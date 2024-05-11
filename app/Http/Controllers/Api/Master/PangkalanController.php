<?php

namespace App\Http\Controllers\Api\Master;

use App\Models\Pangkalan;
use Illuminate\Http\Request;
use App\Fungsi\Respon\Respon;
use App\Http\Controllers\Controller;

class PangkalanController extends Controller
{
    public function pangkalan(){
        $Pangkalan=Pangkalan::all();
        Respon::respon($Pangkalan);
    }


}
