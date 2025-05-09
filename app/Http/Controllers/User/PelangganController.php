<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;

use App\Models\User\Pelanggan;
use App\Models\User\Pegawai;
use App\Models\Inventory\Jabatan;
use App\Models\Transaction\Penjualan;
use App\Models\Transaction\Detail_Penjualan;
use App\Models\Inventory\Barang;
use App\Models\User\Penitip;

use Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function getPoin(Request $request){

    
        

        $request->validate([
            'id_pelanggan' => 'required'
        ]);
        
        

        $request->validate([
            'id_pelanggan' => 'required'
        ]);

        Log::info('Get Poin Request', ['data' => $request->all()]);

        $pelanggan = Pelanggan::where('id_pelanggan', $request->id_pelanggan)->first();
        if(!$pelanggan){
            return response()-> json([
                'status' => 'error',
                'message' => 'Pelanggan Not Found'
            ],404);
        }

        Log::info('Pelanggan Found', ['pelanggan' => $pelanggan]);

        $poin = $pelanggan->poin;

        Log::info('Poin Retrieved', ['poin' => $poin]);

        return response()->json([
            'status' => 'success',
            'message' => 'Poin Retrieved Successfully',
            'data' => $poin
        ], 200);


    }

    public function index(Request $request)
    {

        // Log::info("Request Received", ['data' => $request->all()]);


        $izin = 'View Data Pelanggan';

        $id_pegawai = session('id_pegawai');

        if(!$id_pegawai){
            $request->validate([
                'id_pegawai' => 'required'
            ]);
            $id_pegawai = $request->id_pegawai;
        }

        $pegawai = Pegawai::where('id_pegawai',$id_pegawai)->first();

        if(!$pegawai){
            return response()-> json([
                'status' => 'error',
                'message' => 'Pegawai Not Found'
            ],404);
        }

        $jabatan = Jabatan::where('id_jabatan', $pegawai->id_jabatan)->first();

        if(!$jabatan){
            return response()-> json([
                'status' => 'error',
                'message' => 'Jabatan Not Found'
            ],404);
        }

        if(!in_array($jabatan->izin, explode(',', $izin))){
            return response()-> json([
                'status' => 'error',
                'message' => 'Akses Ditolak'
            ],403);
        }

        try{
            $data = Pelanggan::all();
           
                return response()->json([
                    'status' => 'success',
                    'message' => 'Data Retrieved Successfully',
                    'data' => $data
                ], 200);
            
        }catch(\Exception $e){
            \Log::error('Error in PelangganController@index: ' . $e->getMessage());
            return response()-> json([
                'status' => 'error',
                'message' => 'Failed to Retrive Data',
                'data error' => $e
            ],500);
        }
    }

    public function showId(Request $request, ){

        $id = session('id_pelanggan');



        if (!$id) {
            $request->validate([
                'id_pelanggan' => 'required'
            ]);
            $id = $request->id_pelanggan;
        }
        
        $pelanggan = Pelanggan::find($id);
        
        if (!$pelanggan) {
            return response()->json([
                'status' => 'error',
                'message' => 'Pelanggan Not Found'
            ], 404);
        }

        if(!Auth::check()){
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized'
            ], 401);
        }

    
        try{
            $data = Pelanggan::find($id);
            // Log::info("Request Received", ['data' => $request->all()]);
            if(!$data){
                return response()-> json([
                    'status' => 'error',
                    'message' => 'Pelanggan Not Found'
                ],404);
            }
            // Log::info("Pelanggan Found", ['Pelanggan' => $data]);

            
                return response()->json([
                    'status' => 'success',
                    'message' => 'Data Retrieved Successfully',
                    'data' => $data
                ], 200);
            
            
        }catch(\Exception $e){
            return response()-> json([
                'status' => 'error',
                'message' => 'Failed to Retrive Data',
                'data error' => $e
            ],500);
        }
    }

    public function register(Request $request){

        $email = strtolower($request->input('email'));

        $request->merge(['email' => $email]);

        $request->validate([
            'nama' => 'required|string',
            'email' => [
                'required',
                'email',
                function ($attribute, $email, $fail) {
                    $email = strtolower($email); // just in case

                    $exists = DB::table('pelanggans')->whereRaw('LOWER(email) = ?', [$email])->exists()
                        || DB::table('penitips')->whereRaw('LOWER(email) = ?', [$email])->exists()
                        || DB::table('pegawais')->whereRaw('LOWER(email) = ?', [$email])->exists();

                    if ($exists) {
                        $fail('Email sudah digunakan di sistem.');
                    }
                }
            ],
            'tanggal_lahir' => 'required|date',
            'noTelp' => 'required|string',
            'password' => 'required|string',
            
        ]);

        \Log::info('Register Request', ['data' => $request->all()]);

        $request->email = strtolower($request->email);

        $request->password = Hash::make($request->password);

        // $last = Pelanggan::max('id_pelanggan');
        // $last = Pelanggan::orderBy('id_pelanggan', 'desc')->first();
        // $idnumber = $last ? $last : 0;
        // $id = 'PE'.str_pad($idnumber + 1, 4, '0', STR_PAD_LEFT);

        // $lastId = Pelanggan::max('id_pelanggan');
        // $number = $lastId ? intval(substr($lastId, 2)) : 0;
        // $id = 'PE' . ($number + 1); 
        

        $last = Pelanggan::select('id_pelanggan')
            ->orderByRaw("CAST(SUBSTRING(id_pelanggan, 3) AS UNSIGNED) DESC")
            ->first();

        $number = $last ? intval(substr($last->id_pelanggan, 2)) : 0;
        $id = 'PE' . ($number + 1);

        $pelanggan = Pelanggan::create([
            'id_pelanggan' => $id,
            'nama' => $request->nama,
            'email' => $request->email,
            'noTelp' => $request->noTelp,
            'password' => $request->password,
            'id_jabatan' => 7,
            'tanggal_lahir' => $request->tanggal_lahir,
        ]);

        $this->sendverificationEmail($pelanggan);

        return response()->json([
            'message' => 'Berhasil mendaftar, silahkan cek email anda untuk verifikasi',
            'data' => $pelanggan,

        ], 201);
    }

    private function sendverificationEmail($pelanggan){
        
        $token = urlencode(base64_encode($pelanggan->email . '|' . hash_hmac('sha256', $pelanggan->email,env('HMAC_SECRET_KEY'))));

        $verificationLink = url("/api/verify-email?token=$token");

        // $verificationLink = url("/verify-email?token=$token");

        $body = "Halo {$pelanggan->nama},<br><br>
        Terima kasih sudah mendaftar.<br>
        Klik link di bawah ini untuk verifikasi akun kamu:<br><br>
        <a href='{$verificationLink}'>Verifikasi Sekarang</a><br><br>
        Jika kamu tidak merasa melakukan pendaftaran, abaikan email ini.<br><br>
        Salam,<br>Tim Kami";
        
        Mail::send([], [], function ($message) use ($pelanggan, $body) {
            $message->to($pelanggan->email)
                    ->subject('Verifikasi Akun Anda')
                    ->html($body); // bisa diganti 'text/plain' kalau mau teks biasa
        });
    }

    public function verifyEmail(Request $request){
        $decode = urldecode(base64_decode($request->token));
        $data = explode('|', $decode);
        $email = $data[0];
        $hash = $data[1];
        $pelanggan = Pelanggan::where('email', $email)->first();
        
        if(!$pelanggan){
            return response()->json([
                'status' => 'error',
                'message' => 'Email not found'
            ], 404);
        }

        if(!hash_equals($hash,hash_hmac('sha256', $pelanggan->email,env('HMAC_SECRET_KEY')))){
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid token'
            ], 401);
        }

        Pelanggan::where('email', $email)->update([
            'verified' => 1,
            'verified_at' => now()
        ]);
        return response()->json([
            'status' => 'success',
            'message' => 'Email verified successfully'
        ], 200);

        
    }

    /**
     * Display the specified resource.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        $pelanggan = Pelanggan::where('email', $request->email)->first();
        if(!$pelanggan || !Hash::check($request->password, $pelanggan->password)){
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid Credentials'
            ],401);
        }

        $clientType = $request->header('X-Client-Type');

        if ($clientType === 'web') {
            Auth::login($pelanggan);
            return response()->json([
                'status' => 'success',
                'message' => 'Logged in via web (session)',
                'data' => $pelanggan
            ], 200);
        } elseif ($clientType === 'mobile') {
            $token = $pelanggan->createToken('Personal Access Token')->plainTextToken;

            return response()->json([
                'status' => 'success',
                'message' => 'Pelanggan Logged In Successfully',
                'token' => $token,
                'data' => $pelanggan,
                'id' => $pelanggan->id_pelanggan,
                'jabatan' => $pelanggan->id_jabatan,
            ]);
        }

        
    }

    /**
     * Update the specified resource in storage.
     */
    public function history(Request $request)
    {
        $request->validate([
            'id_pelanggan' => 'required'
        ]);

        Penjualan::where('id_pelanggan', $request->id_pelanggan)->update([
            'status' => 'Selesai'
        ]);
        $data = Penjualan::where('id_pelanggan', $request->id_pelanggan)->get();
        if(!$data){
            return response()-> json([
                'status' => 'error',
                'message' => 'Penjualan Not Found'
            ],404);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Data Retrieved Successfully',
            'data' => $data
        ], 200);
    }

    public function getNamaPenitip(Request $request)
    {
        $request->validate([
            'id_penitip' => 'required'
        ]);

        $penitip = Penitip::where('id_penitip', $request->id_penitip)->first();
        if(!$penitip){
            return response()-> json([
                'status' => 'error',
                'message' => 'Penitip Not Found'
            ],404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Data Retrieved Successfully',
            'data' => $penitip->nama
        ], 200);
    }

    public function getListBarang(Request $request){
        $request->validate([
            'list_barang' => 'required'
        ]);

        $idList = explode(',', $request->list_barang);

        $barangs = Barang::whereIn('kode_barang', $idList)->pluck('nama')->toArray();

        $barangString = implode(', ', $barangs);

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'message' => 'Data barang berhasil diambil.',
            'data' => $barangString
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pelanggan $pelanggan)
    {
        //
    }
}
