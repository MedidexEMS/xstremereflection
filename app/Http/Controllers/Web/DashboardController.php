<?php

namespace Vanguard\Http\Controllers\Web;

use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;
use Vanguard\Estimate;
use Vanguard\Http\Controllers\Controller;
use Vanguard\WorkOrder;

class DashboardController extends Controller
{
    /**
     * Displays the application dashboard.
     *
     * @return Factory|View
     */
    public function index()
    {
        if (session()->has('verified')) {
            session()->flash('success', __('E-Mail verified successfully.'));
        }

        $estimates = Estimate::where('companyId', Auth()->user()->companyId)->get();

        $workorders = WorkOrder::where('companyId', Auth()->user()->companyId)->get();

        return view('dashboard.index', compact('estimates', 'workorders'));
    }
}
