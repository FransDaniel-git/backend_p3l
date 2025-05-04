<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PegawaiController extends Controller
{
    public function index(Request $request)
    {
        $query = Pegawai::with('jabatan');

        if ($request->has('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        $query->orderByRaw('CAST(SUBSTRING(id_pegawai, 2) AS UNSIGNED) ASC');

        $pegawais = $query->get();

        return response()->json([
            'message' => 'Data pegawai berhasil diambil',
            'data' => $pegawais
        ], 200);
    }


    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'email' => 'required|email|unique:pegawais,email',
            'password' => 'required|string|min:6',
            'tanggal_lahir' => 'required|date',
            'noTelp' => 'required|string',
            'id_jabatan' => 'required|exists:jabatans,id_jabatan',
        ]);

        $lastNumber = Pegawai::selectRaw('MAX(CAST(SUBSTRING(id_pegawai, 2) AS UNSIGNED)) as max_id')
            ->first()
            ->max_id;
        $newId = 'P' . ($lastNumber ? $lastNumber + 1 : 1);

        $pegawai = Pegawai::create([
            'id_pegawai' => $newId,
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'tanggal_lahir' => $request->tanggal_lahir,
            'noTelp' => $request->noTelp,
            'id_jabatan' => $request->id_jabatan,
        ]);

        return response()->json([
            'message' => 'Pegawai berhasil ditambahkan',
            'data' => $pegawai
        ], 201);
    }

    public function show($id)
    {
        $pegawai = Pegawai::where('id_pegawai', $id)->first();

        if (!$pegawai) {
            return response()->json([
                'message' => 'Pegawai tidak ditemukan',
                'data' => null
            ], 404);
        }

        return response()->json([
            'message' => 'Data pegawai berhasil ditemukan',
            'data' => $pegawai
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $pegawai = Pegawai::where('id_pegawai', $id)->first();

        if (!$pegawai) {
            return response()->json([
                'message' => 'Pegawai tidak ditemukan',
                'data' => null
            ], 404);
        }

        $request->validate([
            'nama' => 'sometimes|required|string',
            'email' => 'sometimes|required|email|unique:pegawais,email,' . $pegawai->id_pegawai . ',id_pegawai',
            'password' => 'nullable|string|min:6',
            'tanggal_lahir' => 'sometimes|required|date',
            'noTelp' => 'sometimes|required|string',
            'id_jabatan' => 'sometimes|required|exists:jabatans,id_jabatan',
        ]);

        if ($request->filled('password')) {
            $pegawai->password = Hash::make($request->password);
        }

        $pegawai->update($request->except('password'));

        return response()->json([
            'message' => 'Data pegawai berhasil diperbarui',
            'data' => $pegawai
        ], 200);
    }

    public function destroy($id)
    {
        $pegawai = Pegawai::where('id_pegawai', $id)->first();

        if (!$pegawai) {
            return response()->json([
                'message' => 'Pegawai tidak ditemukan',
                'data' => null
            ], 404);
        }

        $pegawai->delete();

        return response()->json([
            'message' => 'Pegawai berhasil dihapus',
            'data' => null
        ], 200);
    }
}
