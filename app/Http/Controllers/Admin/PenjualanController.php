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
use App\Models\Spesifikasi;
use App\Models\Spk;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PenjualanController extends Controller
{
    public function index()
    {
        $deposits = Depositpemesanan::all();
        $barangs = Barang::all();
        $spks = Spk::where(function ($query) {
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
                'spk_id' => 'required',
            ],
            [
                'spk_id.required' => 'Pilih nomor spk terlebih dahulu',
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

        // if ($request->has('barang_id')) {
        //     for ($i = 0; $i < count($request->barang_id); $i++) {
        //         $validasi_produk = Validator::make($request->all(), [
        //             'barang_id.' . $i => 'required',
        //             'kode_barang.' . $i => 'required',
        //             'nama.' . $i => 'required',
        //             'jumlah.' . $i => 'required',
        //             'harga.' . $i => 'required',
        //         ]);

        //         if ($validasi_produk->fails()) {
        //             array_push($error_pesanans, "Spesifikasi nomor " . $i + 1 . " belum dilengkapi!");
        //         }


        //         $barang_id = is_null($request->barang_id[$i]) ? '' : $request->barang_id[$i];
        //         $kode_barang = is_null($request->kode_barang[$i]) ? '' : $request->kode_barang[$i];
        //         $nama = is_null($request->nama[$i]) ? '' : $request->nama[$i];
        //         $jumlah = is_null($request->jumlah[$i]) ? '' : $request->jumlah[$i];
        //         $harga = is_null($request->harga[$i]) ? '' : $request->harga[$i];

        //         $data_pembelians->push(['barang_id' => $barang_id, 'kode_barang' => $kode_barang, 'nama' => $nama, 'barang_id' => $barang_id, 'jumlah' => $jumlah, 'harga' => $harga]);
        //     }
        // } else {
        // }

        if ($request->has('barang_id') || $request->has('kode_barang') || $request->has('nama') || $request->has('jumlah') || $request->has('harga')) {
            for ($i = 0; $i < count($request->barang_id); $i++) {
                // Check if either 'keterangan_tambahan' or 'nominal_tambahan' has input
                if (empty($request->barang_id[$i]) && empty($request->kode_barang[$i]) && empty($request->nama[$i]) && empty($request->jumlah[$i]) && empty($request->harga[$i])) {
                    continue; // Skip validation if both are empty
                }

                $validasi_produk = Validator::make($request->all(), [
                    'barang_id.' . $i => 'required',
                    'kode_barang.' . $i => 'required',
                    'nama.' . $i => 'required',
                    'jumlah.' . $i => 'required',
                    'harga.' . $i => 'required',
                ]);

                if ($validasi_produk->fails()) {
                    array_push($error_pesanans, "Spesifikasi nomor " . ($i + 1) . " belum dilengkapi!");
                }

                $barang_id = $request->barang_id[$i] ?? '';
                $kode_barang = $request->kode_barang[$i] ?? '';
                $nama = $request->nama[$i] ?? '';
                $jumlah = $request->jumlah[$i] ?? '';
                $harga = $request->harga[$i] ?? '';
                $data_pembelians->push(['barang_id' => $barang_id, 'kode_barang' => $kode_barang, 'nama' => $nama, 'jumlah' => $jumlah, 'harga' => $harga]);
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
                'spk_id' => $request->spk_id,
                'depositpemesanan_id' => $request->depositpemesanan_id,
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
                Spesifikasi::create([
                    'penjualan_id' => $penjualans->id,
                    'barang_id' => $data_pesanan['barang_id'],
                    'kode_barang' => $data_pesanan['kode_barang'],
                    'nama' => $data_pesanan['nama'],
                    'jumlah' => $data_pesanan['jumlah'],
                    'harga' => str_replace('.', '', $data_pesanan['harga']),
                ]);
            }
        }


        $spk = Spk::where('id', $penjualans->spk_id)->first();
        $spks = Spk::where('id', $penjualans->spk_id)->update(['status_penjualan' => 'penjualan']);

        $deposit = Depositpemesanan::where(['spk_id' => $spk->id, 'status' => 'posting'])->first();
        if ($deposit) {
            $deposit->update(['status' => 'selesai']);
        }

        $spesifikasis = Spesifikasi::where('penjualan_id', $penjualans->id)->get();

        return view('admin.penjualan.show', compact('penjualans', 'spesifikasis'));
    }

    //     $kode = $this->kode();

    //     // tgl indo
    //     $tanggal1 = Carbon::now('Asia/Jakarta');
    //     $format_tanggal = $tanggal1->format('d F Y');

    //     $tanggal = Carbon::now()->format('Y-m-d');
    //     $penjualans = Penjualan::create(array_merge(
    //         $request->all(),
    //         [
    //             'depositpemesanan_id' => $request->depositpemesanan_id,
    //             'harga' => $request->harga,
    //             'kode_penjualan' => $this->kode(),
    //             'qrcode_penjualan' => 'https:///tigerload.id/penjualan/' . $kode,
    //             'tanggal' => $format_tanggal,
    //             'tanggal_awal' => $tanggal,
    //             'status' => 'posting',
    //             'status_komisi' => 'tidak aktif',
    //         ]
    //     ));

    //     $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
    //     $kendaraan->update([
    //         'status' => 'terjual'
    //     ]);

    //     return view('admin.penjualan.show', compact('penjualans'));
    // }

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

        return view('admin.penjualan.show', compact('penjualans'));
    }

    public function cetakpdf($id)
    {
        $penjualans = Penjualan::find($id);
        $penjual = Penjualan::find($id);
        $spesifikasis = Spesifikasi::where('penjualan_id', $penjual->id)->get();
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('admin.penjualan.cetak_pdf', compact('penjualans', 'spesifikasis'));
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
                'nama_pelanggan.required' => 'Masukkan nama lengkap',
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