<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PenggalangDanaRequest;
use App\Http\Requests\StorePenggalangRequest;
use App\Http\Requests\UpdatePenggalangRequest;
use App\Models\PenggalangDana;
use Illuminate\Support\Facades\Storage;

class PenggalangDanaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $penggalangs = PenggalangDana::latest()->paginate(10);

        return view('pages.admin.penggalang_dana.index', compact('penggalangs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.penggalang_dana.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePenggalangRequest $request)
    {
        $validated = $request->validated();

        // Upload foto jika ada
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('penggalang_dana', 'public');
            $validated['foto'] = $path;
        }

        PenggalangDana::create($validated);

        return redirect()->route('admin.penggalang_dana.index')->with('success', 'Penggalang Dana berhasil ditambahkan.');
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
        $penggalang = PenggalangDana::findOrFail($id);

        return view('pages.admin.penggalang_dana.edit', compact('penggalang'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePenggalangRequest $request, string $id)
    {
        $penggalang = PenggalangDana::findOrFail($id);
        $validated = $request->validated();

        // Jika ada foto baru, hapus foto lama
        if ($request->hasFile('foto')) {
            if ($penggalang->foto && Storage::disk('public')->exists($penggalang->foto)) {
                Storage::disk('public')->delete($penggalang->foto);
            }

            $path = $request->file('foto')->store('penggalang_dana', 'public');
            $validated['foto'] = $path;
        }

        $penggalang->update($validated);

        return redirect()->route('admin.penggalang_dana.index')->with('success', 'Penggalang Dana berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $penggalang = PenggalangDana::findOrFail($id);

        // Hapus foto jika ada
        if ($penggalang->foto && Storage::disk('public')->exists($penggalang->foto)) {
            Storage::disk('public')->delete($penggalang->foto);
        }

        $penggalang->delete();

        return redirect()->route('admin.penggalang_dana.index')->with('success', 'Penggalang Dana berhasil dihapus.');
    }
}
