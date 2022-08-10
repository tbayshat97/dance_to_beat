<?php

namespace App\Http\Controllers\API\Customer;

use App\Enums\AppointmentStatus;
use App\Enums\CustomerSubscriptionStatus;
use App\Enums\OrderStatus;
use App\Enums\TransactionStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\CheckoutRequest;
use App\Http\Resources\Order as ResourcesOrder;
use App\Models\Appointment;
use App\Models\CustomerCourse;
use App\Models\Order;
use App\Models\CustomerSubscription;
use App\Models\CustomerTransaction;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class HyperpayGatewayController extends Controller
{
    use ApiResponser;

    public function getCheckoutId(CheckoutRequest $request)
    {
        $customer = auth()->user();
        $customerPaymentData = $this->getPaymentData($request);

        $url = config('services.hyperpay.endpoint');

        $hyperPayData = [
            'entityId' => config('services.hyperpay.entity_id'),
            'amount' => $customerPaymentData['amount'],
            'currency' => config('services.hyperpay.currency'),
            'paymentType' => config('services.hyperpay.payment_type'),
        ];

        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [config('services.hyperpay.token')]);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($hyperPayData));
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, config('services.hyperpay.ssl_verify_peer')); // this should be set to true in production
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);
        } catch (\Exception $ex) {
            return $this->errorResponse(66, 'Hyperpay error', 200, $ex->getMessage());
        }

        $response = json_decode($response, true);
        $customerPaymentData['checkoutId'] = $response['id'];
        $response['payment_url'] = route('checkout-page', $customerPaymentData);


        $transaction = CustomerTransaction::where('customer_id', $customer->id)
            ->where('transable_type', $customerPaymentData["type"])
            ->where('transable_id', $customerPaymentData["id"])
            ->first();

        if (!$transaction) {
            $transaction = new CustomerTransaction();
            $transaction->customer_id = $customer->id;
            $transaction->transable_type = $customerPaymentData["type"];
            $transaction->transable_id = $customerPaymentData["id"];
            $transaction->status = TransactionStatus::Pending;
            $transaction->total_cost = $hyperPayData["amount"];
            $transaction->checkout_id = $response['id'];
            $transaction->save();
        } else {
            $transaction->checkout_id = $response['id'];
            $transaction->save();
        }

        return $this->successResponse(200, $response["result"]["description"], 200, $response);
    }

    public function getPaymentStatusApi(Request $request)
    {
        $url = config('services.hyperpay.endpoint') . '/' . $request->checkoutId . '/payment?entityId=' . config('services.hyperpay.entity_id');

        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [config('services.hyperpay.token')]);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, config('services.hyperpay.ssl_verify_peer')); // this should be set to true in production
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);
        } catch (\Exception $ex) {
            return $this->errorResponse(66, 'Hyperpay error', 200, $ex->getMessage());
        }

        $response = json_decode($response, true);

        $code = $response['result']['code'];

        if (preg_match('/^(000\.000\.|000\.100\.1|000\.[36])/', $code) || preg_match('/^(000\.400\.0[^3]|000\.400\.100)/', $code)) {
            $data = [
                'status' => 'success',
                'message' => 'تمت عملية الدفع بنجاح',
                'data' => $response,
            ];

            return $this->successResponse(200, trans('api.public.done'), 200, $data);
        }

        $data = [
            'status' => 'fail',
            'message' => $response['result']['description'],
            'data' => $response,
        ];

        return $this->successResponse(200, trans('api.public.done'), 200, $data);
    }

    public function getPaymentStatus(Request $request)
    {
        $url = config('services.hyperpay.endpoint') . '/' . $request["id"] . '/payment?entityId=' . config('services.hyperpay.entity_id');

        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [config('services.hyperpay.token')]);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, config('services.hyperpay.ssl_verify_peer')); // this should be set to true in production
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);
        } catch (\Exception $ex) {
            $data = [
                'status' => 'Hyper pay fail',
                'message' => $ex->getMessage(),
                'code' => 500
            ];

            $data = json_encode($data);

            return view('payment.payment_status', compact(['data']));
        }

        $response = json_decode($response, true);

        $code = $response['result']['code'];

        if (preg_match('/^(000\.000\.|000\.100\.1|000\.[36])/', $code) || preg_match('/^(000\.400\.0[^3]|000\.400\.100)/', $code)) {


            $transaction = CustomerTransaction::where('checkout_id', $request["id"])->first();
            $transaction->status = TransactionStatus::Success;
            $transaction->save();

            $data = [
                'status' => 'success',
                'message' => trans('api.public.done'),
                'data' => $response,
                'object' => $this->getPaymentObject($transaction),
                'code' => 200
            ];

            $this->savePaymentData($transaction);

            $data = json_encode($data);

            return view('payment.payment_status', compact(['data']));
        }

        $data = [
            'status' => 'fail',
            'message' => $response['result']['description'],
            'data' => $response,
            'code' => 406
        ];

        $data = json_encode($data);

        return view('payment.payment_status', compact(['data']));
    }

    protected function getPaymentData($request)
    {
        $data = [];

        switch ($request->type) {
            case 'order':
                $order = Order::find($request->id);
                $data["type"] = Order::class;
                $data["id"] = $order->id;
                $data["amount"] = $order->total_cost;
                break;
            case 'appointment':
                $appointment = Appointment::find($request->id);
                $data["type"] = Appointment::class;
                $data["id"] = $appointment->id;
                $data["amount"] = $appointment->total_cost;
                break;
            case 'subscription':
                $customerSubscription = CustomerSubscription::find($request->id);
                $data["type"] = CustomerSubscription::class;
                $data["id"] = $customerSubscription->id;
                $data["amount"] = $customerSubscription->package->price;
                break;
        }

        return $data;
    }

    protected function savePaymentData($transaction)
    {
        switch ($transaction->transable_type) {
            case Order::class:
                $order = Order::find($transaction->transable_id);
                $order->status = OrderStatus::Paid;
                $order->is_finished = true;
                $order->save();

                $customerCourse = new CustomerCourse();
                $customerCourse->order_id = $order->id;
                $customerCourse->customer_id = $order->customer_id;
                $customerCourse->course_id = $order->course_id;
                $customerCourse->save();
                break;
            case Appointment::class:
                $appointment = Appointment::find($transaction->transable_id);
                $appointment->status = AppointmentStatus::Confirmed;
                $appointment->save();
                break;
            case CustomerSubscription::class:
                $customerSubscription = CustomerSubscription::find($transaction->transable_id);
                $customerSubscription->status = CustomerSubscriptionStatus::Paid;
                $customerSubscription->save();
                break;
        }
    }

    protected function getPaymentObject($data)
    {
        $object = [];

        switch ($data->transable_type) {
            case Order::class:
                $object = [
                    'type' => 'order',
                    'course_id' => $data->transable->course->id
                ];

                break;
            case Appointment::class:
                $object = [
                    'type' => 'appointment',
                ];
                break;

            case CustomerSubscription::class:
                $object = [
                    'type' => 'subscription',
                ];

                break;
        }

        return $object;
    }
}
