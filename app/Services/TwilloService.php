<?php

namespace App\Services;

use Exception;
use Twilio\Rest\Client;

class TwilloService
{
    /*private Client $twillo;
    private string $TWILIO_VERIFY_SID;

    public function __construct()
    {
        $this->twillo = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));
        $this->TWILIO_VERIFY_SID = env('TWILIO_VERIFY_SID');
    }

    public function sendVerificationCode($phoneNumber): bool
    {
        $verification = $this->twillo->verify->v2->services($this->TWILIO_VERIFY_SID)
            ->verifications
            ->create($phoneNumber, "sms");

        if ($verification->status !== 'pending') {
            throw new Exception('Verification code could not be sent');
        }
        return true;
    }

    public function verifyCode($phoneNumber, $code): bool
    {
        $verification_check = $this->twillo->verify->v2->services($this->TWILIO_VERIFY_SID)
            ->verificationChecks
            ->create(['to' => $phoneNumber, 'code' => $code]);

        if ($verification_check->status !== 'approved') {
            throw new Exception('Invalid code');
        }
        return true;
    }*/
}
