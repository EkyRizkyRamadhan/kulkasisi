<x-app-layout>
    <div class="py-12 bg-gray-950 min-h-screen text-gray-100">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('status'))
                <div class="mb-6 px-4 py-3 bg-green-900/40 border border-green-800 text-green-400 rounded-xl font-medium flex items-center shadow-sm">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ session('status') }}
                </div>
            @endif

            <div class="px-4 sm:px-0 mb-4">
                <a href="{{ route('recipes.show', $recipe->id) }}" class="inline-flex items-center text-gray-400 hover:text-white transition duration-300 group bg-gray-900 border border-gray-800 px-4 py-2 rounded-xl">
                    <svg class="w-4 h-4 mr-2 transform group-hover:-translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Batal
                </a>
            </div>

            <div class="bg-gray-900 rounded-3xl border border-gray-800 p-6 md:p-8 shadow-xl mx-4 sm:mx-0">
                <h2 class="text-2xl font-black text-white mb-6">Edit Resep</h2>

                <form action="{{ route('recipes.update', $recipe->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-400 mb-2">Nama Resep</label>
                        <input type="text" name="title" id="title" value="{{ old('title', $recipe->title) }}" required class="w-full bg-gray-950 border border-gray-700 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl text-white py-3 px-4 shadow-sm">
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <div>
                        <label for="ingredients" class="block text-sm font-medium text-gray-400 mb-2">Bahan-Bahan</label>
                        <textarea name="ingredients" id="ingredients" rows="4" required class="w-full bg-gray-950 border border-gray-700 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl text-white placeholder-gray-600 resize-none py-3 px-4 shadow-inner">{{ old('ingredients', $recipe->ingredients) }}</textarea>
                        <x-input-error :messages="$errors->get('ingredients')" class="mt-2" />
                    </div>

                    <div>
                        <label for="instructions" class="block text-sm font-medium text-gray-400 mb-2">Langkah Memasak</label>
                        <textarea name="instructions" id="instructions" rows="8" required class="w-full bg-gray-950 border border-gray-700 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl text-white placeholder-gray-600 resize-none py-3 px-4 shadow-inner">{{ old('instructions', $recipe->instructions) }}</textarea>
                        <x-input-error :messages="$errors->get('instructions')" class="mt-2" />
                    </div>

                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-400 mb-2">Catatan Modifikasi</label>
                        <textarea name="notes" id="notes" rows="3" placeholder="Contoh: Tambah kecap manis 2 sendok makan biar makin mantap." class="w-full bg-gray-950 border border-gray-700 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl text-white placeholder-gray-600 resize-none py-3 px-4 shadow-inner text-sm">{{ old('notes', $recipe->notes) }}</textarea>
                        <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                    </div>

                    <div class="flex justify-end gap-4 pt-2">
                        <a href="{{ route('recipes.show', $recipe->id) }}" class="px-6 py-3 bg-gray-800 hover:bg-gray-700 text-white font-bold rounded-xl transition duration-300">
                            Batal
                        </a>
                        <button type="submit" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-500 text-white font-bold rounded-xl transition duration-300 shadow-md">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
