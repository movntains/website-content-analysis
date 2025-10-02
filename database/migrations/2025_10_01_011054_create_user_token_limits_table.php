<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_token_limits', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->foreignId('user_id')
                ->unique()
                ->constrained()
                ->onDelete('cascade');
            $table->integer('monthly_token_limit')->default(10000);
            $table->integer('current_month_usage')->default(0);
            $table->dateTime('last_reset_date')->default(now()->toDateString());
            $table->timestamps();
            $table->softDeletes();

            $table->index('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_token_limits');
    }
};
