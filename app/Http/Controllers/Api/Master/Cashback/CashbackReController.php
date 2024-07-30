<?php

namespace App\Http\Controllers\Api\Master\Cashback;

use App\Models\Pangkalan;

use App\Fungsi\Respon\Respon;
use App\Models\TotalCashback;
use App\Export\CashbackExport;
use App\Models\KitirPenjualan;
use App\Http\Repository\Cashback;
use App\Http\Controllers\Controller;
use App\Models\SyaratCashback;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Repository\Cashback\CashbackReRepository;
use Illuminate\Http\Request;

// use App\Http\Repository\Cashback\CashbackReRepository;

class CashbackReController extends Controller
{
    public function data_cashback_semua_pangkalan_perbulan($bulan, $tahun,$filter="all")
    {
        $data = CashbackReRepository::data_cashback($bulan, $tahun,$filter);
        return Respon::respon($data);
    }


    public static function kirim($bulan, $tahun)
    {
        return self::data_cashback_semua_pangkalan_perbulan($bulan, $tahun);
    }

    public function download($bulan, $tahun)
    {
        $hasil = CashbackReRepository::data_cashback_download($bulan, $tahun);
        return FastExcel($hasil)->download("Cashback_" . $bulan . "_" . $tahun . ".xlsx");
    }

    public function tandai_ok(Request $r)
    {
        $this->validate($r, [
            'id' => 'required',
            'bulan' => 'required',
            'tahun' => 'required',
        ]);

        $syarat= new SyaratCashback();
        $syarat->id_pang = $r->id;
        $syarat->bulan= $r->bulan;
        $syarat->tahun= $r->tahun;
        $syarat->ket= "";
        
try {
    $syarat->save();
    return response()->json([
        'sukses' => true,
        'pesan' => "Tersimpan...",
    ], 201);
    } catch (\Throwable $th) {
        return response()->json([
            'sukses' => false,
            'pesan' => "Gagal...",
        ], 404);
}
       
    }


    public function tandai_batalkan(Request $r)
    {
        $this->validate($r, [
            'id' => 'required',
        ]);

        $syarat= SyaratCashback::whereId($r->id)->first();
try {
    $syarat->delete();
    return response()->json([
        'sukses' => true,
        'pesan' => "Sukses, membatalkan...",
    ], 204);
    } catch (\Throwable $th) {
        return response()->json([
            'sukses' => false,
            'pesan' => "Gagal menghapus...",
        ], 404);
}
       
    }
}
