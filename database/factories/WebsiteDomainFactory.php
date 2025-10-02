<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\WebsiteDomain;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<WebsiteDomain>
 */
class WebsiteDomainFactory extends Factory
{
    public function definition(): array
    {
        return [
            'domain_name' => fake()->unique()->domainName(),
        ];
    }
}
