<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Configuration;
use App\Models\JenisPolling;
use App\Models\Polling;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class JenisPollingController extends Controller
{
    /**
     * Get all polling categories
     */
    public function index(Request $request)
    {
        try {
            $categories = JenisPolling::select('id', 'judul')->get();
            $config = Configuration::select('polling_activation')->first();
            $pollingActive = $config ? (bool) $config->polling_activation : true;

            $isPraktikanRequest = (bool) $request->user('praktikan');
            $submittedCategories = [];

            if ($isPraktikanRequest) {
                if (! $pollingActive) {
                    return response()->json([
                        'status' => 'success',
                        'categories' => [],
                        'submitted_categories' => [],
                        'polling_active' => false,
                        'message' => 'Polling sedang tidak aktif.',
                    ], 200);
                }
                
                $praktikan = $request->user('praktikan');
                $submittedCategories = Polling::where('praktikan_id', $praktikan->id)
                    ->pluck('polling_id')
                    ->unique()
                    ->values()
                    ->map(fn($id) => (string) $id)
                    ->toArray();
            }

            return response()->json([
                'status' => 'success',
                'categories' => $categories,
                'submitted_categories' => $submittedCategories,
                'polling_active' => $pollingActive,
                'message' => 'Polling categories retrieved successfully.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve polling categories.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Store a newly created polling category.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255|unique:jenis_pollings,judul',
        ]);

        try {
            $category = JenisPolling::create([
                'judul' => $validated['judul'],
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Jenis polling berhasil dibuat.',
                'category' => [
                    'id' => $category->id,
                    'judul' => $category->judul,
                ],
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal membuat jenis polling.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete an existing polling category.
     */
    public function destroy(JenisPolling $jenisPolling): JsonResponse
    {
        try {
            if ($jenisPolling->pollings()->exists()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Jenis polling tidak dapat dihapus karena masih memiliki data polling.',
                ], 422);
            }

            $jenisPolling->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Jenis polling berhasil dihapus.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menghapus jenis polling.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
