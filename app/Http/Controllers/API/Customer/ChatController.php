<?php

namespace App\Http\Controllers\API\Customer;

use App\CustomClasses\Curl;
use App\Http\Controllers\Controller;
use App\Http\Resources\ConsultantCollection;
use App\Models\Consultant;
use App\Traits\ApiResponser;
use Carbon\Carbon;

class ChatController extends Controller
{
    use ApiResponser;

    #region Quick Blox
    private function createSessionWithUser($username)
    {
        $password = 'qweasdzxc123$';
        $timestamp = Carbon::now()->addMinutes(59)->timestamp;
        $nonce = 'nonce_rjeem_' . $timestamp;
        $url = config('services.quickblox.base_url') . '/session.json';
        $headers = [
            "Content-Type: application/json",
        ];
        $signature = hash_hmac(
            'sha1',
            'application_id=' . config('services.quickblox.application_id')
                . '&auth_key=' . config('services.quickblox.authorization_key')
                . '&nonce=' . $nonce
                . '&timestamp=' . $timestamp
                . '&user[login]=' . 'customer_' . $username
                . '&user[password]=' . $password,
            config('services.quickblox.authorization_secret')
        );

        $query = [
            'application_id' => config('services.quickblox.application_id'),
            'auth_key' => config('services.quickblox.authorization_key'),
            'timestamp' => $timestamp,
            'nonce' => $nonce,
            'signature' => $signature,
            'user' => [
                'login' => 'customer_' . $username,
                'password' => $password,
            ]
        ];

        Curl::prepare($url, json_encode($query), $headers);
        Curl::exec_post();
        return Curl::get_response_assoc();
    }

    private function getQBUserIds($token)
    {
        $page = 1;
        $user_ids = [];
        while (true) {
            $url = config('services.quickblox.base_url') . "/users.json";
            $headers = [
                "Content-Type: application/json",
                "QB-Token: $token",
            ];
            $query = [
                'page' => $page,
                'per_page' => '100', // Min: 1, Max 100
                'order' => 'asc+date+created_at',
            ];
            Curl::prepare($url, http_build_query($query), $headers);
            Curl::exec_get();
            $users_list = Curl::get_response_assoc();
            foreach ($users_list['data']['items'] as $value) {
                $user_ids[] = $value['user']['id'];
            }
            if ($users_list['data']['total_entries'] <= count($user_ids)) {
                break;
            }
            $page++;
        }
        return $user_ids;
    }

    private function getQBDialogMessages($token, $chat_dialog_id)
    {
        $url = config('services.quickblox.base_url') . "/chat/Message.json";
        $headers = [
            "Content-Type: application/json",
            "QB-Token: $token",
        ];
        $query = [
            'chat_dialog_id' => $chat_dialog_id,
        ];
        Curl::prepare($url, http_build_query($query), $headers);
        Curl::exec_get();
        $users_list = Curl::get_response_assoc();
        return $users_list;
    }
    #endregion

    public function users()
    {
        $customer = auth()->user();
        $session = $this->createSessionWithUser($customer->username);
        $token = $session['data']['session']['token'];
        $qb_user_ids = $this->getQBUserIds($token);
        $consultants = Consultant::all();
        return $this->successResponse(200, trans('api.public.done'), 200, new ConsultantCollection($consultants));
    }

    public function dialogMessages($dialog)
    {
        $customer = auth()->user();
        $session = $this->createSessionWithUser($customer->username);
        $token = $session['data']['session']['token'];
        $messages = $this->getQBDialogMessages($token, $dialog);
        return $this->successResponse(200, trans('api.public.done'), 200, $messages['data']);
    }
}
