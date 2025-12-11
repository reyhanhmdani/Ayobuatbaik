<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta property="og:site_name" content="Ayobuatbaik">
    <meta property="og:title" content="@yield('og_title', 'Ayobuatbaik - Platform Donasi Digital')">
    <meta property="og:description" content="@yield('og_description', 'Ayobuatbaik - Platform Donasi Digital')">
    <meta property="og:type" content="website">
    <meta property="og:url" content="@yield('og_url', 'https://ayobuatbaik.com')">
    <meta property="og:image" content="@yield('og_image', 'https://ayobuatbaik.com/img/icon_ABBI.png')">

    <!-- Meta Pixel Code -->
    <script>
        ! function(f, b, e, v, n, t, s) {
            if (f.fbq) return;
            n = f.fbq = function() {
                n.callMethod ?
                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq) f._fbq = n;
            n.push = n;
            n.loaded = !0;
            n.version = '2.0';
            n.queue = [];
            t = b.createElement(e);
            t.async = !0;
            t.src = v;
            s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window, document, 'script',
            'https://connect.facebook.net/en_US/fbevents.js');

        @auth
            // Advanced Matching (User Logged In)
            fbq('init', '572554197324218', {
                em: '{{ hash('sha256', auth()->user()->email) }}',
                ph: '{{ hash('sha256', auth()->user()->phone ?? '') }}'
            });
        @else
            // Standard Init (Guest)
            fbq('init', '572554197324218');
        @endauth

        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
            src="https://www.facebook.com/tr?id=572554197324218&ev=PageView&noscript=1" /></noscript>
    <!-- End Meta Pixel Code -->
    <title>@yield('title', 'Ayobuatbaik - Platform Donasi Digital')</title>
    <link rel="icon" type="image/png" href="{{ asset('img/icon_ABBI.png') }}">

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
            $waMessage = 'Assalamualaikum ayobuatbaik, saya ingin berbuat baik';
        @endphp

        <a href="https://wa.me/{{ $waNumber }}?text={{ urlencode($waMessage) }}" target="_blank"
            class="floating-wa" onclick="fbq('track', 'Contact');">
            <i class="fab fa-whatsapp text-3xl"></i>
        </a>
    </div>

    @yield('scripts')
</body>

</html>
