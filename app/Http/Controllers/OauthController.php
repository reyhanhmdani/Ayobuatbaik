<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Str;

class OauthController extends Controller
{
    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleProviderCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Cari user berdasarkan Google ID ATAU Email
            $finduser = User::where('gauth_id', $googleUser->id)->orWhere('email', $googleUser->email)->first();

            if ($finduser) {
                // Update gauth_id jika belum ada
                if (empty($finduser->gauth_id)) {
                    $finduser->gauth_id = $googleUser->id;
                    $finduser->gauth_type = 'google';
                    $finduser->save();
                }

                // Cek admin
                if ($finduser->is_admin) {
                    Auth::login($finduser);
                    return redirect()->intended('admin/dashboard');
                } else {
                    Auth::logout();
                    return redirect()->route('login')->with('error', 'Akses ditolak. Akun Google Anda bukan administrator.');
                }
            }

            // User belum terdaftar → buat user baru
            $newUser = User::create([
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'gauth_id' => $googleUser->id,
                'gauth_type' => 'google',
                'is_admin' => false,
                'email_verified_at' => now(),
                'password' => Hash::make(Str::random(16)),
            ]);

            return redirect()->route('login')->with('error', 'Akun Google Anda baru terdaftar, namun bukan admin.');
        } catch (\Exception $e) {
            \Log::error('Google OAuth Error: ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'Gagal login dengan Google');
        }
    }
}
