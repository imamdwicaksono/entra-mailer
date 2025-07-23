<?php

namespace YourVendor\EntraMailer\Mail;

use YourVendor\EntraMailer\Services\TokenService;
use GuzzleHttp\Client;

class EntraMailer
{
    public static function send(string $to, string $subject, string $body)
    {
        $token = TokenService::getAccessToken();

        $client = new Client();
        $res = $client->post('https://graph.microsoft.com/v1.0/users/' . config('entra-mailer.from_address') . '/sendMail', [
            'headers' => [
                'Authorization' => "Bearer $token",
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'message' => [
                    'subject' => $subject,
                    'body' => [
                        'contentType' => 'HTML',
                        'content' => $body,
                    ],
                    'toRecipients' => [
                        ['emailAddress' => ['address' => $to]],
                    ],
                    'from' => [
                        'emailAddress' => [
                            'address' => config('entra-mailer.from_address'),
                            'name' => config('entra-mailer.from_name')
                        ]
                    ]
                ]
            ]
        ]);

        return $res->getStatusCode() === 202;
    }
}
