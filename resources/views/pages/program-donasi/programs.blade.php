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
    <div class="p-4">
        <!-- Program 1 -->
        <div class="program-card bg-white shadow-md mb-4" data-category="pendidikan">
            <div class="relative">
                <img src="{{ asset('assets/img/beasiswaashabi.jpeg') }}" alt="Beasiswa Santri Selfa"
                    class="w-full h-auto object-cover" loading="lazy">

                <div class="category-badge">Pendidikan</div>
            </div>
            <div class="p-4">
                <h3 class="font-bold text-lg mb-2">Beasiswa Santri Selfa</h3>
                <p class="text-gray-600 text-sm mb-3">Bantu pendidikan santri berprestasi dari keluarga kurang mampu</p>

                <div class="mb-3">
                    <div class="flex justify-between text-xs text-gray-800 mb-1">
                        <span class="font-semibold">Terkumpul: Rp 119.373.780</span>
                        <span class="text-gray-500">85%</span>
                    </div>
                    <div class="progress-bar-simple bg-gray-200">
                        <div class="progress-fill-simple bg-secondary" style="width: 85%"></div>
                    </div>
                    <div class="flex justify-between text-xs text-gray-500 mt-1">
                        <span>Target: Rp 140.000.000</span>
                        <span>∞ hari lagi</span>
                    </div>
                </div>

                <div class="flex justify-between items-center">
                    <div class="flex items-center text-xs text-gray-600">
                        <i class="fas fa-users text-secondary mr-1"></i>
                        <span>1.245 donatur</span>
                    </div>
                    <button
                        class="bg-secondary text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-goldDark transition-colors">
                        Donasi
                    </button>
                </div>
            </div>
        </div>

        <!-- Program 2 -->
        <div class="program-card bg-white shadow-md mb-4" data-category="kemanusiaan">
            <div class="relative">
                <img src="{{ asset('assets/img/ontheroad.jpg') }}" alt="Si Jum On The Road"
                    class="w-full h-auto object-cover" loading="lazy">
                <div class="category-badge">Kemanusiaan</div>
            </div>
            <div class="p-4">
                <h3 class="font-bold text-lg mb-2">Si Jum On The Road</h3>
                <p class="text-gray-600 text-sm mb-3">Program bakti sosial keliling membantu masyarakat kurang mampu</p>

                <div class="mb-3">
                    <div class="flex justify-between text-xs text-gray-800 mb-1">
                        <span class="font-semibold">Terkumpul: Rp 48.060.534</span>
                        <span class="text-gray-500">60%</span>
                    </div>
                    <div class="progress-bar-simple bg-gray-200">
                        <div class="progress-fill-simple bg-secondary" style="width: 60%"></div>
                    </div>
                    <div class="flex justify-between text-xs text-gray-500 mt-1">
                        <span>Target: Rp 80.000.000</span>
                        <span>∞ hari lagi</span>
                    </div>
                </div>

                <div class="flex justify-between items-center">
                    <div class="flex items-center text-xs text-gray-600">
                        <i class="fas fa-users text-secondary mr-1"></i>
                        <span>892 donatur</span>
                    </div>
                    <button
                        class="bg-secondary text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-goldDark transition-colors">
                        Donasi
                    </button>
                </div>
            </div>
        </div>

        <!-- Program 3 -->
        <div class="program-card bg-white shadow-md mb-4" data-category="wakaf">
            <div class="relative">
                <img src="{{ asset('assets/img/wakaf.jpeg') }}" alt="Wakaf Produktif Perluasan Lahan"
                    class="w-full h-auto object-cover" loading="lazy">
                <div class="category-badge">Wakaf</div>
            </div>
            <div class="p-4">
                <h3 class="font-bold text-lg mb-2">Wakaf Produktif Perluasan Lahan</h3>
                <p class="text-gray-600 text-sm mb-3">Wakaf untuk pengembangan lahan produktif masyarakat</p>

                <div class="mb-3">
                    <div class="flex justify-between text-xs text-gray-800 mb-1">
                        <span class="font-semibold">Terkumpul: Rp 175.500.000</span>
                        <span class="text-gray-500">70%</span>
                    </div>
                    <div class="progress-bar-simple bg-gray-200">
                        <div class="progress-fill-simple bg-secondary" style="width: 70%"></div>
                    </div>
                    <div class="flex justify-between text-xs text-gray-500 mt-1">
                        <span>Target: Rp 250.000.000</span>
                        <span>∞ hari lagi</span>
                    </div>
                </div>

                <div class="flex justify-between items-center">
                    <div class="flex items-center text-xs text-gray-600">
                        <i class="fas fa-users text-secondary mr-1"></i>
                        <span>2.134 donatur</span>
                    </div>
                    <button
                        class="bg-secondary text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-goldDark transition-colors">
                        Donasi
                    </button>
                </div>
            </div>
        </div>

        <!-- Program 4 -->
        <div class="program-card bg-white shadow-md mb-4" data-category="kesehatan">
            <div class="relative">
                <img src="https://images.unsplash.com/photo-1576091160399-112ba8d25d1f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80"
                    alt="Bantuan Kesehatan" class="w-full h-48 object-cover">
                <div class="category-badge">Kesehatan</div>
            </div>
            <div class="p-4">
                <h3 class="font-bold text-lg mb-2">Bantuan Operasi Katarak</h3>
                <p class="text-gray-600 text-sm mb-3">Bantu operasi katarak gratis untuk lansia tidak mampu</p>

                <div class="mb-3">
                    <div class="flex justify-between text-xs text-gray-800 mb-1">
                        <span class="font-semibold">Terkumpul: Rp 89.250.000</span>
                        <span class="text-gray-500">45%</span>
                    </div>
                    <div class="progress-bar-simple bg-gray-200">
                        <div class="progress-fill-simple bg-secondary" style="width: 45%"></div>
                    </div>
                    <div class="flex justify-between text-xs text-gray-500 mt-1">
                        <span>Target: Rp 200.000.000</span>
                        <span>45 hari lagi</span>
                    </div>
                </div>

                <div class="flex justify-between items-center">
                    <div class="flex items-center text-xs text-gray-600">
                        <i class="fas fa-users text-secondary mr-1"></i>
                        <span>567 donatur</span>
                    </div>
                    <button
                        class="bg-secondary text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-goldDark transition-colors">
                        Donasi
                    </button>
                </div>
            </div>
        </div>

        <!-- Program 5 -->
        <div class="program-card bg-white shadow-md mb-4" data-category="bencana">
            <div class="relative">
                <img src="https://images.unsplash.com/photo-1583324113626-70b8f5d2d6ae?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80"
                    alt="Bantuan Bencana" class="w-full h-48 object-cover">
                <div class="category-badge">Bencana Alam</div>
            </div>
            <div class="p-4">
                <h3 class="font-bold text-lg mb-2">Bantuan Korban Gempa Lombok</h3>
                <p class="text-gray-600 text-sm mb-3">Bantuan darurat untuk korban gempa di Lombok</p>

                <div class="mb-3">
                    <div class="flex justify-between text-xs text-gray-800 mb-1">
                        <span class="font-semibold">Terkumpul: Rp 325.780.000</span>
                        <span class="text-gray-500">92%</span>
                    </div>
                    <div class="progress-bar-simple bg-gray-200">
                        <div class="progress-fill-simple bg-secondary" style="width: 92%"></div>
                    </div>
                    <div class="flex justify-between text-xs text-gray-500 mt-1">
                        <span>Target: Rp 350.000.000</span>
                        <span>15 hari lagi</span>
                    </div>
                </div>

                <div class="flex justify-between items-center">
                    <div class="flex items-center text-xs text-gray-600">
                        <i class="fas fa-users text-secondary mr-1"></i>
                        <span>3.421 donatur</span>
                    </div>
                    <button
                        class="bg-secondary text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-goldDark transition-colors">
                        Donasi
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
    // Filter functionality
    const filterButtons = document.querySelectorAll(".filter-option");
    const programCards = document.querySelectorAll(".program-card");

    filterButtons.forEach(button => {
        button.addEventListener("click", function() {
            const filter = this.getAttribute("data-filter");

            // Update active filter button
            filterButtons.forEach(btn => btn.classList.remove("active"));
            this.classList.add("active");

            // Filter programs
            programCards.forEach(card => {
                if (filter === "all" || card.getAttribute("data-category") === filter) {
                    card.style.display = "block";
                } else {
                    card.style.display = "none";
                }
            });
        });
    });

    // Search functionality
    const searchInput = document.querySelector('input[type="text"]');
    searchInput.addEventListener("input", function() {
        const searchTerm = this.value.toLowerCase();

        programCards.forEach(card => {
            const title = card.querySelector("h3").textContent.toLowerCase();
            const description = card.querySelector("p").textContent.toLowerCase();

            if (title.includes(searchTerm) || description.includes(searchTerm)) {
                card.style.display = "block";
            } else {
                card.style.display = "none";
            }
        });
    });
});
</script>
@endsection
