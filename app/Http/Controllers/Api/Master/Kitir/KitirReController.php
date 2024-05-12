<?php

namespace App\Http\Controllers\Api\Master\Kitir;

use App\Models\Kitir;
use Illuminate\Http\Request;
use App\Fungsi\Respon\Respon;
use App\Http\Controllers\Controller;

class KitirReController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function kitir_pecah($tanggal)
    {
        $kitir_pecah = Kitir::with('pangkalan:id_pang,nama','bagi_pangkalan:id_bp,id_k,id_u', 'kitir_pecah:id,jumlah,id_k,kitir_penjualan_id', 'kitir_pecah.penjualan:id,tanggal,jumlah,harga,id_pang', 'kitir_pecah.penjualan.pangkalan:id_pang,nama', 'kitir_pecah.penjualan.briva:id_briva,kitir_penjualan_ID,jumlah_bayar,ket,tanggal_tf,status_bayar')
            ->where('tanggal', '=', $tanggal)
            ->orderBy("id_pang")
            ->get();
        return Respon::respon($kitir_pecah);
    }

    public function kitir_pecah_tgl_masuk($tanggal)
    {
        $kitir_pecah = Kitir::with('pangkalan:id_pang,nama','bagi_pangkalan:id_bp,id_k,id_u', 'kitir_pecah:id,jumlah,id_k,kitir_penjualan_id', 'kitir_pecah.penjualan:id,tanggal,jumlah,harga,id_pang', 'kitir_pecah.penjualan.pangkalan:id_pang,nama', 'kitir_pecah.penjualan.briva:id_briva,kitir_penjualan_ID,jumlah_bayar,ket,tanggal_tf,status_bayar')
            ->where('tgl_masuk', '=', $tanggal)
            ->orderBy("id_pang")
            ->get();
        return Respon::respon($kitir_pecah);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
