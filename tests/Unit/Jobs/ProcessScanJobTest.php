<?php

declare(strict_types=1);

use App\Actions\ProcessScanAction;
use App\Facades\BrowsershotService;
use App\Facades\ScanAnalysisService;
use App\Jobs\ProcessScanJob;
use App\Models\Scan;
use Spatie\Browsershot\Browsershot;

test('it can be queued', function () {
    Queue::fake();

    $scan = Scan::factory()->create();

    ProcessScanJob::dispatch($scan);

    Queue::assertPushed(
        ProcessScanJob::class,
        fn (ProcessScanJob $job) => $job->scan->is($scan)
    );
});

test('it handles successful execution', function () {
    $scan = Scan::factory()->create();
    $mockBrowsershot = Mockery::mock(Browsershot::class);
    $processScanActionMock = Mockery::mock(ProcessScanAction::class);

    $dataResponse = [
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

    BrowsershotService::shouldReceive('configureBrowsershot')
        ->once()
        ->with($scan->url)
        ->andReturn($mockBrowsershot);

    $mockBrowsershot->shouldReceive('bodyHtml')
        ->once()
        ->andReturn('<html><body>Test content</body></html>');

    BrowsershotService::shouldReceive('extractVisibleContent')
        ->once()
        ->with('<html><body>Test content</body></html>')
        ->andReturn('Test content');

    ScanAnalysisService::shouldReceive('analyze')
        ->once()
        ->with('Test content')
        ->andReturn([
            'response' => $dataResponse,
            'tokens_used' => 123,
        ]);

    $processScanActionMock
        ->shouldReceive('handle')
        ->once()
        ->with(
            $scan,
            $dataResponse,
            123,
        );

    new ProcessScanJob($scan)->handle($processScanActionMock);
});
