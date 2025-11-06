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
<div class="min-h-screen bg-grayLight flex items-center justify-center px-4 py-8 mb-12">
    <div class="max-w-md w-full">
        <!-- Login Card -->
        <div class="bg-white rounded-xl shadow-md p-6">
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

                <!-- Email Input -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-secondary focus:border-secondary outline-none transition-all"
                        placeholder="masukkan email" required>
                </div>

                <!-- Password Input -->
                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <input type="password" id="password" name="password"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-secondary focus:border-secondary outline-none transition-all"
                        placeholder="masukkan password" required>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full bg-secondary text-white py-3 px-4 rounded-lg font-semibold hover:bg-goldDark transition-colors focus:ring-2 focus:ring-secondary focus:ring-offset-2">
                    Masuk
                </button>
            </form>
            </div>
    </div>
</div>
@endsection
