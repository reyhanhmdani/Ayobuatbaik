@extends('components.layout.admin')

@section('content')
    <div class="max-w-4xl mx-auto mt-8">
        <div class="bg-white shadow-sm rounded-xl p-6 border border-gray-100">
            <h2 class="text-lg font-semibold text-gray-800 mb-6">Edit Program Donasi</h2>

            {{-- Pesan sukses --}}
            @if (session('success'))
                <div class="p-3 mb-4 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
            @endif

            {{-- Pesan error --}}
            @if ($errors->any())
                <div class="p-3 mb-4 bg-red-50 border border-red-200 text-red-700 rounded">
                    <strong>Ada error saat submit:</strong>
                    <ul class="list-disc mt-2 ml-5">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.programs.update', $programs->id) }}" method="POST" enctype="multipart/form-data"
                class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Judul -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Judul Program</label>
                    <input type="text" name="title" value="{{ old('title', $programs->title) }}"
                        class="w-full border-0 border-b border-gray-300 focus:border-primary focus:ring-0"
                        placeholder="Masukkan judul program">
                </div>

                <!-- Kategori -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                    <select name="kategori_id"
                        class="w-full border-0 border-b border-gray-300 focus:border-primary focus:ring-0">
                        @foreach ($kategories as $kategori)
                            <option value="{{ $kategori->id }}"
                                {{ $programs->kategori_id == $kategori->id ? 'selected' : '' }}>
                                {{ $kategori->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Penggalang Dana -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Penggalang Dana</label>
                    <select name="penggalang_id"
                        class="w-full border-0 border-b border-gray-300 focus:border-primary focus:ring-0">
                        @foreach ($penggalangs as $penggalang)
                            <option value="{{ $penggalang->id }}"
                                {{ $programs->penggalang_id == $penggalang->id ? 'selected' : '' }}>
                                {{ $penggalang->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Target -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Target Donasi (Rp)</label>
                    <input type="number" name="target_amount" value="{{ old('target_amount', $programs->target_amount) }}"
                        class="w-full border-0 border-b border-gray-300 focus:border-primary focus:ring-0" min="0">
                </div>

                <!-- Collected Amount (readonly) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Terkumpul (Rp)</label>
                    <input type="number" name="collected_amount"
                        value="{{ old('collected_amount', $programs->collected_amount) }}"
                        class="w-full border-0 border-b border-gray-300 focus:border-primary focus:ring-0" readonly>
                </div>

                <!-- Start Date -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                    <input type="date" name="start_date" value="{{ old('start_date', $programs->start_date) }}"
                        class="w-full border-0 border-b border-gray-300 focus:border-primary focus:ring-0">
                </div>

                <!-- End Date -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Berakhir (opsional)</label>
                    <input type="date" name="end_date" value="{{ old('end_date', $programs->end_date) }}"
                        class="w-full border-0 border-b border-gray-300 focus:border-primary focus:ring-0">
                </div>

                <!-- Gambar -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Gambar Program</label>
                    @if ($programs->gambar)
                        <img src="{{ asset('storage/' . $programs->gambar) }}"
                            class="w-32 h-20 object-cover mb-2 rounded-md">
                    @endif
                    <input type="file" name="gambar" accept="image/*"
                        class="w-full border-0 border-b border-gray-300 focus:border-primary focus:ring-0">
                </div>

                <!-- Short Description -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Singkat</label>
                    <input type="text" name="short_description"
                        value="{{ old('short_description', $programs->short_description) }}"
                        class="w-full border rounded px-3 py-2" placeholder="Tuliskan ringkasan singkat program">
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status"
                        class="w-full border-0 border-b border-gray-300 focus:border-primary focus:ring-0">
                        <option value="active" {{ old('status', $programs->status) == 'active' ? 'selected' : '' }}>Aktif
                        </option>
                        <option value="closed" {{ old('status', $programs->status) == 'closed' ? 'selected' : '' }}>
                            Nonaktif</option>
                        <option value="archived" {{ old('status', $programs->status) == 'archived' ? 'selected' : '' }}>
                            Draft</option>
                    </select>
                </div>

                <!-- Verified -->
                <div>
                    <label class="inline-flex items-center space-x-2">
                        <input type="checkbox" name="verified" value="1"
                            {{ old('verified', $programs->verified) ? 'checked' : '' }}
                            class="rounded text-primary focus:ring-primary">
                        <span class="text-sm text-gray-700">Terverifikasi</span>
                    </label>
                </div>

                <!-- Program Pilihan (Featured) -->
                <div>
                    <label class="inline-flex items-center space-x-2">
                        <input type="checkbox" name="featured" value="1"
                            {{ old('featured', $programs->featured) ? 'checked' : '' }}
                            class="rounded text-primary focus:ring-primary">
                        <span class="text-sm text-gray-700">Program Pilihan</span>
                    </label>
                </div>

                <!-- Deskripsi -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Lengkap</label>
                    <textarea name="deskripsi" id="deskripsi" class="w-full">{{ old('deskripsi', $programs->deskripsi) }}</textarea>
                </div>



                <!-- Tombol -->
                <div class="flex justify-end gap-3 pt-4">
                    <a href="{{ route('admin.programs.index') }}"
                        class="px-4 py-2 text-gray-600 hover:text-gray-800">Batal</a>
                    <button type="submit"
                        class="px-5 py-2 bg-primary text-white rounded-lg hover:bg-green-700 transition">Perbarui</button>
                </div>
            </form>
        </div>
    </div>

    <!-- CKEditor -->
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    <script>
        CKEDITOR.replace('deskripsi', {
            height: 400,
            filebrowserUploadUrl: "{{ route('admin.ckeditor.upload', ['_token' => csrf_token()]) }}",
            filebrowserUploadMethod: 'form',
            toolbar: [{
                    name: 'basicstyles',
                    items: ['Bold', 'Italic', 'Underline', 'Strike', 'RemoveFormat']
                },
                {
                    name: 'paragraph',
                    items: ['NumberedList', 'BulletedList', 'Blockquote', 'JustifyLeft', 'JustifyCenter',
                        'JustifyRight', 'JustifyBlock'
                    ]
                },
                {
                    name: 'insert',
                    items: ['Image', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar']
                },
                {
                    name: 'styles',
                    items: ['Styles', 'Format', 'Font', 'FontSize']
                },
                {
                    name: 'colors',
                    items: ['TextColor', 'BGColor']
                },
                {
                    name: 'tools',
                    items: ['Maximize']
                }
            ]
        });
    </script>
@endsection
