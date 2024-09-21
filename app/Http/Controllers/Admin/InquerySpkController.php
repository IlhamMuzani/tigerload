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
use App\Models\Marketing;
use App\Models\Merek;
use App\Models\Modelken;
use App\Models\Pelanggan;
use App\Models\Spesifikasi;
use App\Models\Spk;
use App\Models\Surat_penawaran;
use App\Models\Tipe;
use App\Models\Typekaroseri;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Mockery\Matcher\Type;

class InquerySpkController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->status;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        $inquery = Spk::query();

        if ($status) {
            $inquery->where('status', $status);
        }

        if ($tanggal_awal && $tanggal_akhir) {
            $inquery->whereBetween('tanggal_awal', [$tanggal_awal, $tanggal_akhir]);
        } elseif ($tanggal_awal) {
            $inquery->where('tanggal_awal', '>=', $tanggal_awal);
        } elseif ($tanggal_akhir) {
            $inquery->where('tanggal_awal', '<=', $tanggal_akhir);
        } else {
            // Jika tidak ada filter tanggal hari ini
            $inquery->whereDate('tanggal_awal', Carbon::today());
        }

        $inquery->orderBy('id', 'DESC');
        $inquery = $inquery->get();

        return view('admin/inqueryspk.index', compact('inquery'));
    }


    public function show($id)
    {
        $pembelians = Spk::where('id', $id)->first();

        $kendaraans = Kendaraan::where('spk_id', $pembelians->id)->first();
        $karoseries = Typekaroseri::where('id', $pembelians->typekaroseri_id)->first();
        $spesifikasis = Spesifikasi::where('typekaroseri_id', $karoseries->id)->get();

        return view('admin.inqueryspk.show', compact('kendaraans', 'pembelians', 'spesifikasis'));
    }


    public function edit($id)
    {
        $pembelian = Spk::where('id', $id)->first();
        $suratpenawarans = Surat_penawaran::where('status_pesanan', null)->get();
        return view('admin/inqueryspk.update', compact('suratpenawarans', 'pembelian'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'kategori' => 'required',
                'harga' => 'required',
                'warna' => 'required',
            ],
            [
                'kategori.required' => 'Pilih kategori',
                'harga.required' => 'Masukkan harga',
                'warna.required' => 'Masukkan warna',
            ]
        );

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return back()->withInput()->with('error', $errors);
        }

        $spk = Spk::findOrFail($id);

        if ($request->gambar_npwp) {
            Storage::disk('local')->delete('public/uploads/' . $spk->gambar_npwp);
            $gambar = str_replace(' ', '', $request->gambar_npwp->getClientOriginalName());
            $namaGambar = 'gambar_npwp/' . date('mYdHs') . rand(1, 10) . '_' . $gambar;
            $request->gambar_npwp->storeAs('public/uploads/', $namaGambar);
        } else {
            $namaGambar = $spk->gambar_npwp;
        }


        $pembelian = Spk::where('id', $id)->update(
            [
                'surat_penawaran_id' => $request->surat_penawaran_id,
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
                'panjangs' => $request->panjangs,
                'lebars' => $request->lebars,
                'tinggis' => $request->tinggis,
                'warna' => $request->warna,
                'spesifikasi' => $request->spesifikasi,
                'aksesoris' => $request->aksesoris,
                'harga' => str_replace(',', '.', str_replace('.', '', $request->harga)),
                'status' => 'posting',
            ]
        );

        $kendaraan = Kendaraan::findOrFail($id);


        Kendaraan::where('id', $id)->update(
            [
                'merek_id' => $request->merek_id,
            ]
        );

        $pembelians = Spk::find($id);
        $SuratPenawaran = Surat_penawaran::where('id', $pembelians->surat_penawaran_id)->update(['status_pesanan' => 'aktif', 'status' => 'selesai']);

        $kendaraans = Kendaraan::where('spk_id', $pembelians->id)->first();
        $karoseries = Typekaroseri::where('id', $pembelians->typekaroseri_id)->first();
        $spesifikasis = Spesifikasi::where('typekaroseri_id', $karoseries->id)->get();


        return view('admin.inqueryspk.show', compact('kendaraans', 'pembelians', 'spesifikasis'));
    }


    public function unpost($id)
    {
        $item = Spk::where('id', $id)->first();

        $SuratPenawaran = Surat_penawaran::where('id', $item->surat_penawaran_id)->update(['status_pesanan' => null, 'status' => 'posting']);

        $item->update([
            'status' => 'unpost'
        ]);

        return back()->with('success', 'Berhasil');
    }

    public function posting($id)
    {
        $item = Spk::where('id', $id)->first();
        $SuratPenawaran = Surat_penawaran::where('id', $item->surat_penawaran_id)->update(['status_pesanan' => 'aktif', 'status' => 'selesai']);

        $item->update([
            'status' => 'posting'
        ]);

        return back()->with('success', 'Berhasil');
    }

    public function destroy($id)
    {
        $item = Spk::find($id);
        $item->detail_kendaraan()->delete();
        $item->delete();

        return redirect('admin/inquery_spk')->with('success', 'Berhasil menghapus Spk');
    }

    public function hapusspk($id)
    {
        $tagihan = Spk::where('id', $id)->first();

        if ($tagihan) {
            $detailtagihan = Kendaraan::where('spk_id', $id)->get();
            // Delete related Detail_tagihan instances
            Kendaraan::where('spk_id', $id)->delete();

            // Delete the main Spk instance
            $tagihan->delete();

            return back()->with('success', 'Berhasil menghapus SPK');
        } else {
            // Handle the case where the Pembelian with the given ID is not found
            return back()->with('error', 'SPK tidak ditemukan');
        }
    }
}