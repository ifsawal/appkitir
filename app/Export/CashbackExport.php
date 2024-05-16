<?php

namespace App\Export;

use App\Http\Controllers\Api\Master\Cashback\CashbackReController;
use App\Models\Pangkalan;
use App\Repository\Cashback\CashbackReRepository;
use Maatwebsite\Excel\Facades\Excel;
use Vitorccs\LaravelCsv\Concerns\FromQuery;
use Vitorccs\LaravelCsv\Concerns\Exportable;
// use Maatwebsite\Excel\Concerns\FromCollection;

// class CashbackExport 
// {
//     //, WithHeadings, WithColumnWidths, WithTitle


//     public function export()
//     {
//         // return Excel::download(new UsersExport, 'users.xlsx');
//     }
// }


class CashbackExport implements FromQuery
{
    use Exportable;

    public function query()
    {
        return Pangkalan::query();
        // return CashbackReRepository::data_cashback(2, 2024);
    }


    // public static function qu($bulan, $tahun)
    // {
    //     return CashbackReRepository::data_cashback($bulan, $tahun);
    // }
}
