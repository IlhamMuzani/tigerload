<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Detail_suratpenawaran;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Merek;
use App\Models\Modelken;
use App\Models\Pelanggan;
use App\Models\Spesifikasi;
use App\Models\Surat_penawaran;
use App\Models\Tipe;
use App\Models\Typekaroseri;
use App\Models\Voucher;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class InquerySuratpenawaranController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->status;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        $inquery = Surat_penawaran::query();

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

        return view('admin/inquery_suratpenawaran.index', compact('inquery'));
    }


    public function show($id)
    {
        $pembelians = Surat_penawaran::where('id', $id)->first();

        $kendaraans = Detail_suratpenawaran::where('surat_penawaran_id', $pembelians->id)->first();
        $karoseries = Typekaroseri::where('id', $pembelians->typekaroseri_id)->first();
        $spesifikasis = Spesifikasi::where('typekaroseri_id', $karoseries->id)->get();

        return view('admin.inquery_suratpenawaran.show', compact('kendaraans', 'pembelians', 'spesifikasis'));
    }


    public function edit($id)
    {
        $pembelian = Surat_penawaran::where('id', $id)->first();
        $kendaraan = Detail_suratpenawaran::where('surat_penawaran_id', $pembelian->id)->first();
        $mereks = Merek::all();
        $tipes = Tipe::all();
        $modelkens = Modelken::all();
        $pelanggans = Pelanggan::all();
        $typekaroseris = Typekaroseri::all();
        return view('admin/inquery_suratpenawaran.update', compact('typekaroseris', 'modelkens', 'kendaraan', 'pembelian', 'mereks', 'tipes', 'pelanggans'));
    }

    public function update(Request $request, $id)
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

        $spk = Surat_penawaran::findOrFail($id);

        if ($request->gambar_npwp) {
            Storage::disk('local')->delete('public/uploads/' . $spk->gambar_npwp);
            $gambar = str_replace(' ', '', $request->gambar_npwp->getClientOriginalName());
            $namaGambar = 'gambar_npwp/' . date('mYdHs') . rand(1, 10) . '_' . $gambar;
            $request->gambar_npwp->storeAs('public/uploads/', $namaGambar);
        } else {
            $namaGambar = $spk->gambar_npwp;
        }


        Surat_penawaran::where('id', $id)->update(
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
                'status' => 'posting',
            ]
        );

        $kendaraan = Detail_suratpenawaran::findOrFail($id);


        Detail_suratpenawaran::where('id', $id)->update(
            [
                'merek_id' => $request->merek_id,
            ]
        );

        $penawaran = Surat_penawaran::where('id', $id)->first();


        // ...
        $pembelian_id = $id; // Anda perlu mendefinisikan $pembelian_id, saya asumsikan ini adalah id dari pembelian yang sedang diperbarui

        // update voucher
        $jumlah_unit = $request->jumlah_unit;

        if ($jumlah_unit) {
            $existing_vouchers = Voucher::where('surat_penawaran_id', $pembelian_id)->get();
            $existing_voucher_count = $existing_vouchers->count();

            if ($jumlah_unit > $existing_voucher_count) {
                // Jika jumlah unit baru lebih besar dari jumlah voucher yang ada, buat voucher baru
                $vouchers_to_create = $jumlah_unit - $existing_voucher_count;

                for ($i = 1; $i <= $vouchers_to_create; $i++) {
                    Voucher::create([
                        'jumlah_unit' => $existing_voucher_count + $i,
                        'surat_penawaran_id' => $pembelian_id,
                        'status_terpakai' => 'belum terpakai',
                        'status' => 'posting'
                    ]);
                }
            } elseif ($jumlah_unit < $existing_voucher_count) {
                // Jika jumlah unit baru lebih kecil dari jumlah voucher yang ada, hapus voucher yang paling baru dibuat
                $vouchers_to_delete = $existing_voucher_count - $jumlah_unit;
                $vouchers_to_delete = $existing_vouchers->sortByDesc('id')->take($vouchers_to_delete);

                foreach ($vouchers_to_delete as $voucher) {
                    $voucher->delete();
                }
            }
        }

        // ...



        $pembelians = Surat_penawaran::find($id);

        $kendaraans = Detail_suratpenawaran::where('surat_penawaran_id', $pembelians->id)->first();
        $karoseries = Typekaroseri::where('id', $pembelians->typekaroseri_id)->first();
        $spesifikasis = Spesifikasi::where('typekaroseri_id', $karoseries->id)->get();


        return view('admin.inquery_suratpenawaran.show', compact('kendaraans', 'pembelians', 'spesifikasis'));
    }


    public function unpostpenawaran($id)
    {
        $ban = Surat_penawaran::where('id', $id)->first();

        $ban->update([
            'status' => 'unpost'
        ]);

        return back()->with('success', 'Berhasil');
    }

    public function postingpenawaran($id)
    {
        $ban = Surat_penawaran::where('id', $id)->first();

        $ban->update([
            'status' => 'posting'
        ]);

        return back()->with('success', 'Berhasil');
    }

    public function destroy($id)
    {
        $ban = Surat_penawaran::find($id);
        $ban->detail_kendaraan()->delete();
        $ban->delete();

        return redirect('admin/inquery_spk')->with('success', 'Berhasil menghapus Surat_penawaran');
    }
}