<?php

declare(strict_types=1);

use App\Models\User;

test('it automatically has a UUID generated upon model creation', function () {
    $user = User::factory()->create();

    expect($user->getUuid())
        ->toBeString()
        ->not->toBeEmpty();
});
