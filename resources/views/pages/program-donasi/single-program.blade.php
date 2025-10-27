@extends('components.layout.app')

@section('title', 'Beasiswa Santri Selfa - Ayobuatbaik')

@section('header-content')
@include('components.layout.header-with-search')
@endsection

@section('content')
<div class="content pb-20">
    <!-- Campaign Header Image -->
    <div class="relative h-64 overflow-hidden">
        <img src="{{ asset('assets/img/beasiswaashabi.jpeg') }}" alt="Beasiswa Santri Selfa"
            class="w-full h-full object-cover" loading="lazy" />
        <div class="absolute inset-0 bg-black bg-opacity-30 flex items-end">
            <div class="p-4 text-white">
                <h2 class="text-xl font-bold">Beasiswa Santri Selfa</h2>
                <p class="text-sm mt-1">Bantu pendidikan santri berprestasi dari keluarga kurang mampu</p>
            </div>
        </div>
    </div>

    <!-- Campaign Stats -->
    <div class="bg-white p-4 shadow-sm">
        <div class="flex justify-between items-center mb-3">
            <div>
                <p class="text-xs text-gray-500">Terkumpul</p>
                <p class="text-lg font-bold text-primary">Rp 119.373.780</p>
            </div>
            <div class="text-right">
                <p class="text-xs text-gray-500">Target</p>
                <p class="text-lg font-bold text-primary">Rp 140.000.000</p>
            </div>
        </div>

        <!-- Progress Bar -->
        <div class="mb-3">
            <div class="progress-bar-simple bg-gray-200">
                <div class="progress-fill-simple bg-secondary" style="width: 85%"></div>
            </div>
            <div class="flex justify-between text-xs text-gray-500 mt-1">
                <span>85%</span>
                <span>Sisa hari: ∞</span>
            </div>
        </div>

        <!-- Donors Count -->
        <div class="flex items-center text-sm text-gray-600">
            <i class="fas fa-users text-secondary mr-2"></i>
            <span>1.245 donatur telah berkontribusi</span>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="bg-white p-4 flex space-x-3 shadow-sm">
        <button class="flex-1 donation-btn py-3 rounded-lg font-semibold text-center">
            <i class="fas fa-heart mr-2"></i>Donasi Sekarang
        </button>
        <button class="w-12 h-12 flex items-center justify-center border border-gray-300 rounded-lg">
            <i class="fas fa-share-alt text-gray-600"></i>
        </button>
    </div>

    <!-- Campaign Tabs - Hanya 2 Tab -->
    <div class="bg-white mt-4">
        <div class="flex border-b">
            <button class="tab-button flex-1 py-3 text-center font-medium active" data-tab="deskripsi">
                Deskripsi
            </button>
            <button class="tab-button flex-1 py-3 text-center font-medium" data-tab="donatur">
                Donatur (1.245)
            </button>
        </div>

        <!-- Tab Content -->
        <div class="p-4">
            <!-- Deskripsi Tab (Gabung dengan Update) -->
            <div id="deskripsi-tab" class="tab-content">
                <!-- Tentang Program -->
                <div class="mb-6">
                    <h3 class="font-bold text-lg mb-3">Tentang Program</h3>
                    <div class="text-gray-700 text-sm space-y-4">
                        <p>
                            Program Beasiswa Santri Selfa merupakan inisiatif untuk membantu santri-santri berprestasi
                            dari
                            keluarga kurang mampu agar dapat melanjutkan pendidikan mereka di pondok pesantren. Program
                            ini
                            bertujuan untuk memberikan kesempatan yang sama bagi setiap anak untuk mendapatkan
                            pendidikan agama yang berkualitas.
                        </p>

                        <h4 class="font-bold text-primary mt-4">Manfaat Program</h4>
                        <ul class="list-disc pl-5 space-y-2">
                            <li>Biaya pendidikan selama satu tahun</li>
                            <li>Buku dan alat tulis</li>
                            <li>Seragam pesantren</li>
                            <li>Bantuan hidup bulanan</li>
                        </ul>

                        <h4 class="font-bold text-primary mt-4">Kriteria Penerima</h4>
                        <ul class="list-disc pl-5 space-y-2">
                            <li>Santri aktif di pondok pesantren</li>
                            <li>Berprestasi akademik atau non-akademik</li>
                            <li>Keluarga dengan ekonomi menengah ke bawah</li>
                            <li>Memiliki motivasi tinggi untuk belajar</li>
                        </ul>
                    </div>
                </div>

                <!-- Update Terbaru (Gabung ke Deskripsi) -->
                <div class="mb-6">
                    <h3 class="font-bold text-lg mb-3">Update Terbaru</h3>
                    <div class="space-y-4">
                        <div class="border-l-4 border-secondary pl-4 py-1">
                            <p class="text-xs text-gray-500">15 Juni 2023</p>
                            <p class="font-medium mt-1">Pendaftaran gelombang kedua telah dibuka</p>
                            <p class="text-sm text-gray-700 mt-1">
                                Pendaftaran untuk gelombang kedua beasiswa santri Selfa telah dibuka hingga 30 Juni
                                2023.
                            </p>
                        </div>

                        <div class="border-l-4 border-secondary pl-4 py-1">
                            <p class="text-xs text-gray-500">1 Juni 2023</p>
                            <p class="font-medium mt-1">Seleksi tahap pertama telah selesai</p>
                            <p class="text-sm text-gray-700 mt-1">
                                Seleksi tahap pertama untuk 50 calon penerima beasiswa telah selesai. Tahap wawancara
                                akan
                                dimulai minggu depan.
                            </p>
                        </div>

                        <div class="border-l-4 border-secondary pl-4 py-1">
                            <p class="text-xs text-gray-500">20 Mei 2023</p>
                            <p class="font-medium mt-1">Program telah mencapai 70% dari target</p>
                            <p class="text-sm text-gray-700 mt-1">
                                Terima kasih kepada semua donatur, program beasiswa santri Selfa telah mencapai 70% dari
                                target pengumpulan dana.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Galeri Program -->
                <div>
                    <h3 class="font-bold text-lg mb-3">Galeri Program</h3>
                    <div class="image-gallery">
                        <img src="https://images.unsplash.com/photo-1503676260728-1c00da094a0b?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80"
                            alt="Siswa berprestasi" loading="lazy" />
                        <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80"
                            alt="Kelas agama" loading="lazy" />
                        <img src="https://images.unsplash.com/photo-1503676260728-1c00da094a0b?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80"
                            alt="Siswa berprestasi" loading="lazy" />
                        <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80"
                            alt="Kelas agama" loading="lazy" />
                    </div>
                </div>
            </div>

            <!-- Donatur Tab (Full Height untuk Scroll) -->
            <div id="donatur-tab" class="tab-content hidden">
                <h3 class="font-bold text-lg mb-4">Daftar Donatur</h3>
                <div class="space-y-3 max-h-96 overflow-y-auto custom-scrollbar">
                    <!-- Sample Donatur Data - Bisa banyak karena scrollable -->
                    <div class="flex items-center justify-between py-2 border-b">
                        <div class="flex items-center">
                            <div
                                class="w-8 h-8 rounded-full bg-secondary flex items-center justify-center text-white text-xs font-bold mr-3">
                                A
                            </div>
                            <div>
                                <p class="font-medium text-sm">Ahmad S.</p>
                                <p class="text-xs text-gray-500">2 jam yang lalu</p>
                            </div>
                        </div>
                        <p class="font-bold text-secondary">Rp 500.000</p>
                    </div>

                    <div class="flex items-center justify-between py-2 border-b">
                        <div class="flex items-center">
                            <div
                                class="w-8 h-8 rounded-full bg-secondary flex items-center justify-center text-white text-xs font-bold mr-3">
                                S
                            </div>
                            <div>
                                <p class="font-medium text-sm">Siti M.</p>
                                <p class="text-xs text-gray-500">5 jam yang lalu</p>
                            </div>
                        </div>
                        <p class="font-bold text-secondary">Rp 250.000</p>
                    </div>

                    <div class="flex items-center justify-between py-2 border-b">
                        <div class="flex items-center">
                            <div
                                class="w-8 h-8 rounded-full bg-secondary flex items-center justify-center text-white text-xs font-bold mr-3">
                                R
                            </div>
                            <div>
                                <p class="font-medium text-sm">Rina W.</p>
                                <p class="text-xs text-gray-500">1 hari yang lalu</p>
                            </div>
                        </div>
                        <p class="font-bold text-secondary">Rp 100.000</p>
                    </div>

                    <div class="flex items-center justify-between py-2 border-b">
                        <div class="flex items-center">
                            <div
                                class="w-8 h-8 rounded-full bg-secondary flex items-center justify-center text-white text-xs font-bold mr-3">
                                M
                            </div>
                            <div>
                                <p class="font-medium text-sm">M. Fajar</p>
                                <p class="text-xs text-gray-500">1 hari yang lalu</p>
                            </div>
                        </div>
                        <p class="font-bold text-secondary">Rp 1.000.000</p>
                    </div>

                    <div class="flex items-center justify-between py-2 border-b">
                        <div class="flex items-center">
                            <div
                                class="w-8 h-8 rounded-full bg-secondary flex items-center justify-center text-white text-xs font-bold mr-3">
                                D
                            </div>
                            <div>
                                <p class="font-medium text-sm">Doni P.</p>
                                <p class="text-xs text-gray-500">2 hari yang lalu</p>
                            </div>
                        </div>
                        <p class="font-bold text-secondary">Rp 75.000</p>
                    </div>

                    <!-- Tambahan donatur untuk demo scroll -->
                    <div class="flex items-center justify-between py-2 border-b">
                        <div class="flex items-center">
                            <div
                                class="w-8 h-8 rounded-full bg-secondary flex items-center justify-center text-white text-xs font-bold mr-3">
                                B
                            </div>
                            <div>
                                <p class="font-medium text-sm">Budi H.</p>
                                <p class="text-xs text-gray-500">3 hari yang lalu</p>
                            </div>
                        </div>
                        <p class="font-bold text-secondary">Rp 300.000</p>
                    </div>

                    <div class="flex items-center justify-between py-2 border-b">
                        <div class="flex items-center">
                            <div
                                class="w-8 h-8 rounded-full bg-secondary flex items-center justify-center text-white text-xs font-bold mr-3">
                                L
                            </div>
                            <div>
                                <p class="font-medium text-sm">Lina K.</p>
                                <p class="text-xs text-gray-500">3 hari yang lalu</p>
                            </div>
                        </div>
                        <p class="font-bold text-secondary">Rp 150.000</p>
                    </div>

                    <div class="flex items-center justify-between py-2 border-b">
                        <div class="flex items-center">
                            <div
                                class="w-8 h-8 rounded-full bg-secondary flex items-center justify-center text-white text-xs font-bold mr-3">
                                F
                            </div>
                            <div>
                                <p class="font-medium text-sm">Fajar R.</p>
                                <p class="text-xs text-gray-500">4 hari yang lalu</p>
                            </div>
                        </div>
                        <p class="font-bold text-secondary">Rp 2.000.000</p>
                    </div>

                    <div class="flex items-center justify-between py-2 border-b">
                        <div class="flex items-center">
                            <div
                                class="w-8 h-8 rounded-full bg-secondary flex items-center justify-center text-white text-xs font-bold mr-3">
                                N
                            </div>
                            <div>
                                <p class="font-medium text-sm">Nina S.</p>
                                <p class="text-xs text-gray-500">4 hari yang lalu</p>
                            </div>
                        </div>
                        <p class="font-bold text-secondary">Rp 50.000</p>
                    </div>

                    <div class="flex items-center justify-between py-2 border-b">
                        <div class="flex items-center">
                            <div
                                class="w-8 h-8 rounded-full bg-secondary flex items-center justify-center text-white text-xs font-bold mr-3">
                                R
                            </div>
                            <div>
                                <p class="font-medium text-sm">Rudi T.</p>
                                <p class="text-xs text-gray-500">5 hari yang lalu</p>
                            </div>
                        </div>
                        <p class="font-bold text-secondary">Rp 1.500.000</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Campaigns -->
    <div class="bg-white mt-4 p-4">
        <h3 class="font-bold text-lg mb-3">Program Lainnya</h3>
        <div class="space-y-4">
            <div class="flex border rounded-lg overflow-hidden">
                <div class="w-24 h-24 flex-shrink-0">
                    <img src="{{ asset('assets/img/ontheroad.jpg') }}" alt="Si Jum On The Road"
                        class="w-full h-full object-cover" loading="lazy" />
                </div>
                <div class="p-3 flex-1">
                    <h4 class="font-bold text-sm">Si Jum On The Road</h4>
                    <div class="flex justify-between text-xs text-gray-500 mt-1">
                        <span>Terkumpul: Rp 48.060.534</span>
                        <span>Sisa hari: ∞</span>
                    </div>
                    <div class="progress-bar-simple bg-gray-200 mt-2">
                        <div class="progress-fill-simple bg-secondary" style="width: 60%"></div>
                    </div>
                </div>
            </div>

            <div class="flex border rounded-lg overflow-hidden">
                <div class="w-24 h-24 flex-shrink-0">
                    <img src="{{ asset('assets/img/wakaf.jpeg') }}" alt="Wakaf Produktif"
                        class="w-full h-full object-cover" loading="lazy" />
                </div>
                <div class="p-3 flex-1">
                    <h4 class="font-bold text-sm">Wakaf Produktif Perluasan Lahan</h4>
                    <div class="flex justify-between text-xs text-gray-500 mt-1">
                        <span>Terkumpul: Rp 175.500.000</span>
                        <span>Sisa hari: ∞</span>
                    </div>
                    <div class="progress-bar-simple bg-gray-200 mt-2">
                        <div class="progress-fill-simple bg-secondary" style="width: 70%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Donation Modal (tetap sama) -->
