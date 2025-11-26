<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-screen flex flex-col justify-center items-center bg-gradient-to-b from-green-400 to-green-100 font-poppins">

    <div class="flex flex-col items-center mb-4">
        <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" class="w-20 mb-3">
        <h1 class="text-3xl font-bold text-green-800">Welcome</h1>
    </div>

    <form method="POST" action="{{ route('login.process') }}" class="w-80 bg-transparent">
        
        @csrf

        {{-- Error message --}}
        @if (session('error'))
            <p class="text-red-600 text-center text-sm mb-3">
                {{ session('error') }}
            </p>
        @endif

        {{-- Email --}}
        <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
        <input 
            type="email" 
            name="email"
            value="{{ old('email', request()->cookie('remember_email')) }}"
            class="w-full p-2 bg-white rounded-2xl border border-green-300 mb-4 focus:ring focus:ring-green-200"
            placeholder="Masukkan email anda"
            required
        >

        {{-- Password --}}
        <label class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
        <input 
            type="password" 
            name="password"
            class="w-full p-2 bg-white rounded-2xl border border-green-300 mb-2 focus:ring focus:ring-green-200"
            placeholder="********" 
            required
        >

        {{-- Remember Me --}}
        <div class="flex items-center gap-2 mb-4">
            <input 
                type="checkbox" 
                name="remember" 
                class="w-4 h-4"
                {{ request()->cookie('remember_email') ? 'checked' : '' }}
            >
            <label class="text-sm text-gray-700">Ingat saya</label>
        </div>

        {{-- Submit --}}
        <button 
            type="submit"
            class="w-full bg-green-600 text-white py-2 rounded-2xl hover:bg-green-700 transition"
        >
            Masuk
        </button>
    </form>

    <footer class="absolute bottom-5 text-sm text-gray-700">
        © 2025 Intern. All rights reserved.
    </footer>

</body>
</html>
