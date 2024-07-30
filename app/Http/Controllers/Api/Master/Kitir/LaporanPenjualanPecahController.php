<?php

namespace App\Http\Controllers\Api\Master\Kitir;

use App\Models\Kitir;
use Illuminate\Http\Request;
use App\Fungsi\Respon\Respon;
use App\Http\Controllers\Controller;
use Rap2hpoutre\FastExcel\FastExcel;
use OpenSpout\Common\Entity\Style\Style;
use OpenSpout\Common\Entity\Style\Border;
use App\Repository\Kitir\LaporanPenjualanPecahRepository;

class LaporanPenjualanPecahController extends Controller
{
    public function laporan_pecah($bulan, $tahun)
    {
        $data = LaporanPenjualanPecahRepository::laporan_pecah_repository($bulan, $tahun);
        return Respon::respon($data);
    }

    public function download($bulan, $tahun)
    {
        $data = LaporanPenjualanPecahRepository::laporan_pecah_repository($bulan, $tahun);
        $p = [];
        $no = 0;
        foreach ($data['detil'] as $d) {
            $no++;
            $pecah = "Tidak";
            $jumlah_pecah = 0;
            $nama_pecah = "";
            $data_pecah = array();
            if (count($d['kitir_pecah']) >= 1) {
                $pecah = "YA";

                $n = 0;
                foreach ($d['kitir_pecah'] as $k) {
                    $n++;
                    $jumlah_pecah += $k['jumlah'];
                    $nama_pecah .= $k['penjualan']['pangkalan']['nama'];
                    $k['penjualan']['briva'] ? $jml_byr = $k['penjualan']['briva']['jumlah_bayar'] : $jml_byr = 0;
                    $k['penjualan']['briva'] ? $status_byr = $k['penjualan']['briva']['status_bayar'] : $status_byr = 0;

                    $data_pecah[] = [
                        "Nomor" => "",
                        "Pangkalan" => "",
                        "Tanggal\nKitir" => "",
                        "Jumlah" => "",
                        "Byr sesuai\n kitir" => "",
                        "Pecah" => "",
                        "Total\nJumlah Pecah" => "",
                        "No Pch" => $n,
                        "Ref" => $k['kitir_penjualan_id'],
                        "Tgl Transfer" => date("Y-m-d", strtotime($k['penjualan']['briva']['tanggal_tf'])),
                        "Nama Pecah" => $k['penjualan']['pangkalan']['nama'] . "\n",
                        "Jumlah\nPecah" => $k['jumlah'],
                        "Jumlah\nbeli" => $k['penjualan']['jumlah'],
                        "Total bayar" => $jml_byr,
                        "Status\nBayar" => $status_byr,
                    ];
                }
            }

            $p[] = [
                "Nomor" => $no,
                "Pangkalan" => $d['pangkalan']['nama'],
                "Tanggal\nKitir" => $d['tanggal'],
                "Jumlah" => $d['jumlah'],
                "Byr sesuai\n kitir" => $d['kitir_briva'] ? "Ya" : "Tidak",
                "Pecah" => $pecah,
                "Total\nJumlah Pecah" => $jumlah_pecah,
                "No Pch" => "",
                "Ref" => "",
                "Tgl Transfer" => "",
                "Nama Pecah" => "",
                "Jumlah\nPecah" => "",
                "Jumlah\nbeli" => "",
                "Total bayar" => "",
                "Status\nBayar" => "",

            ];
            if ($jumlah_pecah > 0) {
                $p = array_merge($p, $data_pecah);
            }

            $data_pecah[] = [
                "Nomor" => "",
                "Pangkalan" => "",
                "Tanggal\nKitir" => "",
                "Jumlah" => "",
                "Byr sesuai\n kitir" => "",
                "Pecah" => "",
                "Total\nJumlah Pecah" => "",
                "No Pch" => "",
                "Ref" => "",
                "Tgl Transfer" => "",
                "Nama Pecah" => "",
                "Jumlah\nPecah" => "",
                "Jumlah\nbeli" => "",
                "Total bayar" => "",
                "Status\nBayar" => "",
            ];
        }

        $hasil = collect($p);

        $header_style = (new Style())->setFontBold()->setBackgroundColor("e5eae1");

        return FastExcel($hasil)
            ->headerStyle($header_style)

            // ->configureWriterUsing(function ($writer) {
            //     $options2 = $writer->getOptions();
            //     $options2->setColumnWidth(100,1);
            // })

            ->download("Laporan_" . $bulan . "_" . $tahun . ".xlsx");
    }
}
