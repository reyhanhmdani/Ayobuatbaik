@extends('components.layout.app')

@section('title', 'Program Donasi - Ayobuatbaik')

@section('header-content')
@include('components.layout.header')
@endsection

@section('content')
<div class="content">
    <!-- Header Section -->
    <div class="bg-primary text-white pt-6 pb-8 px-4">
        <div class="flex justify-center items-center mb-4">
            <h1 class="text-2xl font-bold">Program Donasi</h1>
            <!-- <button class="w-10 h-10 flex items-center justify-center bg-white bg-opacity-20 rounded-full">
              <i class="fas fa-sliders-h text-white"></i>
            </button> -->
        </div>

        <!-- Search Bar -->
        <div class="relative mb-4">
            <div class="search-bar flex items-center">
                <i class="fas fa-search text-gray-400 mr-3"></i>
                <input type="text" placeholder="Cari program donasi..."
                    class="w-full bg-transparent outline-none text-gray-700 placeholder-gray-500">
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="flex justify-between text-center">
            <div>
                <p class="text-2xl font-bold">150+</p>
                <p class="text-xs text-gray-300">Program Aktif</p>
            </div>
            <div>
                <p class="text-2xl font-bold">25K+</p>
                <p class="text-xs text-gray-300">Donatur</p>
            </div>
            <div>
                <p class="text-2xl font-bold">Rp 5M+</p>
                <p class="text-xs text-gray-300">Terkumpul</p>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="bg-white px-4 py-3 border-b">
        <div class="flex space-x-2 overflow-x-auto pb-2 filter-section">
            <button class="filter-option whitespace-nowrap active" data-filter="all">Semua Program</button>
            <button class="filter-option whitespace-nowrap" data-filter="pendidikan">Pendidikan</button>
            <button class="filter-option whitespace-nowrap" data-filter="kemanusiaan">Kemanusiaan</button>
            <button class="filter-option whitespace-nowrap" data-filter="kesehatan">Kesehatan</button>
            <button class="filter-option whitespace-nowrap" data-filter="wakaf">Wakaf</button>
            <button class="filter-option whitespace-nowrap" data-filter="bencana">Bencana Alam</button>
        </div>
    </div>

    <!-- Programs List -->
    <div class="p-4 pb-24">
        <!-- Program: Pendidikan -->
        <a href="/program/beasiswa-santri-selfa"
            class="program-card bg-white overflow-hidden shadow-md flex items-stretch h-28 mb-4 rounded-xl transition-all duration-300 hover:shadow-lg hover:scale-[1.01]"
            data-category="pendidikan">
            <div class="w-1/2 h-full flex-shrink-0 overflow-hidden">
                <img src="{{ asset('assets/img/beasiswaashabi.jpeg') }}" alt="Beasiswa Santri Selfa"
                    class="w-full h-full object-cover" loading="lazy">
            </div>
            <div class="py-2 px-3 flex flex-col justify-between w-full">
                <div>
                    <h3 class="text-xs font-bold text-primary leading-snug line-clamp-2">Beasiswa Santri Selfa</h3>
                    <p class="text-gray-600 text-[10px] mt-0.5">
                        Bantu pendidikan santri berprestasi dari keluarga kurang mampu
                    </p>
                </div>
                <div class="mt-1">
                    <div class="flex justify-between text-[10px] text-gray-800 mb-0.5">
                        <span class="font-semibold">Terkumpul: Rp 119.373.780</span>
                        <span class="text-gray-500">Sisa hari: ∞</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-1.5">
                        <div class="bg-secondary h-1.5 rounded-full" style="width: 85%"></div>
                    </div>
                </div>
            </div>
        </a>

        <!-- Program: Kemanusiaan -->
        <a href="/program/si-jum"
            class="program-card bg-white overflow-hidden shadow-md flex items-stretch h-28 mb-4 rounded-xl transition-all duration-300 hover:shadow-lg hover:scale-[1.01]"
            data-category="kemanusiaan">
            <div class="w-1/2 h-full flex-shrink-0 overflow-hidden">
                <img src="{{ asset('assets/img/ontheroad.jpg') }}" alt="Si Jum On The Road"
                    class="w-full h-full object-cover" loading="lazy">
            </div>
            <div class="py-2 px-3 flex flex-col justify-between w-full">
                <div>
                    <h3 class="text-xs font-bold text-primary leading-snug line-clamp-2">Si Jum On The Road</h3>
                    <p class="text-gray-600 text-[10px] mt-0.5">
                        Program bakti sosial keliling membantu masyarakat kurang mampu
                    </p>
                </div>
                <div class="mt-1">
                    <div class="flex justify-between text-[10px] text-gray-800 mb-0.5">
                        <span class="font-semibold">Terkumpul: Rp 48.060.534</span>
                        <span class="text-gray-500">Sisa hari: ∞</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-1.5">
                        <div class="bg-secondary h-1.5 rounded-full" style="width: 60%"></div>
                    </div>
                </div>
            </div>
        </a>

        <!-- Program: Wakaf -->
        <a href="/program/wakaf-lahan"
            class="program-card bg-white overflow-hidden shadow-md flex items-stretch h-28 mb-4 rounded-xl transition-all duration-300 hover:shadow-lg hover:scale-[1.01]"
            data-category="wakaf">
            <div class="w-1/2 h-full flex-shrink-0 overflow-hidden">
                <img src="{{ asset('assets/img/wakaf.jpeg') }}" alt="Wakaf Produktif" class="w-full h-full object-cover"
                    loading="lazy">
            </div>
            <div class="py-2 px-3 flex flex-col justify-between w-full">
                <div>
                    <h3 class="text-xs font-bold text-primary leading-snug line-clamp-2">
                        Wakaf Produktif Perluasan Lahan
                    </h3>
                    <p class="text-gray-600 text-[10px] mt-0.5">
                        Wakaf untuk pengembangan lahan produktif masyarakat
                    </p>
                </div>
                <div class="mt-1">
                    <div class="flex justify-between text-[10px] text-gray-800 mb-0.5">
                        <span class="font-semibold">Terkumpul: Rp 175.500.000</span>
                        <span class="text-gray-500">Sisa hari: ∞</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-1.5">
                        <div class="bg-secondary h-1.5 rounded-full" style="width: 70%"></div>
                    </div>
                </div>
            </div>
        </a>

        <!-- Program: Kesehatan -->
        <a href="/program/bantuan-kesehatan"
            class="program-card bg-white overflow-hidden shadow-md flex items-stretch h-28 mb-4 rounded-xl transition-all duration-300 hover:shadow-lg hover:scale-[1.01]"
            data-category="kesehatan">
            <div class="w-1/2 h-full flex-shrink-0 overflow-hidden">
                <img src="https://images.unsplash.com/photo-1576091160399-112ba8d25d1f?auto=format&fit=crop&w=1170&q=80"
                    alt="Bantuan Kesehatan" class="w-full h-full object-cover">
            </div>
            <div class="py-2 px-3 flex flex-col justify-between w-full">
                <div>
                    <h3 class="text-xs font-bold text-primary leading-snug line-clamp-2">Bantuan Operasi Katarak</h3>
                    <p class="text-gray-600 text-[10px] mt-0.5">
                        Bantu operasi katarak gratis untuk lansia tidak mampu
                    </p>
                </div>
                <div class="mt-1">
                    <div class="flex justify-between text-[10px] text-gray-800 mb-0.5">
                        <span class="font-semibold">Terkumpul: Rp 89.250.000</span>
                        <span class="text-gray-500">Sisa hari: 45</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-1.5">
                        <div class="bg-secondary h-1.5 rounded-full" style="width: 45%"></div>
                    </div>
                </div>
            </div>
        </a>

        <!-- Program: Bencana Alam -->
        <a href="/program/bantuan-bencana"
            class="program-card bg-white overflow-hidden shadow-md flex items-stretch h-28 mb-4 rounded-xl transition-all duration-300 hover:shadow-lg hover:scale-[1.01]"
            data-category="bencana">
            <div class="w-1/2 h-full flex-shrink-0 overflow-hidden">
                <img src="https://images.unsplash.com/photo-1583324113626-70b8f5d2d6ae?auto=format&fit=crop&w=1170&q=80"
                    alt="Bantuan Bencana" class="w-full h-full object-cover">
            </div>
            <div class="py-2 px-3 flex flex-col justify-between w-full">
                <div>
                    <h3 class="text-xs font-bold text-primary leading-snug line-clamp-2">
                        Bantuan Korban Gempa Lombok
                    </h3>
                    <p class="text-gray-600 text-[10px] mt-0.5">Bantuan darurat untuk korban gempa di Lombok</p>
                </div>
                <div class="mt-1">
                    <div class="flex justify-between text-[10px] text-gray-800 mb-0.5">
                        <span class="font-semibold">Terkumpul: Rp 325.780.000</span>
                        <span class="text-gray-500">Sisa hari: 15</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-1.5">
                        <div class="bg-secondary h-1.5 rounded-full" style="width: 92%"></div>
                    </div>
                </div>
            </div>
        </a>

    </div>


