<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Dompdf\Dompdf;
use App\Models\Komisi;
use App\Models\Pembelian;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Marketing;
use App\Models\Spk;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class KomisiController extends Controller
{
    public function index()
    {
        $pembelians = Spk::where('status_komisi', '!=', 'aktif')->get();
        $penjualans = Penjualan::where('status_komisi', '!=', 'aktif')->get();
        $marketings = Marketing::all();
        return view('admin/komisi.create', compact('pembelians', 'penjualans', 'marketings'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'kategori' => 'required',
                'kode_faktur' => 'required',
                'harga' => 'required',
                'fee' => 'required',
            ],
            [
                'kategori.required' => 'Pilih kategori',
                'kode_faktur.required' => 'Masukan kode faktur',
                'harga.required' => 'Masukkan harga',
                'fee.required' => 'Masukkan fee',
            ]
        );

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return back()->withInput()->with('error', $errors);
        }

        $kode = $this->kode();

        $kategori = $request->kategori;

        $penjualan_id = null;
        $pembelian_id = null;

        if ($kategori === 'Pembelian') {
            $pembelian_id = $request->pembelian_id;
        } elseif ($kategori === 'Penjualan') {
            $penjualan_id = $request->penjualan_id;
        }
        $tanggal1 = Carbon::now('Asia/Jakarta');
        $format_tanggal = $tanggal1->format('d F Y');
        $tanggal = Carbon::now()->format('Y-m-d');
        $komisis = Komisi::create(array_merge(
            $request->all(),
            [
                'kategori' => $kategori,
                'kode_faktur' => $request->kode_faktur,
                'pelanggan_id' => $request->pelanggan_id,
                'kendaraan_id' => $request->kendaraan_id,
                'marketing_id' => $request->marketing_id,
                'kode_komisi' => $this->kode(),
                'qrcode_komisi' => 'https:///tigerload.id/komisi/' . $kode,
                'tanggal' => $format_tanggal,
                'tanggal_awal' => $tanggal,
                'status' => 'posting',
                'penjualan_id' => $penjualan_id, // Set penjualan_id based on the condition
                'pembelian_id' => $pembelian_id, // Set pembelian_id based on the condition
            ]
        ));

        if ($kategori == 'Penjualan') {
            $faktur = Spk::where('id', $penjualan_id)->update([
                'status_komisi' => 'aktif',
            ]);
        } elseif ($kategori == 'Pembelian') {
            $faktur = Spk::where('id', $pembelian_id)->update([
                'status_komisi' => 'aktif',
            ]);
        }

        return view('admin.komisi.show', compact('komisis'));
    }

    public function kode()
    {
        $komisi = Komisi::all();
        if ($komisi->isEmpty()) {
            $num = "000001";
        } else {
            $id = Komisi::getId();
            foreach ($id as $value);
            $idlm = $value->id;
            $idbr = $idlm + 1;
            $num = sprintf("%06s", $idbr);
        }

        $data = 'AI';
        $kode_komisi = $data . $num;
        return $kode_komisi;
    }

    public function cetakpdf($id)
    {
        $komisis = Komisi::find($id);

        // Create an instance of PDF
        $pdf = app('dompdf.wrapper');

        // Load the view into the PDF instance
        $pdf->loadView('admin.komisi.cetak_pdf', compact('komisis'));

        // Set other configurations if needed
        $pdf->setPaper('letter', 'portrait'); // Example configuration

        // Return the PDF as a response
        return $pdf->stream('Faktur_komisi.pdf');
    }

    public function tambah_marketing(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama_marketing' => 'required',
                'nama_alias' => 'required',
                'gender' => 'required',
                'umur' => 'required',
                'telp' => 'required',
                'alamat' => 'required',
                // 'gambar_ktp' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            ],
            [
                'nama_marketing.required' => 'Masukkan nama lengkap',
                'nama_alias.required' => 'Masukkan nama alias',
                'gender.required' => 'Pilih gender',
                'umur.required' => 'Masukkan umur',
                'telp.required' => 'Masukkan no telepon',
                'alamat.required' => 'Masukkan alamat',
                // 'gambar_ktp.image' => 'Gambar yang dimasukan salah!',
            ]
        );

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return back()->withInput()->with('error', $errors);
        }

        if ($request->gambar_ktp) {
            $gambar = str_replace(' ', '', $request->gambar_ktp->getClientOriginalName());
            $namaGambar = 'marketing/' . date('mYdHs') . rand(1, 10) . '_' . $gambar;
            $request->gambar_ktp->storeAs('public/uploads/', $namaGambar);
        } else {
            $namaGambar = null;
        }

        $kodemarketing = $this->kodemarketing();

        $tanggal = Carbon::now()->format('Y-m-d');
        Marketing::create(array_merge(
            $request->all(),
            [
                'gambar_ktp' => $namaGambar,
                'kode_marketing' => $this->kodemarketing(),
                'qrcode_marketing' => 'https://omegamotor.id/marketing/' . $kodemarketing,
                'tanggal_awal' => $tanggal,

            ]
        ));

        return back()->with('success', 'Berhasil menambahkan marketing');
    }

    public function kodemarketing()
    {
        $marketing = Marketing::all();
        if ($marketing->isEmpty()) {
            $num = "000001";
        } else {
            $id = Marketing::getId();
            foreach ($id as $value);
            $idlm = $value->id;
            $idbr = $idlm + 1;
            $num = sprintf("%06s", $idbr);
        }

        $data = 'AE';
        $kode_marketing = $data . $num;
        return $kode_marketing;
    }
}