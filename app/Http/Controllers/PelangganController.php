<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $data = Pelanggan::all();
            return response() -> json([
                'status' => 'success',
                'message' => 'Data Retrive Successfully',
                'data' => $data

            ],200);
        }catch(\Exception $e){
            \Log::error('Error in PelangganController@index: ' . $e->getMessage());
            return response()-> json([
                'status' => 'error',
                'message' => 'Failed to Retrive Data',
                'data error' => $e
            ],500);
        }
    }

    public function showId($id){
        try{
            $data = Pelanggan::find($id);
            return response()-> json([
                'status' => 'success',
                'message' => 'Data Retrive Successfully',
                'data' => $data
            ],200);
        }catch(\Exception $e){
            return response()-> json([
                'status' => 'error',
                'message' => 'Failed to Retrive Data',
                'data error' => $e
            ],500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:pelanggans,name',
            'email' => 'required|string|unique:Pelanggans,email',
            'password' => 'required|string'
        ]);

        $Pelanggan = Pelanggan::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Pelanggan Created Successfully',
            'data' => $Pelanggan
        ],200);
    }

    public function login(Request $request) {
        $request->validate([
            'name' => 'required|string',
            'password' => 'required|string'
        ]);

        $Pelanggan = Pelanggan::where('name',$request->name)->first();

        if(!$Pelanggan || !Hash::check($request->password, $Pelanggan->password)){
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid Credentials'
            ],401);
        }

        $token = $Pelanggan->createToken('token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Pelanggan Logged In Successfully',
            'token' => $token,
            'data' => $Pelanggan->name,
            'id' => $Pelanggan->id
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Pelanggan $Pelanggan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */


public function update(Request $request, $id)
{
    try {
        // Log request masuk
        Log::info("Update Request Received", ['data' => $request->all(), 'id' => $id]);

       $request->validate([
            'name' => 'required|string|unique:Pelanggans,name,' . $id,
            'email' => 'required|string|unique:Pelanggans,email,' . $id,
            'password' => 'required|string'
        ]);

        Log::info("Validation Passed", ['validated' => $request]);

        $Pelanggan = Pelanggan::find($id);
        if (!$Pelanggan) {
            Log::error("Pelanggan Not Found", ['id' => $id]);
            return response()->json([
                'status' => 'error',
                'message' => 'Pelanggan not found'
            ], 404);
        }

        Log::info("Pelanggan Found", ['Pelanggan' => $Pelanggan]);

        $Pelanggan->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        Log::info("Pelanggan Updated Successfully", ['Pelanggan' => $Pelanggan]);

        return response()->json([
            'status' => 'success',
            'message' => 'Pelanggan Updated Successfully',
            'data' => $Pelanggan
        ]);
    } catch (\Exception $e) {
        Log::error("Update Failed", ['error' => $e->getMessage()]);

        return response()->json([
            'status' => 'error',
            'message' => 'Failed to Update Pelanggan',
            'data error' => $e->getMessage()
        ], 500);
    }
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try{

            // Cek apakah Pelanggan ditemukan sebelum delet

        $Pelanggan = Pelanggan::find($id);
        if(!$Pelanggan){
            return response()->json([
                'status' => 'error',
                'message' => 'Pelanggan Not Found'
            ],404);
        }

        $Pelanggan->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Pelanggan Deleted Successfully'
            ],200);
        }catch(\Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to Delete Pelanggan',
                'data error' => $e
            ],500);
        }
    }
}
