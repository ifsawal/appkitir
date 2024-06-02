<?php

namespace App\Repository\Kitir;

use App\Models\Kitir;



class LaporanPenjualanPecahRepository
{

    public static function laporan_pecah_repository($bulan, $tahun)
    {
        $kitir = Kitir::with(
            "pangkalan:id_pang,nama",
            "kitir_briva:id_briva,id_k,jumlah_bayar,status_bayar",
            "kitir_pecah:id,jumlah,id_k,kitir_penjualan_id",
            "kitir_pecah.penjualan:id,id_pang,jumlah",
            "kitir_pecah.penjualan.pangkalan:id_pang,nama",
            "kitir_pecah.penjualan.briva:id_briva,jumlah_bayar,ket,tanggal_tf,status_bayar,kitir_penjualan_ID"
        )
            ->whereMonth("tanggal", $bulan)
            ->whereYear("tanggal", $tahun)
            ->orderBy('tanggal')
            ->get();

        if (count($kitir) === 0) {
            return false;
        } else {
            "";
        }

        $belumterjualperpangkalan = 0;
        $terjual_masi_sisa = 0;
        foreach ($kitir as $k) {

            $jumlah_pec = 0;
            foreach ($k['kitir_pecah'] as $pec) {
                $jumlah_pec = $jumlah_pec + $pec['jumlah'];
            }

            if (!$k['kitir_briva']) {  //jika tida ada penjualan sesuai kitir. maka proses
                if (count($k['kitir_pecah']) == 0) {
                    $belumterjualperpangkalan++;
                }
                if ($k['jumlah'] !== $jumlah_pec and count($k['kitir_pecah']) !== 0) {
                    $terjual_masi_sisa++;
                }
            }
        }

        return $hasil = [
            "belumterjual" => $belumterjualperpangkalan,
            "belumterjual_ada_sisa" => $terjual_masi_sisa,
            "total_pangkalan_belum_terjual" => $belumterjualperpangkalan + $terjual_masi_sisa,
            "detil" => $kitir
        ];
    }
}
