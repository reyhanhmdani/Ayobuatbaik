@extends('components.layout.admin')

@section('title', 'Kelola Donasi - Ayobuatbaik')
@section('page-title', 'Data Transaksi Donasi')

@section('content')
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    <div class="max-w-7xl mx-auto mt-8">
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 mb-4">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                <div class="flex items-center gap-3">
                    <h3 class="text-base font-semibold text-gray-900">Data Transaksi ({{ $donations->total() ?? 0 }})</h3>

                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.donasi.createManual') }}"
                            class="inline-flex items-center gap-1 bg-green-600 text-white px-2 py-1.5 text-xs rounded-lg hover:bg-green-700 transition">
                            <i class="fas fa-plus"></i>
                            <span class="hidden sm:inline">Manual</span>
                        </a>

                        {{-- TOMBOL EKSPOR DENGAN QUERY FILTER --}}
                        <a href="{{ route('admin.donasi.export', request()->query()) }}" target="_blank"
                            class="inline-flex items-center gap-1 bg-blue-600 text-white px-2 py-1.5 text-xs rounded-lg hover:bg-blue-700 transition">
                            <i class="fas fa-download"></i>
                            <span class="hidden sm:inline">CSV</span>
                        </a>
                    </div>
                </div>

                <form id="controlsForm" method="GET"
                    class="flex flex-col sm:flex-row gap-2 items-stretch sm:items-center flex-wrap xl:flex-nowrap">

                    <div class="flex items-center gap-2 w-full sm:w-auto">
                        <input type="text" name="search" placeholder="Cari donatur..." value="{{ request('search') }}"
                            class="w-full sm:w-40 md:w-48 border px-3 py-2 rounded-md text-xs focus:outline-none focus:ring-1 focus:ring-secondary" />
                    </div>

                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 w-full sm:w-auto">
                        {{-- FILTER PROGRAM DONASI --}}
                        <select name="program_id" id="program_id" class="border rounded px-2 py-2 text-xs w-full sm:w-32 md:w-40">
                            <option value="">Semua Program</option>
                            @foreach ($programs as $program)
                                <option value="{{ $program->id }}"
                                    {{ request('program_id') == $program->id ? 'selected' : '' }}>
                                    {{ Str::limit($program->title, 15) }}
                                </option>
                            @endforeach
                        </select>

                        {{-- FILTER STATUS --}}
                        <select name="status" id="status" class="border rounded px-2 py-2 text-xs w-full sm:w-24 md:w-28">
                            <option value="">Semua Status</option>
                            <option value="success" {{ request('status') == 'success' ? 'selected' : '' }}>Success
                            </option>
                            <option value="unpaid" {{ request('status') == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending
                            </option>
                            <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Gagal</option>
                            <option value="expire" {{ request('status') == 'expire' ? 'selected' : '' }}>Expired
                            </option>
                        </select>
                        
                        <select name="perPage" id="perPage" class="border rounded px-2 py-2 text-xs w-full sm:w-16">
                            @foreach ([15, 30, 50] as $size)
                                <option value="{{ $size }}"
                                    {{ request('perPage', 15) == $size ? 'selected' : '' }}>
                                    {{ $size }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Tombol Terapkan --}}
                    <button type="submit"
                        class="bg-secondary text-white px-3 py-2 text-xs rounded-md hover:opacity-95 transition w-full sm:w-auto">
                        <i class="fas fa-search sm:hidden"></i>
                        <span class="hidden sm:inline">Terapkan</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="mt-4">

        {{-- DESKTOP TABLE --}}
        <div class="hidden md:block bg-white rounded-xl shadow-sm p-4 border border-gray-100">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-xs">
                    <thead class="text-gray-600 bg-gray-50">
                        <tr>
                            <th class="px-3 py-2 text-left">Kode</th>
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
                                <td class="px-3 py-2 font-medium text-gray-900 whitespace-nowrap">
                                    {{ $donation->donation_code }}
                                </td>
                                <td class="px-3 py-2">
                                    <p class="font-medium text-gray-900">{{ $donation->donor_name }}</p>
                                    <p class="text-xs text-gray-500">{{ $donation->donor_email }} |
                                        {{ $donation->donor_phone }}</p>
                                </td>
                                <td class="px-3 py-2 text-gray-700 max-w-xs truncate">
                                    {{ $donation->program->title ?? 'Program Dihapus' }}
                                </td>
                                <td class="px-3 py-2 font-bold text-right text-green-600 whitespace-nowrap">
                                    Rp {{ number_format($donation->amount, 0, ',', '.') }}
                                </td>
                                <td class="px-3 py-2 text-center whitespace-nowrap">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                            {{ $donation->status === 'success' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $donation->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                            {{ in_array($donation->status, ['failed', 'expire', 'unpaid']) ? 'bg-red-100 text-red-800' : '' }}
                                            {{ $donation->status === 'refund' ? 'bg-blue-100 text-blue-800' : '' }}">
                                        {{ ucfirst($donation->status) }}
                                    </span>
                                </td>
                                <td class="px-3 py-2 text-xs text-gray-500 whitespace-nowrap">
                                    <div class="flex items-center justify-between gap-3">
                                        <span>{{ $donation->created_at->format('d M Y H:i') }}</span>
                                        <a href="{{ route('admin.donasi.editManual', $donation->id) }}" class="text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 p-1.5 rounded-md transition-colors" title="Edit Donasi">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-6 text-gray-500">Belum ada data donasi yang
                                    tercatat.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- MOBILE CARDS (Optimalisasi) --}}
        <div class="md:hidden space-y-3">
            @forelse($donations as $donation)
                <div class="bg-white rounded-xl shadow p-3 border border-gray-100 space-y-2 text-sm">

                    <div class="flex justify-between items-start pb-2 border-b">
                        <div class="space-y-0.5">
                            <span class="text-xs font-medium text-gray-500">Kode: {{ $donation->donation_code }}</span>
                            <p class="text-xs text-gray-700">Program: **{{ $donation->program->title ?? 'Dihapus' }}**
                            </p>
                        </div>
                        <span
                            class="px-2 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full
                                {{ $donation->status === 'success' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $donation->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ in_array($donation->status, ['failed', 'expire', 'unpaid']) ? 'bg-red-100 text-red-800' : '' }}
                                {{ $donation->status === 'refund' ? 'bg-blue-100 text-blue-800' : '' }}">
                            {{ ucfirst($donation->status) }}
                        </span>
                    </div>

                    <div class="flex justify-between items-center">
                        <span class="text-xs text-gray-500">Nominal:</span>
                        <span class="text-base font-bold text-green-600">
                            Rp {{ number_format($donation->amount, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="pt-2 border-t">
                        <span class="text-xs text-gray-500 block">Donatur:</span>
                        <p class="text-sm font-medium text-gray-900">{{ $donation->donor_name }}</p>
                        <p class="text-xs text-gray-500">{{ $donation->donor_email }} | {{ $donation->donor_phone }}
                        </p>
                    </div>

                    <div class="text-xs text-gray-500 text-right mt-1">
                        Donasi pada: {{ $donation->created_at->format('d M Y H:i') }}
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
                // Submit form ketika nilai perPage, Status, atau Program diubah
                ['perPage', 'status', 'program_id'].forEach(id => {
                    const el = document.getElementById(id);
                    if (el) el.addEventListener('change', () => document.getElementById('controlsForm')
                        .submit());
                });

                // press Enter in search input to submit
                const searchInput = document.querySelector('input[name="search"]');
                if (searchInput) {
                    searchInput.addEventListener('keydown', (e) => {
                        if (e.key === 'Enter') {
                            e.preventDefault();
                            document.getElementById('controlsForm').submit();
                        }
                    });
                }
            });
        </script>
    @endsection
@endsection
