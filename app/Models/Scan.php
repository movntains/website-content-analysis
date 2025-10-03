<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\ScanStatus;
use App\Traits\HasUuid;
use Database\Factories\ScanFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @property string $id
 * @property string $uuid
 * @property string $user_id
 * @property string $website_domain_id
 * @property string $url
 * @property ScanStatus $status
 * @property string|null $extracted_content
 * @property float|null $clarity_score
 * @property float|null $consistency_score
 * @property float|null $seo_score
 * @property float|null $tone_score
 * @property string|null $clarity_analysis
 * @property string|null $consistency_analysis
 * @property string|null $seo_analysis
 * @property string|null $tone_analysis
 * @property array<int, string>|null $suggested_headlines
 * @property array<int, string>|null $suggested_ctas
 * @property array<int, string>|null $suggested_content_hierarchy
 * @property int|null $tokens_used
 * @property Carbon|null $processing_started_at
 * @property Carbon|null $processing_completed_at
 * @property string|null $error_message
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property User $user
 * @property WebsiteDomain $websiteDomain
 *
 * @method static Builder<static> byUuid(string $uuid)
 */
class Scan extends Model
{
    /** @use HasFactory<ScanFactory> */
    use HasFactory, HasUuid, SoftDeletes;

    /**
     * @var list<string>
     */
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

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo<WebsiteDomain, $this>
     */
    public function websiteDomain(): BelongsTo
    {
        return $this->belongsTo(WebsiteDomain::class);
    }

    /**
     * @return array<string, string>
     */
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
