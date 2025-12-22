<?php

namespace App\Http\Controllers;

use App\Models\KitabChapter;
use App\Models\KitabMaqolah;
use Illuminate\Http\Request;

class KitabController extends Controller
{
    /**
     * Menampilkan daftar bab kitab
     */
    public function index()
    {
        $chapters = KitabChapter::withCount("maqolahs")->orderBy("urutan")->get();

        return view("pages.kitab.index", compact("chapters"));
    }

    /**
     * Menampilkan maqolah dalam satu bab
     */
    public function showChapter($slug)
    {
        $chapter = KitabChapter::where("slug", $slug)
            ->with([
                "maqolahs" => function ($query) {
                    $query->orderBy("urutan");
                },
            ])
            ->firstOrFail();

        return view("pages.kitab.chapter", compact("chapter"));
    }

    /**
     * Menampilkan detail maqolah tunggal
     */
    public function showMaqolah($chapterSlug, $id)
    {
        $chapter = KitabChapter::where("slug", $chapterSlug)->firstOrFail();

        $maqolah = KitabMaqolah::where("chapter_id", $chapter->id)->where("id", $id)->firstOrFail();

        // Get previous and next maqolah
        $previous = KitabMaqolah::where("chapter_id", $chapter->id)->where("urutan", "<", $maqolah->urutan)->orderBy("urutan", "desc")->first();

        $next = KitabMaqolah::where("chapter_id", $chapter->id)->where("urutan", ">", $maqolah->urutan)->orderBy("urutan", "asc")->first();

        return view("pages.kitab.maqolah", compact("chapter", "maqolah", "previous", "next"));
    }
}
