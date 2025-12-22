@extends('components.layout.admin')

@section('title', 'Kelola Maqolah Kitab - Ayobuatbaik')
@section('page-title', 'Kelola Maqolah Kitab')

@section('content')
    @php use Illuminate\Support\Str; @endphp

    <div class="max-w-7xl mx-auto mt-8">
        <!-- Header & Filter -->
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex items-center gap-3 flex-wrap">
                    <h3 class="text-base font-semibold text-gray-900">
                        Daftar Maqolah
                        @if($selectedChapter)
                            <span class="text-primary">- Bab {{ $selectedChapter->nomor_bab }}</span>
                        @endif
                    </h3>
                    <a href="{{ route('admin.kitab_maqolah.create', ['chapter' => request('chapter')]) }}"
                        class="inline-flex items-center gap-2 bg-primary text-white px-3 py-2 rounded-lg hover:bg-gray-700 transition">
                        <i class="fas fa-plus"></i> <span>Tambah Maqolah</span>
                    </a>
                </div>

                <!-- Filter Form -->
                <form id="controlsForm" method="GET" class="flex flex-col sm:flex-row gap-3 items-stretch sm:items-center">
                    <select name="chapter" id="chapter" class="border rounded px-3 py-2">
                        <option value="">Semua Bab</option>
                        @foreach($chapters as $ch)
                            <option value="{{ $ch->id }}" {{ request('chapter') == $ch->id ? 'selected' : '' }}>
                                Bab {{ $ch->nomor_bab }} - {{ Str::limit($ch->judul_bab, 25) }}
                            </option>
                        @endforeach
                    </select>

                    <input type="text" name="search" placeholder="Cari judul..." value="{{ request('search') }}"
                        class="w-full sm:w-48 border px-3 py-2 rounded-md focus:outline-none focus:ring-1 focus:ring-primary" />

                    <div class="flex items-center gap-2">
                        <label class="text-sm text-gray-600">Show</label>
                        <select name="perPage" id="perPage" class="border rounded px-2 py-2">
                            @foreach ([10, 30, 50, 100] as $size)
                                <option value="{{ $size }}" {{ request('perPage', 10) == $size ? 'selected' : '' }}>
                                    {{ $size }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit"
                        class="bg-secondary text-white px-3 py-2 rounded-md hover:opacity-95 transition">Terapkan</button>
                </form>
            </div>
        </div>

        <!-- Alert -->
        @if (session('success'))
            <div class="mt-4 p-3 bg-green-100 text-green-800 rounded-lg">{{ session('success') }}</div>
        @endif

        <!-- Table -->
        <div class="mt-4">
            <!-- Desktop Table -->
            <div class="hidden md:block bg-white rounded-xl shadow-sm p-4 border border-gray-100">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="text-gray-600 bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left w-16">No</th>
                                <th class="px-4 py-3 text-left">Bab</th>
                                <th class="px-4 py-3 text-left">Judul</th>
                                <th class="px-4 py-3 text-left">Preview Konten</th>
                                <th class="px-4 py-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @forelse($maqolahs as $maqolah)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 font-semibold text-primary">{{ $maqolah->nomor_maqolah }}</td>
                                    <td class="px-4 py-3">
                                        <span class="inline-flex items-center px-2 py-1 bg-gray-100 rounded text-xs">
                                            Bab {{ $maqolah->chapter->nomor_bab }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="font-semibold">{{ Str::limit($maqolah->judul, 40) }}</div>
                                    </td>
                                    <td class="px-4 py-3 text-gray-600">
                                        {{ Str::limit(strip_tags($maqolah->konten), 60) }}
                                    </td>
                                    <td class="px-4 py-3 text-right">
                                        <a href="{{ route('admin.kitab_maqolah.edit', $maqolah->id) }}"
                                            class="text-blue-600 hover:text-blue-800 mr-3"><i class="fas fa-edit"></i></a>
                                        <form action="{{ route('admin.kitab_maqolah.destroy', $maqolah->id) }}" method="POST"
                                            class="inline" onsubmit="return confirm('Hapus maqolah ini?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-6 text-gray-500">Belum ada maqolah.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $maqolahs->appends(request()->query())->links() }}
                </div>
            </div>

            <!-- Mobile Cards -->
            <div class="md:hidden space-y-3">
                @forelse($maqolahs as $maqolah)
                    <div class="bg-white rounded-lg shadow p-4 border border-gray-100">
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 bg-primary/10 rounded-lg flex items-center justify-center flex-shrink-0">
                                <span class="text-primary font-bold text-sm">{{ $maqolah->nomor_maqolah }}</span>
                            </div>
                            <div class="flex-1">
                                <div class="text-xs text-gray-400 mb-1">Bab {{ $maqolah->chapter->nomor_bab }}</div>
                                <div class="font-semibold text-sm">{{ Str::limit($maqolah->judul, 35) }}</div>
                                <div class="text-xs text-gray-500 mt-1">{{ Str::limit(strip_tags($maqolah->konten), 50) }}</div>
                                <div class="flex justify-end gap-3 text-xs mt-3">
                                    <a href="{{ route('admin.kitab_maqolah.edit', $maqolah->id) }}" class="text-blue-600">
                                        <i class="fas fa-edit"></i></a>
                                    <form action="{{ route('admin.kitab_maqolah.destroy', $maqolah->id) }}" method="POST"
                                        onsubmit="return confirm('Hapus maqolah ini?');" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-600">
                                            <i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-6 text-gray-500">Belum ada maqolah.</div>
                @endforelse

                <div class="mt-4">
                    {{ $maqolahs->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>

    @section('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                ['chapter', 'perPage'].forEach(id => {
                    const el = document.getElementById(id);
                    if (el) el.addEventListener('change', () => document.getElementById('controlsForm').submit());
                });
            });
        </script>
    @endsection
@endsection
