<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\ProgramDonasi;
use App\Models\User;
use Cache;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Hitung total program
        $total_programs = ProgramDonasi::count();

        // Jumlahkan semua collected_amount
        $total_amount = ProgramDonasi::sum('collected_amount');

        $total_donations = Donation::count();

        // Hitung total user
        // $total_users = User::count();

        $stats = Cache::remember('dashboard_stats', 300, function () {
            return [
                'total_programs' => ProgramDonasi::count(),
                'total_donations' => Donation::count(),
                'total_amount' => ProgramDonasi::sum('collected_amount'),
                'total_users' => User::count(),
            ];
        });

        $recent_donations_query = Donation::latest()->with('program')->take(3)->get();

        $recent_donations = $recent_donations_query->map(function ($donations) {
            return [
                'donor_name' => $donations->donor_name,
                'amount' => $donations->amount,
                'time' => $donations->created_at->diffForHumans(),
                'program' => $donations->program ? $donations->program->title : 'Unknown Program',
            ];
        });

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
                $query
                    ->where('donation_code', 'like', '%' . $search . '%')
                    ->orWhere('donor_name', 'like', '%' . $search . '%')
                    ->orWhere('donor_email', 'like', '%' . $search . '%');
            })
            ->when($status, function ($query, $status) {
                if ($status === 'failed') {
                    // Mengelompokkan status gagal, expired, dan unpaid
                    $query->whereIn('status', ['failed', 'expire', 'unpaid']);
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

    public function pageStoreManualDonasi(Request $request)
    {
        $programs = ProgramDonasi::where('status', 'active')
            ->orderBy('title', 'asc')
            ->get(['id', 'title']);

        return view('pages.admin.donasi.store_manual', compact('programs'));
    }

    public function storeManualDonasi(Request $request)
    {
        // Validasi Input
        $validated = $request->validate([
            'program_donasi_id' => 'required|exists:program_donasi,id',
            'donor_name' => 'required|string|max:255',
            'donor_phone' => 'required|string|max:20',
            'donor_email' => 'nullable|email|max:255',
            'amount' => 'required|numeric|min:1000',
            'note' => 'nullable|string',
            'donation_type' => 'nullable|string',
        ]);

        // Generate kode donasi unik
        $donationCode = 'MANUAL-' . strtoupper(uniqid());

        // langsung sukses
        $donation = Donation::create([
            'donation_code' => $donationCode,
            'program_donasi_id' => $validated['program_donasi_id'],
            'donor_name' => $validated['donor_name'],
            'donor_phone' => $validated['donor_phone'],
            'donor_email' => $validated['donor_email'],
            'amount' => $validated['amount'],
            'note' => $validated['note'],
            'donation_type' => $validated['donation_type'],
        ]);

        $donation->setStatusSuccess();

        // update collected_amount kita (total duit) di program donasi kite
        $program = ProgramDonasi::find($validated['program_donasi_id']);
        $program->collected_amount += $validated['amount'];
        $program->save();

        Cache::forget('dashboard_stats');
        Cache::forget('featured_programs');
        Cache::forget('other_programs');
        Cache::forget("donors_count_{$program->id}");
        return redirect()
            ->route('admin.donasi.index')
            ->with('success', 'Donasi manual berhasil ditambahkan! Total program bertambah Rp ' . number_format($validated['amount'], 0, ',', '.'));
    }

    public function users()
    {
        return view('pages.admin.users');
    }
}
