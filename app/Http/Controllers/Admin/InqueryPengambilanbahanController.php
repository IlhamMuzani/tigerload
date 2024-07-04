<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Detail_barang;
use App\Models\Detailpembelian;
use App\Models\Detailpengambilan;
use App\Models\Pembelian;
use App\Models\Pengambilanbahan;
use App\Models\Perintah_kerja;
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
        $spks = Perintah_kerja::all();
        $barangs = Barang::all();
        $details = Detailpengambilan::where('pengambilanbahan_id', $id)->get();

        return view('admin.inquerypengambilan.update', compact('inquery', 'spks', 'barangs', 'details'));
    }

    public function update(Request $request, $id)
    {
        $validasi_pelanggan = Validator::make($request->all(), [
            'perintah_kerja_id' => 'required',
        ], [
            'perintah_kerja_id.required' => 'Pilih nomor spk!',
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


                // Validasi stok tersedia
                $totalStokTersedia = Detail_barang::where('barang_id', $barang_id)
                    ->sum('jumlah');
                // return  $totalStokTersedia;

                if ($jumlah > $totalStokTersedia) {
                    array_push($error_pesanans, "Stok tidak mencukupi untuk barang " . $nama_barang . " dengan kode barang " . $kode_barang . ". Hanya tersedia " . $totalStokTersedia . " unit.");
                    continue;
                }

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
            'perintah_kerja_id' => $request->perintah_kerja_id,
            // 'supplier_id' => $request->supplier_id,
            'tanggal' => $format_tanggal,
            'tanggal_awal' => $tanggal,
            'status' => 'posting',
        ]);

        $transaksi_id = $transaksi->id;


        $detailIdss = $request->input('detail_ids');

        foreach ($data_pembelians as $data_pesanan) {
            $detailId = $data_pesanan['detail_id'];

            if ($detailId) {
                $detailId = $data_pesanan['detail_id'];
                if ($detailId) {

                    $jumlahPengambilan = $data_pesanan['jumlah'];
                    $barangId = $data_pesanan['barang_id'];
                    $totalHarga = 0; // Inisialisasi total harga dari semua detail barang
                    $detailBarangIds = []; // Array untuk menyimpan ID detail_barang yang digunakan
                    $jumlahTiapbarangs = []; // Array untuk menyimpan ID detail_barang yang digunakan
                    $jumlahTotalAmbil = 0; // Inisialisasi jumlah total yang akan diambil

                    // Ambil semua Detail_barang yang tersedia untuk barang_id yang sama
                    $detailBarangs = Detail_barang::where('barang_id', $barangId)
                        ->where('jumlah', '>', 0) // Hanya yang masih memiliki stok
                        ->orderBy('created_at') // Urutkan sesuai kebutuhan
                        ->get();

                    $jumlahTersediaPertama = $detailBarangs->first()->jumlah;

                    foreach ($detailBarangs as $detailBarang) {
                        // Ambil jumlah yang tersedia pada Detail_barang saat ini
                        $jumlahTersedia = $detailBarang->jumlah;
                        // Tentukan jumlah yang akan diambil dari Detail_barang ini
                        $jumlahAmbilDariDetail = min($jumlahPengambilan, $jumlahTersedia);
                        // Kurangi jumlah pada Detail_barang
                        $detailBarang->jumlah -= $jumlahAmbilDariDetail;
                        $detailBarang->save();
                        // Hitung total harga dari detail barang ini
                        $harga = $detailBarang->harga * $jumlahAmbilDariDetail;
                        $totalHarga += $harga;
                        // Akumulasikan jumlah yang diambil
                        $jumlahTotalAmbil += $jumlahAmbilDariDetail;

                        $detailBarangIds[] = $detailBarang->id;
                        $jumlahTiapbarangs[] = $jumlahAmbilDariDetail; // Simpan jumlah tiap barang yang digunakan


                        // Kurangi jumlahPengambilan dengan jumlah yang sudah diambil
                        $jumlahPengambilan -= $jumlahAmbilDariDetail;
                        // Jika jumlah yang diambil sudah mencukupi, keluar dari loop
                        if ($jumlahPengambilan <= 0) {
                            break;
                        }
                    }

                    if ($jumlahTersediaPertama >= $data_pesanan['jumlah'] && $jumlahTotalAmbil > 0) {
                        // Jika stok di detail_barang pertama sudah cukup
                        $detailBarang = $detailBarangs->first();
                        $hargaRataRata = $detailBarang->harga;
                        $hargaRataRatatotal = $detailBarang->harga * $jumlahTotalAmbil;

                    } else {
                        // Jika membutuhkan lebih dari satu detail_barang
                        $hargaRataRata = $totalHarga / $jumlahTotalAmbil;
                        // Bulatkan harga rata-rata ke kelipatan 1000
                        $kelipatan = 1000;
                        $hargaRataRataBulat = round($hargaRataRata / $kelipatan) * $kelipatan;
                        if ($hargaRataRata - ($hargaRataRataBulat - $kelipatan) < $kelipatan / 2) {
                            $hargaRataRataBulat = floor($hargaRataRata / $kelipatan) * $kelipatan;
                        } else {
                            $hargaRataRataBulat = ceil($hargaRataRata / $kelipatan) * $kelipatan;
                        }
                        $hargaRataRata = $hargaRataRataBulat;
                        $hargaRataRatatotal = $hargaRataRataBulat * $jumlahTotalAmbil;
                    }

                    Detailpengambilan::where('id', $detailId)->update([
                        'pengambilanbahan_id' => $transaksi->id,
                        'barang_id' => $barangId,
                        'detail_barang' => implode(',', $detailBarangIds), // ID detail_barang yang digunakan, dipisahkan dengan koma jika lebih dari satu
                        'jumlah_tiapbarang' => implode(',', $jumlahTiapbarangs), // Jumlah tiap barang yang digunakan, dipisahkan dengan koma jika lebih dari satu
                        'kode_barang' => $data_pesanan['kode_barang'],
                        'nama_barang' => $data_pesanan['nama_barang'],
                        'jumlah' => $data_pesanan['jumlah'],
                        'harga' => $hargaRataRata,
                        'total' => $hargaRataRatatotal,
                    ]);
                }
            } else {
                $existingDetail = Detailpengambilan::where([
                    'pengambilanbahan_id' => $transaksi->id,
                    'barang_id' => $data_pesanan['barang_id'],
                ])->first();

                if (!$existingDetail) {

                    $jumlahPengambilan = $data_pesanan['jumlah'];
                    $barangId = $data_pesanan['barang_id'];
                    $totalHarga = 0; // Inisialisasi total harga dari semua detail barang
                    $detailBarangIds = []; // Array untuk menyimpan ID detail_barang yang digunakan
                    $jumlahTiapbarangs = []; // Array untuk menyimpan ID detail_barang yang digunakan
                    $jumlahTotalAmbil = 0; // Inisialisasi jumlah total yang akan diambil

                    // Ambil semua Detail_barang yang tersedia untuk barang_id yang sama
                    $detailBarangs = Detail_barang::where('barang_id', $barangId)
                        ->where('jumlah', '>', 0) // Hanya yang masih memiliki stok
                        ->orderBy('created_at') // Urutkan sesuai kebutuhan
                        ->get();

                    $jumlahTersediaPertama = $detailBarangs->first()->jumlah;

                    foreach ($detailBarangs as $detailBarang) {
                        // Ambil jumlah yang tersedia pada Detail_barang saat ini
                        $jumlahTersedia = $detailBarang->jumlah;
                        // Tentukan jumlah yang akan diambil dari Detail_barang ini
                        $jumlahAmbilDariDetail = min($jumlahPengambilan, $jumlahTersedia);
                        // Kurangi jumlah pada Detail_barang
                        $detailBarang->jumlah -= $jumlahAmbilDariDetail;
                        $detailBarang->save();
                        // Hitung total harga dari detail barang ini
                        $harga = $detailBarang->harga * $jumlahAmbilDariDetail;
                        $totalHarga += $harga;
                        // Akumulasikan jumlah yang diambil
                        $jumlahTotalAmbil += $jumlahAmbilDariDetail;

                        $detailBarangIds[] = $detailBarang->id;
                        $jumlahTiapbarangs[] = $jumlahAmbilDariDetail; // Simpan jumlah tiap barang yang digunakan


                        // Kurangi jumlahPengambilan dengan jumlah yang sudah diambil
                        $jumlahPengambilan -= $jumlahAmbilDariDetail;
                        // Jika jumlah yang diambil sudah mencukupi, keluar dari loop
                        if ($jumlahPengambilan <= 0) {
                            break;
                        }
                    }

                    if ($jumlahTersediaPertama >= $data_pesanan['jumlah'] && $jumlahTotalAmbil > 0) {
                        // Jika stok di detail_barang pertama sudah cukup
                        $detailBarang = $detailBarangs->first();
                        $hargaRataRata = $detailBarang->harga;
                        $hargaRataRatatotal = $detailBarang->harga * $jumlahTotalAmbil;
                        
                    } else {
                        // Jika membutuhkan lebih dari satu detail_barang
                        $hargaRataRata = $totalHarga / $jumlahTotalAmbil;
                        // Bulatkan harga rata-rata ke kelipatan 1000
                        $kelipatan = 1000;
                        $hargaRataRataBulat = round($hargaRataRata / $kelipatan) * $kelipatan;
                        if ($hargaRataRata - ($hargaRataRataBulat - $kelipatan) < $kelipatan / 2) {
                            $hargaRataRataBulat = floor($hargaRataRata / $kelipatan) * $kelipatan;
                        } else {
                            $hargaRataRataBulat = ceil($hargaRataRata / $kelipatan) * $kelipatan;
                        }
                        $hargaRataRata = $hargaRataRataBulat;
                        $hargaRataRatatotal = $hargaRataRataBulat * $jumlahTotalAmbil;
                    }
                    // Membuat Detail_pemasanganpart baru
                    Detailpengambilan::create([
                        'pengambilanbahan_id' => $transaksi->id,
                        'barang_id' => $barangId,
                        'detail_barang' => implode(',', $detailBarangIds), // ID detail_barang yang digunakan, dipisahkan dengan koma jika lebih dari satu
                        'jumlah_tiapbarang' => implode(',', $jumlahTiapbarangs), // Jumlah tiap barang yang digunakan, dipisahkan dengan koma jika lebih dari satu
                        'kode_barang' => $data_pesanan['kode_barang'],
                        'nama_barang' => $data_pesanan['nama_barang'],
                        'tanggal_awal' => Carbon::now('Asia/Jakarta'),
                        'jumlah' => $data_pesanan['jumlah'],
                        'harga' => $hargaRataRata,
                        'total' => $hargaRataRatatotal,
                    ]);
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
            $jumlahDiambil = $detail->jumlah;

            // Ambil array id dari kolom detail_barang dan jumlah_tiapbarang
            $detailBarangIds = explode(',', $detail->detail_barang);
            $jumlahTiapBarang = explode(',', $detail->jumlah_tiapbarang);

            // Iterasi untuk mengembalikan stok berdasarkan detail_barang dan jumlah_tiapbarang
            for ($i = 0; $i < count($detailBarangIds); $i++) {
                $detailBarangId = $detailBarangIds[$i];
                $jumlahKembali = $jumlahTiapBarang[$i];

                // Ambil detail_barang berdasarkan id
                $detailBarang = Detail_barang::find($detailBarangId);

                if ($detailBarang) {
                    // Tambahkan jumlah yang dikembalikan ke stok
                    $detailBarang->jumlah += $jumlahKembali;
                    $detailBarang->save();
                }
            }
        }

        // Update status pengambilan bahan menjadi 'unpost'
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
            $jumlahDiambil = $detail->jumlah;

            // Ambil array id dari kolom detail_barang dan jumlah_tiapbarang
            $detailBarangIds = explode(',', $detail->detail_barang);
            $jumlahTiapBarang = explode(',', $detail->jumlah_tiapbarang);

            // Iterasi untuk mengembalikan stok berdasarkan detail_barang dan jumlah_tiapbarang
            for ($i = 0; $i < count($detailBarangIds); $i++) {
                $detailBarangId = $detailBarangIds[$i];
                $jumlahKembali = $jumlahTiapBarang[$i];

                // Ambil detail_barang berdasarkan id
                $detailBarang = Detail_barang::find($detailBarangId);

                if ($detailBarang) {
                    // Tambahkan jumlah yang dikembalikan ke stok
                    $detailBarang->jumlah -= $jumlahKembali;
                    $detailBarang->save();
                }
            }
        }

        // Update status pengambilan bahan menjadi 'unpost'
        $ban->update([
            'status' => 'posting'
        ]);

        return back()->with('success', 'Berhasil');
    }


    // public function unpostpengambilan($id)
    // {
    //     $ban = Pengambilanbahan::where('id', $id)->first();
    //     $detailpenggantianoli = Detailpengambilan::where('pengambilanbahan_id', $id)->get();

    //     foreach ($detailpenggantianoli as $detail) {
    //         $sparepartId = $detail->barang_id;
    //         $jumlahDiambil = $detail->jumlah;

    //         // Ambil semua detail barang berdasarkan barang_id
    //         $detailBarangs = Detail_barang::where('barang_id', $sparepartId)
    //             ->orderBy('created_at') // Urutkan jika diperlukan
    //             ->get();

    //         $jumlahSudahDikembalikan = 0;

    //         foreach ($detailBarangs as $detailBarang) {
    //             if ($jumlahSudahDikembalikan >= $jumlahDiambil) {
    //                 break; // Keluar dari loop jika jumlah yang dikembalikan sudah mencukupi
    //             }

    //             // Tentukan jumlah yang akan dikembalikan ke Detail_barang ini
    //             $jumlahKembali = min($jumlahDiambil - $jumlahSudahDikembalikan, $detailBarang->jumlah);

    //             // Tambahkan jumlah yang dikembalikan ke stok
    //             $detailBarang->jumlah += $jumlahKembali;
    //             $detailBarang->save();

    //             $jumlahSudahDikembalikan += $jumlahKembali;
    //         }
    //     }

    //     // Update status pengambilan bahan menjadi 'unpost'
    //     $ban->update([
    //         'status' => 'unpost'
    //     ]);

    //     return back()->with('success', 'Berhasil');
    // }


    // public function postingpengambilan($id)
    // {
    //     $ban = Pengambilanbahan::where('id', $id)->first();
    //     $detailpenggantianoli = Detailpengambilan::where('pengambilanbahan_id', $id)->get();

    //     foreach ($detailpenggantianoli as $detail) {
    //         $sparepartId = $detail->barang_id;
    //         $jumlahDiambil = $detail->jumlah;

    //         // Ambil detail barang berdasarkan barang_id
    //         $detailBarang = Detail_barang::where('barang_id', $sparepartId)->first();

    //         if ($detailBarang) {
    //             // Tambahkan jumlah yang diambil kembali ke stok
    //             $detailBarang->jumlah -= $jumlahDiambil;
    //             $detailBarang->save();
    //         }
    //     }

    //     // Update status pengambilan bahan menjadi 'unpost'
    //     $ban->update([
    //         'status' => 'posting'
    //     ]);

    //     return back()->with('success', 'Berhasil');
    // }

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