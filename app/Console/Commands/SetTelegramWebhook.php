<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class SetTelegramWebhook extends Command
{
    protected $signature = 'webhook:set';
    protected $description = 'Установить webhook Telegram на текущий APP_URL';

    public function handle(): void
    {
        $botToken = env('TELEGRAM_BOT_TOKEN');
        $url = rtrim(env('APP_URL'), '/') . '/api/webhook';

        if (!$botToken || !$url) {
            $this->error("Не указан TELEGRAM_BOT_TOKEN или APP_URL в .env");
            return;
        }

        $api = "https://api.telegram.org/bot{$botToken}/setWebhook";

        $response = Http::asForm()->post($api, [
            'url' => $url
        ]);

        $json = $response->json();

        if ($response->ok() && $json['ok']) {
            $this->info("Webhook установлен: {$url}");
        } else {
            $this->error("Ошибка при установке webhook: " . json_encode($json));
        }
    }
}
