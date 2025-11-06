<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProgramDonasiRequest;
use App\Models\KategoriDonasi;
use App\Models\PenggalangDana;
use App\Models\ProgramDonasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Str;

class ProgramDonasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $programs = ProgramDonasi::with(['kategori', 'penggalang'])
            ->latest()
            ->paginate(10);

        return view('pages.admin.programs.index', compact('programs'));
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
    public function store(ProgramDonasiRequest $request)
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $programs = ProgramDonasi::findOrFail($id);
        $kategories = KategoriDonasi::all();
        $penggalangs = PenggalangDana::all();

        return view('pages.admin.programs.edit', compact('programs', 'kategories', 'penggalangs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProgramDonasiRequest $request, string $id)
    {
        $program = ProgramDonasi::findOrFail($id);
        $validated = $request->validated();

        // Update slug otomatis jika title berubah
        $validated['slug'] = Str::slug($validated['title']);

        // Checkbox harus pakai has()
        $validated['verified'] = $request->has('verified');
        $validated['featured'] = $request->has('featured');

        
        $validated['status'] = $validated['status'] ?? $program->status;
        $validated['collected_amount'] = $program->collected_amount;

        if ($request->hasFile('gambar')) {
            if ($program->gambar && Storage::disk('public')->exists($program->gambar)) {
                Storage::disk('public')->delete($program->gambar);
            }
            $path = $request->file('gambar')->store('programs', 'public');
            $validated['gambar'] = $path;
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
