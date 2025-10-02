<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\ScanStatus;
use App\Models\Scan;
use App\Models\User;
use App\Models\WebsiteDomain;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Scan>
 */
class ScanFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'website_domain_id' => WebsiteDomain::factory(),
            'url' => $this->faker->url(),
            'status' => ScanStatus::Pending,
            'extracted_content' => $this->faker->randomHtml(),
            'clarity_score' => $this->faker->randomFloat(2, 0, 100),
            'consistency_score' => $this->faker->randomFloat(2, 0, 100),
            'seo_score' => $this->faker->randomFloat(2, 0, 100),
            'tone_score' => $this->faker->randomFloat(2, 0, 100),
            'clarity_analysis' => $this->faker->text(),
            'consistency_analysis' => $this->faker->text(),
            'seo_analysis' => $this->faker->text(),
            'tone_analysis' => $this->faker->text(),
            'suggested_headlines' => [$this->faker->sentence(), $this->faker->sentence()],
            'suggested_ctas' => [$this->faker->sentence(), $this->faker->sentence()],
            'suggested_content_hierarchy' => [$this->faker->sentence(), $this->faker->sentence()],
            'tokens_used' => $this->faker->numberBetween(0, 1000),
            'processing_started_at' => null,
            'processing_completed_at' => null,
            'error_message' => null,
        ];
    }

    public function processing(): static
    {
        return $this->state(fn (array $attributes): array => [
            'status' => ScanStatus::Processing,
            'processing_started_at' => now(),
            'processing_completed_at' => null,
            'error_message' => null,
        ]);
    }

    public function completed(): static
    {
        return $this->state(fn (array $attributes): array => [
            'status' => ScanStatus::Completed,
            'processing_started_at' => $attributes['processing_started_at'] ?? now()->subMinutes(5),
            'processing_completed_at' => now(),
            'error_message' => null,
        ]);
    }

    public function failed(string $errorMessage): static
    {
        return $this->state(fn (array $attributes): array => [
            'status' => ScanStatus::Failed,
            'processing_started_at' => $attributes['processing_started_at'] ?? now()->subMinutes(5),
            'processing_completed_at' => now(),
            'error_message' => $errorMessage,
        ]);
    }
}
