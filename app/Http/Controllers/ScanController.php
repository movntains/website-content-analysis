<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Scan;
use App\Models\User;
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

        // TODO: Implement pagination
        $scans = $user->scans()->latest()->get();

        return Inertia::render('scans/index', [
            'scans' => $scans,
        ]);
    }

    public function create(): void
    {
        //
    }

    public function store(Request $request): void
    {
        //
    }

    public function show(Scan $scan): void
    {
        //
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
