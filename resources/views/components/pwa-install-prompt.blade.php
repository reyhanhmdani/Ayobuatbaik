<div id="pwa-install-prompt" 
    class="fixed top-0 left-0 right-0 z-[9999] transform -translate-y-[120%] transition-transform duration-700 ease-[cubic-bezier(0.34,1.56,0.64,1)] will-change-transform {{-- Hidden by default via transform --}}">
    
    {{-- Container: Black Metallic, Rounded Bottom, Shadow --}}
    <div class="mx-auto max-w-md bg-gradient-to-b from-gray-900 to-black shadow-2xl rounded-b-[2rem] border-x border-b border-gray-700 p-5 relative overflow-hidden">
        
        {{-- Metallic Shine Effect --}}
        <div class="absolute top-0 left-0 w-full h-[1px] bg-gradient-to-r from-transparent via-gray-500 to-transparent opacity-50"></div>
        <div class="absolute bottom-0 left-0 w-full h-1/2 bg-gradient-to-t from-black/50 to-transparent pointer-events-none"></div>

        <div class="flex items-center gap-4 relative z-10">
            {{-- Icon with dark glow --}}
            <div class="flex-shrink-0 bg-black rounded-2xl p-2 shadow-lg shadow-black/50 border border-gray-800 ring-1 ring-white/5">
                <img src="{{ asset('icon ABBI.png') }}" alt="App Icon" class="w-12 h-12 object-contain drop-shadow-md">
            </div>

            {{-- Content --}}
            <div class="flex-1 min-w-0 pt-1">
                <h3 class="text-sm font-black text-white leading-none mb-1 tracking-tight drop-shadow-md">Ayobuatbaik App</h3>
                <p class="text-[11px] text-gray-300 font-medium leading-snug mb-3">
                    Nikmati pengalaman lebih cepat & lancar.
                </p>

                {{-- Action Buttons --}}
                <div class="flex gap-2">
                    {{-- Install Button: Gold/Metallic Gradient --}}
                    <button id="pwa-install-yes" class="flex-1 bg-gradient-to-br from-yellow-500 via-yellow-600 to-yellow-700 text-white text-[11px] font-black py-2.5 px-4 rounded-xl shadow-lg shadow-yellow-900/40 hover:brightness-110 active:scale-95 transition-all text-center tracking-wide border border-yellow-500/30">
                        INSTALL SEKARANG
                    </button>
                    {{-- Cancel Button: Dark Metallic --}}
                    <button id="pwa-install-no" class="flex-none bg-gray-800 text-gray-400 text-[11px] font-bold py-2.5 px-4 rounded-xl border border-gray-700 hover:bg-gray-700 hover:text-white active:scale-95 transition-all shadow-inner">
                        Nanti
                    </button>
                </div>
            </div>

            {{-- Subtle Close Button --}}
            <button id="pwa-close-btn" class="absolute -top-1 -right-1 p-2 text-gray-600 hover:text-gray-300 transition-colors">
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

        // Logic "Cek Session" saya matikan biar muncul tiap refresh, sesuai request.
        // if (sessionStorage.getItem('pwa_prompt_dismissed')) { return; }

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
            
            // Auto hide dalam 15 detik
            setTimeout(() => {
                if (!installPrompt.classList.contains('-translate-y-[120%]')) {
                     hidePrompt();
                }
            }, 15000); 
        }

        function hidePrompt() {
            // Slide Up Animation
            installPrompt.classList.add('-translate-y-[120%]');
            
            // Logic "Simpan Session" saya matikan juga.
            // sessionStorage.setItem('pwa_prompt_dismissed', 'true');
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
