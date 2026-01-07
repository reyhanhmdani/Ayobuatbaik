<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\KitabChapter;
use App\Models\KitabMaqolah;
use App\Models\ProgramDonasi;
use Illuminate\Http\Request;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class SitemapController extends Controller
{
    public function index()
    {
        $sitemap = Sitemap::create();

        // 1. Static Pages
        $sitemap->add(Url::create('/')->setPriority(1.0)->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY));
        $sitemap->add(Url::create('/login')->setPriority(0.5)->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY));
        $sitemap->add(Url::create('/programs')->setPriority(0.9)->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY));
        $sitemap->add(Url::create('/berita')->setPriority(0.8)->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY));
        $sitemap->add(Url::create('/kitab')->setPriority(0.9)->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY));

        // 2. Dynamic Pages: Program Donasi (Status Active)
        $programs = ProgramDonasi::where('status', 'active')->get();
        foreach ($programs as $program) {
            $sitemap->add(
                Url::create("/programs/{$program->slug}")
                    ->setPriority(0.9)
                    ->setLastModificationDate($program->updated_at ?? $program->created_at)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
            );
        }

        // 3. Dynamic Pages: Berita
        $beritas = Berita::all();
        foreach ($beritas as $berita) {
            $sitemap->add(
                Url::create("/berita/{$berita->slug}")
                    ->setPriority(0.7)
                    ->setLastModificationDate($berita->updated_at ?? $berita->created_at)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
            );
        }

        // 4. Dynamic Pages: Kitab (Chapter & Maqolah)
        // Chapters
        $chapters = KitabChapter::all();
        foreach ($chapters as $chapter) {
            $sitemap->add(
                Url::create("/kitab/{$chapter->slug}")
                    ->setPriority(0.8)
                    ->setLastModificationDate($chapter->updated_at ?? $chapter->created_at)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
            );

            // Maqolahs in Chapter
            $maqolahs = KitabMaqolah::where('chapter_id', $chapter->id)->get();
            foreach ($maqolahs as $maqolah) {
                $sitemap->add(
                    Url::create("/kitab/{$chapter->slug}/maqolah/{$maqolah->id}")
                        ->setPriority(0.8)
                        ->setLastModificationDate($maqolah->updated_at ?? $maqolah->created_at)
                        ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                );
            }
        }

        return $sitemap->toResponse(request());
    }
}
