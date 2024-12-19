<?php

namespace App\Service;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class EmailService
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendTestEmail()
    {
        $email = (new Email())
            ->from('mr.weezy1312@gmail.com')
            ->to('mr.weezy1312@gmail.com')
            ->subject('Test Email')
            ->text('This is a test email using OAuth2 with Symfony Mailer!');

        $this->mailer->send($email);
    }
}
