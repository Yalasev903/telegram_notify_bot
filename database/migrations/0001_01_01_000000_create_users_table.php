<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Запуск миграции.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();

            // nullable и unique telegram_id
            $table->string('telegram_id')->nullable();
            $table->unique('telegram_id');

            $table->boolean('subscribed')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Откат миграции.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
