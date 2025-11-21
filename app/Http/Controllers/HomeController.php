<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $user = Auth::user();
            
            return match($user->role) {
                'super_admin' => redirect()->route('admin.dashboard'),
                'helpdesk_agent' => redirect()->route('agent.dashboard'),
                'end_user' => redirect()->route('user.dashboard'),
                default => abort(403)
            };
        }

        return view('home');
    }
}