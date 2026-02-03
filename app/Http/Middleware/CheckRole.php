<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $userRole = auth()->user()->role;

        // Map generic 'operator' to both operator types for backward compatibility
        $expandedRoles = [];
        foreach ($roles as $role) {
            if ($role === 'operator') {
                $expandedRoles[] = 'operator-asset';
                $expandedRoles[] = 'operator-letter';
            } else {
                $expandedRoles[] = $role;
            }
        }

        if (!in_array($userRole, $expandedRoles)) {
            abort(404);
        }

        return $next($request);
    }
}
