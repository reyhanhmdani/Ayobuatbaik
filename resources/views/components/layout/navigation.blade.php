@php
    function isActive($pattern)
    {
        return request()->is($pattern) ? 'active' : '';
    }
@endphp
<nav class="mobile-nav">
    <div class="flex justify-between items-center px-2">
        <a href="{{ route('home') }}" class="mobile-nav-item text-primary {{ isActive('/') }}">
            <i class="fas fa-home text-lg mb-1"></i>
            <span class="text-xs">Home</span>
        </a>

        <a href="{{ route('home.program') }}" class="mobile-nav-item text-primary {{ isActive('programs') }}">
            <i class="fas fa-hand-holding-heart text-lg mb-1"></i>
            <span class="text-xs">Program</span>
        </a>

        <a href="{{ route('home.berita') }}" class="mobile-nav-item text-primary {{ isActive('berita') }}">
            <i class="fas fa-newspaper text-lg mb-1"></i>
            <span class="text-xs">Berita</span>
        </a>

        <a href="{{ route('home.kitab.index') }}" class="mobile-nav-item text-primary {{ isActive('kitab*') }}">
            <i class="fas fa-book text-lg mb-1"></i>
            <span class="text-xs">Kitab</span>
        </a>

        @auth
            <div class="mobile-nav-item text-primary" id="akun-menu-toggle">
                <i class="fas fa-user-shield text-lg mb-1"></i>
                <span class="text-xs">My Profile</span>
            </div>
        @else
            <a href="{{ route('login') }}" class="mobile-nav-item text-primary {{ isActive('login') }}">
                <i class="fas fa-user text-lg mb-1"></i>
                <span class="text-xs">Akun</span>
            </a>
        @endauth
    </div>

    <!-- Mobile Kitab Menu (Removed) -->

    <!-- Mobile Akun Menu -->
    <div class="hidden bg-white border-t border-gray-200 pt-3 pb-2 px-4" id="akun-menu">
        <div class="space-y-2">
            @auth
                <!-- Jika sudah login -->
                <a href="{{ route('profile') }}"
                    class="flex items-center p-3 rounded-lg bg-gray-50 hover:bg-secondary hover:text-white transition-colors text-sm">
                    <i class="fas fa-user mr-3"></i>
                    <span>Profil Saya</span>
                </a>

                @if (auth()->user()->is_admin)
                    <!-- Tombol Dashboard hanya untuk Admin -->
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center p-3 rounded-lg bg-gray-50 hover:bg-secondary hover:text-white transition-colors text-sm">
                        <i class="fas fa-tachometer-alt mr-3"></i>
                        <span>Dashboard Admin</span>
                    </a>
                @endif

                <form action="{{ route('logout') }}" method="POST" class="w-full">
                    @csrf
                    <button type="submit"
                        class="flex items-center p-3 rounded-lg bg-red-50 hover:bg-red-500 hover:text-white transition-colors text-sm text-red-600 w-full text-left">
                        <i class="fas fa-sign-out-alt mr-3"></i>
                        <span>Keluar</span>
                    </button>
                </form>
            @else
                <!-- Jika belum login -->
                <a href="{{ route('login') }}"
                    class="flex items-center p-3 rounded-lg bg-gray-50 hover:bg-secondary hover:text-white transition-colors text-sm">
                    <i class="fas fa-sign-in-alt mr-3"></i>
                    <span>Login</span>
                </a>
            @endauth
        </div>
    </div>
</nav>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Mobile menu functionality
        const akunMenuToggle = document.getElementById("akun-menu-toggle");
        const akunMenu = document.getElementById("akun-menu");

        function closeAllMenus() {
            if (akunMenu) akunMenu.classList.add("hidden");
        }

        if (akunMenuToggle && akunMenu) {
            akunMenuToggle.addEventListener("click", function() {
                const isAkunMenuOpen = !akunMenu.classList.contains("hidden");
                closeAllMenus();
                if (!isAkunMenuOpen) {
                    akunMenu.classList.remove("hidden");
                }
            });
        }

        document.addEventListener("click", function(event) {
            if (!event.target.closest(".mobile-nav")) {
                closeAllMenus();
            }
        });
    });
</script>
