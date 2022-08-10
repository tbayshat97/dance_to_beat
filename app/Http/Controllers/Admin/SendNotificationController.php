<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerNotification;
use Illuminate\Http\Request;

class SendNotificationController extends Controller
{
    public function sendNotificationPage()
    {
        return view('backend.notifications.send-page');
    }

    public function send(Request $request)
    {
        $validations = [
            'title' => 'required',
            'type' => 'required',
            'message' => 'required'
        ];

        $request->validate($validations);

        try {
            $this->setConfAndSend($request->type, $request->title, $request->message);
            return redirect()->back()->with('success', __('system-messages.done'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());;
        }
    }

    protected function setConfAndSend($type, $title, $message)
    {
        if ($type == Customer::class) {
            $users = Customer::whereNotNull('fcm_token')->get(['id', 'fcm_token']);
        }

        $tokens = [];

        foreach ($users as $value) {
            $notification = new CustomerNotification();
            $notification->customer_id = $value->id;
            $notification->title = $title;
            $notification->content = $message;
            $notification->save();
            array_push($tokens, $value->fcm_token);
        }

        $this->sendNotification(
            $tokens,
            $title,
            $message
        );
    }
}
