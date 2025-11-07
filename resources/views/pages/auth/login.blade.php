@extends('components.layout.app')

@section('title', 'Login - Ayobuatbaik')

@section('header-content')
    <nav class="mobile-top-bar bg-primary">
        <div class="flex justify-center items-center h-full">
            <h1 class="text-xl font-bold text-white"><span class="text-secondary">Ayo</span>buatbaik</h1>
        </div>
    </nav>
@endsection

@section('content')
    <div class="bg-white flex items-center justify-center px-4 py-4">
        <div class="max-w-md w-full">
            <div class="bg-grayLight rounded-xl shadow-lg p-8 border-2 border-secondary">
                <div class="text-center mb-6">
                    <h2 class="text-2xl font-bold text-primary">Masuk ke Admin</h2>
                    <p class="text-gray-600 text-sm mt-2">Silakan login untuk mengelola platform</p>
                </div>

                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg mb-4 text-sm">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg
                               focus:outline-none focus:ring-2 focus:ring-secondary/50 focus:border-secondary
                               transition-all duration-200"
                            placeholder="masukkan email" required>
                    </div>

                    <div class="mb-6">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                        <input type="password" id="password" name="password"
                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg
                               focus:outline-none focus:ring-2 focus:ring-secondary/50 focus:border-secondary
                               transition-all duration-200"
                            placeholder="masukkan password" required>
                    </div>

                    <button type="submit"
                        class="w-full bg-secondary text-white py-2.5 px-4 rounded-lg font-semibold
                           hover:bg-goldDark hover:shadow-md
                           focus:outline-none focus:ring-2 focus:ring-secondary/50 focus:ring-offset-2
                           transition-all duration-300 ease-in-out">
                        Masuk
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
