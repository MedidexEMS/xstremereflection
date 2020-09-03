<?php

namespace Vanguard\Http\Controllers\Web;
use Vanguard\Estimate;
use Vanguard\EstimatePackage;
use Vanguard\Http\Controllers\Controller;
use Vanguard\Package;

use Illuminate\Http\Request;
use Vanguard\packageItem;
use Vanguard\Services;


class PackageController extends Controller
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
        $packages = Package::where('companyId', auth()->user()->companyId)->orWhere('companyId', 0)->get();
        $estimates = EstimatePackage::where('approved', 1)->where('companyId', Auth()->user()->companyId)->get();

        return view('packages.index', compact('packages', 'estimates'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $services   = Services::where('company_id', auth()->user()->companyId)->orWhere('company_id', 0)->get();
        return view('packages.create', compact('services'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $package = new Package;

        $package->companyId = auth()->user()->companyId;
        $package->description = $request->description;
        $package->cost = $request->cost;
        $package->save();

        //dd($request->package_items);

        foreach($request->package_items as $item)
        {
            $pi = new packageItem;

            $pi->packageId = $package->id;
            $pi->serviceId = $item;
            $pi->save();
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $package = Package::find($id);
        $array = explode(',', $package->includes);
        $upsaleArray = explode(',', $package->upsale);
        $upsale = Services::whereIn('id', $upsaleArray)->get();
        $packages = Package::whereIn('id', $array)->get();
        $packageServices = packageItem::whereIn('packageId', $array)->get();
        $availableServices = Services::where('company_id', Auth()->user()->companyId)->orWhere('company_id', 0)->get();


        return view('packages.show', compact('package', 'packages', 'packageServices', 'upsale', 'availableServices'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $package = Package::with('items')->find($id);
        $services   = Services::where('company_id', auth()->user()->companyId)->orWhere('company_id', 0)->get();

        return view('packages.edit', compact('package', 'services'));
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
        $package = Package::find($id);

        $package->companyId = auth()->user()->companyId;
        $package->description = $request->description;
        $package->cost = $request->cost;
        $package->save();

        //dd($request->package_items);

        foreach($request->package_items as $item)
        {
            $pi = new packageItem;

            $pi->packageId = $package->id;
            $pi->serviceId = $item;
            $pi->save();
        }
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
