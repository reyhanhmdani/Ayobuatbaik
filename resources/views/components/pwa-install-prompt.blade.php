<div id="pwa-install-prompt" class="fixed top-0 left-0 right-0 z-[9999] transform -translate-y-full transition-transform duration-500 will-change-transform hidden">
    <div class="bg-white/90 backdrop-blur-md shadow-lg border-b border-gray-100 p-4 mx-auto max-w-md">
        <div class="flex items-start gap-4">
            {{-- Icon --}}
            <div class="flex-shrink-0 bg-primary/10 rounded-xl p-2">
                <img src="{{ asset('icon ABBI.png') }}" alt="App Icon" class="w-10 h-10 object-contain">
            </div>

            {{-- Text --}}
            <div class="flex-1 min-w-0">
                <h3 class="text-sm font-bold text-gray-900 leading-tight mb-1">Install Aplikasi Ayobuatbaik</h3>
                <p class="text-xs text-gray-500 leading-snug mb-3">
                    Akses lebih cepat & hemat kuota tanpa buka browser.
                </p>

                {{-- Buttons --}}
                <div class="flex gap-2">
                    <button id="pwa-install-yes" class="flex-1 bg-primary text-white text-xs font-bold py-2 px-3 rounded-lg shadow-sm hover:bg-primary/90 active:scale-95 transition-all">
                        <i class="fas fa-download mr-1.5"></i> Install
                    </button>
                    <button id="pwa-install-no" class="flex-none bg-gray-100 text-gray-600 text-xs font-bold py-2 px-3 rounded-lg hover:bg-gray-200 active:scale-95 transition-all">
                        Nanti dulu
                    </button>
                </div>
            </div>

            {{-- Close X --}}
            <button id="pwa-close-btn" class="text-gray-400 hover:text-gray-600 p-1 -mt-1 -mr-1">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        let deferredPrompt;
        const installPrompt = document.getElementById('pwa-install-prompt');
        const installBtn = document.getElementById('pwa-install-yes');
        const closeBtn = document.getElementById('pwa-close-btn');
        const noBtn = document.getElementById('pwa-install-no');

        // Logic: Cek apakah sudah pernah di-close sebelumnya (Session Storage)
        // Biar nggak muncul terus kalau user refresh halaman
        if (sessionStorage.getItem('pwa_prompt_dismissed')) {
            return;
        }

        window.addEventListener('beforeinstallprompt', (e) => {
            // 1. Prevent Chrome default mini-infobar
            e.preventDefault();
            // 2. Save event for later
            deferredPrompt = e;
            // 3. Show our custom UI
            showPrompt();
        });

        function showPrompt() {
            installPrompt.classList.remove('hidden');
            // Sedikit delay biar transisi slide-down jalan mulus
            setTimeout(() => {
                installPrompt.classList.remove('-translate-y-full');
            }, 100);

            // Auto-hide after 10 seconds
            setTimeout(() => {
               hidePrompt();
            }, 10000);
        }

        function hidePrompt() {
            installPrompt.classList.add('-translate-y-full');
            setTimeout(() => {
                installPrompt.classList.add('hidden');
            }, 500); // Wait for transition
            
            // Simpan status bahwa user sudah melihat prompt ini
            sessionStorage.setItem('pwa_prompt_dismissed', 'true');
        }

        installBtn.addEventListener('click', async () => {
            if (!deferredPrompt) return;
            
            // Show native prompt
            deferredPrompt.prompt();
            
            // Wait for choice
            const { outcome } = await deferredPrompt.userChoice;
            console.log(`User response to install prompt: ${outcome}`);
            
            // Reset
            deferredPrompt = null;
            hidePrompt();
        });

        noBtn.addEventListener('click', hidePrompt);
        closeBtn.addEventListener('click', hidePrompt);
    });
</script>
