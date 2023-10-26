<?php

namespace App\Services;

use Exception;
use Twilio\Rest\Client;
use Twilio\Exceptions\ConfigurationException;
use Twilio\Exceptions\TwilioException;
use App\Exceptions\CouldNotInitializeTwilioService;
use App\Exceptions\CouldNotSendIvrMessage;
use Twilio\Rest\Api\V2010\Account\CallInstance;

class TwilioService
{
    private Client $twilio;
    private string $TWILIO_VERIFY_SID;

    public function __construct()
    {
        try {
            $this->twilio = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));
        } catch (ConfigurationException $e) {
            throw new CouldNotInitializeTwilioService("Failed to initialize TwilioService: " . $e->getMessage());
        }

        $this->TWILIO_VERIFY_SID = env('TWILIO_VERIFY_SID');
    }

    public function sendVerificationCode($phoneNumber): bool
    {
        $verification = $this->twilio->verify->v2->services($this->TWILIO_VERIFY_SID)
            ->verifications
            ->create($phoneNumber, "sms");

        if ($verification->status !== 'pending') {
            throw new Exception('Verification code could not be sent');
        }
        return true;
    }

    public function verifyCode($phoneNumber, $code): bool
    {
        $verification_check = $this->twilio->verify->v2->services($this->TWILIO_VERIFY_SID)
            ->verificationChecks
            ->create(['to' => $phoneNumber, 'code' => $code]);

        if ($verification_check->status !== 'approved') {
            throw new Exception('Invalid code');
        }
        return true;
    }

    public function sendIRVMessage(string $phoneNumber, string $language, string $countryCode): CallInstance
    {
        $fileName = strtoupper($language) . '.mp3';
        $MP3LINK = asset("twilio/{$fileName}");

        match($countryCode) {
            config('app.country_codes.hw') => $twilioPhoneNumber = config('services.twilio.phone_number_hw'),
            config('app.country_codes.pl') => $twilioPhoneNumber = config('services.twilio.phone_number_pl'),
            default => $twilioPhoneNumber = config('services.twilio.phone_number'),
        };

        try {
            $call = $this->twilio->account->calls->create(
                $phoneNumber,
                $twilioPhoneNumber,
                [
                    "twiml" => "<Response><Play loop='1'>$MP3LINK</Play></Response>"
                ]
            );
        } catch (TwilioException $e) {
            throw new CouldNotSendIvrMessage("Failed to send IVR message due error: " . $e->getMessage());
        }

        return $call;
    }
}
