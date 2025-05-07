<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Http;

class SendTelegramNotification implements ShouldQueue
{
    use Dispatchable, Queueable;

    protected $chatId;
    protected $message;

    public function __construct($chatId, $message)
    {
        $this->chatId = $chatId;
        $this->message = $message;
    }

    public function handle(): void
    {
        Http::post("https://api.telegram.org/bot" . env('TELEGRAM_BOT_TOKEN') . "/sendMessage", [
            'chat_id' => $this->chatId,
            'text' => $this->message
        ]);
    }
    public function getMessage()
    {
        return $this->message;
    }
}

