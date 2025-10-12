<?php

declare(strict_types=1);

namespace App\Services;

use App\Schemas\ScanResultSchema;
use Prism\Prism\Enums\Provider;
use Prism\Prism\Prism;

class ScanAnalysisService
{
    public function analyze(string $extractedContent): array
    {
        $schema = ScanResultSchema::create();

        $response = Prism::structured()
            ->using(Provider::Gemini, 'gemini-2.5-pro')
            ->withMaxTokens(19460)
            ->withSchema($schema)
            ->withPrompt(view('prompts.website-analysis', ['content' => $extractedContent]))
            ->asStructured();

        return [
            'response' => $response->structured,
            'tokens_used' => $response->usage->promptTokens + $response->usage->completionTokens,
        ];

    }
}
