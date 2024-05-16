<?php

namespace App\Http\Controllers\Api\Master\Cashback;

use App\Models\Pangkalan;
use Illuminate\Http\Request;
use App\Fungsi\Respon\Respon;
use App\Models\TotalCashback;
use App\Export\CashbackExport;
use App\Models\KitirPenjualan;
use App\Http\Repository\Cashback;
use App\Http\Controllers\Controller;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Repository\Cashback\CashbackReRepository;

// use App\Http\Repository\Cashback\CashbackReRepository;

class CashbackReController extends Controller
{
    public function data_cashback_semua_pangkalan_perbulan($bulan, $tahun)
    {
        $data=CashbackReRepository::data_cashback($bulan,$tahun);
        return Respon::respon($data);
    }


    public static function kirim($bulan,$tahun){
        return self::data_cashback_semua_pangkalan_perbulan($bulan,$tahun);
    }

    public function download($bulan,$tahun)
    {
        $hasil=CashbackReRepository::data_cashback_download($bulan,$tahun);
        return FastExcel($hasil)->download("Cashback_".$bulan."_".$tahun.".xlsx");
    }
}
