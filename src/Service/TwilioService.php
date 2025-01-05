<?php

namespace App\Service;

use Twilio\Rest\Client;
use Twilio\Exceptions\TwilioException;

class TwilioService
{
    private Client $twilioClient;
    private string $verifyServiceSid;

    public function __construct(string $accountSid, string $authToken, string $verifyServiceSid)
    {
        $this->twilioClient = new Client($accountSid, $authToken);
        $this->verifyServiceSid = $verifyServiceSid;
    }

/**
* Start the verification process by sending a verification code.
*
* @param string $toNumber The phone number to verify.
* @param string $channel  The channel to use ('sms' or 'call').
* @return bool            True on success, false otherwise.
*/
    public function startVerification(string $toNumber, string $channel = 'sms'): bool
    {
        try {
            $this->twilioClient->verify->v2->services($this->verifyServiceSid)
            ->verifications
            ->create($toNumber, $channel);
            return true;
        } catch (TwilioException $e) {
        // Handle the exception (e.g., log the error)
            return false;
        }
    }

/**
* Check the verification code submitted by the user.
*
* @param string $toNumber The phone number to verify.
* @param string $code     The verification code provided by the user.
* @return bool            True if verification is successful, false otherwise.
*/
    public function checkVerification(string $toNumber, string $code): bool
    {
        try {
            $verificationCheck = $this->twilioClient->verify->v2->services($this->verifyServiceSid)
            ->verificationChecks
            ->create([
            'to' => $toNumber,
            'code' => $code,
            ]);

            return $verificationCheck->status === 'approved';
        } catch (TwilioException $e) {
        // Handle the exception (e.g., log the error)
            return false;
        }
    }
}
