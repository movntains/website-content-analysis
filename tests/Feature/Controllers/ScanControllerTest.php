<?php

declare(strict_types=1);

use App\Enums\ScanStatus;
use App\Jobs\ProcessScanJob;
use App\Models\Scan;
use App\Models\User;
use Inertia\Testing\AssertableInertia;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;

test('it renders the scans index page', function () {
    $user = User::factory()->create();
    $scan = Scan::factory()
        ->completed()
        ->for($user)
        ->create();

    actingAs($user)
        ->get(route('scans.index'))
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('scans/index')
            ->has(
                'scans.data.0',
                fn (AssertableInertia $page) => $page
                    ->whereAll([
                        'uuid' => $scan->getUuid(),
                        'domainName' => $scan->websiteDomain->domain_name,
                        'url' => $scan->url,
                        'status' => $scan->status,
                        'createdAt' => $scan->created_at->toJSON(),
                    ])
            )
            ->has(
                'breadcrumbs',
                1,
                fn (AssertableInertia $page) => $page
                    ->whereAll([
                        'title' => 'Scans',
                        'href' => route('scans.index'),
                    ])
            )
        );
});

test('it renders the scans create page', function () {
    $user = User::factory()->create();

    actingAs($user)
        ->get(route('scans.create'))
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('scans/create')
        );
});

test('it stores a new scan if all request fields are valid', function () {
    Queue::fake([
        ProcessScanJob::class,
    ]);

    $user = User::factory()->create();

    actingAs($user)
        ->post(route('scans.store'), [
            'url' => 'https://example.com',
        ])
        ->assertRedirect();

    assertDatabaseHas('scans', [
        'user_id' => $user->getKey(),
        'url' => 'https://example.com',
        'status' => ScanStatus::Pending,
    ]);

    Queue::assertPushed(
        ProcessScanJob::class,
        fn (ProcessScanJob $job) => $job->scan->user_id === $user->getKey() &&
            $job->scan->url === 'https://example.com' &&
            $job->scan->status === ScanStatus::Pending
    );
});

test('it returns validation errors if the request data is invalid when storing a new scan', function () {
    $user = User::factory()->create();

    actingAs($user)
        ->post(route('scans.store'), [
            'url' => '',
        ])
        ->assertSessionHasErrors(['url']);

    actingAs($user)
        ->post(route('scans.store'), [
            'url' => 'not-a-valid-url',
        ])
        ->assertSessionHasErrors(['url']);
});
