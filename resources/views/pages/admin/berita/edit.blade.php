    @extends('components.layout.admin')

    @section('title', 'Edit Berita')
    @section('page-title', 'Edit Berita')

    @section('content')
    <div class="max-w-4xl mx-auto mt-8">
        <div class="bg-white shadow-sm rounded-xl p-6 border border-gray-100">
            <h2 class="text-lg font-semibold text-gray-800 mb-6">Edit Berita</h2>

            @if (session('success'))
                <div class="p-3 mb-4 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div class="p-3 mb-4 bg-red-50 border border-red-200 text-red-700 rounded">
                    <strong>Terdapat kesalahan:</strong>
                    <ul class="list-disc ml-5 mt-2">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.berita.update', $berita->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Judul -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Judul</label>
                    <input type="text" name="judul" value="{{ old('judul', $berita->judul) }}"
                        class="w-full border-0 border-b border-gray-300 focus:border-primary focus:ring-0">
                </div>

                <!-- Slug -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
                    <input type="text" name="slug" value="{{ old('slug', $berita->slug) }}"
                        class="w-full border-0 border-b border-gray-300 focus:border-primary focus:ring-0">
                </div>

                <!-- Tanggal -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                    <input type="date" name="tanggal" value="{{ old('tanggal', $berita->tanggal ? $berita->tanggal->format('Y-m-d') : '') }}"
                        class="w-full border-0 border-b border-gray-300 focus:border-primary focus:ring-0">
                </div>

                <!-- Gambar -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Gambar</label>
                    @if ($berita->gambar)
                        <img src="{{ asset('storage/' . $berita->gambar) }}" class="w-32 h-20 object-cover mb-2 rounded-md">
                    @endif
                    <input type="file" name="gambar" accept="image/*"
                        class="w-full border-0 border-b border-gray-300 focus:border-primary focus:ring-0">
                </div>

                <!-- Deskripsi Singkat -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Singkat</label>
                    <input type="text" name="deskripsi_singkat" value="{{ old('deskripsi_singkat', $berita->deskripsi_singkat) }}"
                        class="w-full border rounded px-3 py-2">
                </div>

                <!-- Konten -->
                <div class="prose prose-sm">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Konten Berita</label>
                    <textarea name="konten" id="konten" class="w-full">{{ old('konten', $berita->konten) }}</textarea>
                </div>

                <!-- Tombol -->
                <div class="flex justify-end gap-3 pt-4">
                    <a href="{{ route('admin.berita.index') }}" class="px-4 py-2 text-gray-600 hover:text-gray-800">Batal</a>
                    <button type="submit"
                        class="px-5 py-2 bg-primary text-white rounded-lg hover:bg-green-700 transition">Perbarui</button>
                </div>
            </form>
        </div>
    </div>

    {{-- CKEditor --}}
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    <script>
        try {
                CKEDITOR.replace('konten', {
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
                    ],
                    bodyClass: 'prose prose-sm text-gray-700',
                    width: '100%'
                });
            } catch (e) {
                console.error('CKEditor init error:', e);
            }
    </script>
    @endsection
