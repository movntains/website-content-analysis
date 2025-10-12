<?php

declare(strict_types=1);

use App\Services\ScanAnalysisService;
use Prism\Prism\Enums\FinishReason;
use Prism\Prism\Prism;
use Prism\Prism\Testing\StructuredResponseFake;
use Prism\Prism\ValueObjects\Meta;
use Prism\Prism\ValueObjects\Usage;

test('it analyzes a scan with AI', function () {
    $service = new ScanAnalysisService;

    $fakeResponse = StructuredResponseFake::make()
        ->withStructured([
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
        ])
        ->withFinishReason(FinishReason::Stop)
        ->withUsage(new Usage(10, 20))
        ->withMeta(new Meta('fake-1', 'fake-model'));

    Prism::fake([$fakeResponse]);

    $result = $service->analyze('Sample extracted content for analysis.');

    expect($result['response'])
        ->toBeArray()
        ->toHaveKeys([
            'extracted_content',
            'clarity_score',
            'consistency_score',
            'seo_score',
            'tone_score',
            'clarity_analysis',
            'consistency_analysis',
            'seo_analysis',
            'tone_analysis',
            'suggested_headlines',
            'suggested_ctas',
            'suggested_content_hierarchy',
        ])
        ->and($result['response']['extracted_content'])->toBe('Sample extracted content.')
        ->and($result['response']['clarity_score'])->toBe(85)
        ->and($result['response']['consistency_score'])->toBe(90)
        ->and($result['response']['seo_score'])->toBe(75)
        ->and($result['response']['tone_score'])->toBe(80)
        ->and($result['response']['clarity_analysis'])->toBe('Good clarity.')
        ->and($result['response']['consistency_analysis'])->toBe('Very consistent.')
        ->and($result['response']['seo_analysis'])->toBe('Needs improvement in SEO.')
        ->and($result['response']['tone_analysis'])->toBe('Appropriate tone.')
        ->and($result['response']['suggested_headlines'])->toBe(['Headline 1', 'Headline 2'])
        ->and($result['response']['suggested_ctas'])->toBe(['CTA 1', 'CTA 2'])
        ->and($result['response']['suggested_content_hierarchy'])->toBe(['H1', 'H2', 'H3'])
        ->and($result['tokens_used'])->toBe(30);
});
