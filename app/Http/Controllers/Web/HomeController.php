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
        $packages = Package::
        with('items', 'items.desc', 'items.desc.type')
            ->where('mainPage', 1)
            ->where('companyId', 0)
            ->where('status', 1)->get();

        $services = Services::get();

        $domain = request()->getHost();

        dd($domain);

        return view('home.index', compact('packages'));
    }
}
