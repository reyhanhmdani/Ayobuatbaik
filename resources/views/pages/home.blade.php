@extends('components.layout.app')

@section('title', 'Ayobuatbaik - Platform Donasi Digital')

@section('header-content')
    @include('components.layout.header-with-search')
    @include('components.sections.hero-sliders')
@endsection

@section('content')
    <!-- Pilihan Section -->
    <section class="px-4 py-8">
        <div class="">
            <h2 class="text-lg font-bold text-primary mb-3">Program bersama Ustad Andre</h2>
            @forelse ($featuredPrograms as $programPilihan)
                <div class="grid grid-cols-1 gap-7 mt-4">
                    <div class="bg-white overflow-hidden shadow-md card-hover-effect flex items-stretch h-28">
                        <div class="w-1/2 h-full flex-shrink-0 overflow-hidden">
                            <img src="{{ asset('storage/' . $programPilihan->gambar) }}" alt="{{ $programPilihan->title }}"
                                class="w-full h-full object-cover">
                        </div>

                        <div class="py-2 px-3 flex flex-col justify-between w-full">
                            <div>
                                <h3 class="text-xs font-semibold text-gray-800 flex items-center gap-1p">
                                    {{ $programPilihan->title }}
                                    @if ($programPilihan->verified)
                                        <span class="ml-1 inline-flex items-center">
                                            {{-- SVG Icon Verifikasi ala Instagram --}}
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                                class="w-4 h-4 text-blue-500">
                                                <path fill-rule="evenodd"
                                                    d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </span>
                                    @endif
                                </h3>
                            </div>
                            <div class="mt-1">
                                <div class="flex justify-between text-xs text-gray-800 mb-0.5">
                                    <span class="font-semibold text-[10px]">Terkumpul: Rp
                                        {{ number_format($programPilihan->collected_amount, 0, ',', '.') }}</span>
                                    <span class="text-gray-500 text-[10px]">
                                        Sisa:
                                        {{ $programPilihan->end_date
                                            ? floor(max(0, \Carbon\Carbon::now()->diffInDays($programPilihan->end_date, false))) . ' hari'
                                            : '∞' }}
                                    </span>
                                </div>
                                @php
                                    $progress =
                                        $programPilihan->target_amount > 0
                                            ? ($programPilihan->collected_amount / $programPilihan->target_amount) * 100
                                            : 0;
                                @endphp
                                <div class="progress-bar-simple">
                                    <div class="progress-fill-simple bg-secondary" style="width: {{ $progress }}"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-xs text-gray-500">Belum ada program pilihan.</p>
            @endforelse
        </div>
        </div>
    </section>

    {{-- Kategori Section --}}
    <section class="px-2 pt-8" id="kategori">
        <div class="text-center mb-10">
            <h2 class="text-sm font-bold text-gray-800 mb-3">Kategori Program Kebaikan</h2>
            <p class="text-xs text-gray-500 mt-1">
                Temukan beragam program kebaikan yang direkomendasikan untukmu
            </p>

            <div class="grid grid-cols-4 gap-3 mt-6 text-center">
                <!-- Semua -->
                <div
                    class="group flex flex-col items-center text-center space-y-1 cursor-pointer transition-all duration-200">
                    <div
                        class="w-12 h-12 flex items-center justify-center rounded-full bg-green-700 group-hover:bg-secondary/10 border border-secondary/40 transition-colors">
                        <i class="fas fa-folder text-white group-hover:text-secondary text-base"></i>
                    </div>
                    <span class="text-[11px] font-medium text-gray-700 font-mono">Semua</span>
                </div>

                <!-- Sosial -->
                <div
                    class="group flex flex-col items-center text-center space-y-1 cursor-pointer transition-all duration-200">
                    <div
                        class="w-12 h-12 flex items-center justify-center rounded-full bg-white group-hover:bg-secondary/10 border border-secondary/40 transition-colors">
                        <i class="fas fa-hand-holding-heart text-secondary text-base"></i>
                    </div>
                    <span class="text-[11px] font-medium text-gray-700 font-mono">Sosial</span>
                </div>

                <!-- Kemanusiaan -->
                <div
                    class="group flex flex-col items-center text-center space-y-1 cursor-pointer transition-all duration-200">
                    <div
                        class="w-12 h-12 flex items-center justify-center rounded-full bg-white group-hover:bg-secondary/10 border border-secondary/40 transition-colors">
                        <i class="fas fa-people-carry text-secondary text-base"></i>
                    </div>
                    <span class="text-[11px] font-medium text-gray-700 font-mono">Kemanusiaan</span>
                </div>

                <!-- Lainnya -->
                <div class="group flex flex-col items-center text-center space-y-1 cursor-pointer transition-all duration-200"
                    onclick="openKategoriModal()">
                    <div
                        class="w-12 h-12 flex items-center justify-center rounded-full bg-white group-hover:bg-secondary/10 border border-secondary/40 transition-colors">
                        <i class="fas fa-ellipsis-h text-secondary text-base"></i>
                    </div>
                    <span class="text-[11px] font-medium text-gray-700 font-mono">Lainnya</span>
                </div>
            </div>
        </div>
    </section>


    <!-- Program Section -->
    <section class="px-4 pb-8" id="program">
        <div class="text-center mb-8">
            <p class="text-gray-600 text-xs font-bold">“Satu klikmu bisa jadi senyum bagi mereka yang membutuhkan.</p>
            <p class="text-gray-600 text-xs font-bold">Yuk bantu santri, dhuafa, dan sesama lewat Ayobuatbaik.”</p>
        </div>

        <div class="grid grid-cols-1 gap-7">
            <!-- Card 1 -->
            <div class="bg-white overflow-hidden shadow-md flex items-stretch h-28">
                <div class="w-1/2 h-full flex-shrink-0 overflow-hidden">
                    <img src="{{ asset('assets/img/beasiswaashabi.jpeg') }}" alt="Beasiswa Santri Selfa"
                        class="w-full h-full object-cover">
                </div>
                <div class="py-2 px-3 flex flex-col justify-between w-full">
                    <h3 class="text-xs font-bold text-primary leading-snug line-clamp-2">Beasiswa Santri Selfa</h3>
                    <div class="mt-1">
                        <div class="flex justify-between text-xs text-gray-800 mb-0.5">
                            <span class="font-semibold text-[10px]">Terkumpul: Rp 119.373.780</span>
                            <span class="text-gray-500 text-[10px]">Sisa hari: ∞</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-1.5">
                            <div class="bg-secondary h-1.5 rounded-full" style="width: 85%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="bg-white overflow-hidden shadow-md flex items-stretch h-28">
                <div class="w-1/2 h-full flex-shrink-0 overflow-hidden">
                    <img src="{{ asset('assets/img/ontheroad.jpg') }}" alt="Si Jum On The Road"
                        class="w-full h-full object-cover">
                </div>
                <div class="py-2 px-3 flex flex-col justify-between w-full">
                    <h3 class="text-xs font-bold text-primary leading-snug line-clamp-2">Si Jum On The Road</h3>
                    <div class="mt-1">
                        <div class="flex justify-between text-xs text-gray-800 mb-0.5">
                            <span class="font-semibold text-[10px]">Terkumpul: Rp 48.060.534</span>
                            <span class="text-gray-500 text-[10px]">Sisa hari: ∞</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-1.5">
                            <div class="bg-secondary h-1.5 rounded-full" style="width: 60%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="bg-white overflow-hidden shadow-md flex items-stretch h-28">
                <div class="w-1/2 h-full flex-shrink-0 overflow-hidden">
                    <img src="{{ asset('assets/img/wakaf.jpeg') }}" alt="Wakaf Produktif"
                        class="w-full h-full object-cover">
                </div>
                <div class="py-2 px-3 flex flex-col justify-between w-full">
                    <h3 class="text-xs font-bold text-primary leading-snug line-clamp-2">
                        Wakaf Produktif Perluasan Lahan
                    </h3>
                    <div class="mt-1">
                        <div class="flex justify-between text-xs text-gray-800 mb-0.5">
                            <span class="font-semibold text-[10px]">Terkumpul: Rp 175.500.000</span>
                            <span class="text-gray-500 text-[10px]">Sisa hari: ∞</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-1.5">
                            <div class="bg-secondary h-1.5 rounded-full" style="width: 70%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tombol -->
        <div class="text-center mt-8">
            <button
                class="bg-primary text-white font-semibold px-5 py-2.5 rounded-lg text-sm hover:bg-grayDark transition-all flex items-center justify-center mx-auto">
                <span>Lihat Program Lainnya</span>
                <i class="fas fa-arrow-right ml-2 text-xs"></i>
            </button>
        </div>
    </section>

    <!-- Modal Popup Kategori -->
    <div id="kategoriModal"
        class="hidden fixed inset-0 bg-black/60 flex items-end justify-center z-[9999] transition-all duration-300">
        <div class="bg-white rounded-t-2xl w-full max-w-md p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-sm font-bold text-gray-900">Pilih kategori program</h3>
                <button onclick="closeKategoriModal()">
                    <i class="fas fa-times text-gray-600"></i>
                </button>
            </div>

            <div class="grid grid-cols-3 gap-6 mt-4">
                <!-- Sosial -->
                <div class="flex flex-col items-center cursor-pointer">
                    <div class="w-12 h-12 flex items-center justify-center rounded-full bg-green-700 text-white">
                        <i class="fas fa-hand-holding-heart text-base"></i>
                    </div>
                    <span class="text-xs text-gray-800 mt-2">Sosial</span>
                </div>

                <!-- Kemanusiaan -->
                <div class="flex flex-col items-center cursor-pointer">
                    <div class="w-12 h-12 flex items-center justify-center rounded-full bg-secondary/20">
                        <i class="fas fa-people-carry text-secondary text-base"></i>
                    </div>
                    <span class="text-xs text-gray-800 mt-2">Kemanusiaan</span>
                </div>

                <!-- Pendidikan -->
                <div class="flex flex-col items-center cursor-pointer">
                    <div class="w-12 h-12 flex items-center justify-center rounded-full bg-secondary/20">
                        <i class="fas fa-graduation-cap text-secondary text-base"></i>
                    </div>
                    <span class="text-xs text-gray-800 mt-2">Pendidikan</span>
                </div>

                <!-- Masjid -->
                <div class="flex flex-col items-center cursor-pointer">
                    <div class="w-12 h-12 flex items-center justify-center rounded-full bg-secondary/20">
                        <i class="fas fa-mosque text-secondary text-base"></i>
                    </div>
                    <span class="text-xs text-gray-800 mt-2">Masjid</span>
                </div>

                <!-- Infrastruktur -->
                <div class="flex flex-col items-center cursor-pointer">
                    <div class="w-12 h-12 flex items-center justify-center rounded-full bg-secondary/20">
                        <i class="fas fa-tools text-secondary text-base"></i>
                    </div>
                    <span class="text-xs text-gray-800 mt-2">Infrastruktur</span>
                </div>

                <div class="flex flex-col items-center cursor-pointer text-center">
                    <div class="w-12 h-12 flex items-center justify-center rounded-full bg-secondary/20">
                        <i class="fas fa-user-tie text-secondary text-base"></i>
                    </div>
                    <span class="text-xs text-gray-800 mt-2">Ustadz Andre Official</span>
                </div>
            </div>
        </div>
    </div>


    <!-- Features Section -->
    <section class="features-section py-8 rounded-2xl px-4">
        <div class="text-center mb-6">
            <h2 class="text-xl font-bold text-primary mb-2">Fitur Lainnya ABBI</h2>
            <p class="text-gray-500 text-xs">
                Nikmati berbagai fitur menarik untuk mendukung ibadah dan aktivitas kebaikan Anda.
            </p>
        </div>

        <div class="grid grid-cols-4 gap-3">
            <a href="/quran" class="group flex flex-col items-center text-center space-y-1 transition-all duration-200">
                <div
                    class="w-12 h-12 flex items-center justify-center rounded-full group-hover:bg-secondary/10 border border-secondary/40 transition-colors">
                    <i class="fas fa-book-quran text-secondary text-base"></i>
                </div>
                <span class="text-[11px] font-medium text-gray-700">Al-Quran</span>
            </a>

            <a href="/nashohul-ibad"
                class="group flex flex-col items-center text-center space-y-1 transition-all duration-200">
                <div
                    class="w-12 h-12 flex items-center justify-center rounded-full group-hover:bg-secondary/10 border border-secondary/40 transition-colors">
                    <i class="fas fa-book text-secondary text-base"></i>
                </div>
                <span class="text-[11px] font-medium text-gray-700">Nashohul Ibad</span>
            </a>

            <a href="/doa" class="group flex flex-col items-center text-center space-y-1 transition-all duration-200">
                <div
                    class="w-12 h-12 flex items-center justify-center rounded-full group-hover:bg-secondary/10 border border-secondary/40 transition-colors">
                    <i class="fas fa-hands-praying text-secondary text-base"></i>
                </div>
                <span class="text-[11px] font-medium text-gray-700">Doa</span>
            </a>

            <a href="/webtoon" class="group flex flex-col items-center text-center space-y-1 transition-all duration-200">
                <div
                    class="w-12 h-12 flex items-center justify-center rounded-full group-hover:bg-secondary/10 border border-secondary/40 transition-colors">
                    <i class="fas fa-images text-secondary text-base"></i>
                </div>
                <span class="text-[11px] font-medium text-gray-700">Webtoon</span>
            </a>
        </div>
    </section>

    <!-- Berita Section -->
    <section class="px-4 py-8 mb-12" id="berita">
        <div class="mb-8">
            <h2 class="text-xl font-bold text-primary mb-2">Berita & Artikel</h2>
            <p class="text-gray-500 text-sm">Update terbaru program dan artikel inspiratif</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Berita 1 -->
            <div class="bg-white rounded-lg border border-gray-100 p-4 hover:border-secondary transition-colors">
                <div class="w-full h-32 rounded-lg overflow-hidden mb-3">
                    <img src="https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80"
                        alt="Suksesnya Program Beasiswa 2023" class="w-full h-full object-cover" />
                </div>
                <span class="text-xs text-secondary font-medium">12 Mei 2023</span>
                <h3 class="text-sm font-bold text-primary mt-1 mb-2 line-clamp-2">Suksesnya Program Beasiswa 2023</h3>
                <p class="text-gray-600 text-xs line-clamp-2">
                    Program beasiswa tahun ini telah berhasil membantu 150 anak dari keluarga kurang mampu.
                </p>
                <a href="#"
                    class="inline-block mt-2 text-secondary text-xs font-medium hover:text-goldDark transition-colors">
                    Baca selengkapnya
                </a>
            </div>

            <div class="bg-white rounded-lg border border-gray-100 p-4 hover:border-secondary transition-colors">
                <div class="w-full h-32 rounded-lg overflow-hidden mb-3">
                    <img src="https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80"
                        alt="Suksesnya Program Beasiswa 2023" class="w-full h-full object-cover" />
                </div>
                <span class="text-xs text-secondary font-medium">12 Mei 2023</span>
                <h3 class="text-sm font-bold text-primary mt-1 mb-2 line-clamp-2">Suksesnya Program Beasiswa 2023</h3>
                <p class="text-gray-600 text-xs line-clamp-2">
                    Program beasiswa tahun ini telah berhasil membantu 150 anak dari keluarga kurang mampu.
                </p>
                <a href="#"
                    class="inline-block mt-2 text-secondary text-xs font-medium hover:text-goldDark transition-colors">
                    Baca selengkapnya
                </a>
            </div>

            <!-- Berita 2 -->
            <div class="bg-white rounded-lg border border-gray-100 p-4 hover:border-secondary transition-colors">
                <div class="w-full h-32 rounded-lg overflow-hidden mb-3">
                    <img src="https://images.unsplash.com/photo-1559027615-cd4628902d4a?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80"
                        alt="Bantuan untuk Korban Banjir" class="w-full h-full object-cover" />
                </div>
                <span class="text-xs text-secondary font-medium">5 April 2023</span>
                <h3 class="text-sm font-bold text-primary mt-1 mb-2 line-clamp-2">Bantuan untuk Korban Banjir</h3>
                <p class="text-gray-600 text-xs line-clamp-2">Tim Ayobuatbaik telah menyalurkan bantuan darurat untuk
                    korban
                    banjir.</p>
                <a href="#"
                    class="inline-block mt-2 text-secondary text-xs font-medium hover:text-goldDark transition-colors">
                    Baca selengkapnya
                </a>
            </div>
            <div class="bg-white rounded-lg border border-gray-100 p-4 hover:border-secondary transition-colors">
                <div class="w-full h-32 rounded-lg overflow-hidden mb-3">
                    <img src="https://images.unsplash.com/photo-1559027615-cd4628902d4a?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80"
                        alt="Bantuan untuk Korban Banjir" class="w-full h-full object-cover" />
                </div>
                <span class="text-xs text-secondary font-medium">5 April 2023</span>
                <h3 class="text-sm font-bold text-primary mt-1 mb-2 line-clamp-2">Bantuan untuk Korban Banjir</h3>
                <p class="text-gray-600 text-xs line-clamp-2">Tim Ayobuatbaik telah menyalurkan bantuan darurat untuk
                    korban
                    banjir.</p>
                <a href="#"
                    class="inline-block mt-2 text-secondary text-xs font-medium hover:text-goldDark transition-colors">
                    Baca selengkapnya
                </a>
            </div>
        </div>

        <!-- Tombol Lihat Semua -->
        <div class="text-center mt-6">
            <button
                class="text-secondary font-semibold text-sm hover:text-goldDark transition-colors flex items-center justify-center mx-auto">
                <span>Lihat Semua Berita</span>
                <i class="fas fa-arrow-right ml-2 text-xs"></i>
            </button>
        </div>
    </section>
    @include('components.layout.footer')
