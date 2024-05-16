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
use App\Models\Marketing;
use App\Models\Merek;
use App\Models\Modelken;
use App\Models\Pelanggan;
use App\Models\Pelunasan;
use App\Models\Pembelian;
use App\Models\Penjualan;
use App\Models\Spesifikasi;
use App\Models\Spk;
use App\Models\Tipe;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class InqueryPelunasanController extends Controller
{
    public function index(Request $request)
    {
        // $penjualans = Penjualan::get();
        // return view('admin/inquerypenjualan.index', compact('penjualans'));

        $status = $request->status;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        $inquery = Pelunasan::query();

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

        return view('admin/inquerypelunasan.index', compact('inquery'));
    }


    public function show($id)
    {

        $pelunasans = Pelunasan::where('id', $id)->first();
        $pelunas = Pelunasan::find($id);
        $penjualans = Penjualan::where('id', $pelunas->penjualan_id)->first();

        $spesifikasis = Spesifikasi::where('penjualan_id', $penjualans->id)->get();

        return view('admin.inquerypelunasan.show', compact('pelunasans', 'penjualans', 'spesifikasis'));
    }


    public function edit($id)
    {
        $pelunasans = pelunasan::where('id', $id)->first();
        $penjualans = Penjualan::where(['status' => 'posting', 'status_pelunasan' => null])->get();

        return view('admin/inquerypelunasan.update', compact('pelunasans', 'penjualans'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'penjualan_id' => 'required',
                'kategori' => 'required',
                'tanggal_transfer' => 'required',
                'nominal' => 'required',
            ],
            [
                'penjualan_id.required' => 'Pilih Penjualan',
                'kategori.required' => 'Pilih Kategori',
                'tanggal_transfer.required' => 'Masukkan Tanggal',
                'nominal.required' => 'Masukkan Nominal',
            ]
        );

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return back()->withInput()->with('error', $errors);
        }

        $statusPelunasan = 'LUNAS'; // Default

        $selisih = (int)str_replace(['Rp', '.', ' '], '', $request->selisih);

        if ($selisih === 0) {
            $statusPelunasan = 'LUNAS';
        } elseif ($selisih < 0) {
            $statusPelunasan = 'BELUM LUNAS';
        }

        $pelunasans = Pelunasan::where('id', $id)->update(
            [
                'penjualan_id' => $request->penjualan_id,
                'potongan' => $request->potongan,
                'kategori' => $request->kategori,
                'nomor' => $request->nomor,
                'tanggal_transfer' => $request->tanggal_transfer,
                'nominal' => $request->nominal,
                'totalpenjualan' => str_replace('.', '', $request->totalpenjualan),
                'dp' => str_replace('.', '', $request->dp),
                'totalpembayaran' => str_replace('.', '', $request->totalpembayaran),
                'selisih' => (int)str_replace(['Rp', '.', ' '], '', $request->selisih),
                'status_pelunasan' => $statusPelunasan,
                'status' => 'posting',
            ]
        );

        $pelunasans = Pelunasan::where('id', $id)->first();
        $penjualan = Penjualan::where('id', $pelunasans->penjualan_id)->update(['status_pelunasan' => 'pelunasan']);

        $penjualans = Penjualan::where('id', $pelunasans->penjualan_id)->first();
        $spesifikasis = Spesifikasi::where('penjualan_id', $penjualans->id)->get();
        
        return view('admin.inquerypelunasan.show', compact('pelunasans','penjualans', 'spesifikasis'));
    }


    public function unpostpelunasan($id)
    {
        $pelunasan = Pelunasan::where('id', $id)->first();

        $penjualan = Penjualan::where('id', $pelunasan->penjualan_id)->update(['status_pelunasan' => null]);

        $pelunasan->update([
            'status' => 'unpost'
        ]);

        return back()->with('success', 'Berhasil');
    }

    public function postingpelunasan($id)
    {
        $pelunasan = Pelunasan::where('id', $id)->first();

        $penjualan = Penjualan::where('id', $pelunasan->penjualan_id)->update(['status_pelunasan' => 'pelunasan']);

        $pelunasan->update([
            'status' => 'posting'
        ]);

        return back()->with('success', 'Berhasil');
    }

    public function hapuspelunasan($id)
    {
        $item = Pelunasan::where('id', $id)->first();

        if ($item) {
            // $detailpelunasan = Detail_pelunasan::where('faktur_pelunasan_id', $id)->get();
            // // Delete related Detail_pelunasan instances
            // Detail_pelunasan::where('faktur_pelunasan_id', $id)->delete();
            // Detail_pelunasanreturn::where('faktur_pelunasan_id', $id)->delete();
            // Detail_pelunasanpotongan::where('faktur_pelunasan_id', $id)->delete();

            // Delete the main Faktur_pelunasan instance
            $item->delete();

            return back()->with('success', 'Berhasil menghapus Pelunasan');
        } else {
            // Handle the case where the Faktur_pelunasan with the given ID is not found
            return back()->with('error', 'Pelunasan tidak ditemukan');
        }
    }

    public function destroy($id)
    {
        $penjualan = Pelunasan::find($id);

        $penjualan->delete();


        return redirect('admin/inquery_pelunasan')->with('success', 'Berhasil menghapus Pelunasan');
    }
}