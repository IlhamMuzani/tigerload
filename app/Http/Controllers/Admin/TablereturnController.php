<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Depositpemesanan;
use App\Models\Returnpembelian;

class TablereturnController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $inquery = Returnpembelian::whereDate('created_at', $today)
            ->orWhere(function ($query) use ($today) {
                $query->where('status', 'unpost')
                ->whereDate('created_at', '<', $today);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.tablereturn.index', compact('inquery'));
    }
}