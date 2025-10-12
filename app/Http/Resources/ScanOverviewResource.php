<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Scan;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Scan
 */
class ScanOverviewResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->getUuid(),
            'domainName' => $this->whenLoaded('websiteDomain', fn () => $this->websiteDomain->domain_name),
            'url' => $this->url,
            'status' => $this->status,
            'createdAt' => $this->created_at,
        ];
    }
}
