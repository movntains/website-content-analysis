<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Actions\ProcessScanAction;
use App\Models\Scan;
use App\Schemas\ScanResultSchema;
use App\Services\BrowsershotService;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Prism\Prism\Enums\Provider;
use Prism\Prism\Prism;

class ProcessScanJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private readonly Scan $scan) {}

    /**
     * @throws Exception
     */
    public function handle(BrowsershotService $browsershotService, ProcessScanAction $action): void
    {
        try {
            $analysisData = $this->performAIAnalysis($browsershotService, $this->scan->url);

            /** @var array<mixed> $dataResponse */
            $dataResponse = $analysisData['response'];

            /** @var int $tokensUsed */
            $tokensUsed = $analysisData['tokens_used'];

            $action->handle($this->scan, $dataResponse, $tokensUsed);
        } catch (Exception $e) {
            $this->scan->markAsFailed($e->getMessage());

            throw $e;
        }
    }

    /**
     * @return array<string, array<mixed>|int|null>
     */
    private function performAIAnalysis(BrowsershotService $browsershotService, string $url): array
    {
        $html = $browsershotService
            ->configureBrowsershot($url)
            ->bodyHtml();

        $extractedContent = $browsershotService->extractVisibleContent($html);

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
