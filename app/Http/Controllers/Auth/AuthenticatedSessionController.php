<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Check if user has role customer
        if (Auth::user()->hasRole('customer') == 1) {
            return redirect()->intended(RouteServiceProvider::HOME_CUSTOMER);
        }
        else if (Auth::user()->hasRole('admin') == 1) {
            return redirect()->intended(RouteServiceProvider::HOME_ADMIN);
        }
        else if (Auth::user()->hasRole('cook') == 1) {
            return redirect()->intended(RouteServiceProvider::HOME_COOK);
        }
        else if (Auth::user()->hasRole('driver') == 1) {
            return redirect()->intended(RouteServiceProvider::HOME_DRIVER);
        }

        // return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
