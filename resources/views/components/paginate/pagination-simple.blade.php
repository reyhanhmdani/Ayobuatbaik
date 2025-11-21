@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-center space-x-2 text-sm">

        {{-- Previous Page Button --}}
        @if ($paginator->onFirstPage())
            <span class="inline-flex items-center px-3 py-1.5 border border-gray-200 rounded-lg text-gray-400 cursor-not-allowed">
                &laquo; Sebelumnya
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex items-center px-3 py-1.5 border border-primary text-primary rounded-lg font-medium hover:bg-primary hover:text-white transition duration-150 ease-in-out">
                &laquo; Sebelumnya
            </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span class="px-3 py-1.5 text-gray-500">{{ $element }}</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span aria-current="page" class="px-3 py-1.5 border border-primary bg-primary text-white rounded-lg font-medium">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}" class="px-3 py-1.5 border border-gray-200 text-gray-700 rounded-lg font-medium hover:bg-gray-100 transition duration-150 ease-in-out">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Button --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex items-center px-3 py-1.5 border border-primary text-primary rounded-lg font-medium hover:bg-primary hover:text-white transition duration-150 ease-in-out">
                Selanjutnya &raquo;
            </a>
        @else
            <span class="inline-flex items-center px-3 py-1.5 border border-gray-200 rounded-lg text-gray-400 cursor-not-allowed">
                Selanjutnya &raquo;
            </span>
        @endif
    </nav>
@endif
