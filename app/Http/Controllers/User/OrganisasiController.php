<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Organisasi;

class OrganisasiController extends Controller
{
    public function updateNamaPenerima(Request $request, $id)
    {
        $request->validate([
            'nama_penerima' => 'required|string|max:255',
        ]);

        $organisasi = Organisasi::find($id);

        if (!$organisasi) {
            return response()->json([
                'message' => 'Organisasi tidak ditemukan.'
            ], 404);
        }

        $organisasi->nama_penerima = $request->nama_penerima;
        $organisasi->save();

        return response()->json([
            'message' => 'Nama penerima berhasil diperbarui.',
            'data' => $organisasi
        ], 200);
    }
}
