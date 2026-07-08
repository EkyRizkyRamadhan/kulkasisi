<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecipeController extends Controller
{
    // READ: Menampilkan daftar resep yang disimpan oleh user saat ini
    public function index(Request $request)
    {
        $search = $request->query('search');

        $recipes = Recipe::where('user_id', Auth::id())
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('ingredients', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->get();

        return view('recipes.index', compact('recipes', 'search'));
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
        $this->authorize('view', $recipe);

        return view('recipes.show', compact('recipe'));
    }

    public function edit(Recipe $recipe)
    {
        $this->authorize('update', $recipe);

        return view('recipes.edit', compact('recipe'));
    }

    public function update(Request $request, Recipe $recipe)
    {
        $this->authorize('update', $recipe);

        $request->validate([
            'title' => 'required|string|max:255',
            'ingredients' => 'required|string',
            'instructions' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $recipe->update([
            'title' => $request->title,
            'ingredients' => $request->ingredients,
            'instructions' => $request->instructions,
            'notes' => $request->notes,
        ]);

        return redirect()->route('recipes.show', $recipe->id)->with('status', 'Resep berhasil diperbarui!');
    }

    public function destroy(Recipe $recipe)
    {
        $this->authorize('delete', $recipe);

        $recipe->delete();

        return redirect()->route('recipes.index')->with('status', 'Resep berhasil dihapus dari koleksi.');
    }
}