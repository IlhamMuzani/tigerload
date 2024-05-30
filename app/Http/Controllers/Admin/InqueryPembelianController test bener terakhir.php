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
                    // 'diskon.' . $i => 'required',
                    'total.' . $i => 'required',
                ]);

                if ($validasi_produk->fails()) {
                    array_push($error_pesanans, "Barang nomor " . ($i + 1) . " belum dilengkapi!"); // Corrected the syntax for concatenation and indexing
                }

                $barang_id = is_null($request->barang_id[$i]) ? '' : $request->barang_id[$i];
                $kode_barang = is_null($request->kode_barang[$i]) ? '' : $request->kode_barang[$i];
                $nama_barang = is_null($request->nama_barang[$i]) ? '' : $request->nama_barang[$i];
                $satuan = is_null($request->satuan[$i]) ? '' : $request->satuan[$i];
                $jumlah = is_null($request->jumlah[$i]) ? '' : $request->jumlah[$i];
                $harga = is_null($request->harga[$i]) ? '' : $request->harga[$i];
                $diskon = is_null($request->diskon[$i]) ? '' : $request->diskon[$i];
                $total = is_null($request->total[$i]) ? '' : $request->total[$i];

                $data_pembelians->push([
                    'detail_id' => $request->detail_ids[$i] ?? null,
                    'barang_id' => $barang_id,
                    'kode_barang' => $kode_barang,
                    'nama_barang' => $nama_barang,
                    'satuan' => $satuan,
                    'jumlah' => $jumlah,
                    'harga' => $harga,
                    'diskon' => $diskon,
                    'total' => $total,
                ]);
            }
        }

        if ($error_pesanans) {
            return back()
                ->withInput()
                ->with('error_pesanans', $error_pesanans)
                ->with('data_pembelians', $data_pembelians);
        }

        $tanggal1 = Carbon::now('Asia/Jakarta');
        $format_tanggal = $tanggal1->format('d F Y');

        $tanggal = Carbon::now()->format('Y-m-d');
        $transaksi = Pembelian::findOrFail($id);

        // Update the main transaction
        $transaksi->update([
            'supplier_id' => $request->supplier_id,
            'grand_total' => str_replace(',', '.', str_replace('.', '', $request->grand_total)),
            'status' => 'posting',
        ]);

        $transaksi_id = $transaksi->id;
        $detailIds = $request->input('detail_ids');
        $allKeterangan = ''; // Initialize an empty string to accumulate keterangan values

        foreach ($data_pembelians as $data_pesanan) {
            $detailId = $data_pesanan['detail_id'];

            if ($detailId) {
                Detailpembelian::where('id', $detailId)->update([
                    'pembelian_id' => $transaksi->id,
                    'barang_id' =>  $data_pesanan['barang_id'],
                    'kode_barang' => $data_pesanan['kode_barang'],
                    'nama_barang' => $data_pesanan['nama_barang'],
                    'satuan' => $data_pesanan['satuan'],
                    'jumlah' => $data_pesanan['jumlah'],
                    'harga' => $data_pesanan['harga'],
                    'diskon' => $data_pesanan['diskon'],
                    'total' => $data_pesanan['total'],

                ]);
            } else {
                $existingDetail = Detailpembelian::where([
                    'pembelian_id' => $transaksi->id,
                    'barang_id' =>  $data_pesanan['barang_id'],
                    'kode_barang' => $data_pesanan['kode_barang'],
                    'nama_barang' => $data_pesanan['nama_barang'],
                    'satuan' => $data_pesanan['satuan'],
                    'jumlah' => $data_pesanan['jumlah'],
                    'harga' => $data_pesanan['harga'],
                    'diskon' => $data_pesanan['diskon'],
                    'total' => $data_pesanan['total'],

                ])->first();
                if (!$existingDetail) {
                    Detailpembelian::create([
                        'pembelian_id' => $transaksi->id,
                        'barang_id' =>  $data_pesanan['barang_id'],
                        'kode_barang' => $data_pesanan['kode_barang'],
                        'nama_barang' => $data_pesanan['nama_barang'],
                        'satuan' => $data_pesanan['satuan'],
                        'jumlah' => $data_pesanan['jumlah'],
                        'harga' => $data_pesanan['harga'],
                        'diskon' => $data_pesanan['diskon'],
                        'total' => $data_pesanan['total'],
                    ]);
                }
            }
        }


        $pembelians = Pembelian::find($transaksi_id);

        $parts = Detailpembelian::where('pembelian_id', $pembelians->id)->get();

        return view('admin.inquerypembelian.show', compact('parts', 'pembelians'));
    }


    public function unpostpembelian($id)
    {
        $ban = Pembelian::where('id', $id)->first();

        $ban->update([
            'status' => 'unpost'
        ]);

        return back()->with('success', 'Berhasil');
    }

    public function postingpembelian($id)
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

    public function hapuspembelian($id)
    {
        $tagihan = Pembelian::where('id', $id)->first();

        if ($tagihan) {
            $detailtagihan = Detailpembelian::where('pembelian_id', $id)->get();

            // Loop through each Detailpembelian and update associated Faktur_ekspedisi records
            // foreach ($detailtagihan as $detail) {
            //     if ($detail->faktur_ekspedisi_id) {
            //         Faktur_ekspedisi::where('id', $detail->faktur_ekspedisi_id)->update(['status_faktur' => null]);
            //     }
            // }

            // Delete related Detail_tagihan instances
            Detailpembelian::where('pembelian_id', $id)->delete();

            // Delete the main Pembelian instance
            $tagihan->delete();

            return back()->with('success', 'Berhasil menghapus Pembelian');
        } else {
            // Handle the case where the Pembelian with the given ID is not found
            return back()->with('error', 'Pembelian tidak ditemukan');
        }
    }

    public function deletebarangs($id)
    {
        $item = Detailpembelian::find($id);

        if ($item) {
            $item->delete();
            return response()->json(['message' => 'Data deleted successfully']);
        } else {
            return response()->json(['message' => 'Detail Faktur not found'], 404);
        }
    }
}