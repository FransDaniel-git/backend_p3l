<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction\Donasi;

class DonasiController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'id_permohonan' => 'required|exists:permohonans,id_permohonan',
        ]);

        $donasi = Donasi::create([
            'id_permohonan' => $request->id_permohonan,
        ]);

        return response()->json([
            'message' => 'Donasi berhasil ditambahkan',
            'data' => $donasi,
        ], 201);
    }
}
