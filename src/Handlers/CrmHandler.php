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
            return "Ошибка: пустые данные";
        }

        $id = $this->data['current']['id'];
        $name = $this->data['current']['name'];
        $id_task = $this->data['current']['id'];

        $created_date = $this->data['current']['created_date'];
        $updated_date = $this->data['current']['updated_date'];

        $event = $this->data['current']['type'];

        if ($created_date === $updated_date) {
            return "✅ **Создана новая задача:** #$id\n📝 $name\n url: [Ссылка](https://6k4cmc691.aspro.cloud/_module/task/view/task/$id_task)
            " ;
        } else {
            return "🔄 **Обновлена задача:** #$id\n📝 $name";
        }

    }
}