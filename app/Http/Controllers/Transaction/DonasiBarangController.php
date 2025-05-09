<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Models\User\Organisasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Transaction\Donasi;
use App\Models\Transaction\donasi_barang;
use App\Models\Inventory\Barang_Donasi;
use App\Models\User\Penitip;
use Illuminate\Support\Facades\Log;
use App\Models\Transaction\Permohonan;
use Illuminate\Support\Facades\Validator;

class DonasiBarangController extends Controller
{
    public function getByOrganisasi($id_organisasi)
    {
        $organisasi = Organisasi::with([
            'permohonan.donasi.donasiBarang.barangdonasi',
        ])->where('id_organisasi', $id_organisasi)->first();

        if (!$organisasi) {
            return response()->json([
                'message' => 'Organisasi tidak ditemukan.'
            ], 404);
        }

        $donasiBarangList = [];

        foreach ($organisasi->permohonan as $permohonan) {
            foreach ($permohonan->donasi as $donasi) {
                foreach ($donasi->donasiBarang as $donasiBarang) {
                    $donasiBarangList[] = $donasiBarang;
                }
            }
        }

        return response()->json([
            'message' => 'Data donasi barang berhasil diambil.',
            'data' => $donasiBarangList
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_barang_donasi' => 'required|exists:barang_donasis,id_barang_donasi',
            'id_donasi' => 'required|exists:donasis,id_donasi',
        ]);

        $donasiBarang = donasi_barang::create([
            'id_barang_donasi' => $request->id_barang_donasi,
            'id_donasi' => $request->id_donasi,
        ]);

        return response()->json([
            'message' => 'Donasi barang berhasil ditambahkan.',
            'data' => $donasiBarang,
        ], 201);
    }

    public function updateCreatedAt(Request $request, $id)
    {
        $request->validate([
            'created_at' => 'required|date',
        ]);

        $donasiBarang = donasi_barang::find($id);

        if (!$donasiBarang) {
            return response()->json(['message' => 'Donasi barang tidak ditemukan.'], 404);
        }

        $donasiBarang->created_at = $request->created_at;
        $donasiBarang->save();

        return response()->json([
            'message' => 'Tanggal dibuat berhasil diperbarui.',
            'data' => $donasiBarang,
        ]);
    }

    public function donasikan(Request $request)
    {
        $validated = $request->validate([
            'id_permohonan' => 'required|string|exists:permohonans,id_permohonan',
            'id_barang_donasi' => 'required|string|exists:barang_donasis,id_barang_donasi',
        ]);

        DB::beginTransaction();
        try {
            // Step 1: Create Donation
            $donasi = Donasi::create([
                'id_permohonan' => $validated['id_permohonan'],
            ]);

            if (!$donasi) {
                throw new \Exception('Failed to create donation record');
            }

            // Step 2: Create Donation Item
            $donasiBarang = donasi_barang::create([
                'id_donasi' => $donasi->id_donasi,
                'id_barang_donasi' => $validated['id_barang_donasi'],
            ]);

            if (!$donasiBarang) {
                throw new \Exception('Failed to create donation item record');
            }

            // Step 3: Update Item Status
            $barang = Barang_Donasi::where('id_barang_donasi', $validated['id_barang_donasi'])->first();
            if (!$barang) {
                throw new \Exception('Item not found');
            }

            $barang->status_donasi = 1;
            if (!$barang->save()) {
                throw new \Exception('Failed to update item status');
            }

            // Step 4: Update Donor Points
            if ($barang->id_penitip) {
                $penitip = Penitip::where('id_penitip', $barang->id_penitip)->first();
                if ($penitip) {
                    $harga = $barang->harga ?? 0;
                    $poinTambahan = floor($harga / 10000);
                    $penitip->poin += $poinTambahan;
                    if (!$penitip->save()) {
                        throw new \Exception('Failed to update donor points');
                    }
                }
            }

            // Step 5: Update Permohonan Status
            $permohonan = Permohonan::where('id_permohonan', $validated['id_permohonan'])->first();
            if (!$permohonan) {
                throw new \Exception('Permohonan not found');
            }

            $permohonan->status_permohonan = 1;
            if (!$permohonan->save()) {
                throw new \Exception('Failed to update permohonan status');
            }

            DB::commit();

            return response()->json([
                'message' => 'Barang berhasil didonasikan',
                'donasi' => $donasi,
                'donasi_barang' => $donasiBarang,
                'barang' => $barang,
                'penitip' => $penitip ?? null,
                'permohonan' => $permohonan,
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Donation error: ' . $e->getMessage(), [
                'request' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'message' => 'Gagal melakukan donasi barang',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function updateDonasi(Request $request, $id_donasi_barang)
    {
        DB::beginTransaction();
        try {
            $donasiBarang = donasi_barang::where('id_donasi_barang', $id_donasi_barang)->first();
            
            if (!$donasiBarang) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data donasi barang tidak ditemukan'
                ], 404);
            }

            $validator = Validator::make($request->all(), [
                'tanggal_donasi' => 'nullable|date',
                'nama_penerima' => 'nullable|string|max:255',
                'status_barang' => 'nullable|integer|in:0,1'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Update tanggal donasi (created_at) jika diisi
            if ($request->has('tanggal_donasi') && $request->tanggal_donasi) {
                $donasiBarang->created_at = $request->tanggal_donasi;
                $donasiBarang->save();
            }

            // Update nama penerima jika diisi
            if ($request->has('nama_penerima') && $request->nama_penerima) {
                Permohonan::where('id_permohonan', $donasiBarang->donasi->id_permohonan)
                    ->update(['nama_penerima' => $request->nama_penerima]);
            }

            // Update status barang jika diisi
            if ($request->has('status_barang') && $request->status_barang !== null) {
                Barang_Donasi::where('id_barang_donasi', $donasiBarang->id_barang_donasi)
                    ->update(['status_donasi' => $request->status_barang]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Data donasi berhasil diperbarui'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui data donasi',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
