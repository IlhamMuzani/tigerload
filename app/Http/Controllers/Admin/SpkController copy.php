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
use App\Models\Gambar;
use App\Models\Marketing;
use App\Models\Spk;
use App\Models\Typekaroseri;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SpkController extends Controller
{
    public function index()
    {
        $pelanggans = Pelanggan::all();
        $mereks = Merek::all();
        $modelkens = Modelken::all();
        $tipes = Tipe::all();
        $marketings = Marketing::all();
        $typekaroseris = Typekaroseri::all();
        return view('admin/spk.create', compact('typekaroseris', 'marketings', 'pelanggans', 'mereks', 'modelkens', 'tipes'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'pelanggan_id' => 'required',
                'typekaroseri_id' => 'required',
                // 'marketing_id' => 'required',
                'no_rangka' => 'required',
                'no_mesin' => 'required',
                'tahun' => 'required',
                'warna' => 'required',
                'merek_id' => 'required',
                'harga' => 'required',
            ],
            [
                'pelanggan_id.required' => 'Pilih pelanggan',
                'typekaroseri_id.required' => 'Pilih karoseri',
                // 'marketing_id.required' => 'Pilih marketing',
                'no_pol.required' => 'Masukkan no registrasi',
                'no_rangka.required' => 'Masukkan no rangka',
                'no_mesin.required' => 'Masukkan no mesin',
                'tahun.required' => 'Masukkan tahun',
                'warna.required' => 'Masukkan warna',
                'merek_id.required' => 'Pilih merek',
                'harga.required' => 'Masukkan harga',
            ]
        );

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return back()->withInput()->with('error', $errors);
        }


        if ($request->gambar_rancangbangun) {
            $gambar = str_replace(' ', '', $request->gambar_rancangbangun->getClientOriginalName());
            $namaGambar = 'gambar_rancangbangun/' . date('mYdHs') . rand(1, 10) . '_' . $gambar;
            $request->gambar_rancangbangun->storeAs('public/uploads/', $namaGambar);
        } else {
            $namaGambar = null;
        }

        if ($request->gambar_gesekannomesin) {
            $gambar = str_replace(' ', '', $request->gambar_gesekannomesin->getClientOriginalName());
            $namaGambar2 = 'gambar_gesekannomesin/' . date('mYdHs') . rand(1, 10) . '_' . $gambar;
            $request->gambar_gesekannomesin->storeAs('public/uploads/', $namaGambar2);
        } else {
            $namaGambar2 = null;
        }

        if ($request->gambar_gesekannorangka) {
            $gambar = str_replace(' ', '', $request->gambar_gesekannorangka->getClientOriginalName());
            $namaGambar3 = 'gambar_gesekannorangka/' . date('mYdHs') . rand(1, 10) . '_' . $gambar;
            $request->gambar_gesekannorangka->storeAs('public/uploads/', $namaGambar3);
        } else {
            $namaGambar3 = null;
        }

        if ($request->gambar_serut) {
            $gambar = str_replace(' ', '', $request->gambar_serut->getClientOriginalName());
            $namaGambar4 = 'gambar_serut/' . date('mYdHs') . rand(1, 10) . '_' . $gambar;
            $request->gambar_serut->storeAs('public/uploads/', $namaGambar4);
        } else {
            $namaGambar4 = null;
        }

        if ($request->gambar_faktur) {
            $gambar = str_replace(' ', '', $request->gambar_faktur->getClientOriginalName());
            $namaGambar5 = 'gambar_faktur/' . date('mYdHs') . rand(1, 10) . '_' . $gambar;
            $request->gambar_faktur->storeAs('public/uploads/', $namaGambar5);
        } else {
            $namaGambar5 = null;
        }

        if ($request->gambar_depan) {
            $gambar = str_replace(' ', '', $request->gambar_depan->getClientOriginalName());
            $namaGambar6 = 'gambar_depan/' . date('mYdHs') . rand(1, 10) . '_' . $gambar;
            $request->gambar_depan->storeAs('public/uploads/', $namaGambar6);
        } else {
            $namaGambar6 = null;
        }

        if ($request->gambar_belakang) {
            $gambar = str_replace(' ', '', $request->gambar_depan->getClientOriginalName());
            $namaGambar7 = 'gambar_belakang/' . date('mYdHs') . rand(1, 10) . '_' . $gambar;
            $request->gambar_belakang->storeAs('public/uploads/', $namaGambar7);
        } else {
            $namaGambar7 = null;
        }

        if ($request->gambar_kanan) {
            $gambar = str_replace(' ', '', $request->gambar_kanan->getClientOriginalName());
            $namaGambar8 = 'gambar_kanan/' . date('mYdHs') . rand(1, 10) . '_' . $gambar;
            $request->gambar_kanan->storeAs('public/uploads/', $namaGambar8);
        } else {
            $namaGambar8 = null;
        }

        if ($request->gambar_kiri) {
            $gambar = str_replace(' ', '', $request->gambar_kiri->getClientOriginalName());
            $namaGambar9 = 'gambar_kiri/' . date('mYdHs') . rand(1, 10) . '_' . $gambar;
            $request->gambar_kiri->storeAs('public/uploads/', $namaGambar9);
        } else {
            $namaGambar9 = null;
        }

        $kode = $this->kode();
        $tanggal1 = Carbon::now('Asia/Jakarta');
        $format_tanggal = $tanggal1->format('d F Y');
        $tanggal = Carbon::now()->format('Y-m-d');
        $pembelian = Spk::create(array_merge(
            $request->all(),
            [
                'pelanggan_id' => $request->pelanggan_id,
                'typekaroseri_id' => $request->typekaroseri_id,
                // 'marketing_id' => $request->marketing_id,
                'harga' => $request->harga,
                'kode_spk' => $this->kode(),
                'qrcode_spk' => 'https:///tigerload.id/pembelian/' . $kode,
                'tanggal' => $format_tanggal,
                'tanggal_awal' => $tanggal,
                'status' => 'posting',
                'status_komisi' => 'tidak aktif',
            ]
        ));

        $kode = $this->kodekendaraan();
        $pembelian_id = $pembelian->id;

        $tanggal = Carbon::now()->format('Y-m-d');
        $kendaraan = Kendaraan::create(array_merge(
            $request->all(),
            [
                'spk_id' => $pembelian_id,
                'gambar_rancangbangun' => $namaGambar,
                'gambar_gesekannomesin' => $namaGambar2,
                'gambar_gesekannorangka' => $namaGambar3,
                'gambar_serut' => $namaGambar4,
                'gambar_faktur' => $namaGambar5,
                'gambar_depan' => $namaGambar6,
                'gambar_belakang' => $namaGambar7,
                'gambar_kanan' => $namaGambar8,
                'gambar_kiri' => $namaGambar9,
                'kode_karoseri' => $this->kodekendaraan(),
                'qrcode_kendaraan' => 'https:///tigerload.id/kendaraan/' . $kode,
                'tanggal_awal' => $tanggal,
                'status' => 'stok',
            ]
        ));

        $pembelians = Spk::find($pembelian_id);

        $kendaraans = Kendaraan::where('spk_id', $pembelians->id)->first();


        return view('admin.spk.show', compact('kendaraans', 'pembelians'));
    }

    public function kode()
    {
        $kendaraan = Spk::all();
        if ($kendaraan->isEmpty()) {
            $num = "000001";
        } else {
            $id = Spk::getId();
            foreach ($id as $value);
            $idlm = $value->id;
            $idbr = $idlm + 1;
            $num = sprintf("%06s", $idbr);
        }

        $data = 'FM';
        $kode_kendaraan = $data . $num;
        return $kode_kendaraan;
    }

    public function kodekendaraan()
    {
        $kendaraan = Kendaraan::all();
        if ($kendaraan->isEmpty()) {
            $num = "000001";
        } else {
            $id = Kendaraan::getId();
            foreach ($id as $value);
            $idlm = $value->id;
            $idbr = $idlm + 1;
            $num = sprintf("%06s", $idbr);
        }

        $data = 'AG';
        $kode_kendaraan = $data . $num;
        return $kode_kendaraan;
    }
    public function show($id)
    {
        $pembelians = Spk::where('id', $id)->first();

        $kendaraans = Kendaraan::where('spk_id', $pembelians->id)->get();

        return view('admin.pembelian.show', compact('kendaraans', 'pembelians'));
    }

    public function cetakpdf($id)
    {
        $pembelians = Spk::find($id);
        $kendaraans = Kendaraan::where('spk_id', $pembelians->id)->first();

        // Create an instance of PDF
        $pdf = app('dompdf.wrapper');

        // Load the view into the PDF instance
        $pdf->loadView('admin.spk.cetak_pdf', compact('kendaraans', 'pembelians'));

        // Set other configurations if needed
        $pdf->setPaper('letter', 'portrait'); // Example configuration

        // Return the PDF as a response
        return $pdf->stream('Faktur_Pembelian.pdf');
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


    public function karoseri(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama_karoseri' => 'required',
                'type_kendaraan' => 'required',
                'panjang' => 'required',
                'lebar' => 'required',
                'tinggi' => 'required',
                'sasis' => 'required',
                'cros_member' => 'required',
                'fream_samping' => 'required',
                'diafragma' => 'required',
                'lantai' => 'required',
                'dinding' => 'required',
            ],
            [
                'nama_karoseri.required' => 'Masukkan nama karoseri',
                'type_kendaraan.required' => 'Masukkan tipe kendaraan',
                'panjang.required' => 'Masukkan panjang',
                'lebar.required' => 'Masukkan lebar',
                'tinggi.required' => 'Masukkan tinggi',
                'sasis.required' => 'Masukkan sasis',
                'cros_member.required' => 'Masukkan cros member',
                'fream_samping.required' => 'Masukkan fream_samping',
                'diafragma.required' => 'Masukkan diafragma',
                'lantai.required' => 'Masukkan lantai',
                'dinding.required' => 'Masukkan dinding',

            ]
        );

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return back()->withInput()->with('error', $errors);
        }

        $kodekaroseri = $this->kodekaroseri();

        $tanggal = Carbon::now()->format('Y-m-d');
        Typekaroseri::create(array_merge(
            $request->all(),
            [
                'kode_type' => $this->kodekaroseri(),
                'qrcode_karoseri' => 'https://tigerload.id/typekaroseri/' . $kodekaroseri,
                'tanggal_awal' => $tanggal,

            ]
        ));

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