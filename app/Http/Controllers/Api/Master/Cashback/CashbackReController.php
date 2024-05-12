<?php

namespace App\Http\Controllers\Api\Master\Cashback;

use App\Http\Controllers\Controller;
use App\Models\KitirPenjualan;
use App\Models\Pangkalan;
use App\Models\TotalCashback;
use Illuminate\Http\Request;

class CashbackReController extends Controller
{
    public function data_cashback_semua_pangkalan_perbulan($bulan, $tahun)
    {
        // $bulan=date("Y-m-d H:i:s",strtotime("2024-".$bulan."-1 10:10:10"));
        $pangkalan = Pangkalan::with('jenis_cashback:id,status,id_pang')
            ->whereRelation('jenis_cashback', 'status', '=', 'aktif')
            ->get();

        $pang = array();
        foreach ($pangkalan as $p) {
            $penjualan = KitirPenjualan::whereYear('tanggal', '=', $tahun)
                ->whereMonth('tanggal', '=', $bulan)
                ->where('id_pang','=',$p['id_pang'])
                ->get();

            $total=TotalCashback::where('tahun', '=', $tahun)
            ->where('bulan', '=', $bulan)
            ->where('id_pang','=',$p['id_pang'])
            ->get();    

            $pang[] = [
                "pangkalan" => $p['nama'],
                "bayar" => $total,
                "penjualan" => $penjualan,
            ];
        }

        return $pang;
    }
}
