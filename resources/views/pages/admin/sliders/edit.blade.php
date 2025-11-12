@extends('components.layout.admin')

@section('title', 'Edit Slider')
@section('page-title', 'Edit Slider')

@section('content')
<div class="max-w-3xl mx-auto mt-8">
    <div class="bg-white border rounded-xl shadow p-6">

        <form action="{{ route('admin.sliders.update', $slider->id) }}"
              method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf @method('PUT')

            <div>
                <label class="block text-sm font-medium mb-1">Gambar</label>

                <div class="w-40 h-28 rounded overflow-hidden shadow">
                    <img src="{{ asset('storage/' . $slider->gambar) }}" id="currentImg"
                         class="w-full h-full object-cover">
                </div>

                <input type="file" name="gambar" id="gambarInput"
                       class="w-full border rounded-lg p-2 mt-2">

                <div id="preview" class="mt-3 hidden">
                    <img class="w-40 rounded shadow">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Urutan</label>
                <input type="number" name="urutan"
                       value="{{ $slider->urutan }}"
                       class="w-full border rounded-lg p-2">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">URL</label>
                <input type="text" name="url"
                       value="{{ $slider->url }}"
                       class="w-full border rounded-lg p-2">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Alt (SEO)</label>
                <input type="text" name="alt_text"
                       value="{{ $slider->alt_text }}"
                       class="w-full border rounded-lg p-2">
            </div>

            <button
                class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">
                Update
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
</script>

@endsection
