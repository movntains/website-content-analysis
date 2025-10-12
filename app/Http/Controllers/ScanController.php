<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\CreateScanAction;
use App\Http\Requests\Scan\StoreScanRequest;
use App\Http\Resources\ScanOverviewResource;
use App\Jobs\ProcessScanJob;
use App\Models\Scan;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class ScanController extends Controller
{
    public function index(): Response
    {
        /** @var User $user */
        $user = Auth::user();

        /** @var int $perPage */
        $perPage = config('scans.scans_per_page');

        $scans = $user
            ->scans()
            ->with(['websiteDomain'])
            ->latest()
            ->paginate($perPage);

        return Inertia::render('scans/index', [
            'scans' => ScanOverviewResource::collection($scans),
            'breadcrumbs' => [
                ['title' => 'Scans', 'href' => route('scans.index')],
            ],
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('scans/create');
    }

    public function store(StoreScanRequest $request, CreateScanAction $action): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $scan = $action->handle($user, $request->string('url')->toString());

        ProcessScanJob::dispatch($scan);

        return redirect()->route('scans.show', $scan);
    }

    public function show(Scan $scan): Response
    {
        return Inertia::render('scans/show', [
            'scan' => $scan,
        ]);
    }

    public function edit(Scan $scan): void
    {
        //
    }

    public function update(Request $request, Scan $scan): void
    {
        //
    }

    public function destroy(Scan $scan): void
    {
        //
    }
}
