<?php

declare(strict_types=1);

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
