<?php

namespace Vanguard\Http\Controllers\Web;
use Vanguard\Estimate;
use Vanguard\Http\Controllers\Controller;

use Illuminate\Http\Request;

class EmailTemplateController extends Controller
{
    public function estimateApproved()
    {
        $estimate = Estimate::find(1);
        $ndp = '';
        return view('templates.approved', compact('estimate'));
    }
}
