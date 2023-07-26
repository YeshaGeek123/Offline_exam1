<?php

namespace App\Http\Controllers\Auth;

use App\Models\Cubicle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use App\Http\Requests\Auth\LoginRequest;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $session = session('srta-kindle-identifier');
        if ( !empty($session) && Cubicle::where('identifier', $session)->exists()) return redirect(route('kindle-dashboard', $session));
        
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

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
                return redirect()->intended(RouteServiceProvider::HOME);
                break;
        }
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        $role = auth()->user()->role_id;
        
        if ( $role == 2 ) {
            $session = session('srta-kindle-identifier');

            Auth::guard('web')->logout();

            $request->session()->invalidate();
    
            $request->session()->regenerateToken();

            return redirect(route('kindle-dashboard', $session));
        }
        else {
            Auth::guard('web')->logout();

            $request->session()->invalidate();
    
            $request->session()->regenerateToken();

            return redirect('/');
        }
    }
}
