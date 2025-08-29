<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Response;

class ImageProxyController extends Controller
{
    public function proxy(Request $request, $filename)
    {
        try {
            // URL gambar eksternal
            $imageUrl = 'https://kemenagnganjuk.id/asset/foto_berita/' . $filename;

            // Ambil gambar dari server eksternal
            $response = Http::timeout(10)
                ->withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                    'Referer' => 'https://kemenagnganjuk.id/',
                ])
                ->get($imageUrl);

            if ($response->successful()) {
                $contentType = $response->header('content-type') ?? 'image/jpeg';

                return response($response->body())
                    ->header('Content-Type', $contentType)
                    ->header('Cache-Control', 'public, max-age=86400') // Cache 24 jam
                    ->header('Access-Control-Allow-Origin', '*');
            }

            // Jika gagal, kembalikan placeholder SVG
            return response()->file(public_path('images/placeholder.svg'), [
                'Content-Type' => 'image/svg+xml'
            ]);

        } catch (\Exception $e) {
            // Log error jika diperlukan
            Log::error('Image proxy error: ' . $e->getMessage());

            // Kembalikan placeholder SVG
            return response()->file(public_path('images/placeholder.svg'), [
                'Content-Type' => 'image/svg+xml'
            ]);
        }
    }
}
