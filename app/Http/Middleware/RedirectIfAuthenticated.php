<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                switch (auth()->user()->role_id) {
                    case 1:
                        return redirect()->intended(route('dashboard'));
                        break;
        
                    case 2:
                        return redirect()->intended(route('evaluator-dashboard'));
                        break;
                        
                    case 3:
                        return redirect()->intended(route('assistant-dashboard'));
                        break;
                        
                    case 4:
                        return redirect()->intended(route('invigilator-dashboard'));
                        break;
                    
                    default:
                        return redirect()->intended(route('manager-dashboard'));
                        break;
                }
            }
        }

        return $next($request);
    }
}
