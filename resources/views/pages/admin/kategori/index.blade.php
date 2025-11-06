@extends('components.layout.admin')

@section('content')
    <div class="p-6">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-xl font-bold">Kategori Donasi</h1>
            <a href="{{ route('admin.kategori_donasi.create') }}"
                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">+ Tambah Kategori</a>
        </div>

        @if (session('success'))
            <div class="p-3 bg-green-100 text-green-700 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <table class="w-full border-collapse bg-white shadow rounded">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="p-3 border-b">#</th>
                    <th class="p-3 border-b">Nama</th>
                    <th class="p-3 border-b">Slug</th>
                    <th class="p-3 border-b">Deskripsi</th>
                    <th class="p-3 border-b text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($kategories as $kategori)
                    <tr class="border-b">
                        <td class="p-3">{{ $loop->iteration }}</td>
                        <td class="p-3">{{ $kategori->name }}</td>
                        <td class="p-3">{{ $kategori->slug }}</td>
                        <td class="p-3">{{ Str::limit($kategori->deskripsi, 50) }}</td>
                        <td class="p-3 text-center">
                            <a href="{{ route('admin.kategori_donasi.edit', $kategori->id) }}"
                                class="text-blue-500 hover:underline">Edit</a> |
                            <form action="{{ route('admin.kategori_donasi.destroy', $kategori->id) }}" method="POST"
                                class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Yakin ingin menghapus?')"
                                    class="text-red-500 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-3 text-center text-gray-500">Belum ada kategori.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $kategories->links() }}
        </div>
    </div>
@endsection
