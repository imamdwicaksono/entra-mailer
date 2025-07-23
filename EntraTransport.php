<?php
namespace Mmsgilibrary\EntraMailer;

use Symfony\Component\Mailer\Transport\AbstractTransport;
use Symfony\Component\Mailer\SentMessage;
use Symfony\Component\Mime\RawMessage;
use YourVendor\EntraMailer\Services\TokenService;
use GuzzleHttp\Client;
use Symfony\Component\Mime\Email;

class EntraTransport extends AbstractTransport
{
    protected function doSend(SentMessage $message): void
    {
        /** @var Email $email */
        $email = $message->getOriginalMessage();

        $to = $email->getTo()[0]->getAddress();
        $subject = $email->getSubject();
        $body = $email->getHtmlBody() ?? $email->getTextBody();

        $token = TokenService::getAccessToken();

        $client = new Client();
        $client->post('https://graph.microsoft.com/v1.0/users/' . config('entra-mailer.from_address') . '/sendMail', [
            'headers' => [
                'Authorization' => "Bearer {$token}",
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
                    ]
                ]
            ]
        ]);
    }

    public function __toString(): string
    {
        return 'entra';
    }
}
