<?php

namespace Vanguard\Http\Controllers\Web;
use Notification;
use Carbon\Carbon;
use Vanguard\AddOnService;
use Vanguard\Customer;
use Vanguard\CustomerVehicle;
use Vanguard\Estimate;
use Vanguard\EstimatePackage;
use Vanguard\EstimateService;
use Vanguard\EstimateTracking;
use Vanguard\EstimateVehicle;
use Vanguard\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Vanguard\Invoice;
use Vanguard\Mail\EstimateMailable;
use Vanguard\Mail\AcceptedEstimateEmail;
use Vanguard\Mail\RescheduleReminder;
use Vanguard\Package;
use Vanguard\packageItem;
use Vanguard\Services;
use Vanguard\VehicleColor;
use Vanguard\VehicleCondition;
use Vanguard\WorkOrder;
USE Vanguard\WorkOrderServices;
use Vanguard\WorkOrderTracking;
use PDF;
use Vanguard\Notifications\EstimateApproved;
use Vanguard\User;



use function GuzzleHttp\Psr7\_parse_request_uri;

class EstimateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth',['except' => ['customerReview', 'uploadSignature']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $estimates = Estimate::with('workorder')
            ->where('companyID', Auth()->user()->companyId)
            ->where('status', '!=', 4)
            ->where('status', '!=', 6)
            ->orderBy('dateofService', 'desc')->get();

        return view('estimate.index', compact('estimates'));
    }

    public function uploadSignature(Request $request, $pid, $eid)
    {
        $folderPath = public_path('customerSignature/');

        $image_parts = explode(";base64,", $request->signed);

        $image_type_aux = explode("image/", $image_parts[0]);

        $image_type = $image_type_aux[1];

        $image_base64 = base64_decode($image_parts[1]);

        $fileName = uniqid(). '.'.$image_type;

        $file = $folderPath . $fileName;

        file_put_contents($file, $image_base64);

        $package = EstimatePackage::find($pid);

        $estimate = Estimate::find($eid);

        $customer = Customer::find($estimate->customerId);

        $estimate->approvedPackage = $pid;
        $estimate->signature = '/customerSignature/'.$fileName;
        $estimate->signed = Carbon::now();
        $estimate->total = $package->chargedPrice;
        $estimate->deposit = $package->deposit;

        $estimate->save();


        $workorder = new WorkOrder;
        $workorder->companyId = Auth()->user()->companyId;
        $workorder->estimateId = $estimate->id;
        $workorder->totalCharge = $estimate->total;
        $workorder->status = 1;
        $workorder->save();

        $tracking = new EstimateTracking;
        $tracking->estimateId = $eid;
        $tracking->note = 'Estimate approved by customer and work order created.';
        $tracking->save();

        $wtracking = new WorkOrderTracking;
        $wtracking->workOrderId = $workorder->id;
        $wtracking->note = 'Estimate approved by customer and work order created.';
        $wtracking->save();

        if($estimate->approvedPackage){
            $array = explode(',', $estimate->approvedPackage->package->includes);
            $services = packageItem::whereIn('packageId', $array)->get();

            foreach($services as $service){
                $estimateService = new WorkOrderServices;
                $estimateService->estimateId = $estimate->id;
                $estimateService->workOrderId = $workorder->id;
                $estimateService->qty = 1;
                $estimateService->serviceId = $service->serviceId;
                $estimateService->listPrice = $service->listPrice;
                $estimateService->chargedPrice = 0;
                $estimateService->status = 1;
                $estimateService->save();
            }
            $addons = AddOnService::where('packageId', $estimate->approvedPackage)->get();

            foreach($addons as $row)
            {
                $estimateService = new WorkOrderServices;
                $estimateService->estimateId = $estimate->id;
                $estimateService->workOrderId = $workorder->id;
                $estimateService->qty = 1;
                $estimateService->serviceId = $row->serviceId;
                $estimateService->listPrice = $row->listPrice;
                $estimateService->chargedPrice = $row->chargedPrice;
                $estimateService->status = 1;
                $estimateService->save();
            }
        }

        $invoice = new Invoice;

        $invoice->companyId = Auth()->user()->companyId;
        $invoice->customerId = $workorder->estimate->customerId;
        $invoice->estimateId = $workorder->estimate->id;
        $invoice->workOrderId = $workorder->id;
        $invoice->detailType = $workorder->estimate->detailType;
        $invoice->dateofService = $workorder->estimate->dateofService;
        $invoice->total = $workorder->totalCharge;
        $invoice->deposit = $estimate->deposit;
        $invoice->status = 1;
        $invoice->save();

        if($estimate->customer->email){
            Mail::to([$estimate->customer->email, 'jblevins@xtremereflection.app'])->send(new AcceptedEstimateEmail($estimate));
            $userSchema = User::where('companyId', $estimate->companyId);

            if(Mail::failures()){
                $tracking = new EstimateTracking;
                $tracking->estimateId = $estimate->id;
                $tracking->note = 'Customer approved and signed email was not sent.';
                $tracking->save();

            }else{
                $tracking = new EstimateTracking;
                $tracking->estimateId = $estimate->id;
                $tracking->note = 'You have successfully accepted the package and signed your estimate we attempted to email you a copy, unfortunately the email did not go through. One of our representative will contact you shortly..';
                $tracking->save();

            }
        }

        if($invoice->deposit > 0){
            $amount = $invoice->deposit * 100;
            $paymentDescription = 'Detail Deposit';
            return view('estimate.payment', compact('invoice', 'amount', 'customer', 'paymentDescription'))->with('success', 'You have successfully accepted the package and signed your estimate a copy will be emailed to you. One of our representative will contact you shortly.');
        }else{
            return back()->with('success', 'You have successfully accepted the package and our representative will contact you shortly.');

        }

    }

    public function approved()
    {
        $estimates = Estimate::with('workorder')
            ->where('companyID', Auth()->user()->companyId)
            ->where('status',  4)
            ->orderBy('dateofService', 'desc')->get();

        return view('estimate.index', compact('estimates'));
    }

    public function canceled()
    {
        $estimates = Estimate::with('workorder')
            ->where('companyID', Auth()->user()->companyId)
            ->where('status',  6)
            ->orderBy('dateofService', 'desc')->get();

        return view('estimate.index', compact('estimates'));
    }

    public function estimateEmail ($id)
    {
        $estimate = Estimate::with('customer', 'services', 'packages')->find($id);

        Mail::to([$estimate->customer->email, 'jblevins@xtremereflection.app'])->send(new EstimateMailable($estimate));

        if(Mail::failures()){
            $tracking = new EstimateTracking;
            $tracking->estimateId = $estimate->id;
            $tracking->note = 'Estimate email failed to send.';
            $tracking->save();
            return back()->with('error', 'The mail was not sent to the customer.');
        }else{
            $tracking = new EstimateTracking;
            $tracking->estimateId = $estimate->id;
            $tracking->note = 'Estimate emailed to the customer.';
            $tracking->save();

            return back()->with('success', 'Email has been sent.');
        }

    }

    public function upsalePdf($id)
    {
        $estimate = Estimate::find($id);
        $customer = $estimate->customer;

        view()->share('customer',$customer);
        view()->share('estimate',$estimate);


        $pdf = PDF::loadView('estimate.pdf.upsale')->setPaper('a4', 'landscape');;

        return $pdf->stream('estimate_'.$estimate->id.'.pdf');

        //return view('estimate.pdf.upsale', compact('estimate', 'customer'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->dateofService);
        $serviceDate = date("Y-m-d", strtotime($request->dateofService));
        if($request->customer == 0){
            $validatedData = $request->validate([
                'email' => 'required_without_all:phoneNumber|sometimes:customers|max:255',
                'phoneNumber' => 'required_without_all:email|sometimes:customers|max:255',
            ]);
            $customer = new Customer;

            $customer->companyId = Auth()->user()->companyId;
            $customer->firstName = $request->firstName;
            $customer->lastName = $request->lastName;
            $customer->phoneNumber = $request->phoneNumber;
            $customer->email = $request->email;
            $customer->address = $request->address;

            $customer->save();
        }else {
            $customer = Customer::find($request->customer);
        }

        $estimate = new Estimate;
        $estimate->companyId = Auth()->user()->companyId;
        $estimate->detailType = $request->detailType;
        $estimate->customerId = $customer->id;
        $estimate->status = 1;
        $estimate->dateofService = $serviceDate;
        $estimate->arrivalTime = $request->arrivalTime;
        $estimate->save();

        $tracking = new EstimateTracking;
        $tracking->estimateId = $estimate->id;
        $tracking->note = 'Estimate created.';
        $tracking->save();

        return redirect()->route('estimate.show', ['id' => $estimate->id]);
    }

    public function addPackage(Request $request, $id){
        $package = Package::find($request->packageId);
        //dd($request->quanity);
        if($request->discountType == 1){
            //PERCENT DISCOUNT//
            $discountPercent = $request->discount / 100;
            $discountTotal = $package->cost * $discountPercent;

            $chargedPrice = $package->cost - $discountTotal;

        }elseif($request->discountType == 2){
            //CASH DISCOUNT//
            $chargedPrice = $package->cost - $request->discount;
        }else{
            $chargedPrice = $package->cost ;
        }

        //dd($chargedPrice);

        $epackage = new EstimatePackage;

        $epackage->estimateId = $id;
        $epackage->companyId = Auth()->user()->companyId;
        $epackage->quanity = $request->quanity;
        $epackage->packageId = $request->packageId;
        $epackage->discount = $request->discount;
        $epackage->discountType = $request->discountType;
        $epackage->listPrice = $package->cost;
        $epackage->deposit  = $request->deposit;
        $epackage->chargedPrice = $chargedPrice;

        $epackage->save();
        /*
        if($package->includes){
            $array = explode(',', $package->includes);
            foreach ($array as $include)
            {
                $services = packageItem::where('packageId', $include)->get();
                foreach ($services as $service){
                    $s = Services::find($service->serviceId);

                    $estimateService = new EstimateService;
                    $estimateService->estimateId = $id;
                    $estimateService->quanity = 1;
                    $estimateService->serviceId = $s->id;
                    $estimateService->listPrice = $s->charge;
                    $estimateService->chargedPrice = 0;
                    $estimateService->status = 1;
                    $estimateService->save();
                }

                $services = packageItem::where('packageId', $package->id)->get();
                foreach ($services as $service){
                    $s = Services::find($service->serviceId);

                    $estimateService = new EstimateService;
                    $estimateService->estimateId = $id;
                    $estimateService->quanity = 1;
                    $estimateService->serviceId = $s->id;
                    $estimateService->listPrice = $s->charge;
                    $estimateService->chargedPrice = 0;
                    $estimateService->status = 1;
                    $estimateService->save();
                }
            }
        }else{
            $services = packageItem::where('packageId', $package->id)->get();
            foreach ($services as $service){
                $s = Services::find($service->serviceId);

                $estimateService = new EstimateService;
                $estimateService->estimateId = $id;
                $estimateService->quanity = 1;
                $estimateService->serviceId = $s->id;
                $estimateService->listPrice = $s->charge;
                $estimateService->chargedPrice = 0;
                $estimateService->status = 1;
                $estimateService->save();
            }

        }
        */



        return redirect()->route('estimate.show', ['id' => $id]);
    }

    public function estimateCancel ($id)
    {
        $estimate = Estimate::find($id);
        $estimate->status = 6;
        $estimate->save();

        $etracking = new EstimateTracking;
        $etracking->estimateId = $id;
        $etracking->status = 6;
        $etracking->note = "Customer canceled the estimate / work Order";
        $etracking->save();

        $workOrder = WorkOrder::where('estimateId', $id)->first();

        if($workOrder){
            $workOrder->status = 9;
            $workOrder->save();

            $wtracking = new EstimateTracking;
            $wtracking->estimateId = $id;
            $wtracking->status = 6;
            $wtracking->note = "Customer canceled the estimate / work Order";
            $wtracking->save();
        }

        return back()->withErrors('Customer Canceled Job');

    }

    public function updateDate(Request $request, $id)
    {
        $estimate = Estimate::find($id);

        $estimate->dateofService = $request->dateofService;
        $estimate->arrivalTime = $request->arrivalTime;
        $estimate->Save();

        $estimateStatus = new EstimateTracking;
        $estimateStatus->estimateId = $id;
        $estimateStatus->status = 4;
        $estimateStatus->note = 'Rescheduled and sent to work order.';
        $estimateStatus->save();

        $wo = WorkOrder::where('estimateId', $id)->first();

        if($wo){
            $wo->status = 1;
            $wo->save();

            $workOrderStatus = new WorkOrderTracking;
            $workOrderStatus->workOrderId = $wo->id;
            $workOrderStatus->status = 1;
            $workOrderStatus->note = "Work order has been rescheduled.";
            $workOrderStatus->save();
        }

    }

    public function rescheduleEmail($id)
    {
        $estimate = Estimate::find($id);

        Mail::to([$estimate->customer->email, 'jblevins@xtremereflection.app'])->send(new RescheduleReminder($estimate));

        if (Mail::failures()) {
            return back()->with('error', 'Mail was not delivered.');
        }else{
            return back()->with('success', 'Reminder mail was sent..');
            $tracking = new EstimateTracking;
            $tracking->estimateId = $id;
            $tracking->note = 'Reminder Email Sent.';
            $tracking->save();
        }
    }

    public function estimateMakeWorkOrder ($id)
    {
        $estimate= Estimate::find($id);
        $estimate->status = 4;
        $estimate->save();

        $wo = new WorkOrder;
        $wo->companyId = Auth()->user()->companyId;
        $wo->estimateId = $id;
        $wo->totalCharge = $estimate->total;
        $wo->status = 1;
        $wo->save();

        $tracking = new EstimateTracking;
        $tracking->estimateId = $id;
        $tracking->note = 'Estimate approved and work order created.';
        $tracking->save();

        $wtracking = new WorkOrderTracking;
        $wtracking->workOrderId = $wo->id;
        $wtracking->note = 'Estimate approved and work order created.';
        $wtracking->save();

        if($estimate->services){
            foreach($estimate->services as $service){
                $estimateService = new WorkOrderServices;
                $estimateService->estimateId = $estimate->id;
                $estimateService->workOrderId = $wo->id;
                $estimateService->qty = 1;
                $estimateService->serviceId = $service->serviceId;
                $estimateService->listPrice = $service->listPrice;
                $estimateService->chargedPrice = 0;
                $estimateService->status = 1;
                $estimateService->save();
            }
        }


        return redirect()->route('estimate.show', ['id' => $id])->with('success', 'You have created a new work order.');
    }

    public function addPackageService (Request $request, $id)
    {
        $package = EstimatePackage::find($id);

        if($request->serviceId == 0){

            if($request->discountType == 1){
                //PERCENT DISCOUNT//
                $discountPercent = $request->discount / 100;
                $discountTotal = $request->price * $discountPercent;

                $chargedPrice = $request->price - $discountTotal;

            }elseif($request->discountType == 2){
                //CASH DISCOUNT//
                $chargedPrice = $request->price - $request->discount;
            }else{
                $chargedPrice = $request->price ;
            }


            $addService = new AddOnService();
            $addService->packageId = $id;
            $addService->serviceid = $request->serviceId;
            $addService->price = $chargedPrice;
            $addService->show = $request->show;

            $addService->save();

        }else{
            $service = Services::find($request->serviceId);


            if($request->discountType == 1){
                //PERCENT DISCOUNT//
                $discountPercent = $request->discount / 100;
                $discountTotal = $service->charge * $discountPercent;

                $chargedPrice = $service->charge - $discountTotal;

            }elseif($request->discountType == 2){
                //CASH DISCOUNT//
                $chargedPrice = $service->charge - $request->discount;
            }else{
                $chargedPrice = $service->charge ;
            }


            $addService = new AddOnService();
            $addService->packageId = $id;
            $addService->serviceid = $request->serviceId;
            $addService->price = $chargedPrice;
            $addService->show = $request->show;

            $addService->save();
        }

        $newPackagePrice = $package->chargedPrice + $chargedPrice;
        $newListPrice = $package->listPrice + $service->charge;

        $package->chargedPrice = $newPackagePrice;
        $package->listPrice = $newListPrice;
        $package->save();

        return back()->with('success', 'Added new service to package.');
    }

    public function pdf($id)
    {
        $estimate = Estimate::with('packages', 'packages.package', 'vehicle', 'vehicle.vehicleInfo', 'vehicle.vehicleInfo.colorInfo', 'vehicle.vehicleInfo.condition')->find($id);
        $customer = Customer::find($estimate->customerId);



        $estimateTotal = 0;
        $downPmt = 0;
        if ($estimate->approvedPackage){
            if ($estimate->packages) {
                foreach ($estimate->packages as $package) {
                    $estimateTotal = $estimateTotal + $package->chargedPrice;
                }
            }

            if ($estimate->services) {
                foreach ($estimate->services as $service) {
                    $estimateTotal = $estimateTotal + $service->chargedPrice;
                }
                foreach ($estimate->services->where('requiresDownPayment', 1) as $service) {
                    $downPmt = $downPmt + $service->chargedPrice;
                }
            }

            $estimate->total = $estimateTotal;
            $estimate->deposit = $downPmt;
            $estimate->save();
        }

        view()->share('customer',$customer);
        view()->share('estimate',$estimate);


        $pdf = PDF::loadView('estimate.pdf.estimate');

        return $pdf->stream('estimate.pdf');

        //return view('estimate.pdf.estimate', compact('customer', 'estimate', 'estimateTotal', 'colors', 'conditions'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $estimate = Estimate::with('packages', 'packages.package', 'vehicle', 'vehicle.vehicleInfo', 'vehicle.vehicleInfo.colorInfo', 'vehicle.vehicleInfo.condition')->find($id);
        $customer = Customer::find($estimate->customerId);
        $colors = VehicleColor::get();
        $conditions = VehicleCondition::get();

        if (Auth()->user()->companyId != $estimate->companyId) {

            return view('layouts.403');

        }

        $packages = Package::where('companyId', 0)->orWhere('companyId', Auth()->user()->companyId)->get();


        $estimateTotal = 0;
        $downPmt = 0;
        if ($estimate->approvedPackage){
            if ($estimate->packages) {
                foreach ($estimate->packages as $package) {
                    $estimateTotal = $estimateTotal + $package->chargedPrice;
                }
            }

        if ($estimate->services) {
            foreach ($estimate->services as $service) {
                $estimateTotal = $estimateTotal + $service->chargedPrice;
            }
            foreach ($estimate->services->where('requiresDownPayment', 1) as $service) {
                $downPmt = $downPmt + $service->chargedPrice;
            }
        }

        $estimate->save();
    }
        $services = Services::where('company_id', 0)->orWhere('company_id', Auth()->user()->companyId)->get();



        return view('estimate.create', compact('packages', 'customer', 'estimate', 'estimateTotal', 'colors', 'conditions', 'services'));
    }

    public function customerReview($id)
    {
        $estimate = Estimate::with('packages', 'packages.package', 'vehicle', 'vehicle.vehicleInfo', 'vehicle.vehicleInfo.colorInfo', 'vehicle.vehicleInfo.condition')->find($id);


        return view('estimate.customerReview', compact('estimate'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function destroyPackage ($id)
    {
        $package = EstimatePackage::find($id);
            $package->addOnService()->delete();
            $package->delete();


        return back()->with('success', 'Package removed from estimate.');

    }

    public function addVehicle (Request $request, $cid, $eid)
    {
        //dd($eid);
        if($request->vehicleId == 0){
            $customerVehicle = new CustomerVehicle;

            $customerVehicle->customerId = $cid;
            $customerVehicle->vin = $request->vin;
            $customerVehicle->year = $request->year;
            $customerVehicle->make = $request->make;
            $customerVehicle->model = $request->model;
            $customerVehicle->trim = $request->trim;
            $customerVehicle->style = $request->style;
            $customerVehicle->color = $request->color;
            $customerVehicle->customerCondition = $request->condition;
            $customerVehicle->save();

            $estimateVehicle = new EstimateVehicle;
            $estimateVehicle->estimateId = $eid;
            $estimateVehicle->customerVehicleId = $customerVehicle->id;
            $estimateVehicle->save();

            return back();

        }else{
            $estimateVehicle = new EstimateVehicle;
            $estimateVehicle->estimateId = $eid;
            $estimateVehicle->customerVehicleId = $request->vehicleId;
            $estimateVehicle->save();

            return back();
        }
    }

    public function estimateRescheduleModal ($id)
    {
        $estimate = Estimate::find($id);

        return view('dashboard.partials.modalUpdateEstimateBody', compact('estimate'));
    }

    public function voidEstimate($id)
    {
        $estimate = Estimate::find($id);
        $estimate->status = 8;
        $estimate->save();

        return back()->with('error', 'Estimate Voided.' );
    }
}
