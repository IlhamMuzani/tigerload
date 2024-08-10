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
use App\Models\Detail_penjualan;
use App\Models\Marketing;
use App\Models\Pelunasan;
use App\Models\Penjualan;
use App\Models\Perintah_kerja;
use App\Models\Spesifikasi;
use App\Models\Spk;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PelunasanController extends Controller
{
    public function index()
    {
        $penjualans = Penjualan::where(['status' => 'posting', 'status_pelunasan' => null])->get();
        return view('admin/pelunasan.create', compact('penjualans'));
    }

    public function get_itemtambahan($penjualan_id)
    {
        $details = Detail_penjualan::where(['penjualan_id' => $penjualan_id])
            ->get();
        return response()->json($details);
    }


    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'penjualan_id' => 'required',
                'kategori' => 'required',
                'tanggal_transfer' => 'required',
                'nominal' => 'required',
                // 'status_pembayaran' => 'required',
            ],
            [
                'penjualan_id.required' => 'Pilih Penjualan',
                'kategori.required' => 'Pilih Kategori',
                'tanggal_transfer.required' => 'Masukkan Tanggal',
                'nominal.required' => 'Masukkan Nominal',
                // 'status_pembayaran.required' => 'Pilih Status',
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

        $statusPelunasan = 'LUNAS'; // Default

        $selisih = (int)str_replace(['Rp', '.', ' '], '', $request->selisih);

        if ($selisih === 0) {
            $statusPelunasan = 'LUNAS';
        } elseif ($selisih < 0) {
            $statusPelunasan = 'BELUM LUNAS';
        }

        $pelunasans = Pelunasan::create(array_merge(
            $request->all(),
            [
                'kode_pelunasan' => $this->kode(),
                'qrcode_pelunasan' => 'https://tigerload.id/pelunasan/' . $kode,
                'tanggal_awal' => $tanggal,
                'tanggal' => $format_tanggal,
                'totalpenjualan' => $request->totalpenjualan ? str_replace('.', '', $request->totalpenjualan) : 0,
                'biaya_tambahan' => $request->biaya_tambahan ? str_replace('.', '', $request->biaya_tambahan) : 0,
                'dp' => $request->dp ? str_replace('.', '', $request->dp) : 0,
                'totalpembayaran' => $request->totalpembayaran ? str_replace('.', '', $request->totalpembayaran) : 0,
                'selisih' => (int)str_replace(['Rp', '.', ' '], '', $request->selisih),
                'status_pelunasan' => $statusPelunasan,
                'status' => 'posting',

            ]
        ));

        $penjualan = Penjualan::where('id', $pelunasans->penjualan_id)->update(['status' => 'selesai', 'status_pelunasan' => 'pelunasan']);

        $penjualans = Penjualan::where('id', $pelunasans->penjualan_id)->first();
        $detail_penjualans = Detail_penjualan::where('penjualan_id', $penjualans->id)->get();
        $perintah_kerja = Perintah_kerja::where('id', $penjualans->perintah_kerja_id)->first();
        $depositpemesanans = Depositpemesanan::where('perintah_kerja_id', $perintah_kerja->id)->get();
        $spesifikasis = Spesifikasi::where('penjualan_id', $penjualans->id)->get();

        return view('admin.pelunasan.show', compact('detail_penjualans', 'depositpemesanans', 'pelunasans', 'penjualans', 'spesifikasis'));
    }

    public function kode()
    {
        $kendaraan = Pelunasan::all();
        if ($kendaraan->isEmpty()) {
            $num = "000001";
        } else {
            $id = Pelunasan::getId();
            foreach ($id as $value);
            $idlm = $value->id;
            $idbr = $idlm + 1;
            $num = sprintf("%06s", $idbr);
        }

        $data = 'FL';
        $kode_kendaraan = $data . $num;
        return $kode_kendaraan;
    }

    // public function show($id)
    // {
    //     $penjualans = Pelunasan::where('id', $id)->first();

    //     return view('admin.penjualan.show', compact('penjualans'));
    // }

    public function cetakpdf($id)
    {
        $pelunasans = Pelunasan::where('id', $id)->first();
        $pelunas = Pelunasan::find($id);
        $penjualans = Penjualan::where('id', $pelunas->penjualan_id)->first();
        $detail_penjualans = Detail_penjualan::where('penjualan_id', $penjualans->id)->get();
        $perintah_kerja = Perintah_kerja::where('id', $penjualans->perintah_kerja_id)->first();
        $depositpemesanans = Depositpemesanan::where('perintah_kerja_id', $perintah_kerja->id)->get();
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('admin.pelunasan.cetak_pdf', compact('depositpemesanans', 'pelunasans', 'detail_penjualans'));
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
