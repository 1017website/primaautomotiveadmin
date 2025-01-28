<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserRole;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $roleId)
    {
        if (Auth::check()) {
            $user = Auth::user();

            if ($user->is_owner == 1) {
                return $next($request);
            }

            $hasAccess = UserRole::where('id_user', $user->id)
                ->where('id_menu', $roleId)
                ->exists();

            if ($hasAccess) {
                return $next($request);
            }

            return redirect()->route('unauthorized');
        }

        return redirect()->route('login');
    }
}
