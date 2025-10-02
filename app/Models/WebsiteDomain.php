<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\HasUuid;
use Database\Factories\WebsiteDomainFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class WebsiteDomain extends Model
{
    /** @use HasFactory<WebsiteDomainFactory> */
    use HasFactory, HasUuid, SoftDeletes;

    protected $fillable = [
        'domain_name',
    ];

    public function scans(): HasMany
    {
        return $this->hasMany(Scan::class);
    }
}
