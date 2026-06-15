<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsurePremium
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        if (! Auth::user()->isPremium()) {
            return redirect()
                ->route('membership.index')
                ->with('error', 'Fitur ini hanya tersedia untuk member premium. Silakan pilih paket membership terlebih dahulu.');
        }

        return $next($request);
    }
}
