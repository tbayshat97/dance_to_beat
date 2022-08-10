<?php

namespace App\Http\Controllers\Admin;

use App\Events\NewMessageAdmin;
use App\Http\Controllers\Controller;
use App\Models\Artist;
use App\Models\Customer;
use App\Models\Dialog;
use App\Models\DialogMessage;
use App\Models\User;
use Illuminate\Http\Request;

class DialogController extends Controller
{
    public function chat()
    {
        $customers = Customer::all();

        $breadcrumbs = [
            ['link' => "admin", 'name' => "Dashboard"], ['name' => "Customers"],
        ];

        $pageConfigs = ['pageHeader' => false];

        $dialogs = Dialog::where(['accountable_type' => Artist::class])->get();

        $dialogs->each(function ($dialog) {
            $dialog->account = $this->getDialogUser($dialog->accountable_type, $dialog->accountable_id);
        });

        return view('backend.dialogs.chat', compact('breadcrumbs', 'pageConfigs', 'dialogs'));
    }

    public function chatMessages(Dialog $dialog)
    {
        $dialog->messages()->update(['is_read' => true]);

        $messages = $dialog->messages;
        $account = $this->getDialogUser($dialog->accountable_type, $dialog->accountable_id);

        return view('backend.dialogs.chat-content', compact('dialog', 'account', 'messages'));
    }

    protected function getDialogUser($accountable_type, $accountable_id)
    {
        $account = null;

        if ($accountable_type === Customer::class) {
            $account = Customer::find($accountable_id);
        }

        if ($accountable_type === Artist::class) {
            $account = Artist::find($accountable_id);
        }

        return $account;
    }

    public function sendMessage(Dialog $dialog, Request $request)
    {
        $dialog->update(
            ['updated_at' => now()]
        );

        $dialogMessage = new DialogMessage();
        $dialogMessage->dialog_id = $dialog->id;
        $dialogMessage->from_accountable_type = User::class;
        $dialogMessage->from_accountable_id = auth()->user()->id;
        $dialogMessage->to_accountable_type = $dialog->accountable_type;
        $dialogMessage->to_accountable_id = $dialog->accountable_id;
        $dialogMessage->message = $request->message;
        $dialogMessage->save();


        $data = [
            'dialog' => $dialog,
            'dialogMessage' => $dialogMessage,
            'accountImage' => asset('images/placeholders/user.png'),
            'lastMessageDate' => $dialogMessage->created_at->format('g:i A'),
            'unreadMessagesCount' => $dialog->unreadMessages(),
            'authUserId' => $dialog->accountable_id
        ];

        event(new NewMessageAdmin($data));
    }

    public function sidebar()
    {
        $dialogs = Dialog::where(['accountable_type' => Artist::class])->get();

        $dialogs->each(function ($dialog) {
            $dialog->account = $this->getDialogUser($dialog->accountable_type, $dialog->accountable_id);
        });

        return view('backend.dialogs.sidebar', compact('dialogs'));
    }

    public function readAll(Dialog $dialog)
    {
        $dialog->messages()->update(
            ['is_read' => true]
        );
    }
}
