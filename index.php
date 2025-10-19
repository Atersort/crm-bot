<?php

use GuzzleHttp\Exception\GuzzleException;

require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$botToken = $_ENV['BOT_TOKEN'];
$chatId = $_ENV['TELEGRAM_CHAT_ID'];
$sendMessage = "Привет, я первое сообщение из бота";

try {

    $client = new \GuzzleHttp\Client();

    $response = $client->post('https://api.telegram.org/bot' . $botToken . "/sendMessage", [
        'form_params' => [
            'chat_id' => $chatId,
            'text' => $sendMessage,
        ]
    ]);

    echo $chatId;
    echo "<br>";
    echo "Статус ответа: " . $response->getStatusCode();
    echo "<br>";
    echo "Тело ответа: " . $response->getBody();

} catch (GuzzleException $e) {
    echo $e->getMessage();
}

