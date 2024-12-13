<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class SetTelegramWebhook extends Command
{
    protected $signature = 'telegram:set-webhook';
    protected $description = 'Set Telegram webhook';

    public function handle()
    {
        // Убедитесь, что URL вебхука использует HTTPS
        $url = config('app.url') . '/telegram/webhook';

        // Токен бота
        $token = '7905536979:AAHZXb45rHvPkdpOVsj2vIjWB-8f0KEmCkA';

        // Устанавливаем вебхук
        $response = Http::withOptions([
            'verify' => false, // Указываем путь к сертификату CA
        ])->post("https://api.telegram.org/bot$token/setWebhook", [
            'url' => $url,
        ]);

        // Проверяем ответ
        if ($response->successful()) {
            $this->info('Webhook set successfully.');
        } else {
            $this->error('Failed to set webhook.');
            $this->error($response->body()); // Вывод тела ответа для дебага
        }
    }
}