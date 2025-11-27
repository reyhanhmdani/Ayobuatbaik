<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProgramDonasiRequest;
use App\Http\Requests\UpdateProgramDonasiRequest;
use App\Models\KategoriDonasi;
use App\Models\PenggalangDana;
use App\Models\ProgramDonasi;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProgramDonasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // allowed sort columns (prevent SQL injection)
        $allowedSorts = ['title', 'penggalang', 'target_amount', 'created_at', 'end_date', 'status', 'verified'];

        $search = $request->query('search');
        $sort = $request->query('sort', 'created_at');
        $direction = $request->query('direction', 'desc');
        $perPage = (int) $request->query('perPage', 10);

        // normalize values
        if (!in_array($sort, $allowedSorts)) {
            $sort = 'created_at';
        }
        $direction = strtolower($direction) === 'asc' ? 'asc' : 'desc';
        $perPage = in_array($perPage, [10, 30, 50, 100]) ? $perPage : 10;

        // base query with relations
        $query = ProgramDonasi::with(['kategori', 'penggalang']);

        // search across title and penggalang name
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")->orWhereHas('penggalang', function ($q2) use ($search) {
                    $q2->where('nama', 'like', "%{$search}%");
                });
            });
        }

        // sorting special: if sorting by penggalang, join on relationship
        if ($sort === 'penggalang') {
            $query->leftJoin('penggalang_dana', 'program_donasi.penggalang_id', '=', 'penggalang_dana.id')->select('program_donasi.*')->orderBy('penggalang_dana.nama', $direction);
        } else {
            $query->orderBy($sort, $direction);
        }

        $programs = $query->paginate($perPage)->withQueryString();

        // pass current params for view controls
        return view('pages.admin.programs.index', compact('programs', 'search', 'sort', 'direction', 'perPage'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategories = KategoriDonasi::all();
        $penggalangs = PenggalangDana::all();

        return view('pages.admin.programs.create', compact('kategories', 'penggalangs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProgramDonasiRequest $request)
    {
        // dd('Masuk ke store', $request->all());
        $validated = $request->validated();

        // Tambahkan slug otomatis
        $validated['slug'] = Str::slug($validated['title']);

        // Default collected_amount = 0 kalau tidak ada
        $validated['collected_amount'] = $validated['collected_amount'] ?? 0;

        // Checkbox logic
        $validated['verified'] = $request->has('verified');
        $validated['featured'] = $request->has('featured');

        // Default status & verified jika belum diisi
        $validated['status'] = $validated['status'] ?? 'nonaktif';

        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('programs', 'public');
            $validated['gambar'] = $path;
        }

        ProgramDonasi::create($validated);

        return redirect()->route('admin.programs.index')->with('success', 'Program Donasi Berhasil');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        $program = ProgramDonasi::with('penggalang')->findOrFail($id);

        // $total_amount = $program->donations()->where('status', 'success')->sum('amount');
        $total_amount = $program->collected_amount;

        $donors_count = $program->donations()->where('status', 'success')->count();

        $query = $program->donations()->latest();

        if ($request->filled('donor_search')) {
            $search = $request->donor_search;
            $query->whereHas('donor', function ($q) use ($search) {
                $q->where('donor_name', 'like', "%{$search}%")
                    ->orWhere('donor_email', 'like', "%{$search}%")
                    ->orWhere('donor_phone', 'like', "%{$search}%");
            });
        }

        $query->where('status', 'success');

        $donations = $query->paginate(10)->withQueryString();

        return view('pages.admin.programs.show', compact('program', 'total_amount', 'donors_count', 'donations'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProgramDonasi $program)
    {
        $kategories = KategoriDonasi::all();
        $penggalangs = PenggalangDana::all();

        return view('pages.admin.programs.edit', compact('program', 'kategories', 'penggalangs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProgramDonasiRequest $request, ProgramDonasi $program)
    {
        $validated = $request->validated();

        // Slug otomatis dari title
        $validated['slug'] = Str::slug($validated['title']);

        // Checkbox
        $validated['verified'] = $request->has('verified');
        $validated['featured'] = $request->has('featured');

        // Status default
        $validated['status'] = $validated['status'] ?? $program->status;

        // Collected amount harus mempertahankan value lama
        $validated['collected_amount'] = $program->collected_amount;

        // Upload gambar baru
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama
            if ($program->gambar && Storage::disk('public')->exists($program->gambar)) {
                Storage::disk('public')->delete($program->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('programs', 'public');
        }

        $program->update($validated);

        return redirect()->route('admin.programs.index')->with('success', 'Program Donasi Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $program = ProgramDonasi::findOrFail($id);
        $program->delete();

        return redirect()->route('admin.programs.index')->with('success', 'Program Donasi berhasil dihapus');
    }
}
