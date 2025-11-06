@extends('components.layout.admin')

@section('content')
    <div class="p-6">
        <h1 class="text-xl font-bold mb-6">Tambah Kategori Donasi</h1>

        @if ($errors->any())
            <div class="p-4 mb-4 bg-red-100 text-red-700 rounded">
                <strong>Terjadi kesalahan:</strong>
                <ul class="list-disc list-inside mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.kategori_donasi.store') }}" method="POST" class="space-y-5 bg-white p-6 shadow rounded">
            @csrf

            <div>
                <label class="block text-gray-700 font-medium mb-2">Nama Kategori</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-500">
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-2">Deskripsi (Opsional)</label>
                <textarea name="deskripsi" rows="4"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-500">{{ old('deskripsi') }}</textarea>
            </div>

            <div class="flex justify-end">
                <a href="{{ route('admin.kategori_donasi.index') }}"
                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 mr-2">Batal</a>

                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Simpan
                </button>
            </div>
        </form>
    </div>
@endsection
