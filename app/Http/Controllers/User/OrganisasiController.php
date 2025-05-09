<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User\Organisasi;
use Illuminate\Http\Request;

class OrganisasiController extends Controller
{
    public function getDonasiByOrganisasi($id_organisasi)
    {
        $organisasi = Organisasi::with([
            'permohonan' => function($query) {
                $query->where('status_permohonan', 1)
                    ->with(['donasi.donasiBarang.barangdonasi']);
            }
        ])->where('id_organisasi', $id_organisasi)->first();

        if (!$organisasi) {
            return response()->json([
                'success' => false,
                'message' => 'Organisasi tidak ditemukan'
            ], 404);
        }

        $donasiBarangList = [];
        
        foreach ($organisasi->permohonan as $permohonan) {
            foreach ($permohonan->donasi as $donasi) {
                foreach ($donasi->donasiBarang as $donasiBarang) {
                    $donasiBarangList[] = [
                        'nama_penerima' => $permohonan->nama_penerima,
                        'catatan_permohonan' => $permohonan->catatan,
                        'barang' => [
                            'nama' => $donasiBarang->barangdonasi->nama,
                            'kategori' => $donasiBarang->barangdonasi->subkategori->kategori->nama_kategori ?? '-',
                            'subkategori' => $donasiBarang->barangdonasi->subkategori->nama_subkategori ?? '-',
                            'status_donasi' => $donasiBarang->barangdonasi->status_donasi,
                        ],
                        'tanggal_donasi' => $donasiBarang->created_at?->format('Y-m-d H:i:s') ?? '-',
                        'id_donasi_barang' => $donasiBarang->id_donasi_barang,
                    ];
                }
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Data donasi berhasil diambil',
            'data' => [
                'organisasi' => [
                    'id' => $organisasi->id_organisasi,
                    'nama' => $organisasi->nama,
                    'email' => $organisasi->email
                ],
                'total_donasi' => count($donasiBarangList),
                'daftar_donasi' => $donasiBarangList
            ]
        ]);
    }

    public function getAllOrganisasi()
    {
        $organisasis = Organisasi::select('id_organisasi', 'nama', 'email', 'alamat')
                        ->orderBy('nama', 'asc')
                        ->get();

        return response()->json([
            'success' => true,
            'data' => $organisasis
        ]);
    }
}