@endsection

@section('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // --- Modal Kategori ---
            const kategoriModal = document.getElementById("kategoriModal");

            window.openKategoriModal = function() {
                if (kategoriModal) kategoriModal.classList.remove("hidden");
            };

            window.closeKategoriModal = function() {
                if (kategoriModal) kategoriModal.classList.add("hidden");
            };

            // --- Slider / Banner Otomatis ---
            const sliderContainer = document.querySelector(".slider-container");
            const sliderDots = document.querySelectorAll(".slider-dot");
            let currentSlide = 0;
            const totalSlides = sliderDots.length || 3; // fallback 3 kalau belum ada dot

            function updateSlider() {
                if (!sliderContainer) return;

                sliderContainer.scrollTo({
                    left: currentSlide * sliderContainer.offsetWidth,
                    behavior: "smooth",
                });

                sliderDots.forEach((dot, index) => {
                    dot.classList.toggle("active", index === currentSlide);
                    dot.classList.toggle("opacity-50", index !== currentSlide);
                });
            }

            if (sliderContainer && sliderDots.length > 0) {
                // Ganti slide setiap 5 detik
                setInterval(() => {
                    currentSlide = (currentSlide + 1) % totalSlides;
                    updateSlider();
                }, 5000);

                // Klik dot manual
                sliderDots.forEach((dot, index) => {
                    dot.addEventListener("click", () => {
                        currentSlide = index;
                        updateSlider();
                    });
                });
            }
        });
    </script>

@endsection
