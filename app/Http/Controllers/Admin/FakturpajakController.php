<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Depositpemesanan;
use App\Models\Faktur_pajak;
use App\Models\Penjualan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Barryvdh\DomPDF\Facade\Pdf;

class FakturpajakController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $inquery = Faktur_pajak::where('kategori', 'PENJUALAN')->whereDate('created_at', $today)
            ->orWhere(function ($query) use ($today) {
                $query->where('status', 'unpost')
                    ->whereDate('created_at', '<', $today);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.faktur_pajak.index', compact('inquery'));
    }

    public function create()
    {
        $penjualans = Penjualan::where(['status' => 'posting', 'kategori' => 'PPN'])->get();
        return view('admin/faktur_pajak.create', compact('penjualans'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'penjualan_id' => 'required',
                'gambar_pajak' => 'nullable|mimes:pdf|max:2048',
            ],
            [
                'penjualan_id.required' => 'Pilih Penjualan',
                'gambar_pajak.mimes' => 'Hanya file PDF yang diperbolehkan!',
                'gambar_pajak.max' => 'Ukuran file PDF maksimal 2MB!',
            ]
        );

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return back()->withInput()->with('error', $errors);
        }

        if ($request->gambar_pajak) {
            $gambar = str_replace(' ', '', $request->gambar_pajak->getClientOriginalName());
            $namaGambar = 'faktur_pajak/' . date('mYdHs') . rand(1, 10) . '_' . $gambar;
            $request->gambar_pajak->storeAs('public/uploads/', $namaGambar);
        } else {
            $namaGambar = null;
        }

        $kode = $this->kode();
        $tanggal1 = Carbon::now('Asia/Jakarta');
        $format_tanggal = $tanggal1->format('d F Y');

        $tanggal = Carbon::now()->format('Y-m-d');
        $inquery = Faktur_pajak::create(array_merge(
            $request->all(),
            [
                'gambar_pajak' => $namaGambar,
                'penjualan_id' => $request->penjualan_id,
                'kode_pajak' => $this->kode(),
                'tanggal_awal' => $tanggal,
                'tanggal' => $format_tanggal,
                'kategori' => 'PENJUALAN',
                'status' => 'posting',
            ]
        ));

        $encryptedId = Crypt::encryptString($inquery->id);
        $inquery->qrcode_pajak = 'https://tigerload.id/faktur_pajak/' . $encryptedId;
        $inquery->save();


        $faktur_pajak = Penjualan::where('id', $inquery->penjualan_id)->update(['status' => 'selesai', 'status_pajak' => 'aktif']);
        return view('admin.faktur_pajak.show', compact('inquery'));
    }

    public function show($id)
    {
        $inquery = Faktur_pajak::where('id', $id)->first();
        $penjualan = Penjualan::where('id', $inquery->perintah_kerja_id)->first();

        return view('admin.faktur_pajak.show', compact('inquery', 'penjualan'));
    }

    public function cetakpdf($id)
    {
        $cetakpdf = Faktur_pajak::where('id', $id)->first();

        $pdf = PDF::loadView('admin.faktur_pajak.cetak_pdf', compact('cetakpdf'));
        $pdf->setPaper('letter', 'portrait'); // Set the paper size to portrait letter

        return $pdf->stream('Faktur_pajak.pdf');
    }

    public function kode()
    {
        $deposit = Faktur_pajak::all();
        if ($deposit->isEmpty()) {
            $num = "000001";
        } else {
            $id = Faktur_pajak::getId();
            foreach ($id as $value);
            $idlm = $value->id;
            $idbr = $idlm + 1;
            $num = sprintf("%06s", $idbr);
        }

        $data = 'FP';
        $kode_deposit = $data . $num;
        return $kode_deposit;
    }

    public function destroy($id)
    {
        $deposit = Pelanggan::find($id);
        $deposit->delete();

        return redirect('admin/faktur_pajak')->with('success', 'Berhasil menghapus faktur');
    }
}