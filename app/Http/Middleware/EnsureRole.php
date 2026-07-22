<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRole
{
    /**
     * Super Admin can access everything; otherwise the user's role must be
     * in the allowed list passed as route params (role:sales_agent,media_buyer).
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (! $user || ! ($user->is_active ?? true)) {
            abort(403);
        }

        if ($user->role !== 'super_admin' && ! empty($roles) && ! in_array($user->role, $roles, true)) {
            abort(403, 'You do not have permission to view this page.');
        }

        return $next($request);
    }
}
