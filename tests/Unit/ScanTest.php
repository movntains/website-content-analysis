<?php

declare(strict_types=1);

use App\Models\Scan;
use App\Models\User;
use App\Models\WebsiteDomain;
use Illuminate\Support\Str;

test('it automatically has a UUID generated upon model creation', function () {
    $scan = Scan::factory()->create();

    expect($scan->getUuid())
        ->toBeString()
        ->not->toBeEmpty()
        ->and(Str::isUuid($scan->getUuid()))
        ->toBeTrue();
});

test('it soft deletes', function () {
    $scan = Scan::factory()->create();

    $scan->delete();

    expect($scan->trashed())->toBeTrue();
});

test('it belongs to a user', function () {
    $user = User::factory()->create();
    $scan = Scan::factory()
        ->for($user)
        ->create();

    expect($scan->user)->toBeInstanceOf(User::class)
        ->and($scan->user->getKey())->toBe($user->getKey());
});

test('it belongs to a website domain', function () {
    $domain = WebsiteDomain::factory()->create();
    $scan = Scan::factory()
        ->for($domain)
        ->create();

    expect($scan->websiteDomain)->toBeInstanceOf(WebsiteDomain::class)
        ->and($scan->websiteDomain->getKey())->toBe($domain->getKey());
});
