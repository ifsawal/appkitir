<?php

namespace App\Models;

use App\Models\NamaCashback;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JenisCashback extends Model
{
    use HasFactory;
    protected $table = 'jenis_cashback';

    public function nama_cashback()
    {
        return $this->belongsTo(NamaCashback::class, 'nama_cashback_id', 'id');
    }
}
