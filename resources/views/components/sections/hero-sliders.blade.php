<header class="relative text-white overflow-hidden pt-2 pb-8">
    <div class="absolute top-0 left-0 right-0 z-0 bg-primary" style="height: 140px"></div>

    <div class="relative w-full z-10">
        <div class="slider-container flex overflow-x-scroll snap-x snap-mandatory h-[200px] gap-3 px-6">

            @foreach ($sliders as $slide)
                <a href="{{ $slide->url ?? '#' }}"
                   class="min-w-[88%] flex-shrink-0 relative flex items-center justify-center bg-gray-100 snap-center rounded-xl overflow-hidden">
                    <img src="{{ asset('storage/' . $slide->gambar) }}"
                         alt="{{ $slide->alt_text ?? 'Slider Image' }}"
                         class="absolute inset-0 w-full h-full object-cover"
                         loading="lazy">
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

