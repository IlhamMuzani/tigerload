<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Depositpemesanan;
use App\Models\Spk;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DepositpemesananController extends Controller
{
    public function index()
    {
        $spks = Spk::all();
        return view('admin/depositpemesanan.create', compact('spks'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'spk_id' => 'required',
                'harga' => 'required',
            ],
            [
                'spk_id.required' => 'Pilih Spk',
                'harga.required' => 'Masukkan harga',
            ]
        );

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return back()->withInput()->with('error', $errors);
        }

        $kode = $this->kode();
        $tanggal1 = Carbon::now('Asia/Jakarta');
        $format_tanggal = $tanggal1->format('d F Y');

        $tanggal = Carbon::now()->format('Y-m-d');
        $deposits = Depositpemesanan::create(array_merge(
            $request->all(),
            [
                'kode_deposit' => $this->kode(),
                'qrcode_deposit' => 'https://tigerload.id/deposit_pemesanan/' . $kode,
                'tanggal_awal' => $tanggal,
                'tanggal' => $format_tanggal,
                'harga' => str_replace(',', '.', str_replace('.', '', $request->harga)),
                'status' => 'posting',

            ]
        )); 
        
        return view('admin.depositpemesanan.show', compact('deposits'));
    }

    public function cetakpdf($id)
    {
        $deposits = Depositpemesanan::where('id', $id)->first();
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('admin.depositpemesanan.cetak_pdf', compact('deposits'));
        $pdf->setPaper('folio', 'portrait');
        return $pdf->stream('Faktur_Pembelian.pdf');
    }

    public function kode()
    {
        $deposit = Depositpemesanan::all();
        if ($deposit->isEmpty()) {
            $num = "000001";
        } else {
            $id = Depositpemesanan::getId();
            foreach ($id as $value);
            $idlm = $value->id;
            $idbr = $idlm + 1;
            $num = sprintf("%06s", $idbr);
        }

        $data = 'DP';
        $kode_deposit = $data . $num;
        return $kode_deposit;
    }

    public function destroy($id)
    {
        $deposit = Pelanggan::find($id);
        $deposit->delete();

        return redirect('admin/deposit_pemesanan')->with('success', 'Berhasil menghapus DP');
    }
}