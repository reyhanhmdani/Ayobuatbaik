@extends('components.layout.app')

@section('title', 'Status Donasi - ' . $donation->program->title)

@section('header-content')
    @include('components.layout.header')
@endsection

@section('content')
    <div class="content pb-20">
        <div class="bg-white p-6 shadow-md rounded-lg mx-auto max-w-lg mt-4">

            {{-- Status Section --}}
            <div class="text-center mb-6">
                @if ($donation->status === 'success')
                    <i class="fas fa-check-circle text-green-500 text-6xl mb-3"></i>
                    <h2 class="text-2xl font-bold text-green-600">Donasi Berhasil!</h2>
                    <p class="text-gray-600 mt-1">Terima kasih atas kontribusi Anda.</p>
                @elseif ($donation->status === 'pending')
                    <i class="fas fa-clock text-yellow-500 text-6xl mb-3"></i>
                    <h2 class="text-2xl font-bold text-yellow-600">Menunggu Pembayaran</h2>
                    <p class="text-gray-600 mt-1">Segera selesaikan pembayaran sebelum batas waktu.</p>
                    <p class="text-sm text-gray-500 mt-2">Kode Pembayaran Anda: <span class="font-semibold">{{ $donation->donation_code }}</span></p>
                @elseif ($donation->status === 'failed' || $donation->status === 'expired')
                    <i class="fas fa-times-circle text-red-500 text-6xl mb-3"></i>
                    <h2 class="text-2xl font-bold text-red-600">Pembayaran Gagal/Kadaluarsa</h2>
                    <p class="text-gray-600 mt-1">Pembayaran Anda tidak dapat diproses. Silakan coba lagi.</p>
                @else
                    <i class="fas fa-question-circle text-gray-500 text-6xl mb-3"></i>
                    <h2 class="text-2xl font-bold text-gray-600">Status Tidak Diketahui</h2>
                @endif
            </div>

            <hr class="my-4">

            {{-- Detail Donasi --}}
            <h3 class="font-bold text-lg mb-3 text-primary">Detail Transaksi</h3>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-500">Program Donasi:</span>
                    <span class="font-semibold text-right">{{ $donation->program->title }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Nominal Donasi:</span>
                    <span class="font-bold text-lg text-blue-600">Rp {{ number_format($donation->amount, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Nama Donatur:</span>
                    <span class="font-medium">{{ $donation->donor_name }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Status:</span>
                    <span class="font-medium capitalize text-{{ $donation->status === 'success' ? 'green' : ($donation->status === 'pending' ? 'yellow' : 'red') }}-600">
                        {{ $donation->status }}
                    </span>
                </div>
                @if ($donation->status === 'pending' && $donation->status_change_at)
                    <div class="flex justify-between text-xs text-red-500 pt-1 border-t">
                        <span>Waktu Kadaluarsa:</span>
                        <span class="font-semibold">{{ $donation->status_change_at->addHours(24)->translatedFormat('d F Y, H:i') }} WIB</span>
                    </div>
                @endif
            </div>

            {{-- Info Penghapusan Otomatis --}}
            @if ($isDeletable)
            <div class="mt-4 p-3 bg-red-100 border border-red-400 rounded-lg text-red-700 text-sm">
                <i class="fas fa-exclamation-triangle mr-2"></i>
                Data donasi ini (Gagal/Expired) akan **dihapus otomatis dalam waktu dekat** karena telah melewati batas 24 jam.
            </div>
            @endif

            {{-- Tombol Aksi --}}
            <div class="mt-6">
                <a href="{{ route('home.program.show', $donation->program->slug) }}" class="w-full block py-3 rounded-lg font-bold text-center bg-secondary text-white hover:bg-goldDark transition shadow-md">
                    Lihat Program Donasi
                </a>
            </div>
        </div>

        {{-- Daftar Donatur Lain --}}
        <div class="bg-white p-6 shadow-md rounded-lg mx-auto max-w-lg mt-4">
            <h3 class="font-bold text-lg mb-4 text-primary">Donatur Lain dalam Program Ini</h3>
            <div class="space-y-3">
                @forelse($recentDonation as $donor)
                <div class="flex items-center justify-between py-2 border-b last:border-0">
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-xs font-bold mr-3">
                            {{ strtoupper(substr($donor->donor_name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="font-medium text-sm">{{ $donor->donor_name }}</p>
                            <p class="text-xs text-gray-500">Status:
                                <span class="capitalize text-{{ $donor->status === 'success' ? 'green' : ($donor->status === 'pending' ? 'yellow' : 'red') }}-500 font-semibold">{{ $donor->status }}</span>
                            </p>
                            <p class="text-xs text-gray-500">
                                {{ $donor->status_change_at ? $donor->status_change_at->diffForHumans() : $donor->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                    <p class="font-bold text-blue-600 text-sm">Rp {{ number_format($donor->amount, 0, ',', '.') }}</p>
                </div>
                @empty
                <p class="text-center text-gray-500">Belum ada donatur lain untuk program ini.</p>
                @endforelse
            </div>
        </div>

    </div>
@endsection
