<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecipeController extends Controller
{
    // READ: Menampilkan daftar resep yang disimpan oleh user saat ini
    public function index()
    {
        $recipes = Recipe::where('user_id', Auth::id())->latest()->get();
        return view('recipes.index', compact('recipes'));
    }

    // CREATE: Menyimpan resep baru ke dalam database lokal
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'ingredients' => 'required|string',
            'instructions' => 'required|string',
        ]);

        Recipe::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'ingredients' => $request->ingredients,
            'instructions' => $request->instructions,
        ]);

        return redirect()->route('recipes.index')->with('status', 'Resep berhasil disimpan ke dalam koleksi Anda!');
    }

    public function show(Recipe $recipe)
    {
        return view('recipes.show', compact('recipe'));
    }

    public function update(Request $request, Recipe $recipe)
    {
        $request->validate([
            'notes' => 'nullable|string',
        ]);

        $recipe->update([
            'notes' => $request->notes,
        ]);

        return redirect()->route('recipes.show', $recipe->id)->with('status', 'Catatan berhasil diperbarui!');
    }

    public function destroy(Recipe $recipe)
    {
        $recipe->delete();

        return redirect()->route('recipes.index')->with('status', 'Resep berhasil dihapus dari koleksi.');
    }
}