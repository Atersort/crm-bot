<?php
declare(strict_types=1);

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Dotenv\Dotenv;

class TelegramService
{

public object $client;
public string $chatId;
public string $token;

public function __construct() {
    $this->client = new Client();
    $this->chatId = $_ENV['TELEGRAM_CHAT_ID'];
    $this->token = $_ENV['TELEGRAM_TOKEN'];
}

public function sendMessage(string $message) {
    try {
        $responce = $this->client->post("https://api.telegram.org/bot{$this->token}/sendMessage", [
            'form_params' => [
                'chat_id' => $this->chatId,
                'text' => $message,
            ]
        ]);
    } catch (GuzzleException $e) {
        file_put_contents('error.log', $e->getMessage() . PHP_EOL . "\n", FILE_APPEND);
    }
}

}