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
}