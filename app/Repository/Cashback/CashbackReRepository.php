<?php

namespace App\Repository\Cashback;

use App\Models\Pangkalan;
use App\Models\TotalCashback;
use App\Models\KitirPenjualan;
use App\Models\SyaratCashback;

class CashbackReRepository
{
    public static function data_cashback($bulan, $tahun, $filter = "all", $status_bayar = "all")
    {
        // $bulan=date("Y-m-d H:i:s",strtotime("2024-".$bulan."-1 10:10:10"));

        $rekap = Pangkalan::query();
        $rekap->select(
            'pangkalan.id_pang',
            'pangkalan.nama',
            'jenis_cashback.status',
            'nama_cashback.nama as nama_cashback',
            'nama_cashback.jumlah',
            'pangkalan.norek',
            'pangkalan.nama_rek',
            'pangkalan.nama_bank',
        );

        $rekap->join('jenis_cashback', 'jenis_cashback.id_pang', '=', 'pangkalan.id_pang');
        $rekap->join('nama_cashback', 'nama_cashback.id', '=', 'jenis_cashback.nama_cashback_id');
        $rekap->where('jenis_cashback.status', '=', 'aktif');
        $rekap->orderBy("pangkalan.nama");
        // $rekap->orderBy('pangkalan.id_pang');

        $pangkalan = $rekap->get();


        $pang = array();
        foreach ($pangkalan as $p) {


            $syarat_cek = SyaratCashback::where('id_pang', $p['id_pang'])
                ->where('bulan', $bulan)
                ->where('tahun', $tahun)
                ->first();

            $penjualan = KitirPenjualan::whereYear('tanggal', '=', $tahun)
                ->join('cashback', 'kitir_penjualan.id', '=', 'cashback.kitir_penjualan_id')
                ->whereMonth('tanggal', '=', $bulan)
                ->where('id_pang', '=', $p['id_pang'])
                ->get();
            if (count($penjualan) === 0) {
                continue;
            }
            $total = TotalCashback::where('tahun', '=', $tahun)
                ->where('bulan', '=', $bulan)
                ->where('id_pang', '=', $p['id_pang'])
                ->first();

            if ($status_bayar == "sudah-bayar") {
                if ($total == NULL) {
                    continue;
                } else {
                }
            }

            if ($status_bayar == "belum-bayar") {
                if ($total == NULL) {
                } else {
                    continue;
                }
            }

            if ($filter == "syarat-ok") {
                if ($syarat_cek  && !$total) {
                } else {
                    continue;
                }
            }

            if ($syarat_cek && !$total) {   //jika ada sarat DAN total tidak ditemukan
                $syarat = "<font color=#009349><b>Syarat &#x2705 </b></font>";
            } else {
                $syarat = "";
            }

            $pang[] = [
                "id_pang" => $p['id_pang'],
                "pangkalan" => $p['nama'],
                "no_rek" => $p['norek'],
                "nama_rek" => $p['nama_rek'],
                "nama_bank" => $p['nama_bank'],
                "status" => $p['status'],
                "nama_cashback" => $syarat . $p['nama_cashback'],
                "besaran_cashback" => $p['jumlah'],
                "bayar" => $total,
                "penjualan" => $penjualan,
            ];
        }

        return $pang;
    }

    public static function data_cashback_download($bulan, $tahun)
    {
        // $bulan=date("Y-m-d H:i:s",strtotime("2024-".$bulan."-1 10:10:10"));
        $rekap = Pangkalan::query();
        $rekap->select(
            'pangkalan.id_pang',
            'pangkalan.nama',
            'jenis_cashback.status',
            'nama_cashback.nama as nama_cashback',
            'nama_cashback.jumlah',
            'pangkalan.norek',
            'pangkalan.nama_rek',
        );

        $rekap->join('jenis_cashback', 'jenis_cashback.id_pang', '=', 'pangkalan.id_pang');
        $rekap->join('nama_cashback', 'nama_cashback.id', '=', 'jenis_cashback.nama_cashback_id');
        $rekap->where('jenis_cashback.status', '=', 'aktif');

        $pangkalan = $rekap->get();

        $pang = array();
        foreach ($pangkalan as $p) {
            $penjualan = KitirPenjualan::whereYear('tanggal', '=', $tahun)
                ->join('cashback', 'kitir_penjualan.id', '=', 'cashback.kitir_penjualan_id')
                ->whereMonth('tanggal', '=', $bulan)
                ->where('id_pang', '=', $p['id_pang'])
                ->get();
            if (count($penjualan) === 0) {
                continue;
            }
            $total = TotalCashback::where('tahun', '=', $tahun)
                ->where('bulan', '=', $bulan)
                ->where('id_pang', '=', $p['id_pang'])
                ->first();
            $sudah_bayar = "Sudah dibayar";
            if (!$total) {
                $total['jumlah'] = "";
                $sudah_bayar = "";
            }

            $pen = "";
            $total_hitung = 0;
            foreach ($penjualan as $jual) {
                $pen .= $jual['jumlah'] . ",";
                $total_hitung = $total_hitung + $jual['jumlah'];
            }
            $pang[] = [
                "No Pangkalan" => $p['id_pang'],
                "Pangkalan" => $p['nama'],
                "Status Bayar" => $sudah_bayar,
                "Nama Cahback" => ['nama_cashback'],
                "Besaran" => $p['jumlah'],
                "Perhitungan" => $total_hitung *  $p['jumlah'],
                "Penjualan" => $pen,
                "Total" => $total_hitung,
                "Lunas" => $total['jumlah'],
            ];
        }

        return $pang;
    }
}
