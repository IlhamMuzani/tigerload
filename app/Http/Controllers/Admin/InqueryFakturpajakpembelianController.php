<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Faktur_pajak;
use App\Models\Pembelian;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class InqueryFakturpajakpembelianController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->status;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        $inquery = Faktur_pajak::query();

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

        $inquery->orderBy('id', 'DESC')->where('kategori', 'PEMBELIAN');
        $inquery = $inquery->get();

        return view('admin/inquery_fakturpajakpembelian.index', compact('inquery'));
    }


    public function show($id)
    {
        $inquery = Faktur_pajak::where('id', $id)->first();

        return view('admin.inquery_fakturpajakpembelian.show', compact('inquery'));
    }


    public function edit($id)
    {
        $penjualans = Pembelian::where(['status' => 'posting', 'kategori' => 'PPN'])->get();
        $inquery = Faktur_pajak::where('id', $id)->first();

        return view('admin/inquery_fakturpajakpembelian.update', compact('inquery', 'penjualans'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'pembelian_id' => 'required',
            ],
            [
                'pembelian_id.required' => 'Pilih Pembelian',
            ]
        );

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return back()->withInput()->with('error', $errors);
        }

        $inquery = Faktur_pajak::findOrFail($id);

        if ($request->gambar_pajak) {
            Storage::disk('local')->delete('public/uploads/' . $inquery->gambar_pajak);
            $gambar = str_replace(' ', '', $request->gambar_pajak->getClientOriginalName());
            $namaGambar = 'faktur_pajak/' . date('mYdHs') . rand(1, 10) . '_' . $gambar;
            $request->gambar_pajak->storeAs('public/uploads/', $namaGambar);
        } else {
            $namaGambar = $inquery->gambar_pajak;
        }
        Faktur_pajak::where('id', $id)->update([
            'gambar_pajak' => $namaGambar,
            'pembelian_id' => $request->pembelian_id,
            'status' => 'posting',
        ]);
        
        $inquery = Faktur_pajak::where('id', $id)->first();
        $penjualan = Pembelian::where('id', $inquery->pembelian_id)->update(['status' => 'selesai', 'status_pajak' => 'aktif']);

        return view('admin.inquery_fakturpajakpembelian.show', compact('inquery'));
    }

    public function unpostfakturpajakpembelian($id)
    {
        $faktur_pajaks = Faktur_pajak::where('id', $id)->first();

        $penjualans = Pembelian::where('id', $faktur_pajaks->pembelian_id)->update(['status' => 'posting', 'status_pajak' => null]);

        $faktur_pajaks->update([
            'status' => 'unpost'
        ]);

        return back()->with('success', 'Berhasil');
    }

    public function postingfakturpajakpembelian($id)
    {
        $faktur_pajaks = Faktur_pajak::where('id', $id)->first();

        $penjualans = Pembelian::where('id', $faktur_pajaks->pembelian_id)->update(['status' => 'selesai', 'status_pajak' => 'aktif']);

        $faktur_pajaks->update([
            'status' => 'posting'
        ]);

        return back()->with('success', 'Berhasil');
    }

    public function hapus_pajakpembelian($id)
    {
        $tagihan = Faktur_pajak::where('id', $id)->first();
        $tagihan->delete();
        return back()->with('success', 'Berhasil menghapus Surat penawaran');
    }
}