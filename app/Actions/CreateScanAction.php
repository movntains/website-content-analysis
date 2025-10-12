<?php

declare(strict_types=1);

namespace App\Actions;

use App\Enums\ScanStatus;
use App\Models\Scan;
use App\Models\User;
use App\Models\WebsiteDomain;

class CreateScanAction
{
    public function handle(User $user, string $url): Scan
    {
        $domain = WebsiteDomain::findOrCreateByUrl($url);

        return $user->scans()->create([
            'website_domain_id' => $domain->getKey(),
            'status' => ScanStatus::Pending,
            'url' => $url,
        ]);
    }
}
