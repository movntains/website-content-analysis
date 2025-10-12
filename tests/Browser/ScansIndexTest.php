<?php

declare(strict_types=1);

use App\Models\Scan;
use App\Models\User;

test('it displays empty state if the user has no scans', function () {
    $user = User::factory()->create();

    Auth::login($user);

    $page = visit(route('scans.index'));

    $page
        ->assertSee('No Scans Yet')
        ->assertSee("You haven't scanned any URLs yet.");
});

test('it displays scans if the user has scans', function () {
    $user = User::factory()->create();
    $scan = Scan::factory()->for($user)->create();

    Auth::login($user);

    $page = visit(route('scans.index'));

    $page
        ->assertSee($scan->websiteDomain->domain_name)
        ->assertSee($scan->url)
        ->assertSee($scan->status->value)
        ->assertDontSee('No Scans Yet');
});
