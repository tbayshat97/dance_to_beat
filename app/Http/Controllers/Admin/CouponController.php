<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use DateTime;
use App\Http\Requests\Admin\AddCouponRequest;
use App\Http\Requests\Admin\UpdateCouponRequest;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coupon = Coupon::all();

        $breadcrumbs = [
            ['link' => "admin", 'name' => "Dashboard"], ['name' => "Coupons"],
        ];

        $addNewBtn = "admin.coupon.create";

        $pageConfigs = ['pageHeader' => true];

        return view('backend.coupons.list', compact('coupon', 'breadcrumbs', 'addNewBtn', 'pageConfigs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $breadcrumbs = [
            ['link' => "admin", 'name' => "Dashboard"], ['name' => "Coupons"],
        ];

        $pageConfigs = ['pageHeader' => true];

        return view('backend.coupons.add', compact('breadcrumbs', 'pageConfigs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddCouponRequest $request)
    {
        try {
            $coupon = new Coupon();
            $coupon->code = $request->code;
            $coupon->percentage = $request->percentage;
            $coupon->expire_count = $request->expire_count;
            $coupon->is_active = $request->has('is_active') ? true : false;

            if ($request->start_at) {
                $date = DateTime::createFromFormat('Y-m-d\TH:i', $request->start_at);
                $coupon->start_at = $date->format('Y-m-d H:i:s');
            }

            if ($request->end_at) {
                $date = DateTime::createFromFormat('Y-m-d\TH:i', $request->end_at);
                $coupon->end_at = $date->format('Y-m-d H:i:s');
            }

            $coupon->save();

            return redirect(route('admin.coupon.show', $coupon))->with('success', __('system-messages.add'));
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function show(Coupon $coupon)
    {
        $breadcrumbs = [
            ['link' => "admin", 'name' => "Dashboard"], ['link' => "admin/coupon", 'name' => "Coupons"], ['name' => "Update"],
        ];

        $pageConfigs = ['pageHeader' => true];

        return view('backend.coupons.show', compact('coupon', 'breadcrumbs', 'pageConfigs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCouponRequest $request, Coupon $coupon)
    {
        try {
            $coupon->code = $request->code;
            $coupon->percentage = $request->percentage;
            $coupon->expire_count = $request->expire_count;
            $coupon->is_active = $request->has('is_active') ? true : false;

            if ($request->start_at) {
                $date = DateTime::createFromFormat('Y-m-d\TH:i', $request->start_at);
                $coupon->start_at = $date->format('Y-m-d H:i:s');
            }

            if ($request->end_at) {
                $date = DateTime::createFromFormat('Y-m-d\TH:i', $request->end_at);
                $coupon->end_at = $date->format('Y-m-d H:i:s');
            }

            $coupon->save();

            return redirect()->back()->with('success', __('system-messages.update'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function destroy(Coupon $coupon)
    {
        $coupon->delete();
        return redirect(route('admin.coupon.index'))->with('success', __('system-messages.delete'));
    }
}
