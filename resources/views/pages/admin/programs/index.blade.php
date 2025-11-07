@extends('components.layout.admin')

@section('title', 'Kelola Program Donasi - Ayobuatbaik')
@section('page-title', 'Kelola Program Donasi')

@section('content')
    @php use Illuminate\Support\Str; @endphp

    <div class="max-w-7xl mx-auto mt-8">
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex items-center gap-3">
                    <h3 class="text-base font-semibold text-gray-900">Daftar Program Donasi</h3>
                    <a href="{{ route('admin.programs.create') }}"
                        class="ml-2 inline-flex items-center gap-2 bg-blue-600 text-white px-3 py-2 rounded-lg hover:bg-blue-700 transition">
                        <i class="fas fa-plus"></i>
                    </a>
                </div>

                <!-- Controls -->
                <form id="controlsForm" method="GET" class="flex flex-col sm:flex-row gap-3 items-stretch sm:items-center">
                    <div class="flex items-center gap-2">
                        <input type="text" name="search" placeholder="Cari judul / penggalang..."
                            value="{{ request('search') ?? $search }}"
                            class="w-full sm:w-64 border px-3 py-2 rounded-md focus:outline-none focus:ring-1 focus:ring-primary" />
                    </div>

                    <div class="flex items-center gap-2">
                        <label class="text-sm text-gray-600">Show</label>
                        <select name="perPage" id="perPage" class="border rounded px-2 py-2">
                            <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                            <option value="30" {{ $perPage == 30 ? 'selected' : '' }}>30</option>
                            <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
                        </select>
                    </div>

                    <div class="flex items-center gap-2">
                        <label class="text-sm text-gray-600">Sort</label>
                        <select name="sort" id="sort" class="border rounded px-2 py-2">
                            <option value="created_at" {{ $sort == 'created_at' ? 'selected' : '' }}>Created At</option>
                            <option value="title" {{ $sort == 'title' ? 'selected' : '' }}>Title</option>
                            <option value="penggalang" {{ $sort == 'penggalang' ? 'selected' : '' }}>Penggalang</option>
                            <option value="target_amount" {{ $sort == 'target_amount' ? 'selected' : '' }}>Target</option>
                            <option value="end_date" {{ $sort == 'end_date' ? 'selected' : '' }}>End Date</option>
                            <option value="status" {{ $sort == 'status' ? 'selected' : '' }}>Status</option>
                            <option value="verified" {{ $sort == 'verified' ? 'selected' : '' }}>Verified</option>
                        </select>

                        <select name="direction" id="direction" class="border rounded px-2 py-2">
                            <option value="desc" {{ $direction == 'desc' ? 'selected' : '' }}>Desc</option>
                            <option value="asc" {{ $direction == 'asc' ? 'selected' : '' }}>Asc</option>
                        </select>
                    </div>

                    <div>
                        <button type="submit"
                            class="bg-secondary text-white px-3 py-2 rounded-md hover:opacity-95 transition">Apply</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Table Desktop / Card Mobile -->
        <div class="mt-4">
            <!-- Desktop Table -->
            <div class="hidden md:block bg-white rounded-xl shadow-sm p-4 border border-gray-100">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="text-gray-600 bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left">Title</th>
                                <th class="px-4 py-3 text-left">Penggalang</th>
                                <th class="px-4 py-3 text-left">Target</th>
                                <th class="px-4 py-3 text-left">Dibuat</th>
                                <th class="px-4 py-3 text-left">Berakhir</th>
                                <th class="px-4 py-3 text-left">Status</th>
                                <th class="px-4 py-3 text-left">Verified</th>
                                <th class="px-4 py-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @forelse($programs as $program)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-3">
                                            <div class="w-12 h-12 bg-gray-100 rounded overflow-hidden flex-shrink-0">
                                                @if ($program->gambar)
                                                    <img src="{{ asset('storage/' . $program->gambar) }}" alt=""
                                                        class="w-full h-full object-cover">
                                                @else
                                                    <div
                                                        class="w-full h-full flex items-center justify-center text-gray-400">
                                                        <i class="fas fa-image"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div>
                                                <div class="font-semibold">
                                                    {{ Str::limit($program->title, 10, '...') }}
                                                </div>
                                                <div class="text-xs text-gray-500">
                                                    {{ $program->short_description ? Str::limit($program->short_description, 30) : '' }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-4 py-3">{{ $program->penggalang->nama ?? '-' }}</td>
                                    <td class="px-4 py-3">Rp {{ number_format($program->target_amount, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3">{{ optional($program->created_at)->format('d M Y') }}</td>
                                    <td class="px-4 py-3">
                                        {{ $program->end_date ? \Carbon\Carbon::parse($program->end_date)->format('d M Y') : '—' }}
                                    </td>

                                    <td class="px-4 py-3">
                                        <span
                                            class="px-2 py-1 rounded-lg text-xs
                                    {{ $program->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                                            {{ ucfirst($program->status) }}
                                        </span>
                                    </td>

                                    <td class="px-4 py-3 text-center">
                                        @if ($program->verified)
                                            <span class="inline-flex items-center gap-1 text-xs text-blue-700">
                                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <rect width="24" height="24" rx="6" fill="#2B9AF3" />
                                                    <path d="M7 12.5l2.5 2.5L17 8" stroke="#fff" stroke-width="2"
                                                        stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                                Yes
                                            </span>
                                        @else
                                            <span class="text-xs text-gray-500">No</span>
                                        @endif
                                    </td>

                                    <td class="px-4 py-3 text-right">
                                        <a href="{{ route('admin.programs.edit', $program->id) }}"
                                            class="text-blue-600 hover:text-blue-800 mr-3"><i class="fas fa-edit"></i></a>

                                        <form action="{{ route('admin.programs.destroy', $program->id) }}" method="POST"
                                            class="inline" onsubmit="return confirm('Hapus program ini?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800"><i
                                                    class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-6 text-gray-500">Belum ada program donasi.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $programs->links() }}
                </div>
            </div>

            <!-- Mobile Cards -->
            <div class="md:hidden space-y-3">
                @forelse($programs as $program)
                    <div class="bg-white rounded-lg shadow p-3 border border-gray-100">
                        <div class="flex items-start gap-3">
                            <div class="w-20 h-16 rounded overflow-hidden flex-shrink-0 bg-gray-100">
                                @if ($program->gambar)
                                    <img src="{{ asset('storage/' . $program->gambar) }}"
                                        class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400"><i
                                            class="fas fa-image"></i></div>
                                @endif
                            </div>
                            <div class="flex-1">
                                <div class="flex justify-between items-start">
                                    <div class="font-semibold text-sm">{{ Str::limit($program->title, 10, '...') }}</div>
                                    <div class="text-xs text-gray-500">
                                        {{ $program->created_at ? $program->created_at->format('d M Y') : '' }}</div>
                                </div>
                                <div class="text-xs text-gray-600 mt-1">Penggalang:
                                    {{ $program->penggalang->nama ?? '-' }}</div>
                                <div class="text-xs text-gray-600">Target: Rp
                                    {{ number_format($program->target_amount, 0, ',', '.') }}</div>
                                <div class="flex items-center justify-between mt-2 text-xs">
                                    <div>
                                        <span class="px-2 py-1 rounded bg-gray-100">{{ ucfirst($program->status) }}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        @if ($program->verified)
                                            <span class="text-blue-600 text-xs">Terverifikasi</span>
                                        @endif
                                        <a href="{{ route('admin.programs.edit', $program->id) }}"
                                            class="text-blue-600"><i class="fas fa-edit"></i></a>
                                        <form action="{{ route('admin.programs.destroy', $program->id) }}" method="POST"
                                            class="inline" onsubmit="return confirm('Hapus program ini?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600"><i
                                                    class="fas fa-trash"></i></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-6 text-gray-500">Belum ada program donasi.</div>
                @endforelse

                <div class="mt-4">
                    {{ $programs->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- JS to auto-submit on control change -->
    @section('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const perPage = document.getElementById('perPage');
                const sort = document.getElementById('sort');
                const direction = document.getElementById('direction');

                [perPage, sort, direction].forEach(el => {
                    if (!el) return;
                    el.addEventListener('change', () => {
                        // keep search value present in querystring
                        document.getElementById('controlsForm').submit();
                    });
                });

                // press Enter in search input to submit
                const searchInput = document.querySelector('input[name="search"]');
                if (searchInput) {
                    searchInput.addEventListener('keydown', (e) => {
                        if (e.key === 'Enter') {
                            e.preventDefault();
                            document.getElementById('controlsForm').submit();
                        }
                    });
                }
            });
        </script>
    @endsection

@endsection
