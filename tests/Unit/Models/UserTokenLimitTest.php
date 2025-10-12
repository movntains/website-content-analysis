<?php

declare(strict_types=1);

use App\Models\User;
use App\Models\UserTokenLimit;
use Carbon\Carbon;
use Illuminate\Support\Str;

test('it automatically has a UUID generated upon model creation', function () {
    $tokenLimit = UserTokenLimit::factory()->create();

    expect($tokenLimit->getUuid())
        ->toBeString()
        ->not->toBeEmpty()
        ->and(Str::isUuid($tokenLimit->getUuid()))
        ->toBeTrue();
});

test('it soft deletes', function () {
    $tokenLimit = UserTokenLimit::factory()->create();

    $tokenLimit->delete();

    expect($tokenLimit->trashed())->toBeTrue();
});

test('it casts last_reset_date to a datetime', function () {
    $tokenLimit = UserTokenLimit::factory()->create([
        'last_reset_date' => '2024-01-01 12:00:00',
    ]);

    expect($tokenLimit->last_reset_date)
        ->toBeInstanceOf(Carbon::class)
        ->and($tokenLimit->last_reset_date->toDateTimeString())
        ->toBe('2024-01-01 12:00:00');
});

test('it casts monthly_token_limit and current_month_usage to integers', function () {
    $tokenLimit = UserTokenLimit::factory()->create([
        'monthly_token_limit' => '15000',
        'current_month_usage' => '5000',
    ]);

    expect($tokenLimit->monthly_token_limit)
        ->toBeInt()
        ->toBe(15000)
        ->and($tokenLimit->current_month_usage)
        ->toBeInt()
        ->toBe(5000);
});

test('it belongs to a user', function () {
    $user = User::factory()->create();

    $tokenLimit = UserTokenLimit::factory()
        ->for($user)
        ->create();

    expect($tokenLimit->user)
        ->toBeInstanceOf(User::class)
        ->and($tokenLimit->user->getUuid())
        ->toBe($user->getUuid());
});
