<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\KitabChapter;
use App\Models\KitabMaqolah;
use Illuminate\Http\Request;

class KitabMaqolahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $chapters = KitabChapter::orderBy("nomor_bab")->get();
        $selectedChapter = $request->chapter ? KitabChapter::find($request->chapter) : null;

        $query = KitabMaqolah::with("chapter");

        // Filter by chapter
        if ($request->chapter) {
            $query->where("chapter_id", $request->chapter);
        }

        // Search
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where("judul", "like", "%" . $request->search . "%")->orWhere("konten", "like", "%" . $request->search . "%");
            });
        }

        // Default sort: Chapter Number then Maqolah Number
        $sortField = $request->get("sort", "chapter_nomor");
        $sortDirection = $request->get("direction", "asc");

        if ($sortField === "chapter_nomor" || $sortField === "chapter") {
            $query
                ->join("kitab_chapters", "kitab_maqolah.chapter_id", "=", "kitab_chapters.id")
                ->orderBy("kitab_chapters.nomor_bab", $sortDirection)
                ->orderBy("kitab_maqolah.nomor_maqolah", "asc")
                ->select("kitab_maqolah.*");
        } else {
            $query->orderBy($sortField, $sortDirection);
        }

        $maqolahs = $query->paginate($request->get("perPage", 10));

        return view("pages.admin.kitab-maqolah.index", compact("maqolahs", "chapters", "selectedChapter"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $chapters = KitabChapter::orderBy("nomor_bab")->get();
        $selectedChapterId = $request->chapter;

        // Get next nomor_maqolah for selected chapter
        $nextNomor = 1;
        if ($selectedChapterId) {
            $lastMaqolah = KitabMaqolah::where("chapter_id", $selectedChapterId)->orderBy("nomor_maqolah", "desc")->first();
            $nextNomor = $lastMaqolah ? $lastMaqolah->nomor_maqolah + 1 : 1;
        }

        return view("pages.admin.kitab-maqolah.create", compact("chapters", "selectedChapterId", "nextNomor"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            "chapter_id" => "required|exists:kitab_chapters,id",
            "nomor_maqolah" => "required|integer",
            "judul" => "required|string|max:255",
            "konten" => "required|string",
        ]);

        $validated["urutan"] = $validated["nomor_maqolah"];

        KitabMaqolah::create($validated);

        return redirect()
            ->route("admin.kitab_maqolah.index", ["chapter" => $validated["chapter_id"]])
            ->with("success", "Maqolah berhasil ditambahkan.");
    }

    /**
     * Display the specified resource.
     */
    public function show(KitabMaqolah $kitabMaqolah)
    {
        return redirect()->route("home.kitab.maqolah", [
            "chapterSlug" => $kitabMaqolah->chapter->slug,
            "id" => $kitabMaqolah->id,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KitabMaqolah $kitabMaqolah)
    {
        $chapters = KitabChapter::orderBy("nomor_bab")->get();

        return view("pages.admin.kitab-maqolah.edit", compact("kitabMaqolah", "chapters"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KitabMaqolah $kitabMaqolah)
    {
        $validated = $request->validate([
            "chapter_id" => "required|exists:kitab_chapters,id",
            "nomor_maqolah" => "required|integer",
            "judul" => "required|string|max:255",
            "konten" => "required|string",
        ]);

        $validated["urutan"] = $validated["nomor_maqolah"];

        $kitabMaqolah->update($validated);

        return redirect()
            ->route("admin.kitab_maqolah.index", ["chapter" => $validated["chapter_id"]])
            ->with("success", "Maqolah berhasil diperbarui.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KitabMaqolah $kitabMaqolah)
    {
        $chapterId = $kitabMaqolah->chapter_id;
        $kitabMaqolah->delete();

        return redirect()
            ->route("admin.kitab_maqolah.index", ["chapter" => $chapterId])
            ->with("success", "Maqolah berhasil dihapus.");
    }
}
