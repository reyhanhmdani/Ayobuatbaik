@extends('components.layout.admin')

@section('title', 'Kelola Slider')
@section('page-title', 'Kelola Slider')

@section('content')
<div class="max-w-5xl mx-auto mt-8">

    <div class="bg-white rounded-xl shadow p-5 border border-gray-100">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-900">List Slider</h3>

            <a href="{{ route('admin.sliders.create') }}"
                class="inline-flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-plus"></i> Tambah Slider
            </a>
        </div>

        @if(session('success'))
            <div class="p-3 bg-green-100 text-green-700 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <ul id="slider-sortable" class="space-y-2">
    @foreach($sliders as $slider)
        <li data-id="{{ $slider->id }}"
            class="bg-white border rounded-xl p-3 shadow-sm
                   flex items-center gap-4
                   hover:bg-gray-50 cursor-move transition">

            <!-- LEFT: Image -->
            <div class="w-24 h-16 rounded-md overflow-hidden bg-gray-100 flex-shrink-0">
                <img src="{{ asset('storage/' . $slider->gambar) }}"
                     class="w-full h-full object-cover">
            </div>

            <!-- CENTER: URL + ALT -->
            <div class="flex-1">
                <p class="text-xs text-gray-600 break-all">
                    <span class="font-thin">URL:</span> {{ $slider->url ?? '-' }}
                </p>

                <p class="text-sm text-gray-500">
                    <span class="font-medium">Alt:</span> {{ $slider->alt_text ?? '—' }}
                </p>
            </div>

            <!-- RIGHT: Urutan + Actions -->
            <div class="flex flex-col items-end gap-2 w-20 text-right">

                <!-- Order Number -->
                <div class="text-gray-800 font-semibold text-lg">
                    #{{ $slider->urutan }}
                </div>

                <!-- Actions -->
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.sliders.edit', $slider->id) }}"
                       class="text-blue-600 hover:text-blue-800">
                        <i class="fas fa-edit text-lg"></i>
                    </a>

                    <form action="{{ route('admin.sliders.destroy', $slider->id) }}"
                          method="POST"
                          onsubmit="return confirm('Hapus slider ini?')">
                        @csrf @method('DELETE')
                        <button class="text-red-600 hover:text-red-800">
                            <i class="fas fa-trash text-lg"></i>
                        </button>
                    </form>
                </div>

            </div>

        </li>
    @endforeach
</ul>


        <div class="mt-4">
            {{ $sliders->links() }}
        </div>
    </div>
</div>

{{-- DRAGGABLE SORT SCRIPT --}}
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>

<script>
    const sortable = new Sortable(document.getElementById('slider-sortable'), {
        animation: 150,
        onEnd: function() {
            const order = [];
            document.querySelectorAll('#slider-sortable li').forEach((el, index) => {
                order.push({
                    id: el.getAttribute('data-id'),
                    urutan: index + 1
                });
            });

            fetch("{{ route('admin.sliders.reorder') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                body: JSON.stringify({ order })
            });
        }
    });
</script>
@endsection

@endsection
