<?php
declare(strict_types=1);

namespace App\Handlers;

class CrmHandler
{
    public array $data;

    public function __construct($requestBody)
    {
        $this->data = json_decode($requestBody, true);
    }

    public function handle(): string
    {
        if (empty($this->data['current'])) {
            http_response_code(400);
            echo 'Current not set';
            exit;
        }

        $id = $this->data['current']['id'];
        $name = $this->data['current']['name'];

        $event = $this->data['current']['type'];
        $messageText = match ($event) {
            0 => "Создана новая задача $id и с именем $name",
            default => "статус задачи неизвестен"
        };

        return $messageText;

    }
}