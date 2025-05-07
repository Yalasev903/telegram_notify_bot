<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class TelegramWebhookTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_stores_user_on_start_command(): void
    {
        $payload = [
            'message' => [
                'chat' => [
                    'id' => 123456789,
                    'first_name' => 'TestUser',
                ],
                'text' => '/start',
            ],
        ];

        $response = $this->postJson('/api/webhook', $payload);
        $response->assertJson(['status' => 'ok']);

        $this->assertDatabaseHas('users', [
            'telegram_id' => '123456789',
            'name' => 'TestUser',
            'subscribed' => true,
        ]);
    }

    #[Test]
    public function it_unsubscribes_user_on_stop_command(): void
    {
        User::create([
            'name' => 'TestUser',
            'telegram_id' => '123456789',
            'subscribed' => true,
        ]);

        $payload = [
            'message' => [
                'chat' => [
                    'id' => 123456789,
                    'first_name' => 'TestUser',
                ],
                'text' => '/stop',
            ],
        ];

        $response = $this->postJson('/api/webhook', $payload);
        $response->assertJson(['status' => 'ok']);

        $this->assertDatabaseHas('users', [
            'telegram_id' => '123456789',
            'subscribed' => false,
        ]);
    }
}
