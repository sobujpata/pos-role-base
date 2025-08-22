<?php

namespace App\Http\Controllers;

use App\Models\ShopBanner;
use Illuminate\Http\Request;
use App\Helper\ResponseHelper;
use Illuminate\Http\JsonResponse;

class ShopBannerController extends Controller
{
   
    public function shopBannerView():JsonResponse{
        $data = ShopBanner::all();
        return ResponseHelper::Out('success',$data,200);
    }
}
