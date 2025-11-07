<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Scan;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Scan
 */
class ScanDetailsResource extends JsonResource
{
    public static $wrap = null;

    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->getUuid(),
            'url' => $this->url,
            'status' => $this->status,
            'createdAt' => $this->created_at,
            'scores' => [
                'clarity' => $this->clarity_score,
                'consistency' => $this->consistency_score,
                'seo' => $this->seo_score,
                'tone' => $this->tone_score,
            ],
            'analysis' => [
                'clarity' => $this->clarity_analysis,
                'consistency' => $this->consistency_analysis,
                'seo' => $this->seo_analysis,
                'tone' => $this->tone_analysis,
            ],
        ];
    }
}
