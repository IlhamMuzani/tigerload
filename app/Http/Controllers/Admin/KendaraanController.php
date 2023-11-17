<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Dompdf\Dompdf;
use App\Models\Divisi;
use App\Models\Golongan;
use App\Models\Kendaraan;
use Illuminate\Http\Request;
use App\Models\Jenis_kendaraan;
use App\Http\Controllers\Controller;
use App\Models\Gambar;
use App\Models\Merek;
use App\Models\Modelken;
use App\Models\Tipe;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class KendaraanController extends Controller
{
    public function index(Request $request)
    {

        $kendaraans = Kendaraan::all();
        return view('admin/kendaraan.index', compact('kendaraans'));
    }


    public function create()
    {
        $mereks = Merek::all();
        $modelkens = Modelken::all();
        $tipes = Tipe::all();
        return view('admin/kendaraan.create', compact('mereks', 'modelkens', 'tipes'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'no_rangka' => 'required',
                'no_mesin' => 'required',
                'tahun' => 'required',
                'warna' => 'required',
                'merek_id' => 'required',
            ],
            [
                'no_rangka.required' => 'Masukkan no rangka',
                'no_mesin.required' => 'Masukkan no mesin',
                'tahun.required' => 'Pilih Tahun',
                'warna.required' => 'Pilih warna',
                'merek_id.required' => 'Pilih merek',
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
            $namaGambar2= 'gambar_gesekannomesin/' . date('mYdHs') . rand(1, 10) . '_' . $gambar;
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

        $tanggal = Carbon::now()->format('Y-m-d');
        $kendaraan = Kendaraan::create(array_merge(
            $request->all(),
            [
                'gambar_rancangbangun' => $namaGambar,
                'gambar_gesekannomesin' => $namaGambar2,
                'gambar_gesekannorangka' => $namaGambar3,
                'gambar_serut' => $namaGambar4,
                'gambar_faktur' => $namaGambar5,
                'gambar_depan' => $namaGambar6,
                'gambar_belakang' => $namaGambar7,
                'gambar_kanan' => $namaGambar8,
                'gambar_kiri' => $namaGambar9,
                'kode_karoseri' => $this->kode(),
                'qrcode_kendaraan' => 'https:///tigerload.id/kendaraan/' . $kode,
                'tanggal_awal' => $tanggal,
                'status' => 'stok',
            ]
        ));
        
        return redirect('admin/kendaraan')->with('success', 'Berhasil menambahkan kendaraan');
    }

    public function cetakqrcode($id)
    {
        $kendaraans = Kendaraan::find($id);
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('admin.kendaraan.cetak_pdf', compact('kendaraans'));

        // Mengatur jenis kertas dan orientasi menjadi lanscape
        $pdf->setPaper('landscape');

        return $pdf->stream('QrCodeKendaraan.pdf');
    }

    public function kode()
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

        $kendaraan = Kendaraan::where('id', $id)->first();
        return view('admin/kendaraan.show', compact('kendaraan'));
    }

    public function edit($id)
    {
        $kendaraan = Kendaraan::where('id', $id)->first();
        $mereks = Merek::all();
        $tipes = Tipe::all();
        $modelkens = Modelken::all();

        return view('admin/kendaraan.update', compact('modelkens', 'kendaraan', 'mereks', 'tipes'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'no_rangka' => 'required',
                'no_mesin' => 'required',
                'tahun' => 'required',
                'warna' => 'required',
                'merek_id' => 'required',
            ],
            [
                'no_rangka.required' => 'Masukkan no rangka',
                'no_mesin.required' => 'Masukkan no mesin',
                'tahun.required' => 'Pilih Tahun',
                'warna.required' => 'Pilih warna',
                'merek_id.required' => 'Pilih merek',
            ]
        );

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return back()->withInput()->with('error', $errors);
        }

        $kendaraan = Kendaraan::findOrFail($id);

        if ($request->gambar_rancangbangun) {
            Storage::disk('local')->delete('public/uploads/' . $kendaraan->gambar_rancangbangun);
            $gambar = str_replace(' ', '', $request->gambar_rancangbangun->getClientOriginalName());
            $namaGambar = 'gambar_rancangbangun/' . date('mYdHs') . rand(1, 10) . '_' . $gambar;
            $request->gambar_rancangbangun->storeAs('public/uploads/', $namaGambar);
        } else {
            $namaGambar = $kendaraan->gambar_rancangbangun;
        }

        if ($request->gambar_gesekannomesin) {
            Storage::disk('local')->delete('public/uploads/' . $kendaraan->gambar_gesekannomesin);
            $gambar = str_replace(' ', '', $request->gambar_gesekannomesin->getClientOriginalName());
            $namaGambar2 = 'gambar_gesekannomesin/' . date('mYdHs') . rand(1, 10) . '_' . $gambar;
            $request->gambar_gesekannomesin->storeAs('public/uploads/', $namaGambar2);
        } else {
            $namaGambar2 = $kendaraan->gambar_notisgambar_gesekannomesin;
        }

        if ($request->gambar_gesekannorangka) {
            Storage::disk('local')->delete('public/uploads/' . $kendaraan->gambar_gesekannorangka);
            $gambar = str_replace(' ', '', $request->gambar_gesekannorangka->getClientOriginalName());
            $namaGambar3 = 'gambar_gesekannorangka/' . date('mYdHs') . rand(1, 10) . '_' . $gambar;
            $request->gambar_gesekannorangka->storeAs('public/uploads/', $namaGambar3);
        } else {
            $namaGambar3 = $kendaraan->gambar_gesekannorangka;
        }

        if ($request->gambar_serut) {
            Storage::disk('local')->delete('public/uploads/' . $kendaraan->gambar_serut);
            $gambar = str_replace(' ', '', $request->gambar_serut->getClientOriginalName());
            $namaGambar4 = 'gambar_serut/' . date('mYdHs') . rand(1, 10) . '_' . $gambar;
            $request->gambar_serut->storeAs('public/uploads/', $namaGambar4);
        } else {
            $namaGambar4 = $kendaraan->gambar_serut;
        }

        if ($request->gambar_faktur) {
            Storage::disk('local')->delete('public/uploads/' . $kendaraan->gambar_faktur);
            $gambar = str_replace(' ', '', $request->gambar_faktur->getClientOriginalName());
            $namaGambar5 = 'gambar_faktur/' . date('mYdHs') . rand(1, 10) . '_' . $gambar;
            $request->gambar_faktur->storeAs('public/uploads/', $namaGambar5);
        } else {
            $namaGambar5 = $kendaraan->gambar_faktur;
        }

        if ($request->gambar_depan) {
            Storage::disk('local')->delete('public/uploads/' . $kendaraan->gambar_depan);
            $gambar = str_replace(' ', '', $request->gambar_depan->getClientOriginalName());
            $namaGambar6 = 'gambar_depan/' . date('mYdHs') . rand(1, 10) . '_' . $gambar;
            $request->gambar_depan->storeAs('public/uploads/', $namaGambar6);
        } else {
            $namaGambar6 = $kendaraan->gambar_depan;
        }

        if ($request->gambar_belakang) {
            Storage::disk('local')->delete('public/uploads/' . $kendaraan->gambar_belakang);
            $gambar = str_replace(' ', '', $request->gambar_belakang->getClientOriginalName());
            $namaGambar7 = 'gambar_belakang/' . date('mYdHs') . rand(1, 10) . '_' . $gambar;
            $request->gambar_belakang->storeAs('public/uploads/', $namaGambar7);
        } else {
            $namaGambar7 = $kendaraan->gambar_belakang;
        }

        if ($request->gambar_kanan) {
            Storage::disk('local')->delete('public/uploads/' . $kendaraan->gambar_kanan);
            $gambar = str_replace(' ', '', $request->gambar_kanan->getClientOriginalName());
            $namaGambar8 = 'gambar_kanan/' . date('mYdHs') . rand(1, 10) . '_' . $gambar;
            $request->gambar_kanan->storeAs('public/uploads/', $namaGambar8);
        } else {
            $namaGambar8 = $kendaraan->gambar_kanan;
        }

        if ($request->gambar_kiri) {
            Storage::disk('local')->delete('public/uploads/' . $kendaraan->gambar_kiri);
            $gambar = str_replace(' ', '', $request->gambar_kiri->getClientOriginalName());
            $namaGambar9 = 'gambar_kiri/' . date('mYdHs') . rand(1, 10) . '_' . $gambar;
            $request->gambar_kiri->storeAs('public/uploads/', $namaGambar9);
        } else {
            $namaGambar9 = $kendaraan->gambar_kiri;
        }

        Kendaraan::where('id', $id)->update(
            [
                'no_rangka' => $request->no_rangka,
                'no_mesin' => $request->no_mesin,
                'tahun' => $request->tahun,
                'warna' => $request->warna,
                'merek_id' => $request->merek_id,
                'gambar_rancangbangun' => $namaGambar,
                'gambar_gesekannomesin' => $namaGambar2,
                'gambar_gesekannorangka' => $namaGambar3,
                'gambar_serut' => $namaGambar4,
                'gambar_faktur' => $namaGambar5,
                'gambar_depan' => $namaGambar6,
                'gambar_belakang' => $namaGambar7,
                'gambar_kanan' => $namaGambar8,
                'gambar_kiri' => $namaGambar9,
            ]
        );

        return redirect('admin/kendaraan')->with('success', 'Berhasil memperbarui kendaraan');
    }

    public function destroy($id)
    {
        $kendaraan = Kendaraan::find($id);
        $kendaraan->delete();

        return redirect('admin/kendaraan')->with('success', 'Berhasil menghapus Kendaraan');
    }

    public function merek(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama_merek' => 'required',
                'tipe_id' => 'required',
            ],
            [
                'nama_merek.required' => 'Masukkan nama merek',
                'tipe_id.required' => 'Pilih tipe',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $kode = $this->kodemerek();

        Merek::create(array_merge(
            $request->all(),
            [
                'kode_merek' => $this->kodemerek(),
                'qrcode_merek' => 'https://tigerload.id/merek/' . $kode,
                'tanggal_awal' => Carbon::now('Asia/Jakarta'),
            ],
        ));

        return back()->with('success', 'Berhasil menambahkan merek');
    }

    public function kodemerek()
    {
        $merek = Merek::all();
        if ($merek->isEmpty()) {
            $num = "000001";
        } else {
            $id = Merek::getId();
            foreach ($id as $value);
            $idlm = $value->id;
            $idbr = $idlm + 1;
            $num = sprintf("%06s", $idbr);
        }

        $data = 'AD';
        $kode_merek = $data . $num;
        return $kode_merek;
    }
}