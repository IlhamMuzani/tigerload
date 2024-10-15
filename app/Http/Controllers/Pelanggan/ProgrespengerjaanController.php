<?php

namespace App\Http\Controllers\Pelanggan;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use App\Models\Perintah_kerja;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ProgrespengerjaanController extends Controller
{
    public function index()
    {
        $user = auth()->user(); // Pastikan untuk mendapatkan pengguna yang sedang login
        $pelanggan = Pelanggan::where('id', $user->pelanggan_id)->first();

        $inquery = Perintah_kerja::where('pelanggan_id', $pelanggan->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pelanggan.progres_pengerjaan.index', compact('inquery'));
    }


    public function show($id)
    {
        $progres = Perintah_kerja::where('id', $id)->first();
        return view('pelanggan.progres_pengerjaan.show', compact('progres'));
    }
}