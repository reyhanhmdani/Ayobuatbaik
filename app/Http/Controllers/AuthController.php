<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        // Redirect to profile if already logged in
        if (auth()->check()) {
            return redirect()->route("profile");
        }

        return view("pages.auth.login");
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            "email" => "required|email",
            "password" => "required:min:6",
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Redirect based on user role
            if (auth()->user()->is_admin) {
                return redirect()->intended("admin/dashboard");
            }

            return redirect()->intended(route("profile"));
        }

        return back()
            ->withErrors([
                "email" => "Email atau password salah.",
            ])
            ->onlyInput("email");
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect("/");
    }
}
