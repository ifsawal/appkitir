<?php

namespace App\Models;

use App\Models\Pangkalan;
use App\Models\KitirPecah;
use App\Models\BagiPangkalan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kitir extends Model
{
    use HasFactory;
    protected $table = 'kitir';

    public function kitir_pecah()
    {
        return $this->hasMany(KitirPecah::class, 'id_k', 'id_k');
    }

    public function pangkalan()
    {
        return $this->belongsTo(Pangkalan::class, 'id_pang', 'id_pang');
    }

    public function bagi_pangkalan()
    {
        return $this->belongsTo(BagiPangkalan::class, 'id_k', 'id_k');
    }



}
