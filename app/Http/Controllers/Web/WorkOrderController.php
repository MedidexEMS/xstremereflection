<?php

namespace Vanguard\Http\Controllers\Web;
use Vanguard\Customer;
use Vanguard\CustomerVehicle;
use Vanguard\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Vanguard\Invoice;
use Vanguard\Mail\CompletedWorkOrder;
use Vanguard\VehicleColor;
use Vanguard\VehicleCondition;
use Vanguard\WorkOrder;
use Illuminate\Support\Facades\Mail;
use Vanguard\Mail\SendTechEnrouteMailable;

class WorkOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $workorders = WorkOrder::
            where('status', '<', 8)
            ->get();

        return view('workorder.index', compact('workorders'));
    }
    public function canceled()
    {
        $workorders = WorkOrder::
        where('status', 9)
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
        $invoice->detailType = $workorder->estimate->detailType;
        $invoice->dateofService = $workorder->estimate->dateofService;
        $invoice->total = $workorder->totalCharge;
        $invoice->status = 1;
        $invoice->save();

        Mail::to([$workorder->estimate->customer->email, 'jblevins@xtremereflection.app'])->send(new CompletedWorkOrder());

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
}
