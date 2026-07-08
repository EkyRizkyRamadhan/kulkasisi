<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IsiKulkas AI - Generator Resep Pintar</title>

    <!-- Memanggil Tailwind CSS -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
</head>
<body class="antialiased bg-stone-50 text-slate-900 min-h-screen flex flex-col items-center justify-center relative font-sans">
    
    <div class="text-center px-6 relative z-10 w-full max-w-4xl mx-auto flex flex-col items-center">
        <!-- Logo Container -->
        <div class="w-24 h-24 bg-white rounded-3xl border border-slate-200 shadow-xl flex items-center justify-center mb-8">
            <svg class="w-12 h-12 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
            </svg>
        </div>

        <!-- Judul -->
        <h1 class="text-5xl md:text-7xl font-black mb-6 tracking-tight text-slate-900">
            Isi<span class="text-emerald-600">Kulkas</span> AI
        </h1>
        
        <!-- Deskripsi -->
        <p class="text-slate-600 text-lg md:text-xl mb-12 max-w-2xl mx-auto leading-relaxed">
            Punya bahan makanan sisa di dapur tapi bingung mau masak apa? <br class="hidden md:block">
            Biar kecerdasan buatan (AI) yang meracik ide resep kreatif untukmu!
        </p>

        <!-- Tombol -->
        @if (Route::has('login'))
            <div class="flex flex-col sm:flex-row justify-center items-center gap-4 w-full">
                @auth
                    <a href="{{ url('/dashboard') }}" class="w-full sm:w-auto px-8 py-4 bg-emerald-600 hover:bg-emerald-700 text-white text-lg font-bold rounded-2xl transition duration-300 shadow-lg shadow-emerald-600/20 flex items-center justify-center group">
                        Masuk ke Dashboard 
                        <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="w-full sm:w-auto px-10 py-4 bg-emerald-600 hover:bg-emerald-700 text-white text-lg font-bold rounded-2xl transition duration-300 shadow-lg shadow-emerald-600/20">
                        Log in
                    </a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="w-full sm:w-auto px-10 py-4 bg-white hover:bg-slate-100 border border-slate-200 text-slate-900 text-lg font-bold rounded-2xl transition duration-300">
                            Daftar Akun
                        </a>
                    @endif
                @endauth
            </div>
        @endif
    </div>

    <!-- Footer -->
    <div class="absolute bottom-6 w-full text-center text-slate-500 text-sm font-medium">
        &copy; {{ date('Y') }} IsiKulkas AI. Powered by Laravel & Gemini.
    </div>
</body>
</html>