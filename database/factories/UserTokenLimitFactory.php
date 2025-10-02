<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\User;
use App\Models\UserTokenLimit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<UserTokenLimit>
 */
class UserTokenLimitFactory extends Factory
{
    public function definition(): array
    {
        $monthlyLimit = $this->faker->numberBetween(10000, 200000);

        return [
            'user_id' => User::factory(),
            'monthly_token_limit' => $monthlyLimit,
            'current_month_usage' => $this->faker->numberBetween(0, $monthlyLimit),
            'last_reset_date' => $this->faker->dateTimeBetween('-1 year'),
        ];
    }
}
