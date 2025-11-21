<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\ProgramDonasi;
use Illuminate\Http\Request;

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

    public function donasi(Request $request)
    {
        // 1. Ambil data Program Donasi (untuk dropdown filter)
        $programs = ProgramDonasi::orderBy('title', 'asc')->get(['id', 'title']);

        // 2. Mendapatkan parameter dari request
        $search = $request->get('search');
        $status = $request->get('status');
        $programId = $request->get('program_id'); // Parameter BARU
        $perPage = $request->get('perPage', 15);

        $donations = Donation::with('program')
            ->orderBy('created_at', 'desc')
            ->when($search, function ($query, $search) {
                // Filter berdasarkan kode donasi, nama donatur, atau email
                $query->where('donation_code', 'like', '%' . $search . '%')
                      ->orWhere('donor_name', 'like', '%' . $search . '%')
                      ->orWhere('donor_email', 'like', '%' . $search . '%');
            })
            ->when($status, function ($query, $status) {
                if ($status === 'failed') {
                    // Mengelompokkan status gagal, expired, dan cancel
                    $query->whereIn('status', ['failed', 'expire', 'cancel']);
                } else {
                    // Filter status spesifik
                    $query->where('status', $status);
                }
            })
            // 3. Filter BERDASARKAN PROGRAM (BARU)
            ->when($programId, function ($query, $programId) {
                $query->where('program_donasi_id', $programId);
            })
            ->paginate($perPage)
            ->withQueryString(); // Memastikan parameter filter tetap ada di link pagination

        return view('pages.admin.donasi.index', compact('donations', 'programs'));
    }

    public function users()
    {
        return view('pages.admin.users');
    }
}
