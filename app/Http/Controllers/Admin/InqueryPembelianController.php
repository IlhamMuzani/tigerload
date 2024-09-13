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
use App\Models\Detail_barang;
use App\Models\Detailpembelian;
use App\Models\Marketing;
use App\Models\Merek;
use App\Models\Modelken;
use App\Models\Pelanggan;
use App\Models\Pembelian;
use App\Models\Penjualan;
use App\Models\Satuan;
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
        $satuans = Satuan::all();
        $details = Detailpembelian::where('pembelian_id', $id)->get();

        return view('admin.inquerypembelian.update', compact('satuans','inquery', 'suppliers', 'barangs', 'details'));
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
                    'satuan_id.' . $i => 'required',
                    'jumlah.' . $i => 'required',
                    'harga.' . $i => 'required',
                    'harga_jual.' . $i => 'required',
                    // 'diskon.' . $i => 'required',
                    'total.' . $i => 'required',
                ]);

                if ($validasi_produk->fails()) {
                    array_push($error_pesanans, "Barang nomor " . ($i + 1) . " belum dilengkapi!"); // Corrected the syntax for concatenation and indexing
                }

                $barang_id = is_null($request->barang_id[$i]) ? '' : $request->barang_id[$i];
                $kode_barang = is_null($request->kode_barang[$i]) ? '' : $request->kode_barang[$i];
                $nama_barang = is_null($request->nama_barang[$i]) ? '' : $request->nama_barang[$i];
                $satuan_id = is_null($request->satuan_id[$i]) ? '' : $request->satuan_id[$i];
                $jumlah = is_null($request->jumlah[$i]) ? '' : $request->jumlah[$i];
                $harga = is_null($request->harga[$i]) ? '' : $request->harga[$i];
                $harga_jual = is_null($request->harga_jual[$i]) ? '' : $request->harga_jual[$i];
                $diskon = is_null($request->diskon[$i]) ? '' : $request->diskon[$i];
                $total = is_null($request->total[$i]) ? '' : $request->total[$i];

                $data_pembelians->push([
                    'detail_id' => $request->detail_ids[$i] ?? null,
                    'barang_id' => $barang_id,
                    'kode_barang' => $kode_barang,
                    'nama_barang' => $nama_barang,
                    'satuan_id' => $satuan_id,
                    'jumlah' => $jumlah,
                    'harga' => $harga,
                    'harga_jual' => $harga_jual,
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
        $transaksi = Pembelian::findOrFail($id);

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
                // Update Detailpembelian
                Detailpembelian::where('id', $detailId)->update([
                    'pembelian_id' => $transaksi->id,
                    'barang_id' => $data_pesanan['barang_id'],
                    'kode_barang' => $data_pesanan['kode_barang'],
                    'nama_barang' => $data_pesanan['nama_barang'],
                    'satuan_id' => $data_pesanan['satuan_id'],
                    'jumlah' => $data_pesanan['jumlah'],
                    'harga' => $data_pesanan['harga'],
                    'harga_jual' => $data_pesanan['harga_jual'],
                    'diskon' => $data_pesanan['diskon'],
                    'total' => $data_pesanan['total'],
                ]);

                // Check if the Detail_barang already exists with the updated values
                $existingDetailBarang = Detail_barang::where('supplier_id', $request->supplier_id)
                    ->where('barang_id', $data_pesanan['barang_id'])
                    ->where('harga', $data_pesanan['harga'])
                    ->first();

                if ($existingDetailBarang) {
                    // Update the jumlah
                    $existingDetailBarang->jumlah += $data_pesanan['jumlah'];
                    $existingDetailBarang->save();

                    // Update status menjadi 'posting'
                    $existingDetailBarang->update(['status' => 'posting']);
                } else {
                    Detail_barang::create([
                        'pembelian_id' => $transaksi->id,
                        'detailpembelian_id' => $detailId,
                        'supplier_id' => $request->supplier_id,
                        'barang_id' => $data_pesanan['barang_id'],
                        'jumlah' => $data_pesanan['jumlah'],
                        'harga' => $data_pesanan['harga'],
                        'tanggal_awal' => $tanggal,
                        'status' => 'posting',
                    ]);
                }
            } else {
                // Check if the detail already exists
                $existingDetail = Detailpembelian::where([
                    'pembelian_id' => $transaksi->id,
                    'barang_id' =>  $data_pesanan['barang_id'],
                    'kode_barang' => $data_pesanan['kode_barang'],
                    'nama_barang' => $data_pesanan['nama_barang'],
                    'satuan_id' => $data_pesanan['satuan_id'],
                    'jumlah' => $data_pesanan['jumlah'],
                    'harga' => $data_pesanan['harga'],
                    'harga_jual' => $data_pesanan['harga_jual'],
                    'diskon' => $data_pesanan['diskon'],
                    'total' => $data_pesanan['total'],
                ])->first();

                // If the detail does not exist, create a new one
                if (!$existingDetail) {
                    $detailPembelian = Detailpembelian::create([
                        'pembelian_id' => $transaksi->id,
                        'barang_id' =>  $data_pesanan['barang_id'],
                        'kode_barang' => $data_pesanan['kode_barang'],
                        'nama_barang' => $data_pesanan['nama_barang'],
                        'satuan_id' => $data_pesanan['satuan_id'],
                        'jumlah' => $data_pesanan['jumlah'],
                        'harga' => $data_pesanan['harga'],
                        'harga_jual' => $data_pesanan['harga_jual'],
                        'diskon' => $data_pesanan['diskon'],
                        'total' => $data_pesanan['total'],
                    ]);
                }

                // Check if the Detail_barang already exists
                $existingDetailBarang = Detail_barang::where('supplier_id', $request->supplier_id)
                    ->where('barang_id', $data_pesanan['barang_id'])
                    ->where('harga', $data_pesanan['harga'])
                    ->first();

                if ($existingDetailBarang) {
                    // If exists, update the jumlah
                    $existingDetailBarang->jumlah += $data_pesanan['jumlah'];
                    $existingDetailBarang->save();
                } else {
                    // If not exists, create a new Detail_barang
                    Detail_barang::create([
                        'pembelian_id' => $transaksi->id,
                        'detailpembelian_id' => $detailPembelian->id,
                        'supplier_id' => $request->supplier_id,
                        'barang_id' => $data_pesanan['barang_id'],
                        'jumlah' => $data_pesanan['jumlah'],
                        'harga' => $data_pesanan['harga'],
                        'tanggal_awal' => $tanggal,
                        'status' => 'posting',
                    ]);
                }
            }
        }

        // sudah benar kurang hapus saat update 
        // foreach ($data_pembelians as $data_pesanan) {
        //     $detailId = $data_pesanan['detail_id'];

        //     if ($detailId) {
        //         // Update Detailpembelian
        //         Detailpembelian::where('id', $detailId)->update([
        //             'pembelian_id' => $transaksi->id,
        //             'barang_id' => $data_pesanan['barang_id'],
        //             'kode_barang' => $data_pesanan['kode_barang'],
        //             'nama_barang' => $data_pesanan['nama_barang'],
        //             'satuan_id' => $data_pesanan['satuan_id'],
        //             'jumlah' => $data_pesanan['jumlah'],
        //             'harga' => $data_pesanan['harga'],
        //             'harga_jual' => $data_pesanan['harga_jual'],
        //             'diskon' => $data_pesanan['diskon'],
        //             'total' => $data_pesanan['total'],
        //         ]);

        //         // Update Detail_barang if exists
        //         $existingDetailBarang = Detail_barang::where('supplier_id', $request->supplier_id)
        //             ->where('barang_id', $data_pesanan['barang_id'])
        //             ->where('harga', $data_pesanan['harga'])
        //             ->first();

        //         if ($existingDetailBarang) {
        //             // Update the jumlah
        //             $existingDetailBarang->jumlah += $data_pesanan['jumlah'];
        //             $existingDetailBarang->save();

        //             $existingDetailBarang->update(['status' => 'posting']);
        //         }
        //         // No need to create if not found, as per your requirement
        //     } else {
        //         // Check if the detail already exists
        //         $existingDetail = Detailpembelian::where([
        //             'pembelian_id' => $transaksi->id,
        //             'barang_id' =>  $data_pesanan['barang_id'],
        //             'kode_barang' => $data_pesanan['kode_barang'],
        //             'nama_barang' => $data_pesanan['nama_barang'],
        //             'satuan_id' => $data_pesanan['satuan_id'],
        //             'jumlah' => $data_pesanan['jumlah'],
        //             'harga' => $data_pesanan['harga'],
        //             'harga_jual' => $data_pesanan['harga_jual'],
        //             'diskon' => $data_pesanan['diskon'],
        //             'total' => $data_pesanan['total'],
        //         ])->first();

        //         // If the detail does not exist, create a new one
        //         if (!$existingDetail) {
        //             $detailPembelian = Detailpembelian::create([
        //                 'pembelian_id' => $transaksi->id,
        //                 'barang_id' =>  $data_pesanan['barang_id'],
        //                 'kode_barang' => $data_pesanan['kode_barang'],
        //                 'nama_barang' => $data_pesanan['nama_barang'],
        //                 'satuan_id' => $data_pesanan['satuan_id'],
        //                 'jumlah' => $data_pesanan['jumlah'],
        //                 'harga' => $data_pesanan['harga'],
        //                 'harga_jual' => $data_pesanan['harga_jual'],
        //                 'diskon' => $data_pesanan['diskon'],
        //                 'total' => $data_pesanan['total'],
        //             ]);
        //         }

        //         // Check if the Detail_barang already exists
        //         $existingDetailBarang = Detail_barang::where('supplier_id', $request->supplier_id)
        //             ->where('barang_id', $data_pesanan['barang_id'])
        //             ->where('harga', $data_pesanan['harga'])
        //             ->first();

        //         if ($existingDetailBarang) {
        //             // If exists, update the jumlah
        //             $existingDetailBarang->jumlah += $data_pesanan['jumlah'];
        //             $existingDetailBarang->save();
        //         } else {
        //             // If not exists, create a new Detail_barang
        //             Detail_barang::create([
        //                 'pembelian_id' => $transaksi->id,
        //                 'detailpembelian_id' => $detailPembelian->id,
        //                 'supplier_id' => $request->supplier_id,
        //                 'barang_id' => $data_pesanan['barang_id'],
        //                 'jumlah' => $data_pesanan['jumlah'],
        //                 'harga' => $data_pesanan['harga'],
        //                 'tanggal_awal' => $tanggal,
        //                 'status' => 'posting',
        //             ]);
        //         }
        //     }
        // }


        $pembelians = Pembelian::find($transaksi_id);

        $parts = Detailpembelian::where('pembelian_id', $pembelians->id)->get();
        Detail_barang::where('pembelian_id', $pembelians->id)
            ->where('status', 'unpost')
            ->delete();

        return view('admin.inquerypembelian.show', compact('parts', 'pembelians'));
    }


    public function unpostpembelian($id)
    {
        $pembelian = Pembelian::findOrFail($id);
        $detailpembelian = Detailpembelian::where('pembelian_id', $id)->get();

        foreach ($detailpembelian as $detail) {
            // Cari Detail_barang yang sesuai
            $existingDetailBarang = Detail_barang::where('supplier_id', $pembelian->supplier_id)
                ->where('barang_id', $detail->barang_id)
                ->where('harga', $detail->harga)
                ->first();

            if ($existingDetailBarang) {
                // Kurangi jumlahnya
                $existingDetailBarang->jumlah -= $detail->jumlah;

                // Simpan perubahan
                $existingDetailBarang->save();
            }
        }

        foreach ($detailpembelian as $detail) {
            // Cari Detail_barang yang sesuai
            $existingDetailBarang = Detail_barang::where('supplier_id', $pembelian->supplier_id)
                ->where('barang_id', $detail->barang_id)
                ->where('harga', $detail->harga)
                ->where('detailpembelian_id', $detail->id)
                ->first();

            if ($existingDetailBarang) {
                $existingDetailBarang->update(['status' => 'unpost']);
            }
        }

        // Update status pembelian menjadi 'unpost'
        $pembelian->update(['status' => 'unpost']);

        return back()->with('success', 'Pembelian berhasil di-unpost.');
    }


    public function postingpembelian($id)
    {
        $pembelian = Pembelian::findOrFail($id);
        $detailpembelian = Detailpembelian::where('pembelian_id', $id)->get();

        foreach ($detailpembelian as $detail) {
            // Cari Detail_barang yang sesuai
            $existingDetailBarang = Detail_barang::where('supplier_id', $pembelian->supplier_id)
                ->where('barang_id', $detail->barang_id)
                ->where('harga', $detail->harga)
                ->first();
            if ($existingDetailBarang) {
                // Tambahkan jumlahnya
                $existingDetailBarang->jumlah += $detail->jumlah;
                // Simpan perubahan
                $existingDetailBarang->save();
            }
        }

        foreach ($detailpembelian as $detail) {
            // Cari Detail_barang yang sesuai
            $existingDetailBarang = Detail_barang::where('supplier_id', $pembelian->supplier_id)
                ->where('barang_id', $detail->barang_id)
                ->where('harga', $detail->harga)
                ->where('detailpembelian_id', $detail->id)
                ->first();

            if ($existingDetailBarang) {
                $existingDetailBarang->update(['status' => 'posting']);
            }
        }

        // Update status pembelian menjadi 'posting'
        $pembelian->update(['status' => 'posting']);

        return back()->with('success', 'Pembelian berhasil di-posting kembali.');
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