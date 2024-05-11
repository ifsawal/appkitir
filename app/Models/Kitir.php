<?php

namespace App\Models;

use App\Models\KitirPecah;
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

}
