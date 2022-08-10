<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $breadcrumbs = [
            ['link' => "admin", 'name' => "Dashboard"], ['name' => "Subscriptions"],
        ];

        $pageConfigs = ['pageHeader' => true];

        $subscriptions = Subscription::all();
        return view('backend.subscriptions.list', compact('subscriptions', 'breadcrumbs', 'pageConfigs'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function show(Subscription $subscription)
    {
        $breadcrumbs = [
            ['link' => "admin", 'name' => "Dashboard"], ['link' => "admin/subscription", 'name' => "Subscriptions"], ['name' => "Update"]
        ];

        return view('backend.subscriptions.show', compact(['subscription', 'breadcrumbs']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subscription $subscription)
    {
        try {
            $subscription->name = $request->name;
            $subscription->month_count = $request->month_count;
            $subscription->price = $request->price;
            $subscription->save();

            return redirect(route('admin.subscription.index'))->with('success', __('system-messages.update'));
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }
}
