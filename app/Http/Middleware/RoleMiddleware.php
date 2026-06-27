<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @param  string|null  $roles
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next, ?string $roles = null)
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('login');
        }

        if ($roles === null) {
            return $next($request);
        }

        $allowedRoles = array_map('trim', explode(',', $roles));

        if (! in_array($user->role, $allowedRoles, true)) {
            abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        return $next($request);
    }
}
