@extends('components.layout.admin')

@section('content')
    <div class="p-6">
        <h1 class="text-xl font-bold mb-6">Edit Penggalang Dana</h1>

        <form action="{{ route('admin.penggalang_dana.update', $penggalang->id) }}" method="POST"
            enctype="multipart/form-data" class="space-y-5 bg-white p-6 shadow rounded">
            @csrf
            @method('PUT')

            <div>
                <label class="block mb-2 font-medium">Nama</label>
                <input type="text" name="nama" value="{{ old('nama', $penggalang->nama) }}" required
                    class="w-full border rounded px-3 py-2">
            </div>

            <div>
                <label class="block mb-2 font-medium">Tipe</label>
                <select name="tipe" class="w-full border rounded px-3 py-2">
                    <option value="individu" {{ $penggalang->tipe == 'individu' ? 'selected' : '' }}>Individu</option>
                    <option value="yayasan" {{ $penggalang->tipe == 'yayasan' ? 'selected' : '' }}>Yayasan</option>
                    <option value="komunitas" {{ $penggalang->tipe == 'komunitas' ? 'selected' : '' }}>Komunitas</option>
                </select>
            </div>

            <div>
                <label class="block mb-2 font-medium">Kontak</label>
                <input type="text" name="kontak" value="{{ old('kontak', $penggalang->kontak) }}"
                    class="w-full border rounded px-3 py-2">
            </div>

            <div>
                <label class="block mb-2 font-medium">Foto</label>
                @if ($penggalang->foto)
                    <img src="{{ asset('storage/' . $penggalang->foto) }}" class="w-20 h-20 rounded-full mb-2 object-cover">
                @endif
                <input type="file" name="foto" accept="image/*" class="w-full border rounded px-3 py-2">
            </div>

            <div class="flex justify-end">
                <a href="{{ route('admin.penggalang_dana.index') }}" class="px-4 py-2 bg-gray-200 rounded mr-2">Batal</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Update</button>
            </div>
        </form>
    </div>
@endsection
