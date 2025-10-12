<?php

declare(strict_types=1);

use App\Actions\ProcessScanAction;
use App\Enums\ScanStatus;
use App\Models\Scan;

test('it processes a scan', function () {
    $scan = Scan::factory()->create();
    $tokensUsed = 150;
    $analysisData = [
        'extracted_content' => 'Sample extracted content.',
        'clarity_score' => 85,
        'consistency_score' => 90,
        'seo_score' => 75,
        'tone_score' => 80,
        'clarity_analysis' => 'Good clarity.',
        'consistency_analysis' => 'Very consistent.',
        'seo_analysis' => 'Needs improvement in SEO.',
        'tone_analysis' => 'Appropriate tone.',
        'suggested_headlines' => ['Headline 1', 'Headline 2'],
        'suggested_ctas' => ['CTA 1', 'CTA 2'],
        'suggested_content_hierarchy' => ['H1', 'H2', 'H3'],
    ];

    expect($scan->status)->toBe(ScanStatus::Pending);

    $action = new ProcessScanAction;

    $action->handle($scan, $analysisData, $tokensUsed);

    expect($scan->extracted_content)->toBe('Sample extracted content.')
        ->and($scan->clarity_score)->toBe('85.00')
        ->and($scan->consistency_score)->toBe('90.00')
        ->and($scan->seo_score)->toBe('75.00')
        ->and($scan->tone_score)->toBe('80.00')
        ->and($scan->clarity_analysis)->toBe('Good clarity.')
        ->and($scan->consistency_analysis)->toBe('Very consistent.')
        ->and($scan->seo_analysis)->toBe('Needs improvement in SEO.')
        ->and($scan->tone_analysis)->toBe('Appropriate tone.')
        ->and($scan->suggested_headlines)->toBe(['Headline 1', 'Headline 2'])
        ->and($scan->suggested_ctas)->toBe(['CTA 1', 'CTA 2'])
        ->and($scan->suggested_content_hierarchy)->toBe(['H1', 'H2', 'H3'])
        ->and($scan->tokens_used)->toBe(150)
        ->and($scan->status)->toBe(ScanStatus::Completed);
});

test('it handles missing fields in the analysis data', function () {
    $scan = Scan::factory()->create();
    $tokensUsed = 150;
    $analysisData = [
        'extracted_content' => 'Sample extracted content.',
    ];

    expect($scan->status)->toBe(ScanStatus::Pending);

    $action = new ProcessScanAction;

    $action->handle($scan, $analysisData, $tokensUsed);

    expect($scan->extracted_content)->toBe('Sample extracted content.')
        ->and($scan->clarity_score)->toBeNull()
        ->and($scan->consistency_score)->toBeNull()
        ->and($scan->seo_score)->toBeNull()
        ->and($scan->tone_score)->toBeNull()
        ->and($scan->clarity_analysis)->toBeNull()
        ->and($scan->consistency_analysis)->toBeNull()
        ->and($scan->seo_analysis)->toBeNull()
        ->and($scan->tone_analysis)->toBeNull()
        ->and($scan->suggested_headlines)->toBeNull()
        ->and($scan->suggested_ctas)->toBeNull()
        ->and($scan->suggested_content_hierarchy)->toBeNull()
        ->and($scan->tokens_used)->toBe(150)
        ->and($scan->status)->toBe(ScanStatus::Completed);
});

test('it marks the scan as failed if an exception occurs', function () {
    $mock = Mockery::mock(ProcessScanAction::class);

    $mock->shouldReceive('handle')
        ->once()
        ->andThrow(new Exception('Simulated failure'));

    $scan = Scan::factory()->create();
    $tokensUsed = 150;
    $analysisData = [
        'extracted_content' => 'Sample extracted content.',
        'clarity_score' => 85,
        'consistency_score' => 90,
        'seo_score' => 75,
        'tone_score' => 80,
        'clarity_analysis' => 'Good clarity.',
        'consistency_analysis' => 'Very consistent.',
        'seo_analysis' => 'Needs improvement in SEO.',
        'tone_analysis' => 'Appropriate tone.',
        'suggested_headlines' => ['Headline 1', 'Headline 2'],
        'suggested_ctas' => ['CTA 1', 'CTA 2'],
        'suggested_content_hierarchy' => ['H1', 'H2', 'H3'],
    ];

    expect($scan->status)->toBe(ScanStatus::Pending);

    $mock->handle($scan, $analysisData, $tokensUsed);
})->throws(Exception::class, 'Simulated failure');
