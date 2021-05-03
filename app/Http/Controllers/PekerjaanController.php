<?php

namespace App\Http\Controllers;

use App\Models\Pekerjaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PekerjaanController extends Controller
{
    #fetch
    function fetch()
    {
        $object = Pekerjaan::all();

        $realObject = array();
        foreach ($object as $key) {
            $realObject["pegawai"][] = [
                "id" => $key->id,
                "nama_pekerjaan" => $key->nama_pekerjaan,
                "gaji" => $key->gaji,
                "created_at" => $key->created_at,
                "updated_at" => $key->updated_at,
            ];
        }

        if ($object) {
            return $this->hasSuccessWithData(200, true, 1, "Berhasil Get Data Pekerjaan", $realObject);
        } else {
            return $this->hasFailed(400, false, 0, "Gagal Menambah Pekerjaan");
        }
    }
    #detail pekerjaan
    function detail($id)
    {
        $object = Pekerjaan::find($id);

        if ($object==null) {
            return $this->hasFailed(400, false, 0, "ID Pekerjaan Tidak Ditemukan");
        }

        $realObject = array();
        foreach ($object as $key) {
            $realObject["pekerjaan"] = [
                "id" => $object['id'],
                "nama_pekerjaan" => $object['nama_pekerjaan'],
                "gaji" => $object['gaji'],
            ];
        }

        if ($object) {
            return $this->hasSuccessWithData(200, true, 1, "Berhasil Mendapatkan Data Pekerjaan $object->nama_pekerjaan", $realObject);
        } else {
            return $this->hasFailed(400, false, 0, "Gagal Mendapatkan Data Divisi");
        }
    }
    #cari
    function cari(Request $request)
    {
        $cariAtas=$request->cariAtas;
        $cariBawah=$request->cariBawah;
        $object = Pekerjaan::whereRaw('(gaji >= ? and gaji <= ?)', [$cariAtas, $cariBawah])->get();

        if ($object==null) {
            return $this->hasFailed(400, false, 0, "ID Pekerjaan Tidak Ditemukan");
        }

        $realObject = array();
        foreach ($object as $key) {
            $realObject[][] = [
                "id" => $key->id,
                "nama_pekerjaan" =>  $key->nama_pekerjaan,
                "gaji" =>  $key->gaji,
            ];
        }

        if ($object) {
            return $this->hasSuccessWithData(200, true, 1, "Berhasil Mendapatkan Data Divisi", $realObject);
        } else {
            return $this->hasFailed(400, false, 0, "Gagal Mendapatkan Data Divisi");
        }
    }

    #store
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
                'pekerjaan' => $object,
            ]);
        }else{
            return response()->json([
                'http_response' => 400,
                'status' => 0,
                'message' => 'Gagal menyimpan Pekerjaan',
            ]);
        }
    }
    #update
    function update(Request $request, $id)
    {
        $rules = [
            "nama_pekerjaan" => "required",
            "gaji" => "required|numeric",
        ];

        $customMessages = [
            'required' => 'Mohon Isi Kolom :attribute sebelum melanjutkan'
        ];

        $this->validate($request, $rules, $customMessages);

        $object = Pekerjaan::find($id);

        if ($object == null) {
            $this->hasFailed(400, false, 0, "ID Pekerjaan Tidak Ditemukan");
        }

        $object->nama_pekerjaan = $request->nama_pekerjaan;
        $object->gaji = $request->gaji;
        $object->save();

        if ($object) {
           return $this->hasSuccessWithData(200, true, 1, "Berhasil Mengupdate Pekerjaan", $object);
        } else {
            return $this->hasFailed(400, false, 0, "Gagal Mengupdate Pekerjaan");
        }
    }
    function isPekerjaanExist($id)
    {
        $find = Pekerjaan::find($id);

        if ($find == null) {
            return true;
        }
        return false;
    }
    #delete
    function delete($id)
    {
        if ($this->isPekerjaanExist($id)) {
            return $this->hasFailed(200,false,1,"ID Pekerjaan Tidak Ditemukan");
        }
        $object = Pekerjaan::find($id);

        $object->delete();
        if ($object) {
            return $this->hasSuccess(200, true, 1, "Berhasil Menghapus Pekerjaan $object->name");
        } else {
            return $this->hasFailed(400, false, 0, "Gagal Menghapus Pekerjaan");
        }
    }

    #notif sukses
    function hasSuccessWithData($http_resp, $ok, $status, $message, $data)
    {
        $counter = 1;
        if (is_countable($data)) {
            $counter=count($data);
        }
        return response()->json([
            'http_response' => $http_resp,
            'status' => $status,
            'OK' => $ok,
            'message' => $message,
            'data_size' => $counter,
            'data' => $data,
        ]);
    }
    function hasSuccess($http_resp, $ok, $status, $message)
    {
        return response()->json([
            'http_response' => $http_resp,
            'status' => $status,
            'OK' => $ok,
            'message' => $message,
        ]);
    }
    function hasFailed($http_resp, $ok, $status, $message)
    {
        return response()->json([
            'http_response' => $http_resp,
            'OK' => $ok,
            'status' => $status,
            'message' => $message,
        ]);
    }
}
