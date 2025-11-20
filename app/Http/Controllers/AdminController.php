<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\ProgramDonasi;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Hitung total program
        $total_programs = ProgramDonasi::count();

        // Jumlahkan semua collected_amount
        $total_amount = ProgramDonasi::sum('collected_amount');

        // Jika tabel donasi belum ada, sementara isi manual dulu
        // $total_donations = class_exists(Donasi::class) ? Donasi::count() : 0;

        // Hitung total user
        // $total_users = User::count();

        $stats = [
            'total_programs' => $total_programs,
            'total_donations' => 1250,
            'total_amount' => $total_amount,
            'total_users' => 3450,
        ];

        $recent_donations = [
            [
                'name' => 'Ahmad S.',
                'amount' => 500000,
                'program' => 'Beasiswa Santri Selfa',
                'time' => '2 jam lalu',
            ],
            [
                'name' => 'Siti M.',
                'amount' => 250000,
                'program' => 'Si Jum On The Road',
                'time' => '5 jam lalu',
            ],
            [
                'name' => 'Rina W.',
                'amount' => 100000,
                'program' => 'Wakaf Produktif',
                'time' => '1 hari lalu',
            ],
        ];
        // Ambil 3 program terbaru
        $recent_programs = ProgramDonasi::latest()
            ->take(3)
            ->get(['title', 'collected_amount', 'target_amount', 'gambar']);
        return view('pages.admin.dashboard', compact('stats', 'recent_donations', 'recent_programs'));
    }

    public function programs()
    {
        //   $programs = Program::latest()->paginate(10);
        // return view('pages.admin.programs', compact('programs'));
        return view('pages.admin.programs');
    }

    public function donasi()
    {
        $donations = Donation::with('program')->orderBy('created_at', 'desc')->paginate(15);

        return view('pages.admin.donasi.index', compact('donations'));
    }

    public function users()
    {
        return view('pages.admin.users');
    }
}
