<?php

namespace App\Http\Controllers;

use App\Models\Bonus;
use App\Models\Divisi;
use App\Models\Pegawai;
use Illuminate\Http\Request;

class BonusController extends Controller
{

    function fetch()
    {
        $object = Bonus::all();

        if ($object) {
            return $this->hasSuccessWithData(200, true, 1, "Berhasil Get Data Bonus", $object);
        } else {
            return $this->hasFailed(400, false, 0, "Gagal Menambah Bonus");
        }
    }


    function fetchByID($id)
    {
        $object = Bonus::find($id);

        if ($object == null) {
            return $this->hasFailed(400, false, 0, "ID Bonus Tidak Ditemukan");
        }

    
        if ($object) {
            return $this->hasSuccessWithData(200, true, 1, "Berhasil Mendapatkan Data Bonus",$object);
        } else {
            return $this->hasFailed(400, false, 0, "Gagal Mendapatkan Data Bonus");
        }
    }

    function cari(Request $request)
    {
        $object = Bonus::all();
        $id_pemberi = $request->id_pemberi;

        $id_penerima = $request->id_penerima;
        if ($id_pemberi!=null) {
            $object = Bonus::where('id_pemberi','=',$id_pemberi)->get();
        }
        if ($id_penerima!=null) {
            $object = Bonus::where('id_penerima','=',$id_penerima)->get();
        }
        
        if ($object) {
            return $this->hasSuccessWithData(200, true, 1, "Berhasil Mendapatkan Data Bonus",$object);
        } else {
            return $this->hasFailed(400, false, 0, "Gagal Mendapatkan Data Bonus");
        }
    }


    function store(Request $request)
    {
        $rules = [
            "nama_bonus" => "required",
            "deskripsi_bonus" => "required",
            "jumlah" => "required",
            "id_pemberi" => "required",
            "id_penerima" => "required",
        ];

        $customMessages = [
            'required' => 'Mohon Isi Kolom :attribute sebelum melanjutkan'
        ];

        $this->validate($request, $rules, $customMessages);

        if ($this->isKaryawanDoesntExist($request->id_pemberi)) {
            return $this->hasFailed(400, false, 0, "ID Pemberi Tidak Ditemukan di Database HR");
        }
        if ($this->isKaryawanDoesntExist($request->id_penerima)) {
            return $this->hasFailed(400, false, 0, "ID Penerima Tidak Ditemukan di Database HR");
        }

        $object = new Bonus();
        $object->nama_bonus = $request->nama_bonus;
        $object->deskripsi_bonus = $request->deskripsi_bonus;
        $object->jumlah = $request->jumlah;
        $object->id_pemberi = $request->id_pemberi;
        $object->id_penerima = $request->id_penerima;
        $object->save();

        if ($object) {
            return $this->hasSuccessWithData(200, true, 1, "Berhasil Menyimpan Data Bonus", $object);
        } else {
            return $this->hasFailed(400, false, 0, "Gagal Menyimpan Data Bonus");
        }
    }


    /*
    Fungsi ini digunakan untuk mengupdate data bonus
    */
    function update(Request $request, $id)
    {
        $rules = [
            "nama_bonus" => "required",
            "deskripsi_bonus" => "required",
            "jumlah" => "required",
            "id_pemberi" => "required",
            "id_penerima" => "required",
        ];

        $customMessages = [
            'required' => 'Mohon Isi Kolom :attribute sebelum melanjutkan'
        ];

        $this->validate($request, $rules, $customMessages);

        $object = Bonus::find($id);

        if ($object == null) {
            return $this->hasFailed(400, false, 0, "ID Bonus Tidak Ditemukan");
        }

        if ($this->isKaryawanDoesntExist($request->id_pemberi)) {
            return $this->hasFailed(400, false, 0, "ID Pemberi Tidak Ditemukan di Database HR");
        }
        if ($this->isKaryawanDoesntExist($request->id_penerima)) {
            return $this->hasFailed(400, false, 0, "ID Penerima Tidak Ditemukan di Database HR");
        }

        $object->nama_bonus = $request->nama_bonus;
        $object->deskripsi_bonus = $request->deskripsi_bonus;
        $object->jumlah = $request->jumlah;
        $object->id_pemberi = $request->id_pemberi;
        $object->id_penerima = $request->id_penerima;
        $object->save();

        if ($object) {
            return $this->hasSuccessWithData(200, true, 1, "Berhasil Mengupdate Data Bonus", $object);
        } else {
            return $this->hasFailed(400, false, 0, "Gagal Mengupdate Data Bonus");
        }
    }

    function isKaryawanDoesntExist($id)
    {
        $find = Pegawai::find($id);

        if ($find == null) {
            return true;
        }
        return false;
    }
    function isDivisiExist($id)
    {
        $find = Divisi::find($id);

        if ($find == null) {
            return true;
        }
        return false;
    }

    function delete($id)
    {
        $object = Bonus::find($id);
        if ($object==null) {
            return $this->hasFailed(400, false, 0, "ID Bonus Tidak Ditemukan");
        }
        $object->delete();
        if ($object) {
            return $this->hasSuccess(200, true, 1, "Berhasil Menghapus Data Bonus");
        } else {
            return $this->hasFailed(400, false, 0, "Gagal Menghapus Data Bonus");
        }
    }


    function hasSuccessWithData($http_resp, $ok, $status, $message, $data)
    {
        $counter = 1;
        if (is_countable($data)) {
            $counter = count($data);
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
