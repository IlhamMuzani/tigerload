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
use App\Models\Barang;
use App\Models\Detailpembelian;
use App\Models\Marketing;
use App\Models\Merek;
use App\Models\Modelken;
use App\Models\Pelanggan;
use App\Models\Pembelian;
use App\Models\Penjualan;
use App\Models\Spesifikasi;
use App\Models\Supplier;
use App\Models\Tipe;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class InqueryPembelianController extends Controller
{
    public function index(Request $request)
    {
        // $penjualans = Penjualan::get();
        // return view('admin/inquerypenjualan.index', compact('penjualans'));

        $status = $request->status;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        $inquery = Pembelian::query();

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

        return view('admin/inquerypembelian.index', compact('inquery'));
    }


    public function show($id)
    {

        $pembelians = Pembelian::where('id', $id)->first();
        $pembelian = Pembelian::find($id);

        $parts = Detailpembelian::where('pembelian_id', $pembelian->id)->get();

        return view('admin.inquerypembelian.show', compact('parts', 'pembelians'));
    }


    public function edit($id)
    {
        $inquery = Pembelian::where('id', $id)->first();
        $suppliers = Supplier::all();
        $barangs = Barang::all();
        $details = Detailpembelian::where('pembelian_id', $id)->get();

        return view('admin.inquerypembelian.update', compact('inquery', 'suppliers', 'barangs', 'details'));
    }

    public function update(Request $request, $id)
    {
        $validasi_pelanggan = Validator::make($request->all(), [
            'supplier_id' => 'required',
        ], [
            'supplier_id.required' => 'Pilih nama supplier!',
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
                    'satuan.' . $i => 'required',
                    'jumlah.' . $i => 'required',
                    'harga.' . $i => 'required',
                ]);

                if ($validasi_produk->fails()) {
                    array_push($error_pesanans, "Barang nomor " . $i + 1 . " belum dilengkapi!");
                }


                $barang_id = is_null($request->barang_id[$i]) ? '' : $request->barang_id[$i];
                $kode_barang = is_null($request->kode_barang[$i]) ? '' : $request->kode_barang[$i];
                $nama_barang = is_null($request->nama_barang[$i]) ? '' : $request->nama_barang[$i];
                $satuan = is_null($request->satuan[$i]) ? '' : $request->satuan[$i];
                $jumlah = is_null($request->jumlah[$i]) ? '' : $request->jumlah[$i];
                $harga = is_null($request->harga[$i]) ? '' : $request->harga[$i];

                $data_pembelians->push(['detail_id' => $request->detail_ids[$i] ?? null, 'barang_id' => $barang_id, 'kode_barang' => $kode_barang, 'nama_barang' => $nama_barang, 'satuan' => $satuan, 'jumlah' => $jumlah, 'harga' => $harga,]);
            
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
        $transaksi = Pembelian::findOrFail($id);

        $transaksi->update([
            'supplier_id' => $request->supplier_id,
            'tanggal' => $format_tanggal,
            'tanggal_awal' => $tanggal1,
            'status' => 'posting',
        ]);

        $transaksi_id = $transaksi->id;


        $detailIds = $request->input('detail_ids');

        foreach ($data_pembelians as $data_pesanan) {
            $detailId = $data_pesanan['detail_id'];

            if ($detailId) {
                // Mendapatkan data Detail_pembelianpart yang akan diupdate
                $detailToUpdate = Detailpembelian::find($detailId);

                if ($detailToUpdate) {
                    // Menghitung jumlah baru berdasarkan perubahan
                    $jumlahLamaDetail = $detailToUpdate->jumlah;
                    $jumlahBaruDetail = $data_pesanan['jumlah'];
                    $jumlahSparepart = $jumlahLamaDetail - $jumlahBaruDetail + $jumlahBaruDetail;

                    // Update Detail_pembelianpart
                    $detailToUpdate->update([
                        'pembelian_id' => $transaksi->id,
                        'tanggal_awal' => Carbon::now('Asia/Jakarta'),
                        'kode_barang' => $data_pesanan['kode_barang'],
                        'nama_barang' => $data_pesanan['nama_barang'],
                        'satuan' => $data_pesanan['satuan'],
                        'jumlah' => $data_pesanan['jumlah'],
                        'harga' => $data_pesanan['harga'],
                    ]);

                    // Temukan semua Detail_pembelianpart dengan sparepart_id yang sama
                    $detailParts = Detailpembelian::where('barang_id', $detailToUpdate->barang_id)->get();

                    // Update jumlah dan harga di Sparepart untuk semua Detail_pembelianpart yang sesuai
                    foreach ($detailParts as $detail) {
                        $sparepart = Barang::find($detail->barang_id);

                        if ($sparepart) {
                            // Menghitung jumlah baru untuk Sparepart
                            $jumlahLamaSparepart = $sparepart->jumlah;
                            $jumlahBaruSparepart = $data_pesanan['jumlah'];
                            $jumlahTotalSparepart = $jumlahLamaSparepart - $jumlahLamaDetail + $jumlahBaruSparepart;

                            // Update jumlah dan harga di Sparepart
                            $sparepart->update([
                                'jumlah' => $jumlahTotalSparepart,
                                // 'harga' => $data_pesanan['harga'],
                            ]);
                        }
                    }
                }
            } else {
                Detailpembelian::create([
                    'pembelian_id' => $transaksi->id,
                    'barang_id' => $data_pesanan['barang_id'],
                    'tanggal_awal' => Carbon::now('Asia/Jakarta'),
                    'kode_barang' => $data_pesanan['kode_barang'],
                    'nama_barang' => $data_pesanan['nama_barang'],
                    'satuan' => $data_pesanan['satuan'],
                    'jumlah' => $data_pesanan['jumlah'],
                    'harga' => $data_pesanan['harga'],
                ]);
            }
        }


        $pembelians = Pembelian::find($transaksi_id);

        $parts = Detailpembelian::where('pembelian_id', $pembelians->id)->get();

        return view('admin.inquerypembelian.show', compact('parts', 'pembelians'));
    }


    public function unpostbarang($id)
    {
        $ban = Pembelian::where('id', $id)->first();

        $ban->update([
            'status' => 'unpost'
        ]);

        return back()->with('success', 'Berhasil');
    }

    public function postingbarang($id)
    {
        $ban = Pembelian::where('id', $id)->first();

        $ban->update([
            'status' => 'posting'
        ]);

        return back()->with('success', 'Berhasil');
    }

    public function destroy($id)
    {
        $pembelian = Pembelian::find($id);
        $pembelian->detail_pembelian()->delete();
        $pembelian->delete();


        return redirect('admin/inquery_pembelian')->with('success', 'Berhasil menghapus pembelian');
    }
}