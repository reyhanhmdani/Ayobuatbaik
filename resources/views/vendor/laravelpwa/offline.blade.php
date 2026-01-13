<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Offline - Ayobuatbaik</title>
    <link rel="icon" type="image/png" href="/icon ABBI.png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');
        body { font-family: 'Poppins', sans-serif; }
        .float-animation {
            animation: float 3s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
        }
        .pulse-glow {
            animation: pulse-glow 2s ease-in-out infinite;
        }
        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 20px rgba(212, 175, 55, 0.3); }
            50% { box-shadow: 0 0 40px rgba(212, 175, 55, 0.6); }
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-b from-gray-900 via-gray-800 to-gray-900 flex items-center justify-center p-6">
    
    <div class="text-center max-w-md mx-auto">
        {{-- Animated Offline Icon --}}
        <div class="float-animation mb-8">
            <div class="w-32 h-32 mx-auto bg-gradient-to-br from-gray-700 to-gray-800 rounded-full flex items-center justify-center shadow-2xl border border-gray-600">
                <i class="fas fa-wifi-slash text-5xl text-gray-400"></i>
            </div>
        </div>

        {{-- Main Message --}}
        <h1 class="text-2xl font-bold text-white mb-3">Kamu Sedang Offline</h1>
        <p class="text-gray-400 text-sm mb-8 leading-relaxed">
            Sepertinya koneksi internet kamu terputus. <br>
            Tapi tenang, kamu tetap bisa membaca <strong class="text-yellow-500">Kitab Hikmah</strong>!
        </p>

        {{-- Kitab Shortcut Button --}}
        <a href="/kitab" class="inline-flex items-center justify-center gap-3 bg-gradient-to-r from-yellow-500 via-yellow-600 to-yellow-700 text-white font-bold py-4 px-8 rounded-2xl shadow-xl pulse-glow hover:brightness-110 active:scale-95 transition-all">
            <i class="fas fa-book-quran text-xl"></i>
            <span>Buka Kitab Hikmah</span>
        </a>

        {{-- Retry Connection --}}
        <button onclick="window.location.reload()" class="mt-6 block w-full text-center text-gray-500 hover:text-gray-300 text-xs font-medium py-3 transition-colors">
            <i class="fas fa-rotate-right mr-2"></i>Coba Sambungkan Ulang
        </button>

        {{-- Logo --}}
        <div class="mt-12 pt-8 border-t border-gray-700/50">
            <img src="/icon ABBI.png" alt="Ayobuatbaik" class="w-12 h-12 mx-auto opacity-50">
            <p class="text-[10px] text-gray-600 mt-2">Ayobuatbaik &copy; {{ date('Y') }}</p>
        </div>
    </div>

</body>
</html>