<?php

namespace App\Http\Controllers\Pelanggan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use App\Models\Kendaraan;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

class DashboardController extends Controller
{

    public function index(Request $request)
    {
        return view('pelanggan.index');
    }
}