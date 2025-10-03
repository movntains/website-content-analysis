<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\HasUuid;
use Database\Factories\UserTokenLimitFactory;
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
 * @property int $monthly_token_limit
 * @property int $current_month_usage
 * @property Carbon|null $last_reset_date
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property User $user
 *
 * @method static Builder<static> byUuid(string $uuid)
 */
class UserTokenLimit extends Model
{
    /** @use HasFactory<UserTokenLimitFactory> */
    use HasFactory, HasUuid, SoftDeletes;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'monthly_token_limit',
        'current_month_usage',
        'last_reset_date',
    ];

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'last_reset_date' => 'datetime',
            'monthly_token_limit' => 'integer',
            'current_month_usage' => 'integer',
        ];
    }
}
