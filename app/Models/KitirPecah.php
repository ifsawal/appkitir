<?php

namespace App\Models;

use App\Models\KitirPenjualan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KitirPecah extends Model
{
    use HasFactory;
    protected $table = 'kitir_pecah';


    public function kitir()
    {
        return $this->belongsTo(Kitir::class, 'id_k', 'id_k');
    }

    public function penjualan()
    {
        return $this->belongsTo(KitirPenjualan::class, 'kitir_penjualan_id', 'id');
    }
}
