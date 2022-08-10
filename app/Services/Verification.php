<?php

namespace App\Services;

use Twilio\Rest\Client;

class Verification
{
    protected $token;
    protected $twilio_sid;
    protected $twilio_verify_sid;
    protected $send_to;

    public function __construct($send_to)
    {
        $this->token = getenv("TWILIO_AUTH_TOKEN");
        $this->twilio_sid = getenv("TWILIO_SID");
        $this->twilio_verify_sid = getenv("TWILIO_VERIFY_SID");
        $this->send_to = $send_to;
    }

    public function sendSms()
    {
        try {
            $twilio = new Client($this->twilio_sid, $this->token);
            $twilio->verify->v2->services($this->twilio_verify_sid)
                ->verifications
                ->create('+' . $this->send_to, "sms");
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function verifySMS($code)
    {
        $twilio = new Client($this->twilio_sid, $this->token);

        try {
            $verification_check = $twilio->verify->v2->services($this->twilio_verify_sid)
                ->verificationChecks
                ->create(
                    $code,
                    ["to" => '+' . $this->send_to]
                );

            if ($verification_check->status === 'approved') {
                return true;
            }

            return false;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
