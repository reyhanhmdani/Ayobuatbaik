<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Get user's donation statistics
        $totalDonations = $user->donations()->where("status", "success")->count();

        $totalAmount = $user->donations()->where("status", "success")->sum("amount");

        // Get recent donations (last 10)
        $recentDonations = $user->donations()->with("program")->orderBy("created_at", "desc")->take(10)->get();

        return view("pages.user.profile", compact("user", "totalDonations", "totalAmount", "recentDonations"));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            "name" => "required|string|max:255",
            "email" => "required|email|max:255|unique:users,email," . $user->id,
        ]);

        $user->update($validated);

        return back()->with("success", "Profil berhasil diperbarui!");
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            "current_password" => "required",
            "new_password" => "required|min:6|confirmed",
        ]);

        $user = Auth::user();

        // Verify current password
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(["current_password" => "Password saat ini salah."]);
        }

        // Update password
        $user->update([
            "password" => Hash::make($request->new_password),
        ]);

        return back()->with("success", "Password berhasil diubah!");
    }
}
