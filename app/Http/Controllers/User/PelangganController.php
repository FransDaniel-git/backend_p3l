<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function register(Request $request){
        $request->validate([
            'nama' => 'required|string',
            'email' => 'required|email|unique:Pelanggan, email',
            'tanggal_lahir' => 'required|date',
            'noTelp' => 'required|string',
            'password' => 'required|string',
            
        ]);

        $request->poin = 0;
        $request->verified = 0;
        $request->verified_at = null;
        $request->password = Hash::make($request->password);

        $last = Pelanggan::latest('id_pelanggan')->first();
        $idnumber = $last ? $last->id_pelanggan : 0;
        $id = 'P'.str_pad($idnumber + 1, 4, '0', STR_PAD_LEFT);
        

        $pelanggan = Pelanggan::create([
            'id_pelanggan' => $id,
            'nama' => $request->nama,
            'email' => $request->email,
            'noTelp' => $request->noTelp,
            'password' => $request->password,
            'tanggal_lahir' => $request->tanggal_lahir,
        ]);

        $this->sendverificationEmail($pelanggan);

        return response()->json([
            'message' => 'Berhasil mendaftar, silahkan cek email anda untuk verifikasi',
            'data' => $pelanggan,

        ], 201);
    }

    private function sendverificationEmail($pelanggan){
        //TINGGAL BUAT EMAILNYA SAMA PAHAMIN KODE YG BUAT ISI DATA DI HTML DAN KIRIM EMIALNYA
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
                    ->setBody($body, 'text/html'); // bisa diganti 'text/plain' kalau mau teks biasa
        });
    }

    public function verifyEmail(Request $request){
        $decode = $request->token;

        
    }

    /**
     * Display the specified resource.
     */
    public function show(Pelanggan $pelanggan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pelanggan $pelanggan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pelanggan $pelanggan)
    {
        //
    }
}
