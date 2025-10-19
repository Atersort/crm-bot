<?php

use GuzzleHttp\Exception\GuzzleException;

require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$botToken = $_ENV['BOT_TOKEN'];
$chatId = $_ENV['TELEGRAM_CHAT_ID'];

