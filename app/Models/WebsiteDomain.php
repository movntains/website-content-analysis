<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\HasUuid;
use Database\Factories\WebsiteDomainFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use InvalidArgumentException;
use Throwable;

/**
 * @property string $id
 * @property string $uuid
 * @property string $domain_name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property Collection<int, Scan> $scans
 *
 * @method static Builder<static> byUuid(string $uuid)
 */
class WebsiteDomain extends Model
{
    /** @use HasFactory<WebsiteDomainFactory> */
    use HasFactory, HasUuid, SoftDeletes;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'domain_name',
    ];

    /**
     * @throws Throwable
     */
    public static function findOrCreateByUrl(string $url): self
    {
        $host = parse_url($url, PHP_URL_HOST);

        throw_if($host === false || $host === null, new InvalidArgumentException("Invalid URL provided: {$url}"));

        $domain = preg_replace('/^www\./i', '', $host);

        return static::query()->firstOrCreate([
            'domain_name' => $domain,
        ]);
    }

    /**
     * @return HasMany<Scan, $this>
     */
    public function scans(): HasMany
    {
        return $this->hasMany(Scan::class);
    }
}
