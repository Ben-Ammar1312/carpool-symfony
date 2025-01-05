<?php

namespace App\Service;

use App\Entity\Notification;
use App\Repository\NotificationRepository;
use App\Controller\NotificationWebSocketController;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;

class NotificationService
{
    private NotificationRepository $notificationRepository;
    private NotificationWebSocketController $notificationWebSocketController;
    private EntityManagerInterface $entityManager;

    public function __construct(
        NotificationRepository $notificationRepository,
        NotificationWebSocketController $notificationWebSocketController,
        EntityManagerInterface $entityManager
    ) {
        $this->notificationRepository = $notificationRepository;
        $this->notificationWebSocketController = $notificationWebSocketController;
        $this->entityManager = $entityManager;
    }

    public function getUserNotifications(int $userId): array
    {
        return $this->notificationRepository->findBy(
            ['userId' => $userId],
            ['timestamp' => 'DESC']
        );
    }

    public function getUnreadNotifications(int $userId): array
    {
        return $this->notificationRepository->findBy(
            ['userId' => $userId, 'read' => false],
            ['timestamp' => 'DESC']
        );
    }

    public function createNotification(int $userId, string $message): Notification
    {
        $notification = new Notification();
        $notification->setUserId($userId);
        $notification->setMessage($message);
        $notification->setRead(false);
        $notification->setTimestamp(new DateTimeImmutable());

        $this->entityManager->persist($notification);
        $this->entityManager->flush();

        $dto = [
            'id' => $notification->getId(),
            'message' => $notification->getMessage(),
            'read' => $notification->isRead(),
            'timestamp' => $notification->getTimestamp(),
        ];

        $this->notificationWebSocketController->sendNotification($userId, $dto);

        return $notification;
    }

    public function markAsRead(int $notificationId): void
    {
        $notification = $this->notificationRepository->find($notificationId);
        if ($notification) {
            $notification->setRead(true);
            $this->entityManager->flush();
        }
    }
}
