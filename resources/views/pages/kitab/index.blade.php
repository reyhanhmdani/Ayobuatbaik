@extends('components.layout.app')

@section('title', 'Kitab Nashaihul Ibad - Ayobuatbaik')

@section('og_title', 'Kitab Nashaihul Ibad - Ayobuatbaik')
@section('og_description', 'Kumpulan maqolah-maqolah hikmah dari Kitab Nashaihul Ibad karya Syekh Nawawi al-Bantani')
@section('og_url', 'https://ayobuatbaik.com/kitab')
@section('og_image', 'https://ayobuatbaik.com/img/icon_ABBI.png')

@section('header-content')
    @include('components.layout.header')
@endsection

@section('content')
    <div class="content bg-gray-50 min-h-screen">
        {{-- Hero Section --}}
        <div class="bg-gradient-to-br from-primary via-gray-800 to-gray-900 text-white pt-8 pb-12 px-4 relative overflow-hidden">
            <div class="relative z-10 text-center max-w-7xl mx-auto">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-white/10 backdrop-blur-sm rounded-2xl mb-4 shadow-lg border border-white/10">
                    <i class="fas fa-book-quran text-3xl text-secondary"></i>
                </div>
                <h1 class="text-2xl font-bold mb-2 tracking-tight">Kitab Nashaihul Ibad</h1>
                <p class="text-sm text-gray-300 mb-3 font-serif italic">نصائح العباد</p>
                <p class="text-xs text-gray-400 max-w-sm mx-auto leading-relaxed">
                    Kumpulan maqolah-maqolah hikmah karya Syekh Muhammad Nawawi al-Bantani al-Jawi Al-Indunisi
                </p>
                <div class="flex justify-center gap-4 mt-6 text-xs mb-4">
                    <div class="bg-white/10 backdrop-blur-sm px-4 py-2 rounded-full border border-white/10">
                        <i class="fas fa-book-open mr-1.5 text-secondary"></i> {{ count($chapters) }} Bab
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm px-4 py-2 rounded-full border border-white/10">
                        <i class="fas fa-scroll mr-1.5 text-secondary"></i> {{ $maqolahs }} Maqolah
                    </div>
                </div>

                {{-- Download for Offline Button --}}
                <div id="offline-download-wrapper" class="mb-8" data-total-maqolah="{{ $maqolahs }}">
                    <button id="btn-download-offline" 
                        class="relative inline-flex items-center gap-2 bg-white/10 hover:bg-white/20 backdrop-blur-sm text-white text-xs font-medium px-5 py-2.5 rounded-full border border-white/20 transition-all">
                        <i class="fas fa-cloud-download-alt"></i>
                        <span id="btn-download-text">Simpan untuk Dibaca Offline</span>
                        {{-- Update Badge (Hidden by default) --}}
                        <span id="update-badge" class="hidden absolute -top-1 -right-1 bg-red-500 text-white text-[8px] font-bold px-1.5 py-0.5 rounded-full animate-pulse">
                            UPDATE
                        </span>
                    </button>
                    
                    {{-- Update Notification (Hidden by default) --}}
                    <p id="update-notification" class="hidden text-[10px] text-yellow-400 mt-2">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        Ada konten baru! Klik untuk update data offline.
                    </p>
                    
                    {{-- Progress Bar (Hidden by default) --}}
                    <div id="download-progress" class="hidden mt-4 max-w-xs mx-auto">
                        <div class="bg-white/10 rounded-full h-2 overflow-hidden">
                            <div id="progress-bar" class="bg-secondary h-full transition-all duration-300" style="width: 0%"></div>
                        </div>
                        <p id="progress-text" class="text-[10px] text-gray-400 mt-2">Memulai download...</p>
                    </div>
                </div>

                {{-- Quick Jump / Pencarian Cepat --}}
                <div class="max-w-xl mx-auto bg-white/10 backdrop-blur-md rounded-2xl p-4 border border-white/20 shadow-xl">
                    <p class="text-xs text-gray-300 mb-3 font-medium uppercase tracking-wider text-left pl-1">
                        <i class="fas fa-bolt text-secondary mr-1"></i> Pencarian Cepat
                    </p>
                    <div class="flex gap-2 items-center">
                        {{-- Select Bab --}}
                        <div class="flex-1 relative">
                            <select id="quick-chapter" 
                                class="w-full appearance-none bg-white/90 text-gray-800 text-xs rounded-xl px-3 py-2 pr-6 focus:outline-none focus:ring-2 focus:ring-secondary cursor-pointer border-0 font-medium">
                                <option value="" selected disabled>Pilih Bab</option>
                                @foreach($chapters as $ch)
                                    <option value="{{ $ch->slug }}" data-maqolahs="{{ json_encode($ch->maqolahs) }}">
                                        Bab {{ $ch->nomor_bab }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-gray-500">
                                <i class="fas fa-chevron-down text-xs"></i>
                            </div>
                        </div>

                        {{-- Select Maqolah --}}
                        <div class="flex-1 relative">
                            <select id="quick-maqolah" disabled
                                class="w-full appearance-none bg-black/20 text-white/50 text-xs rounded-xl px-3 py-2 pr-6 focus:outline-none focus:ring-2 focus:ring-secondary cursor-not-allowed border-0 font-medium transition-all">
                                <option value="" selected disabled>Pilih Maqolah</option>
                            </select>
                            <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-white/30">
                                <i class="fas fa-chevron-down text-xs"></i>
                            </div>
                        </div>

                        {{-- Button Go --}}
                        <button id="btn-go" disabled
                            class="bg-secondary text-white px-5 py-2 rounded-xl font-bold text-xs hover:bg-yellow-600 transition-colors shadow-lg shadow-orange-500/20 disabled:opacity-50 disabled:cursor-not-allowed min-w-[80px]">
                            Buka
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Chapter List --}}
        <div class="px-4 py-8 pb-32">
            <div class="max-w-7xl mx-auto">
                <header class="mb-6">
                    <h2 class="text-xl font-bold text-primary flex items-center gap-2">
                        <i class="fas fa-list-ul text-secondary"></i>
                        Daftar Bab
                    </h2>
                    <div class="h-1 w-16 bg-secondary rounded-full mt-2"></div>
                </header>

                <div class="grid grid-cols-1 gap-4">
                    @forelse ($chapters as $chapter)
                        <a href="{{ route('home.kitab.chapter', $chapter->slug) }}"
                            class="block bg-white rounded-xl shadow-sm border border-gray-100 hover:border-secondary hover:shadow-md transition-all duration-300 overflow-hidden group h-full">
                            <div class="flex items-center p-4">
                                {{-- Chapter Number Badge --}}
                                <div class="flex-shrink-0 w-12 h-12 bg-gray-50 rounded-xl flex items-center justify-center mr-4 group-hover:bg-primary/10 transition-colors border border-gray-100">
                                    <span class="text-gray-600 font-bold text-lg group-hover:text-primary transition-colors">{{ $chapter->nomor_bab }}</span>
                                </div>

                                {{-- Chapter Info --}}
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-semibold text-gray-800 text-sm group-hover:text-primary transition-colors line-clamp-1 mb-1">
                                        Nashaihul Ibad Bab {{ $chapter->nomor_bab }}{{ $chapter->judul_bab ? ' : ' . $chapter->judul_bab : '' }}
                                    </h3>
                                    <p class="text-xs text-gray-500 line-clamp-1">
                                        {{ Str::limit(strip_tags($chapter->deskripsi), 100) }}
                                    </p>
                                    <div class="flex items-center mt-2 text-[10px] text-gray-400">
                                        <i class="fas fa-scroll mr-1 text-secondary"></i>
                                        <span>{{ $chapter->maqolahs_count }} Maqolah</span>
                                    </div>
                                </div>

                                {{-- Arrow Icon --}}
                                <div class="flex-shrink-0 ml-2">
                                    <div class="w-8 h-8 rounded-full bg-gray-50 flex items-center justify-center group-hover:bg-secondary group-hover:text-white transition-all">
                                        <i class="fas fa-chevron-right text-xs text-gray-400 group-hover:text-white"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="col-span-full text-center py-10 text-gray-500 bg-white rounded-xl border border-dashed border-gray-300">
                            <i class="fas fa-book text-5xl mb-3 text-gray-300"></i>
                            <p class="text-lg font-semibold">Belum ada data kitab.</p>
                            {{-- <p class="text-sm">Silakan hubungi admin</p> --}}
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const chapterSelect = document.getElementById('quick-chapter');
        const maqolahSelect = document.getElementById('quick-maqolah');
        const btnGo = document.getElementById('btn-go');

        let currentChapterSlug = '';
        let currentMaqolahId = '';

        // Handle Chapter Change
        chapterSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            currentChapterSlug = this.value;
            
            // Get maqolahs data from data-attribute
            const maqolahs = JSON.parse(selectedOption.dataset.maqolahs || '[]');

            // Reset Maqolah Select
            maqolahSelect.innerHTML = '<option value="" selected disabled>Pilih Maqolah...</option>';
            
            if (maqolahs.length > 0) {
                maqolahs.forEach(m => {
                    const label = m.judul ? `Maqolah ${m.nomor_maqolah}: ${m.judul}` : `Maqolah ${m.nomor_maqolah}`; // Use fallback if judul is empty
                    // Truncate if too long
                    const truncatedLabel = label.length > 30 ? label.substring(0, 30) + '...' : label;
                    
                    const option = document.createElement('option');
                    option.value = m.id;
                    option.textContent = truncatedLabel;
                    maqolahSelect.appendChild(option);
                });

                // Enable Select
                maqolahSelect.disabled = false;
                maqolahSelect.classList.remove('bg-black/20', 'text-white/50', 'cursor-not-allowed');
                maqolahSelect.classList.add('bg-white/90', 'text-gray-800', 'cursor-pointer');
            } else {
                maqolahSelect.disabled = true;
                maqolahSelect.classList.add('bg-black/20', 'text-white/50', 'cursor-not-allowed');
                maqolahSelect.classList.remove('bg-white/90', 'text-gray-800', 'cursor-pointer');
            }
            
            // Reset Button
            btnGo.disabled = true;
        });

        // Handle Maqolah Change
        maqolahSelect.addEventListener('change', function() {
            currentMaqolahId = this.value;
            if (currentMaqolahId) {
                btnGo.disabled = false;
            } else {
                btnGo.disabled = true;
            }
        });

        // Handle Go Click
        btnGo.addEventListener('click', function() {
            if (currentChapterSlug && currentMaqolahId) {
                // Construct URL: /kitab/{chapterSlug}/maqolah/{id}
                const url = `{{ route('home.kitab.index') }}/${currentChapterSlug}/maqolah/${currentMaqolahId}`;
                window.location.href = url;
            }
        });

        // =============================================
        // OFFLINE DOWNLOAD FEATURE
        // =============================================
        const btnDownload = document.getElementById('btn-download-offline');
        const btnDownloadText = document.getElementById('btn-download-text');
        const updateBadge = document.getElementById('update-badge');
        const updateNotification = document.getElementById('update-notification');
        const progressWrapper = document.getElementById('download-progress');
        const progressBar = document.getElementById('progress-bar');
        const progressText = document.getElementById('progress-text');
        const wrapper = document.getElementById('offline-download-wrapper');

        // Get current total from server (passed via data attribute)
        const currentTotal = parseInt(wrapper.dataset.totalMaqolah) || 0;
        
        // Get stored data from localStorage
        const storedData = JSON.parse(localStorage.getItem('kitab_offline_data') || '{}');
        const storedTotal = storedData.total || 0;
        const wasDownloaded = !!storedData.downloadedAt;

        // Determine state
        if (wasDownloaded && storedTotal === currentTotal) {
            // Already downloaded and up to date
            btnDownload.innerHTML = '<i class="fas fa-check-circle"></i> <span>Sudah Tersimpan Offline</span>';
            btnDownload.classList.remove('bg-white/10', 'hover:bg-white/20');
            btnDownload.classList.add('bg-green-600/50');
        } else if (wasDownloaded && storedTotal < currentTotal) {
            // Downloaded before but there's new content
            const newCount = currentTotal - storedTotal;
            btnDownloadText.textContent = 'Update Data Offline';
            updateBadge.classList.remove('hidden');
            updateNotification.textContent = `Ada ${newCount} maqolah baru! Klik untuk update.`;
            updateNotification.classList.remove('hidden');
            btnDownload.classList.remove('bg-white/10');
            btnDownload.classList.add('bg-yellow-600/50', 'border-yellow-500/50');
        }
        // else: Never downloaded - keep default state

        btnDownload.addEventListener('click', async function() {
            // Prevent double click
            if (this.disabled) return;
            this.disabled = true;
            
            // Show progress
            progressWrapper.classList.remove('hidden');
            this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> <span>Mengunduh...</span>';
            this.classList.add('opacity-50', 'cursor-not-allowed');

            try {
                // 1. Fetch all URLs from API
                progressText.textContent = 'Mengambil daftar halaman...';
                const response = await fetch('/kitab/api/urls');
                const data = await response.json();
                const urls = data.urls;
                const total = urls.length;

                progressText.textContent = `Ditemukan ${total} halaman. Memulai download...`;

                // 2. Cache each URL
                let completed = 0;
                let failed = 0;

                for (const url of urls) {
                    try {
                        await fetch(url, { cache: 'reload' }); // Force fresh fetch
                        completed++;
                    } catch (e) {
                        failed++;
                        console.warn('[Offline Download] Failed:', url);
                    }

                    // Update progress
                    const percent = Math.round((completed + failed) / total * 100);
                    progressBar.style.width = percent + '%';
                    progressText.textContent = `Mengunduh ${completed}/${total} halaman...`;
                }

                // 3. Done!
                progressBar.style.width = '100%';
                progressText.textContent = `Selesai! ${completed} halaman tersimpan untuk offline.`;
                
                // Save to localStorage (with total count for update detection)
                localStorage.setItem('kitab_offline_data', JSON.stringify({
                    downloadedAt: Date.now(),
                    total: currentTotal
                }));

                // Update button
                this.innerHTML = '<i class="fas fa-check-circle"></i> <span>Tersimpan!</span>';
                this.classList.remove('opacity-50', 'bg-yellow-600/50', 'border-yellow-500/50');
                this.classList.add('bg-green-600/50');
                
                // Hide update notification
                updateBadge.classList.add('hidden');
                updateNotification.classList.add('hidden');

                // Hide progress after 3 seconds
                setTimeout(() => {
                    progressWrapper.classList.add('hidden');
                }, 3000);

            } catch (error) {
                console.error('[Offline Download] Error:', error);
                progressText.textContent = 'Gagal mengunduh. Coba lagi nanti.';
                this.disabled = false;
                this.innerHTML = '<i class="fas fa-cloud-download-alt"></i> <span>Coba Lagi</span>';
                this.classList.remove('opacity-50', 'cursor-not-allowed');
            }
        });
    });
</script>
@endsection
