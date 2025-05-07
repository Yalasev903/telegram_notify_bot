<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class TelegramController extends Controller
{
    public function webhook(Request $request)
    {
        Log::info('Webhook received', $request->all());

        $message = $request->input('message');
        if (!$message) {
            return response()->json(['status' => 'not a message update']);
        }

        $chat = $message['chat'] ?? null;
        $chatId = $chat['id'] ?? null;
        $text = trim($message['text'] ?? '');

        // 🛡 Защита: если chatId или текст отсутствует
        if (empty($chatId) || empty($text)) {
            Log::warning('Invalid Telegram message structure', $message);
            return response()->json(['status' => 'invalid structure']);
        }

        // /start — подписка
        if ($text === '/start') {

          Log::info('Parsed chat_id', ['chat_id' => $chatId, 'chat' => $chat]);

          User::updateOrCreate(
               ['telegram_id' => (string) $chatId],
               [
                   'name' => $chat['first_name'] ?? 'User',
                   'subscribed' => true,
               ]
           );
            $this->sendMessage($chatId, "Ви підписані на оновлення.");
        }

        // /stop — отписка
        if ($text === '/stop') {
            User::where('telegram_id', (string) $chatId)->update([
                'subscribed' => false
            ]);
            $this->sendMessage($chatId, "Ви відписані від оновлень.");
        }

        return response()->json(['status' => 'ok']);
    }

    private function sendMessage($chatId, $text)
    {
        $token = env('TELEGRAM_BOT_TOKEN');
        $url = "https://api.telegram.org/bot{$token}/sendMessage";

        $response = Http::post($url, [
            'chat_id' => $chatId,
            'text' => $text,
        ]);

        Log::info('Telegram response', $response->json());
    }
}
