<x-app-layout>
    <div class="py-12 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8 px-4 sm:px-6 lg:px-8">

            <div>
                <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Dashboard</h2>
                <p class="text-slate-500 mt-2">Selamat datang, {{ Auth::user()->name }}!</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-emerald-100 rounded-2xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                        </div>
                        <div>
                            <p class="text-3xl font-black text-slate-900">{{ $totalRecipes }}</p>
                            <p class="text-sm text-slate-500">Resep Andalan</p>
                        </div>
                    </div>
                </div>

                <a href="{{ route('generator.index') }}" class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm hover:border-emerald-300 transition duration-300 group">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-emerald-100 rounded-2xl flex items-center justify-center group-hover:bg-emerald-200 transition">
                            <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        </div>
                        <div>
                            <p class="font-bold text-slate-900 group-hover:text-emerald-600 transition">Generate Resep Baru</p>
                            <p class="text-sm text-slate-500">Buat ide masakan dari bahan sisa</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('recipes.index') }}" class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm hover:border-emerald-300 transition duration-300 group">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-sky-100 rounded-2xl flex items-center justify-center group-hover:bg-sky-200 transition">
                            <svg class="w-6 h-6 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>
                        </div>
                        <div>
                            <p class="font-bold text-slate-900 group-hover:text-emerald-600 transition">Lihat Koleksi</p>
                            <p class="text-sm text-slate-500">{{ $totalRecipes > 0 ? "Kamu punya $totalRecipes resep tersimpan" : 'Belum ada resep tersimpan' }}</p>
                        </div>
                    </div>
                </a>
            </div>

            @if($recipes->count() > 0)
                <div>
                    <h3 class="text-xl font-bold text-slate-900 mb-4">Resep Terbaru</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($recipes as $recipe)
                            <a href="{{ route('recipes.show', $recipe->id) }}" class="bg-white rounded-xl border border-slate-200 p-6 hover:border-emerald-300 transition duration-300 group shadow-sm">
                                <h4 class="font-extrabold text-slate-900 text-lg mb-1 group-hover:text-emerald-600 transition">{{ $recipe->title }}</h4>
                                <p class="text-xs text-slate-400 mb-3">{{ $recipe->created_at->format('d M Y, H:i') }}</p>
                                <p class="text-sm text-slate-600 line-clamp-2 italic">{{ $recipe->ingredients }}</p>
                            </a>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="bg-white rounded-xl border border-slate-200 text-center py-16 shadow-sm">
                    <div class="w-16 h-16 bg-stone-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-slate-200">
                        <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg>
                    </div>
                    <h4 class="text-lg font-bold text-slate-900 mb-2">Belum Ada Resep</h4>
                    <p class="text-slate-500 text-sm">Mulai dengan generate ide resep dari bahan sisa di kulkasmu!</p>
                    <a href="{{ route('generator.index') }}" class="inline-block mt-6 bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-6 py-3 rounded-xl transition duration-300 shadow-sm">
                        Generate Resep Sekarang
                    </a>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
