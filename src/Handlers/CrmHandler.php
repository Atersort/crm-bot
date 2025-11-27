<?php
declare(strict_types=1);

namespace App\Handlers;

use Dotenv\Dotenv;

class CrmHandler
{
    public array $data;

    public function __construct($requestBody)
    {
        $this->data = json_decode($requestBody, true);
    }

    public function handle(): array
    {
        $users = require dirname(__DIR__) . '/Config/users.php';
        $statuses = require dirname(__DIR__) . '/Config/config.php';

        if (empty($this->data['current'])) {
            http_response_code(400);
            return "Ошибка: пустые данные";
        }

        $id = $this->data['current']['id'];
        $name = $this->data['current']['name'];
        $id_task = $this->data['current']['id'];
        $responsibleId = $this->data['current']['responsible_id'];
        $statusId = $this->data['current']['status'];

        $chatId = $users[$responsibleId] ?? $_ENV['TELEGRAM_CHAT_ID_ADMIN'];
        $statusName = $statuses[$statusId] ?? "Статус: $statusId";

        $created_date = $this->data['current']['created_date'];
        $updated_date = $this->data['current']['updated_date'];

        $event = $this->data['current']['type'];

        if ($created_date === $updated_date) {
            $text = "✅ **Новая задача:** #$id\n📝 $name \n url: [Ссылка](https://6k4cmc691.aspro.cloud/_module/task/view/task/$id_task)\n 📂 Статус: $statusName
            " ;
        } else {
            $text = "🔄 Задача обновлена: #$id\n📝 $name \nurl: [Ссылка](https://6k4cmc691.aspro.cloud/_module/task/view/task/$id_task)\nСтатус: $statusName";
        }

        return [
            'chat_id' => $chatId,
            'text' => $text
        ];
    }
}