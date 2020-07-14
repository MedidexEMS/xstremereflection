<?php

namespace Vanguard\Http\Controllers\Web;
use Vanguard\Customer;
use Vanguard\Estimate;
use Vanguard\EstimatePackage;
use Vanguard\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Vanguard\Package;

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

        if($request->customer == 0){
            $validatedData = $request->validate([
                'email' => 'required|unique:customers|max:255',

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
        $estimate->customerId = $customer->id;
        $estimate->status = 1;
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

        return redirect()->route('estimate.show', ['id' => $id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $estimate = Estimate::with('packages', 'packages.package')->find($id);
        $customer = Customer::find($estimate->customerId);

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

        return view('estimate.create', compact('packages', 'customer', 'estimate', 'estimateTotal'));
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
}
