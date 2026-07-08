<x-app-layout>
    <div class="py-12 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if (session('status'))
                <div class="mb-6 px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl font-medium flex items-center shadow-sm">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ session('status') }}
                </div>
            @endif

            <div class="px-4 sm:px-0 mb-4">
                <a href="{{ route('recipes.index') }}" class="inline-flex items-center text-slate-600 hover:text-slate-900 transition duration-300 group bg-white border border-slate-200 px-4 py-2 rounded-xl shadow-sm">
                    <svg class="w-4 h-4 mr-2 transform group-hover:-translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Koleksi
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 px-4 sm:px-0">
                
                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm">
                        <div class="flex items-start justify-between gap-4">
                            <h2 class="text-2xl font-black text-slate-900 leading-tight mb-2">{{ $recipe->title }}</h2>
                            <a href="{{ route('recipes.edit', $recipe->id) }}" class="shrink-0 bg-stone-50 hover:bg-emerald-50 border border-slate-200 hover:border-emerald-300 text-slate-400 hover:text-emerald-600 p-2 rounded-xl transition duration-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </a>
                        </div>
                        <p class="text-xs text-slate-400 mb-6">Disimpan pada {{ $recipe->created_at->format('d M Y, H:i') }}</p>

                        <div class="border-t border-slate-200 pt-4">
                            <h4 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-3">Bahan Utama yang Digunakan:</h4>
                            <div class="bg-stone-50 p-4 rounded-xl border border-slate-200 text-sm text-slate-700 font-medium leading-relaxed italic">
                                {{ $recipe->ingredients }}
                            </div>
                        </div>

                        <div class="mt-8 pt-4 border-t border-slate-200">
                            <form action="{{ route('recipes.destroy', $recipe->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus resep ini secara permanen dari koleksi?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full text-red-600 hover:text-white text-sm font-bold bg-red-50 hover:bg-red-600 px-4 py-3 rounded-xl transition border border-red-200 hover:border-red-500 flex items-center justify-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    Hapus dari Koleksi
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-xl border border-slate-200 p-6 md:p-8 shadow-sm">
                        <h3 class="text-lg font-bold text-slate-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                            Panduan Langkah Memasak
                        </h3>
                        <ol class="list-decimal pl-5 space-y-2 text-left text-slate-700 text-sm sm:text-base leading-relaxed bg-stone-50 border border-slate-200 p-6 rounded-xl">
                            @php($steps = explode("\n", $recipe->instructions))
                            @foreach ($steps as $step)
                                @if (trim($step))
                                    <li class="pl-1">{{ trim($step) }}</li>
                                @endif
                            @endforeach
                        </ol>
                    </div>

                    <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm">
                        <h3 class="text-lg font-bold text-slate-900 mb-2 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            Catatan Modifikasi Anda
                        </h3>
                        <p class="text-xs text-slate-400 mb-4">Catatan ini hanya bisa diedit melalui halaman edit resep.</p>
                        <div class="bg-stone-50 border border-slate-200 rounded-xl p-4 text-sm text-slate-700 leading-relaxed" style="text-align: left;">
                            @if ($recipe->notes)
                                @php($notes = explode("\n", $recipe->notes))
                                @foreach ($notes as $line)
                                    {{ trim($line) }}<br>
                                @endforeach
                            @else
                                Belum ada catatan modifikasi.
                            @endif
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>
</x-app-layout>