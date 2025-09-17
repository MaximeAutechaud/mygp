<?php

namespace App\Services;

use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

readonly class MailerService
{
    public function __construct(private MailerInterface $mailer)
    {

    }

    /**
     * @throws TransportExceptionInterface
     */
    public function sendMessageEmail(string $subject, string $body, string $to = "foo@bar.com",  ?string $filePath = null): void
    {
        $email = (new Email())
            ->from('random@addresse.com')
            ->to($to)
            ->subject($subject)
            ->html("
                <h2>Nouveau message soumis</h2>
                <p><strong>Sujet :</strong> {$subject}</p>
                <p><strong>Message :</strong><br>{$body}</p>
            ");

        if ($filePath) {
            $email->attachFromPath($filePath);
        }

        $this->mailer->send($email);
    }
}
