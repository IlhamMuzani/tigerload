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
use App\Models\Detailpembelianreturn;
use App\Models\Marketing;
use App\Models\Merek;
use App\Models\Modelken;
use App\Models\Pelanggan;
use App\Models\Returnpembelian;
use App\Models\Penjualan;
use App\Models\Spesifikasi;
use App\Models\Supplier;
use App\Models\Tipe;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class InqueryReturnpembelianController extends Controller
{
    public function index(Request $request)
    {
        // $penjualans = Penjualan::get();
        // return view('admin/inquerypenjualan.index', compact('penjualans'));

        $status = $request->status;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        $inquery = Returnpembelian::query();

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

        return view('admin/inquerypembelianreturn.index', compact('inquery'));
    }


    public function show($id)
    {

        $pembelians = Returnpembelian::where('id', $id)->first();
        $pembelian = Returnpembelian::find($id);

        $parts = Detailpembelianreturn::where('returnpembelian_id', $pembelian->id)->get();

        return view('admin.inquerypembelianreturn.show', compact('parts', 'pembelians'));
    }


    public function edit($id)
    {
        $inquery = Returnpembelian::where('id', $id)->first();
        $suppliers = Supplier::all();
        $barangs = Barang::all();
        $details = Detailpembelianreturn::where('returnpembelian_id', $id)->get();

        return view('admin.inquerypembelianreturn.update', compact('inquery', 'suppliers', 'barangs', 'details'));
    }

    public function update(Request $request, $id)
    {
        $validasi_pelanggan = Validator::make(
            $request->all(),
            [
                'supplier_id' => 'required',
            ],
            [
                'supplier_id.required' => 'Pilih nama supplier!',
            ]
        );

        $error_pelanggans = array();

        if ($validasi_pelanggan->fails()) {
            array_push($error_pelanggans, $validasi_pelanggan->errors()->all()[0]);
        }

        $error_pesanans = array();
        $data_pembelians = collect();

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
                    'total' => $total
                ]);
            }
        }


        if ($error_pelanggans || $error_pesanans) {
            return back()
                ->withInput()
                ->with('error_pelanggans', $error_pelanggans)
                ->with('error_pesanans', $error_pesanans)
                ->with('data_pembelians', $data_pembelians);
        }

        $tanggal1 = Carbon::now('Asia/Jakarta');
        $format_tanggal = $tanggal1->format('d F Y');

        $tanggal = Carbon::now()->format('Y-m-d');
        $transaksi = Returnpembelian::findOrFail($id);

        // Update the main transaction
        $transaksi->update([
            'supplier_id' => $request->supplier_id,
            'grand_total' => str_replace(',', '.', str_replace('.', '', $request->grand_total)),
            'status' => 'posting',
        ]);

        $transaksi_id = $transaksi->id;

        $detailIds = $request->input('detail_ids');

        foreach ($data_pembelians as $data_pesanan) {
            $detailId = $data_pesanan['detail_id'];

            if ($detailId) {
                // Update Detailpembelianreturn
                Detailpembelianreturn::where('id', $detailId)->update([
                    'returnpembelian_id' => $transaksi->id,
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
                // Check if the detail already exists
                $existingDetail = Detailpembelianreturn::where([
                    'returnpembelian_id' => $transaksi->id,
                    'barang_id' =>  $data_pesanan['barang_id'],
                    'kode_barang' => $data_pesanan['kode_barang'],
                    'nama_barang' => $data_pesanan['nama_barang'],
                    'satuan' => $data_pesanan['satuan'],
                    'jumlah' => $data_pesanan['jumlah'],
                    'harga' => $data_pesanan['harga'],
                    'diskon' => $data_pesanan['diskon'],
                    'total' => $data_pesanan['total'],
                ])->first();

                // If the detail does not exist, create a new one
                if (!$existingDetail) {
                    Detailpembelianreturn::create([
                        'returnpembelian_id' => $transaksi->id,
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

            // Increment the quantity of the barang
            Barang::where('id', $data_pesanan['barang_id'])->increment('jumlah', $data_pesanan['jumlah']);
        }


        $pembelians = Returnpembelian::find($transaksi_id);

        $parts = Detailpembelianreturn::where('returnpembelian_id', $pembelians->id)->get();

        return view('admin.inquerypembelianreturn.show', compact('parts', 'pembelians'));
    }


    public function unpostpembelianreturn($id)
    {
        $pembelian = Returnpembelian::where('id', $id)->first();
        $detailpembelian = Detailpembelianreturn::where('returnpembelian_id', $id)->get();

        foreach ($detailpembelian as $detail) {
            $barangId = $detail->barang_id;
            $barang = Barang::find($barangId);

            // Add the quantity back to the stock in the Sparepart record
            $newQuantity = $barang->jumlah - $detail->jumlah;
            $barang->update(['jumlah' => $newQuantity]);
        }
        $pembelian->update([
            'status' => 'unpost'
        ]);

        return back()->with('success', 'Berhasil');
    }

    public function postingpembelianreturn($id)
    {
        $pembelian = Returnpembelian::where('id', $id)->first();
        $detailpembelian = Detailpembelianreturn::where('returnpembelian_id', $id)->get();

        foreach ($detailpembelian as $detail) {
            $barangId = $detail->barang_id;
            $barang = Barang::find($barangId);

            // Add the quantity back to the stock in the Sparepart record
            $newQuantity = $barang->jumlah + $detail->jumlah;
            $barang->update(['jumlah' => $newQuantity]);
        }
        $pembelian->update([
            'status' => 'posting'
        ]);

        return back()->with('success', 'Berhasil');
    }

    public function destroy($id)
    {
        $pembelian = Returnpembelian::find($id);
        $pembelian->detail_pembelianreturn()->delete();
        $pembelian->delete();


        return redirect('admin/inquerypembelianreturn')->with('success', 'Berhasil menghapus return pembelian');
    }

    public function hapuspembelianreturn($id)
    {
        $tagihan = Returnpembelian::where('id', $id)->first();

        if ($tagihan) {
            $detailtagihan = Detailpembelianreturn::where('returnpembelian_id', $id)->get();
            // Delete related Detail_tagihan instances
            Detailpembelianreturn::where('returnpembelian_id', $id)->delete();

            // Delete the main Returnpembelian instance
            $tagihan->delete();

            return back()->with('success', 'Berhasil menghapus Returnpembelian');
        } else {
            // Handle the case where the Returnpembelian with the given ID is not found
            return back()->with('error', 'Returnpembelian tidak ditemukan');
        }
    }

    public function deletebarangsreturn($id)
    {
        $item = Detailpembelianreturn::find($id);

        if ($item) {
            $item->delete();
            return response()->json(['message' => 'Data deleted successfully']);
        } else {
            return response()->json(['message' => 'Detail Faktur not found'], 404);
        }
    }
}