<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Models\Transaction\Permohonan;
use Illuminate\Http\Request;

class PermohonanController extends Controller
{
    public function index()
    {
        $permohonans = Permohonan::with('penerima')
                            ->where('status_permohonan', 0)
                            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $permohonans,
        ]);
    }
}
