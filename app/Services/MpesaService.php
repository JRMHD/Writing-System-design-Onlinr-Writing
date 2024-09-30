<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;

class MpesaService
{
    protected $client;
    protected $consumerKey;
    protected $consumerSecret;
    protected $shortcode;
    protected $passkey;
    protected $callbackUrl;
    protected $environment;

    public function __construct()
    {
        $this->consumerKey = Config::get('services.mpesa.consumer_key');
        $this->consumerSecret = Config::get('services.mpesa.consumer_secret');
        $this->shortcode = Config::get('services.mpesa.shortcode');
        $this->passkey = Config::get('services.mpesa.passkey');
        $this->callbackUrl = Config::get('services.mpesa.callback_url');
        $this->environment = Config::get('services.mpesa.environment');

        $baseUri = $this->environment === 'sandbox'
            ? 'https://sandbox.safaricom.co.ke/'
            : 'https://api.safaricom.co.ke/';

        $this->client = new Client([
            'base_uri' => $baseUri,
            'timeout'  => 30.0,
        ]);
    }

    private function getAccessToken()
    {
        $credentials = base64_encode($this->consumerKey . ':' . $this->consumerSecret);
        try {
            $response = $this->client->request('GET', 'oauth/v1/generate?grant_type=client_credentials', [
                'headers' => [
                    'Authorization' => 'Basic ' . $credentials,
                ],
            ]);

            $body = json_decode($response->getBody(), true);
            return $body['access_token'] ?? null;
        } catch (\Exception $e) {
            Log::error('Mpesa Access Token Error: ' . $e->getMessage());
            return null;
        }
    }

    public function stkPush($phone, $amount, $accountReference, $transactionDesc)
    {
        $accessToken = $this->getAccessToken();
        if (!$accessToken) {
            return ['success' => false, 'message' => 'Could not retrieve access token'];
        }

        $timestamp = date('YmdHis');
        $password = base64_encode($this->shortcode . $this->passkey . $timestamp);

        $payload = [
            'BusinessShortCode' => $this->shortcode,
            'Password' => $password,
            'Timestamp' => $timestamp,
            'TransactionType' => 'CustomerPayBillOnline',
            'Amount' => $amount,
            'PartyA' => $phone,
            'PartyB' => $this->shortcode,
            'PhoneNumber' => $phone,
            'CallBackURL' => $this->callbackUrl,
            'AccountReference' => $accountReference,
            'TransactionDesc' => $transactionDesc,
        ];

        try {
            $response = $this->client->request('POST', 'mpesa/stkpush/v1/processrequest', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                    'Content-Type' => 'application/json',
                ],
                'json' => $payload,
            ]);

            $body = json_decode($response->getBody(), true);
            if (isset($body['ResponseCode']) && $body['ResponseCode'] == '0') {
                return ['success' => true, 'data' => $body];
            } else {
                return ['success' => false, 'message' => $body['errorMessage'] ?? 'Unknown error'];
            }
        } catch (\Exception $e) {
            Log::error('Mpesa STK Push Error: ' . $e->getMessage());
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}
