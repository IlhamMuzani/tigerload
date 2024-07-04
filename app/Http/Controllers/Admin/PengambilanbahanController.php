<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Detail_barang;
use App\Models\Detailpengambilan;
use App\Models\Pengambilanbahan;
use App\Models\Perintah_kerja;
use App\Models\Spesifikasi;
use App\Models\Spk;
use App\Models\Typekaroseri;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Crypt;

class PengambilanbahanController extends Controller
{
    public function index()
    {
        $spks = Perintah_kerja::get();
        $barangs = Barang::get();
        return view('admin/pengambilanbahan.index', compact('spks', 'barangs'));
    }

    public function store(Request $request)
    {
        $validasi_pelanggan = Validator::make(
            $request->all(),
            [
                'perintah_kerja_id' => 'required',
            ],
            [
                'perintah_kerja_id.required' => 'Pilih nomor SPK',
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
                    'jumlah.' . $i => 'required|numeric|min:1',
                ]);

                if ($validasi_produk->fails()) {
                    array_push($error_pesanans, "Barang nomor " . ($i + 1) . " belum dilengkapi!");
                    continue;
                }

                $barang_id = $request->barang_id[$i];
                $kode_barang = $request->kode_barang[$i];
                $nama_barang = $request->nama_barang[$i];
                $jumlah = $request->jumlah[$i];

                // Validasi stok tersedia
                $totalStokTersedia = Detail_barang::where('barang_id', $barang_id)
                    ->sum('jumlah');
                // return  $totalStokTersedia;

                if ($jumlah > $totalStokTersedia) {
                    array_push($error_pesanans, "Stok tidak mencukupi untuk barang " . $nama_barang . " dengan kode barang " . $kode_barang . ". Hanya tersedia " . $totalStokTersedia . " unit.");
                    continue;
                }

                $data_pembelians->push([
                    'nama_barang' => $nama_barang,
                    'kode_barang' => $kode_barang,
                    'barang_id' => $barang_id,
                    'jumlah' => $jumlah
                ]);
            }
        } else {
            // Tambahkan logika untuk menangani jika tidak ada barang_id
        }

        if ($error_pelanggans || $error_pesanans) {
            return back()
                ->withInput()
                ->with('error_pelanggans', $error_pelanggans)
                ->with('error_pesanans', $error_pesanans)
                ->with('data_pembelians', $data_pembelians);
        }
        // format tanggal indo

        $kode = $this->kode();
        $tanggal1 = Carbon::now('Asia/Jakarta');
        $format_tanggal = $tanggal1->format('d F Y');

        $tanggal1 = Carbon::now('Asia/Jakarta');
        $tanggal = Carbon::now()->format('Y-m-d');
        $transaksi = Pengambilanbahan::create(array_merge(
            $request->all(),
            [
                'user_id' => auth()->user()->id,
                'perintah_kerja_id' > $request->perintah_kerja_id,
                'kode_pengambilan' => $this->kode(),
                'tanggal' => $format_tanggal,
                'tanggal_awal' => $tanggal,
                'status' => 'posting',
            ]
        ));

        $encryptedId = Crypt::encryptString($transaksi->id);
        $transaksi->qrcode_pengambilan = 'https://tigerload.id/pengambilanbahan/' . $encryptedId;
        $transaksi->save();


        $transaksi_id = $transaksi->id;

        if ($transaksi) {
            foreach ($data_pembelians as $data_pesanan) {
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
                    $hargaRataRatatotal = $detailBarang->harga * $jumlahTotalAmbil ;

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
                // Buat Detailpengambilan
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


        // sudah benar dapat mengambil id nya 
        // if ($transaksi) {
        //     foreach ($data_pembelians as $data_pesanan) {
        //         $jumlahPengambilan = $data_pesanan['jumlah'];
        //         $barangId = $data_pesanan['barang_id'];
        //         $totalHarga = 0; // Inisialisasi total harga dari semua detail barang
        //         $detailBarangIds = []; // Array untuk menyimpan ID detail_barang yang digunakan
        //         $jumlahTotalAmbil = 0; // Inisialisasi jumlah total yang akan diambil

        //         // Ambil semua Detail_barang yang tersedia untuk barang_id yang sama
        //         $detailBarangs = Detail_barang::where('barang_id', $barangId)
        //             ->where('jumlah', '>', 0) // Hanya yang masih memiliki stok
        //             ->orderBy('created_at') // Urutkan sesuai kebutuhan
        //             ->get();

        //         $jumlahTersediaPertama = $detailBarangs->first()->jumlah;

        //         foreach ($detailBarangs as $detailBarang) {
        //             // Ambil jumlah yang tersedia pada Detail_barang saat ini
        //             $jumlahTersedia = $detailBarang->jumlah;
        //             // Tentukan jumlah yang akan diambil dari Detail_barang ini
        //             $jumlahAmbilDariDetail = min($jumlahPengambilan, $jumlahTersedia);
        //             // Kurangi jumlah pada Detail_barang
        //             $detailBarang->jumlah -= $jumlahAmbilDariDetail;
        //             $detailBarang->save();
        //             // Hitung total harga dari detail barang ini
        //             $harga = $detailBarang->harga * $jumlahAmbilDariDetail;
        //             $totalHarga += $harga;
        //             // Akumulasikan jumlah yang diambil
        //             $jumlahTotalAmbil += $jumlahAmbilDariDetail;

        //             $detailBarangIds[] = $detailBarang->id;

        //             // Kurangi jumlahPengambilan dengan jumlah yang sudah diambil
        //             $jumlahPengambilan -= $jumlahAmbilDariDetail;
        //             // Jika jumlah yang diambil sudah mencukupi, keluar dari loop
        //             if ($jumlahPengambilan <= 0) {
        //                 break;
        //             }
        //         }

        //         if ($jumlahTersediaPertama >= $data_pesanan['jumlah']) {
        //             // Jika stok di detail_barang pertama sudah cukup
        //             $detailBarang = $detailBarangs->first();
        //             $hargaRataRata = $detailBarang->harga * $jumlahTotalAmbil;
        //         } else {
        //             // Jika membutuhkan lebih dari satu detail_barang
        //             $hargaRataRata = $totalHarga / $jumlahTotalAmbil;
        //             // Bulatkan harga rata-rata ke kelipatan 1000
        //             $kelipatan = 1000;
        //             $hargaRataRataBulat = round($hargaRataRata / $kelipatan) * $kelipatan;
        //             if ($hargaRataRata - ($hargaRataRataBulat - $kelipatan) < $kelipatan / 2) {
        //                 $hargaRataRataBulat = floor($hargaRataRata / $kelipatan) * $kelipatan;
        //             } else {
        //                 $hargaRataRataBulat = ceil($hargaRataRata / $kelipatan) * $kelipatan;
        //             }
        //             $hargaRataRata = $hargaRataRataBulat;
        //         }
        //         // Buat Detailpengambilan
        //         Detailpengambilan::create([
        //             'pengambilanbahan_id' => $transaksi->id,
        //             'barang_id' => $barangId,
        //             'detail_barang' => implode(',', $detailBarangIds), // ID detail_barang yang digunakan, dipisahkan dengan koma jika lebih dari satu
        //             'kode_barang' => $data_pesanan['kode_barang'],
        //             'nama_barang' => $data_pesanan['nama_barang'],
        //             'tanggal_awal' => Carbon::now('Asia/Jakarta'),
        //             'jumlah' => $data_pesanan['jumlah'],
        //             'harga' => $hargaRataRata,
        //         ]);
        //     }
        // }



        // belum bener jika hanya satu detail barang
        // if ($transaksi) {
        //     foreach ($data_pembelians as $data_pesanan) {
        //         $jumlahPengambilan = $data_pesanan['jumlah'];
        //         $barangId = $data_pesanan['barang_id'];
        //         $totalHarga = 0; // Inisialisasi total harga dari semua detail barang
        //         $jumlahTotalAmbil = 0; // Inisialisasi jumlah total yang akan diambil

        //         // Ambil semua Detail_barang yang tersedia untuk barang_id yang sama
        //         $detailBarangs = Detail_barang::where('barang_id', $barangId)
        //             ->where('jumlah', '>', 0) // Hanya yang masih memiliki stok
        //             ->orderBy('created_at') // Urutkan sesuai kebutuhan
        //             ->get();

        //         foreach ($detailBarangs as $detailBarang) {
        //             // Ambil jumlah yang tersedia pada Detail_barang saat ini
        //             $jumlahTersedia = $detailBarang->jumlah;

        //             // Tentukan jumlah yang akan diambil dari Detail_barang ini
        //             $jumlahAmbilDariDetail = min($jumlahPengambilan, $jumlahTersedia);

        //             // Kurangi jumlah pada Detail_barang
        //             $detailBarang->jumlah -= $jumlahAmbilDariDetail;
        //             $detailBarang->save();

        //             // Hitung total harga dari detail barang ini
        //             $totalHarga += $detailBarang->harga * $jumlahAmbilDariDetail;

        //             // Akumulasikan jumlah yang diambil
        //             $jumlahTotalAmbil += $jumlahAmbilDariDetail;

        //             // Kurangi jumlahPengambilan dengan jumlah yang sudah diambil
        //             $jumlahPengambilan -= $jumlahAmbilDariDetail;

        //             // Jika jumlah yang diambil sudah mencukupi, keluar dari loop
        //             if ($jumlahPengambilan <= 0) {
        //                 break;
        //             }
        //         }

        //         // Hitung harga rata-rata berdasarkan total harga dan jumlah total yang diambil
        //         if ($jumlahTotalAmbil > 0) {
        //             $hargaRataRata = $totalHarga / $jumlahTotalAmbil;
        //         } else {
        //             $hargaRataRata = 0; // Jika tidak ada yang diambil, harga rata-rata dianggap 0
        //         }

        //         // Buat Detailpengambilan
        //         Detailpengambilan::create([
        //             'pengambilanbahan_id' => $transaksi->id,
        //             'barang_id' => $barangId,
        //             'kode_barang' => $data_pesanan['kode_barang'],
        //             'nama_barang' => $data_pesanan['nama_barang'],
        //             'tanggal_awal' => Carbon::now('Asia/Jakarta'),
        //             'jumlah' => $data_pesanan['jumlah'],
        //             'harga' => $hargaRataRata, // Masukkan harga rata-rata yang sudah dihitung
        //         ]);
        //     }
        // }


        // if ($transaksi) {
        //     foreach ($data_pembelians as $data_pesanan) {
        //         $jumlahPengambilan = $data_pesanan['jumlah'];
        //         $barangId = $data_pesanan['barang_id'];

        //         // Ambil semua Detail_barang yang tersedia untuk barang_id yang sama
        //         $detailBarangs = Detail_barang::where('barang_id', $barangId)
        //             ->where('jumlah', '>', 0) // Hanya yang masih memiliki stok
        //             ->orderBy('created_at') // Urutkan sesuai kebutuhan
        //             ->get();

        //         $totalHarga = 0; // Inisialisasi total harga dari semua detail barang
        //         $jumlahTotalAmbil = 0; // Inisialisasi jumlah total yang akan diambil

        //         foreach ($detailBarangs as $detailBarang) {
        //             // Ambil jumlah yang tersedia pada Detail_barang saat ini
        //             $jumlahTersedia = $detailBarang->jumlah;

        //             // Tentukan jumlah yang akan diambil dari Detail_barang ini
        //             $jumlahAmbilDariDetail = min($jumlahPengambilan, $jumlahTersedia);

        //             // Kurangi jumlah pada Detail_barang
        //             $detailBarang->jumlah -= $jumlahAmbilDariDetail;
        //             $detailBarang->save();

        //             // Hitung total harga dari detail barang ini
        //             $totalHarga += $detailBarang->harga * $jumlahAmbilDariDetail;

        //             // Akumulasikan jumlah yang diambil
        //             $jumlahTotalAmbil += $jumlahAmbilDariDetail;

        //             // Kurangi jumlahPengambilan dengan jumlah yang sudah diambil
        //             $jumlahPengambilan -= $jumlahAmbilDariDetail;

        //             // Jika jumlah yang diambil sudah mencukupi, keluar dari loop
        //             if ($jumlahPengambilan <= 0) {
        //                 break;
        //             }
        //         }

        //         // Hitung harga rata-rata berdasarkan total harga dan jumlah total yang diambil
        //         $hargaRataRata = $totalHarga / $jumlahTotalAmbil;

        //         // Bulatkan harga rata-rata ke bilangan bulat atau presisi tertentu
        //         $hargaRataRataBulat = round($hargaRataRata, 2); // Contoh untuk membulatkan ke 2 desimal

        //         // Buat Detailpengambilan
        //         Detailpengambilan::create([
        //             'pengambilanbahan_id' => $transaksi->id,
        //             'barang_id' => $barangId,
        //             'kode_barang' => $data_pesanan['kode_barang'],
        //             'nama_barang' => $data_pesanan['nama_barang'],
        //             'tanggal_awal' => Carbon::now('Asia/Jakarta'),
        //             'jumlah' => $data_pesanan['jumlah'],
        //             'harga' => $hargaRataRataBulat, // Masukkan harga rata-rata yang sudah dihitung dan dibulatkan
        //         ]);
        //     }
        // }



        // sudah benar hanya kurang nilai harga rata2 
        // if ($transaksi) {
        //     foreach ($data_pembelians as $data_pesanan) {
        //         $jumlahPengambilan = $data_pesanan['jumlah'];
        //         $barangId = $data_pesanan['barang_id'];

        //         // Ambil semua Detail_barang yang tersedia untuk barang_id yang sama
        //         $detailBarangs = Detail_barang::where('barang_id', $barangId)
        //             ->where('jumlah', '>', 0) // Hanya yang masih memiliki stok
        //             ->orderBy('created_at') // Urutkan sesuai kebutuhan
        //             ->get();

        //         foreach ($detailBarangs as $detailBarang) {
        //             // Ambil jumlah yang tersedia pada Detail_barang saat ini
        //             $jumlahTersedia = $detailBarang->jumlah;

        //             // Tentukan jumlah yang akan diambil dari Detail_barang ini
        //             $jumlahAmbilDariDetail = min($jumlahPengambilan, $jumlahTersedia);

        //             // Kurangi jumlah pada Detail_barang
        //             $detailBarang->jumlah -= $jumlahAmbilDariDetail;
        //             $detailBarang->save();

        //             $harga = $detailBarang->harga * $jumlahAmbilDariDetail;

        //             // Kurangi jumlahPengambilan dengan jumlah yang sudah diambil
        //             $jumlahPengambilan -= $jumlahAmbilDariDetail;

        //             // Jika jumlah yang diambil sudah mencukupi, keluar dari loop
        //             if ($jumlahPengambilan <= 0) {
        //                 break;
        //             }
        //         }

        //         // Buat Detailpengambilan
        //         Detailpengambilan::create([
        //             'pengambilanbahan_id' => $transaksi->id,
        //             'barang_id' => $barangId,
        //             'kode_barang' => $data_pesanan['kode_barang'],
        //             'nama_barang' => $data_pesanan['nama_barang'],
        //             'tanggal_awal' => Carbon::now('Asia/Jakarta'),
        //             'jumlah' => $data_pesanan['jumlah'] - $jumlahPengambilan,
        //             'harga' => $harga, // Masukkan harga yang sudah dihitung
        //         ]);
        //     }
        // }



        $pengambilans = Pengambilanbahan::find($transaksi_id);

        $parts = Detailpengambilan::where('pengambilanbahan_id', $pengambilans->id)->get();

        return view('admin.pengambilanbahan.show', compact('parts', 'pengambilans'));

        // return redirect('admin/pengambilanbahan')->with('success', 'Berhasil menambahkan pengambilan bahan baku');
    }

    public function show($id)
    {

        $pengambilans = Pengambilanbahan::where('id', $id)->first();
        $pengambil = Pengambilanbahan::find($id);

        $parts = Detailpengambilan::where('pengambilanbahan_id', $pengambil->id)->get();

        return view('admin.pengambilanbahan.show', compact('parts', 'pengambilans'));
    }

    public function cetak_pengambilanfilter(Request $request)
    {
        $selectedIds = explode(',', $request->input('ids'));

        $cetakpdfs = Pengambilanbahan::whereIn('id', $selectedIds)->orderBy('id', 'DESC')->get();
        $pdf = app('dompdf.wrapper');
        $pdf->setPaper('letter', 'portrait'); // Set the paper size to portrait letter

        $pdf->loadView('admin.pengambilanbahan.cetak_pdffilter', compact('cetakpdfs'));

        return $pdf->stream('SelectedFaktur.pdf');
    }

    public function cetakpdf($id)
    {

        $pengambil = Pengambilanbahan::find($id);
        $parts = Detailpengambilan::where('pengambilanbahan_id', $pengambil->id)->get();

        // Load the view and set the paper size to portrait letter
        $pengambilans = Pengambilanbahan::where('id', $id)->first();
        $pdf = PDF::loadView('admin.pengambilanbahan.cetak_pdf', compact('parts', 'pengambilans'));
        $pdf->setPaper('letter', 'portrait'); // Set the paper size to portrait letter

        return $pdf->stream('Faktur_pengambilan_bahan_baku.pdf');
    }

    public function kode()
    {
        $typekaroseri = Pengambilanbahan::all();
        if ($typekaroseri->isEmpty()) {
            $num = "000001";
        } else {
            $id = Pengambilanbahan::getId();
            foreach ($id as $value);
            $idlm = $value->id;
            $idbr = $idlm + 1;
            $num = sprintf("%06s", $idbr);
        }

        $data = 'AK';
        $kode_type = $data . $num;
        return $kode_type;
    }
}