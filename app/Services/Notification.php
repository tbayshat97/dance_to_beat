<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Kawankoding\Fcm\Fcm;

class Notification
{
    protected $env;
    protected $tokens;
    protected $title;
    protected $message;
    protected $data;

    public function __construct($tokens, $title, $message, $data = [])
    {
        $this->env = getenv("FCM_SERVER_KEY");
        $this->tokens = $tokens;
        $this->title = $title;
        $this->message = $message;
        $this->data = $data;
    }

    public function send()
    {
        try {
            $fcm = new Fcm($this->env);

            $context = $fcm->to($this->tokens)
                ->priority('high')
                ->timeToLive(0)
                ->notification([
                    'title' => trim($this->title),
                    'body' => trim($this->message),
                    'sound' => 'default'
                ])
                ->send();

            Log::info('New notification sent', ["context" => $context]);
        } catch (\Exception $e) {
            Log::error('Faild send notification due to: ', ["context" => $e->getMessage()]);
        }
    }
}
