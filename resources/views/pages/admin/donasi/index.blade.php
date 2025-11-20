@extends('components.layout.admin')

@section('title', 'Kelola Donasi - Ayobuatbaik')
@section('page-title', 'Data Transaksi Donasi')

@section('content')
    <div class="max-w-full mx-auto mt-8">
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 mb-4">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                {{-- JUDUL DAN TOMBOL EKSPOR --}}
                <div class="flex items-center gap-3">
                    <h3 class="text-lg font-semibold text-gray-900">Daftar Transaksi Donasi</h3>

                    {{-- TOMBOL EKSPOR BARU --}}
                    <a href=""
                        class="ml-2 inline-flex items-center gap-2 bg-blue-600 text-white px-3 py-2 text-xs rounded-lg hover:bg-blue-700 transition">
                        <i class="fas fa-download"></i>
                        <span>Ekspor(CSV)</span>
                    </a>
                </div>

                <form id="controlsForm" method="GET" class="flex flex-col sm:flex-row gap-3 items-stretch sm:items-center">

                    {{-- SEARCH (Nama/Kode) --}}
                    <input type="text" name="search" placeholder="Cari kode/nama donatur..." value="{{ request('search') }}"
                        class="w-full sm:w-64 border px-3 py-2 rounded-md text-sm focus:outline-none focus:ring-1 focus:ring-secondary" />

                    <div class="flex items-center gap-2">
                        <label class="text-sm text-gray-600">Status</label>
                        <select name="status" id="status" class="border rounded px-2 py-2 text-sm">
                            <option value="">Semua</option>
                            <option value="success" {{ request('status') == 'success' ? 'selected' : '' }}>Success</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed/Cancel</option>
                            <option value="expire" {{ request('status') == 'expire' ? 'selected' : '' }}>Expired</option>
                        </select>
                    </div>

                    <div class="flex items-center gap-2">
                        <label class="text-sm text-gray-600">Show</label>
                        <select name="perPage" id="perPage" class="border rounded px-2 py-2 text-sm">
                            @foreach ([15, 30, 50] as $size)
                                <option value="{{ $size }}" {{ request('perPage', 15) == $size ? 'selected' : '' }}>
                                    {{ $size }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit"
                        class="bg-secondary text-white px-3 py-2 text-sm rounded-md hover:opacity-95 transition">Terapkan</button>
                </form>
            </div>
        </div>

        <div class="mt-4">
            {{-- DESKTOP TABLE (Minimalis) --}}
            <div class="hidden md:block bg-white rounded-xl shadow-sm p-4 border border-gray-100">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-xs"> {{-- Text size dikecilkan --}}
                        <thead class="text-gray-600 bg-gray-50">
                            <tr>
                                <th class="px-3 py-2 text-left">Kode</th> {{-- Padding dikecilkan --}}
                                <th class="px-3 py-2 text-left">Donatur (Nama, Email, HP)</th>
                                <th class="px-3 py-2 text-left">Program</th>
                                <th class="px-3 py-2 text-right">Nominal</th>
                                <th class="px-3 py-2 text-center">Status</th>
                                <th class="px-3 py-2 text-left">Waktu Donasi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($donations as $donation)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-3 py-2 font-medium text-gray-900">
                                        {{ $donation->donation_code }}
                                    </td>
                                    <td class="px-3 py-2">
                                        <p class="font-medium text-gray-900">{{ $donation->donor_name }}</p>
                                        {{-- Ukuran text lebih kecil --}}
                                        <p class="text-xs text-gray-500">{{ $donation->donor_email }} | {{ $donation->donor_phone }}</p>
                                    </td>
                                    <td class="px-3 py-2 text-gray-700 max-w-xs truncate"> {{-- Tambah truncate untuk nama program yang panjang --}}
                                        {{ $donation->program->title ?? 'Program Dihapus' }}
                                    </td>
                                    <td class="px-3 py-2 font-bold text-right text-green-600">
                                        Rp {{ number_format($donation->amount, 0, ',', '.') }}
                                    </td>
                                    <td class="px-3 py-2 text-center">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                            {{ $donation->status === 'success' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $donation->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                            {{ in_array($donation->status, ['failed', 'expire', 'cancel']) ? 'bg-red-100 text-red-800' : '' }}
                                            {{ $donation->status === 'refund' ? 'bg-blue-100 text-blue-800' : '' }}">
                                            {{ ucfirst($donation->status) }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-2 text-xs text-gray-500">
                                        {{ $donation->created_at->format('d M Y H:i') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-6 text-gray-500">Belum ada data donasi yang tercatat.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- MOBILE CARDS (Tetap sama) --}}
            <div class="md:hidden space-y-3">
                @forelse($donations as $donation)
                    <div class="bg-white rounded-xl shadow p-4 border border-gray-100 space-y-2 text-sm">
                        <div class="flex justify-between items-center border-b pb-2">
                            <span class="text-xs text-gray-500">Kode:</span>
                            <span class="text-sm font-medium text-gray-900">{{ $donation->donation_code }}</span>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-xs text-gray-500">Donatur:</span>
                            <div>
                                <p class="text-sm font-medium text-gray-900 text-right">{{ $donation->donor_name }}</p>
                                <p class="text-xs text-gray-500 text-right">{{ $donation->donor_phone }}</p>
                                <p class="text-xs text-gray-500 text-right">{{ $donation->donor_email }}</p>
                            </div>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-xs text-gray-500">Program:</span>
                            <span class="text-sm text-gray-700 text-right">{{ $donation->program->title ?? 'Program Dihapus' }}</span>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-xs text-gray-500">Nominal:</span>
                            <span class="text-sm font-bold text-green-600">Rp {{ number_format($donation->amount, 0, ',', '.') }}</span>
                        </div>

                        <div class="flex justify-between items-center pt-2 border-t">
                            <span class="text-xs text-gray-500">Status:</span>
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                {{ $donation->status === 'success' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $donation->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ in_array($donation->status, ['failed', 'expire', 'cancel']) ? 'bg-red-100 text-red-800' : '' }}
                                {{ $donation->status === 'refund' ? 'bg-blue-100 text-blue-800' : '' }}">
                                {{ ucfirst($donation->status) }}
                            </span>
                        </div>
                        <div class="text-xs text-gray-500 text-right mt-1">
                            {{ $donation->created_at->format('d M Y H:i') }}
                        </div>
                    </div>
                @empty
                    <div class="text-center py-6 text-gray-500">Belum ada data donasi yang tercatat.</div>
                @endforelse
            </div>
        </div>

        {{-- Pagination Links --}}
        <div class="mt-4">
            {{ $donations->links() }}
        </div>
    </div>

    {{-- Script untuk Auto-Submit Form --}}
    @section('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Submit form ketika nilai perPage atau Status diubah
                ['perPage', 'status'].forEach(id => {
                    const el = document.getElementById(id);
                    if (el) el.addEventListener('change', () => document.getElementById('controlsForm').submit());
                });
            });
        </script>
    @endsection
@endsection
