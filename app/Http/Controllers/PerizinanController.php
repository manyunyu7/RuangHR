<?php

namespace App\Http\Controllers;

use App\Models\Perizinan;
use Carbon\Carbon;
use Illuminate\Http\Request;


class PerizinanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $perizinan = Perizinan::whereBetween('created_at',[Carbon::parse($request->start_date), Carbon::parse($request->end_date)])->get();
    
        if($perizinan){
            return response()->json([
                'http_response' => 200,
                'status' => 1,
                'message' => 'Berhasil Mendapat data Perizinan',
                'perizinan' => $perizinan,
            ]);
        }else{
            return response()->json([
                'http_response' => 400,
                'status' => 0,
                'message' => 'Gagal Mendapat data Perizinan',
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
        $bukti_foto = time() . '.' . $request->bukti_foto->extension();

        $request->bukti_foto->move(public_path('img/perizinan'), $bukti_foto);

        $perizinan = Perizinan::insert([
            "id_pegawai" => $request->id_pegawai,
            "alasan" => $request->alasan,
            "bukti_foto" => $bukti_foto,
            "status" => $request->status,
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now()

        ]);

        if($perizinan){
            return response()->json([
                'http_response' => 200,
                'status' => 1,
                'message' => 'Berhasil Menyimpan Perizinan',
                'perizinan' => $perizinan,
            ]);
        }else{
            return response()->json([
                'http_response' => 400,
                'status' => 0,
                'message' => 'Gagal menyimpan Perizinan',
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
        $perizinan = Perizinan::find($id);

        if($perizinan){
            return response()->json([
                'http_response' => 200,
                'status' => 1,
                'message' => 'Berhasil Mencari Perizinan',
                'perizinan' => $perizinan,
            ]);
        }else{
            return response()->json([
                'http_response' => 400,
                'status' => 0,
                'message' => 'Gagal mencari Perizinan',
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

            $perizinan = Perizinan::where('id', $id)->update([
                'alasan' => $request->alasan,
                'status' => $request->status
            ]);

        
        if($perizinan){
            return response()->json([
                'http_response' => 200,
                'status' => 1,
                'message' => 'Berhasil Edit Perizinan',
                'perizinan' => Perizinan::find($id),
            ]);
        }else{
            return response()->json([
                'http_response' => 400,
                'status' => 0,
                'message' => 'Gagal edit Perizinan',
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
        $perizinan = Perizinan::find($id)->delete();

        if($perizinan){
            return response()->json([
                'http_response' => 200,
                'status' => 1,
                'message' => 'Berhasil Delete Perizinan',
                'perizinan' => $perizinan,
            ]);
        }else{
            return response()->json([
                'http_response' => 400,
                'status' => 0,
                'message' => 'Gagal delete Perizinan',
            ]);
        }
    }

    public function fetchAll()
    {
        return response()->json([
            'http_response' => 200,
            'status' => 1,
            'message' => 'Berhasil menampilkan data perizinan',
            'perizinan' => Perizinan::all(),
        ]);
    }
}
