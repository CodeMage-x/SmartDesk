<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        // Redirect if already authenticated
        if (Auth::check()) {
            return $this->redirectBasedOnRole();
        }
        
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            $user = Auth::user();
            
            if (!$user->isActive) {
                Auth::logout();
                return back()->with('error', 'Your account has been deactivated.');
            }

            $request->session()->regenerate();
            
            return $this->redirectBasedOnRole();
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('home');
    }

    private function redirectBasedOnRole()
    {
        $user = Auth::user();
        
        return match($user->role) {
            'super_admin' => redirect()->route('admin.dashboard'),
            'helpdesk_agent' => redirect()->route('agent.dashboard'),
            'end_user' => redirect()->route('user.dashboard'),
            default => redirect()->route('home')
        };
    }
}