<?php

namespace Vanguard\Http\Controllers\Web;

use Illuminate\View\View;
use Vanguard\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index ()
    {
        return view('home.index');
    }
}
