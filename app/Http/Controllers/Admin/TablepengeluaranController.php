<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pengeluaran_kaskecil;

class TablepengeluaranController extends Controller
{
    public function index(Request $request)
    {
        $inquery = Pengeluaran_kaskecil::query();

        // Apply the conditions for filtering
        $inquery->whereDate('tanggal_awal', Carbon::today());

        // Order the results by id in descending order
        $inquery->orderBy('id', 'DESC');

        // Get the results
        $inquery = $inquery->get();

        return view('admin.tablepengeluaran.index', compact('inquery'));
    }
}