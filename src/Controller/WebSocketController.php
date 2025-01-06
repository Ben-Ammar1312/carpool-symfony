<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class WebSocketController extends AbstractController
{
    /**
     * @Route("/ws", name="websocket_endpoint")
     */
    public function websocket(): JsonResponse
    {
        return new JsonResponse(['status' => 'WebSocket endpoint is ready']);
    }
}
