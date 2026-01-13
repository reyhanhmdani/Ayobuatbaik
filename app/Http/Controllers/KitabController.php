<?php

namespace App\Http\Controllers;

use App\Models\KitabChapter;
use App\Models\KitabMaqolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class KitabController extends Controller
{
    /**
     * Menampilkan daftar bab kitab
     */
    public function index()
    {
        $chapters = Cache::remember("kitab_chapters_list", 43200, function () {
            return KitabChapter::with(['maqolahs' => function ($query) {
                $query->select('id', 'chapter_id', 'nomor_maqolah', 'judul', 'urutan')->orderBy('urutan');
            }])->withCount("maqolahs")->orderBy("urutan")->get();
        });

        $maqolahs = Cache::remember("kitab_total_maqolah", 43200, function () {
            return KitabMaqolah::count();
        });

        return view("pages.kitab.index", compact("chapters", "maqolahs"));
    }

    /**
     * Menampilkan maqolah dalam satu bab
     */
    public function showChapter($slug)
    {
        $chapter = Cache::remember("kitab_chapter_{$slug}", 43200, function () use ($slug) {
            return KitabChapter::where("slug", $slug)
                ->with([
                    "maqolahs" => function ($query) {
                        $query->orderBy("urutan");
                    },
                ])
                ->firstOrFail();
        });

        return view("pages.kitab.chapter", compact("chapter"));
    }

    /**
     * Menampilkan detail maqolah tunggal
     */
    public function showMaqolah($chapterSlug, $id)
    {
        $cacheKey = "kitab_maqolah_{$id}";
        $data = Cache::remember($cacheKey, 43200, function () use ($chapterSlug, $id) {
            $chapter = KitabChapter::where("slug", $chapterSlug)->firstOrFail();
            $maqolah = KitabMaqolah::where("chapter_id", $chapter->id)->where("id", $id)->firstOrFail();

            // Get previous and next maqolah
            $previous = KitabMaqolah::where("chapter_id", $chapter->id)->where("urutan", "<", $maqolah->urutan)->orderBy("urutan", "desc")->first();
            $next = KitabMaqolah::where("chapter_id", $chapter->id)->where("urutan", ">", $maqolah->urutan)->orderBy("urutan", "asc")->first();

            return compact("chapter", "maqolah", "previous", "next");
        });

        return view("pages.kitab.maqolah", $data);
    }

    /**
     * API: Mengembalikan semua URL Kitab untuk offline caching
     */
    public function getAllUrls()
    {
        $urls = ['/kitab']; // Index page

        $chapters = KitabChapter::with('maqolahs:id,chapter_id,nomor_maqolah')
            ->orderBy('urutan')
            ->get();

        foreach ($chapters as $chapter) {
            // Chapter URL
            $urls[] = '/kitab/' . $chapter->slug;

            // Maqolah URLs
            foreach ($chapter->maqolahs as $maqolah) {
                $urls[] = '/kitab/' . $chapter->slug . '/maqolah/' . $maqolah->id;
            }
        }

        return response()->json([
            'total' => count($urls),
            'urls' => $urls
        ]);
    }
}
