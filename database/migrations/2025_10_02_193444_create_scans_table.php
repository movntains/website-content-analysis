<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('scans', function (Blueprint $table): void {
            $table->id();
            $table->uuid()->unique();
            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');
            $table->foreignId('website_domain_id')
                ->constrained()
                ->onDelete('cascade');
            $table->text('url');
            $table->string('status')->default('pending');
            $table->longText('extracted_content')->nullable();

            // Scores (0-100 scale)
            $table->decimal('clarity_score', 5, 2)->nullable();
            $table->decimal('consistency_score', 5, 2)->nullable();
            $table->decimal('seo_score', 5, 2)->nullable();
            $table->decimal('tone_score', 5, 2)->nullable();

            // Analysis texts
            $table->longText('clarity_analysis')->nullable();
            $table->longText('consistency_analysis')->nullable();
            $table->longText('seo_analysis')->nullable();
            $table->longText('tone_analysis')->nullable();

            // Suggestions (stored as JSON)
            $table->json('suggested_headlines')->nullable();
            $table->json('suggested_ctas')->nullable();
            $table->json('suggested_content_hierarchy')->nullable();

            // Token usage and processing metadata
            $table->integer('tokens_used')->default(0);
            $table->timestamp('processing_started_at')->nullable();
            $table->timestamp('processing_completed_at')->nullable();
            $table->text('error_message')->nullable();

            $table->timestamps();

            $table->softDeletes();

            $table->index('user_id');
            $table->index('website_domain_id');
            $table->index('status');
            $table->index('created_at');
            $table->index(['user_id', 'website_domain_id']);
            $table->index(['website_domain_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('scans');
    }
};
