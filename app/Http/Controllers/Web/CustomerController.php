<?php

namespace Vanguard\Http\Controllers\Web;
use Vanguard\Customer;
use Vanguard\Http\Controllers\Controller;

use Illuminate\Http\Request;


class CustomerController extends Controller
{

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function customerForm(){
        $customers = Customer::where('companyId', Auth()->user()->companyId)->get();

        return view('invoice.partials.customerForm', compact('customers'));
    }

    public function store(Request $request)
    {
        $customer = new Customer;

        $customer->companyId = Auth()->user()->companyId;
        $customer->firstName = $request->firstName;
        $customer->lastName = $request->lastName;
        $customer->phoneNumber = $request->phoneNumber;
        $customer->email = $request->email;
        $customer->address = $request->address;

        $customer->save();

    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
