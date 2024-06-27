<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Depositpemesanan;
use App\Models\Pengambilanbahan;

class TablepengambilanbahanController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $inquery = Pengambilanbahan::whereDate('created_at', $today)
            ->orWhere(function ($query) use ($today) {
                $query->where('status', 'unpost')
                ->whereDate('created_at', '<', $today);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.tablepengambilanbahan.index', compact('inquery'));
    }
}