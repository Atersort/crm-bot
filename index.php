<?php

use GuzzleHttp\Exception\GuzzleException;

require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$botToken = $_ENV['BOT_TOKEN'];
$chatId = $_ENV['TELEGRAM_CHAT_ID'];
$secretToken = $_ENV['CRM_SECRET_TOKEN'];
$receivedToken = $_GET['token'] ?? null;

$requestUri = $_SERVER['REQUEST_URI'];

if ($_SERVER['REQUEST_URI'] === "/") {
    echo "Bot is already";
} elseif (str_starts_with($requestUri, "/webhook/crm")) {

    if ($receivedToken === null || $secretToken !== $receivedToken) {
        http_response_code(403);
        echo "Error: Access Forbidden";
        exit;
    }

    $requestBody = file_get_contents("php://input");

    file_put_contents(
        __DIR__ . "/logs/crm.log",
        $requestBody . "\n",
        FILE_APPEND
    );

    $data = json_decode($requestBody, true);

    if (empty($data)) {
        http_response_code(400);
        echo "Error: Empty message";
        exit;
    }

    $event = $data['event'];
    $messageText = match ($event) {
        'task_updated' => "🔥 **Обновлена задача**: #{$data['task_id']} - {$data['title']}",
        default => "получено неизвестное событие:" . $event,

    };

    try {
        $client = new GuzzleHttp\Client();
        $response = $client->post('https://api.telegram.org/bot' . $botToken . '/sendMessage', [
            'form_params' => [
                'chat_id' => $chatId,
                'text' => $messageText,
                'parse_mode' => 'Markdown',
            ]
        ]);
    } catch (GuzzleException $e) {
        file_put_contents(
            __DIR__ . '/logs/crm.log',
            $e->getMessage() . PHP_EOL . "\n",
            FILE_APPEND
        );
    }

    echo "OK\n";
} else {
    http_response_code(404);
    echo "404 Not Found";
}