<?php

namespace App\Http\Controllers\Api\Master\Cashback;

use App\Models\Pangkalan;
use Illuminate\Http\Request;
use App\Fungsi\Respon\Respon;
use App\Models\TotalCashback;
use App\Models\KitirPenjualan;
use App\Http\Controllers\Controller;

class CashbackReController extends Controller
{
    public function data_cashback_semua_pangkalan_perbulan($bulan, $tahun)
    {
        // $bulan=date("Y-m-d H:i:s",strtotime("2024-".$bulan."-1 10:10:10"));
        $pangkalan = Pangkalan::with('jenis_cashback:id,status,id_pang,nama_cashback_id','jenis_cashback.nama_cashback:id,nama,jumlah')
            ->whereRelation('jenis_cashback', 'status', '=', 'aktif')
            ->get();

        $pang = array();
        foreach ($pangkalan as $p) {
            $penjualan = KitirPenjualan::whereYear('tanggal', '=', $tahun)
            ->join('cashback','kitir_penjualan.id','=','cashback.kitir_penjualan_id')
                ->whereMonth('tanggal', '=', $bulan)
                ->where('id_pang', '=', $p['id_pang'])
                ->get();
            if(count($penjualan)===0){continue;}
            $total = TotalCashback::where('tahun', '=', $tahun)
                ->where('bulan', '=', $bulan)
                ->where('id_pang', '=', $p['id_pang'])
                ->first();

            $pang[] = [
                "id_pang" => $p['id_pang'],
                "pangkalan" => $p['nama'],
                "status" => $p['jenis_cashback']['status'],
                "nama_cashback" => $p['jenis_cashback']['nama_cashback']['nama'],
                "besaran_cashback" => $p['jenis_cashback']['nama_cashback']['jumlah'],
                "bayar" => $total,
                "penjualan" => $penjualan,
            ];
        }
        return Respon::respon($pang);
    }
}
