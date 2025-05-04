<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang_Donasi;

class BarangDonasiController extends Controller
{
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status_donasi' => 'required|string'
        ]);

        $barang = Barang_Donasi::find($id);

        if (!$barang) {
            return response()->json([
                'message' => 'Barang donasi tidak ditemukan'
            ], 404);
        }

        $barang->status_donasi = $request->status_donasi;
        $barang->save();

        return response()->json([
            'message' => 'Status donasi berhasil diperbarui',
            'data' => $barang
        ], 200);
    }
}
