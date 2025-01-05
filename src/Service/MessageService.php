<?php

namespace App\Service;

use App\Entity\Chat;
use App\Entity\Message;
use App\Entity\User;
use App\Repository\ChatRepository;
use App\Repository\MessageRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class MessageService
{
    private $messageRepository;
    private $chatRepository;
    private $userRepository;
    private $entityManager;

    public function __construct(
        MessageRepository $messageRepository,
        ChatRepository $chatRepository,
        UserRepository $userRepository,
        EntityManagerInterface $entityManager
    ) {
        $this->messageRepository = $messageRepository;
        $this->chatRepository = $chatRepository;
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
    }

    public function getMessagesForChat(int $chatId): array
    {
        // Récupérer les messages triés par timestamp (croissant)
        return $this->messageRepository->findBy(
            ['chat' => $chatId],
            ['timestamp' => 'ASC']
        );
    }

    public function sendMessage(int $chatId, string $messageContent, string $senderEmail): void
    {
        $chat = $this->chatRepository->find($chatId);
        if (!$chat) {
            throw new NotFoundHttpException("Chat not found");
        }

        $sender = $this->userRepository->findOneBy(['email' => $senderEmail]);
        if (!$sender) {
            throw new NotFoundHttpException("User not found");
        }

        $message = new Message();
        $message->setContent($messageContent);
        $message->setTimestamp(new \DateTime());
        $message->setChat($chat);
        $message->setSender($sender);

        $this->entityManager->persist($message);
        $this->entityManager->flush();
    }

    public function saveMessage(Message $message): void
    {
        $this->entityManager->persist($message);
        $this->entityManager->flush();
    }

    public function getMessagesByRideId(int $rideId): array
    {
        return $this->messageRepository->findBy(
            ['chat' => $rideId],
            ['timestamp' => 'ASC']
        );
    }

    public function countUnreadMessagesForUser(int $userId): int
    {
        return $this->messageRepository->countUnreadMessagesForUser($userId);
    }

    public function markAsRead(int $messageId): void
    {
        $message = $this->messageRepository->find($messageId);
        if (!$message) {
            throw new NotFoundHttpException("Message not found");
        }

        $message->setIsRead(true);
        $this->entityManager->flush();
    }

    public function markAllMessagesAsRead(int $chatId, int $userId): void
    {
        $unreadMessages = $this->messageRepository->findUnreadMessagesByChatAndUser($chatId, $userId);

        foreach ($unreadMessages as $message) {
            $message->setIsRead(true);
        }

        $this->entityManager->flush();
    }
}
