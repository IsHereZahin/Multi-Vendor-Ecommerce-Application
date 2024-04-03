<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Status
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $status)
    {
        // Get the authenticated user
        $user = Auth::user();

        // Check if the user is authenticated
        if ($user) {
            // Check user role and status
            if ($user->role === 'admin' && $user->status !== $status) {
                return redirect('admin/dashboard');
            } elseif ($user->role === 'vendor' && $user->status !== $status) {
                return redirect('vendor/dashboard');
            } elseif ($user->role === 'user' && $user->status !== $status) {
                return redirect('dashboard');
            }
        }

        // If user is not authenticated or the status matches, proceed with the request
        return $next($request);
    }
}
