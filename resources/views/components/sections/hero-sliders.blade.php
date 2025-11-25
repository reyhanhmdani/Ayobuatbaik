<header class="relative text-white overflow-hidden pt-2 pb-8">
    <div class="absolute top-0 left-0 right-0 z-0 bg-primary h-24 md:h-28"></div>

    <div class="relative w-full z-10">
        <div class="slider-container flex overflow-x-auto snap-x snap-mandatory h-auto gap-3 px-4 scroll-smooth">
            @foreach ($sliders as $slide)
            @php
                $fallbackImageUrl = 'https://placehold.co/1600x900/4CAF50/FFFFFF?text=Ayobuatbaik+Slider';

                $imageUrl = $slide->gambar
                            ? asset('storage/' . $slide->gambar)
                            : $fallbackImageUrl;
            @endphp

            <a href="{{ $slide->url ?? '#' }}"
               class="min-w-[90%] flex-shrink-0 relative flex items-center justify-center snap-center rounded-xl overflow-hidden aspect-[16/9] bg-gray-200">
                <img src="{{ $imageUrl }}"
                     alt="{{ $slide->alt_text ?? 'Slider Image' }}"
                     class="absolute inset-0 w-full h-full object-cover"
                     loading="lazy"

                     {{-- Opsi: Tambahkan fallback error handling JS jika gambar gagal dimuat --}}
                     onerror="this.onerror=null; this.src='{{ $fallbackImageUrl }}';"
                     >
            </a>
        @endforeach

        </div>
    </div>
</header>
<div class="flex justify-center space-x-2 z-30 mt-1 relative px-4">
    @foreach ($sliders as $index => $slide)
        <button class="slider-dot w-3 h-3 rounded-full bg-gray-400 opacity-50 {{ $index === 0 ? 'active' : '' }}"></button>
    @endforeach
</div>

