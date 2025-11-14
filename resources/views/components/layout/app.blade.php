<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>@yield('title', 'Ayobuatbaik - Platform Donasi Digital')</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-grayLight font-poppins">
    <div class="mobile-container">
        <div class="content">
            @yield('header-content')
            <main>
                @yield('content')
            </main>
        </div>
        @include('components.layout.navigation')

        <!-- Floating WhatsApp Button -->
        @php
            $waNumber = '6282133337058';
            $waMessage = 'Assalamualaikum ayobuatbaik, saya ingin berdonasi';
        @endphp

        <a href="https://wa.me/{{ $waNumber }}?text={{ urlencode($waMessage) }}" target="_blank"
            class="floating-wa">
            <i class="fab fa-whatsapp text-3xl"></i>
        </a>
    </div>

    @yield('scripts')
</body>

</html>
