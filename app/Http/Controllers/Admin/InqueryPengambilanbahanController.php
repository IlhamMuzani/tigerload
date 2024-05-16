<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Detailpembelian;
use App\Models\Detailpengambilan;
use App\Models\Pembelian;
use App\Models\Pengambilanbahan;
use App\Models\Spk;
use App\Models\Supplier;
use Illuminate\Support\Facades\Validator;

class InqueryPengambilanbahanController extends Controller
{
    public function index(Request $request)
    {
        // $penjualans = Penjualan::get();
        // return view('admin/inquerypenjualan.index', compact('penjualans'));

        $status = $request->status;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        $inquery = Pengambilanbahan::query();

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

        return view('admin/inquerypengambilan.index', compact('inquery'));
    }


    public function show($id)
    {

        $pengambilans = Pengambilanbahan::where('id', $id)->first();
        $pengambil = Pengambilanbahan::find($id);

        $parts = Detailpengambilan::where('pengambilanbahan_id', $pengambil->id)->get();

        return view('admin.inquerypengambilan.show', compact('parts', 'pengambilans'));
    }


    public function edit($id)
    {
        $inquery = Pengambilanbahan::where('id', $id)->first();
        $spks = Spk::all();
        $barangs = Barang::all();
        $details = Detailpengambilan::where('pengambilanbahan_ID', $id)->get();

        return view('admin.inquerypengambilan.update', compact('inquery', 'spks', 'barangs', 'details'));
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
        $transaksi = Pengambilanbahan::findOrFail($id);

        $transaksi->update([
            'supplier_id' => $request->supplier_id,
            'tanggal' => $format_tanggal,
            'tanggal_awal' => $tanggal,
            'status' => 'posting',
        ]);

        $transaksi_id = $transaksi->id;


        $detailIdss = $request->input('detail_ids');

        foreach ($data_pembelians as $data_pesanan) {
            $detailId = $data_pesanan['detail_id'];

            if ($detailId) {
                // Mendapatkan data Detail_pembelianpart yang akan diupdate
                $detailToUpdate = Detailpengambilan::find($detailId);

                if ($detailToUpdate) {
                    // Menghitung jumlah baru berdasarkan perubahan
                    $jumlahLamaDetail = $detailToUpdate->jumlah;
                    $jumlahBaruDetail = $data_pesanan['jumlah'];

                    // Menghitung selisih antara stok lama dan stok baru
                    $selisihStok = $jumlahBaruDetail - $jumlahLamaDetail;

                    // Mendapatkan data Sparepart
                    $sparepart = Barang::find($detailToUpdate->barang_id);

                    if ($sparepart) {
                        // Menghitung jumlah baru untuk Sparepart
                        $jumlahLamaSparepart = $sparepart->jumlah;
                        $jumlahBaruSparepart = $data_pesanan['jumlah'];
                        $jumlahTotalSparepart = $jumlahLamaSparepart - $selisihStok;

                        // Mengecek apakah stok cukup
                        // Update Detail_pembelianpart
                        $detailToUpdate->update([
                            'pengambilanbahan_id' => $transaksi->id,
                            'barang_id' => $data_pesanan['barang_id'],
                            'kode_barang' => $data_pesanan['kode_barang'],
                            'nama_barang' => $data_pesanan['nama_barang'],
                            'jumlah' => $data_pesanan['jumlah'],
                        ]);

                        // Temukan semua Detail_pembelianpart dengan sparepart_id yang sama
                        $sparepart->update([
                            'jumlah' => $jumlahTotalSparepart,
                        ]);
                    }
                }
            } else {
                $existingDetail = Detailpengambilan::where([
                    'pengambilanbahan_id' => $transaksi->id,
                    'barang_id' => $data_pesanan['barang_id'],
                ])->first();

                if (!$existingDetail) {
                    // Membuat Detail_pemasanganpart baru
                    Detailpengambilan::create([
                        'pengambilanbahan_id' => $transaksi->id,
                        'tanggal_awal' => Carbon::now('Asia/Jakarta'),
                        'barang_id' => $data_pesanan['barang_id'],
                        'kode_barang' => $data_pesanan['kode_barang'],
                        'nama_barang' => $data_pesanan['nama_barang'],
                        'jumlah' => $data_pesanan['jumlah'],
                    ]);

                    // Mengambil informasi jumlah yang ada di tabel Sparepart
                    $sparepart = Barang::find($data_pesanan['barang_id']);

                    if ($sparepart) {
                        // Mengurangkan jumlah yang ada di tabel Sparepart dengan jumlah yang diminta dalam request
                        $newQuantity = $sparepart->jumlah - $data_pesanan['jumlah'];

                        // Pastikan jumlah tidak kurang dari nol
                        $newQuantity = max(0, $newQuantity);

                        // Memperbarui jumlah yang ada di tabel Sparepart
                        $sparepart->update(['jumlah' => $newQuantity]);
                    }
                }
            }
        }


        $pengambilans = Pengambilanbahan::find($transaksi_id);

        $parts = Detailpengambilan::where('pengambilanbahan_id', $pengambilans->id)->get();

        return view('admin.inquerypengambilan.show', compact('parts', 'pengambilans'));
    }


