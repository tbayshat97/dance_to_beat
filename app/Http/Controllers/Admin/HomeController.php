<?php

namespace App\Http\Controllers\Admin;

use App\Enums\TransactionStatus;
use App\Http\Controllers\Controller;
use App\Models\Artist;
use App\Models\Course;
use App\Models\Customer;
use App\Models\CustomerTransaction;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function dashboard(Request $request)
    {
        $ordersCount = Order::count();
        $clientsCount = Customer::count();
        $coursesCount = Course::count();
        $artistsCount = Artist::count();

        $thisYear = Carbon::now()->format('Y');
        $lastYear = Carbon::now()->subWeeks(52)->format('Y');

        $thisYear_month_01 = CustomerTransaction::where('status', TransactionStatus::Success)->whereYear('created_at', $thisYear)->whereMonth('created_at', 1)->sum('total_cost');
        $thisYear_month_02 = CustomerTransaction::where('status', TransactionStatus::Success)->whereYear('created_at', $thisYear)->whereMonth('created_at', 2)->sum('total_cost');
        $thisYear_month_03 = CustomerTransaction::where('status', TransactionStatus::Success)->whereYear('created_at', $thisYear)->whereMonth('created_at', 3)->sum('total_cost');
        $thisYear_month_04 = CustomerTransaction::where('status', TransactionStatus::Success)->whereYear('created_at', $thisYear)->whereMonth('created_at', 4)->sum('total_cost');
        $thisYear_month_05 = CustomerTransaction::where('status', TransactionStatus::Success)->whereYear('created_at', $thisYear)->whereMonth('created_at', 5)->sum('total_cost');
        $thisYear_month_06 = CustomerTransaction::where('status', TransactionStatus::Success)->whereYear('created_at', $thisYear)->whereMonth('created_at', 6)->sum('total_cost');
        $thisYear_month_07 = CustomerTransaction::where('status', TransactionStatus::Success)->whereYear('created_at', $thisYear)->whereMonth('created_at', 7)->sum('total_cost');
        $thisYear_month_08 = CustomerTransaction::where('status', TransactionStatus::Success)->whereYear('created_at', $thisYear)->whereMonth('created_at', 8)->sum('total_cost');
        $thisYear_month_09 = CustomerTransaction::where('status', TransactionStatus::Success)->whereYear('created_at', $thisYear)->whereMonth('created_at', 9)->sum('total_cost');
        $thisYear_month_10 = CustomerTransaction::where('status', TransactionStatus::Success)->whereYear('created_at', $thisYear)->whereMonth('created_at', 10)->sum('total_cost');
        $thisYear_month_11 = CustomerTransaction::where('status', TransactionStatus::Success)->whereYear('created_at', $thisYear)->whereMonth('created_at', 11)->sum('total_cost');
        $thisYear_month_12 = CustomerTransaction::where('status', TransactionStatus::Success)->whereYear('created_at', $thisYear)->whereMonth('created_at', 12)->sum('total_cost');

        $thisYearRevenueData = [
            '01' => floatval($thisYear_month_01),
            '02' => floatval($thisYear_month_02),
            '03' => floatval($thisYear_month_03),
            '04' => floatval($thisYear_month_04),
            '05' => floatval($thisYear_month_05),
            '06' => floatval($thisYear_month_06),
            '07' => floatval($thisYear_month_07),
            '08' => floatval($thisYear_month_08),
            '09' => floatval($thisYear_month_09),
            '10' => floatval($thisYear_month_10),
            '11' => floatval($thisYear_month_11),
            '12' => floatval($thisYear_month_12)
        ];

        $lastYear_month_01 = CustomerTransaction::where('status', TransactionStatus::Success)->whereYear('created_at', $lastYear)->whereMonth('created_at', 1)->sum('total_cost');
        $lastYear_month_02 = CustomerTransaction::where('status', TransactionStatus::Success)->whereYear('created_at', $lastYear)->whereMonth('created_at', 2)->sum('total_cost');
        $lastYear_month_03 = CustomerTransaction::where('status', TransactionStatus::Success)->whereYear('created_at', $lastYear)->whereMonth('created_at', 3)->sum('total_cost');
        $lastYear_month_04 = CustomerTransaction::where('status', TransactionStatus::Success)->whereYear('created_at', $lastYear)->whereMonth('created_at', 4)->sum('total_cost');
        $lastYear_month_05 = CustomerTransaction::where('status', TransactionStatus::Success)->whereYear('created_at', $lastYear)->whereMonth('created_at', 5)->sum('total_cost');
        $lastYear_month_06 = CustomerTransaction::where('status', TransactionStatus::Success)->whereYear('created_at', $lastYear)->whereMonth('created_at', 6)->sum('total_cost');
        $lastYear_month_07 = CustomerTransaction::where('status', TransactionStatus::Success)->whereYear('created_at', $lastYear)->whereMonth('created_at', 7)->sum('total_cost');
        $lastYear_month_08 = CustomerTransaction::where('status', TransactionStatus::Success)->whereYear('created_at', $lastYear)->whereMonth('created_at', 8)->sum('total_cost');
        $lastYear_month_09 = CustomerTransaction::where('status', TransactionStatus::Success)->whereYear('created_at', $lastYear)->whereMonth('created_at', 9)->sum('total_cost');
        $lastYear_month_10 = CustomerTransaction::where('status', TransactionStatus::Success)->whereYear('created_at', $lastYear)->whereMonth('created_at', 10)->sum('total_cost');
        $lastYear_month_11 = CustomerTransaction::where('status', TransactionStatus::Success)->whereYear('created_at', $lastYear)->whereMonth('created_at', 11)->sum('total_cost');
        $lastYear_month_12 = CustomerTransaction::where('status', TransactionStatus::Success)->whereYear('created_at', $lastYear)->whereMonth('created_at', 12)->sum('total_cost');

        $lastYearRevenueData = [
            '01' => floatval($lastYear_month_01),
            '02' => floatval($lastYear_month_02),
            '03' => floatval($lastYear_month_03),
            '04' => floatval($lastYear_month_04),
            '05' => floatval($lastYear_month_05),
            '06' => floatval($lastYear_month_06),
            '07' => floatval($lastYear_month_07),
            '08' => floatval($lastYear_month_08),
            '09' => floatval($lastYear_month_09),
            '10' => floatval($lastYear_month_10),
            '11' => floatval($lastYear_month_11),
            '12' => floatval($lastYear_month_12)
        ];

        $weekAgo = Carbon::now()->subDays(7)->startOfDay();

        $weekRevenue = CustomerTransaction::where('status', TransactionStatus::Success)->where('created_at', '>=', $weekAgo)->get();

        $weekRevenueDataIndex = [];
        $weekRevenueDataValue = [];

        $weekTotal = 0;
        $todayTotal = 0;

        foreach ($weekRevenue as $key => $value) {
            $weekRevenueDataIndex[] = $value->created_at->format('d');
            $weekRevenueDataValue[] = $value->total_cost;

            $weekTotal += $value->total_cost;
        }

        $today = Carbon::now()->format('Y-m-d');

        $todayRevenue = CustomerTransaction::where('status', TransactionStatus::Success)->whereDate('created_at', $today)->get();

        $todayRevenueDataIndex = [];
        $todayRevenueDataValue = [];

        foreach ($todayRevenue as $key => $value) {
            $todayRevenueDataIndex[] = $value->created_at->format('g:i A');
            $todayRevenueDataValue[] = $value->total_cost;

            $todayTotal += $value->total_cost;
        }

        return view('backend.dashboard', compact('ordersCount', 'clientsCount', 'artistsCount', 'coursesCount', 'thisYearRevenueData', 'lastYearRevenueData', 'weekRevenueDataIndex', 'weekRevenueDataValue', 'weekTotal', 'todayTotal', 'todayRevenueDataIndex', 'todayRevenueDataValue'));
    }
}
