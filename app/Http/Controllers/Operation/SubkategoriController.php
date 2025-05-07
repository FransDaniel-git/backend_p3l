<?php
namespace App\Http\Controllers\Operation;

use App\Http\Controllers\Controller;
use App\Models\Operation\Subkategori;
use Illuminate\Http\Request;

class SubkategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Jika ingin filter subkategori berdasarkan kategori (opsional)
        if ($request->filled('kategori_id')) {
            $subkategoris = Subkategori::where('id_kategori', $request->kategori_id)->get();
        } else {
            $subkategoris = Subkategori::all();
        }

        return response()->json([
            'message' => 'Daftar subkategori berhasil diambil',
            'data' => $subkategoris,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(subkategori $subkategori)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, subkategori $subkategori)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(subkategori $subkategori)
    {
        //
    }
}
