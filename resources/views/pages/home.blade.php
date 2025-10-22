@extends('components.layout.app-padded')

@section('title', 'Ayobuatbaik - Platform Donasi Digital')

@section('header-content')
@include('components.layout.header-with-search')
@include('components.sections.hero-sliders')
@endsection

@section('content')
<!-- About Section -->
<section class="mb-12">
    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-primary mb-3">Tentang Ayobuatbaik</h2>
        <div class="w-20 h-1 bg-secondary mx-auto mb-4"></div>
        <p class="text-gray-600 text-sm">
            Ayobuatbaik adalah platform donasi digital yang menghubungkan para dermawan dengan berbagai program
            kemanusiaan.
        </p>
    </div>

    <div class="grid grid-cols-1 gap-6">
        <!-- Feature Card 1 -->
        <div class="bg-white rounded-xl overflow-hidden shadow-md p-5 feature-card">
            <div class="flex items-center gap-4 mb-3">
                <div class="w-14 h-14 rounded-full bg-goldLight flex items-center justify-center">
                    <i class="fas fa-hand-holding-heart text-xl text-secondary"></i>
                </div>
                <h3 class="text-lg font-bold text-primary">Transparan</h3>
            </div>
            <p class="text-gray-600 text-sm">Setiap donasi yang diberikan akan dilaporkan secara transparan kepada para
                donatur.</p>
        </div>

        <!-- Feature Card 2 -->
        <div class="bg-white rounded-xl overflow-hidden shadow-md p-5 feature-card">
            <div class="flex items-center gap-4 mb-3">
                <div class="w-14 h-14 rounded-full bg-goldLight flex items-center justify-center">
                    <i class="fas fa-bullseye text-xl text-secondary"></i>
                </div>
                <h3 class="text-lg font-bold text-primary">Tepat Sasaran</h3>
            </div>
            <p class="text-gray-600 text-sm">Bantuan akan disalurkan langsung kepada mereka yang benar-benar
                membutuhkan.</p>
        </div>

        <!-- Feature Card 3 -->
        <div class="bg-white rounded-xl overflow-hidden shadow-md p-5 feature-card">
            <div class="flex items-center gap-4 mb-3">
                <div class="w-14 h-14 rounded-full bg-goldLight flex items-center justify-center">
                    <i class="fas fa-shield-alt text-xl text-secondary"></i>
                </div>
                <h3 class="text-lg font-bold text-primary">Aman & Terpercaya</h3>
            </div>
            <p class="text-gray-600 text-sm">Platform kami menggunakan sistem keamanan terbaik untuk melindungi data dan
                transaksi.</p>
        </div>
    </div>
</section>
<!-- Program Section -->
<section class="mb-12" id="program">
    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-primary mb-3">Program Donasi</h2>
        <div class="w-20 h-1 bg-secondary mx-auto mb-4"></div>
        <p class="text-gray-600 text-sm">Pilih program donasi yang sesuai dengan keinginan Anda.</p>
    </div>

    <div class="grid grid-cols-1 gap-7">
        <div class="bg-white overflow-hidden shadow-md card-hover-effect flex items-stretch h-28">
            <div class="w-1/2 h-full flex-shrink-0 overflow-hidden">
                <img src="{{ asset('assets/img/beasiswaashabi.jpeg') }}" alt="Beasiswa Santri Selfa"
                    class="w-full h-full object-cover">
            </div>

            <div class="py-2 px-3 flex flex-col justify-between w-full">
                <div>
                    <h3 class="text-xs font-bold text-primary leading-snug line-clamp-2">Beasiswa Santri Selfa</h3>
                </div>

                <div class="mt-1">
                    <div class="flex justify-between text-xs text-gray-800 mb-0.5">
                        <span class="font-semibold text-[10px]">Terkumpul: Rp 119.373.780</span>
                        <span class="text-gray-500 text-[10px]">Sisa hari: ∞</span>
                    </div>
                    <div class="progress-bar-simple">
                        <div class="progress-fill-simple bg-secondary" style="width: 85%"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-md card-hover-effect flex items-stretch h-28">
            <div class="w-1/2 h-full flex-shrink-0 overflow-hidden">
                <img src="{{ asset('assets/img/ontheroad.jpg') }}" alt="Beasiswa Santri Selfa"
                    class="w-full h-full object-cover">
            </div>

            <div class="py-2 px-3 flex flex-col justify-between w-full">
                <div>
                    <h3 class="text-xs font-bold text-primary leading-snug line-clamp-2">Si Jum On The Road</h3>
                </div>

                <div class="mt-1">
                    <div class="flex justify-between text-xs text-gray-800 mb-0.5">
                        <span class="font-semibold text-[10px]">Terkumpul: Rp 48.060.534</span>
                        <span class="text-gray-500 text-[10px]">Sisa hari: ∞</span>
                    </div>
                    <div class="progress-bar-simple">
                        <div class="progress-fill-simple bg-secondary" style="width: 60%"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-md card-hover-effect flex items-stretch h-28">
            <div class="w-1/2 h-full flex-shrink-0 overflow-hidden">
                <img src="{{ asset('assets/img/wakaf.jpeg') }}" alt="Beasiswa Santri Selfa"
                    class="w-full h-full object-cover">
            </div>

            <div class="py-2 px-3 flex flex-col justify-between w-full">
                <div>
                    <h3 class="text-xs font-bold text-primary leading-snug line-clamp-2">Wakaf Produktif Perluasan Lahan
                    </h3>
                </div>
                <div class="mt-1">
                    <div class="flex justify-between text-xs text-gray-800 mb-0.5">
                        <span class="font-semibold text-[10px]">Terkumpul: Rp 175.500.000</span>
                        <span class="text-gray-500 text-[10px]">Sisa hari: ∞</span>
                    </div>
                    <div class="progress-bar-simple">
                        <div class="progress-fill-simple bg-secondary" style="width: 70%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center mt-8">
        <button
            class="bg-primary text-white font-semibold px-5 py-2.5 rounded-lg text-sm hover:bg-grayDark transition-all flex items-center justify-center mx-auto">
            <span>Lihat Program Lainnya</span>
            <i class="fas fa-arrow-right ml-2 text-xs"></i>
        </button>
    </div>
