<?php

namespace App\Http\Controllers\API\Customer;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\Order as ResourcesOrder;
use App\Http\Resources\OrderCollection;
use App\Models\Coupon;
use App\Models\Course;
use App\Models\Order;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    use ApiResponser;

    public function list()
    {
        $customer = auth()->user();

        $orders = $customer->orders()
            ->where([
                'status' => OrderStatus::Paid,
                'is_finished' => true,
            ])
            ->orderBy('created_at', 'desc')
            ->get();

        return $this->successResponse(200, trans('api.public.done'), 200, new OrderCollection($orders));
    }

    public function store(Course $course, Request $request)
    {
        $customer = auth()->user();

        if (!$course->live) {
            return $this->successResponse(204, trans('api.public.live-message'), 200);
        }

        $isPaidOrder = in_array($course->id, $customer->courses()->pluck('course_id')->toArray());

        if ($isPaidOrder) {
            return $this->successResponse(205, trans('api.public.exist'), 200);
        }

        $isNotPaidOrder = Order::where([
            'customer_id' => $customer->id,
            'course_id' => $course->id,
            'status' => OrderStatus::Pending,
            'is_finished' => false
        ])->first();

        if ($isNotPaidOrder) {
            return $this->successResponse(206, trans('api.public.exist_not_paid'), 200, new ResourcesOrder($isNotPaidOrder));
        }

        # check coupon
        $percentage = null;
        $discount = 0;
        $coupon_id = null;
        $coupon_filter = null;

        if ($request->has('coupon') && !is_null($request->coupon)) {
            $coupon = Coupon::where(['code' => $request->coupon, 'is_active' =>  true])->first();

            if (!$coupon) {
                return $this->errorResponse(99, trans('api.order.coupon_expired'), 200);
            }

            $count_used_in = Order::where('coupon_id', $coupon->id)->where('status', OrderStatus::Paid)->count();

            $coupon_filter = Coupon::where('id', $coupon->id)
                ->where('is_active', true)
                ->where('expire_count', '>', $count_used_in)
                ->whereDate('start_at', '<=', date('Y-m-d H:i:s'))
                ->whereDate('end_at', '>=', date('Y-m-d H:i:s'))
                ->first();

            if ($coupon_filter) {
                $percentage = $coupon_filter->percentage;
                $coupon_id = $coupon->id;
                $discount =  ($percentage / 100) * $course->price;
            } else {
                return $this->errorResponse(99, trans('api.order.coupon_expired'), 200);
            }
        }

        # make order
        $customer_order = new Order();
        $customer_order->order_number = $this->generateUniqueNumber($customer);
        $customer_order->customer_id = $customer->id;
        $customer_order->course_id = $course->id;
        $customer_order->status = OrderStatus::Pending;
        $customer_order->total_cost = $course->price;

        # calc coupon discount
        if (!is_null($percentage)) {
            $customer_order->total_cost = $course->price - $discount;
            $customer_order->coupon_id = $coupon_id;
        }

        $customer_order->save();

        return $this->successResponse(200, trans('api.order.submit'), 200, new ResourcesOrder($customer_order));
    }

    public function show(Order $order)
    {
        return $this->successResponse(200, trans('api.public.done'), 200, new ResourcesOrder($order));
    }

    protected function generateUniqueNumber($customer)
    {
        return 'O' . date('ymd') . $customer->id . strtoupper(substr(uniqid(sha1(time())), 0, 4));
    }
}
