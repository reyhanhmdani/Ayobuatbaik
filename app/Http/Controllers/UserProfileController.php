<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Get user's donation statistics
        $totalDonations = $user->donations()->where('status', 'success')->count();

        $totalAmount = $user->donations()->where('status', 'success')->sum('amount');

        // Get recent donations (last 10)
        $recentDonations = $user->donations()->with('program')->orderBy('created_at', 'desc')->take(10)->get();

        return view('pages.user.profile', compact('user', 'totalDonations', 'totalAmount', 'recentDonations'));
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        Auth::user()->update($request->validated());
        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        Auth::user()->update([
            'password' => Hash::make($request->new_password),
        ]);
        return back()->with('success', 'Password berhasil diubah!');
    }
}
