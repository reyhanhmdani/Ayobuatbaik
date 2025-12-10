@extends('components.layout.app')

@section('title', 'Profil Saya - Ayobuatbaik')

@section('og_title', 'Profil Saya - Ayobuatbaik')
@section('og_description', 'Profil Saya - Ayobuatbaik')
@section('og_url', 'https://ayobuatbaik.com')
@section('og_image', 'https://ayobuatbaik.com/img/icon_ABBI.png')

@section('content')
    {{-- Tambah padding bottom untuk mobile navigation --}}
    <div class="min-h-screen bg-gray-50 py-4 md:py-8 px-4 pb-24 md:pb-8">
        <div class="max-w-4xl mx-auto">
            {{-- Header --}}
            <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 mb-4 md:mb-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h1 class="text-xl md:text-2xl font-bold text-gray-900">Profil Saya</h1>
                        <p class="text-xs md:text-sm text-gray-600 mt-1">Kelola informasi profil dan lihat riwayat donasi Anda</p>
                    </div>
                    
                    {{-- Buttons responsive: stack di mobile, horizontal di desktop --}}
                    <div class="flex flex-col sm:flex-row gap-2">
                        @if(auth()->user()->is_admin)
                            <a href="{{ route('admin.dashboard') }}"
                                class="inline-flex items-center justify-center gap-2 bg-secondary text-white px-4 py-2 rounded-lg hover:opacity-90 transition text-sm font-semibold">
                                <i class="fas fa-tachometer-alt"></i>
                                <span>Dashboard</span>
                            </a>
                        @endif
                        
                        <form action="{{ route('logout') }}" method="POST" class="w-full sm:w-auto">
                            @csrf
                            <button type="submit"
                                class="w-full inline-flex items-center justify-center gap-2 bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition text-sm font-semibold">
                                <i class="fas fa-sign-out-alt"></i>
                                <span>Keluar</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Success/Error Messages --}}
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-4 md:mb-6 text-sm">
                    <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                </div>
            @endif

            {{-- Stats Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6 mb-4 md:mb-6">
                <div class="bg-green-600 bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-5 md:p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <p class="text-white/80 text-xs md:text-sm font-medium">Total Donasi</p>
                            <h2 class="text-white text-2xl md:text-3xl font-bold mt-1">
                                Rp {{ number_format($totalAmount, 0, ',', '.') }}
                            </h2>
                        </div>
                        <div class="bg-white/20 p-3 md:p-4 rounded-lg flex-shrink-0">
                            <i class="fas fa-hand-holding-heart text-white text-2xl md:text-3xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-blue-600 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-5 md:p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <p class="text-white/80 text-xs md:text-sm font-medium">Jumlah Donasi</p>
                            <h2 class="text-white text-2xl md:text-3xl font-bold mt-1">
                                {{ $totalDonations }} kali
                            </h2>
                        </div>
                        <div class="bg-white/20 p-3 md:p-4 rounded-lg flex-shrink-0">
                            <i class="fas fa-donate text-white text-2xl md:text-3xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 mb-4 md:mb-6">
                <h2 class="text-lg md:text-xl font-bold text-gray-900 mb-4">Riwayat Donasi</h2>
                
                @if($recentDonations->count() > 0)
                    {{-- Desktop Table --}}
                    <div class="hidden md:block overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kode</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Program</th>
                                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Nominal</th>
                                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Status</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($recentDonations as $donation)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3 text-sm font-medium text-gray-900 whitespace-nowrap">
                                            {{ $donation->donation_code }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-700">
                                            {{ $donation->program ? $donation->program->title : 'Program Dihapus' }}
                                        </td>
                                        <td class="px-4 py-3 text-sm font-bold text-green-600 text-right whitespace-nowrap">
                                            Rp {{ number_format($donation->amount, 0, ',', '.') }}
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                                {{ $donation->status === 'success' ? 'bg-green-100 text-green-800' : '' }}
                                                {{ $donation->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                {{ in_array($donation->status, ['failed', 'expire', 'unpaid']) ? 'bg-red-100 text-red-800' : '' }}">
                                                {{ ucfirst($donation->status) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-500 whitespace-nowrap">
                                            {{ $donation->created_at->format('d M Y H:i') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Mobile Cards --}}
                    <div class="md:hidden space-y-3">
                        @foreach($recentDonations as $donation)
                            <div class="bg-gray-50 rounded-lg p-3 border border-gray-200">
                                <div class="flex justify-between items-start mb-2">
                                    <span class="text-xs font-medium text-gray-500">{{ $donation->donation_code }}</span>
                                    <span class="px-2 py-0.5 inline-flex text-xs font-semibold rounded-full
                                        {{ $donation->status === 'success' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $donation->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ in_array($donation->status, ['failed', 'expire', 'unpaid']) ? 'bg-red-100 text-red-800' : '' }}">
                                        {{ ucfirst($donation->status) }}
                                    </span>
                                </div>
                                <p class="text-sm font-medium text-gray-900 mb-1">
                                    {{ $donation->program ? $donation->program->title : 'Program Dihapus' }}
                                </p>
                                <div class="flex justify-between items-center mt-2 pt-2 border-t border-gray-200">
                                    <span class="text-lg font-bold text-green-600">
                                        Rp {{ number_format($donation->amount, 0, ',', '.') }}
                                    </span>
                                    <span class="text-xs text-gray-500">
                                        {{ $donation->created_at->format('d M Y') }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500">
                        <i class="fas fa-inbox text-4xl mb-2"></i>
                        <p class="text-sm">Belum ada riwayat donasi</p>
                    </div>
                @endif
            </div>

            {{-- Edit Profile Form --}}
            <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 mb-4 md:mb-6">
                <h2 class="text-lg md:text-xl font-bold text-gray-900 mb-4">Edit Profil</h2>
                
                <form action="{{ route('profile.update') }}" method="POST" class="space-y-4">
                    @csrf
                    
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg text-sm
                                   focus:outline-none focus:ring-2 focus:ring-secondary/40 focus:border-secondary
                                   @error('name') border-red-500 @enderror">
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg text-sm
                                   focus:outline-none focus:ring-2 focus:ring-secondary/40 focus:border-secondary
                                   @error('email') border-red-500 @enderror">
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                        class="w-full bg-secondary text-white py-2.5 px-4 rounded-lg font-semibold text-sm
                               hover:opacity-90 transition-all duration-300">
                        Simpan Perubahan
                    </button>
                </form>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 mb-4 md:mb-6">
                <h2 class="text-lg md:text-xl font-bold text-gray-900 mb-4">Ubah Password</h2>
                
                <form action="{{ route('profile.password') }}" method="POST" class="space-y-4">
                    @csrf
                    
                    <div>
                        <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">Password Saat Ini</label>
                        <input type="password" id="current_password" name="current_password" required
                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg text-sm
                                   focus:outline-none focus:ring-2 focus:ring-secondary/40 focus:border-secondary
                                   @error('current_password') border-red-500 @enderror">
                        @error('current_password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="new_password" class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                        <input type="password" id="new_password" name="new_password" required
                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg text-sm
                                   focus:outline-none focus:ring-2 focus:ring-secondary/40 focus:border-secondary
                                   @error('new_password') border-red-500 @enderror">
                        @error('new_password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password Baru</label>
                        <input type="password" id="new_password_confirmation" name="new_password_confirmation" required
                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg text-sm
                                   focus:outline-none focus:ring-2 focus:ring-secondary/40 focus:border-secondary">
                    </div>

                    <button type="submit"
                        class="w-full bg-blue-600 text-white py-2.5 px-4 rounded-lg font-semibold text-sm
                               hover:bg-blue-700 transition-all duration-300">
                        Ubah Password
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
