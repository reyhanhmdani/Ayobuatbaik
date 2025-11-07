<?php

namespace App\Http\Controllers;

use App\Http\Requests\SliderRequest;
use App\Http\Requests\StoreSliderRequest;
use App\Http\Requests\UpdateSliderRequest;
use App\Models\ProgramDonasi;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::with('program')->orderBy('urutan')->paginate(10);
        return view('pages.admin.sliders.index', compact('sliders'));
    }

    public function create()
    {
        $nextOrder = Slider::max('urutan') ? Slider::max('urutan') + 1 : 1;

        return view('pages.admin.sliders.create', compact('nextOrder'));
    }

    public function store(StoreSliderRequest $request)
    {
        // Ambil urutan dari request (pastikan integer)
        $urutan = (int) $request->urutan;

        // Shift semua slider yang urutannya >= urutan baru
        Slider::where('urutan', '>=', $urutan)->increment('urutan');

        // Upload file ke storage/public/sliders
        $path = $request->file('gambar')->store('sliders', 'public');

        // Simpan slider baru
        Slider::create([
            'gambar' => $path,
            'urutan' => $urutan,
            'url' => $request->url,
            'alt_text' => $request->alt_text,
        ]);

        return redirect()->route('admin.sliders.index')->with('success', 'Slider berhasil ditambahkan!');
    }

    public function edit(Slider $slider)
    {
        return view('pages.admin.sliders.edit', compact('slider'));
    }

    public function update(UpdateSliderRequest $request, Slider $slider)
    {
        $oldOrder = $slider->urutan;
        $newOrder = (int) $request->urutan;

        // --- SHIFT URUTAN ---
        if ($newOrder != $oldOrder) {
            if ($newOrder < $oldOrder) {
                // Geser semua ke bawah (+1)
                Slider::where('urutan', '>=', $newOrder)->where('urutan', '<', $oldOrder)->increment('urutan');
            } else {
                // Geser semua ke atas (-1)
                Slider::where('urutan', '<=', $newOrder)->where('urutan', '>', $oldOrder)->decrement('urutan');
            }
        }

        // --- UPDATE IMAGE ---
        if ($request->hasFile('gambar')) {
            if ($slider->gambar && Storage::disk('public')->exists($slider->gambar)) {
                Storage::disk('public')->delete($slider->gambar);
            }

            $path = $request->file('gambar')->store('sliders', 'public');
            $slider->gambar = $path;
        }

        // --- UPDATE DATA LAIN ---
        $slider->url = $request->url;
        $slider->alt_text = $request->alt_text;
        $slider->urutan = $newOrder;

        $slider->save();

        return redirect()->route('admin.sliders.index')->with('success', 'Slider berhasil diperbarui!');
    }

    public function destroy(Slider $slider)
    {
        $deletedOrder = $slider->urutan;

        Storage::disk('public')->delete($slider->gambar);
        $slider->delete();

        // Setelah dihapus → slider di bawahnya naik 1
        Slider::where('urutan', '>', $deletedOrder)->decrement('urutan');

        return back()->with('success', 'Slider berhasil dihapus!');
    }

    public function reorder(Request $request)
    {
        foreach ($request->order as $item) {
            Slider::where('id', $item['id'])->update(['urutan' => $item['urutan']]);
        }

        return response()->json(['success' => true]);
    }
}
