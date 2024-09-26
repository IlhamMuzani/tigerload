<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Kasbon_karyawan;
use App\Models\Saldo;

class TablekasbonController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $inquery = Kasbon_karyawan::whereDate('created_at', $today)
            ->orWhere(function ($query) use ($today) {
                $query->where('status', 'unpost')
                ->whereDate('created_at', '<', $today);
            })
            ->orderBy('created_at', 'desc')
            ->get();
        $saldoTerakhir = Saldo::latest()->first();

        return view('admin.tablekasbon.index', compact('inquery', 'saldoTerakhir'));
    }
}