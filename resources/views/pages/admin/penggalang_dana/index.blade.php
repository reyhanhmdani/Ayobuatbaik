@extends('components.layout.admin')

@section('content')
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-xl font-bold">Daftar Penggalang Dana</h1>
            <a href="{{ route('admin.penggalang_dana.create') }}"
                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                + Tambah Penggalang
            </a>
        </div>

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto bg-white shadow rounded">
            <table class="min-w-full text-left text-gray-700">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-3">#</th>
                        <th class="px-4 py-3">Nama</th>
                        <th class="px-4 py-3">Tipe</th>
                        <th class="px-4 py-3">Kontak</th>
                        <th class="px-4 py-3">Foto</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($penggalangs as $index => $item)
                        <tr class="border-t">
                            <td class="px-4 py-3">{{ $penggalangs->firstItem() + $index }}</td>
                            <td class="px-4 py-3">{{ $item->nama }}</td>
                            <td class="px-4 py-3 capitalize">{{ $item->tipe }}</td>
                            <td class="px-4 py-3">{{ $item->kontak ?? '-' }}</td>
                            <td class="px-4 py-3">
                                @if ($item->foto)
                                    <img src="{{ asset('storage/' . $item->foto) }}" alt=""
                                        class="w-12 h-12 rounded-full object-cover">
                                @else
                                    <span class="text-gray-400 italic">Tidak ada</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right space-x-2">
                                <a href="{{ route('admin.penggalang_dana.edit', $item->id) }}"
                                    class="px-3 py-1 bg-yellow-400 text-white rounded hover:bg-yellow-500">Edit</a>

                                <form action="{{ route('admin.penggalang_dana.destroy', $item->id) }}" method="POST"
                                    class="inline-block" onsubmit="return confirm('Yakin hapus penggalang ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-3 text-center text-gray-500">Belum ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $penggalangs->links() }}
        </div>
    </div>
@endsection
