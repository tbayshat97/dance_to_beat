<?php

namespace App\Console\Commands;

use App\Enums\CustomerSubscriptionStatus;
use App\Models\CustomerSubscription;
use Illuminate\Console\Command;

class CheckEndedSubscription extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:subscription';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check Ended Subscription';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        CustomerSubscription::where('ends_at', '<=',  now())->update([
            'status' => CustomerSubscriptionStatus::Ended
        ]);
    }
}
