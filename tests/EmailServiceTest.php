<?php

namespace App\Tests\Service;

use App\Service\EmailService;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class EmailServiceTest extends TestCase
{
    public function testSendTestEmail(): void
    {

        $mailerMock = $this->createMock(MailerInterface::class);


        $mailerMock->expects($this->once())
            ->method('send')
            ->with($this->callback(function (Email $email) {
                return $email->getFrom()[0]->getAddress() === 'mr.weezy1312@gmail.com'
                    && $email->getTo()[0]->getAddress() === 'mr.weezy1312@gmail.com'
                    && $email->getSubject() === 'Test Email'
                    && $email->getTextBody() === 'This is a test email using OAuth2 with Symfony Mailer!';
            }));

        // Create the EmailService instance with the mocked MailerInterface
        $emailService = new EmailService($mailerMock);

        // Call the method to test
        $emailService->sendTestEmail();
    }
}

