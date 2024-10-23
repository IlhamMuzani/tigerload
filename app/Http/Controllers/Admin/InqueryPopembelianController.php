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
use App\Models\Detailpopembelian;
use App\Models\Pembelian;
use App\Models\Popembelian;
use App\Models\Satuan;
use App\Models\Supplier;
use Illuminate\Support\Facades\Validator;

class InqueryPopembelianController extends Controller
{
    public function index(Request $request)
    {
        // $penjualans = Penjualan::get();
        // return view('admin/inquerypenjualan.index', compact('penjualans'));

        $status = $request->status;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        $inquery = Popembelian::query();

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

        return view('admin/inquerypopembelian.index', compact('inquery'));
    }


    public function show($id)
    {

        $pembelians = Popembelian::where('id', $id)->first();
        $pembelian = Popembelian::find($id);

        $parts = Detailpopembelian::where('popembelian_id', $pembelian->id)->get();

        return view('admin.inquerypopembelian.show', compact('parts', 'pembelians'));
    }


    public function edit($id)
    {
        $inquery = Popembelian::where('id', $id)->first();
        $suppliers = Supplier::all();
        $barangs = Barang::all();
        $satuans = Satuan::all();

        $details = Detailpopembelian::where('popembelian_id', $id)->get();

        return view('admin.inquerypopembelian.update', compact('satuans', 'inquery', 'details', 'suppliers', 'barangs'));
    }

    public function update(Request $request, $id)
    {
        $validasi_pelanggan = Validator::make(
            $request->all(),
            [
                'supplier_id' => 'required',
            ],
            [
                'supplier_id.required' => 'Pilih nama supplier',
            ]
        );

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
                    // 'harga.' . $i => 'required',
                    'jumlah.' . $i => 'required',
                    'satuan_id.' . $i => 'required',
                    // 'total.' . $i => 'required',
                ]);

                if ($validasi_produk->fails()) {
                    array_push($error_pesanans, "Barang nomor " . $i + 1 . " belum dilengkapi!");
                }

                $barang_id = is_null($request->barang_id[$i]) ? '' : $request->barang_id[$i];
                $kode_barang = is_null($request->kode_barang[$i]) ? '' : $request->kode_barang[$i];
                $nama_barang = is_null($request->nama_barang[$i]) ? '' : $request->nama_barang[$i];
                // $harga = is_null($request->harga[$i]) ? '' : $request->harga[$i];
                $jumlah = is_null($request->jumlah[$i]) ? '' : $request->jumlah[$i];
                $satuan_id = is_null($request->satuan_id[$i]) ? '' : $request->satuan_id[$i];
                // $total = is_null($request->total[$i]) ? '' : $request->total[$i];

                $data_pembelians->push([
                    'detail_id' => $request->detail_ids[$i] ?? null,
                    'barang_id' => $barang_id,
                    'kode_barang' => $kode_barang,
                    'nama_barang' => $nama_barang,
                    // 'harga' => $harga,
                    'jumlah' => $jumlah,
                    'satuan_id' => $satuan_id,
                    // 'total' => $total
                ]);
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

        $transaksi = Popembelian::findOrFail($id);

        $transaksi->update([
            'supplier_id' => $request->supplier_id,
            'status' => 'posting',
        ]);

        $transaksi_id = $transaksi->id;


        $detailIds = $request->input('detail_ids');

        foreach ($data_pembelians as $data_pesanan) {
            $detailId = $data_pesanan['detail_id'];

            if ($detailId) {
                // Mendapatkan data Detail_pembelianpart yang akan diupdate
                $detailToUpdate = Detailpopembelian::find($detailId);

                if ($detailToUpdate) {
                    // Update Detail_pembelianpart
                    $detailToUpdate->update([
                        'popembelian_id' => $transaksi->id,
                        'barang_id' => $data_pesanan['barang_id'],
                        'kode_barang' => $data_pesanan['kode_barang'],
                        'nama_barang' => $data_pesanan['nama_barang'],
                        // 'harga' => $data_pesanan['harga'],
                        'jumlah' => $data_pesanan['jumlah'],
                        'satuan_id' => $data_pesanan['satuan_id'],
                        // 'total' => $data_pesanan['total'],
                    ]);
                }
            } else {
                Detailpopembelian::create([
                    'popembelian_id' => $transaksi->id,
                    'barang_id' => $data_pesanan['barang_id'],
                    'kode_barang' => $data_pesanan['kode_barang'],
                    'nama_barang' => $data_pesanan['nama_barang'],
                    // 'harga' => $data_pesanan['harga'],
                    'jumlah' => $data_pesanan['jumlah'],
                    'satuan_id' => $data_pesanan['satuan_id'],
                    // 'total' => $data_pesanan['total'],
                ]);
            }
        }


        $pembelians = Popembelian::find($transaksi_id);

        $parts = Detailpopembelian::where('popembelian_id', $pembelians->id)->get();

        return view('admin.inquerypopembelian.show', compact('parts', 'pembelians'));
    }


    public function unpostbarangpo($id)
    {
        $ban = Popembelian::where('id', $id)->first();

        $ban->update([
            'status' => 'unpost'
        ]);

        return back()->with('success', 'Berhasil');
    }

    public function postingbarangpo($id)
    {
        $ban = Popembelian::where('id', $id)->first();

        $ban->update([
            'status' => 'posting'
        ]);

        return back()->with('success', 'Berhasil');
    }

    public function deletedetailpo($id)
    {
        $item = Detailpopembelian::find($id);

        if ($item) {
            $item->delete();
            return response()->json(['message' => 'Data deleted successfully']);
        } else {
            return response()->json(['message' => 'Detail Faktur not found'], 404);
        }
    }

    public function destroy($id)
    {
        $pembelian = Popembelian::find($id);
        $pembelian->detail_popembelian()->delete();
        $pembelian->delete();


        return redirect('admin/inquery_popembelian')->with('success', 'Berhasil menghapus po pembelian');
    }
}