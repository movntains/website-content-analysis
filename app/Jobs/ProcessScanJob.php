<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Actions\ProcessScanAction;
use App\Facades\BrowsershotService;
use App\Facades\ScanAnalysisService;
use App\Models\Scan;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;

class ProcessScanJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public readonly Scan $scan) {}

    /**
     * @throws Exception
     */
    public function handle(ProcessScanAction $action): void
    {
        try {
            $html = BrowsershotService::configureBrowsershot($this->scan->url)
                ->bodyHtml();

            $extractedContent = BrowsershotService::extractVisibleContent($html);

            $analysisData = ScanAnalysisService::analyze($extractedContent);

            /** @var array<mixed> $dataResponse */
            $dataResponse = Arr::get($analysisData, 'response');

            /** @var int $tokensUsed */
            $tokensUsed = Arr::get($analysisData, 'tokens_used');

            $action->handle($this->scan, $dataResponse, $tokensUsed);
        } catch (Exception $e) {
            $this->scan->markAsFailed($e->getMessage());

            throw $e;
        }
    }
}
