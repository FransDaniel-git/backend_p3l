<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Inventory\Barang;
use App\Models\Operation\Subkategori;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'search' => 'nullable|string|max:255',
            'harga_min' => 'nullable|numeric|min:0',
            'harga_max' => 'nullable|numeric|min:0',
            'kategori' => 'nullable|integer|exists:kategoris,id_kategori',
            'subkategori' => 'nullable|integer|exists:subkategoris,id_subkategori',
            'garansi' => 'nullable|in:ada',
            'rating_min' => 'nullable|numeric|min:0|max:5',
        ]);

        $query = Barang::with(['penitipan.penitip', 'subkategori'])
            ->where('status', 'Tersedia');

        if (!empty($validated['search'])) {
            $query->where('nama', 'like', "%{$validated['search']}%");
        }

        if (isset($validated['harga_min'])) {
            $query->where('harga', '>=', $validated['harga_min']);
        }

        if (isset($validated['harga_max'])) {
            $query->where('harga', '<=', $validated['harga_max']);
        }

        if (!empty($validated['kategori'])) {
            $kategoriId = $validated['kategori'];
            $subkategoriIds = Subkategori::where('id_kategori', $kategoriId)->pluck('id_subkategori');
            $query->whereIn('id_subkategori', $subkategoriIds);
        }

        if (!empty($validated['subkategori'])) {
            $query->where('id_subkategori', $validated['subkategori']);
        }

        if (!empty($validated['garansi']) && $validated['garansi'] === 'ada') {
            $today = Carbon::today()->toDateString();
            $query->whereNotNull('tanggal_garansi')
                  ->whereDate('tanggal_garansi', '>=', $today);
        }

        if (isset($validated['rating_min'])) {
            $ratingMin = floatval($validated['rating_min']);
            $query->whereHas('penitipan.penitip', function ($q) use ($ratingMin) {
                $q->where('rating_total', '>=', $ratingMin);
            });
        }

        $barangs = $query->get();

        return response()->json([
            'message' => 'Data barang berhasil diambil',
            'data' => $barangs,
        ]);
    }

    public function getDetail($kode_barang)
    {
        $barang = Barang::with([
            'penitipan.penitip',
            'subkategori.kategori'
        ])->where('kode_barang', $kode_barang)->first();

        if (!$barang) {
            return response()->json([
                'message' => 'Barang tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $barang
        ]);
    }
}
