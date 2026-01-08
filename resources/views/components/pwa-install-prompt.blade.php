<div id="pwa-install-prompt" 
    class="fixed top-0 left-0 right-0 z-[9999] transform -translate-y-[120%] transition-transform duration-700 ease-[cubic-bezier(0.34,1.56,0.64,1)] will-change-transform {{-- Hidden by default via transform --}}">
    
    {{-- Container: Solid White, Rounded Bottom, Shadow --}}
    <div class="mx-auto max-w-md bg-white shadow-2xl rounded-b-[2rem] border-x border-b border-gray-100 p-5 relative overflow-hidden">
        
        <div class="flex items-center gap-4 relative z-10">
            {{-- Icon with Black Metallic Background --}}
            <div class="flex-shrink-0 bg-gradient-to-br from-gray-800 to-black rounded-2xl p-2 shadow-lg border border-gray-100">
                <img src="{{ asset('icon ABBI.png') }}" alt="App Icon" class="w-12 h-12 object-contain drop-shadow-sm">
            </div>

            {{-- Content --}}
            <div class="flex-1 min-w-0 pt-1">
                <h3 class="text-sm font-black text-gray-900 leading-none mb-1 tracking-tight">Ayobuatbaik App</h3>
                <p class="text-[11px] text-gray-500 font-medium leading-snug mb-3">
                    Nikmati pengalaman lebih cepat & lancar.
                </p>

                {{-- Action Buttons --}}
                <div class="flex gap-2">
                    {{-- Install Button: Yellow/Gold --}}
                    <button id="pwa-install-yes" class="flex-1 bg-gradient-to-r from-primary to-yellow-600 text-white text-[11px] font-bold py-2.5 px-4 rounded-xl shadow-lg shadow-yellow-500/20 hover:shadow-yellow-500/40 active:scale-95 transition-all text-center tracking-wide">
                        INSTALL SEKARANG
                    </button>
                    {{-- Cancel Button: Gray --}}
                    <button id="pwa-install-no" class="flex-none bg-gray-50 text-gray-400 text-[11px] font-bold py-2.5 px-4 rounded-xl border border-gray-200 hover:bg-gray-100 hover:text-gray-600 active:scale-95 transition-all">
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

        // Logic "Cek Session" dimatikan (Always Show)
        // if (sessionStorage.getItem('pwa_prompt_dismissed')) { return; }

        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            deferredPrompt = e;
            
            // Delay 2 detik
            setTimeout(() => {
                showPrompt();
            }, 2000);
        });

        function showPrompt() {
            installPrompt.classList.remove('-translate-y-[120%]');
            
            // Auto hide dalam 15 detik
            setTimeout(() => {
                if (!installPrompt.classList.contains('-translate-y-[120%]')) {
                     hidePrompt();
                }
            }, 15000); 
        }

        function hidePrompt() {
            installPrompt.classList.add('-translate-y-[120%]');
            // Session storage disabled (Always Show)
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
