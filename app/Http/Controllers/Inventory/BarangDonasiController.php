<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Inventory\Barang_Donasi;
use App\Models\Operation\Subkategori;
use Illuminate\Http\Request;

class BarangDonasiController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'search' => 'nullable|string|max:255',
            'kategori' => 'nullable|integer|exists:kategoris,id_kategori',
            'subkategori' => 'nullable|integer|exists:subkategoris,id_subkategori',
        ]);

        $query = Barang_Donasi::with('subkategori.kategori')->where('status_donasi', 0);

        if (!empty($validated['search'])) {
            $query->where('nama', 'like', '%' . $validated['search'] . '%');
        }

        if (!empty($validated['kategori'])) {
            $kategoriId = $validated['kategori'];

            $subkategoriIds = Subkategori::where('id_kategori', $kategoriId)->pluck('id_subkategori');

            $query->whereIn('id_subkategori', $subkategoriIds);
        }

        if (!empty($validated['subkategori'])) {
            $query->where('id_subkategori', $validated['subkategori']);
        }

        $barangDonasis = $query->get();

        return response()->json([
            'message' => 'Data barang donasi berhasil diambil',
            'data' => $barangDonasis,
        ]);
    }

    public function show($id_barang_donasi)
    {
        $barangDonasi = Barang_Donasi::with(['penitip', 'subkategori.kategori'])
            ->where('id_barang_donasi', $id_barang_donasi)
            ->first();

        if (!$barangDonasi) {
            return response()->json([
                'message' => 'Barang donasi tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'message' => 'Data barang donasi berhasil diambil',
            'data' => $barangDonasi,
        ]);
    }
}
