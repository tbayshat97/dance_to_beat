<?php

namespace App\Http\Controllers\API\Customer;

use App\Events\NewMessage;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Dialog;
use App\Models\DialogMessage;
use App\Models\User;
use Illuminate\Http\Request;

class DialogMessageController extends Controller
{
    public function sendMessage(Request $request)
    {
        $customer = auth()->user();

        $dialog = Dialog::where([
            'accountable_type' => Customer::class,
            'accountable_id' => $customer->id
        ])->first();

        if (!$dialog) {
            $dialog = new Dialog();
            $dialog->accountable_type = Customer::class;
            $dialog->accountable_id = $customer->id;
            $dialog->save();
        }

        $dialog->update(
            ['updated_at' => now()]
        );

        $dialogMessage = new DialogMessage();
        $dialogMessage->dialog_id = $dialog->id;
        $dialogMessage->from_accountable_type = Customer::class;
        $dialogMessage->from_accountable_id = $customer->id;
        $dialogMessage->to_accountable_type = User::class;
        $dialogMessage->to_accountable_id = User::first()->id;
        $dialogMessage->message = $request->message;
        $dialogMessage->is_read = false;
        $dialogMessage->save();

        $data = [
            'dialog' => $dialog,
            'dialogMessage' => $dialogMessage,
            'accountImage' => $customer->profile->image ? asset('storage/' . $customer->profile->image) : asset('images/placeholders/user.png'),
            'lastMessageDate' => $dialogMessage->created_at->format('g:i A'),
            'unreadMessagesCount' => $dialog->unreadMessages()
        ];

        event(new NewMessage($data));
    }
}
