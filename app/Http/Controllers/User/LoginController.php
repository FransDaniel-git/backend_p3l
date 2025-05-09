<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;

use App\Models\User\Organisasi;
use App\Models\User\Pelanggan;
use App\Models\User\Pegawai;
use App\Models\User\Penitip;

use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{


    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);
    
        $email      = $request->email;
        $password   = $request->password;
        $clientType = $request->header('X-Client-Type');
    
        Log::info('Login attempt', ['email' => $email, 'client_type' => $clientType]);
    
        // Daftar model yang dicek
        $userSources = [
            ['model' => Organisasi::class, 'type' => 'organisasi',  'id_field' => 'id_organisasi'],
            ['model' => Pegawai::class,    'type' => 'pegawai',     'id_field' => 'id_pegawai'],
            ['model' => Pelanggan::class,   'type' => 'pelanggan',   'id_field' => 'id_pelanggan'],
            ['model' => Penitip::class,     'type' => 'penitip',     'id_field' => 'id_penitip'],
        ];
    
        $foundUser = null;
        $userType = null;
        $userId = null;
        $jabatan = null;
    
        // Loop cek setiap tabel tanpa langsung return
        foreach ($userSources as $src) {
            $user = $src['model']::where('email', $email)->first();
    
            Log::info('User check', ['email' => $email, 'user_type' => $src['type'], 'model' => $src['model']]);
    
            if ($user) {
                Log::info('User found in table', ['email' => $email, 'user_type' => $src['type']]);
                
                if (Hash::check($password, $user->password)) {
                    $foundUser = $user;
                    $userType = ucwords($src['type']);
                    $userId = $user->{$src['id_field']};
                    $jabatan = $user->id_jabatan ?? null; // Handle jika tidak ada jabatan
                    break; // Keluar dari loop setelah menemukan yang cocok
                } else {
                    Log::error('Invalid Password for user', ['email' => $email, 'user_type' => $src['type']]);
                }
            }
        }
    
        // Jika ditemukan user yang cocok
        if ($foundUser) {
            // Response untuk web (session)
            if ($clientType === 'web') {
                $token = $foundUser->createToken('Authentication Token')->accessToken;

                
                Log::info('User logged in via web', ['user_id' => $userId, 'jabatan' => $jabatan, 'user_type' => $userType]);
    
                return response()->json([
                    'status'    => 'success',
                    'message'   => 'Logged in via web (session)',
                    'data'      => $foundUser,
                    'id'        => $userId,
                    'jabatan'   => $jabatan,
                    'user_type' => $userType,
                    'token' => $token,
                ], 200);
            }
    
            // Response untuk mobile (token)
            if ($clientType === 'mobile') {
                $token = $foundUser->createToken('Authentication Token')->accessToken;
                Log::info('User logged in via mobile', ['user_id' => $userId, 'jabatan' => $jabatan, 'token' => $token]);
    
                return response()->json([
                    'status'    => 'success',
                    'message'   => ucfirst($userType) . ' Logged In Successfully',
                    'token'     => $token,
                    'data'      => $foundUser,
                    'id'        => $userId,
                    'jabatan'   => $jabatan,
                    'user_type' => $userType,
                ], 200);
            }
    
            // Jika header X-Client-Type tidak dikenali
            Log::error('Invalid Client Type', ['client_type' => $clientType]);
            return response()->json([
                'status'  => 'error',
                'message' => 'Invalid Client Type'
            ], 400);
        }
    
        // Hardcoded Owner (jabatan = superadmin)
        $ownerEmail    = 'owner@example.com';
        $ownerHashPass = '$argon2id$v=19$m=65536,t=4,p=2$ZXQxRkRpd2xIcnNueUNwbw$tBW9VbV7LDWpG0Fr2Wji3aIAWFyFQB0po4VmjpkdUSQ';
        $ownerName = "ArchiPera Rari Dyaksa";
        $ownerJabatan =  5;
        if ($email === $ownerEmail && Hash::check($password, $ownerHashPass)) {
            return response()->json([
                'status'    => 'success',
                'message'   => 'Owner Logged In Successfully',
                'data'      => [
                    'id'        => 'owner',
                    'jabatan'   => $ownerJabatan,
                    'user_type' => 'Owner',
                    'nama'      => $ownerName,
                    'data'      => [
                        'id_pegawai' => 'owner',
                        'email'      => $ownerEmail,
                        'nama'       => $ownerName,
                        'jabatan'    => $ownerJabatan,
                    ],
                    'email'      => $ownerEmail,
                ],
                'user_type' => 'owner',
                'jabatan'   => $ownerJabatan,
                'id'        => 'owner',
                'email'     => $ownerEmail,
            ], 200);
        }
    
        // Jika tidak ada yang cocok
        Log::error('Invalid Credentials', ['email' => $email]);
        return response()->json([
            'status'  => 'error',
            'message' => 'Invalid Credentials'
        ], 401);
    }


}
