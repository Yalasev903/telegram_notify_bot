<?php

namespace Tests\Feature;

use App\Jobs\SendTelegramNotification;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class NotifyTasksCommandTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_dispatches_jobs_to_active_users()
    {
        Queue::fake();
        Http::fake([
            'jsonplaceholder.typicode.com/todos' => Http::response([
                ['userId' => 1, 'id' => 1, 'title' => 'Test Task 1', 'completed' => false],
                ['userId' => 6, 'id' => 2, 'title' => 'Should be ignored', 'completed' => false],
                ['userId' => 2, 'id' => 3, 'title' => 'Test Task 2', 'completed' => true],
            ])
        ]);

        $user = User::factory()->create(['telegram_id' => '123', 'subscribed' => true]);

        $this->artisan('notify:tasks')
             ->expectsOutput('Уведомления отправлены.')
             ->assertExitCode(0);

             Queue::assertPushed(SendTelegramNotification::class, function ($job) {
               return str_contains($job->getMessage(), 'Test Task');
           });
    }
}
