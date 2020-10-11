<?php

namespace Vanguard\Http\Controllers\Web;
use Vanguard\AddOnService;
use Vanguard\Customer;
use Vanguard\CustomerVehicle;
use Vanguard\Estimate;
use Vanguard\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Vanguard\Invoice;
use Vanguard\Mail\CompletedWorkOrder;
use Vanguard\packageItem;
use Vanguard\VehicleColor;
use Vanguard\VehicleCondition;
use Vanguard\WorkOrder;
use Illuminate\Support\Facades\Mail;
use Vanguard\Mail\SendTechEnrouteMailable;
use Vanguard\WorkOrderServices;

class WorkOrderController extends Controller
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
        $workorders = WorkOrder::
            where('status', '<', 8)
            ->where('companyId', Auth()->user()->companyId)
            ->get();

        return view('workorder.index', compact('workorders'));
    }
    public function canceled()
    {
        $workorders = WorkOrder::
        where('status', 9)
            ->where('companyId', Auth()->user()->companyId)
            ->get();

        return view('workorder.index', compact('workorders'));
    }

    public function completedWo()
    {
        $workorders = WorkOrder::
        where('status', 8)
            ->where('companyId', Auth()->user()->companyId)
            ->get();

        return view('workorder.index', compact('workorders'));
    }


    public function completed($id)
    {
        $workorder = WorkOrder::find($id);
        $workorder->status = 8;
        $workorder->save();

        $invoice = new Invoice;

        $invoice->companyId = Auth()->user()->companyId;
        $invoice->customerId = $workorder->estimate->customerId;
        $invoice->estimateId = $workorder->estimate->id;
        $invoice->workOrderId = $workorder->id;
        $invoice->detailType = $workorder->estimate->detailType;
        $invoice->dateofService = $workorder->estimate->dateofService;
        $invoice->total = $workorder->totalCharge;
        $invoice->status = 1;
        $invoice->save();

        $estimate = Estimate::find($workorder->estimate->id);
        $estimate->invoiceId = $invoice->id;
        $estimate->save();

        $wo = WorkOrder::find($id);

        if($wo->estimate->customer->email)
        {
            Mail::to([$workorder->estimate->customer->email, 'jblevins@xtremereflection.app'])->send(new CompletedWorkOrder($wo));

        }else{
            Mail::to(['jblevins@xtremereflection.app'])->send(new CompletedWorkOrder($wo));

        }


        return back()->with('success', 'Work Order Completed, and turned to invoice.');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $workOrder = WorkOrder::find($id);

        $colors = VehicleColor::get();

        $conditions = VehicleCondition::get();

        return view('workorder.show', compact('workOrder', 'colors', 'conditions'));
    }

    public function techEnroute ($id)
    {
        $workOrder = WorkOrder::with('estimate', 'estimate.customer')->find($id);

        //$customer = Customer::where('id', $workOrder->estimate->customerId)->first();

        $workOrder->status = 2;
        $workOrder->save();

        Mail::to([$workOrder->estimate->customer->email,'blevins.josh@gmail.com'])->send(new SendTechEnrouteMailable($workOrder));

        return back()->with('success', 'Notification sent and status updated');
    }

    public function addServices($id)
    {
     $wo = WorkOrder::find($id);
     $estimate = Estimate::find($wo->estimate->id);


        if($wo->estimate->approvedPackage) {
            $array = explode(',', $wo->estimate->acceptedPackage->package->includes);
            $services = packageItem::whereIn('packageId', $array)->orWhere('packageId', $estimate->acceptedPackage->package->id)->get();

            foreach ($services as $service) {
                $estimateService = new WorkOrderServices;
                $estimateService->estimateId = $wo->estimate->id;
                $estimateService->workOrderId = $wo->id;
                $estimateService->qty = 1;
                $estimateService->serviceId = $service->serviceId;
                $estimateService->listPrice = $service->desc->charge;
                $estimateService->chargedPrice = 0;
                $estimateService->status = 1;
                $estimateService->save();
            }

            $addons = AddOnService::where('packageId', $wo->estimate->approvedPackage)->get();


            foreach ($addons as $row) {
                $estimateService = new WorkOrderServices;
                $estimateService->estimateId = $wo->estimate->id;
                $estimateService->workOrderId = $wo->id;
                $estimateService->qty = 1;
                $estimateService->serviceId = $row->serviceId;
                $estimateService->listPrice = $row->service->charge;
                $estimateService->chargedPrice = $row->price;
                $estimateService->status = 1;
                $estimateService->save();
            }
        }

        return back();
    }

    public function serviceComplete($id)
    {
        $service = WorkOrderServices::find($id);
        $service->status = 2;
        $service->save();

        return 'Ok';
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

    public function updateVehicle (Request $request, $id)
    {
        $customerVehicle = CustomerVehicle::find($id);

        $customerVehicle->vin = $request->vin;
        $customerVehicle->year = $request->year;
        $customerVehicle->make = $request->make;
        $customerVehicle->model = $request->model;
        $customerVehicle->trim = $request->trim;
        $customerVehicle->style = $request->style;
        $customerVehicle->color = $request->color;
        $customerVehicle->customerCondition = $request->condition;

        $customerVehicle->save();
    }

    public function completeOrder($id)
    {
        $workorder = WorkOrder::find($id);
        $workorder->status = 8;
        $workorder->save();

        $invoice = new Invoice;

        $invoice->companyId = Auth()->user()->companyId;
        $invoice->customerId = $workorder->estimate->customerId;
        $invoice->detailType = $workorder->estimate->detailType;
        $invoice->dateofService = $workorder->estimate->dateofService;
        $invoice->total = $workorder->totalCharge;
        $invoice->status = 1;
        $invoice->save();

        return back()->with('success', 'Work Order Completed, and turned to invoice.');
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

    public function updateModal ($id)
    {
        $workOrder = WorkOrder::find($id);

        return view('dashboard.partials.modalUpdateWorkOrderBody', compact('workOrder'));
       // return 'Getting a response';
    }
}
