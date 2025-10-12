<?php

declare(strict_types=1);

use App\Models\User;

test('it allows creating a new scan', function () {
    $user = User::factory()->create();

    Auth::login($user);

    $page = visit(route('scans.create'));

    $page
        ->assertSee('Create a New URL Scan')
        ->assertSee('Enter a URL to scan and analyze its content for clarity, consistency, SEO-friendliness, and tone.')
        ->assertSee('URL to Scan')
        ->assertSee('Start Scan')
        ->fill('url', 'https://example.com')
        ->click('Start Scan')
        ->assertPathContains('/scans/')
        ->assertSee('URL Scan Results');
});
