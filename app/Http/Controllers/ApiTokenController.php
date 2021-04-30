<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\Token;
use Illuminate\Http\Request;

class ApiTokenController extends Controller
{

    function createAPIToken(Request $request)
    {
        $rules = [
            "name" => "required",
        ];

        $customMessages = [
            'required' => 'Mohon Isi Kolom :attribute sebelum melanjutkan'
        ];

        $this->validate($request, $rules, $customMessages);

        $myToken = Str::random(24);
        $check = Token::all()->where('token', '=', $myToken)->count();

        while ($check == 1) {
            $myToken = Str::random(24);
            $check = Token::all()->where('token', '=', $myToken)->count();
        }

        $object = new Token();
        $object->name = $request->name;
        $object->access_type = 0;
        $object->token = $myToken;
        $object->save();

        if($object){
            return response()->json([
                'http_response' => 200,
                'status' => 1,
                'success' => true,
                'message' => 'Berhasil Membuat Token, Hubungi Divisi HR Untuk Mengaktifkan Token',
                'token' => $object,
            ]);
        }else{
            return response()->json([
                'http_response' => 400,
                'status' => 0,
                'success' => false,
                'message' => 'Gagal Membuat Token',
            ]);
        }
    }
   
   
    function updateToken(Request $request,$id)
    {

        $rules = [
            "name" => "required",
            "access_type" => "required",
        ];

        $customMessages = [
            'required' => 'Mohon Isi Kolom :attribute sebelum melanjutkan'
        ];

        $this->validate($request, $rules, $customMessages);

        $object = Token::findOrFail($id);
        $object->name = $request->name;
        $object->access_type = $request->access_type;
        $object->save();

        if($object){
            return response()->json([
                'http_response' => 200,
                'status' => 1,
                'success' => true,
                'message' => 'Berhasil Mengupdate Token',
                'token' => $object,
            ]);
        }else{
            return response()->json([
                'http_response' => 400,
                'status' => 0,
                'success' => false,
                'message' => 'Gagal Mengupdate Token',
                'token' => $object,
            ]);
        }
    }


    /*
    Menghapus Token Yang Sudah Dibuat
    */
    function deleteToken($id)
    {
        $object = Token::findOrFail($id);
        $object->delete();

        if($object){
            return response()->json([
                'http_response' => 200,
                'status' => 1,
                'success' => true,
                'message' => 'Berhasil Menghapus Token , Token Tidak Dapat Digunakan Kembali',
                'token' => $object,
            ]);
        }else{
            return response()->json([
                'http_response' => 400,
                'status' => 0,
                'success' => false,
                'message' => 'Gagal Menghapus Token, Silakan Hubungi Tim IT Divisi HR Untuk Bantuan Teknis',
            ]);
        }
    }
}
