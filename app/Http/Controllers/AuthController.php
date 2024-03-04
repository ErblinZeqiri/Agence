<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(){
        return view('auth.login');
    }

    public function dologin(LoginRequest $request) {
        $credentials = $request->validated();
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('admin.property.index');
        }
        return back()->withErrors([
            'email' => 'Identifiants incorrect'
        ])->onlyInput('email');
    }

    public function logout() {
        Auth::logout();
        return to_route('login')->with('success', 'Vous êtes déconnecté');
    }
}
