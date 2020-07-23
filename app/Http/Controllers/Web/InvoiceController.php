<?php

namespace Vanguard\Http\Controllers\Web;
use Vanguard\Estimate;
use Vanguard\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Vanguard\Invoice;
use Vanguard\InvoicePackage;
use Vanguard\InvoiceService;
use Vanguard\Package;

use DB;

class InvoiceController extends Controller
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

    }

    public function estimateConvert ($id)
    {
        $estimate = Estimate::findOrFail($id);



                $newInvoice = Invoice::create([
                    'companyId' => Auth()->user()->companyId,
                    'customerId' => $estimate->customerId,
                    'detailType' => $estimate->detailType,
                    'serviceAddress' => $estimate->serviceAddress,
                    'arrivalTime' => $estimate->arrivalTime,
                    'dateofService' => $estimate->dateofService,
                    'status' => 1

                ]);

                foreach ($estimate->packages as $package)
                {
                    $ip = InvoicePackage::create([
                        'invoiceId' => $newInvoice->id,
                        'packageId' => $package->packageId,
                        'qty' => $package->quanity,
                        'discount' => $package->discount,
                        'discountType' => $package->discountType,
                        'total' => $package->chargedPrice
                    ]);
                }

                foreach ($estimate->services as $service)
                {
                    $ip = InvoiceService::create([
                        'invoiceId' => $newInvoice->id,
                        'serviceId' => $service->serviceId,
                        'qty' => $service->quanity,
                        'discount' => $service->discount,
                        'discountType' => $service->discountType,
                        'total' => $service->chargedPrice
                    ]);
                }

        }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($cid)
    {
        $customer = Customer::find($cid);
        $packages = Package::where('companyId', 0)->orWhere('companyId', Auth()->user()->company_Id)->get();
        return view('invoice.create', compact('packages', 'customer'));
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
        //
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
