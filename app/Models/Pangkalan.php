<?php

namespace App\Models;

use App\Models\JenisCashback;
use App\Models\KitirPenjualan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pangkalan extends Model
{
    use HasFactory;
    protected $table = 'pangkalan';

    public function jenis_cashback()
    {
    	return $this->hasOne(JenisCashback::class, 'id_pang', 'id_pang');
    }

    public function kitir_penjualan()
    {
        return $this->hasMany(KitirPenjualan::class, 'id_pang', 'id_pang');
    }
    
}
