<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User\Penitip;

class PenitipController extends Controller
{
    public function tambahPoin(Request $request, $id)
    {
        $request->validate([
            'poin' => 'required|numeric|min:1'
        ]);

        $penitip = Penitip::find($id);

        if (!$penitip) {
            return response()->json([
                'message' => 'Penitip tidak ditemukan.'
            ], 404);
        }

        $penitip->poin += $request->poin;
        $penitip->save();

        return response()->json([
            'message' => 'Poin berhasil ditambahkan.',
            'data' => $penitip
        ], 200);
    }
}
