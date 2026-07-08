<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeneratorController extends Controller
{
    public function index()
    {
        return view('generator.index');
    }

    public function generate(Request $request)
    {
        $request->validate([
            'ingredients' => 'required|string'
        ]);

        $ingredients = $request->ingredients;
        $apiKey = config('services.groq.api_key');
        $model = config('services.groq.model');

        if (!$apiKey) {
            Log::error('GROQ_API_KEY tidak ditemukan di konfigurasi');
            return back()->with('error', 'API Key Groq belum diisi. Isi GROQ_API_KEY di file .env');
        }

        $prompt = "Saya memiliki bahan-bahan masakan berikut: " . $ingredients . ". 
        Berikan 3 ide resep masakan kreatif yang bisa saya buat dengan bahan-bahan tersebut.
        Jawab dalam format JSON dengan struktur berikut, dan jangan sertakan teks lain di luar JSON:
        {
          \"recipes\": [
            {
              \"name\": \"Nama Resep\",
              \"additional_ingredients\": [\"Bahan tambahan 1\", \"Bahan tambahan 2\"],
              \"steps\": [\"Langkah 1\", \"Langkah 2\", \"Langkah 3\"]
            }
          ]
        }";

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
            ])->timeout(120)->post('https://api.groq.com/openai/v1/chat/completions', [
                'model' => $model,
                'messages' => [
                    ['role' => 'user', 'content' => $prompt],
                ],
                'temperature' => 0.7,
                'max_tokens' => 2048,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $content = $data['choices'][0]['message']['content'] ?? null;

                if ($content) {
                    $recipes = json_decode($content, true);

                    if (json_last_error() !== JSON_ERROR_NONE || !isset($recipes['recipes'])) {
                        Log::warning('Groq tidak mengembalikan JSON valid', ['content' => $content]);
                        return back()->with('error', 'AI tidak mengembalikan format yang valid. Coba lagi.');
                    }

                    return view('generator.index', [
                        'ingredients' => $ingredients,
                        'recipes' => $recipes['recipes'],
                    ]);
                }

                Log::warning('Groq tidak mengembalikan teks', ['response' => $data]);
                return back()->with('error', 'AI tidak mengembalikan hasil. Coba dengan bahan yang berbeda.');
            }

            Log::error('Groq API gagal', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            return back()->with('error', 'Gagal menghubungi Groq (HTTP ' . $response->status() . '). Coba lagi nanti.');
        } catch (\Exception $e) {
            Log::error('Exception saat memanggil Groq API: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan koneksi ke Groq. Coba lagi nanti.');
        }
    }
}