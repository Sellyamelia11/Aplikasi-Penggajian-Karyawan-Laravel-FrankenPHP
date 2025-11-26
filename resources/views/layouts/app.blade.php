<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Z-Corporate</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex flex-col bg-gradient-to-b from-green-400 to-green-100 font-poppins">
    <header class="bg-white shadow-md flex justify-between items-center px-1 py-1 border-b border-gray-200">
        <h1 class="text-2xl font-bold text-gray-800 px-12">
            <span class=" text-gray-700">Z.</span><span class="text-green-600">Corporate</span>
        </h1>
        <div class="flex items-center gap-4 mr-2">
            <img src="../assets/images/logo.png" alt="Logo" class="w-45 h-20 px-10 mr-0 ">
            <a href="{{ route('logout') }}"
            class="flex items-center gap-2 text-black px-4 py-2 mt-5 rounded-lg text-sm font-semibold"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6A2.25 2.25 0 005.25 5.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                </svg>
                keluar
            </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
            @csrf
        </form>
        </div>
    </header>

    <main class="flex-1 px-4 md:px-10 py-10">
        <div class="w-full max-w-7xl mx-auto">
            @yield('content')
        </div>
    </main>

    <footer class="text-center text-gray-700 text-sm py-4">
    © 2025 Intern. All rights reserved.
    </footer>
</body>
</html>