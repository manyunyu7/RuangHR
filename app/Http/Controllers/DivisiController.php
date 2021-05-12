<?php

namespace App\Http\Controllers;

use App\Models\Divisi;
use App\Models\Pegawai;
use Illuminate\Http\Request;

class DivisiController extends Controller
{

    function fetch()
    {
        $object = Divisi::all();

        $realObject = array();
        foreach ($object as $key) {
            $realObject["divisi"][] = [
                "id" => $key->id,
                "nama_divisi" => $key->nama_divisi,
                "lead_divisi" => Pegawai::find($key->lead_divisi),
                "co_lead_divisi" => Pegawai::find($key->co_lead_divisi),
                "kontak_divisi" => $key->kontak_divisi,
                "alamat_divisi" => $key->alamat_divisi,
                "email_divisi" => $key->email_divisi,
                "created_at" => $key->created_at,
                "updated_at" => $key->updated_at,
            ];
        }

        if ($object) {
            return $this->hasSuccessWithData(200, true, 1, "Berhasil Get Data Divisi", $realObject);
        } else {
            return $this->hasFailed(400, false, 0, "Gagal Menambah Divisi");
        }
    }


    function fetchByID($id)
    {
        $object = Divisi::find($id);

        if ($object==null) {
            return $this->hasFailed(400, false, 0, "ID Divisi Tidak Ditemukan");
        }

        $realObject = array();
        foreach ($object as $key) {
            $realObject["divisi"] = [
                "id" => $object['id'],
                "nama_divisi" => $object['nama_divisi'],
                "lead_divisi" => Pegawai::find($object['lead_divisi']),
                "co_lead_divisi" => Pegawai::find($object['co_lead_divisi']),
                "kontak_divisi" => $object['kontak_divisi'],
                "alamat_divisi" => $object['alamat_divisi'],
                "email_divisi" => $object['email_divisi'],
                "created_at" => $object['created_at'],
                "updated_at" => $object['updated_at'],
            ];
        }

        if ($object) {
            return $this->hasSuccessWithData(200, true, 1, "Berhasil Mendapatkan Data Divisi $object->nama_divisi", $realObject);
        } else {
            return $this->hasFailed(400, false, 0, "Gagal Mendapatkan Data Divisi");
        }
    }


    function storeDivisi(Request $request)
    {
        $rules = [
            "nama_divisi" => "required",
            "lead_divisi" => "required",
            "co_lead_divisi" => "required",
            "kontak_divisi" => "required",
            "email_divisi" => "required",
            "alamat_divisi" => "required",
        ];

        $customMessages = [
            'required' => 'Mohon Isi Kolom :attribute sebelum melanjutkan'
        ];

        $this->validate($request, $rules, $customMessages);

        if ($this->isKaryawanDoesntExist($request->co_lead_divisi)) {
            return $this->hasFailed(400, false, 0, "ID Co Lead Tidak Ditemukan di Database HR");
        }
        if ($this->isKaryawanDoesntExist($request->lead_divisi)) {
            return $this->hasFailed(400, false, 0, "ID Lead Tidak Ditemukan di Database HR");
        }

        $object = new Divisi();
        $object->nama_divisi = $request->nama_divisi;
        $object->lead_divisi = $request->lead_divisi;
        $object->co_lead_divisi = $request->co_lead_divisi;
        $object->kontak_divisi = $request->kontak_divisi;
        $object->email_divisi = $request->email_divisi;
        $object->alamat_divisi = $request->alamat_divisi;
        $object->save();

        if ($object) {
            return $this->hasSuccessWithData(200, true, 1, "Berhasil Menambah Divisi", $object);
        } else {
            return $this->hasFailed(400, false, 0, "Gagal Menyimpan Divisi");
        }
    }


    /*
    Fungsi ini digunakan untuk mengupdate data divisi
    */
    function update(Request $request, $id)
    {
        $rules = [
            "nama_divisi" => "required",
            "lead_divisi" => "required",
            "co_lead_divisi" => "required",
            "kontak_divisi" => "required",
            "email_divisi" => "required",
            "alamat_divisi" => "required",
        ];

        $customMessages = [
            'required' => 'Mohon Isi Kolom :attribute sebelum melanjutkan'
        ];

        $this->validate($request, $rules, $customMessages);

        if ($this->isKaryawanDoesntExist($request->co_lead_divisi)) {
            return $this->hasFailed(400, false, 0, "ID Karyawan Untuk Co Lead Divisi Tidak Ditemukan di Database HR");
        }

        if ($this->isKaryawanDoesntExist($request->lead_divisi)) {
            return $this->hasFailed(400, false, 0, "ID Karyawan Untuk Lead Divisi Tidak Ditemukan di Database HR");
        }

        $object = Divisi::find($id);

        if ($object == null) {
            return $this->hasFailed(400, false, 0, "ID Divisi Tidak Ditemukan");
        }

        $object->nama_divisi = $request->nama_divisi;
        $object->lead_divisi = $request->lead_divisi;
        $object->co_lead_divisi = $request->co_lead_divisi;
        $object->kontak_divisi = $request->kontak_divisi;
        $object->email_divisi = $request->email_divisi;
        $object->alamat_divisi = $request->alamat_divisi;
        $object->save();

        if ($object) {
           return $this->hasSuccessWithData(200, true, 1, "Berhasil Mengupdate Divisi", $object);
        } else {
            return $this->hasFailed(400, false, 0, "Gagal Mengupdate Divisi");
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
        
        if ($this->isDivisiExist($id)) {
            return $this->hasFailed(200,false,1,"ID Divisi Tidak Ditemukan");
        }
        $object = Divisi::find($id);

        $object->delete();
        if ($object) {
            return $this->hasSuccess(200, true, 1, "Berhasil Menghapus Divisi $object->name");
        } else {
            return $this->hasFailed(400, false, 0, "Gagal Menghapus Divisi");
        }
    }


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
