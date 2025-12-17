<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = $request->user();

        if (! $user) {
            abort(403);
        }

        // Asumsi: relasi role ada, atau minimal ada role_id (lebih bagus relasi)
        $roleName = optional($user->role)->name;

        // fallback kalau role relation belum ada:
        if (! $roleName && method_exists($user, 'role')) {
            $roleName = optional($user->role)->name;
        }

        if (! $roleName || ! in_array($roleName, $roles, true)) {
            abort(403, 'Akses ditolak.');
        }

        return $next($request);
    }
}