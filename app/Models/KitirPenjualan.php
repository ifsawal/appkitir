<?php

namespace App\Models;

use App\Models\Pangkalan;
use App\Models\KitirPenjualanBriva;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KitirPenjualan extends Model
{
    use HasFactory;
    protected $table = 'kitir_penjualan';

    public function pangkalan()
    {
        return $this->belongsTo(Pangkalan::class, 'id_pang', 'id_pang');
    }
    public function briva()
    {
    	return $this->belongsTo(KitirPenjualanBriva::class, 'id', 'kitir_penjualan_ID');
    }

}
