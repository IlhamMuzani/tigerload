<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Tipe;
use App\Models\Merek;
use App\Models\Modelken;
use App\Models\Kendaraan;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Detail_suratpenawaran;
use App\Models\Gambar;
use App\Models\Marketing;
use App\Models\Spesifikasi;
use App\Models\Surat_penawaran;
use App\Models\Typekaroseri;
use App\Models\Voucher;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SuratPenawaranController extends Controller
{
    public function index()
    {
        $pelanggans = Pelanggan::all();
        $mereks = Merek::all();
        // $modelkens = Modelken::all();
        $tipes = Tipe::all();
        $marketings = Marketing::all();
        $typekaroseris = Typekaroseri::all();
        return view('admin/surat_penawaran.create', compact('typekaroseris', 'marketings', 'pelanggans', 'mereks', 'tipes'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'kategori' => 'required',
                'pelanggan_id' => 'required',
                'typekaroseri_id' => 'required',
                // 'marketing_id' => 'required',
                'merek_id' => 'required',
                'harga' => 'required',
            ],
            [
                'kategori.required' => 'Pilih kategori',
                'pelanggan_id.required' => 'Pilih pelanggan',
                'typekaroseri_id.required' => 'Pilih karoseri',
                // 'marketing_id.required' => 'Pilih marketing',
                'merek_id.required' => 'Pilih merek',
                'harga.required' => 'Masukkan harga',
            ]
        );

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return back()->withInput()->with('error', $errors);
        }

        if ($request->gambar_npwp) {
            $gambar = str_replace(' ', '', $request->gambar_npwp->getClientOriginalName());
            $namaGambar = 'gambar_npwp/' . date('mYdHs') . rand(1, 10) . '_' . $gambar;
            $request->gambar_npwp->storeAs('public/uploads/', $namaGambar);
        } else {
            $namaGambar = null;
        }

        $kode = $this->kode();
        $tanggal1 = Carbon::now('Asia/Jakarta');
        $format_tanggal = $tanggal1->format('d F Y');
        $tanggal = Carbon::now()->format('Y-m-d');
        $pembelian = Surat_penawaran::create(array_merge(
            $request->all(),
            [
                'gambar_npwp' => $namaGambar,
                'no_npwp' => $request->no_npwp,
                'kategori' => $request->kategori,
                'pelanggan_id' => $request->pelanggan_id,
                'nama_pelanggan' => $request->nama_pelanggan,
                'kode_pelanggan' => $request->kode_pelanggan,
                'alamat' => $request->alamat,
                'telp' => $request->telp,
                'merek_id' => $request->merek_id,
                'nama_merek' => $request->nama_merek,
                'tipe' => $request->tipe,
                'typekaroseri_id' => $request->typekaroseri_id,
                'kode_type' => $request->kode_type,
                'nama_karoseri' => $request->nama_karoseri,
                'panjang' => $request->panjang,
                'lebar' => $request->lebar,
                'tinggi' => $request->tinggi,
                'spesifikasi' => $request->spesifikasi,
                'aksesoris' => $request->aksesoris,
                'jumlah_unit' => $request->jumlah_unit,
                'harga' => str_replace(',', '.', str_replace('.', '', $request->harga)),
                'kode_spk' => $this->kode(),
                'qrcode_penawaran' => 'https:///tigerload.id/surat_penawaran/' . $kode,
                'tanggal' => $format_tanggal,
                'tanggal_awal' => $tanggal,
                'status' => 'posting',
                'status_komisi' => 'tidak aktif',
            ]
        ));

        // $kode = $this->kodekendaraan();
        $pembelian_id = $pembelian->id;

        $tanggal = Carbon::now()->format('Y-m-d');
        $kendaraan = Detail_suratpenawaran::create(array_merge(
            $request->all(),
            [
                'surat_penawaran_id' => $pembelian_id,
                'qrcode_kendaraan' => 'https:///tigerload.id/kendaraan/' . $kode,
                'tanggal_awal' => $tanggal,
                'status' => 'stok',
            ]
        ));

        $jumlah_unit = $request->jumlah_unit;

        if ($jumlah_unit) {
            // Memeriksa jika jumlah unit adalah 1
            if ($jumlah_unit == 1) {
                // Membuat voucher untuk 1 unit
                Voucher::create([
                    'jumlah_unit' => $jumlah_unit,
                    'surat_penawaran_id' => $pembelian_id,
                    'status_terpakai' => 'belum terpakai',
                    'status' => 'posting'
                ]);
            } else {
                // Membuat voucher untuk lebih dari 1 unit
                for ($i = 1; $i <= $jumlah_unit; $i++) {
                    Voucher::create([
                        'jumlah_unit' => $i,
                        'surat_penawaran_id' => $pembelian_id,
                        'status_terpakai' => 'belum terpakai',
                        'status' => 'posting'
                    ]);
                }
            }
        }


        $pembelians = Surat_penawaran::find($pembelian_id);

        $kendaraans = Detail_suratpenawaran::where('surat_penawaran_id', $pembelians->id)->first();
        $karoseries = Typekaroseri::where('id', $pembelians->typekaroseri_id)->first();
        $spesifikasis = Spesifikasi::where('typekaroseri_id', $karoseries->id)->get();


        return view('admin.surat_penawaran.show', compact('kendaraans', 'pembelians', 'spesifikasis'));
    }

    public function kode()
    {
        $kendaraan = Surat_penawaran::all();
        if ($kendaraan->isEmpty()) {
            $num = "000001";
        } else {
            $id = Surat_penawaran::getId();
            foreach ($id as $value);
            $idlm = $value->id;
            $idbr = $idlm + 1;
            $num = sprintf("%06s", $idbr);
        }

        $data = 'PK';
        $kode_kendaraan = $data . $num;
        return $kode_kendaraan;
    }

    // public function kodekendaraan()
    // {
    //     $kendaraan = Kendaraan::all();
    //     if ($kendaraan->isEmpty()) {
    //         $num = "000001";
    //     } else {
    //         $id = Kendaraan::getId();
    //         foreach ($id as $value);
    //         $idlm = $value->id;
    //         $idbr = $idlm + 1;
    //         $num = sprintf("%06s", $idbr);
    //     }

    //     $data = 'AG';
    //     $kode_kendaraan = $data . $num;
    //     return $kode_kendaraan;
    // }
    public function show($id)
    {
        $pembelians = Surat_penawaran::where('id', $id)->first();

        $kendaraans = Detail_suratpenawaran::where('surat_penawaran_id', $pembelians->id)->get();
        $karoseries = Typekaroseri::where('id', $pembelians->typekaroseri_id)->first();
        $spesifikasis = Spesifikasi::where('typekaroseri_id', $karoseries->id)->get();

        return view('admin.pembelian.show', compact('kendaraans', 'pembelians', 'spesifikasis'));
    }

    public function cetakpdf($id)
    {
        $pembelians = Surat_penawaran::find($id);
        $kendaraans = Detail_suratpenawaran::where('surat_penawaran_id', $pembelians->id)->first();
        $karoseries = Typekaroseri::where('id', $pembelians->typekaroseri_id)->first();
        $spesifikasis = Spesifikasi::where('typekaroseri_id', $karoseries->id)->get();
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('admin.surat_penawaran.cetak_pdf', compact('kendaraans', 'pembelians', 'spesifikasis'));
        $pdf->setPaper('folio', 'portrait');
        return $pdf->stream('Faktur_Pembelian.pdf');
    }

    public function pelanggan(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama_pelanggan' => 'required',
                'nama_alias' => 'required',
                // 'gender' => 'required',
                // 'umur' => 'required',
                'telp' => 'required',
                'alamat' => 'required',
                // 'gambar_ktp' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            ],
            [
                'nama_pelanggan.required' => 'Masukkan nama lengkap',
                'nama_alias.required' => 'Masukkan nama alias',
                // 'gender.required' => 'Pilih gender',
                // 'umur.required' => 'Masukkan umur',
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

    public function karoseri(Request $request)
    {
        $validasi_pelanggan = Validator::make(
            $request->all(),
            [
                'nama_karoseri' => 'required',
                // 'type_kendaraan' => 'required',
                'panjang' => 'required',
                'lebar' => 'required',
                'tinggi' => 'required',
            ],
            [
                'nama_karoseri.required' => 'Masukkan bentuk karoseri',
                // 'type_kendaraan.required' => 'Masukkan tipe kendaraan',
                'panjang.required' => 'Masukkan panjang',
                'lebar.required' => 'Masukkan lebar',
                'tinggi.required' => 'Masukkan tinggi',
            ]
        );

        $error_pelanggans = array();

        if ($validasi_pelanggan->fails()) {
            array_push($error_pelanggans, $validasi_pelanggan->errors()->all()[0]);
        }

        $error_pesanans = array();
        $data_pembelians = collect();

        if ($request->has('nama')) {
            for ($i = 0; $i < count($request->nama); $i++) {
                $validasi_produk = Validator::make($request->all(), [
                    'nama.' . $i => 'required',
                ]);

                if ($validasi_produk->fails()) {
                    array_push($error_pesanans, "Spesifikasi nomor " . $i + 1 . " belum dilengkapi!");
                }


                $nama = is_null($request->nama[$i]) ? '' : $request->nama[$i];

                $data_pembelians->push(['nama' => $nama]);
            }
        } else {
        }

        if ($error_pelanggans || $error_pesanans) {
            return back()
                ->withInput()
                ->with('error_pelanggans', $error_pelanggans)
                ->with('error_pesanans', $error_pesanans)
                ->with('data_pembelians', $data_pembelians);
        }

        // format tanggal indo
        $tanggal1 = Carbon::now('Asia/Jakarta');

        $kode = $this->kode();
        $tanggal = Carbon::now()->format('Y-m-d');
        $transaksi = Typekaroseri::create(array_merge(
            $request->all(),
            [
                'kode_type' => $this->kode(),
                'qrcode_karoseri' => 'https://tigerload.id/typekaroseri/' . $kode,
                'tanggal_awal' => $tanggal,

            ]
        ));

        $transaksi_id = $transaksi->id;

        // $kodeban = $this->kodeban();

        if ($transaksi) {

            foreach ($data_pembelians as $data_pesanan) {
                Spesifikasi::create([
                    'typekaroseri_id' => $transaksi->id,
                    'nama' => $data_pesanan['nama'],
                ]);
            }
        }

        return back()->with('success', 'Berhasil menambahkan type karoseri');
    }

    public function kodekaroseri()
    {
        $typekaroseri = Typekaroseri::all();
        if ($typekaroseri->isEmpty()) {
            $num = "000001";
        } else {
            $id = Typekaroseri::getId();
            foreach ($id as $value);
            $idlm = $value->id;
            $idbr = $idlm + 1;
            $num = sprintf("%06s", $idbr);
        }

        $data = 'AG';
        $kode_type = $data . $num;
        return $kode_type;
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
