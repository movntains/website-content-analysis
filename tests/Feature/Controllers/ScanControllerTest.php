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

test('it renders the scans show page', function () {
    $user = User::factory()->create();
    $scan = Scan::factory()
        ->for($user)
        ->create();

    actingAs($user)
        ->get(route('scans.show', [
            'scan' => $scan,
        ]))
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('scans/show')
            ->has(
                'scan',
                fn (AssertableInertia $page) => $page
                    ->whereAll([
                        'uuid' => $scan->getUuid(),
                        'url' => $scan->url,
                        'status' => $scan->status,
                        'createdAt' => $scan->created_at->toJSON(),
                        'scores' => [
                            'clarity' => $scan->clarity_score,
                            'consistency' => $scan->consistency_score,
                            'seo' => $scan->seo_score,
                            'tone' => $scan->tone_score,
                        ],
                        'analysis' => [
                            'clarity' => $scan->clarity_analysis,
                            'consistency' => $scan->consistency_analysis,
                            'seo' => $scan->seo_analysis,
                            'tone' => $scan->tone_analysis,
                        ],
                        'suggestions' => [
                            'headlines' => $scan->suggested_headlines,
                            'ctas' => $scan->suggested_ctas,
                            'hierarchy' => $scan->suggested_content_hierarchy,
                        ],
                    ])
            )
            ->has('breadcrumbs', 2)
            ->has(
                'breadcrumbs.0',
                fn (AssertableInertia $page) => $page
                    ->whereAll([
                        'title' => 'Scans',
                        'href' => route('scans.index'),
                    ])
            )
            ->has(
                'breadcrumbs.1',
                fn (AssertableInertia $page) => $page
                    ->whereAll([
                        'title' => 'Scan Results',
                        'href' => route('scans.show', ['scan' => $scan]),
                    ])
            )
        );
});

test("a user cannot view another user's scan results", function () {
    $user = User::factory()->create();
    $scan = Scan::factory()
        ->for($user)
        ->create();

    actingAs(User::factory()->create())
        ->get(route('scans.show', [
            'scan' => $scan,
        ]))
        ->assertForbidden();
});
