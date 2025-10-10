<?php

declare(strict_types=1);

namespace App\Services;

use Spatie\Browsershot\Browsershot;

class BrowsershotService
{
    public function configureBrowsershot(string $url): Browsershot
    {
        $browsershot = Browsershot::url($url);

        $browsershot->addChromiumArguments([
            '--no-sandbox',
            '--disable-dev-shm-usage',
            '--disable-gpu',
            '--disable-web-security',
            '--headless',
        ]);

        $nodePath = base_path('node_modules');

        $browsershot->setNodeModulePath($nodePath);

        $browsershot->setEnvironmentOptions([
            'NODE_PATH' => $nodePath,
        ]);

        return $browsershot;
    }

    public function extractVisibleContent(string $html): string
    {
        // Remove script and style tags
        $html = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', '', $html);
        $html = preg_replace('/<style\b[^>]*>(.*?)<\/style>/is', '', (string) $html);

        // Convert HTML to plain text
        $text = strip_tags((string) $html);

        // Remove extra whitespace
        $text = preg_replace('/\s+/', ' ', $text);

        return trim((string) $text);
    }
}
