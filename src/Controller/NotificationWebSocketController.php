<?php

namespace App\Controller;

use App\Form\NotificationDTO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mercure\PublisherInterface;
use Symfony\Component\Mercure\Update;

class NotificationWebSocketController extends AbstractController
{
    private PublisherInterface $publisher;

    // Inject the publisher service
    public function __construct(PublisherInterface $publisher)
    {
        $this->publisher = $publisher;
    }

    /**
     * @Route("/send-notification/{userId}", name="send_notification")
     */
    public function sendNotification(int $userId, NotificationDTO $message): Response
    {
        // Créer le sujet pour Mercure
        $topic = 'notifications/' . $userId;

        // Publier la notification via Mercure
        $this->publisher->publish(new Update(
            $topic,
            json_encode(['message' => $message->getMessage()]) // Convertir l'objet DTO en JSON
        ));

        // Log pour la console
        $this->get('logger')->info("Sending notification to userId=$userId with message: " . $message->getMessage());

        return new Response('Notification sent');
    }
}
