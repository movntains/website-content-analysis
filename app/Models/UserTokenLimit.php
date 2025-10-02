<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\HasUuid;
use Database\Factories\UserTokenLimitFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserTokenLimit extends Model
{
    /** @use HasFactory<UserTokenLimitFactory> */
    use HasFactory, HasUuid, SoftDeletes;

    protected $fillable = [
        'user_id',
        'monthly_token_limit',
        'current_month_usage',
        'last_reset_date',
    ];

    protected function casts(): array
    {
        return [
            'last_reset_date' => 'datetime',
            'monthly_token_limit' => 'integer',
            'current_month_usage' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
