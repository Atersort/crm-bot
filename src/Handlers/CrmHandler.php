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

        $event = $this->data['current']['type'];

        if ($this->data['current']['created_date'] === $this->data['current']['updated_date']) {
            return "✅ **Создана новая задача:** #$id\n📝 $name";
        } else {
            return "🔄 **Обновлена задача:** #$id\n📝 $name";
        }

    }
}