<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('website_domains', function (Blueprint $table): void {
            $table->id();
            $table->uuid()->unique();
            $table->string('domain_name')->unique();
            $table->timestamps();

            $table->softDeletes();

            $table->index('domain_name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('website_domains');
    }
};
