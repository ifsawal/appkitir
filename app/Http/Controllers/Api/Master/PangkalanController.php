<?php

namespace App\Http\Controllers\Api\Master;

use App\Http\Controllers\Controller;
use App\Models\Pangkalan;
use Illuminate\Http\Request;

class PangkalanController extends Controller
{
    public function pangkalan(){
        return Pangkalan::all();
    }


}
