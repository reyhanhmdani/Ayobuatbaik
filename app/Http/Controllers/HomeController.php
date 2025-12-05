<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Donation;
use App\Models\KategoriDonasi;
use App\Models\ProgramDonasi;
use App\Models\Slider;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredPrograms = ProgramDonasi::with(['kategori', 'penggalang'])
            ->where('featured', 1)
            ->where('status', 'active')
            ->orderBy('id', 'desc')
            ->take(3)
            ->get();

        $otherPrograms = ProgramDonasi::with(['kategori', 'penggalang'])
            ->where('featured', 0)
            ->orderBy('id', 'desc')
            ->get();

        $kategori = KategoriDonasi::orderBy('name')->get();

        $sliders = Slider::orderBy('urutan', 'asc')->get();

        // Ambil 4 berita terbaru
        $berita = Berita::orderBy('tanggal', 'desc')->take(4)->get();

        return view('pages.home', compact('featuredPrograms', 'otherPrograms', 'kategori', 'sliders', 'berita'));
    }

    public function programs()
    {
        $kategories = KategoriDonasi::select('id', 'name', 'slug')->get();

        $programs = ProgramDonasi::with(['kategori', 'penggalang'])
            ->where('status', 'active')
            ->latest()
            ->get();

        return view('pages.program-donasi.programs', compact('kategories', 'programs'));
    }

    public function program($slug)
    {
        $program = ProgramDonasi::where('slug', $slug)->firstOrFail();
        // 1. Ambil daftar donasi sukses (maksimal 20 atau lebih, disarankan dibatasi)
        // Diurutkan berdasarkan yang terbaru (created_at atau status_change_at)
        $donations = Donation::where('program_donasi_id', $program->id)
            ->where('status', 'success')
            ->latest()
            ->limit(20) // Batasi jumlah yang ditampilkan di tab Donatur
            ->get();

        $donorsCount = $program->donations()->where('status', 'success')->count();
        $relatedPrograms = ProgramDonasi::where('id', '!=', $program->id)->inRandomOrder()->take(3)->get();

        if ($relatedPrograms->count() < 3) {
            $relatedPrograms = ProgramDonasi::where('id', '!=', $program->id)->get();
        }

        return view('pages.program-donasi.single-program', compact('program', 'relatedPrograms', 'donations', 'donorsCount'));
    }

    public function search(Request $request)
    {
        $keyword = $request->input('q');

        $programs = ProgramDonasi::when($keyword, function ($query) use ($keyword) {
            $query
                ->where('title', 'like', "%{$keyword}%")
                ->orWhere('short_description', 'like', "%{$keyword}%")
                ->orWhere('deskripsi', 'like', "%{$keyword}%");
        })
            ->latest()
            ->paginate(10);

        return view('pages.program-donasi.search', compact('programs', 'keyword'));
    }

    public function berita()
    {
        $beritas = Berita::latest()->paginate(7);
        return view('pages.berita.index', compact('beritas'));
    }

    public function showBerita($slug)
    {
        $berita = Berita::where('slug', $slug)->firstOrFail();

        // Ambil 3 berita terkait/terbaru lainnya secara acak (kecuali berita saat ini)
        $relatedBeritas = Berita::where('id', '!=', $berita->id)->inRandomOrder()->limit(3)->get();

        // Opsional: Hitung view/baca berita (jika ada kolom views di tabel Berita)
        // $berita->increment('views');

        return view('pages.berita.berita', compact('berita', 'relatedBeritas'));
    }
}
