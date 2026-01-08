<div id="pwa-install-prompt" class="fixed top-0 left-0 right-0 z-[9999] p-4 flex justify-center pointer-events-none transition-transform duration-700 cubic-bezier(0.16, 1, 0.3, 1) -translate-y-[150%]">
    <div class="bg-white/90 backdrop-blur-xl rounded-3xl shadow-2xl border border-white/40 ring-1 ring-black/5 p-4 w-full max-w-sm pointer-events-auto relative overflow-hidden">
        {{-- Shine Effect --}}
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-secondary/50 to-transparent opacity-50"></div>

        <div class="flex items-start gap-4">
            {{-- Icon --}}
            <div class="flex-shrink-0 bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl p-2.5 shadow-inner border border-white/50">
                <img src="{{ asset('icon ABBI.png') }}" alt="App Icon" class="w-10 h-10 object-contain drop-shadow-sm">
            </div>

            {{-- Text --}}
            <div class="flex-1 min-w-0 pt-0.5">
                <h3 class="text-sm font-bold text-gray-900 leading-tight mb-1">Install Ayobuatbaik</h3>
                <p class="text-[11px] text-gray-500 leading-relaxed mb-3 font-medium">
                    Akses lebih cepat, hemat kuota & tanpa ribet buka browser.
                </p>

                {{-- Buttons --}}
                <div class="flex gap-2.5">
                    <button id="pwa-install-yes" class="flex-1 bg-gray-900 text-white text-[11px] font-bold py-2.5 px-4 rounded-xl shadow-lg shadow-gray-900/20 hover:bg-black hover:scale-[1.02] active:scale-95 transition-all duration-300">
                        Install Sekarang
                    </button>
                    <button id="pwa-install-no" class="flex-none bg-gray-100 text-gray-500 text-[11px] font-bold py-2.5 px-4 rounded-xl hover:bg-gray-200 hover:text-gray-700 active:scale-95 transition-all duration-300">
                        Nanti
                    </button>
                </div>
            </div>

            {{-- Close X --}}
            <button id="pwa-close-btn" class="absolute top-2 right-2 text-gray-300 hover:text-gray-500 w-6 h-6 flex items-center justify-center rounded-full hover:bg-gray-100 transition-all">
                <i class="fas fa-times text-xs"></i>
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

        if (sessionStorage.getItem('pwa_prompt_dismissed')) {
            return;
        }

        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            deferredPrompt = e;
            showPrompt();
        });

        function showPrompt() {
            // Slide down animation
            requestAnimationFrame(() => {
                installPrompt.classList.remove('-translate-y-[150%]');
            });

            // Auto-hide after 15 seconds (kasih waktu lebih lama buat baca)
            setTimeout(() => {
               hidePrompt();
            }, 15000);
        }

        function hidePrompt() {
            installPrompt.classList.add('-translate-y-[150%]');
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
