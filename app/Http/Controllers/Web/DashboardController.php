<?php

namespace Vanguard\Http\Controllers\Web;

use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;
use Vanguard\Charts\MonthlyIncomeChart;
use Vanguard\Customer;
use Vanguard\Estimate;
use Vanguard\EstimateStatus;
use Vanguard\EstimateTracking;
use Vanguard\Http\Controllers\Api\Auth\AuthController;
use Vanguard\Http\Controllers\Controller;
use Vanguard\Invoice;
use Vanguard\InvoicePayment;
use Vanguard\WorkOrder;
use DB;

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
        ])
            ->where('companyId', Auth()->user()->companyId)
            ->get();

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
        $invoiceChart = InvoicePayment::
            whereBetween('created_at', [$start, $end])
            ->groupBy(DB::raw('monthname(created_at)'))
            ->get([DB::raw('SUM(pmtAmount) as count'),DB::raw('monthname(created_at) as date')])->pluck('date', 'count');

        $chart = new MonthlyIncomeChart();
        $chart->labels($invoiceChart->values())
        ->dataset('Income', 'bar', $invoiceChart->keys())->options(
            [
                'backgroundColor' => '#ff9e27',

            ]);


        return view('dashboard.dashboard', compact('estimates', 'workorders', 'invoices', 'estimateStatus', 'invoiceYTD', 'invoiceTotal', 'invoiceOutstanding', 'leads', 'leadPercent', 'estimate', 'workorder', 'unpaidInvoices','estimateHistory', 'invoiceChart', 'chart'));
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