</section>
<!-- Features Section -->
<section class="features-section py-8 rounded-2xl mb-12 px-4">
    <div class="text-center mb-6">
        <h2 class="text-xl font-bold text-primary mb-2">Fitur Lainnya ABBI</h2>
        <p class="text-gray-500 text-xs">Nikmati berbagai fitur menarik untuk mendukung ibadah dan aktivitas kebaikan
            Anda.</p>
    </div>

    <div class="grid grid-cols-4 gap-3">
        <a href="/quran" class="group flex flex-col items-center text-center space-y-1 transition-all duration-200">
            <div
                class="w-12 h-12 flex items-center justify-center rounded-full bg-gray-100 group-hover:bg-[#C8A951]/10 border border-[#C8A951]/40 transition-colors">
                <i class="fas fa-book-quran text-[#C8A951] text-base"></i>
            </div>
            <span class="text-[11px] font-medium text-gray-700">Al-Quran</span>
        </a>

        <a href="/nashohul-ibad"
            class="group flex flex-col items-center text-center space-y-1 transition-all duration-200">
            <div
                class="w-12 h-12 flex items-center justify-center rounded-full bg-gray-100 group-hover:bg-[#C8A951]/10 border border-[#C8A951]/40 transition-colors">
                <i class="fas fa-book text-[#C8A951] text-base"></i>
            </div>
            <span class="text-[11px] font-medium text-gray-700">Nashohul Ibad</span>
        </a>

        <a href="/doa" class="group flex flex-col items-center text-center space-y-1 transition-all duration-200">
            <div
                class="w-12 h-12 flex items-center justify-center rounded-full bg-gray-100 group-hover:bg-[#C8A951]/10 border border-[#C8A951]/40 transition-colors">
                <i class="fas fa-hands-praying text-[#C8A951] text-base"></i>
            </div>
            <span class="text-[11px] font-medium text-gray-700">Doa</span>
        </a>

        <a href="/webtoon" class="group flex flex-col items-center text-center space-y-1 transition-all duration-200">
            <div
                class="w-12 h-12 flex items-center justify-center rounded-full bg-gray-100 group-hover:bg-[#C8A951]/10 border border-[#C8A951]/40 transition-colors">
                <i class="fas fa-images text-[#C8A951] text-base"></i>
            </div>
            <span class="text-[11px] font-medium text-gray-700">Webtoon</span>
        </a>
    </div>
</section>
<!-- Berita Section -->
<section class="mb-12" id="berita">
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
            <p class="text-gray-600 text-xs line-clamp-2">Tim Ayobuatbaik telah menyalurkan bantuan darurat untuk korban
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
            <p class="text-gray-600 text-xs line-clamp-2">Tim Ayobuatbaik telah menyalurkan bantuan darurat untuk korban
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
    document.addEventListener("DOMContentLoaded", function () {
    const sliderContainer = document.querySelector(".slider-container");
    const sliderDots = document.querySelectorAll(".slider-dot");
    let currentSlide = 0;
    const totalSlides = 3;

    function updateSlider() {
        if (sliderContainer) {
            sliderContainer.scrollTo({
                left: currentSlide * sliderContainer.offsetWidth,
                behavior: "smooth",
            });

            sliderDots.forEach((dot, index) => {
                if (index === currentSlide) {
                    dot.classList.add("active");
                    dot.classList.remove("opacity-50");
                } else {
                    dot.classList.remove("active");
                    dot.classList.add("opacity-50");
                }
            });
        }
    }

    setInterval(() => {
        currentSlide = (currentSlide + 1) % totalSlides;
        updateSlider();
    }, 5000);

    sliderDots.forEach((dot, index) => {
        dot.addEventListener("click", () => {
            currentSlide = index;
            updateSlider();
        });
    });
});
</script>
@endsection