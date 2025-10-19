<?php

use GuzzleHttp\Exception\GuzzleException;

require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$botToken = $_ENV['BOT_TOKEN'];
$chatId = $_ENV['TELEGRAM_CHAT_ID'];

$requestUri = $_SERVER['REQUEST_URI'];

if ($_SERVER['REQUEST_URI'] === "/") {
    echo "Bot is already";
} elseif (str_starts_with($requestUri, "/webhook/crm")) {
    $requestBody = file_get_contents("php://input");


    file_put_contents(
        __DIR__ . "/logs/crm.log",
        $requestBody . "\n",
        FILE_APPEND
    );
}