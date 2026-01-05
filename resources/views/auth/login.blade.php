@extends('layouts.guest')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <div class="mx-auto h-16 w-16 bg-navy-800 rounded-full flex items-center justify-center">
                <span class="text-white text-2xl font-bold">LM</span>
            </div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Masuk ke Akun Anda
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Atau
                <a href="{{ route('register') }}" class="font-medium text-navy-800 hover:text-blue-500">
                    daftar akun baru
                </a>
            </p>
        </div>
        
        <form class="mt-8 space-y-6" method="POST" action="{{ route('login') }}">
            @csrf
            
            <div class="rounded-md shadow-sm space-y-4">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input id="email" name="email" type="email" autocomplete="email" required 
                           class="input-field @error('email') border-red-500 @enderror" 
                           placeholder="nama@student.university.ac.id"
                           value="{{ old('email') }}">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input id="password" name="password" type="password" autocomplete="current-password" required 
                           class="input-field @error('password') border-red-500 @enderror" 
                           placeholder="••••••••">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember" name="remember" type="checkbox" 
                           class="h-4 w-4 text-navy-800 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="remember" class="ml-2 block text-sm text-gray-900">
                        Ingat saya
                    </label>
                </div>

                <div class="text-sm">
                    <a href="{{ route('password.request') }}" class="font-medium text-navy-800 hover:text-blue-500">
                        Lupa password?
                    </a>
                </div>
            </div>

            <div>
                <button type="submit" class="w-full btn-primary py-3 text-lg">
                    Masuk
                </button>
            </div>
            
            <div class="text-center">
                <p class="text-xs text-gray-500">
                    Dengan masuk, Anda menyetujui 
                    <a href="#" class="text-navy-800 hover:underline">Syarat & Ketentuan</a> kami
                </p>
            </div>
        </form>
        
        <!-- Demo Credentials -->
        <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
            <p class="text-sm font-semibold text-yellow-800 mb-2">Demo Login:</p>
            <ul class="text-xs text-yellow-700 space-y-1">
                <li><strong>Student:</strong> budi.santoso@student.university.ac.id / password</li>
                <li><strong>Admin:</strong> admin@university.ac.id / password</li>
            </ul>
        </div>
    </div>
</div>
@endsection
