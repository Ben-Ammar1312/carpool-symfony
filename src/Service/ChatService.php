<?php

namespace App\Service;

use App\DTO\ChatMessage;
use App\Entity\Chat;
use App\Entity\Message;
use App\Entity\User;
use App\Repository\ChatRepository;
use App\Repository\MessageRepository;
use App\Service\AnnonceService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\User\UserInterface;

class ChatService
{
    private ChatRepository $chatRepository;
    private MessageRepository $messageRepository;
    private AnnonceService $annonceService;
    private EntityManagerInterface $entityManager;

    public function __construct(
        ChatRepository $chatRepository,
        MessageRepository $messageRepository,
        AnnonceService $annonceService,
        EntityManagerInterface $entityManager
    ) {
        $this->chatRepository = $chatRepository;
        $this->messageRepository = $messageRepository;
        $this->annonceService = $annonceService;
        $this->entityManager = $entityManager;
    }

    /**
     * Retrieve all chats for a user.
     */
    public function getAllChatsForUser(UserInterface $user): array
    {
        $chats = $this->chatRepository->findByParticipantsContaining($user);
        foreach ($chats as $chat) {
            // Logging or debugging if needed
        }
        return $chats;
    }

    /**
     * Retrieve messages for a chat.
     */
    public function getChatMessages(int $chatId): array
    {
        $chat = $this->chatRepository->findChatWithParticipants($chatId);
        if (!$chat) {
            return [];
        }

        return array_map(function ($msg) use ($chat) {
            $dto = new ChatMessage();
            $dto->setSenderId($msg->getSender()->getId());
            $dto->setReceiverId($msg->getReceiver()->getId());
            $dto->setContent($msg->getContent());
            $dto->setTimestamp($msg->getTimestamp());
            $dto->setRideId($chat->getAnnonce()->getId());
            $dto->setSenderName($msg->getSender()->getName());
            return $dto;
        }, $chat->getMessages()->toArray());
    }

    /**
     * Retrieve or create a chat between a ride's driver and a passenger.
     */
    public function getOrCreateChat(int $rideId, User $passenger, User $driver): Chat
    {
        $chat = $this->chatRepository->findByAnnonceAndParticipant($rideId, $passenger);
        if ($chat) {
            if (!$chat->getParticipants()->contains($driver)) {
                $chat->addParticipant($driver);
                $this->entityManager->persist($chat);
                $this->entityManager->flush();
            }
            return $chat;
        } else {
            $newChat = new Chat();
            $newChat->addParticipant($passenger);
            $newChat->addParticipant($driver);
            $newChat->setAnnonce($this->annonceService->findById($rideId));
            $this->entityManager->persist($newChat);
            $this->entityManager->flush();
            return $newChat;
        }
    }

    /**
     * Save a message to a chat.
     */
    public function saveMessage(int $chatId, Message $message): Message
    {
        $chat = $this->chatRepository->find($chatId);
        if (!$chat) {
            throw new NotFoundHttpException("Chat not found");
        }

        $message->setChat($chat);
        $message->setTimestamp(new \DateTimeImmutable());
        $this->entityManager->persist($message);
        $this->entityManager->flush();

        return $message;
    }

    /**
     * Retrieve a chat by ID.
     */
    public function getChatById(int $chatId): ?Chat
    {
        return $this->chatRepository->findChatWithParticipants($chatId);
    }
}

