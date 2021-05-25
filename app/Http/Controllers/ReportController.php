<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Pekerjaan;
use App\Models\Report;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    #fetch
    function fetch()
    {
        $object = Report::all();
        if ($object) {
            return $this->hasSuccessWithData(200, true, 1, "Berhasil Get Data Report", $object);
        } else {
            return $this->hasFailed(400, false, 0, "Gagal Mendapatkan Data Record");
        }
    }
    #detail
    function detail($id)
    {
        $object = Report::findOrFail($id);

        if ($object==null) {
            return $this->hasFailed(400, false, 0, "ID Report Tidak Ditemukan");
        }
    
        if ($object) {
            return $this->hasSuccessWithData(200, true, 1, "Berhasil Mendapatkan Data Report $object->nama_pekerjaan", $object);
        } else {
            return $this->hasFailed(400, false, 0, "Gagal Mendapatkan Data Report");
        }
    }

    #store
    function store(Request $request){
        $rules = [
            "id_pelapor" => "required|numeric",
            "id_terlapor" => "required|numeric",
            "isi_laporan" => "required",
        ];

        $customMessages = [
            'required' => 'Mohon Isi Kolom :attribute sebelum melanjutkan'
        ];

        $this->validate($request, $rules, $customMessages);

        $idPelapor = $request->id_pelapor;
        $idTerlapor = $request->id_terlapor;

        if ($request->photo==null) {
            return response()->json([
                'http_response' => 422,
                'status' => 0,
                'message' => 'Foto Tidak Valid, ',
            ],422);    
        }

        if ($this->isPegawaiDoesntExist($idTerlapor)) {
            return response()->json([
                'http_response' => 400,
                'status' => 0,
                'message' => 'ID Pelapor Tidak Ditemukan, ',
            ],400); 
        }
        if ($this->isPegawaiDoesntExist($idTerlapor)) {
            return response()->json([
                'http_response' => 400,
                'status' => 0,
                'message' => 'ID Terlapor Tidak Ditemukan, ',
            ],400); 
        }

        if ($idPelapor == $idTerlapor) {
            return response()->json([
                'http_response' => 400,
                'status' => 0,
                'message' => 'Gagal menyimpan Report, ',
            ],400);
        }

        $photoPath = "";

        if ($request->hasFile('photo')) {

            $file = $request->file('photo');
            $extension = $file->getClientOriginalExtension(); // you can also use file name
            $fileName = time() . '.' . $extension;

            $savePath = "/web_files/report/";
            $savePathDB = "/web_files/report/$fileName";
            $path = public_path() . "$savePath";
            $file->move($path, $fileName);

            $photoPath = $savePathDB;
        }

        $this->validate($request, $rules, $customMessages);


        $object = new Report();
        $object->id_pelapor = $request->id_pelapor;
        $object->id_terlapor = $request->id_terlapor;
        $object->isi_laporan = $request->isi_laporan;
        $object->bukti_foto = $photoPath;
        $object->save();

        if($object){
            return response()->json([
                'http_response' => 200,
                'status' => 1,
                'message' => 'Berhasil Menyimpan Report',
                'pekerjaan' => $object,
            ],200);
        }else{
            return response()->json([
                'http_response' => 400,
                'status' => 0,
                'message' => 'Gagal menyimpan Report',
            ],400);
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

    #update
    function update(Request $request,$id){
        $rules = [
            "id_pelapor" => "required|numeric",
            "id_terlapor" => "required|numeric",
            "isi_laporan" => "required",
        ];

        $customMessages = [
            'required' => 'Mohon Isi Kolom :attribute sebelum melanjutkan'
        ];

        $this->validate($request, $rules, $customMessages);

        $idPelapor = $request->id_pelapor;
        $idTerlapor = $request->id_terlapor;

        if ($this->isPegawaiDoesntExist($idTerlapor)) {
            return response()->json([
                'http_response' => 400,
                'status' => 0,
                'message' => 'ID Pelapor Tidak Ditemukan, ',
            ],400); 
        }
        if ($this->isPegawaiDoesntExist($idTerlapor)) {
            return response()->json([
                'http_response' => 400,
                'status' => 0,
                'message' => 'ID Terlapor Tidak Ditemukan, ',
            ],400); 
        }

        if ($idPelapor == $idTerlapor) {
            return response()->json([
                'http_response' => 400,
                'status' => 0,
                'message' => 'Gagal menyimpan Report, ',
            ],400);
        }

        $photoPath = "";

        if ($request->hasFile('photo')) {

            $file = $request->file('photo');
            $extension = $file->getClientOriginalExtension(); // you can also use file name
            $fileName = time() . '.' . $extension;

            $savePath = "/web_files/report/";
            $savePathDB = "/web_files/report/$fileName";
            $path = public_path() . "$savePath";
            $file->move($path, $fileName);

            $photoPath = $savePathDB;
        }

        $this->validate($request, $rules, $customMessages);

        $object = Report::findOrFail($id);
        $object->id_pelapor = $request->id_pelapor;
        $object->id_terlapor = $request->id_terlapor;
        $object->isi_laporan = $request->isi_laporan;
        $object->bukti_foto = $photoPath;
        $object->save();

        if($object){
            return response()->json([
                'http_response' => 200,
                'status' => 1,
                'message' => 'Berhasil Mengupdate Pekerjaan',
                'report' => $object,
            ],200);
        }else{
            return response()->json([
                'http_response' => 400,
                'status' => 0,
                'report' => 'Gagal Mengupdate Pekerjaan',
            ],400);
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
        $object = Report::findOrFail($id);
        $file_path = public_path() . $object->bukti_foto;
        if (file_exists($file_path)) {
            try {
                unlink($file_path);
            } catch (Exception $e) {
                //Do Nothing
            }
        }
        $object->delete();
        if ($object) {
            return $this->hasSuccess(200, true, 1, "Berhasil Menghapus Report");
        } else {
            return $this->hasFailed(400, false, 0, "Gagal Menghapus Report");
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
