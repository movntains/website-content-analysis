<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\ScanStatus;
use App\Traits\HasUuid;
use Database\Factories\ScanFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Scan extends Model
{
    /** @use HasFactory<ScanFactory> */
    use HasFactory, HasUuid, SoftDeletes;

    protected $fillable = [
        'user_id',
        'website_domain_id',
        'url',
        'status',
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
        'tokens_used',
        'processing_started_at',
        'processing_completed_at',
        'error_message',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function websiteDomain(): BelongsTo
    {
        return $this->belongsTo(WebsiteDomain::class);
    }

    protected function casts(): array
    {
        return [
            'status' => ScanStatus::class,
            'clarity_score' => 'decimal:2',
            'consistency_score' => 'decimal:2',
            'seo_score' => 'decimal:2',
            'tone_score' => 'decimal:2',
            'suggested_headlines' => 'array',
            'suggested_ctas' => 'array',
            'suggested_content_hierarchy' => 'array',
            'tokens_used' => 'integer',
            'processing_started_at' => 'datetime',
            'processing_completed_at' => 'datetime',
        ];
    }
}
