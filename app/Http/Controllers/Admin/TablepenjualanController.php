<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Penjualan;

class TablepenjualanController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $inquery = Penjualan::whereDate('created_at', $today)
            ->orWhere(function ($query) use ($today) {
                $query->where('status', 'unpost')
                ->whereDate('created_at', '<', $today);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.tablepenjualan.index', compact('inquery'));
    }
}