<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Detailpembelian;
use App\Models\Detailperintah;
use App\Models\Pembelian;
use App\Models\Perintah_kerja;
use App\Models\Spesifikasi;
use App\Models\Spk;
use App\Models\Supplier;
use App\Models\Typekaroseri;
use Illuminate\Support\Facades\Validator;

class InqueryperintahkerjaController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->status;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        $inquery = Perintah_kerja::query();

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

        return view('admin/inquery_perintahkerja.index', compact('inquery'));
    }


    public function show($id)
    {

        $inquery = Perintah_kerja::where('id', $id)->first();
        $pengambil = Perintah_kerja::find($id);
        $karoseries = Typekaroseri::where('id', $pengambil->typekaroseri_id)->first();
        $spesifikasis = Spesifikasi::where('typekaroseri_id', $karoseries->id)->get();

        $parts = Detailperintah::where('perintah_kerja_id', $inquery->id)->get();

        return view('admin.inquery_perintahkerja.show', compact('spesifikasis', 'parts', 'inquery', 'karoseries'));
    }


    public function edit($id)
    {
        $inquery = Perintah_kerja::where('id', $id)->first();
        $spks = Spk::all();
        $barangs = Barang::all();
        $details = Detailperintah::where('perintah_kerja_id', $id)->get();

        return view('admin.inquery_perintahkerja.update', compact('inquery', 'spks', 'barangs', 'details'));
    }

    public function update(Request $request, $id)
    {
        $validasi_pelanggan = Validator::make($request->all(), [
            'spk_id' => 'required',
        ], [
            'spk_id.required' => 'Pilih nomor spk!',
        ]);

        $error_pelanggans = array();
        $error_pesanans = array();
        $data_pembelians = collect();


        if ($validasi_pelanggan->fails()) {
            array_push($error_pelanggans, $validasi_pelanggan->errors()->all()[0]);
        }


        if ($request->has('barang_id')) {
            for ($i = 0; $i < count($request->barang_id); $i++) {
                $validasi_produk = Validator::make($request->all(), [
                    'barang_id.' . $i => 'required',
                    'kode_barang.' . $i => 'required',
                    'nama_barang.' . $i => 'required',
                    'jumlah.' . $i => 'required',
                ]);

                if ($validasi_produk->fails()) {
                    array_push($error_pesanans, "Barang nomor " . $i + 1 . " belum dilengkapi!");
                }


                $barang_id = is_null($request->barang_id[$i]) ? '' : $request->barang_id[$i];
                $kode_barang = is_null($request->kode_barang[$i]) ? '' : $request->kode_barang[$i];
                $nama_barang = is_null($request->nama_barang[$i]) ? '' : $request->nama_barang[$i];
                $jumlah = is_null($request->jumlah[$i]) ? '' : $request->jumlah[$i];

                $data_pembelians->push(['detail_id' => $request->detail_ids[$i] ?? null, 'barang_id' => $barang_id, 'kode_barang' => $kode_barang, 'nama_barang' => $nama_barang, 'jumlah' => $jumlah]);
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
        $format_tanggal = $tanggal1->format('d F Y');
        $tanggal = Carbon::now()->format('Y-m-d');
        $transaksi = Perintah_kerja::findOrFail($id);

        $transaksi->update([
            'keterangan' => $request->keterangan,
            'spk_id' => $request->spk_id,
            'pelanggan_id' => $request->pelanggan_id,
            'typekaroseri_id' => $request->typekaroseri_id,
            'status' => 'posting',
        ]);

        $transaksi_id = $transaksi->id;
        $detailIds = $request->input('detail_ids');

        foreach ($data_pembelians as $data_pesanan) {
            $detailId = $data_pesanan['detail_id'];

            if ($detailId) {
                // Mendapatkan data Detail_pembelianpart yang akan diupdate
                $detailToUpdate = Detailperintah::find($detailId);

                if ($detailToUpdate) {
                    // Update Detail_pembelianpart
                    $detailToUpdate->update([
                        'perintah_kerja_id' => $transaksi->id,
                        'barang_id' => $data_pesanan['barang_id'],
                        'kode_barang' => $data_pesanan['kode_barang'],
                        'nama_barang' => $data_pesanan['nama_barang'],
                        'jumlah' => $data_pesanan['jumlah'],
                    ]);
                }
            } else {
                Detailperintah::create([
                    'perintah_kerja_id' => $transaksi->id,
                    'barang_id' => $data_pesanan['barang_id'],
                    'kode_barang' => $data_pesanan['kode_barang'],
                    'nama_barang' => $data_pesanan['nama_barang'],
                    'jumlah' => $data_pesanan['jumlah'],
                ]);
            }
        }

        $inquery = Perintah_kerja::find($transaksi_id);

        $karoseries = Typekaroseri::where('id', $inquery->typekaroseri_id)->first();
        $spesifikasis = Spesifikasi::where('typekaroseri_id', $karoseries->id)->get();

        $parts = Detailperintah::where('perintah_kerja_id', $inquery->id)->get();

        return view('admin.inquery_perintahkerja.show', compact('parts', 'inquery', 'karoseries', 'spesifikasis'));
    }


    public function unpostperintahkerja($id)
    {
        $ban = Perintah_kerja::where('id', $id)->first();
        $detailpenggantianoli = Detailperintah::where('perintah_kerja_id', $id)->get();


        // foreach ($detailpenggantianoli as $detail) {
        //     $sparepartId = $detail->barang_id;
        //     $sparepart = Barang::find($sparepartId);

        //     // Add the quantity back to the stock in the Sparepart record
        //     $newQuantity = $sparepart->jumlah + $detail->jumlah;
        //     $sparepart->update(['jumlah' => $newQuantity]);
        // }

        $ban->update([
            'status' => 'unpost'
        ]);

        return back()->with('success', 'Berhasil');
    }

    public function postingperintahkerja($id)
    {
        $ban = Perintah_kerja::where('id', $id)->first();

        $detailpenggantianoli = Detailperintah::where('perintah_kerja_id', $id)->get();


        // foreach ($detailpenggantianoli as $detail) {
        //     $sparepartId = $detail->barang_id;
        //     $sparepart = Barang::find($sparepartId);

        //     // Add the quantity back to the stock in the Sparepart record
        //     $newQuantity = $sparepart->jumlah - $detail->jumlah;
        //     $sparepart->update(['jumlah' => $newQuantity]);
        // }

        $ban->update([
            'status' => 'posting'
        ]);

        return back()->with('success', 'Berhasil');
    }

    public function hapusperintahkerja($id)
    {
        $perintah = Perintah_kerja::where('id', $id)->first();

        if ($perintah) {
            $detailtagihan = Detailperintah::where('perintah_kerja_id', $id)->get();
            // Delete related Detail_tagihan instances
            Detailperintah::where('perintah_kerja_id', $id)->delete();

            // Delete the main Pembelian instance
            $perintah->delete();

            return back()->with('success', 'Berhasil menghapus perintah kerja');
        } else {
            // Handle the case where the Pengambilan with the given ID is not found
            return back()->with('error', 'Pengambilan tidak ditemukan');
        }
    }
}