<?php

namespace App\Http\Controllers;

use App\Models\Organisasi;
use Illuminate\Http\Request;
use App\Models\Transaction\donasi_barang;

class DonasiBarangController extends Controller
{
    public function getByOrganisasi($id_organisasi)
    {
        $organisasi = Organisasi::with([
            'permohonan.donasi.donasiBarang.barangdonasi',
        ])->where('id_organisasi', $id_organisasi)->first();

        if (!$organisasi) {
            return response()->json([
                'message' => 'Organisasi tidak ditemukan.'
            ], 404);
        }

        $donasiBarangList = [];

        foreach ($organisasi->permohonan as $permohonan) {
            foreach ($permohonan->donasi as $donasi) {
                foreach ($donasi->donasiBarang as $donasiBarang) {
                    $donasiBarangList[] = $donasiBarang;
                }
            }
        }

        return response()->json([
            'message' => 'Data donasi barang berhasil diambil.',
            'data' => $donasiBarangList
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_barang_donasi' => 'required|exists:barang_donasis,id_barang_donasi',
            'id_donasi' => 'required|exists:donasis,id_donasi',
        ]);

        $donasiBarang = donasi_barang::create([
            'id_barang_donasi' => $request->id_barang_donasi,
            'id_donasi' => $request->id_donasi,
        ]);

        return response()->json([
            'message' => 'Donasi barang berhasil ditambahkan.',
            'data' => $donasiBarang,
        ], 201);
    }

    public function updateCreatedAt(Request $request, $id)
    {
        $request->validate([
            'created_at' => 'required|date',
        ]);

        $donasiBarang = donasi_barang::find($id);

        if (!$donasiBarang) {
            return response()->json(['message' => 'Donasi barang tidak ditemukan.'], 404);
        }

        $donasiBarang->created_at = $request->created_at;
        $donasiBarang->save();

        return response()->json([
            'message' => 'Tanggal dibuat berhasil diperbarui.',
            'data' => $donasiBarang,
        ]);
    }
}
