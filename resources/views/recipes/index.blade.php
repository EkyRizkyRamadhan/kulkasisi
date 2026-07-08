<x-app-layout>
    <div class="py-12 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if (session('status'))
                <div class="mb-6 px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl font-medium flex items-center shadow-sm">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ session('status') }}
                </div>
            @endif

            <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-8 px-4 sm:px-0 gap-4">
                <div>
                    <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Koleksi Resepku</h2>
                    <p class="text-slate-500 mt-2">Daftar ide masakan kreatif yang telah kamu simpan dari AI.</p>
                </div>
                <a href="{{ route('generator.index') }}" class="inline-flex items-center justify-center bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-5 py-3 rounded-xl transition duration-300 shadow-sm w-fit">
                    + Cari Ide Resep Baru
                </a>
            </div>

            <div class="px-4 sm:px-0">
                <form method="GET" action="{{ route('recipes.index') }}" class="mb-6" x-data="{ search: '{{ $search ?? '' }}' }">
                    <div class="relative">
                        <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <input type="text" name="search" x-model="search" placeholder="Cari resep berdasarkan nama atau bahan..." class="w-full bg-stone-50 border border-slate-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl text-slate-900 placeholder-slate-400 py-3 pl-12 pr-24 shadow-sm">
                        <div class="absolute right-2 top-1/2 -translate-y-1/2 flex gap-1">
                            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold px-4 py-1.5 rounded-lg transition">Cari</button>
                            @if(request('search'))
                                <a href="{{ route('recipes.index') }}" class="bg-slate-200 hover:bg-slate-300 text-slate-700 text-sm font-bold px-4 py-1.5 rounded-lg transition">Reset</a>
                            @endif
                        </div>
                    </div>
                </form>

                @if($search && $recipes->count() === 0)
                    <div class="text-center py-12 text-slate-500">
                        <p class="font-medium">Tidak ditemukan resep dengan kata kunci "{{ $search }}"</p>
                        <a href="{{ route('recipes.index') }}" class="text-emerald-600 hover:text-emerald-700 text-sm mt-2 inline-block">Reset pencarian</a>
                    </div>
                @endif

                @if($recipes->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($recipes as $recipe)
                            <div class="bg-white rounded-xl p-6 border border-slate-200 flex flex-col justify-between hover:border-emerald-300 transition duration-300 group shadow-sm">
                                <div>
                                    <h4 class="font-extrabold text-slate-900 text-xl mb-2 group-hover:text-emerald-600 transition">
                                        {{ $recipe->title }}
                                    </h4>
                                    <span class="text-xs text-slate-400">Disimpan pada {{ $recipe->created_at->format('d M Y, H:i') }}</span>
                                    
                                    <div class="mt-4">
                                        <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Bahan Utama:</p>
                                        <p class="text-sm text-slate-700 line-clamp-2 italic bg-stone-50 px-3 py-2 rounded-xl border border-slate-200">
                                            {{ $recipe->ingredients }}
                                        </p>
                                    </div>
                                </div>
                                
                                <div class="mt-6 pt-4 border-t border-slate-200 flex items-center justify-between">
                                    <span class="text-xs text-emerald-700 bg-emerald-50 border border-emerald-200 px-3 py-1 rounded-md font-medium">
                                        Tersimpan
                                    </span>
                                    
                                    <a href="{{ route('recipes.show', $recipe->id) }}" class="text-sm font-bold text-emerald-600 hover:text-emerald-700 transition flex items-center group-hover:translate-x-0.5 duration-200">
                                        Lihat Detail Resep &rarr;
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-white rounded-xl border border-slate-200 text-center py-20 shadow-sm">
                        <div class="w-20 h-20 bg-stone-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-slate-200">
                            <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                            </svg>
                        </div>
                        <h4 class="text-xl font-bold text-slate-900 mb-2">Koleksi Masih Kosong</h4>
                        <p class="text-slate-500 text-sm max-w-md mx-auto px-4">
                            Kamu belum memiliki resep yang disimpan. Coba masukkan sisa bahan makananmu di generator AI untuk mulai mengoleksi resep masakan.
                        </p>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>