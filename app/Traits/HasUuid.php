<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

trait HasUuid
{
    public static function bootHasUuid(): void
    {
        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = Str::uuid()->toString();
            }
        });
    }

    public function getUuid(): ?string
    {
        return $this->getAttribute('uuid');
    }

    #[Scope]
    public function byUuid(Builder $query, string $uuid): Builder
    {
        return $query->where('uuid', '=', $uuid);
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }
}
