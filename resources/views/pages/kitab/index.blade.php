@extends('components.layout.app')

@section('title', 'Kitab Nashaihul Ibad - Ayobuatbaik')

@section('og_title', 'Kitab Nashaihul Ibad - Ayobuatbaik')
@section('og_description', 'Kumpulan maqolah-maqolah hikmah dari Kitab Nashaihul Ibad karya Syekh Nawawi al-Bantani')
@section('og_url', 'https://ayobuatbaik.com/kitab')
@section('og_image', 'https://ayobuatbaik.com/img/icon_ABBI.png')

@section('header-content')
    @include('components.layout.header')
@endsection

@section('content')
    <div class="content bg-gray-50 min-h-screen">
        {{-- Hero Section --}}
        <div class="bg-gradient-to-br from-primary via-gray-800 to-gray-900 text-white pt-8 pb-12 px-4 relative overflow-hidden">
            <div class="relative z-10 text-center max-w-7xl mx-auto">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-white/10 backdrop-blur-sm rounded-2xl mb-4 shadow-lg border border-white/10">
                    <i class="fas fa-book-quran text-3xl text-secondary"></i>
                </div>
                <h1 class="text-2xl font-bold mb-2 tracking-tight">Kitab Nashaihul Ibad</h1>
                <p class="text-sm text-gray-300 mb-3 font-serif italic">نصائح العباد</p>
                <p class="text-xs text-gray-400 max-w-sm mx-auto leading-relaxed">
                    Kumpulan maqolah-maqolah hikmah karya Syekh Muhammad Nawawi al-Bantani al-Jawi Al-Indunisi
                </p>
                <div class="flex justify-center gap-4 mt-6 text-xs">
                    <div class="bg-white/10 backdrop-blur-sm px-4 py-2 rounded-full border border-white/10">
                        <i class="fas fa-book-open mr-1.5 text-secondary"></i> {{ count($chapters) }} Bab
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm px-4 py-2 rounded-full border border-white/10">
                        <i class="fas fa-scroll mr-1.5 text-secondary"></i> {{ $maqolahs }} Maqolah
                    </div>
                </div>
            </div>
        </div>

        {{-- Chapter List --}}
        <div class="px-4 py-8 pb-32">
            <div class="max-w-7xl mx-auto">
                <header class="mb-6">
                    <h2 class="text-xl font-bold text-primary flex items-center gap-2">
                        <i class="fas fa-list-ul text-secondary"></i>
                        Daftar Bab
                    </h2>
                    <div class="h-1 w-16 bg-secondary rounded-full mt-2"></div>
                </header>

                <div class="grid grid-cols-1 gap-4">
                    @forelse ($chapters as $chapter)
                        <a href="{{ route('home.kitab.chapter', $chapter->slug) }}"
                            class="block bg-white rounded-xl shadow-sm border border-gray-100 hover:border-secondary hover:shadow-md transition-all duration-300 overflow-hidden group h-full">
                            <div class="flex items-center p-4">
                                {{-- Chapter Number Badge --}}
                                <div class="flex-shrink-0 w-12 h-12 bg-gray-50 rounded-xl flex items-center justify-center mr-4 group-hover:bg-primary/10 transition-colors border border-gray-100">
                                    <span class="text-gray-600 font-bold text-lg group-hover:text-primary transition-colors">{{ $chapter->nomor_bab }}</span>
                                </div>

                                {{-- Chapter Info --}}
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-semibold text-gray-800 text-sm group-hover:text-primary transition-colors line-clamp-1 mb-1">
                                        Nashaihul Ibad Bab {{ $chapter->nomor_bab }}{{ $chapter->judul_bab ? ' : ' . $chapter->judul_bab : '' }}
                                    </h3>
                                    <p class="text-xs text-gray-500 line-clamp-1">
                                        {{ Str::limit(strip_tags($chapter->deskripsi), 100) }}
                                    </p>
                                    <div class="flex items-center mt-2 text-[10px] text-gray-400">
                                        <i class="fas fa-scroll mr-1 text-secondary"></i>
                                        <span>{{ $chapter->maqolahs_count }} Maqolah</span>
                                    </div>
                                </div>

                                {{-- Arrow Icon --}}
                                <div class="flex-shrink-0 ml-2">
                                    <div class="w-8 h-8 rounded-full bg-gray-50 flex items-center justify-center group-hover:bg-secondary group-hover:text-white transition-all">
                                        <i class="fas fa-chevron-right text-xs text-gray-400 group-hover:text-white"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="col-span-full text-center py-10 text-gray-500 bg-white rounded-xl border border-dashed border-gray-300">
                            <i class="fas fa-book text-5xl mb-3 text-gray-300"></i>
                            <p class="text-lg font-semibold">Belum ada data kitab.</p>
                            {{-- <p class="text-sm">Silakan hubungi admin</p> --}}
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
