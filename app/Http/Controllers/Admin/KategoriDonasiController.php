<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\KategoriDonasiRequest;
use App\Models\KategoriDonasi;
use Str;

class KategoriDonasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategories = KategoriDonasi::latest()->paginate(10);

        return view('pages.admin.kategori.index', compact('kategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.kategori.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(KategoriDonasiRequest $request)
    {
        $validated = $request->validated();
        $validated['slug'] = Str::slug($validated['name']);

        KategoriDonasi::create($validated);

        return redirect()->route('admin.kategori_donasi.index')->with('success', 'Kategori Donasi berhasil ditambahkan.');
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
        $kategori = KategoriDonasi::findOrFail($id);

        return view('pages.admin.kategori.edit', compact('kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(KategoriDonasiRequest $request, string $id)
    {
        $kategori = KategoriDonasi::findOrFail($id);
        $validated = $request->validated();
        $validated['slug'] = Str::slug($validated['name']);

        $kategori->update($validated);

        return redirect()->route('admin.kategori_donasi.index')->with('success', 'Kategori Donasi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        KategoriDonasi::findOrFail($id)->delete();

        return redirect()->route('admin.kategori_donasi.index')->with('success', 'Kategori Donasi berhasil dihapus.');
    }
}
