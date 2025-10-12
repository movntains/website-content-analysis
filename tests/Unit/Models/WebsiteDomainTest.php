<?php

declare(strict_types=1);

use App\Models\Scan;
use App\Models\WebsiteDomain;
use Illuminate\Support\Str;

use function Pest\Laravel\assertDatabaseHas;

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

test('it finds by URL', function () {
    $domainName = 'example.com';

    WebsiteDomain::factory()->create([
        'domain_name' => $domainName,
    ]);

    $domain = WebsiteDomain::findOrCreateByUrl("https://www.{$domainName}/some/path");

    expect($domain)
        ->toBeInstanceOf(WebsiteDomain::class)
        ->and($domain->domain_name)->toBe($domainName);
});

test('it creates by URL if not found', function () {
    $domainName = 'newdomain.com';

    $domain = WebsiteDomain::findOrCreateByUrl("https://{$domainName}");

    expect($domain)->toBeInstanceOf(WebsiteDomain::class)
        ->and($domain->domain_name)->toBe($domainName);

    assertDatabaseHas('website_domains', [
        'domain_name' => $domainName,
    ]);
});

test('it has many scans', function () {
    $domain = WebsiteDomain::factory()->create();

    Scan::factory(2)
        ->for($domain)
        ->create();

    expect($domain->scans()->count())->toBe(2);
});
