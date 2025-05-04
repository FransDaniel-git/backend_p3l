<?php

namespace App\Http\Controllers;

use App\Models\Permohonan;
use Illuminate\Http\Request;

class PermohonanController extends Controller
{
    public function index()
    {
        $permohonans = Permohonan::with('penerima')->get();

        return response()->json([
            'message' => 'Daftar permohonan berhasil diambil',
            'data' => $permohonans
        ], 200);
    }
}