</div>
@endsection


@section('scripts')
<script src="//unpkg.com/alpinejs" defer></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
    const filterButtons = document.querySelectorAll(".filter-option");
    const programCards = document.querySelectorAll(".program-card");
    const searchInput = document.querySelector('input[type="text"]');

    let activeFilter = "all"; // menyimpan filter aktif

    // Fungsi untuk update tampilan card
    function updateCards() {
        const searchTerm = searchInput.value.toLowerCase();

        programCards.forEach(card => {
            const matchesFilter =
                activeFilter === "all" ||
                card.getAttribute("data-category") === activeFilter;
            const title = card.querySelector("h3").textContent.toLowerCase();
            const description = card.querySelector("p").textContent.toLowerCase();
            const matchesSearch =
                title.includes(searchTerm) || description.includes(searchTerm);

            if (matchesFilter && matchesSearch) {
                card.classList.remove("hidden");
                card.classList.add("flex");
            } else {
                card.classList.add("hidden");
                card.classList.remove("flex");
            }
        });
    }

    // Klik tombol kategori
    filterButtons.forEach(button => {
        button.addEventListener("click", function() {
            activeFilter = this.getAttribute("data-filter");

            // update tombol aktif
            filterButtons.forEach(btn => btn.classList.remove("active", "bg-primary", "text-white"));
            this.classList.add("active", "bg-primary", "text-white");

            updateCards();
        });
    });

    // Input pencarian
    if (searchInput) {
        searchInput.addEventListener("input", updateCards);
    }

    // Inisialisasi awal (tampilkan semua)
    updateCards();
});
</script>

@endsection
