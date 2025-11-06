@extends('components.layout.admin')

@section('content')
    <div class="p-6">
        <h1 class="text-xl font-bold mb-6">Tambah Penggalang Dana</h1>

        @if ($errors->any())
            <div class="p-4 mb-4 bg-red-100 text-red-700 rounded">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.penggalang_dana.store') }}" method="POST" enctype="multipart/form-data"
            class="space-y-5 bg-white p-6 shadow rounded">
            @csrf

            <div>
                <label class="block mb-2 font-medium">Nama</label>
                <input type="text" name="nama" value="{{ old('nama') }}" required
                    class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200">
            </div>

            <div>
                <label class="block mb-2 font-medium">Tipe</label>
                <select name="tipe" class="w-full border rounded px-3 py-2">
                    <option value="individu">Individu</option>
                    <option value="yayasan">Yayasan</option>
                    <option value="komunitas">Komunitas</option>
                </select>
            </div>

            <div>
                <label class="block mb-2 font-medium">Kontak (Opsional)</label>
                <input type="text" name="kontak" value="{{ old('kontak') }}" class="w-full border rounded px-3 py-2">
            </div>

            <div>
                <label class="block mb-2 font-medium">Foto (Opsional)</label>
                <input type="file" name="foto" accept="image/*" class="w-full border rounded px-3 py-2">
            </div>

            <div class="flex justify-end">
                <a href="{{ route('admin.penggalang_dana.index') }}" class="px-4 py-2 bg-gray-200 rounded mr-2">Batal</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Simpan</button>
            </div>
        </form>
    </div>
@endsection
