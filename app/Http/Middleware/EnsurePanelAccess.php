<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsurePanelAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user || ! $user->canAccessPanel()) {
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            abort(Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
