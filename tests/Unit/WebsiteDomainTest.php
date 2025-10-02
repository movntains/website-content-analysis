<?php

declare(strict_types=1);

use App\Models\Scan;
use App\Models\WebsiteDomain;
use Illuminate\Support\Str;

test('it automatically has a UUID generated upon model creation', function () {
    $domain = WebsiteDomain::factory()->create();

    expect($domain->getUuid())
        ->toBeString()
        ->not->toBeEmpty()
        ->and(Str::isUuid($domain->getUuid()))
        ->toBeTrue();
});

test('it soft deletes', function () {
    $domain = WebsiteDomain::factory()->create();

    $domain->delete();

    expect($domain->trashed())->toBeTrue();
});

test('it has many scans', function () {
    $domain = WebsiteDomain::factory()->create();

    Scan::factory(2)
        ->for($domain)
        ->create();

    expect($domain->scans()->count())->toBe(2);
});
