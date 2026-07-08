<x-app-layout>
    <div class="py-12 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('status'))
                <div class="mb-6 px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl font-medium flex items-center shadow-sm">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ session('status') }}
                </div>
            @endif

            <div class="px-4 sm:px-0 mb-4">
                <a href="{{ route('recipes.show', $recipe->id) }}" class="inline-flex items-center text-slate-600 hover:text-slate-900 transition duration-300 group bg-white border border-slate-200 px-4 py-2 rounded-xl shadow-sm">
                    <svg class="w-4 h-4 mr-2 transform group-hover:-translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Batal
                </a>
            </div>

            <div class="bg-white rounded-xl border border-slate-200 p-6 md:p-8 shadow-sm mx-4 sm:mx-0">
                <h2 class="text-2xl font-black text-slate-900 mb-6">Edit Resep</h2>

                <form action="{{ route('recipes.update', $recipe->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="title" class="block text-sm font-medium text-slate-700 mb-2">Nama Resep</label>
                        <input type="text" name="title" id="title" value="{{ old('title', $recipe->title) }}" required class="w-full bg-stone-50 border border-slate-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl text-slate-900 py-3 px-4 shadow-sm">
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <div>
                        <label for="ingredients" class="block text-sm font-medium text-slate-700 mb-2">Bahan-Bahan</label>
                        <textarea name="ingredients" id="ingredients" rows="4" required class="w-full bg-stone-50 border border-slate-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl text-slate-900 placeholder-slate-400 resize-none py-3 px-4 shadow-sm">{{ old('ingredients', $recipe->ingredients) }}</textarea>
                        <x-input-error :messages="$errors->get('ingredients')" class="mt-2" />
                    </div>

                    <div>
                        <label for="instructions" class="block text-sm font-medium text-slate-700 mb-2">Langkah Memasak</label>
                        <textarea name="instructions" id="instructions" rows="8" required class="w-full bg-stone-50 border border-slate-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl text-slate-900 placeholder-slate-400 resize-none py-3 px-4 shadow-sm">{{ old('instructions', $recipe->instructions) }}</textarea>
                        <x-input-error :messages="$errors->get('instructions')" class="mt-2" />
                    </div>

                    <div>
                        <label for="notes" class="block text-sm font-medium text-slate-700 mb-2">Catatan Modifikasi</label>
                        <textarea name="notes" id="notes" rows="3" placeholder="Contoh: Tambah kecap manis 2 sendok makan biar makin mantap." class="w-full bg-stone-50 border border-slate-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl text-slate-900 placeholder-slate-400 resize-none py-3 px-4 shadow-sm text-sm">{{ old('notes', $recipe->notes) }}</textarea>
                        <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                    </div>

                    <div class="flex justify-end gap-4 pt-2">
                        <a href="{{ route('recipes.show', $recipe->id) }}" class="px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl transition duration-300">
                            Batal
                        </a>
                        <button type="submit" class="px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl transition duration-300 shadow-sm">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
