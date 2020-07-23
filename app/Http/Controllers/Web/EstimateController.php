<?php

namespace Vanguard\Http\Controllers\Web;
use Vanguard\Customer;
use Vanguard\CustomerVehicle;
use Vanguard\Estimate;
use Vanguard\EstimatePackage;
use Vanguard\EstimateService;
use Vanguard\EstimateVehicle;
use Vanguard\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Vanguard\Package;
use Vanguard\packageItem;
use Vanguard\Services;
use Vanguard\VehicleColor;
use Vanguard\VehicleCondition;
use Vanguard\WorkOrder;

class EstimateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

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

        return redirect()->route('estimate.show', ['id' => $estimate->id]);
    }

    public function addPackage(Request $request, $id){
        $package = Package::find($request->packageId);
        //dd($request->quanity);
        if($request->discountType == 1){
            //PERCENT DISCOUNT//
            $discountPercent = $request->discount / 100;
            $discountTotal = $package->cost * $discountPercent;

            $chargedPrice = $package->cost - $discountTotal * $request->quanity;

        }elseif($request->discountType == 2){
            //CASH DISCOUNT//
            $chargedPrice = $package->cost - $request->discount * $request->quanity;
        }else{
            $chargedPrice = $package->cost * $request->quanity;
        }

        $epackage = new EstimatePackage;

        $epackage->estimateId = $id;
        $epackage->quanity = $request->quanity;
        $epackage->packageId = $request->packageId;
        $epackage->discount = $request->discount;
        $epackage->discountType = $request->discountType;
        $epackage->listPrice = $package->cost;
        $epackage->chargedPrice = $chargedPrice;

        $epackage->save();

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



        return redirect()->route('estimate.show', ['id' => $id]);
    }

    public function estimateMakeWorkOrder ($id)
    {
        $wo = new WorkOrder;
        $wo->companyId = Auth()->user()->companyId;
        $wo->estimateId = $id;
        $wo->status = 1;
        $wo->save();

        $estimate= Estimate::find($id);
        $estimate->status = 4;
        $estimate->save();


        return redirect()->route('estimate.show', ['id' => $id])->with('success', 'You have created a new work order.');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $estimate = Estimate::with('packages', 'packages.package', 'vehicle', 'vehicle.vehicleInfo','vehicle.vehicleInfo.color', 'vehicle.vehicleInfo.condition')->find($id);
        $customer = Customer::find($estimate->customerId);
        $colors = VehicleColor::get();
        $conditions = VehicleCondition::get();

        if (Auth()->user()->companyId != $estimate->companyId) {

          return  view('layouts.403');

        }

        $packages = Package::where('companyId', 0)->orWhere('companyId', Auth()->user()->company_Id)->get();

        $estimateTotal = 0;

        if($estimate->packages){
            foreach($estimate->packages as $package){
                $estimateTotal = $estimateTotal + $package->chargedPrice;
            }
        }

        if($estimate->services){
            foreach($estimate->services as $service){
                $estimateTotal = $estimateTotal + $service->chargedPrice;
            }
        }

        return view('estimate.create', compact('packages', 'customer', 'estimate', 'estimateTotal', 'colors', 'conditions'));
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
}
