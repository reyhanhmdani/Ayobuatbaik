<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - Ayobuatbaik')</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/css/admin.css'])
</head>

<body class="bg-gray-50 font-poppins">
    <!-- Desktop Sidebar -->
    <div class="hidden lg:flex">
        <div class="fixed inset-y-0 left-0 w-64 bg-primary shadow-lg z-50">
            <!-- Logo -->
            <div class="flex items-center justify-center h-16 bg-primary-dark px-4">
                <h1 class="text-xl font-bold text-white">
                    <span class="text-secondary">Ayo</span>buatbaik
                </h1>
                <span class="ml-2 bg-secondary text-primary text-xs px-2 py-1 rounded-full">Admin</span>
            </div>

            <!-- Navigation -->
            <nav class="mt-8">
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center px-6 py-3 text-gray-200 hover:bg-primary-dark hover:text-white transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-primary-dark text-white border-r-4 border-secondary' : '' }}">
                    <i class="fas fa-chart-bar mr-3"></i>
                    Dashboard
                </a>
                <a href="{{ route('admin.programs') }}"
                    class="flex items-center px-6 py-3 text-gray-200 hover:bg-primary-dark hover:text-white transition-colors {{ request()->routeIs('admin.programs') ? 'bg-primary-dark text-white border-r-4 border-secondary' : '' }}">
                    <i class="fas fa-hand-holding-heart mr-3"></i>
                    Program Donasi
                </a>
                <a href="{{ route('admin.donations') }}"
                    class="flex items-center px-6 py-3 text-gray-200 hover:bg-primary-dark hover:text-white transition-colors {{ request()->routeIs('admin.donations') ? 'bg-primary-dark text-white border-r-4 border-secondary' : '' }}">
                    <i class="fas fa-donate mr-3"></i>
                    Donasi
                </a>
                <a href="{{ route('admin.users') }}"
                    class="flex items-center px-6 py-3 text-gray-200 hover:bg-primary-dark hover:text-white transition-colors {{ request()->routeIs('admin.users') ? 'bg-primary-dark text-white border-r-4 border-secondary' : '' }}">
                    <i class="fas fa-users mr-3"></i>
                    Pengguna
                </a>
            </nav>

            <!-- Logout -->
            <div class="absolute bottom-0 w-full p-4">
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit"
                        class="flex items-center w-full px-4 py-2 text-gray-200 hover:bg-primary-dark hover:text-white rounded-lg transition-colors">
                        <i class="fas fa-sign-out-alt mr-3"></i>
                        Keluar
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 lg:ml-64">
            <!-- Top Bar -->
            <header class="bg-white shadow-sm border-b">
                <div class="flex items-center justify-between px-6 py-4">
                    <div class="flex items-center">
                        <h2 class="text-lg font-semibold text-gray-800">@yield('page-title', 'Dashboard')</h2>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="text-sm text-gray-600">
                            <i class="fas fa-user-circle mr-2"></i>
                            Administrator
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-6">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Mobile Layout -->
    <div class="lg:hidden">
        <!-- Mobile Top Bar -->
        <header class="bg-primary text-white p-4">
            <div class="flex items-center justify-between">
                <h1 class="text-lg font-bold">
                    <span class="text-secondary">Ayo</span>buatbaik
                </h1>
                <button id="mobile-menu-toggle" class="text-white">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </header>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden bg-primary text-white">
            <nav class="py-4">
                <a href="{{ route('admin.dashboard') }}" class="block px-6 py-3 hover:bg-primary-dark">
                    <i class="fas fa-chart-bar mr-3"></i>Dashboard
                </a>
                <a href="{{ route('admin.programs') }}" class="block px-6 py-3 hover:bg-primary-dark">
                    <i class="fas fa-hand-holding-heart mr-3"></i>Program Donasi
                </a>
                <a href="{{ route('admin.donations') }}" class="block px-6 py-3 hover:bg-primary-dark">
                    <i class="fas fa-donate mr-3"></i>Donasi
                </a>
                <a href="{{ route('admin.users') }}" class="block px-6 py-3 hover:bg-primary-dark">
                    <i class="fas fa-users mr-3"></i>Pengguna
                </a>
                <form method="POST" action="{{ route('admin.logout') }}" class="px-6 py-3 border-t border-primary-dark">
                    @csrf
                    <button type="submit" class="flex items-center w-full text-left">
                        <i class="fas fa-sign-out-alt mr-3"></i>Keluar
                    </button>
                </form>
            </nav>
        </div>

        <!-- Mobile Content -->
        <main class="p-4">
            @yield('content')
        </main>
    </div>

    @yield('scripts')

    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-toggle')?.addEventListener('click', function() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });
    </script>
</body>

</html>
