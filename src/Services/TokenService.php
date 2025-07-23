<?php

namespace YourVendor\EntraMailer\Services;

use GuzzleHttp\Client;

class TokenService
{
    public static function getAccessToken(): string
    {
        $client = new Client();
        $url = 'https://login.microsoftonline.com/' . config('entra-mailer.tenant_id') . '/oauth2/v2.0/token';

        $response = $client->post($url, [
            'form_params' => [
                'client_id' => config('entra-mailer.client_id'),
                'client_secret' => config('entra-mailer.client_secret'),
                'scope' => 'https://graph.microsoft.com/.default',
                'grant_type' => 'client_credentials',
            ],
        ]);

        $body = json_decode($response->getBody()->getContents(), true);
        return $body['access_token'];
    }
}
