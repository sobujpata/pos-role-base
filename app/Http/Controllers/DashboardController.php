<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Invoice;
use App\Models\PosInvoice;
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
        $totalPosSales = $posInvoices->sum( 'payable');
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
        ])->sum( 'payable');

        // Last week
        $lastWeekTotalSales = PosInvoice::whereBetween('created_at', [
            Carbon::now()->subWeek()->startOfWeek(),
            Carbon::now()->subWeek()->endOfWeek(),
        ])->sum( 'payable');

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


        return view('backend.pages.dashboard', 
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
            ));
    }
}
