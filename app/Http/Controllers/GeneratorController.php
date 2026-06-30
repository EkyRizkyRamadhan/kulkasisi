<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GeneratorController extends Controller
{
    // Menampilkan halaman form input bahan
    public function index()
    {
        return view('generator.index');
    }

    // Memproses data ke Gemini API
    public function generate(Request $request)
    {
        // Validasi input dari user
        $request->validate([
            'ingredients' => 'required|string'
        ]);

        $ingredients = $request->ingredients;
        $apiKey = env('GEMINI_API_KEY');

        // Prompt (Perintah) spesifik untuk AI
        $prompt = "Saya memiliki bahan-bahan masakan berikut: " . $ingredients . ". 
        Tolong berikan 3 ide resep masakan kreatif yang bisa saya buat dengan bahan-bahan tersebut. 
        Format jawaban harus rapi dengan memisahkan Nama Resep, Bahan Tambahan (jika ada), dan Langkah-langkah Memasak.";

        // Hit API Gemini (Model gemini-1.5-flash)
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key={$apiKey}", [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt]
                    ]
                ]
            ]
        ]);

        if ($response->successful()) {
            // Ambil teks jawaban dari struktur JSON Gemini
            $result = $response->json()['candidates'][0]['content']['parts'][0]['text'];
            
            // Kembalikan ke view dengan membawa data hasil AI
            return view('generator.index', [
                'ingredients' => $ingredients,
                'result' => $result
            ]);
        }

        return back()->with('error', 'Gagal menghubungi AI. Coba lagi nanti.');
    }
}