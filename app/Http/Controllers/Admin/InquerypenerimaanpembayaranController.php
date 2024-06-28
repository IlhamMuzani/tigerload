<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Kendaraan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Spesifikasi;
use App\Models\Penerimaan_pembayaran;
use App\Models\Surat_penawaran;
use App\Models\Typekaroseri;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Mockery\Matcher\Type;

class InquerypenerimaanpembayaranController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->status;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        $inquery = Penerimaan_pembayaran::query();

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

        return view('admin/inquerypenerimaanpembayaran.index', compact('inquery'));
    }


    public function show($id)
    {
        $pembelian = Penerimaan_pembayaran::where('id', $id)->first();
        return view('admin/inquerypenerimaanpembayaran.show', compact('pembelian'));
    }


    public function edit($id)
    {
        $pembelian = Penerimaan_pembayaran::where('id', $id)->first();
        $suratpenawarans = Surat_penawaran::all();
        return view('admin/inquerypenerimaanpembayaran.update', compact('suratpenawarans', 'pembelian'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'kategoris' => 'required',
            'surat_penawaran_id' => 'required',
            'pelanggan_id' => 'required',
            'typekaroseri_id' => 'required',
            'nominal' => 'required',
        ], [
            'kategoris.required' => 'Pilih kategoris',
            'surat_penawaran_id.required' => 'Pilih Surat Penawaran',
            'pelanggan_id.required' => 'Pilih pelanggan',
            'typekaroseri_id.required' => 'Pilih karoseri',
            'nominal.required' => 'Masukkan nominal',
        ]);

        // Jika validasi gagal, kembalikan ke halaman sebelumnya dengan error
        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return back()->withInput()->with('error', $errors);
        }

        // Ambil data pembayaran yang akan diupdate
        $pembelian = Penerimaan_pembayaran::findOrFail($id);

        // Lakukan update data
        $pembelian->surat_penawaran_id = $request->surat_penawaran_id;
        $pembelian->typekaroseri_id = $request->typekaroseri_id;
        $pembelian->tanggal_pembayaran = $request->tanggal_pembayaran;
        $pembelian->keterangan = $request->keterangan;
        $pembelian->kategoris = $request->kategoris;
        $pembelian->pelanggan_id = $request->pelanggan_id;
        $pembelian->nominal = str_replace(',', '.', str_replace('.', '', $request->nominal));
        $pembelian->status = 'posting';
        $pembelian->save();

        // Ambil data pembelian setelah diupdate
        $pembelian = Penerimaan_pembayaran::findOrFail($id);

        // Tampilkan halaman show dengan data yang telah diupdate
        return view('admin.inquerypenerimaanpembayaran.show', compact('pembelian'));
    }

    public function unpostpenerimaan($id)
    {
        $deposits = Penerimaan_pembayaran::where('id', $id)->first();
        $deposits->update([
            'status' => 'unpost'
        ]);

        return back()->with('success', 'Berhasil');
    }

    public function postingpenerimaan($id)
    {
        $deposits = Penerimaan_pembayaran::where('id', $id)->first();
        $deposits->update([
            'status' => 'posting'
        ]);

        return back()->with('success', 'Berhasil');
    }

    public function hapuspenerimaanpembayaran($id)
    {
        $penjualan = Penerimaan_pembayaran::where('id', $id)->first();
        $penjualan->delete();
        return back()->with('success', 'Berhasil menghapus Penerimaan');
    }
}
