<?php

use App\Models\Artist;
use App\Models\Customer;
use App\Models\Dialog;
use App\Models\DialogMessage;
use App\Models\User;
use Illuminate\Database\Seeder;

class DialogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $customers = Customer::all();
        $artists = Artist::all();

        foreach ($customers as $customer) {
            $dialog = new Dialog();
            $dialog->accountable_type = Customer::class;
            $dialog->accountable_id = $customer->id;
            $dialog->save();

            $dialogMessage = new DialogMessage();
            $dialogMessage->dialog_id = $dialog->id;
            $dialogMessage->from_accountable_type = Customer::class;
            $dialogMessage->from_accountable_id = $customer->id;
            $dialogMessage->to_accountable_type = User::class;
            $dialogMessage->to_accountable_id = 1;
            $dialogMessage->message = 'Hello Admin';
            $dialogMessage->save();
        }

        foreach ($artists as $artist) {
            $dialog = new Dialog();
            $dialog->accountable_type = Artist::class;
            $dialog->accountable_id = $artist->id;
            $dialog->save();

            $dialogMessage = new DialogMessage();
            $dialogMessage->dialog_id = $dialog->id;
            $dialogMessage->from_accountable_type = Artist::class;
            $dialogMessage->from_accountable_id = $artist->id;
            $dialogMessage->to_accountable_type = User::class;
            $dialogMessage->to_accountable_id = 1;
            $dialogMessage->message = 'Hello Admin';
            $dialogMessage->save();
        }
    }
}
