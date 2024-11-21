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
use App\Models\Detail_penjualan;
use App\Models\Perintah_kerja;
use App\Models\Tipe;
use App\Models\Typekaroseri;
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
        $spesifikasis = Detail_penjualan::where('penjualan_id', $penjual->id)->get();
        $perintah_kerja = Perintah_kerja::where('id', $penjual->perintah_kerja_id)->first();
        $depositpemesanans = Depositpemesanan::where('perintah_kerja_id', $perintah_kerja->id)->get();
        return view('admin.inquerypenjualan.show', compact('depositpemesanans', 'penjualans', 'spesifikasis'));
    }


    public function edit($id)
    {
        $penjualans = Penjualan::where('id', $id)->first();
        $barangs = Typekaroseri::all();
        $spks = Perintah_kerja::where(['status_penjualan' => null])->get();
        $details = Detail_penjualan::where('penjualan_id', $id)->get();

        return view('admin/inquerypenjualan.update', compact('spks', 'barangs', 'penjualans', 'details'));
    }

    public function update(Request $request, $id)
    {
        $validasi_pelanggan = Validator::make(
            $request->all(),
            [
                'perintah_kerja_id' => 'required',
                // 'depositpemesanan_id' => 'required',
            ],
            [
                'perintah_kerja_id.required' => 'Pilih nomor spk terlebih dahulu',
                // 'depositpemesanan_id.required' => 'Deposit Kosong',
            ]
        );

        $error_pelanggans = array();

        if ($validasi_pelanggan->fails()) {
            array_push($error_pelanggans, $validasi_pelanggan->errors()->all()[0]);
        }

        $error_pesanans = array();
        $data_pembelians = collect();

        if ($request->has('typekaroseri_id') || $request->has('kode_types') || $request->has('nama_karoseri') || $request->has('jumlah') || $request->has('harga')) {
            for ($i = 0; $i < count($request->typekaroseri_id); $i++) {
                // Check if either 'keterangan_tambahan' or 'nominal_tambahan' has input
                if (empty($request->typekaroseri_id[$i]) && empty($request->kode_types[$i]) && empty($request->nama_karoseri[$i]) && empty($request->jumlah[$i]) && empty($request->harga[$i])) {
                    continue; // Skip validation if both are empty
                }

                $validasi_produk = Validator::make($request->all(), [
                    'typekaroseri_id.' . $i => 'required',
                    'kode_types.' . $i => 'required',
                    'nama_karoseri.' . $i => 'required',
                    'jumlah.' . $i => 'required',
                    'harga.' . $i => 'required',
                    // 'diskon.' . $i => 'required',
                    'total.' . $i => 'required',
                ]);

                if ($validasi_produk->fails()) {
                    array_push($error_pesanans, "Detail_penjualan nomor " . ($i + 1) . " belum dilengkapi!");
                }

                $typekaroseri_id = $request->typekaroseri_id[$i] ?? '';
                $kode_types = $request->kode_types[$i] ?? '';
                $nama_karoseri = $request->nama_karoseri[$i] ?? '';
                $jumlah = $request->jumlah[$i] ?? '';
                $harga = $request->harga[$i] ?? '';
                $diskon = $request->diskon[$i] ?? '';
                $total = $request->total[$i] ?? '';
                $data_pembelians->push([
                    'detail_id' => $request->detail_ids[$i] ?? null,
                    'typekaroseri_id' => $typekaroseri_id,
                    'kode_types' => $kode_types,
                    'nama_karoseri' => $nama_karoseri,
                    'jumlah' => $jumlah,
                    'harga' => $harga,
                    'diskon' => $diskon,
                    'total' => $total
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
            'kategori' => $request->kategori,
            'status' => 'posting',
        ]);

        $transaksi_id = $transaksi->id;

        $detailIds = $request->input('detail_ids');

        foreach ($data_pembelians as $data_pesanan) {
            $detailId = $data_pesanan['detail_id'];

            if ($detailId) {
                Detail_penjualan::where('id', $detailId)->update([
                    'penjualan_id' => $transaksi->id,
                    'typekaroseri_id' => $data_pesanan['typekaroseri_id'],
                    'kode_types' => $data_pesanan['kode_types'],
                    'nama_karoseri' => $data_pesanan['nama_karoseri'],
                    'jumlah' => $data_pesanan['jumlah'],
                    'harga' => str_replace('.', '', $data_pesanan['harga']),
                    'diskon' => str_replace('.', '', $data_pesanan['diskon']),
                    'total' => str_replace('.', '', $data_pesanan['total']),
                ]);
            } else {
                $existingDetail = Detail_penjualan::where([
                    'penjualan_id' => $transaksi->id,
                    'typekaroseri_id' => $data_pesanan['typekaroseri_id'],
                ])->first();

                if (!$existingDetail) {
                    Detail_penjualan::create([
                        'penjualan_id' => $transaksi->id,
                        'typekaroseri_id' => $data_pesanan['typekaroseri_id'],
                        'kode_types' => $data_pesanan['kode_types'],
                        'nama_karoseri' => $data_pesanan['nama_karoseri'],
                        'jumlah' => $data_pesanan['jumlah'],
                        'harga' => str_replace('.', '', $data_pesanan['harga']),
                        'diskon' => str_replace('.', '', $data_pesanan['diskon']),
                        'total' => str_replace('.', '', $data_pesanan['total']),
                    ]);
                }
            }
        }

        // Fetch the Perintah_kerja record
        $spk = Perintah_kerja::where('id', $transaksi->perintah_kerja_id)->first();

        // Update the status of Perintah_kerja
        if ($spk) {
            $spk->update(['status_penjualan' => 'penjualan']);
        }

        // Update the status of all related Depositpemesanan records
        Depositpemesanan::where(['perintah_kerja_id' => $spk->id, 'status' => 'posting'])
            ->update(['status' => 'selesai']);

        $penjualans = Penjualan::find($transaksi_id);

        $spesifikasis = Detail_penjualan::where('penjualan_id', $penjualans->id)->get();

        $perintah_kerja = Perintah_kerja::where('id', $penjualans->perintah_kerja_id)->first();
        $depositpemesanans = Depositpemesanan::where('perintah_kerja_id', $perintah_kerja->id)->get();

        return view('admin.inquerypenjualan.show', compact('depositpemesanans', 'spesifikasis', 'penjualans'));
    }

    public function unpostpenjualan($id)
    {
        // Fetch the Penjualan record
        $transaksi = Penjualan::where('id', $id)->first();

        if (!$transaksi) {
            return back()->with('error', 'Transaksi not found.');
        }

        // Fetch the related Perintah_kerja record
        $spk = Perintah_kerja::where('id', $transaksi->perintah_kerja_id)->first();

        if ($spk) {
            // Update the status of Perintah_kerja
            $spk->update(['status_penjualan' => null]);
        }

        // Update the status of all related Depositpemesanan records
        Depositpemesanan::where(['perintah_kerja_id' => $spk->id, 'status' => 'selesai'])
            ->update(['status' => 'posting']);

        // Update the status of the Penjualan record
        $transaksi->update(['status' => 'unpost']);

        return back()->with('success', 'Berhasil');
    }


    public function postingpenjualan($id)
    {
        // Fetch the Penjualan record
        $transaksi = Penjualan::where('id', $id)->first();

        if (!$transaksi) {
            return back()->with('error', 'Transaksi not found.');
        }

        // Fetch the related Perintah_kerja record
        $spk = Perintah_kerja::where('id', $transaksi->perintah_kerja_id)->first();

        if ($spk) {
            // Update the status of Perintah_kerja
            $spk->update(['status_penjualan' => 'penjualan']);
        }

        // Update the status of all related Depositpemesanan records
        Depositpemesanan::where(['perintah_kerja_id' => $spk->id, 'status' => 'posting'])
            ->update(['status' => 'selesai']);

        // Update the status of the Penjualan record
        $transaksi->update(['status' => 'posting']);

        return back()->with('success', 'Berhasil');
    }

    public function deletedetails($id)
    {
        $item = Detail_penjualan::find($id);

        if ($item) {
            $item->delete();
            return response()->json(['message' => 'Data deleted successfully']);
        } else {
            return response()->json(['message' => 'Detail Faktur not found'], 404);
        }
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