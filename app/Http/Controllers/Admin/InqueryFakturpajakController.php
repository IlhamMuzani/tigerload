<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Faktur_pajak;
use App\Models\Penjualan;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class InqueryFakturpajakController extends Controller
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

        $inquery->orderBy('id', 'DESC')->where('kategori', 'PENJUALAN');
        $inquery = $inquery->get();

        return view('admin/inquery_fakturpajak.index', compact('inquery'));
    }


    public function show($id)
    {
        $inquery = Faktur_pajak::where('id', $id)->first();

        return view('admin.inquery_fakturpajak.show', compact('inquery'));
    }


    public function edit($id)
    {
        $penjualans = Penjualan::where(['status' => 'posting', 'kategori' => 'PPN'])->get();
        $inquery = Faktur_pajak::where('id', $id)->first();

        return view('admin/inquery_fakturpajak.update', compact('inquery', 'penjualans'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'penjualan_id' => 'required',
            ],
            [
                'penjualan_id.required' => 'Pilih Penjualan',
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
            'penjualan_id' => $request->penjualan_id,
            'status' => 'posting',
        ]);
        
        $inquery = Faktur_pajak::where('id', $id)->first();
        $penjualan = Penjualan::where('id', $inquery->penjualan_id)->update(['status' => 'selesai', 'status_pajak' => 'aktif']);

        return view('admin.inquery_fakturpajak.show', compact('inquery'));
    }

    public function unpostfakturpajak($id)
    {
        $faktur_pajaks = Faktur_pajak::where('id', $id)->first();

        $penjualans = Penjualan::where('id', $faktur_pajaks->penjualan_id)->update(['status' => 'posting', 'status_pajak' => null]);

        $faktur_pajaks->update([
            'status' => 'unpost'
        ]);

        return back()->with('success', 'Berhasil');
    }

    public function postingfakturpajak($id)
    {
        $faktur_pajaks = Faktur_pajak::where('id', $id)->first();

        $penjualans = Penjualan::where('id', $faktur_pajaks->penjualan_id)->update(['status' => 'selesai', 'status_pajak' => 'aktif']);

        $faktur_pajaks->update([
            'status' => 'posting'
        ]);

        return back()->with('success', 'Berhasil');
    }

    public function hapus_pajak($id)
    {
        $tagihan = Faktur_pajak::where('id', $id)->first();
        $tagihan->delete();
        return back()->with('success', 'Berhasil menghapus Surat penawaran');
    }

    public function cetak_buktifilterpenjualan(Request $request)
    {
        $selectedIds = explode(',', $request->input('ids'));

        // Mengambil faktur berdasarkan id yang dipilih
        $cetakpdfs = Faktur_pajak::whereIn('id', $selectedIds)->orderBy('id', 'DESC')->get();

        $pdf = PDF::loadView('admin.inquery_fakturpajakpembelian.cetak_pdffilter', compact('cetakpdfs'));
        $pdf->setPaper('a4');

        return $pdf->stream('Bukti_Potong_pajak.pdf');
    }
}