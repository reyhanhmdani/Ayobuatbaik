@extends('components.layout.app')

@section('title', $program->title)

@section('og_title', $program->title)
@section('og_description', $program->short_description)
@section('og_url', 'https://ayobuatbaik.com')
@section('og_image', 'https://ayobuatbaik.com/storage/' . $program->gambar)

@section('header-content')
    @include('components.layout.header-with-search')
@endsection

@section('styles')
    <style>
        /* Style untuk Tab Aktif */
        .tab-button.active {
            color: #2563eb;
            /* blue-600 */
            border-bottom: 2px solid #2563eb;
        }

        /* Style untuk Pilihan Nominal */
        .amount-option {
            cursor: pointer;
            padding: 0.5rem;
            border: 1px solid #e5e7eb;
            /* gray-200 */
            border-radius: 0.5rem;
            text-align: center;
            font-size: 0.875rem;
            transition: all 0.2s;
        }

        .amount-option:hover {
            background-color: #f3f4f6;
        }

        .amount-option.selected {
            border-color: #3b82f6;
            /* blue-500 */
            background-color: #eff6ff;
            /* blue-50 */
            color: #1d4ed8;
            /* blue-700 */
            font-weight: 600;
        }

        /* Custom Scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 4px;
        }
    </style>
@endsection

@section('content')
    <div class="content pb-20">

        <!-- Hero Image -->
        <div class="relative h-64 overflow-hidden">
            <img src="{{ asset('storage/' . $program->gambar) }}" alt="{{ $program->title }}"
                class="w-full h-full object-cover" loading="lazy" />

            <div class="absolute inset-0 bg-black bg-opacity-20"></div>
        </div>

        <!-- Title & Short Description -->
        <div class="bg-white px-4 py-5 shadow-sm border-b">
            <h1 class="text-xl font-extrabold text-gray-900 leading-snug">
                {{ $program->title }}
            </h1>
            <p class="text-sm text-gray-600 mt-2">
                {{ $program->short_description ?? 'Deskripsi Belum tersedia.' }}
            </p>
        </div>

        <!-- Donation Stats -->
        <div class="bg-white p-4 shadow-sm">

            <div class="flex justify-between items-center mb-4">
                <div>
                    <p class="text-xs text-gray-500">Terkumpul</p>
                    <p class="text-lg md:text-xl font-extrabold text-primary">
                        Rp {{ number_format($program->collected_amount, 0, ',', '.') }}
                    </p>
                </div>

                <div class="text-right">
                    <p class="text-xs text-gray-500">Target</p>
                    <p class="text-lg md:text-xl font-extrabold text-primary">
                        Rp {{ number_format($program->target_amount, 0, ',', '.') }}
                    </p>
                </div>
            </div>

            @php
                $progress =
                    $program->target_amount > 0 ? ($program->collected_amount / $program->target_amount) * 100 : 0;
                $progress = min(100, $progress);

                $daysLeft = $program->end_date
                    ? floor(max(0, \Carbon\Carbon::now()->diffInDays($program->end_date, false)))
                    : '∞';
            @endphp

            <!-- Progress Bar -->
            <div class="mb-4">
                <div class="w-full bg-gray-200 rounded-full h-2.5 overflow-hidden">
                    <div class="bg-primary h-2.5 rounded-full transition-all duration-500"
                        style="width: {{ $progress }}%;">
                    </div>
                </div>

                <div class="flex justify-between text-xs text-gray-500 mt-1">
                    <span class="font-medium">{{ number_format($progress, 0) }}%</span>
                    <span>Sisa hari: {{ $daysLeft }}</span>
                </div>
            </div>

            <!-- Donor Count -->
            <div class="flex items-center text-sm text-gray-600">
                <i class="fas fa-users text-secondary mr-2"></i>
                <span>{{ number_format($donorsCount ?? 0) }} donatur telah berkontribusi</span>
            </div>
        </div>

        <div class="bg-white p-4 flex space-x-3 shadow-sm sticky top-0 z-10">
            <button
                class="flex-1 donation-btn bg-blue-600 text-white py-3 rounded-lg font-semibold text-center hover:bg-blue-700 transition">
                <i class="fas fa-heart mr-2"></i>Donasi Sekarang
            </button>
            <button
                class="w-12 h-12 flex items-center justify-center border border-gray-300 rounded-lg text-gray-600 hover:bg-gray-50">
                <i class="fas fa-share-alt"></i>
            </button>
        </div>

        <div class="bg-white mt-4">
            <div class="flex border-b text-gray-500">
                <button class="tab-button flex-1 py-3 text-center font-medium active" data-tab="deskripsi">
                    Deskripsi
                </button>
                {{-- Ganti $program->donors_count dengan $donorsCount dari controller --}}
                <button class="tab-button flex-1 py-3 text-center font-medium" data-tab="donatur">
                    Donatur ({{ number_format($donorsCount) }})
                </button>
            </div>

            <div class="p-4 min-h-[300px]">

                <div id="deskripsi-tab" class="tab-content">
                    {{-- Bagian Deskripsi tidak berubah --}}
                    <div class="mb-6">
                        <h3 class="font-bold text-lg mb-3">Tentang Program</h3>
                        <div class="prose prose-sm text-gray-700">
                            {!! $program->deskripsi !!}
                        </div>
                    </div>
                </div>

                <div id="donatur-tab" class="tab-content hidden">
                    <h3 class="font-bold text-lg mb-4">Daftar Donatur</h3>
                    <div class="space-y-3 max-h-96 overflow-y-auto custom-scrollbar">

                        {{-- 🚀 UBAH DARI DUMMY KE DATA REAL 🚀 --}}
                        @forelse($donations as $donation)
                            <div class="flex items-center justify-between py-2 border-b last:border-0">
                                <div class="flex items-center">
                                    <div
                                        class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-xs font-bold mr-3">
                                        {{-- Menggunakan Accessor getDonorInitialAttribute --}}
                                        {{ $donation->donor_initial }}
                                    </div>
                                    <div>
                                        {{-- Menampilkan nama donatur --}}
                                        <p class="font-medium text-sm">
                                            {{ $donation->donor_name && strtolower($donation->donor_name) !== 'null'
                                                ? $donation->donor_name
                                                : 'Hamba Allah' }}
                                        </p>
                                        {{-- Menampilkan waktu donasi yang lalu --}}
                                        <p class="text-xs text-gray-500">{{ $donation->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                {{-- Menampilkan nominal donasi --}}
                                <p class="font-bold text-blue-600 text-sm">Rp
                                    {{ number_format($donation->amount, 0, ',', '.') }}</p>
                            </div>
                        @empty
                            <div class="text-center py-10 text-gray-500">
                                <i class="fas fa-hand-holding-heart text-3xl mb-2 text-gray-300"></i>
                                <p class="text-sm">Belum ada donatur yang tercatat untuk program ini.</p>
                            </div>
                        @endforelse

                        @if ($donations->count() > 0)
                            <div class="text-center text-xs text-gray-400 mt-4">
                                -- Menampilkan {{ $donations->count() }} donatur terbaru --
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>

        @if ($relatedPrograms->isNotEmpty())
            <div class="bg-white mt-4 p-4 mb-8">
                <h3 class="font-bold text-lg mb-3">Program Lainnya</h3>
                <div class="space-y-4">
                    @foreach ($relatedPrograms as $item)
                        @php
                            $relProgress =
                                $item->target_amount > 0 ? ($item->collected_amount / $item->target_amount) * 100 : 0;
                            $relProgress = min(100, $relProgress);

                            $relDaysLeft = $item->end_date
                                ? floor(max(0, \Carbon\Carbon::now()->diffInDays($item->end_date, false)))
                                : '∞';
                        @endphp
                        <a href="{{ route('home.program.show', $item->slug) }}"
                            class="flex border rounded-lg overflow-hidden hover:shadow-md transition">
                            <div class="w-24 h-24 flex-shrink-0">
                                <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->title }}"
                                    class="w-full h-full object-cover" loading="lazy" />
                            </div>
                            <div class="p-3 flex-1">
                                <h4 class="font-bold text-sm line-clamp-2">{{ $item->title }}</h4>
                                <div class="flex justify-between text-xs text-gray-500 mt-1">
                                    <span>Terkumpul: {{ number_format($item->collected_amount, 0, ',', '.') }}</span>
                                    <span>Sisa: {{ $relDaysLeft }} hari</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-1.5 mt-2">
                                    <div class="bg-blue-600 h-1.5 rounded-full" style="width: {{ $relProgress }}%"></div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <div id="donation-modal"
        class="donation-modal hidden fixed inset-0 bg-black/50 flex justify-center items-end sm:items-center z-50 transition-opacity">
        <div
            class="modal-content bg-white w-full sm:max-w-md sm:rounded-lg rounded-t-2xl shadow-lg transform transition-transform duration-300">

            <div class="p-4 border-b flex justify-between items-center">
                <h3 class="font-bold text-lg">Donasi Sekarang</h3>
                <button id="close-modal" class="text-gray-500 hover:text-red-500 transition">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <div class="p-4 space-y-4 max-h-[80vh] overflow-y-auto">

                <div>
                    <p class="font-medium mb-2 text-sm text-gray-700">Data Donatur</p>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">Nama Lengkap</label>
                            <div class="flex items-center gap-2">
                                <input type="text" id="donor-name"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                                    placeholder="Masukkan nama Anda">

                                <!-- Checkbox Hamba Allah -->
                                <label class="flex items-center gap-1 text-xs text-gray-600">
                                    <input type="checkbox" id="anonymous-check" class="w-4 h-4">
                                    Sembunyikan nama saya
                                </label>
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">Nomor HP / WhatsApp</label>
                            <input type="tel" id="donor-phone"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                                placeholder="Contoh: 081234567890">
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">Email (Opsional)</label>
                            <input type="email" id="donor-email"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                                placeholder="email@contoh.com">
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">Doa & Dukungan (Opsional)</label>
                            <textarea id="donor-note" rows="2"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                                placeholder="Tuliskan doa atau dukungan Anda..."></textarea>
                        </div>
                    </div>
                </div>

                <div class="pt-2 border-t">
                    <p class="font-medium mb-2 text-sm text-gray-700">Pilih Nominal Donasi</p>

                    <div class="grid grid-cols-3 gap-2 mb-3">
                        <div class="amount-option" data-amount="25000">Rp 25rb</div>
                        <div class="amount-option" data-amount="50000">Rp 50rb</div>
                        <div class="amount-option" data-amount="100000">Rp 100rb</div>
                        <div class="amount-option" data-amount="250000">Rp 250rb</div>
                        <div class="amount-option" data-amount="500000">Rp 500rb</div>
                        <div class="amount-option" data-amount="1000000">Rp 1 Juta</div>
                    </div>

                    <div>
                        <p class="text-xs text-gray-500 mb-1">Atau masukkan nominal lain (Min Rp 10.000)</p>
                        <div
                            class="flex items-center border border-gray-300 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-blue-500">
                            <span class="bg-gray-100 px-3 py-2 text-gray-600 text-sm font-bold">Rp</span>
                            <input type="number" id="custom-amount" class="flex-1 px-3 py-2 outline-none text-sm"
                                placeholder="0">
                        </div>
                    </div>
                </div>

                <button id="pay-now-btn"
                    class="w-full py-3 rounded-lg font-bold text-center bg-blue-600 text-white hover:bg-blue-700 transition shadow-md">
                    Lanjutkan Pembayaran
                </button>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @if (config('services.midtrans.is_production'))
        {{-- Script Production --}}
        <script src="https://app.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.clientKey') }}">
        </script>
    @else
        {{-- Script Sandbox --}}
        <script src="https://app.sandbox.midtrans.com/snap/snap.js"
            data-client-key="{{ config('services.midtrans.clientKey') }}"></script>
    @endif

@section('scripts')
    @if (config('services.midtrans.is_production'))
        <script src="https://app.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.clientKey') }}">
        </script>
    @else
        <script src="https://app.sandbox.midtrans.com/snap/snap.js"
            data-client-key="{{ config('services.midtrans.clientKey') }}"></script>
    @endif

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const programDonasiId = {{ $program->id }};

            /* =========================================
                1. TAB SWITCHING
            ========================================= */
            const tabButtons = document.querySelectorAll('.tab-button');
            const tabContents = document.querySelectorAll('.tab-content');

            tabButtons.forEach(button => {
                button.addEventListener('click', () => {
                    tabButtons.forEach(btn => btn.classList.remove('active'));
                    tabContents.forEach(content => content.classList.add('hidden'));

                    button.classList.add('active');

                    const targetId = button.getAttribute('data-tab') + '-tab';
                    const targetContent = document.getElementById(targetId);

                    if (targetContent) {
                        targetContent.classList.remove('hidden');
                    }
                });
            });

            /* =========================================
                2. MODAL
            ========================================= */
            const donationModal = document.getElementById("donation-modal");
            const openDonationBtns = document.querySelectorAll(".donation-btn");
            const closeModalBtn = document.getElementById("close-modal");

            function toggleModal(show) {
                if (!donationModal) return;

                if (show) {
                    donationModal.classList.remove("hidden");
                    document.body.style.overflow = 'hidden';
                } else {
                    donationModal.classList.add("hidden");
                    document.body.style.overflow = '';
                }
            }

            openDonationBtns.forEach(btn => btn.addEventListener("click", () => toggleModal(true)));

            if (closeModalBtn) {
                closeModalBtn.addEventListener("click", () => toggleModal(false));
            }

            if (donationModal) {
                donationModal.addEventListener("click", (e) => {
                    if (e.target === donationModal) toggleModal(false);
                });
            }

            /* =========================================
                3. AMOUNT LOGIC
            ========================================= */
            const amountOptions = document.querySelectorAll(".amount-option");
            const customAmountInput = document.getElementById("custom-amount");

            let selectedAmount = null;

            amountOptions.forEach(option => {
                option.addEventListener("click", function() {
                    amountOptions.forEach(opt => opt.classList.remove("selected"));

                    this.classList.add("selected");
                    selectedAmount = this.dataset.amount;
                    customAmountInput.value = selectedAmount;
                });
            });

            customAmountInput.addEventListener("input", function() {
                amountOptions.forEach(opt => opt.classList.remove("selected"));
                selectedAmount = this.value;
            });

            /* =========================================
                4. PAYMENT
            ========================================= */
            const payButton = document.getElementById("pay-now-btn");

            if (!payButton) return;

            payButton.addEventListener("click", function() {
                const originalText = payButton.innerText;
                payButton.disabled = true;
                payButton.innerText = "Memproses...";
                payButton.classList.add("opacity-70", "cursor-not-allowed");

                let donorName = document.getElementById("donor-name").value.trim();
                const donorPhone = document.getElementById("donor-phone").value.trim();
                const donorEmail = document.getElementById("donor-email").value.trim();
                const donorNote = document.getElementById("donor-note").value.trim();

                const anonymousCheck = document.getElementById("anonymous-check");
                if (anonymousCheck && anonymousCheck.checked) {
                    donorName = "Hamba Allah";
                }

                const finalAmount = parseInt(selectedAmount || customAmountInput.value || 0);

                /* ===== VALIDATION ===== */
                if (!donorName) {
                    alert("Nama wajib diisi");
                    resetButton();
                    return;
                }

                if (!donorPhone) {
                    alert("Nomor HP wajib diisi");
                    resetButton();
                    return;
                }

                if (!finalAmount || finalAmount < 1000) {
                    alert("Minimal donasi Rp 1.000");
                    resetButton();
                    return;
                }

                /* ===== SEND REQUEST ===== */
                fetch(`/api/donation/${programDonasiId}`, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            "Accept": "application/json",
                        },
                        body: JSON.stringify({
                            donor_name: donorName,
                            donor_phone: donorPhone,
                            donor_email: donorEmail,
                            amount: finalAmount,
                            donation_type: "umum",
                            note: donorNote
                        })
                    })
                    .then(res => {
                        if (!res.ok) throw new Error("Request failed");
                        return res.json();
                    })
                    .then(data => {
                        if (!data.snap_token || !data.donation_code) {
                            alert("Gagal mendapatkan token pembayaran.");
                            resetButton();
                            return;
                        }

                        const donationCode = data.donation_code;

                        snap.pay(data.snap_token, {
                            onSuccess: () => window.location.href =
                                `/donate/status/${donationCode}`,
                            onPending: () => window.location.href =
                                `/donate/status/${donationCode}`,
                            onError: function() {
                                alert("Pembayaran gagal.");
                                resetButton();
                            },
                            onClose: () => window.location.href =
                                `/donate/status/${donationCode}`
                        });
                    })
                    .catch(err => {
                        console.error(err);
                        alert("Terjadi kesalahan sistem.");
                        resetButton();
                    });

                function resetButton() {
                    payButton.disabled = false;
                    payButton.innerText = originalText;
                    payButton.classList.remove("opacity-70", "cursor-not-allowed");
                }
            });
        });
    </script>
@endsection

@endsection
