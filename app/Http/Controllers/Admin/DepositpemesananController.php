<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Depositpemesanan;
use App\Models\Perintah_kerja;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;

class DepositpemesananController extends Controller
{
    public function index()
    {
        $spks = Perintah_kerja::where(['status' => 'posting', 'status_deposit' => null])->get();
        return view('admin/depositpemesanan.create', compact('spks'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'perintah_kerja_id' => 'required',
                'harga' => 'required',
            ],
            [
                'perintah_kerja_id.required' => 'Pilih Perintah kerja',
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
                'perintah_kerja_id' => $request->perintah_kerja_id,
                'kode_deposit' => $this->kode(),
                'tanggal_awal' => $tanggal,
                'tanggal' => $format_tanggal,
                'harga' => str_replace(',', '.', str_replace('.', '', $request->harga)),
                'status' => 'posting',
            ]
        ));

        $encryptedId = Crypt::encryptString($deposits->id);
        $deposits->qrcode_deposit = 'https://tigerload.id/deposit_pemesanan/' . $encryptedId;
        $deposits->save();


        // $spk = Perintah_kerja::where('id', $deposits->perintah_kerja_id)->update(['status' => 'selesai', 'status_deposit' => 'deposit']);
        $spk = Perintah_kerja::where('id', $deposits->perintah_kerja_id)->first();
        return view('admin.depositpemesanan.show', compact('deposits', 'spk'));
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