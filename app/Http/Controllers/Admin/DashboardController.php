<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Kendaraan;
use App\Models\Nokir;
use App\Models\Stnk;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }
}