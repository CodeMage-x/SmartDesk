<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    public function show()
    {
        return view('auth.passwords.change');
    }

   
    public function update(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password'         => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = Auth::user();
        $user->password = Hash::make($request->password);

        if (array_key_exists('must_change_password', $user->getAttributes())) {
            $user->must_change_password = false;
        }

        $user->save();


        return back()->with('success', 'Your password has been updated.');
    }
}