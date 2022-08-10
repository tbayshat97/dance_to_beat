<?php

namespace App\Http\Controllers\Artist;

use App\Events\NewMessage;
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
            ['link' => "artist", 'name' => "Dashboard"], ['name' => "Customers"],
        ];

        $pageConfigs = ['pageHeader' => false];

        $dialog = Dialog::where(['accountable_type' => Artist::class, 'accountable_id' => auth('artist')->user()->id])->first();

        return view('backend-artist.dialogs.chat', compact('customers', 'breadcrumbs', 'pageConfigs', 'dialog'));
    }

    public function chatMessages(Dialog $dialog)
    {
        $dialog->messages()->update(['is_read' => true]);

        $messages = $dialog->messages;
        $account = $this->getDialogUser($dialog->accountable_type, $dialog->accountable_id);

        return view('backend-artist.dialogs.chat-content', compact('dialog', 'account', 'messages'));
    }

    protected function getDialogUser($accountable_type, $accountable_id)
    {
        $account = null;

        if ($accountable_type === Artist::class) {
            $account = Artist::find($accountable_id);
        }

        return $account;
    }

    public function sendMessage(Dialog $dialog, Request $request)
    {
        $artist = auth('artist')->user();

        $dialog = Dialog::where([
            'accountable_type' => Artist::class,
            'accountable_id' => $artist->id
        ])->first();

        if (!$dialog) {
            $dialog = new Dialog();
            $dialog->accountable_type = Artist::class;
            $dialog->accountable_id = $artist->id;
            $dialog->save();
        }

        $dialog->update(
            ['updated_at' => now()]
        );

        $dialogMessage = new DialogMessage();
        $dialogMessage->dialog_id = $dialog->id;
        $dialogMessage->from_accountable_type = Artist::class;
        $dialogMessage->from_accountable_id = $artist->id;
        $dialogMessage->to_accountable_type = User::class;
        $dialogMessage->to_accountable_id = User::first()->id;
        $dialogMessage->message = $request->message;
        $dialogMessage->is_read = false;
        $dialogMessage->save();

        $data = [
            'dialog' => $dialog,
            'dialogMessage' => $dialogMessage,
            'accountImage' => $artist->profile->getProfileImage() ? asset($artist->profile->getProfileImage()) : asset('images/placeholders/user.png'),
            'lastMessageDate' => $dialogMessage->created_at->format('g:i A'),
            'unreadMessagesCount' => $dialog->unreadMessages()
        ];

        event(new NewMessage($data));
    }

    public function sidebar()
    {
        $dialogs = Dialog::where(['accountable_type' => Artist::class, 'accountable_id' => auth('artist')->user()->id])->get();

        $dialogs->each(function ($dialog) {
            $dialog->account = $this->getDialogUser($dialog->accountable_type, $dialog->accountable_id);
        });

        return view('backend-artist.dialogs.sidebar', compact('dialogs'));
    }

    public function readAll(Dialog $dialog)
    {
        $dialog->messages()->update(
            ['is_read' => true]
        );
    }
}
