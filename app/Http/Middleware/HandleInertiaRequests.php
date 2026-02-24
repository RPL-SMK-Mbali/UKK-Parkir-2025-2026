<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Illuminate\Support\Facades\Auth;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $menus = [];
        if (Auth::check()) {
            $user = Auth::user();
            if($user->role == 'petugas') {
                $menus = [
                    [
                        'name' => 'Parkir',
                        'route' => 'transactions.',
                        'active' => '*',
                    ],
                ];
            } else if($user->role == 'admin') {
                $menus = [
                    [
                        'name' => 'User',
                        'route' => 'users.',
                        'active' => '*',
                    ],
                    [
                        'name' => 'Tarif Parkir',
                        'route' => 'rates.',
                        'active' => '*',
                    ],
                    [
                        'name' => 'Area Parkir',
                        'route' => 'parking_areas.',
                        'active' => '*',
                    ]
                ];
            } else if($user->role == 'owner') {
                $menus = [
                    [
                        'name' => 'Laporan Transaksi',
                        'route' => 'reports.',
                        'active' => '*',
                    ]
                ];
            }
        }

        return [
            ...parent::share($request),
            'menus' => $menus
        ];
    }
}
