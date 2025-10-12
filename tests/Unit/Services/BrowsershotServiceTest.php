<?php

declare(strict_types=1);

use App\Services\BrowsershotService;
use Spatie\Browsershot\Browsershot;

test('it returns a configured Browsershot instance', function () {
    $service = new BrowsershotService;
    $url = 'https://example.com/test-page';
    $browsershot = $service->configureBrowsershot($url);

    expect($browsershot)->toBeInstanceOf(Browsershot::class);
});

test('it removes script and style tags completely', function () {
    $service = new BrowsershotService;

    $html = '<div>Content</div><script>alert("remove");</script><style>.test{color:red;}</style><p>More</p>';

    $result = $service->extractVisibleContent($html);

    expect($result)->toBe('ContentMore')
        ->and($result)->not->toContain('alert')
        ->and($result)->not->toContain('color:red');
});

test('it gracefully handles malformed HTML', function () {
    $service = new BrowsershotService;
    $html = '<div>Content<script>unclosed script<p>More content</p>';
    $result = $service->extractVisibleContent($html);

    expect($result)->toContain('Content')
        ->and($result)->toContain('More content');
});
