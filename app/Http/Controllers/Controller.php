<?php

namespace App\Http\Controllers;

use App\Services\Notification;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public $lang = [
        ['name' => 'english', 'code' => 'en'],
        ['name' => 'arabic', 'code' => 'ar'],
    ];

    public function sendNotification($tokens, $title, $message, $data = [])
    {
        $notify = new Notification($tokens, $title, $message, $data);
        $notify->send();
    }
}
