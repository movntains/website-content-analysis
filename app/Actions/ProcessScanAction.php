<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Scan;
use Exception;

class ProcessScanAction
{
    /**
     * @param  array<mixed>  $analysisData
     *
     * @throws Exception
     */
    public function handle(Scan $scan, array $analysisData, int $tokensUsed): void
    {
        $scan->markAsProcessing();

        try {
            $scan->update([
                'extracted_content' => $analysisData['extracted_content'] ?? null,
                'clarity_score' => $analysisData['clarity_score'] ?? null,
                'consistency_score' => $analysisData['consistency_score'] ?? null,
                'seo_score' => $analysisData['seo_score'] ?? null,
                'tone_score' => $analysisData['tone_score'] ?? null,
                'clarity_analysis' => $analysisData['clarity_analysis'] ?? null,
                'consistency_analysis' => $analysisData['consistency_analysis'] ?? null,
                'seo_analysis' => $analysisData['seo_analysis'] ?? null,
                'tone_analysis' => $analysisData['tone_analysis'] ?? null,
                'suggested_headlines' => $analysisData['suggested_headlines'] ?? null,
                'suggested_ctas' => $analysisData['suggested_ctas'] ?? null,
                'suggested_content_hierarchy' => $analysisData['suggested_content_hierarchy'] ?? null,
                'tokens_used' => $tokensUsed,
            ]);

            $scan->markAsCompleted();
        } catch (Exception $e) {
            $scan->markAsFailed($e->getMessage());

            throw $e;
        }
    }
}
