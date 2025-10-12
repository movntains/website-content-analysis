<?php

declare(strict_types=1);

use App\Enums\ScanStatus;
use App\Models\Scan;
use App\Models\User;
use App\Models\WebsiteDomain;
use Carbon\Carbon;
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

test('it marks the scan as processing', function () {
    $scan = Scan::factory()->create();

    expect($scan->status)->toBe(ScanStatus::Pending)
        ->and($scan->processing_started_at)->toBeNull();

    $scan->markAsProcessing();

    expect($scan->status)->toBe(ScanStatus::Processing)
        ->and($scan->processing_started_at)->toBeInstanceOf(Carbon::class);
});

test('it marks the scan as completed', function () {
    $scan = Scan::factory()->create();

    expect($scan->status)->toBe(ScanStatus::Pending)
        ->and($scan->processing_completed_at)->toBeNull();

    $scan->markAsCompleted();

    expect($scan->status)->toBe(ScanStatus::Completed)
        ->and($scan->processing_completed_at)->toBeInstanceOf(Carbon::class);
});

test('it marks the scan as failed', function () {
    $scan = Scan::factory()->create();

    expect($scan->status)->toBe(ScanStatus::Pending)
        ->and($scan->processing_completed_at)->toBeNull()
        ->and($scan->error_message)->toBeNull();

    $scan->markAsFailed('Something went wrong.');

    expect($scan->status)->toBe(ScanStatus::Failed)
        ->and($scan->processing_completed_at)->toBeInstanceOf(Carbon::class)
        ->and($scan->error_message)->toBe('Something went wrong.');
});
