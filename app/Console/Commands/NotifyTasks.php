<?php

namespace App\Console\Commands;

use App\Jobs\SendTelegramNotification;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class NotifyTasks extends Command
{
    protected $signature = 'notify:tasks';
    protected $description = 'Отправить задачи пользователям в Telegram';

    public function handle()
    {
        $response = Http::get('https://jsonplaceholder.typicode.com/todos');
        $tasks = collect($response->json())
            ->where('completed', false)
            ->where('userId', '<=', 5);

        $message = "Новые задачи:\n" . $tasks->pluck('title')->implode("\n- ");

        User::where('subscribed', true)->each(function ($user) use ($message) {
            SendTelegramNotification::dispatch($user->telegram_id, $message);
        });

        $this->info("Уведомления отправлены.");
    }
}