<div id="donation-modal" class="donation-modal hidden">
    <!-- Modal content tetap sama -->
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        console.log("Script loaded");

        // Tab functionality - Hanya 2 tab sekarang
        const tabButtons = document.querySelectorAll(".tab-button");
        const tabContents = document.querySelectorAll(".tab-content");

        tabButtons.forEach((button) => {
            button.addEventListener("click", function () {
                const tabId = this.getAttribute("data-tab");

                tabButtons.forEach((btn) => btn.classList.remove("active"));
                this.classList.add("active");

                tabContents.forEach((content) => content.classList.add("hidden"));
                document.getElementById(`${tabId}-tab`).classList.remove("hidden");
            });
        });

        // Donation modal functionality
        const donationBtn = document.querySelector(".donation-btn");
        const donationModal = document.getElementById("donation-modal");
        const closeModal = document.getElementById("close-modal");

        if (donationModal) {
            donationModal.classList.add("hidden");
        }

        if (donationBtn) {
            donationBtn.addEventListener("click", function () {
                if (donationModal) {
                    donationModal.classList.remove("hidden");
                }
            });
        }

        if (closeModal) {
            closeModal.addEventListener("click", function () {
                if (donationModal) {
                    donationModal.classList.add("hidden");
                }
            });
        }

        // Amount selection
        const amountOptions = document.querySelectorAll(".amount-option");
        const customAmountInput = document.getElementById("custom-amount");

        amountOptions.forEach((option) => {
            option.addEventListener("click", function () {
                amountOptions.forEach((opt) => opt.classList.remove("selected"));
                this.classList.add("selected");
                if (customAmountInput) customAmountInput.value = "";
            });
        });

        if (customAmountInput) {
            customAmountInput.addEventListener("input", function () {
                amountOptions.forEach((opt) => opt.classList.remove("selected"));
            });
        }
    });
</script>
@endsection