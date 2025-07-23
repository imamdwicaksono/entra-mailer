<?php

namespace Mmsgilibrary\EntraMailer\Transport;

use Symfony\Component\Mailer\Transport\AbstractTransport;
use Symfony\Component\Mailer\SentMessage;
use Symfony\Component\Mime\RawMessage;
use Mmsgilibrary\EntraMailer\Services\TokenService;
use GuzzleHttp\Client;
use Symfony\Component\Mime\Email;
use function config;

class EntraTransport extends AbstractTransport
{
    protected function doSend(SentMessage $message): void
    {
        /** @var Email $email */
        $email = $message->getOriginalMessage();

        $token = TokenService::getAccessToken();

        $toRecipients = array_map(fn($addr) => ['emailAddress' => ['address' => $addr->getAddress()]], $email->getTo());
        $ccRecipients = array_map(fn($addr) => ['emailAddress' => ['address' => $addr->getAddress()]], $email->getCc());
        $bccRecipients = array_map(fn($addr) => ['emailAddress' => ['address' => $addr->getAddress()]], $email->getBcc());

        $payload = [
            'message' => [
                'subject' => $email->getSubject(),
                'body' => [
                    'contentType' => $email->getHtmlBody() ? 'HTML' : 'Text',
                    'content' => $email->getHtmlBody() ?? $email->getTextBody(),
                ],
                'toRecipients' => $toRecipients,
            ]
        ];

        if (!empty($ccRecipients)) {
            $payload['message']['ccRecipients'] = $ccRecipients;
        }
        if (!empty($bccRecipients)) {
            $payload['message']['bccRecipients'] = $bccRecipients;
        }

        try {
            $client = new Client();
            $client->post('https://graph.microsoft.com/v1.0/users/' . config('entra-mailer.from_address') . '/sendMail', [
                'headers' => [
                    'Authorization' => "Bearer {$token}",
                    'Content-Type' => 'application/json',
                ],
                'json' => $payload,
            ]);
        } catch (\Exception $e) {
            throw new \RuntimeException("Failed to send email via Microsoft Graph: " . $e->getMessage(), 0, $e);
        }
    }

    public function __toString(): string
    {
        return 'entra';
    }
}
