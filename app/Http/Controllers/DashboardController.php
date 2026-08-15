<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Invoice;
use App\Models\PosInvoice;
use App\Models\PosInvoiceProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Session\Session;

class DashboardController extends Controller
{
    public function index()
    {
        //POS Invoice Data
        $posInvoices = PosInvoice::all();
        $totalPosInvoice = $posInvoices->count();
        $totalPosSales = $posInvoices->sum('payable');
        $totalPosInvoiceToday = $posInvoices->where('created_at', '>=', today())->count();
        $totalPosSalesToday = $posInvoices->where('created_at', '>=', today())->sum('payable');
        // This week
        $currentWeekTotal = PosInvoice::whereBetween('created_at', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek(),
        ])->count();

        // Last week
        $lastWeekTotal = PosInvoice::whereBetween('created_at', [
            Carbon::now()->subWeek()->startOfWeek(),
            Carbon::now()->subWeek()->endOfWeek(),
        ])->count();

        // Calculate percentage change
        if ($lastWeekTotal > 0) {
            $percentChange = (($currentWeekTotal - $lastWeekTotal) / $lastWeekTotal) * 100;
        } else {
            // If last week is zero, avoid division by zero
            $percentChange = $currentWeekTotal > 0 ? 100 : 0;
        }
        //Total sales
        $currentWeekTotalSales = PosInvoice::whereBetween('created_at', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek(),
        ])->sum('payable');

        // Last week
        $lastWeekTotalSales = PosInvoice::whereBetween('created_at', [
            Carbon::now()->subWeek()->startOfWeek(),
            Carbon::now()->subWeek()->endOfWeek(),
        ])->sum('payable');

        // Calculate percentage change
        if ($lastWeekTotalSales > 0) {
            $percentChangeSales = (($currentWeekTotalSales - $lastWeekTotalSales) / $lastWeekTotalSales) * 100;
        } else {
            // If last week is zero, avoid division by zero
            $percentChangeSales = $currentWeekTotalSales > 0 ? 100 : 0;
        }

        // Today
        $todayTotal = PosInvoice::whereDate('created_at', Carbon::today())->count();

        // Yesterday
        $yesterdayTotal = PosInvoice::whereDate('created_at', Carbon::yesterday())->count();

        // Calculate percentage change
        if ($yesterdayTotal > 0) {
            $yesterdayTotalPercentChange = (($todayTotal - $yesterdayTotal) / $yesterdayTotal) * 100;
        } else {
            // Avoid divide-by-zero
            $yesterdayTotalPercentChange = $todayTotal > 0 ? 100 : 0;
        }
        // Today
        $todayTotalSales = PosInvoice::whereDate('created_at', Carbon::today())->sum('payable');

        // Yesterday
        $yesterdayTotalSales = PosInvoice::whereDate('created_at', Carbon::yesterday())->sum('payable');

        // Calculate percentage change
        if ($yesterdayTotalSales > 0) {
            $yesterdayPercentChange = (($todayTotalSales - $yesterdayTotalSales) / $yesterdayTotalSales) * 100;
        } else {
            // Avoid divide-by-zero
            $yesterdayPercentChange = $todayTotalSales > 0 ? 100 : 0;
        }



        $totalVisitor = DB::table('sessions')->count();


        return view(
            'backend.pages.dashboard',
            compact(
                'totalPosInvoice',
                'totalPosSales',
                'totalPosInvoiceToday',
                'totalPosSalesToday',
                'percentChange',
                'percentChangeSales',
                'yesterdayTotalPercentChange',
                'yesterdayPercentChange',
                'totalVisitor',
                'posInvoices'
            )
        );
    }


    public function dashboardData()
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth   = Carbon::now()->endOfMonth();

        $dailySales = PosInvoice::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(payable) as total_sales')
            )
            ->whereBetween('created_at', [
                $startOfMonth,
                $endOfMonth
            ])
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date', 'asc')
            ->get()
            ->keyBy('date');

        // Number of days in current month
        $daysInMonth = $startOfMonth->daysInMonth;

        $dailySalesData = [];

        for ($day = 1; $day <= $daysInMonth; $day++) {

            $date = $startOfMonth
                ->copy()
                ->day($day)
                ->format('Y-m-d');

            $dailySalesData[] = [
                'date' => $date,
                'day' => $day,
                'total_sales' => isset($dailySales[$date])
                    ? (float) $dailySales[$date]->total_sales
                    : 0
            ];
        }

        return response()->json([
            'dailySalesData' => $dailySalesData,
        ]);
    }

    public function invoiceSelect(Request $request)
    {
        // Today's unread invoices
        $invoices = PosInvoice::where('is_read', 0)
            ->whereDate('created_at', today())
            ->with('user')
            ->get();
        // Prepare a response structure
        $responseData = $invoices->map(function ($invoice) {
            $invoice_id = $invoice->id;

            // Fetch invoice products for the current invoice
            $invoiceProducts = PosInvoiceProduct::where('invoice_id', $invoice_id)
                ->with('product')
                ->get();

            // Calculate total buy price for this invoice
            $totalBuyPrice = PosInvoiceProduct::where('invoice_id', $invoice_id)
                ->join('products', 'pos_invoice_products.product_id', '=', 'products.id')
                ->select(DB::raw('SUM(products.original_price * pos_invoice_products.qty) as total_buy_price'))
                ->value('total_buy_price');

            return [
                'invoice'         => $invoice,
                'invoiceProducts' => $invoiceProducts,
                'totalBuyPrice'   => $totalBuyPrice,
            ];
        });
        return response()->json([
            'data' => $responseData,
        ]);
    }
}
