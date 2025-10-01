<?php

declare(strict_types=1);

use App\Models\User;
use App\Models\UserTokenLimit;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;

test('it automatically has a UUID generated upon model creation', function () {
    $user = User::factory()->create();

    expect($user->getUuid())
        ->toBeString()
        ->not->toBeEmpty()
        ->and(Str::isUuid($user->getUuid()))
        ->toBeTrue();
});

test('it soft deletes', function () {
    $user = User::factory()->create();

    $user->delete();

    expect($user->trashed())->toBeTrue();
});

test('it has one token limit', function () {
    $user = User::factory()->create();

    $tokenLimit = UserTokenLimit::factory()
        ->for($user)
        ->create();

    $user->refresh();

    expect($user->tokenLimit)
        ->toBeInstanceOf(UserTokenLimit::class)
        ->and($user->tokenLimit->getUuid())
        ->toBe($tokenLimit->getUuid());
});

test('it cannot have more than one token limit', function () {
    $user = User::factory()->create();

    UserTokenLimit::factory()->for($user)->create();

    expect(fn () => UserTokenLimit::factory()->for($user)->create())
        ->toThrow(QueryException::class);
});
