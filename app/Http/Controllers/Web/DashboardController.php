<?php

namespace Vanguard\Http\Controllers\Web;

use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;
use Vanguard\Customer;
use Vanguard\Estimate;
use Vanguard\EstimateStatus;
use Vanguard\EstimateTracking;
use Vanguard\Http\Controllers\Controller;
use Vanguard\Invoice;
use Vanguard\InvoicePayment;
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

        $estimates = Estimate::where('companyId', Auth()->user()->companyId)->orderBy('status')->get();

        $workorders = WorkOrder::where('companyId', Auth()->user()->companyId)->get();

        $invoices = Customer::where('companyId', Auth()->user()->companyId)->whereHas('invoice', function($q){$q->where('status', '<=', 2);})->get() ;

        $invoiceYTD = Invoice::whereBetween('created_at', [
            Carbon::now()->startOfYear(),
            Carbon::now()->endOfYear(),
        ])->get();

        $invoiceTotal = $invoiceYTD->sum('total');
        $invoiceOutstanding =  $invoiceTotal - $invoiceYTD->sum('totalPaid');
        $leads = count($estimates->where('status', 0));
        $leadPercent = ($leads ?? 0) / 10 * 100;
        $estimate = count($estimates->where('status', 1));
        $workorder = count($workorders->where('status', '<', 8));
        $unpaidInvoices = count($invoiceYTD->where('status', 1));

        $estimateHistory = EstimateTracking::orderBy('created_at', 'desc')->take('10')->get();


        $estimateStatus = EstimateStatus::get();
        $start = Carbon::now()->startOfYear();
        $end = Carbon::now()->endOfYear();
        $users_created = InvoicePayment::
            whereBetween('created_at', [$start, $end])
            ->groupBy(DB::raw('MONTH(users.created_at)'))
            ->get([DB::raw('COUNT(*) as count'),DB::raw('DATE(users.created_at) as date')]);

        dd($users_created);

        return view('dashboard.dashboard', compact('estimates', 'workorders', 'invoices', 'estimateStatus', 'invoiceYTD', 'invoiceTotal', 'invoiceOutstanding', 'leads', 'leadPercent', 'estimate', 'workorder', 'unpaidInvoices','estimateHistory'));
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
