@extends('components.layout.app')

@section('title', 'Halaman Tidak Ditemukan')

@section('header-content')
    @include('components.layout.header')
@endsection

@section('content')
    <div class="content pb-20">
        <div class="bg-white p-6 shadow-md rounded-lg mx-auto max-w-lg mt-10 text-center py-12">
            <i class="fas fa-search text-gray-300 text-7xl mb-4"></i>
            <h1 class="text-2xl font-bold text-gray-800">Halaman Tidak Ditemukan</h1>
            <p class="mt-3 text-gray-600 leading-relaxed">
                Maaf, halaman atau data donasi yang Anda cari tidak ditemukan di database kami.
            </p>

            <div class="mt-8 space-y-3">
                <a href="{{ route('home') }}"
                    class="block w-full py-3 rounded-lg font-bold bg-secondary text-white hover:bg-goldDark transition shadow-md">
                    <i class="fas fa-home mr-2"></i>Kembali ke Beranda
                </a>
                
                <a href="https://wa.me/6282133337058" target="_blank"
                    class="block w-full py-3 rounded-lg font-semibold border border-gray-300 text-gray-600 hover:bg-gray-50 transition">
                    <i class="fab fa-whatsapp mr-2"></i>Hubungi Admin
                </a>
            </div>
        </div>
    </div>
@endsection
