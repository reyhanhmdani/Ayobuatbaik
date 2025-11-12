@extends('components.layout.admin')

@section('title', 'Tambah Slider')
@section('page-title', 'Tambah Slider')

@section('content')

    <div class="max-w-3xl mx-auto mt-8">

        {{-- ✅ Tombol Kembali --}}
        <div class="mb-4">
            <a href="{{ route('admin.sliders.index') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-100 border rounded-lg hover:bg-gray-200 transition">
                ← Kembali
            </a>
        </div>

        {{-- ✅ Popup Berhasil --}}
        @if (session('success'))
            <div id="successAlert"
                class="transition-soft mb-4 p-4 rounded-xl bg-green-50 border border-green-200 text-green-700 flex items-start gap-3 animate-fade-in">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mt-0.5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <div class="font-medium">
                    {{ session('success') }}
                </div>
            </div>
        @endif

        <div class="bg-white border rounded-xl shadow p-6">

            <form action="{{ route('admin.sliders.store') }}" method="POST" enctype="multipart/form-data"
                class="space-y-5">
                @csrf

                {{-- Input Gambar --}}
                <div>
                    <label class="block text-sm font-medium mb-1">Gambar</label>
                    <input type="file" name="gambar" id="gambarInput" class="w-full border rounded-lg p-2">
                    <p class="text-xs text-gray-500 mt-1">Maks 2MB — JPG/PNG</p>

                    <div id="preview" class="mt-3 hidden">
                        <img class="w-40 rounded shadow">
                    </div>
                </div>

                {{-- Input Urutan --}}
                <div>
                    <label class="block text-sm font-medium mb-1">Urutan</label>
                    <input type="number" name="urutan" class="w-full border rounded-lg p-2"
                        value="{{ old('urutan', $nextOrder) }}">
                </div>

                {{-- URL --}}
                <div>
                    <label class="block text-sm font-medium mb-1">URL (opsional)</label>
                    <input type="text" name="url" class="w-full border rounded-lg p-2" value="{{ old('url') }}">
                </div>

                {{-- ALT --}}
                <div>
                    <label class="block text-sm font-medium mb-1">Alt (SEO)</label>
                    <input type="text" name="alt_text" class="w-full border rounded-lg p-2" value="{{ old('alt_text') }}">
                </div>

                {{-- Tombol Submit --}}
                <button class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">
                    Simpan
                </button>

            </form>

        </div>
    </div>
    @endsection

    @section('scripts')
    <script>
        document.getElementById('gambarInput').addEventListener('change', function(e) {
            const img = document.querySelector('#preview img');
            img.src = URL.createObjectURL(e.target.files[0]);
            document.getElementById('preview').classList.remove('hidden');
        });
        // Auto close popup success
        setTimeout(() => {
            const alert = document.getElementById('successAlert');
            if (alert) {
                alert.classList.add('opacity-0', 'translate-y-2');
                setTimeout(() => alert.remove(), 300);
            }
        }, 3000);
        </script>

    @endsection
    {{-- Preview Gambar --}}

    {{-- Fade In Animation --}}
    <style>
        .transition-soft {
            transition: all .3s ease;
        }

        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(-6px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fade-in .3s ease-out;
        }
    </style>

