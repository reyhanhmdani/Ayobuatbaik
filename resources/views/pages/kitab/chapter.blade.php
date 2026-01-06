@extends('components.layout.app')

@section('title', $chapter->judul_bab . ' - Kitab Nashaihul Ibad')

@section('og_title', $chapter->judul_bab . ' - Kitab Nashaihul Ibad')
@section('og_description', strip_tags($chapter->deskripsi))
@section('og_url', route('home.kitab.chapter', $chapter->slug))
@section('og_image', 'https://ayobuatbaik.com/img/icon_ABBI.png')

@section('header-content')
    @include('components.layout.header')
@endsection

@section('content')
    <div class="content bg-gray-50 min-h-screen">
        {{-- Header Section --}}
        <div class="bg-gradient-to-br from-primary via-gray-800 to-gray-900 text-white pt-4 pb-10 px-4 relative overflow-hidden">
            {{-- Decorative Elements --}}
            <div class="absolute inset-0 opacity-10">
                <div class="absolute top-0 right-0 w-64 h-64 bg-secondary rounded-full filter blur-3xl -translate-y-1/2 translate-x-1/2"></div>
            </div>

            <div class="relative z-10 max-w-7xl mx-auto">
                {{-- Back Button --}}
                <a href="{{ route('home.kitab.index') }}" 
                    class="inline-flex items-center text-sm text-gray-300 hover:text-secondary mb-6 transition-colors font-medium">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali ke Daftar Bab
                </a>

                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0 w-16 h-16 bg-white/10 backdrop-blur-md border border-white/10 rounded-2xl flex items-center justify-center shadow-lg">
                        <span class="text-secondary font-black text-2xl drop-shadow-sm">{{ $chapter->nomor_bab }}</span>
                    </div>
                    <div>
                        <span class="inline-block px-2 py-0.5 rounded-md bg-secondary/20 text-secondary text-[10px] font-bold tracking-wider mb-2 border border-secondary/20">
                            BAB {{ $chapter->nomor_bab }}
                        </span>
                        <h1 class="text-xl font-bold leading-tight mb-2">{{ $chapter->judul_bab }}</h1>
                        @if($chapter->deskripsi)
                            <p class="text-sm text-gray-300 leading-relaxed font-light">
                                {!! $chapter->deskripsi !!}
                            </p>
                        @endif
                        
                        <div class="flex items-center mt-4 text-xs text-gray-400 font-medium">
                            <i class="fas fa-scroll text-secondary mr-2"></i>
                            <span>{{ $chapter->maqolahs->count() }} Maqolah dalam bab ini</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Maqolah List --}}
        <div class="px-4 -mt-6 pb-24 relative z-20">
            <div class="max-w-7xl mx-auto space-y-3">
                @forelse ($chapter->maqolahs as $index => $maqolah)
                    <a href="{{ route('home.kitab.maqolah', ['chapterSlug' => $chapter->slug, 'id' => $maqolah->id]) }}"
                        class="block bg-white rounded-xl shadow-sm border border-gray-100 hover:border-secondary hover:shadow-md transition-all duration-300 overflow-hidden group">
                        <div class="p-4">
                            <div class="flex items-start gap-3">
                                {{-- Number Badge --}}
                                <div class="flex-shrink-0 w-8 h-8 bg-gray-50 border border-gray-100 group-hover:bg-secondary/10 group-hover:border-secondary/20 rounded-lg flex items-center justify-center transition-colors">
                                    <span class="text-gray-500 group-hover:text-secondary font-bold text-xs">{{ $maqolah->nomor_maqolah }}</span>
                                </div>

                                {{-- Content --}}
                                <div class="flex-1 min-w-0 pt-1">
                                    <h3 class="font-bold text-gray-800 text-sm group-hover:text-secondary transition-colors mb-1 line-clamp-2">
                                        {{ $maqolah->judul ?? 'Maqolah ' . $maqolah->nomor_maqolah }}
                                    </h3>
                                    <p class="text-xs text-gray-500 line-clamp-2 leading-relaxed font-light">
                                        {{ Str::limit(html_entity_decode(strip_tags($maqolah->konten)), 120) }}
                                    </p>
                                </div>

                                {{-- Arrow --}}
                                <div class="flex-shrink-0 ml-1 self-center">
                                    <div class="w-6 h-6 rounded-full flex items-center justify-center bg-gray-50 group-hover:bg-secondary group-hover:text-white transition-all">
                                        <i class="fas fa-chevron-right text-[10px] text-gray-300 group-hover:text-white"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="text-center py-12 bg-white rounded-xl border border-dashed border-gray-300">
                        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-scroll text-2xl text-gray-400"></i>
                        </div>
                        <p class="text-base font-semibold text-gray-600">Belum ada maqolah</p>
                        <p class="text-xs text-gray-400">Maqolah untuk bab ini belum tersedia.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
