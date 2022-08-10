<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Appointment;
use App\Models\Subscription;
use App\Models\CustomerSubscription;

class ReportController extends Controller
{
    public function orders(Request $request)
    {
        $orders = Order::query();
        $start = $request->start_date;
        $end = $request->end_date;

        if (isset($start) && $start && !$end) {
            $orders = $orders->whereDate('created_at', '>=', $start);
        }

        if (isset($end) && $end && !$start) {
            $orders = $orders->whereDate('created_at', '<=', $end);
        }

        if (isset($start) && $start && isset($end) && $end) {
            $orders = $orders->whereDate('created_at', '>=', $start)
                ->whereDate('created_at', '<=', $end);
        }

        $orders = $orders->get();

        $breadcrumbs = [
            ['link' => "admin", 'name' => "Dashboard"], ['name' => "Orders Report"],
        ];

        $pageConfigs = ['pageHeader' => true];

        return view('backend.reports.order', compact('orders', 'breadcrumbs', 'pageConfigs'));
    }

    public function bookings(Request $request)
    {
        $books = Appointment::query();
        $start = $request->start_date;
        $end = $request->end_date;

        if (isset($start) && $start && !$end) {
            $books = $books->whereDate('date', '>=', $start);
        }

        if (isset($end) && $end && !$start) {
            $books = $books->whereDate('date', '<=', $end);
        }

        if (isset($start) && $start && isset($end) && $end) {
            $books = $books->whereDate('date', '>=', $start)
                ->whereDate('created_at', '<=', $end);
        }

        $books = $books->get();

        $breadcrumbs = [
            ['link' => "admin", 'name' => "Dashboard"], ['name' => "Books Report"],
        ];

        $pageConfigs = ['pageHeader' => true];

        return view('backend.reports.book', compact('books', 'breadcrumbs', 'pageConfigs'));
    }
    public function subscriptions(Request $request)
    {
        $subscriptions = CustomerSubscription::query();
        $subscription_types = Subscription::all();
        $start = $request->start_date;
        $end = $request->end_date;
        $expiry_start = $request->expiry_start;
        $expiry_end = $request->expiry_end;
        $type = $request->type;

        # Duration
        if ($start && !$end) {
            $subscriptions = $subscriptions->whereDate('updated_at', '>=', $start);
        }

        if ($end && !$start) {
            $subscriptions = $subscriptions->whereDate('updated_at', '<=', $end);
        }

        if ($start && $end) {
            $subscriptions = $subscriptions->whereDate('updated_at', '>=', $start)
                ->whereDate('created_at', '<=', $end);
        }
        # End Duration

        # Expiry
        if ($expiry_start && !$expiry_end) {
            $subscriptions = $subscriptions->whereDate('ends_at', '>=', $expiry_start);
        }

        if ($expiry_end && !$expiry_start) {
            $subscriptions = $subscriptions->whereDate('ends_at', '<=', $expiry_end);
        }

        if ($expiry_start && $expiry_end) {
            $subscriptions = $subscriptions->whereDate('ends_at', '>=', $expiry_start)
                ->whereDate('ends_at', '<=', $expiry_end);
        }
        # End Expiry

        # Type
        if ($type) {
            $subscriptions = $subscriptions->where('subscription_id', $type);
        }
        #End Type

        $subscriptions = $subscriptions->get();

        $breadcrumbs = [
            ['link' => "admin", 'name' => "Dashboard"], ['name' => "Subscription Report"],
        ];

        $pageConfigs = ['pageHeader' => true];

        return view('backend.reports.subscription', compact('subscriptions', 'subscription_types', 'breadcrumbs', 'pageConfigs'));
    }
}
