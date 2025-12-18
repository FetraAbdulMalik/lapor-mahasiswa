@extends('layouts.guest')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm: px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <div class="mx-auto h-16 w-16 bg-primary-600 rounded-full flex items-center justify-center">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
            </div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Lupa Password? 
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Masukkan email Anda dan kami akan mengirimkan link untuk reset password
            </p>
        </div>
        
        @if(session('status'))
            <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded">
                <p class="text-green-700">{{ session('status') }}</p>
            </div>
        @endif
        
        <form class="mt-8 space-y-6" method="POST" action="{{ route('password.email') }}">
            @csrf
            
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input id="email" name="email" type="email" required 
                       class="input-field @error('email') border-red-500 @enderror" 
                       placeholder="nama@student.university.ac.id"
                       value="{{ old('email') }}">
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <button type="submit" class="w-full btn-primary py-3">
                    Kirim Link Reset Password
                </button>
            </div>
            
            <div class="text-center">
                <a href="{{ route('login') }}" class="text-sm font-medium text-primary-600 hover:text-primary-500">
                    ← Kembali ke Login
                </a>
            </div>
        </form>
    </div>
</div>
@endsection