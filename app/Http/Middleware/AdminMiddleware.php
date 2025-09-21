<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Redirect guests to login instead of showing 403
        if (!auth()->check()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }
            return redirect()->route('login')->with('error', 'Silakan login untuk mengakses halaman admin.');
        }

        $user = auth()->user();
        $isAdminByColumn = ($user->role ?? null) === 'admin';
        $isAdminBySpatie = method_exists($user, 'hasRole') ? $user->hasRole('admin') : false;

        if (!$isAdminByColumn && !$isAdminBySpatie) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Forbidden.'], 403);
            }
            // Redirect authenticated non-admins with a friendly message
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke halaman admin.');
        }

        return $next($request);
    }
}
