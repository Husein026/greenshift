<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

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

            $credetials = [
                'email' => $request->email,
                'password' => $request->password,
            ];
            if(Auth::attempt($credetials)){
                
                $user = Auth::user();

                if ($user->FKRoleId === 2) {
                    return redirect('/dashboard');
                } elseif ($user->FKRoleId === 3) {
                    return redirect('/packages');
                } elseif ($user->FKRoleId === 1) {
                    return redirect('/agendainstructor'); 
                }
            }
            return back()->with('message', 'email or wachtwoord is wrong');

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
