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
        $url = config('app.url') . '/telegram/webhook';
        $token = '7905536979:AAHZXb45rHvPkdpOVsj2vIjWb-8f0KEmCkA';
        $response = Http::withOptions([
            'verify' => false,
        ])->post("https://api.telegram.org/bot$token/setWebhook", [
                    'url' => $url,
                ]);

        if ($response->successful()) {
            $this->info('Webhook set successfully.');
        } else {
            $this->error('Failed to set webhook.');
            $this->error($response->body()); // Вывод тела ответа для дебага
        }
    }
}