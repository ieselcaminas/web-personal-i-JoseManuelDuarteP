<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ChatController extends AbstractController
{
    #[Route('/chat', name: 'chat', methods: ['POST'])]
    public function chat(Request $request): JsonResponse
    {
        $userMessage = $request->request->get('message');

        $apiKey = ''; #Token de OpenRouter.ai aqui
        $url = 'https://openrouter.ai/api/v1/chat/completions';

        $data = [
            "model" => "openrouter/polaris-alpha",
            "messages" => [
                ["role" => "user", "content" => $userMessage]
            ]
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            "Authorization: Bearer $apiKey"
        ]);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        curl_close($ch);

        $decoded = json_decode($response, true);

        if (isset($decoded['choices'][0]['message']['content'])) {
            $botMessage = $decoded['choices'][0]['message']['content'];
        } elseif (isset($decoded['choices'][0]['content'])) {
            $botMessage = $decoded['choices'][0]['content'];
        } else {
            $botMessage = 'Error en la respuesta de la IA: ' . $response;
        }

        $botMessage = str_replace(['<｜begin▁of▁sentence｜>', '<｜end▁of▁sentence｜>', '<｜end_of_text｜>'], '', $botMessage);
        $botMessage = trim($botMessage);

        return new JsonResponse(['reply' => $botMessage]);
    }
}
