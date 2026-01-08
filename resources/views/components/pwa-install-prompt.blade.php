<div id="pwa-install-prompt" 
    class="fixed top-0 left-0 right-0 z-[9999] transform -translate-y-[120%] transition-transform duration-700 ease-[cubic-bezier(0.34,1.56,0.64,1)] will-change-transform {{-- Hidden by default --}}">
    
    {{-- Container: Solid White, Rounded Bottom, Shadow --}}
    <div class="mx-auto max-w-md bg-white shadow-2xl rounded-b-[2rem] border-x border-b border-gray-100 p-5 relative overflow-hidden">
        
        <div class="flex items-center gap-4 relative z-10">
            {{-- Icon (Black Metallic Background) --}}
            <div class="flex-shrink-0 bg-gradient-to-br from-gray-800 to-black rounded-2xl p-2 shadow-lg border border-gray-100">
                <img src="{{ asset('icon ABBI.png') }}" alt="App Icon" class="w-12 h-12 object-contain drop-shadow-sm">
            </div>

            {{-- Content --}}
            <div class="flex-1 min-w-0 pt-1">
                <h3 class="text-sm font-black text-gray-900 leading-none mb-1 tracking-tight">Ayobuatbaik App</h3>
                <p id="pwa-desc" class="text-[11px] text-gray-500 font-medium leading-snug mb-3">
                    Nikmati pengalaman lebih cepat & lancar.
                </p>

                {{-- Action Buttons --}}
                <div class="flex gap-2">
                    {{-- Install Button (Gold Gradient) --}}
                    <button id="pwa-install-yes" class="flex-1 bg-gradient-to-r from-primary to-yellow-600 text-white text-[11px] font-bold py-2.5 px-4 rounded-xl shadow-lg shadow-yellow-500/20 hover:shadow-yellow-500/40 active:scale-95 transition-all text-center tracking-wide">
                        INSTALL SEKARANG
                    </button>
                    {{-- Cancel Button --}}
                    <button id="pwa-install-no" class="flex-none bg-gray-50 text-gray-400 text-[11px] font-bold py-2.5 px-4 rounded-xl border border-gray-200 hover:bg-gray-100 hover:text-gray-600 active:scale-95 transition-all">
                        Nanti
                    </button>
                </div>
            </div>

            {{-- Close Button --}}
            <button id="pwa-close-btn" class="absolute -top-1 -right-1 p-2 text-gray-300 hover:text-gray-500 transition-colors">
                <i class="fas fa-times text-xs"></i>
            </button>
        </div>

        {{-- iOS Instruction (Hidden by default) --}}
        <div id="ios-instruction" class="hidden mt-3 pt-3 border-t border-gray-50 text-center">
             <p class="text-[10px] text-gray-500 animate-pulse">
                Ketuk tombol <span class="font-bold text-blue-500"><i class="fas fa-share-square"></i> Share</span> dibawah, <br>
                lalu pilih <span class="font-bold text-gray-800"><i class="fas fa-plus-square"></i> Tambah ke Layar Utama</span>
            </p>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        let deferredPrompt;
        const installPrompt = document.getElementById('pwa-install-prompt');
        const installBtn = document.getElementById('pwa-install-yes');
        const iosInstruction = document.getElementById('ios-instruction');
        const installPromptDesc = document.getElementById('pwa-desc');
        
        // Cek User Agent (Apakah iPhone/iPad?)
        const isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
        // Cek Browser Mode (Apakah sudah mode aplikasi/standalone?)
        const isStandalone = window.matchMedia('(display-mode: standalone)').matches || (window.navigator.standalone === true);

        // 1. Logic untuk ANDROID (Chrome/Edge/Samsung Internet)
        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            deferredPrompt = e;
            
            // Tunda sebentar biar smooth loadingnya
            setTimeout(() => {
                showPrompt();
            }, 2000);
        });

        // 2. Logic untuk iOS (iPhone/iPad)
        // Paksa muncul kalau di iPhone + BELUM Install (bukan standalone)
        if (isIOS && !isStandalone) {
             setTimeout(() => {
                showPrompt();
            }, 2000);
        }

        function showPrompt() {
            installPrompt.classList.remove('-translate-y-[120%]');
        }

        function hidePrompt() {
            installPrompt.classList.add('-translate-y-[120%]');
        }

        installBtn.addEventListener('click', async () => {
             // Jika Android (Ada event install bawaan)
            if (deferredPrompt) {
                deferredPrompt.prompt();
                const { outcome } = await deferredPrompt.userChoice;
                deferredPrompt = null;
                hidePrompt();
            } 
            // Jika iOS (Manual Instructions)
            else if (isIOS) {
                installBtn.innerHTML = 'IKUTI PETUNJUK DI BAWAH 👇';
                installBtn.classList.remove('bg-gradient-to-r', 'from-primary', 'to-yellow-600');
                installBtn.classList.add('bg-gray-800', 'text-white');
                iosInstruction.classList.remove('hidden');
                installPromptDesc.textContent = "Khusus iPhone perlu manual sedikit ya:";
            }
        });

        document.getElementById('pwa-install-no').addEventListener('click', hidePrompt);
        document.getElementById('pwa-close-btn').addEventListener('click', hidePrompt);
    });
</script>
