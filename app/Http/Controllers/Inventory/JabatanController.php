<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Inventory\Jabatan;
use Illuminate\Http\Request;

class JabatanController extends Controller
{
    public function index()
    {
        $jabatans = Jabatan::all();
        
        return response()->json([
            'message' => 'Data jabatan berhasil diambil',
            'data' => $jabatans
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_jabatan' => 'required|string|unique:jabatans,nama_jabatan',
            'izin' => 'required|string'
        ]);

        $jabatan = Jabatan::create([
            'nama_jabatan' => $request->nama_jabatan,
            'izin' => $request->izin
        ]);

        return response()->json([
            'message' => 'Jabatan berhasil ditambahkan',
            'data' => $jabatan
        ], 201);
    }

    public function show($id)
    {
        $jabatan = Jabatan::find($id);

        if (!$jabatan) {
            return response()->json([
                'message' => 'Jabatan tidak ditemukan',
                'data' => null
            ], 404);
        }

        return response()->json([
            'message' => 'Data jabatan berhasil ditemukan',
            'data' => $jabatan
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $jabatan = Jabatan::find($id);

        if (!$jabatan) {
            return response()->json([
                'message' => 'Jabatan tidak ditemukan',
                'data' => null
            ], 404);
        }

        $request->validate([
            'nama_jabatan' => 'sometimes|required|string|unique:jabatans,nama_jabatan,'.$id.',id_jabatan',
            'izin' => 'sometimes|required|string'
        ]);

        $jabatan->update($request->all());

        return response()->json([
            'message' => 'Data jabatan berhasil diperbarui',
            'data' => $jabatan
        ], 200);
    }

    public function destroy($id)
    {
        $jabatan = Jabatan::find($id);

        if (!$jabatan) {
            return response()->json([
                'message' => 'Jabatan tidak ditemukan',
                'data' => null
            ], 404);
        }

        $jabatan->delete();

        return response()->json([
            'message' => 'Jabatan berhasil dihapus',
            'data' => null
        ], 200);
    }
}