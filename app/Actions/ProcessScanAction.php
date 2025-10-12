<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Scan;
use Arr;
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
                'extracted_content' => Arr::get($analysisData, 'extracted_content'),
                'clarity_score' => Arr::get($analysisData, 'clarity_score'),
                'consistency_score' => Arr::get($analysisData, 'consistency_score'),
                'seo_score' => Arr::get($analysisData, 'seo_score'),
                'tone_score' => Arr::get($analysisData, 'tone_score'),
                'clarity_analysis' => Arr::get($analysisData, 'clarity_analysis'),
                'consistency_analysis' => Arr::get($analysisData, 'consistency_analysis'),
                'seo_analysis' => Arr::get($analysisData, 'seo_analysis'),
                'tone_analysis' => Arr::get($analysisData, 'tone_analysis'),
                'suggested_headlines' => Arr::get($analysisData, 'suggested_headlines'),
                'suggested_ctas' => Arr::get($analysisData, 'suggested_ctas'),
                'suggested_content_hierarchy' => Arr::get($analysisData, 'suggested_content_hierarchy'),
                'tokens_used' => $tokensUsed,
            ]);

            $scan->markAsCompleted();
        } catch (Exception $e) {
            $scan->markAsFailed($e->getMessage());

            throw $e;
        }
    }
}
