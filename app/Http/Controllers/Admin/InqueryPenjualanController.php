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
use App\Models\Depositpemesanan;
use App\Models\Marketing;
use App\Models\Merek;
use App\Models\Modelken;
use App\Models\Pelanggan;
use App\Models\Pembelian;
use App\Models\Penjualan;
use App\Models\Spesifikasi;
use App\Models\Perintah_kerja;
use App\Models\Tipe;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class InqueryPenjualanController extends Controller
{
    public function index(Request $request)
    {
        // $penjualans = Penjualan::get();
        // return view('admin/inquerypenjualan.index', compact('penjualans'));

        $status = $request->status;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        $inquery = Penjualan::query();

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

        return view('admin/inquerypenjualan.index', compact('inquery'));
    }


    public function show($id)
    {

        $penjualans = Penjualan::where('id', $id)->first();
        $penjual = Penjualan::find($id);
        $spesifikasis = Spesifikasi::where('penjualan_id', $penjual->id)->get();
        return view('admin.inquerypenjualan.show', compact('penjualans', 'spesifikasis'));
    }


    public function edit($id)
    {
        $penjualans = Penjualan::where('id', $id)->first();
        $barangs = Barang::all();
        $spks = Perintah_kerja::where(['status' => 'selesai', 'status_penjualan' => null])->get();
        $details = Spesifikasi::where('penjualan_id', $id)->get();

        return view('admin/inquerypenjualan.update', compact('spks', 'barangs', 'penjualans', 'details'));
    }

    public function update(Request $request, $id)
    {
        $validasi_pelanggan = Validator::make(
            $request->all(),
            [
                'perintah_kerja_id' => 'required',
            ],
            [
                'perintah_kerja_id.required' => 'Pilih nomor spk terlebih dahulu',
            ]
        );

        $error_pelanggans = array();

        if ($validasi_pelanggan->fails()) {
            array_push($error_pelanggans, $validasi_pelanggan->errors()->all()[0]);
        }

        $error_pesanans = array();
        $data_pembelians = collect();

        // if ($request->has('barang_id')) {
        //     for ($i = 0; $i < count($request->barang_id); $i++) {
        //         $validasi_produk = Validator::make($request->all(), [
        //             'barang_id.' . $i => 'required',
        //             'kode_barang.' . $i => 'required',
        //             'nama.' . $i => 'required',
        //             'jumlah.' . $i => 'required',
        //             'harga.' . $i => 'required',
        //         ]);

        //         if ($validasi_produk->fails()) {
        //             array_push($error_pesanans, "Spesifikasi nomor " . $i + 1 . " belum dilengkapi!");
        //         }


        //         $barang_id = is_null($request->barang_id[$i]) ? '' : $request->barang_id[$i];
        //         $kode_barang = is_null($request->kode_barang[$i]) ? '' : $request->kode_barang[$i];
        //         $nama = is_null($request->nama[$i]) ? '' : $request->nama[$i];
        //         $jumlah = is_null($request->jumlah[$i]) ? '' : $request->jumlah[$i];
        //         $harga = is_null($request->harga[$i]) ? '' : $request->harga[$i];

        //         $data_pembelians->push([
        //             'detail_id' => $request->detail_ids[$i] ?? null,
        //             'barang_id' => $barang_id,
        //             'kode_barang' => $kode_barang,
        //             'nama' => $nama,
        //             'jumlah' => $jumlah,
        //             'harga' => $harga
        //         ]);
        //     }
        // } else {
        // }

        if ($request->has('barang_id') || $request->has('kode_barang') || $request->has('nama') || $request->has('jumlah') || $request->has('harga')) {
            for ($i = 0; $i < count($request->barang_id); $i++) {
                // Check if either 'keterangan_tambahan' or 'nominal_tambahan' has input
                if (empty($request->barang_id[$i]) && empty($request->kode_barang[$i]) && empty($request->nama[$i]) && empty($request->jumlah[$i]) && empty($request->harga[$i])) {
                    continue; // Skip validation if both are empty
                }

                $validasi_produk = Validator::make($request->all(), [
                    'barang_id.' . $i => 'required',
                    'kode_barang.' . $i => 'required',
                    'nama.' . $i => 'required',
                    'jumlah.' . $i => 'required',
                    'harga.' . $i => 'required',
                ]);

                if ($validasi_produk->fails()) {
                    array_push($error_pesanans, "Spesifikasi nomor " . ($i + 1) . " belum dilengkapi!");
                }

                $barang_id = $request->barang_id[$i] ?? '';
                $kode_barang = $request->kode_barang[$i] ?? '';
                $nama = $request->nama[$i] ?? '';
                $jumlah = $request->jumlah[$i] ?? '';
                $harga = $request->harga[$i] ?? '';
                $data_pembelians->push([
                    'detail_id' => $request->detail_ids[$i] ?? null,
                    'barang_id' => $barang_id,
                    'kode_barang' => $kode_barang,
                    'nama' => $nama,
                    'jumlah' => $jumlah,
                    'harga' => $harga
                ]);
            }
        }

        if ($validasi_pelanggan->fails() || $error_pesanans) {
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
        $transaksi = Penjualan::findOrFail($id);

        // Update the main transaction
        $transaksi->update([
            'perintah_kerja_id' => $request->perintah_kerja_id,
            'depositpemesanan_id' => $request->depositpemesanan_id,
            'status' => 'posting',
        ]);

        $transaksi_id = $transaksi->id;

        $detailIds = $request->input('detail_ids');

        foreach ($data_pembelians as $data_pesanan) {
            $detailId = $data_pesanan['detail_id'];

            if ($detailId) {
                Spesifikasi::where('id', $detailId)->update([
                    'penjualan_id' => $transaksi->id,
                    'barang_id' => $data_pesanan['barang_id'],
                    'kode_barang' => $data_pesanan['kode_barang'],
                    'nama' => $data_pesanan['nama'],
                    'jumlah' => $data_pesanan['jumlah'],
                    'harga' => str_replace('.', '', $data_pesanan['harga']),
                ]);
            } else {
                $existingDetail = Spesifikasi::where([
                    'penjualan_id' => $transaksi->id,
                    'barang_id' => $data_pesanan['barang_id'],
                ])->first();

                if (!$existingDetail) {
                    Spesifikasi::create([
                        'penjualan_id' => $transaksi->id,
                        'barang_id' => $data_pesanan['barang_id'],
                        'kode_barang' => $data_pesanan['kode_barang'],
                        'nama' => $data_pesanan['nama'],
                        'jumlah' => $data_pesanan['jumlah'],
                        'harga' => str_replace('.', '', $data_pesanan['harga']),
                    ]);
                }
            }
        }

        $spk = Perintah_kerja::where('id', $transaksi->perintah_kerja_id)->first();
        $spks = Perintah_kerja::where('id', $transaksi->perintah_kerja_id)->update(['status_penjualan' => 'penjualan']);
        $deposit = Depositpemesanan::where(['perintah_kerja_id' => $spk->id, 'status' => 'posting'])->first();
        if ($deposit) {
            $deposit->update(['status' => 'selesai']);
        }

        $penjualans = Penjualan::find($transaksi_id);

        $spesifikasis = Spesifikasi::where('penjualan_id', $penjualans->id)->get();

        return view('admin.inquerypenjualan.show', compact('spesifikasis', 'penjualans'));
    }

    public function unpostpenjualan($id)
    {
        $transaksi = Penjualan::where('id', $id)->first();
        $spk = Perintah_kerja::where('id', $transaksi->perintah_kerja_id)->first();
        $spks = Perintah_kerja::where('id', $transaksi->perintah_kerja_id)->update(['status_penjualan' => null]);
        $deposit = Depositpemesanan::where(['perintah_kerja_id' => $spk->id, 'status' => 'selesai'])->first();
        if ($deposit) {
            $deposit->update(['status' => 'posting']);
        }
        $transaksi->update([
            'status' => 'unpost'
        ]);

        return back()->with('success', 'Berhasil');
    }

    public function postingpenjualan($id)
    {
        $transaksi = Penjualan::where('id', $id)->first();
        $spk = Perintah_kerja::where('id', $transaksi->perintah_kerja_id)->first();
        $spks = Perintah_kerja::where('id', $transaksi->perintah_kerja_id)->update(['status_penjualan' => 'penjualan']);
        $deposit = Depositpemesanan::where(['perintah_kerja_id' => $spk->id, 'status' => 'posting'])->first();
        if ($deposit) {
            $deposit->update(['status' => 'selesai']);
        }
        $transaksi->update([
            'status' => 'posting'
        ]);

        return back()->with('success', 'Berhasil');
    }


    public function hapuspenjualan($id)
    {
        $penjualan = Penjualan::where('id', $id)->first();

        Kendaraan::where('id', $penjualan->kendaraan_id)->update([
            'status' => 'stok',
        ]);
        $penjualan->delete();
        return back()->with('success', 'Berhasil menghapus Penjualan');
    }

    public function destroy($id)
    {
        $penjualan = Penjualan::find($id);
        Kendaraan::where('id', $penjualan->kendaraan_id)->update([
            'status' => 'stok',
        ]);
        $penjualan->delete();
        return redirect('admin/inquery_penjualan')->with('success', 'Berhasil menghapus Penjualan');
    }
}