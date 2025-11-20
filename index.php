<?php

use GuzzleHttp\Exception\GuzzleException;

require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$secretToken = $_ENV['CRM_SECRET_TOKEN'];
$receivedToken = $_GET['token'] ?? null;

$requestUri = $_SERVER['REQUEST_URI'];

if ($_SERVER['REQUEST_URI'] === "/") {
    echo "Bot is already";
} elseif (str_starts_with($requestUri, "/webhook/crm")) {

    if ($receivedToken === null || $secretToken !== $receivedToken) {
        http_response_code(403);
        echo "Error: Доступ запрещён";
        exit;
    }

    $requestBody = file_get_contents("php://input");

    file_put_contents(
        __DIR__ . "/logs/crm.log",
        $requestBody . "\n",
        FILE_APPEND
    );

    $handler = new \App\Handlers\CrmHandler($requestBody);
    $telegram = new \App\Services\TelegramService();
    $messageText = $handler->handle();
    $telegram->sendMessage($messageText);


    echo "OK\n";
} else {
    http_response_code(404);
    echo "404 Not Found";
}