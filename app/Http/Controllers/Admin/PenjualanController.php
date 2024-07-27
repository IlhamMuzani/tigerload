<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Tipe;
use App\Models\Merek;
use App\Models\Modelken;
use Barryvdh\DomPDF\PDF;
use App\Models\Kendaraan;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Depositpemesanan;
use App\Models\Marketing;
use App\Models\Penjualan;
use App\Models\Detail_penjualan;
use App\Models\Perintah_kerja;
use App\Models\Typekaroseri;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PenjualanController extends Controller
{
    public function index()
    {
        $deposits = Depositpemesanan::all();
        $barangs = Typekaroseri::all();
        $spks = Perintah_kerja::where(function ($query) {
            $query->where('status', 'selesai')
                ->orWhere('status', 'posting');
        })
            ->where('status_penjualan', null)
            ->get();
        return view('admin/penjualan.create', compact('deposits', 'barangs', 'spks'));
    }

    public function store(Request $request)
    {
        $validasi_pelanggan = Validator::make(
            $request->all(),
            [
                'perintah_kerja_id' => 'required',
                // 'depositpemesanan_id' => 'required',
            ],
            [
                'perintah_kerja_id.required' => 'Pilih nomor spk terlebih dahulu',
                // 'depositpemesanan_id.required' => 'Deposit Kosong',
            ]
        );

        $error_pelanggans = array();

        if ($validasi_pelanggan->fails()) {
            array_push($error_pelanggans, $validasi_pelanggan->errors()->all()[0]);
        }

        $error_pesanans = array();
        $data_pembelians = collect();

        $error_pesanans = array();
        $data_pembelians = collect();

        if ($request->has('typekaroseri_id') || $request->has('kode_type') || $request->has('nama_karoseri') || $request->has('jumlah') || $request->has('harga')) {
            for ($i = 0; $i < count($request->typekaroseri_id); $i++) {
                // Check if either 'keterangan_tambahan' or 'nominal_tambahan' has input
                if (empty($request->typekaroseri_id[$i]) && empty($request->kode_type[$i]) && empty($request->nama_karoseri[$i]) && empty($request->jumlah[$i]) && empty($request->harga[$i])) {
                    continue; // Skip validation if both are empty
                }

                $validasi_produk = Validator::make($request->all(), [
                    'typekaroseri_id.' . $i => 'required',
                    'kode_types.' . $i => 'required',
                    'nama_karoseri.' . $i => 'required',
                    'jumlah.' . $i => 'required',
                    'harga.' . $i => 'required',
                    // 'diskon.' . $i => 'required',
                    'total.' . $i => 'required',
                ]);

                if ($validasi_produk->fails()) {
                    array_push($error_pesanans, "Detail_penjualan nomor " . ($i + 1) . " belum dilengkapi!");
                }

                $typekaroseri_id = $request->typekaroseri_id[$i] ?? '';
                $kode_types = $request->kode_types[$i] ?? '';
                $nama_karoseri = $request->nama_karoseri[$i] ?? '';
                $jumlah = $request->jumlah[$i] ?? '';
                $harga = $request->harga[$i] ?? '';
                $diskon = $request->diskon[$i] ?? '';
                $total = $request->total[$i] ?? '';
                $data_pembelians->push(['typekaroseri_id' => $typekaroseri_id, 'kode_types' => $kode_types, 'nama_karoseri' => $nama_karoseri, 'jumlah' => $jumlah, 'harga' => $harga, 'diskon' => $diskon, 'total' => $total]);
            }
        }

        if ($error_pelanggans || $error_pesanans) {
            return back()
                ->withInput()
                ->with('error_pelanggans', $error_pelanggans)
                ->with('error_pesanans', $error_pesanans)
                ->with('data_pembelians', $data_pembelians);
        }

        $kode = $this->kode();
        // tgl indo
        $tanggal1 = Carbon::now('Asia/Jakarta');
        $format_tanggal = $tanggal1->format('d F Y');

        $tanggal = Carbon::now()->format('Y-m-d');
        $penjualans = Penjualan::create(array_merge(
            $request->all(),
            [
                'perintah_kerja_id' => $request->perintah_kerja_id,
                'depositpemesanan_id' => $request->depositpemesanan_id,
                'kategori' => $request->kategori,
                // 'harga' => $request->harga,
                'kode_penjualan' => $this->kode(),
                'qrcode_penjualan' => 'https:///tigerload.id/penjualan/' . $kode,
                'tanggal' => $format_tanggal,
                'tanggal_awal' => $tanggal,
                'status' => 'posting',
            ]
        ));

        $transaksi_id = $penjualans->id;

        if ($penjualans) {

            foreach ($data_pembelians as $data_pesanan) {
                Detail_penjualan::create([
                    'penjualan_id' => $penjualans->id,
                    'typekaroseri_id' => $data_pesanan['typekaroseri_id'],
                    'kode_types' => $data_pesanan['kode_types'],
                    'nama_karoseri' => $data_pesanan['nama_karoseri'],
                    'jumlah' => $data_pesanan['jumlah'],
                    'harga' => str_replace('.', '', $data_pesanan['harga']),
                    'diskon' => str_replace('.', '', $data_pesanan['diskon']),
                    'total' => str_replace('.', '', $data_pesanan['total']),
                ]);
            }
        }


        // Fetch the Perintah_kerja record
        $spk = Perintah_kerja::where('id', $penjualans->perintah_kerja_id)->first();
        if ($spk) {
            $spk->update(['status_penjualan' => 'penjualan']);
        }
        Depositpemesanan::where(['perintah_kerja_id' => $spk->id, 'status' => 'posting'])
            ->update(['status' => 'selesai']);


        $spesifikasis = Detail_penjualan::where('penjualan_id', $penjualans->id)->get();

        $perintah_kerja = Perintah_kerja::where('id', $penjualans->perintah_kerja_id)->first();
        $depositpemesanans = Depositpemesanan::where('perintah_kerja_id', $perintah_kerja->id)->get();

        return view('admin.penjualan.show', compact('depositpemesanans', 'penjualans', 'spesifikasis'));
    }

    public function kode()
    {
        $kendaraan = Penjualan::all();
        if ($kendaraan->isEmpty()) {
            $num = "000001";
        } else {
            $id = Penjualan::getId();
            foreach ($id as $value);
            $idlm = $value->id;
            $idbr = $idlm + 1;
            $num = sprintf("%06s", $idbr);
        }

        $data = 'FP';
        $kode_kendaraan = $data . $num;
        return $kode_kendaraan;
    }

    public function show($id)
    {

        $penjualans = Penjualan::where('id', $id)->first();
        $penjual = Penjualan::find($id);
        $spesifikasis = Detail_penjualan::where('penjualan_id', $penjual->id)->get();
        $perintah_kerja = Perintah_kerja::where('id', $penjual->perintah_kerja_id)->first();
        $depositpemesanans = Depositpemesanan::where('perintah_kerja_id', $perintah_kerja->id)->get();
        return view('admin.penjualan.show', compact('depositpemesanans', 'penjualans', 'spesifikasis'));
    }


    public function cetakpdf($id)
    {
        $penjualans = Penjualan::find($id);
        $penjual = Penjualan::find($id);
        $spesifikasis = Detail_penjualan::where('penjualan_id', $penjual->id)->get();
        $perintah_kerja = Perintah_kerja::where('id', $penjual->perintah_kerja_id)->first();
        $depositpemesanans = Depositpemesanan::where('perintah_kerja_id', $perintah_kerja->id)->get();

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('admin.penjualan.cetak_pdf', compact('depositpemesanans', 'penjualans', 'spesifikasis'));
        $pdf->setPaper('letter', 'portrait');

        // Return the PDF as a response
        return $pdf->stream('Faktur_Penjualan.pdf');
    }

    public function pelanggan(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama_pelanggan' => 'required',
                'nama_alias' => 'required',
                'gender' => 'required',
                'umur' => 'required',
                'telp' => 'required',
                'alamat' => 'required',
                // 'gambar_ktp' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            ],
            [
                'nama_pelanggan.required' => 'Masukkan nama_karoseri lengkap',
                'nama_alias.required' => 'Masukkan nama_karoseri alias',
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
            $namaGambar = 'gambar_ktp/' . date('mYdHs') . rand(1, 10) . '_' . $gambar;
            $request->gambar_ktp->storeAs('public/uploads/', $namaGambar);
        } else {
            $namaGambar = null;
        }

        $kode = $this->kodepelanggan();

        $tanggal = Carbon::now()->format('Y-m-d');
        Pelanggan::create(array_merge(
            $request->all(),
            [
                'gambar' => $namaGambar,
                'kode_pelanggan' => $this->kodepelanggan(),
                'qrcode_pelanggan' => 'https://tigerload.id/pelanggan/' . $kode,
                'tanggal_awal' => $tanggal,
            ]
        ));

        return back()->with('success', 'Berhasil menambahkan pelanggan');
    }

    public function kodepelanggan()
    {
        $pelanggan = Pelanggan::all();
        if ($pelanggan->isEmpty()) {
            $num = "000001";
        } else {
            $id = Pelanggan::getId();
            foreach ($id as $value);
            $idlm = $value->id;
            $idbr = $idlm + 1;
            $num = sprintf("%06s", $idbr);
        }

        $data = 'AH';
        $kode_pelanggan = $data . $num;
        return $kode_pelanggan;
    }
}