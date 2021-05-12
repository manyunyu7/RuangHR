<?php

namespace App\Http\Controllers;

use App\Models\Divisi;
use App\Models\Pegawai;
use App\Models\Pekerjaan;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class PegawaiController extends Controller
{

    function store(Request $request)
    {

        $rules = [
            "nama_depan" => "required",
            "nama_belakang" => "required",
            "email" => "required|email",
            "no_hp" => "required|numeric",
            "gender" => "required",
            "alamat" => "required",
            "tanggal_masuk" => "required|date_format:Y-m-d",
            "tanggal_lahir" => "required|date_format:Y-m-d|",
            "id_pekerjaan" => "numeric",
        ];

        $customMessages = [
            'required' => 'Mohon Isi Kolom :attribute sebelum melanjutkan',
            'email' => 'Mohon Isi Kolom :attribute dengan email yang valid',
            'numeric' => 'Mohon Isi Kolom :attribute dengan angka yang valid',
            'date_format' => 'Sesuaikan Format Tanggal dengan format Y-m-d misal 2020/08/24',
            'max' => 'Ukuran File Maximal 1 MB',
        ];

        $checkEmail = Pegawai::where('email', '=', $request->email)->count();

        if ($checkEmail) {
            return $this->hasFailed(422, false, 0, "Gagal Menyimpan Karyawan, Email Sudah Digunakan, Silakan Gunakan Email Lain atau update email pegawai");
        }


        $photoPath = "";

        if ($request->hasFile('photo')) {

            $file = $request->file('photo');
            $extension = $file->getClientOriginalExtension(); // you can also use file name
            $fileName = time() . '.' . $extension;

            $savePath = "/web_files/user_profile/";
            $savePathDB = "/web_files/user_profile/$fileName";
            $path = public_path() . "$savePath";
            $file->move($path, $fileName);

            $photoPath = $savePathDB;
        }

        $this->validate($request, $rules, $customMessages);

        $object = new Pegawai();
        $object->nama_depan = $request->nama_depan;
        $object->nama_belakang = $request->nama_belakang;
        $object->no_hp = $request->no_hp;
        $object->gender = $request->gender;
        $object->alamat = $request->alamat;
        $object->email = $request->email;
        $object->photo_path = $photoPath;
        $object->tanggal_masuk = $request->tanggal_masuk;
        $object->tanggal_lahir = $request->tanggal_lahir;
        $object->id_pekerjaan = $request->id_pekerjaan;
        $object->save();

        if ($object) {
            return $this->hasSuccessWithData(200, true, 1, "Berhasil Menambah Karyawan", $object);
        } else {
            return $this->hasFailed(400, false, 0, "Gagal Menyimpan Karyawan");
        }
    }

    function delete($id)
    {
        if ($this->isPegawaiDoesntExist($id)) {
            return $this->hasFailed(200, false, 1, "ID Pegawai Tidak Ditemukan");
        }
        $object = Pegawai::find($id);
        $object->delete();
        if ($object) {
            return $this->hasSuccess(200, true, 1, "Berhasil Menghapus Pegawai $object->nama_depan $object->nama_belakang");
        } else {
            return $this->hasFailed(400, false, 0, "Gagal Menghapus Pegawai");
        }
    }

    function update(Request $request, $id)
    {

        $rules = [
            "nama_depan" => "required",
            "nama_belakang" => "required",
            "email" => "required|email",
            "no_hp" => "required|numeric",
            "gender" => "required",
            "alamat" => "required",
            "tanggal_masuk" => "required|date_format:Y-m-d",
            "tanggal_lahir" => "required|date_format:Y-m-d|",
            "id_pekerjaan" => "numeric",
        ];

        $customMessages = [
            'required' => 'Mohon Isi Kolom :attribute sebelum melanjutkan',
            'email' => 'Mohon Isi Kolom :attribute dengan email yang valid',
            'numeric' => 'Mohon Isi Kolom :attribute dengan angka yang valid',
            'date_format' => 'Sesuaikan Format Tanggal dengan format Y-m-d misal 2020/08/24',
            'max' => 'Ukuran File Maximal 1 MB',
        ];

        $object = Pegawai::find($id);

        if ($object == null) {
            return $this->hasFailed(422, false, 0, "Gagal Mengupdate Karyawan, Data Karyawan Tidak Ditemukan");
        }

        $pekerjaan = Pekerjaan::find($request->id_pekerjaan);
        if ($pekerjaan == null) {
            return $this->hasFailed(400, false, 0, "ID Pekerjaan Tidak Ditemukan");
        }
        $divisi = Divisi::find($request->id_divisi);
        if ($divisi == null) {
            return $this->hasFailed(400, false, 0, "ID Divisi Tidak Ditemukan");
        }



        $checkEmail = Pegawai::where('id', '<>', $id)
            ->where('email', '==', $request->email)
            ->count();


        if ($checkEmail > 1) {
            return $this->hasFailed(422, false, 0, "Gagal Mengupdate Karyawan, Email Sudah Digunakan, Silakan Gunakan Email Lain atau update email pegawai");
        }


        $photoPath = "";

        if ($request->hasFile('photo')) {

            $file_path = public_path() . $object->photo_path;
            if (file_exists($file_path)) {
                try {
                    unlink($file_path);
                } catch (Exception $e) {
                    //Do Nothing
                }
            }


            $file = $request->file('photo');
            $extension = $file->getClientOriginalExtension(); // you can also use file name
            $fileName = time() . '.' . $extension;

            $savePath = "/web_files/user_profile/";
            $savePathDB = "/web_files/user_profile/$fileName";
            $path = public_path() . "$savePath";
            $file->move($path, $fileName);

            $photoPath = $savePathDB;
        }

        $this->validate($request, $rules, $customMessages);

        $object = Pegawai::find($id);
        $object->nama_depan = $request->nama_depan;
        $object->nama_belakang = $request->nama_belakang;
        $object->no_hp = $request->no_hp;
        $object->gender = $request->gender;
        $object->alamat = $request->alamat;
        $object->email = $request->email;
        $object->photo_path = $photoPath;
        $object->tanggal_masuk = $request->tanggal_masuk;
        $object->tanggal_lahir = $request->tanggal_lahir;
        $object->id_pekerjaan = $request->id_pekerjaan;
        $object->id_divisi = $request->id_divisi;
        $object->save();

        if ($object) {
            return $this->hasSuccessWithData(200, true, 1, "Berhasil Mengupdate Karyawan", $object);
        } else {
            return $this->hasFailed(400, false, 0, "Gagal  Mengupdate Karyawan");
        }
    }

    function fetchAll(Request $request)
    {
        $paginate = $request->paginate;
        $pageNumber = $request->page_number;
        $object = Pegawai::paginate($paginate, ['*'], 'page', $pageNumber);

        if ($object == null) {
            return $this->hasFailed(400, false, 0, "Belum Ada Data Pegawai");
        }

        $myResponse = array();
        $myResponse["pagination"] = [
            "per_page" => $paginate,
            "page_number" => $pageNumber,
        ];
        $myResponse["pegawai"] = $object;

        if ($object) {
            return $this->hasSuccessWithData(200, true, 1, "Berhasil Mendapatkan Data Pegawai", $myResponse);
        } else {
            return $this->hasFailed(400, false, 0, "Gagal Mendapatkan Data Pegawai");
        }
    }

    function fetchByID($id)
    {
        $object = Pegawai::find($id);

        if ($object == null) {
            return $this->hasFailed(400, false, 0, "ID Pegawai Tidak Ditemukan");
        }

        if ($object) {
            return $this->hasSuccessWithData(200, true, 1, "Berhasil Mendapatkan Data Pegawai $object->nama_divisi", $object);
        } else {
            return $this->hasFailed(400, false, 0, "Gagal Mendapatkan Data Pegawai");
        }
    }

    function search(Request $request)
    {
        $search = $request->search;
        $object =
            Pegawai::whereRaw('(nama_depan = ? or nama_belakang like ? or alamat like ? or email like ?)', [$search, '%' . $search . '%', '%' . $search . '%', '%' . $search . '%'])->get();

        if ($object == null) {
            return $this->hasFailed(400, false, 0, "ID Divisi Tidak Ditemukan");
        }

        if ($object) {
            return $this->hasSuccessWithData(200, true, 1, "Berhasil Mendapatkan Data Pegawai", $object);
        } else {
            return $this->hasFailed(400, false, 0, "Gagal Mendapatkan Data Divisi");
        }
    }

    function isPegawaiDoesntExist($id)
    {
        $pegawai = Pegawai::find($id);
        if ($pegawai == null) {
            return true;
        } else {
            return false;
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
