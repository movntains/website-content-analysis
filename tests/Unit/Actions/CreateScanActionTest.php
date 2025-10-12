<?php

declare(strict_types=1);

use App\Actions\CreateScanAction;
use App\Enums\ScanStatus;
use App\Models\Scan;
use App\Models\User;
use App\Models\WebsiteDomain;

use function Pest\Laravel\assertDatabaseHas;

test('it creates a new scan', function () {
    $user = User::factory()->create();
    $url = 'https://example.com/some-page';

    $action = new CreateScanAction;
    $scan = $action->handle($user, $url);

    expect($scan)
        ->toBeInstanceOf(Scan::class)
        ->and($scan->user_id)->toBe($user->getKey())
        ->and($scan->url)->toBe($url)
        ->and($scan->status)->toBe(ScanStatus::Pending)
        ->and($scan->websiteDomain)->toBeInstanceOf(WebsiteDomain::class)
        ->and($scan->websiteDomain->domain_name)->toBe('example.com');

    assertDatabaseHas('scans', [
        'id' => $scan->id,
        'user_id' => $user->getKey(),
        'url' => $url,
        'status' => ScanStatus::Pending,
    ]);
});
