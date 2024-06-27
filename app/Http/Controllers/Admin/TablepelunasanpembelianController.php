<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Faktur_pelunasanpembelian;
use App\Models\Pelunasan;
use App\Models\Penjualan;

class TablepelunasanpembelianController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $inquery = Faktur_pelunasanpembelian::whereDate('created_at', $today)
            ->orWhere(function ($query) use ($today) {
                $query->where('status', 'unpost')
                ->whereDate('created_at', '<', $today);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.tablepelunasanpembelian.index', compact('inquery'));
    }
}