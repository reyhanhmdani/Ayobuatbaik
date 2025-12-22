<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\KitabChapter;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KitabChapterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = KitabChapter::withCount("maqolahs");

        // Search
        if ($request->search) {
            $query->where("judul_bab", "like", "%" . $request->search . "%");
        }

        // Sort
        $sortField = $request->get("sort", "nomor_bab");
        $sortDirection = $request->get("direction", "asc");
        $query->orderBy($sortField, $sortDirection);

        $chapters = $query->paginate($request->get("perPage", 10));

        return view("pages.admin.kitab-chapter.index", compact("chapters"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $lastChapter = KitabChapter::orderBy("nomor_bab", "desc")->first();
        $nextNomor = $lastChapter ? $lastChapter->nomor_bab + 1 : 1;

        return view("pages.admin.kitab-chapter.create", compact("nextNomor"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            "nomor_bab" => "required|integer|unique:kitab_chapters,nomor_bab",
            "judul_bab" => "required|string|max:255",
            "deskripsi" => "nullable|string",
        ]);

        $validated["slug"] = Str::slug("bab-" . $validated["nomor_bab"] . "-" . $validated["judul_bab"]);
        $validated["urutan"] = $validated["nomor_bab"];

        KitabChapter::create($validated);

        return redirect()->route("admin.kitab_chapter.index")->with("success", "Bab berhasil ditambahkan.");
    }

    /**
     * Display the specified resource.
     */
    public function show(KitabChapter $kitabChapter)
    {
        return redirect()->route("admin.kitab_maqolah.index", ["chapter" => $kitabChapter->id]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KitabChapter $kitabChapter)
    {
        return view("pages.admin.kitab-chapter.edit", compact("kitabChapter"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KitabChapter $kitabChapter)
    {
        $validated = $request->validate([
            "nomor_bab" => "required|integer|unique:kitab_chapters,nomor_bab," . $kitabChapter->id,
            "judul_bab" => "required|string|max:255",
            "deskripsi" => "nullable|string",
        ]);

        $validated["slug"] = Str::slug("bab-" . $validated["nomor_bab"] . "-" . $validated["judul_bab"]);
        $validated["urutan"] = $validated["nomor_bab"];

        $kitabChapter->update($validated);

        return redirect()->route("admin.kitab_chapter.index")->with("success", "Bab berhasil diperbarui.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KitabChapter $kitabChapter)
    {
        // Maqolahs akan otomatis terhapus karena cascade
        $kitabChapter->delete();

        return redirect()->route("admin.kitab_chapter.index")->with("success", "Bab berhasil dihapus.");
    }
}
