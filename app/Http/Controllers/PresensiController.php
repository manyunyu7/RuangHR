<?php

namespace App\Http\Controllers;

use App\Models\Presensi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PresensiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $presensi = Presensi::whereBetween('created_at',[Carbon::parse($request->start_date), Carbon::parse($request->end_date)->addDays(1)])->get();
    
        if($presensi){
            return response()->json([
                'http_response' => 200,
                'status' => 1,
                'message' => 'Berhasil Mendapat data Presensi',
                'presensi' => $presensi,
            ]);
        }else{
            return response()->json([
                'http_response' => 400,
                'status' => 0,
                'message' => 'Gagal Mendapat data Presensi',
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $bukti_foto = time().'.'. $request->bukti_foto->extension();

        $request->bukti_foto->move(public_path('/img/Presensi'), $bukti_foto);

        $presensi = Presensi::insert([
            "id_pegawai" => $request->id_pegawai,
            "alasan" => $request->alasan,
            "bukti_foto" => $bukti_foto,
            "status" => $request->status,
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now()
        ]);

        if($presensi){
            return response()->json([
                'http_response' => 200,
                'status' => 1,
                'message' => 'Berhasil Menyimpan Presensi',
                'presensi' => $presensi
            ]);
        }else{
            return response()->json([
                'http_response' => 400,
                'status' => 0,
                'message' => 'Gagal menyimpan Presensi',
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $presensi = Presensi::find($id);

        if($presensi){
            return response()->json([
                'http_response' => 200,
                'status' => 1,
                'message' => 'Berhasil Mencari Presensi',
                'presensi' => $presensi,
            ]);
        }else{
            return response()->json([
                'http_response' => 400,
                'status' => 0,
                'message' => 'Gagal mencari Presensi',
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $presensi = Presensi::where('id', $id)->update([
            'alasan' => $request->alasan,
            'status' => $request->status
        ]);

        if($presensi){
            return response()->json([
                'http_response' => 200,
                'status' => 1,
                'message' => 'Berhasil Edit Presensi',
                'presensi' => Presensi::find($id),
            ]);
        }else{
            return response()->json([
                'http_response' => 400,
                'status' => 0,
                'message' => 'Gagal edit Presensi',
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $presensi = Presensi::find($id)->delete();

        if($presensi){
            return response()->json([
                'http_response' => 200,
                'status' => 1,
                'message' => 'Berhasil Delete Presensi',
                'presensi' => $presensi,
            ]);
        }else{
            return response()->json([
                'http_response' => 400,
                'status' => 0,
                'message' => 'Gagal delete Presensi',
            ]);
        }
    }

    public function fetchAll()
    {
        return response()->json([
            'http_response' => 200,
            'status' => 1,
            'message' => 'Berhasil menampilkan data presensi',
            'presensi' => Presensi::all(),
        ]);
    }
}
