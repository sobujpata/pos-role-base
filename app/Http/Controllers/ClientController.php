<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function ClientShow(){
        $clients = Client::get();

        return response()->json($clients);
    }
}
