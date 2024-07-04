<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Detail_barang;
use App\Models\Detailpembelian;
use App\Models\Detailpengambilan;
use App\Models\Pembelian;
use App\Models\Pengambilanbahan;
use App\Models\Perhitunganbahanbaku;
use App\Models\Perintah_kerja;
use Illuminate\Support\Facades\Validator;

class InqueryPerhitunganbahanbakuController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->status;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        $inquery = Perhitunganbahanbaku::query();

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

        return view('admin/inqueryperhitunganbahanbaku.index', compact('inquery'));
    }


    public function show($id)
    {

        $pengambilans = Perhitunganbahanbaku::where('id', $id)->first();
        $pengambil = Perhitunganbahanbaku::find($id);
        $spks = Perintah_kerja::where('id', $pengambil->perintah_kerja_id)->first();

        $cetakpdfs = Pengambilanbahan::where('perintah_kerja_id', $spks->id)->get();

        return view('admin.inqueryperhitunganbahanbaku.show', compact('cetakpdfs', 'pengambilans'));
    }


    public function edit($id)
    {
        // Fetch the Perhitunganbahanbaku record by its ID
        $inquery = Perhitunganbahanbaku::find($id);

        if (!$inquery) {
            return redirect()->back()->withErrors('Inquery not found.');
        }

        // Fetch the related Perintah_kerja using the relationship
        $spks = Perintah_kerja::find($inquery->perintah_kerja_id);

        if (!$spks) {
            return redirect()->back()->withErrors('Perintah Kerja not found.');
        }

        // Fetch the Pengambilanbahan records related to the Perintah_kerja
        $details = Pengambilanbahan::where('perintah_kerja_id', $spks->id)->get();

        // Pass the retrieved data to the view
        return view('admin.inqueryperhitunganbahanbaku.update', compact('inquery', 'spks', 'details'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'perintah_kerja_id' => 'required',
            ],
            [
                'perintah_kerja_id.required' => 'Pilih nomor SPK',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        Perhitunganbahanbaku::where('id', $id)->update([
            'perintah_kerja_id' => $request->perintah_kerja_id,
            'keterangan' => $request->keterangan,
            'grand_total' => str_replace(',', '.', str_replace('.', '', $request->grand_total)),
            'status' => 'posting',
        ]);

        $pengambilans = Perhitunganbahanbaku::where('id', $id)->first();
        $pengambil = Perhitunganbahanbaku::find($id);
        $spks = Perintah_kerja::where('id', $pengambil->perintah_kerja_id)->first();

        $cetakpdfs = Pengambilanbahan::where('perintah_kerja_id', $spks->id)->get();

        return view('admin.inqueryperhitunganbahanbaku.show', compact('cetakpdfs', 'pengambilans'));
    }

    public function unpostperhitungan($id)
    {
        $item = Perhitunganbahanbaku::where('id', $id)->first();
        $item->update([
            'status' => 'unpost'
        ]);

        return back()->with('success', 'Berhasil');
    }

    public function postingperhitungan($id)
    {
        $item = Perhitunganbahanbaku::where('id', $id)->first();
        $item->update([
            'status' => 'posting'
        ]);

        return back()->with('success', 'Berhasil');
    }


    public function hapusperhitunganbahan($id)
    {
        $tagihan = Perhitunganbahanbaku::where('id', $id)->first();

        if ($tagihan) {
            $tagihan->delete();
            return back()->with('success', 'Berhasil menghapus Perhitungan');
        } else {
            // Handle the case where the Perhitungan with the given ID is not found
            return back()->with('error', 'Perhitungan tidak ditemukan');
        }
    }
}