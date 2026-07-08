<x-app-layout>
    <div class="py-12 bg-gray-950 min-h-screen text-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if (session('status'))
                <div class="mb-6 px-4 py-3 bg-green-900/40 border border-green-800 text-green-400 rounded-xl font-medium flex items-center shadow-sm">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ session('status') }}
                </div>
            @endif

            <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-8 px-4 sm:px-0 gap-4">
                <div>
                    <h2 class="text-3xl font-extrabold text-white tracking-tight">Koleksi Resepku</h2>
                    <p class="text-gray-400 mt-2">Daftar ide masakan kreatif yang telah kamu simpan dari AI.</p>
                </div>
                <a href="{{ route('generator.index') }}" class="inline-flex items-center justify-center bg-indigo-600 hover:bg-indigo-500 text-white font-bold px-5 py-3 rounded-xl transition duration-300 shadow-md shadow-indigo-600/20 w-fit">
                    + Cari Ide Resep Baru
                </a>
            </div>

            <div class="px-4 sm:px-0">
                <form method="GET" action="{{ route('recipes.index') }}" class="mb-6" x-data="{ search: '{{ $search ?? '' }}' }">
                    <div class="relative">
                        <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <input type="text" name="search" x-model="search" placeholder="Cari resep berdasarkan nama atau bahan..." class="w-full bg-gray-900 border border-gray-700 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl text-white placeholder-gray-500 py-3 pl-12 pr-24 shadow-inner">
                        <div class="absolute right-2 top-1/2 -translate-y-1/2 flex gap-1">
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-bold px-4 py-1.5 rounded-lg transition">Cari</button>
                            @if(request('search'))
                                <a href="{{ route('recipes.index') }}" class="bg-gray-700 hover:bg-gray-600 text-gray-300 text-sm font-bold px-4 py-1.5 rounded-lg transition">Reset</a>
                            @endif
                        </div>
                    </div>
                </form>

                @if($search && $recipes->count() === 0)
                    <div class="text-center py-12 text-gray-500">
                        <p class="font-medium">Tidak ditemukan resep dengan kata kunci "{{ $search }}"</p>
                        <a href="{{ route('recipes.index') }}" class="text-indigo-400 hover:text-indigo-300 text-sm mt-2 inline-block">Reset pencarian</a>
                    </div>
                @endif

                @if($recipes->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($recipes as $recipe)
                            <div class="bg-gray-900 rounded-3xl p-6 border border-gray-800 flex flex-col justify-between hover:border-gray-700 transition duration-300 group shadow-lg">
                                <div>
                                    <h4 class="font-extrabold text-white text-xl mb-2 group-hover:text-indigo-400 transition">
                                        {{ $recipe->title }}
                                    </h4>
                                    <span class="text-xs text-gray-500">Disimpan pada {{ $recipe->created_at->format('d M Y, H:i') }}</span>
                                    
                                    <div class="mt-4">
                                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Bahan Utama:</p>
                                        <p class="text-sm text-gray-300 line-clamp-2 italic bg-gray-950 px-3 py-2 rounded-xl border border-gray-800">
                                            {{ $recipe->ingredients }}
                                        </p>
                                    </div>
                                </div>
                                
                                <div class="mt-6 pt-4 border-t border-gray-800 flex items-center justify-between">
                                    <span class="text-xs text-emerald-400 bg-emerald-900/20 border border-emerald-800/40 px-3 py-1 rounded-md font-medium">
                                        Tersimpan
                                    </span>
                                    
                                    <a href="{{ route('recipes.show', $recipe->id) }}" class="text-sm font-bold text-indigo-400 hover:text-indigo-300 transition flex items-center group-hover:translate-x-0.5 duration-200">
                                        Lihat Detail Resep &rarr;
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-gray-900 rounded-3xl border border-gray-800 text-center py-20">
                        <div class="w-20 h-20 bg-gray-950 rounded-full flex items-center justify-center mx-auto mb-4 border border-gray-800 shadow-inner">
                            <svg class="w-10 h-10 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                            </svg>
                        </div>
                        <h4 class="text-xl font-bold text-white mb-2">Koleksi Masih Kosong</h4>
                        <p class="text-gray-400 text-sm max-w-md mx-auto px-4">
                            Kamu belum memiliki resep yang disimpan. Coba masukkan sisa bahan makananmu di generator AI untuk mulai mengoleksi resep masakan.
                        </p>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>