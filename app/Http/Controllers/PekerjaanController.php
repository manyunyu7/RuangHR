<?php

namespace App\Http\Controllers;

use App\Models\Pekerjaan;
use Illuminate\Http\Request;

class PekerjaanController extends Controller
{
    function store(Request $request){

        $rules = [
            "nama_pekerjaan" => "required",
            "gaji" => "required|numeric",
        ];

        $customMessages = [
            'required' => 'Mohon Isi Kolom :attribute sebelum melanjutkan'
        ];

        $this->validate($request, $rules, $customMessages);

        $object = new Pekerjaan();
        $object->nama_pekerjaan = $request->nama_pekerjaan;
        $object->gaji = $request->gaji;
        $object->save();

        if($object){
            return response()->json([
                'http_response' => 200,
                'status' => 1,
                'message' => 'Berhasil Menyimpan Pekerjaan',
            ]);
        }else{
            return response()->json([
                'http_response' => 400,
                'status' => 0,
                'message' => 'Gagal menyimpan Pekerjaan',
            ]);
        }

    }
}
