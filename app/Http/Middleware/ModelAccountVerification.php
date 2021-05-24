<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ModelAccountVerification
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        dd($request);
        if (isset(session()->get('account')->id) and session()->get('account')->id != $act) {
            Auth::logout();
            session()->invalidate();
            session()->regenerateToken();
            session()->flash('redirect');
        }
        return $next($request);
    }
}
