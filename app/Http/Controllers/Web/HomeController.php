<?php

namespace Vanguard\Http\Controllers\Web;


use Illuminate\View\View;
use Vanguard\Http\Controllers\Controller;
use Vanguard\Package;
use Vanguard\Services;

class HomeController extends Controller
{
    public function index ()
    {
        $packages = Package::with('items')->where('companyId', 1)->where('status', 1)->get();

        $services = Services::get();

        return view('home.index', compact('packages'));
    }
}
