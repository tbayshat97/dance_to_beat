<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Enums\OrderStatus;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::all();

        $breadcrumbs = [
            ['link' => "admin", 'name' => "Dashboard"], ['name' => "Orders"],
        ];

        $pageConfigs = ['pageHeader' => true];

        return view('backend.orders.list', compact('orders', 'breadcrumbs', 'pageConfigs'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        $breadcrumbs = [
            ['link' => "admin", 'name' => "Dashboard"], ['link' => "admin/order", 'name' => "Orders"], ['name' => "Update"],
        ];

        $pageConfigs = ['pageHeader' => true];

        $orderStatuses = OrderStatus::asSelectArray();

        return view('backend.orders.show', compact('order', 'breadcrumbs', 'pageConfigs', 'orderStatuses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        try {
            $order->status = $request->status;
            $order->is_finished = ($request->has('is_finished')) ? true : false;
            $order->save();

            return redirect()->back()->with('success', __('system-messages.update'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
