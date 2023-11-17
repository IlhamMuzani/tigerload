<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Dompdf\Dompdf;
use App\Models\Divisi;
use App\Models\Golongan;
use App\Models\Kendaraan;
use Illuminate\Http\Request;
use App\Models\Jenis_kendaraan;
use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Marketing;
use App\Models\Merek;
use App\Models\Modelken;
use App\Models\Pelanggan;
use App\Models\Pembelian;
use App\Models\Penjualan;
use App\Models\Spesifikasi;
use App\Models\Spk;
use App\Models\Tipe;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class InqueryPenjualanController extends Controller
{
    public function index(Request $request)
    {
        // $penjualans = Penjualan::get();
        // return view('admin/inquerypenjualan.index', compact('penjualans'));

        $status = $request->status;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        $inquery = Penjualan::query();

        if ($status) {
            $inquery->where('status', $status);
        }

        if ($tanggal_awal && $tanggal_akhir) {
            $inquery->whereBetween('tanggal_awal', [$tanggal_awal, $tanggal_akhir]);
        } elseif ($tanggal_awal) {
            $inquery->where('tanggal_awal', '>=', $tanggal_awal);
        } elseif ($tanggal_akhir) {
            $inquery->where('tanggal_awal', '<=', $tanggal_akhir);
        } else {
            // Jika tidak ada filter tanggal hari ini
            $inquery->whereDate('tanggal_awal', Carbon::today());
        }

        $inquery->orderBy('id', 'DESC');
        $inquery = $inquery->get();

        return view('admin/inquerypenjualan.index', compact('inquery'));

    }


    public function show($id)
    {

        $penjualans = Penjualan::where('id', $id)->first();
        $penjual = Penjualan::find($id);
        $spesifikasis = Spesifikasi::where('penjualan_id', $penjual->id)->get();
        return view('admin.inquerypenjualan.show', compact('penjualans', 'spesifikasis'));
    }


    public function edit($id)
    {
        $penjualans = Penjualan::where('id', $id)->first();
        $barangs = Barang::all();
        $spks = Spk::all();

        return view('admin/inquerypenjualan.update', compact('spks','barangs', 'penjualans'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'pelanggan_id' => 'required',
                'kendaraan_id' => 'required',
                'marketing_id' => 'required',
                'harga' => 'required',
            ],
            [
                'pelanggan_id.required' => 'Pilih pelanggan',
                'kendaraan_id.required' => 'Pilih Kendaraan',
                'marketing_id.required' => 'Pilih Kendaraan',
                'harga.required' => 'Masukkan harga',
            ]
        );

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return back()->withInput()->with('error', $errors);
        }

        $penjualan = Penjualan::where('id', $id)->update(
            [
                'pelanggan_id' => $request->pelanggan_id,
                'kendaraan_id' => $request->kendaraan_id,
                'marketing_id' => $request->marketing_id,
                'harga' => $request->harga,
                'status' => 'posting',
            ]
        );

        return redirect('admin/inquery_penjualan')->with('success', 'Berhasil memperbarui penjualan');
    }


    public function unpostpenjualan($id)
    {
        $ban = Penjualan::where('id', $id)->first();

        $ban->update([
            'status' => 'unpost'
        ]);

        return back()->with('success', 'Berhasil');
    }

    public function postingpenjualan($id)
    {
        $ban = Penjualan::where('id', $id)->first();

        $ban->update([
            'status' => 'posting'
        ]);

        return back()->with('success', 'Berhasil');
    }

    public function destroy($id)
    {
        $penjualan = Penjualan::find($id);
        Kendaraan::where('id', $penjualan->kendaraan_id)->update([
            'status' => 'stok',
        ]);
        $penjualan->delete();


        return redirect('admin/inquery_penjualan')->with('success', 'Berhasil menghapus Penjualan');
    }
}