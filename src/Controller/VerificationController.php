<?php

namespace App\Controller;

use App\Repository\AdminRepository;
use App\Repository\ConducteurRepository;
use App\Repository\UtilisateurRepository;
use App\Service\EmailService;
use App\Service\TwilioService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Attribute\Route;

class VerificationController extends AbstractController
{
    private TwilioService $twilioVerifyService;
    private EmailService $emailService;

    private UtilisateurRepository $utilisateurRepository;

    public function __construct(
        TwilioService $twilioVerifyService,
        EmailService $emailService,
        UtilisateurRepository $utilisateurRepository
    ){
        $this->twilioVerifyService = $twilioVerifyService;
        $this->emailService = $emailService;
        $this->utilisateurRepository = $utilisateurRepository;
    }

    #[Route('/start-verification', name: 'start_verification', methods: ['POST'])]
    public function startVerification(Request $request): Response
    {
        $phoneNumber = $request->request->get('phone_number');
        $channel = $request->request->get('channel', 'sms'); // 'sms' or 'call'

        if (!$phoneNumber) {
            return $this->json(['error' => 'Phone number is required.'], Response::HTTP_BAD_REQUEST);
        }

        $success = $this->twilioVerifyService->startVerification($phoneNumber, $channel);

        if ($success) {
            return $this->json(['message' => 'Verification code sent.']);
        } else {
            return $this->json(['error' => 'Failed to send verification code.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/check-verification', name: 'check_verification', methods: ['POST'])]
    public function checkVerification(Request $request): Response
    {
        $phoneNumber = $request->request->get('phone_number');
        $code = $request->request->get('code');

        if (!$phoneNumber || !$code) {
            return $this->json(['error' => 'Phone number and code are required.'], Response::HTTP_BAD_REQUEST);
        }

        $isVerified = $this->twilioVerifyService->checkVerification($phoneNumber, $code);

        if ($isVerified) {
            // Optionally, you can mark the user as verified in your system here.
            return $this->json(['message' => 'Phone number verified successfully.']);
        } else {
            return $this->json(['error' => 'Invalid verification code.'], Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route('/send-mail', name: 'send-mail', methods: ['GET'])]
    public function sendmail(Request $request): Response
    {
        $this->emailService->sendTestEmail();
        return $this->json(['message' => 'Email sent.']);
    }


    #[Route('/test', name: 'test', methods: ['GET'])]
    public function test(Request $request): Response
    {
        $test = $this->utilisateurRepository->find(1);
        return $this->json($test);
    }
}
