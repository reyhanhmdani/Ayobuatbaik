<!DOCTYPE html>
<html lang="id">

<head>
    @laravelPWA
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
            @php
                $userData = [];
                // Validasi Email: Wajib ada dan tidak kosong
                if (!empty(auth()->user()->email)) {
                    $userData['em'] = hash('sha256', strtolower(trim(auth()->user()->email)));
                }
                
                // Validasi HP: Wajib ada dan tidak kosong
                if (!empty(auth()->user()->phone)) {
                    $phone = preg_replace('/[^0-9]/', '', auth()->user()->phone);
                    // Minimal 9 digit untuk dianggap valid (628...)
                    if (strlen($phone) >= 9) {
                        $userData['ph'] = hash('sha256', $phone);
                    }
                }
            @endphp

            @if (!empty($userData))
                fbq('init', '2777910462416668', {!! json_encode($userData) !!});
            @else
                fbq('init', '2777910462416668');
            @endif
        @else
            // Standard Init (Guest)
            fbq('init', '2777910462416668');
        @endauth

        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
            src="https://www.facebook.com/tr?id=2777910462416668&ev=PageView&noscript=1" /></noscript>
    <!-- End Meta Pixel Code -->
    <title>@yield('title', 'Ayobuatbaik - Platform Donasi Digital')</title>
    <link rel="icon" type="image/png" href="{{ asset('img/icon_ABBI.png') }}">

    {{-- Preconnect to Speed up Font Loading --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    {{-- Font Awesome (Asynchronous Load) --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" 
          media="print" onload="this.media='all'" />
    <noscript>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    </noscript>

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
