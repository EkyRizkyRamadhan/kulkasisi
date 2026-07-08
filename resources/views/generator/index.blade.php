<x-app-layout>
    <div class="py-12 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <div class="mb-6 px-4 sm:px-0">
                <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">
                    Isi<span class="text-emerald-600">Kulkas</span> AI
                </h2>
                <p class="text-slate-500 mt-2">Ubah bahan makanan yang tersisa menjadi ide resep masakan matang yang lezat.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 px-4 sm:px-0">
                <div class="w-full lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 sticky top-24">
                        <h3 class="text-xl font-bold text-slate-900 mb-4 flex items-center">
                            <svg class="w-6 h-6 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                            Bahan Tersedia
                        </h3>

                        @if(session('error'))
                            <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-xl text-red-700 text-sm">
                                {{ session('error') }}
                            </div>
                        @endif

                        <form action="{{ route('generator.generate') }}" method="POST" class="space-y-4" x-data="{ loading: false }" @submit="loading = true">
                            @csrf
                            <div>
                                <label for="ingredients" class="block text-sm font-medium text-slate-700 mb-2">Masukkan semua bahan (pisahkan dengan koma)</label>
                                <textarea name="ingredients" id="ingredients" rows="4" placeholder="Contoh: Telur, Nasi, Sosis, Bawang Merah, Cabai" class="w-full bg-stone-50 border border-slate-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl text-slate-900 placeholder-slate-400 resize-none py-3 px-4 shadow-sm" required x-bind:readonly="loading">{{ $ingredients ?? old('ingredients') }}</textarea>
                                <x-input-error :messages="$errors->get('ingredients')" class="mt-2" />
                            </div>

                            <button type="submit" :disabled="loading" class="w-full bg-emerald-600 hover:bg-emerald-700 disabled:bg-emerald-400 disabled:cursor-not-allowed disabled:hover:bg-emerald-400 disabled:hover:-translate-y-0 text-white font-bold py-3.5 rounded-xl transition duration-300 shadow-sm flex items-center justify-center transform hover:-translate-y-0.5">
                                <svg x-cloak x-show="loading" class="w-5 h-5 mr-2 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                                <span x-show="!loading">Generate Ide Resep</span>
                                <span x-cloak x-show="loading">Memproses...</span>
                            </button>
                        </form>
                    </div>
                </div>

                <div class="w-full lg:col-span-2">
                    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 md:p-8 min-h-[300px] flex flex-col justify-between">
                        <div>
                            <h3 class="text-xl font-bold text-slate-900 mb-6 border-b border-slate-200 pb-4">Rekomendasi Resep Kreatif</h3>
                            
                            @if(isset($recipes))
                                <div class="space-y-6">
                                    @foreach($recipes as $index => $recipe)
                                        <div class="bg-stone-50 border border-slate-200 rounded-xl p-6">
                                            <div class="flex items-start justify-between gap-4 mb-4">
                                                <h4 class="text-lg font-bold text-emerald-700">{{ $loop->iteration }}. {{ $recipe['name'] }}</h4>
                                            </div>

                                            @if(!empty($recipe['additional_ingredients']))
                                                <div class="mb-4">
                                                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Bahan Tambahan:</p>
                                                    <ul class="list-disc list-inside text-sm text-slate-700 space-y-1">
                                                        @foreach($recipe['additional_ingredients'] as $item)
                                                            <li>{{ $item }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif

                                            <div class="mb-4">
                                                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Langkah Memasak:</p>
                                                <ol class="list-decimal list-inside text-sm text-slate-700 space-y-1.5">
                                                    @foreach($recipe['steps'] as $step)
                                                        <li>{{ $step }}</li>
                                                    @endforeach
                                                </ol>
                                            </div>

                                            <div class="mt-4 pt-4 border-t border-slate-200">
                                                <form action="{{ route('recipes.store') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="title" value="{{ $recipe['name'] }}">
                                                    <input type="hidden" name="ingredients" value="{{ $ingredients }}{{ !empty($recipe['additional_ingredients']) ? ', ' . implode(', ', $recipe['additional_ingredients']) : '' }}">
                                                    <input type="hidden" name="instructions" value="{{ implode("\n", $recipe['steps']) }}">
                                                    <button type="submit" class="w-full px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl transition duration-300 shadow-sm flex items-center justify-center text-sm">
                                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>
                                                        Simpan Resep Ini
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-16 text-slate-400">
                                    <svg class="w-16 h-16 mx-auto mb-4 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg>
                                    <p class="font-medium text-slate-500">Belum ada bahan yang di-generate.</p>
                                    <p class="text-xs text-slate-400 mt-1">Masukkan sisa bahan kulkasmu di kolom sebelah kiri.</p>
                                </div>
                            @endif
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>