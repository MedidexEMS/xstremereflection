<?php

namespace Vanguard\Http\Controllers\Web;

use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;
use Vanguard\Customer;
use Vanguard\Estimate;
use Vanguard\EstimateStatus;
use Vanguard\Http\Controllers\Controller;
use Vanguard\Invoice;
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

        $invoices = Customer::where('companyId', Auth()->user()->companyId)->whereHas('invoice', function($q){$q->where('status', '<=', 2);})->get() ;

        $invoiceYTD = Invoice::whereBetween('created_at', [
            Carbon::now()->startOfYear(),
            Carbon::now()->endOfYear(),
        ])->get();

        $estimateStatus = EstimateStatus::get();

        return view('dashboard.dashboard', compact('estimates', 'workorders', 'invoices', 'estimateStatus', 'invoiceYTD'));
    }

    public function manage()
    {
        if (session()->has('verified')) {
            session()->flash('success', __('E-Mail verified successfully.'));
        }

        $estimates = Estimate::where('companyId', Auth()->user()->companyId)->get();

        $workorders = WorkOrder::where('companyId', Auth()->user()->companyId)->get();

        $invoices = Customer::where('companyId', Auth()->user()->companyId)->whereHas('invoice', function($q){$q->where('status', '<=', 2);})->get() ;

        $invoiceYTD = Invoice::whereBetween('created_at', [
            Carbon::now()->startOfYear(),
            Carbon::now()->endOfYear(),
        ])->get();

        $estimateStatus = EstimateStatus::get();

        return view('dashboard.index', compact('estimates', 'workorders', 'invoices', 'estimateStatus', 'invoiceYTD'));
    }

}
