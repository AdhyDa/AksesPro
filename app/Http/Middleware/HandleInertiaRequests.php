<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     * Points to resources/views/app.blade.php (the Inertia root template).
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     * Used by Inertia to detect asset changes and force a full reload.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define props shared globally with EVERY Inertia page component.
     *
     * These values are available in any JSX page via:
     *   const { auth, flash, ziggy } = usePage().props;
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),

            // ── Auth: User data (safe serialization) ─────────────────
            'auth' => [
                'user' => $request->user() ? [
                    'id'     => $request->user()->id,
                    'name'   => $request->user()->name,
                    'email'  => $request->user()->email,
                    'role'   => $request->user()->role,
                    'points' => $request->user()->points ?? 0,
                ] : null,
            ],

            // ── Flash messages: success / error / warning ─────────────
            // Tersedia di React via: const { flash } = usePage().props;
            'flash' => [
                'success' => fn () => $request->session()->get('success'),
                'error'   => fn () => $request->session()->get('error'),
                'warning' => fn () => $request->session()->get('warning'),
            ],

            // ── CSRF Token ──
            'csrf_token' => csrf_token(),
        ];
    }
}
