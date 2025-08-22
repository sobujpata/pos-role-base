<?php

namespace App\Http\Controllers;

use App\Models\SingleBanner;
use Illuminate\Http\Request;
use App\Helper\ResponseHelper;

class SingleBannerController extends Controller
{
    public function singleBannerView(){
        $data = SingleBanner::first();
        return ResponseHelper::Out('success',$data,200);
    }
}