    public function unpostpengambilan($id)
    {
        $ban = Pengambilanbahan::where('id', $id)->first();
        $detailpenggantianoli = Detailpengambilan::where('pengambilanbahan_id', $id)->get();


        foreach ($detailpenggantianoli as $detail) {
            $sparepartId = $detail->barang_id;
            $sparepart = Barang::find($sparepartId);

            // Add the quantity back to the stock in the Sparepart record
            $newQuantity = $sparepart->jumlah + $detail->jumlah;
            $sparepart->update(['jumlah' => $newQuantity]);
        }

        $ban->update([
            'status' => 'unpost'
        ]);

        return back()->with('success', 'Berhasil');
    }

    public function postingpengambilan($id)
    {
        $ban = Pengambilanbahan::where('id', $id)->first();

        $detailpenggantianoli = Detailpengambilan::where('pengambilanbahan_id', $id)->get();


        foreach ($detailpenggantianoli as $detail) {
            $sparepartId = $detail->barang_id;
            $sparepart = Barang::find($sparepartId);

            // Add the quantity back to the stock in the Sparepart record
            $newQuantity = $sparepart->jumlah - $detail->jumlah;
            $sparepart->update(['jumlah' => $newQuantity]);
        }

        $ban->update([
            'status' => 'posting'
        ]);

        return back()->with('success', 'Berhasil');
    }

    public function hapuspengambilan($id)
    {
        $tagihan = Pengambilanbahan::where('id', $id)->first();

        if ($tagihan) {
            $detailtagihan = Detailpengambilan::where('pengambilanbahan_id', $id)->get();
            // Delete related Detail_tagihan instances
            Detailpengambilan::where('pengambilanbahan_id', $id)->delete();

            // Delete the main Pembelian instance
            $tagihan->delete();

            return back()->with('success', 'Berhasil menghapus Pengambilan');
        } else {
            // Handle the case where the Pengambilan with the given ID is not found
            return back()->with('error', 'Pengambilan tidak ditemukan');
        }
    }

    // public function destroy($id)
    // {
    //     $part = Pengambilanbahan::find($id);
    //     $detailpenggantianoli = Detailpengambilan::where('pengambilanbahan_id', $id)->get();


    //     foreach ($detailpenggantianoli as $detail) {
    //         $sparepartId = $detail->barang_id;
    //         $sparepart = Barang::find($sparepartId);

    //         // Add the quantity back to the stock in the Sparepart record
    //         $newQuantity = $sparepart->jumlah + $detail->jumlah;
    //         $sparepart->update(['jumlah' => $newQuantity]);
    //     }

    //     $pembelian = Pengambilanbahan::find($id);
    //     $pembelian->detail_pengambilan()->delete();
    //     $pembelian->delete();


    //     return redirect('admin/inquery_pembelian')->with('success', 'Berhasil menghapus pengambilan');
    // }
}