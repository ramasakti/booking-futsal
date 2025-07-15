<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use App\Models\MenuModel;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Tidak login → redirect / abort
        if (! $user) {
            return redirect()->route('login');
        }

        // Ambil daftar route yg diizinkan utk user ini
        $routeNames = Cache::remember(
            "allowed_routes_user_{$user->id}",
            now()->addMinutes(30),
            function () use ($user) {
                $roleIds = $user->userRole->pluck('role_id');
                return MenuModel::getRouteNamesByRoles($roleIds);
            }
        );

        // Filter jika mengandung '/' pada awal string, maka dihapus
        $routeNames->transform(fn($item) => ltrim($item, '/'));

        // Cocokkan dengan route yg sedang dipanggil
        $current = $request->route()->uri;
        $allowed = $routeNames->contains(fn($uri) => Str::startsWith($current, $uri));
        if ($allowed) {
            return $next($request);
        }

        // Tolak jika tidak di daftar
        abort(403, 'You are not authorized to access this route.');
    }
}
