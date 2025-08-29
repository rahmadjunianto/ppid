<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class BeritaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try {
            $query = Berita::published()->with('kategori');

            // Filter by category
            if ($request->filled('kategori')) {
                $query->where('id_kategori', $request->kategori);
            }

            // Filter by author/user
            if ($request->filled('user')) {
                $query->where('username', 'LIKE', "%{$request->user}%");
            }

            // Search functionality
            if ($request->filled('q')) {
                $searchTerm = $request->q;
                $query->where(function($q) use ($searchTerm) {
                    $q->where('judul', 'LIKE', "%{$searchTerm}%")
                      ->orWhere('isi_berita', 'LIKE', "%{$searchTerm}%");
                });
            }

            $berita = $query->orderBy('tanggal', 'desc')
                           ->orderBy('jam', 'desc')
                           ->paginate(12);

            // Append all query parameters to pagination links
            $berita->appends($request->only(['kategori', 'user', 'q']));

            // Get categories for filter dropdown
            $categories = Kategori::aktif()->orderBy('nama_kategori')->get();

            // Get unique authors for filter dropdown
            $authors = Berita::published()
                            ->whereNotNull('username')
                            ->where('username', '!=', '')
                            ->distinct()
                            ->pluck('username')
                            ->sort()
                            ->values();

            // Check if request wants JSON response
            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Data berita berhasil diambil',
                    'data' => $berita,
                    'filters' => [
                        'categories' => $categories,
                        'authors' => $authors
                    ]
                ], 200);
            }

            return view('berita.index', compact('berita', 'categories', 'authors'));

        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Gagal mengambil data berita: ' . $e->getMessage(),
                    'data' => null
                ], 500);
            }

            return view('berita.index')->with('error', 'Gagal mengambil data berita: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function show($slug, Request $request)
    {
        try {
            $berita = Berita::published()
                           ->with('kategori')
                           ->where('judul_seo', $slug)
                           ->firstOrFail();

            // Increment view counter only for HTML requests (not API)
            if (!$request->wantsJson()) {
                $berita->increment('dibaca');
            }

            // Check if request wants JSON response
            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Data berita berhasil diambil',
                    'data' => $berita
                ], 200);
            }

            return view('berita.show', compact('berita'));

        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Berita tidak ditemukan: ' . $e->getMessage(),
                    'data' => null
                ], 404);
            }

            abort(404, 'Berita tidak ditemukan');
        }
    }

    /**
     * Get latest news
     *
     * @param  int  $limit
     * @return \Illuminate\Http\JsonResponse
     */
    public function latest($limit = 5): JsonResponse
    {
        try {
            $berita = Berita::published()
                           ->orderBy('tanggal', 'desc')
                           ->orderBy('jam', 'desc')
                           ->limit($limit)
                           ->get();

            return response()->json([
                'status' => 'success',
                'message' => 'Data berita terbaru berhasil diambil',
                'data' => $berita
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengambil data berita terbaru: ' . $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    /**
     * Search news by title
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        // Redirect to index with search parameter
        return redirect()->route('berita.index', $request->only(['q', 'kategori', 'user']));
    }
}
