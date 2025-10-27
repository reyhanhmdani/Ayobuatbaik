<nav class="mobile-nav">
    <div class="flex justify-between items-center px-2">
        <a href="#" class="mobile-nav-item text-primary active">
            <i class="fas fa-home text-lg mb-1"></i>
            <span class="text-xs">Home</span>
        </a>

        <a href="/programs" class="mobile-nav-item text-primary">
            <i class="fas fa-hand-holding-heart text-lg mb-1"></i>
            <span class="text-xs">Program</span>
        </a>

        <a href="#berita" class="mobile-nav-item text-primary">
            <i class="fas fa-newspaper text-lg mb-1"></i>
            <span class="text-xs">Berita</span>
        </a>

        <!-- Kitab Menu for Mobile -->
        <div class="mobile-nav-item text-primary" id="kitab-menu-toggle">
            <i class="fas fa-book text-lg mb-1"></i>
            <span class="text-xs">Kebutuhan</span>
        </div>

        <!-- Akun Menu for Mobile -->
        <div class="mobile-nav-item text-primary" id="akun-menu-toggle">
            <i class="fas fa-user text-lg mb-1"></i>
            <span class="text-xs">Akun</span>
        </div>
    </div>

    <!-- Mobile Kitab Menu -->
    <div class="hidden bg-white border-t border-gray-200 pt-3 pb-2 px-4" id="kitab-menu">
        <div class="grid grid-cols-2 gap-3">
            <a href="#"
                class="flex items-center p-2 rounded-lg bg-gray-50 hover:bg-secondary hover:text-white transition-colors text-sm">
                <i class="fas fa-book-quran mr-2"></i>
                <span>Al-Quran</span>
            </a>
            <a href="#"
                class="flex items-center p-2 rounded-lg bg-gray-50 hover:bg-secondary hover:text-white transition-colors text-sm">
                <i class="fas fa-book mr-2"></i>
                <span>Kitab Nashohul Ibad</span>
            </a>
            <a href="#"
                class="flex items-center p-2 rounded-lg bg-gray-50 hover:bg-secondary hover:text-white transition-colors text-sm">
                <i class="fas fa-hands-praying mr-2"></i>
                <span>Doa Sehari-hari</span>
            </a>
            <a href="#"
                class="flex items-center p-2 rounded-lg bg-gray-50 hover:bg-secondary hover:text-white transition-colors text-sm">
                <i class="fas fa-images mr-2"></i>
                <span>Webtoon ABBI</span>
            </a>
        </div>
    </div>

    <!-- Mobile Akun Menu -->
    <div class="hidden bg-white border-t border-gray-200 pt-3 pb-2 px-4" id="akun-menu">
        <div class="space-y-2">
            <a href="/profile"
                class="flex items-center p-3 rounded-lg bg-gray-50 hover:bg-secondary hover:text-white transition-colors text-sm">
                <i class="fas fa-user-edit mr-3"></i>
                <span>Profil Saya</span>
            </a>
            <a href="/donations"
                class="flex items-center p-3 rounded-lg bg-gray-50 hover:bg-secondary hover:text-white transition-colors text-sm">
                <i class="fas fa-history mr-3"></i>
                <span>Riwayat Donasi</span>
            </a>
            <a href="/bookmarks"
                class="flex items-center p-3 rounded-lg bg-gray-50 hover:bg-secondary hover:text-white transition-colors text-sm">
                <i class="fas fa-bookmark mr-3"></i>
                <span>Program Tersimpan</span>
            </a>
            <a href="/settings"
                class="flex items-center p-3 rounded-lg bg-gray-50 hover:bg-secondary hover:text-white transition-colors text-sm">
                <i class="fas fa-cog mr-3"></i>
                <span>Pengaturan</span>
            </a>
            <a href="/logout"
                class="flex items-center p-3 rounded-lg bg-red-50 hover:bg-red-500 hover:text-white transition-colors text-sm text-red-600">
                <i class="fas fa-sign-out-alt mr-3"></i>
                <span>Keluar</span>
            </a>
        </div>
    </div>
</nav>

<script>
    document.addEventListener("DOMContentLoaded", function () {
    // Mobile menu functionality
    const akunMenuToggle = document.getElementById("akun-menu-toggle");
    const akunMenu = document.getElementById("akun-menu");
    const kitabMenuToggle = document.getElementById("kitab-menu-toggle");
    const kitabMenu = document.getElementById("kitab-menu");

    function closeAllMenus() {
        kitabMenu.classList.add("hidden");
        akunMenu.classList.add("hidden");
    }

    if (akunMenuToggle && akunMenu) {
        akunMenuToggle.addEventListener("click", function () {
            const isAkunMenuOpen = !akunMenu.classList.contains("hidden");
            closeAllMenus();
            if (!isAkunMenuOpen) {
                akunMenu.classList.remove("hidden");
            }
        });
    }

    if (kitabMenuToggle && kitabMenu) {
        kitabMenuToggle.addEventListener("click", function () {
            const isKitabMenuOpen = !kitabMenu.classList.contains("hidden");
            closeAllMenus();
            if (!isKitabMenuOpen) {
                kitabMenu.classList.remove("hidden");
            }
        });
    }

    document.addEventListener("click", function (event) {
        if (!event.target.closest(".mobile-nav")) {
            closeAllMenus();
        }
    });
});
</script>
