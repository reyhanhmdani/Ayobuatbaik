<div id="pwa-install-prompt" 
    class="fixed top-0 left-0 right-0 z-[9999] transform -translate-y-[120%] transition-transform duration-700 ease-[cubic-bezier(0.34,1.56,0.64,1)] will-change-transform {{-- Hidden by default via transform --}}">
    
    {{-- Container: Glassmorphism, Rounded Bottom, Shadow --}}
    <div class="mx-auto max-w-md bg-white/95 backdrop-blur-xl shadow-2xl rounded-b-[2rem] border-x border-b border-white/20 p-5 relative overflow-hidden">
        
        {{-- Shine Effect --}}
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-white/50 to-transparent opacity-50"></div>

        <div class="flex items-center gap-4 relative z-10">
            {{-- Icon with modern styling --}}
            <div class="flex-shrink-0 bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl p-2 shadow-inner border border-white/50">
                <img src="{{ asset('icon ABBI.png') }}" alt="App Icon" class="w-12 h-12 object-contain bg-black drop-shadow-sm">
            </div>

            {{-- Content --}}
            <div class="flex-1 min-w-0 pt-1">
                <h3 class="text-sm font-black text-gray-800 leading-none mb-1 tracking-tight">Ayobuatbaik App</h3>
                <p class="text-[11px] text-gray-500 font-medium leading-snug mb-3">
                    Nikmati pengalaman lebih cepat & lancar.
                </p>

                {{-- Action Buttons --}}
                <div class="flex gap-2">
                    <button id="pwa-install-yes" class="flex-1 bg-gradient-to-r from-primary to-yellow-600 text-white text-[11px] font-bold py-2.5 px-4 rounded-xl shadow-lg shadow-orange-500/20 hover:shadow-orange-500/40 active:scale-95 transition-all text-center tracking-wide">
                        INSTALL SEKARANG
                    </button>
                    <button id="pwa-install-no" class="flex-none bg-gray-50 text-gray-400 text-[11px] font-bold py-2.5 px-4 rounded-xl border border-gray-100 hover:bg-gray-100 hover:text-gray-600 active:scale-95 transition-all">
                        Nanti
                    </button>
                </div>
            </div>

            {{-- Subtle Close Button --}}
            <button id="pwa-close-btn" class="absolute -top-1 -right-1 p-2 text-gray-300 hover:text-gray-500 transition-colors">
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

        // Cek session biar gak spam
        if (sessionStorage.getItem('pwa_prompt_dismissed')) {
            return;
        }

        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            deferredPrompt = e;
            
            // Delay sedikit biar halaman loaded dulu baru muncul "Twing!"
            setTimeout(() => {
                showPrompt();
            }, 2000);
        });

        function showPrompt() {
            // Slide Down Animation
            installPrompt.classList.remove('-translate-y-[120%]');
            
            // Auto hide dalam 15 detik (dilemakan dikit biar user sempat baca)
            setTimeout(() => {
                // Cek kalau user belum interaksi (masih visible)
                if (!installPrompt.classList.contains('-translate-y-[120%]')) {
                     hidePrompt();
                }
            }, 15000); 
        }

        function hidePrompt() {
            // Slide Up Animation
            installPrompt.classList.add('-translate-y-[120%]');
            
            // Tandai sudah dilihat
            sessionStorage.setItem('pwa_prompt_dismissed', 'true');
        }

        installBtn.addEventListener('click', async () => {
            if (!deferredPrompt) return;
            deferredPrompt.prompt();
            const { outcome } = await deferredPrompt.userChoice;
            deferredPrompt = null;
            hidePrompt();
        });

        noBtn.addEventListener('click', hidePrompt);
        closeBtn.addEventListener('click', hidePrompt);
    });
</script>
