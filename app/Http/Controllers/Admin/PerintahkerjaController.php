<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Detailperintah;
use App\Models\Penerimaan_kaskecil;
use App\Models\Perintah_kerja;
use App\Models\Spesifikasi;
use App\Models\Spk;
use App\Models\Typekaroseri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Crypt;

class PerintahkerjaController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $inquery = Perintah_kerja::whereDate('created_at', $today)
            ->orWhere(function ($query) use ($today) {
                $query->where('status', 'unpost')
                    ->whereDate('created_at', '<', $today);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.perintah_kerja.index', compact('inquery'));
    }

    public function create()
    {
        $barangs = Barang::get();
        $spks = Spk::get();
        return view('admin.perintah_kerja.create', compact('spks', 'barangs'));
    }

    public function store(Request $request)
    {
        $validasi_pelanggan = Validator::make(
            $request->all(),
            [
                'spk_id' => 'required',
                'pelanggan_id' => 'required',
                'typekaroseri_id' => 'required',
            ],
            [
                'spk_id.required' => 'Pilih Surat pesanan',
                'pelanggan_id.required' => 'Pilih pelanggan',
                'typekaroseri_id.required' => 'Pilih karoseri',
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
                    // 'jumlah.' . $i => 'required',
                ]);

                if ($validasi_produk->fails()) {
                    array_push($error_pesanans, "Barang nomor " . $i + 1 . " belum dilengkapi!");
                }


                $barang_id = is_null($request->barang_id[$i]) ? '' : $request->barang_id[$i];
                $kode_barang = is_null($request->kode_barang[$i]) ? '' : $request->kode_barang[$i];
                $nama_barang = is_null($request->nama_barang[$i]) ? '' : $request->nama_barang[$i];
                $jumlah = is_null($request->jumlah[$i]) ? '' : $request->jumlah[$i];

                $data_pembelians->push([
                    'barang_id' => $barang_id, 'kode_barang' => $kode_barang, 'nama_barang' => $nama_barang, 'jumlah' => $jumlah
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


        $kode = $this->kode();
        $tanggal1 = Carbon::now('Asia/Jakarta');
        $format_tanggal = $tanggal1->format('d F Y');
        $tanggal = Carbon::now()->format('Y-m-d');
        $pembelian = Perintah_kerja::create(array_merge(
            $request->all(),
            [
                'user_id' => auth()->user()->id,
                'keterangan' => $request->keterangan,
                'kode_perintah' => $this->kode(),
                'tanggal' => $format_tanggal,
                'tanggal_awal' => $tanggal,
                'status' => 'posting',
            ]
        ));

        $encryptedId = Crypt::encryptString($pembelian->id);
        $pembelian->qrcode_perintah = 'https://tigerload.id/perintah_kerja/' . $encryptedId;
        $pembelian->save();

        $transaksi_id = $pembelian->id;

        if ($pembelian) {
            foreach ($data_pembelians as $data_pesanan) {
                // Create a new Detailpembelianreturn
                Detailperintah::create([
                    'perintah_kerja_id' => $pembelian->id,
                    'barang_id' => $data_pesanan['barang_id'],
                    'kode_barang' => $data_pesanan['kode_barang'],
                    'nama_barang' => $data_pesanan['nama_barang'],
                    'jumlah' => $data_pesanan['jumlah'],
                ]);

                // Barang::where('id', $data_pesanan['barang_id'])->increment('jumlah', $data_pesanan['jumlah']);
            }
        }

        $inquery = Perintah_kerja::find($transaksi_id);

        $karoseries = Typekaroseri::where('id', $inquery->typekaroseri_id)->first();
        $spesifikasis = Spesifikasi::where('typekaroseri_id', $karoseries->id)->get();

        $parts = Detailperintah::where('perintah_kerja_id', $inquery->id)->get();

        return view('admin.perintah_kerja.show', compact('parts', 'inquery', 'karoseries', 'spesifikasis'));
    }

    public function show($id)
    {
        $inquery = Perintah_kerja::find($id);

        $karoseries = Typekaroseri::where('id', $inquery->typekaroseri_id)->first();
        $spesifikasis = Spesifikasi::where('typekaroseri_id', $karoseries->id)->get();

        $parts = Detailperintah::where('perintah_kerja_id', $inquery->id)->get();
        return view('admin.perintah_kerja.show', compact('parts', 'inquery', 'karoseries', 'spesifikasis'));
    }

    // public function kode()
    // {
    //     // Mengambil kode terbaru dari database dengan awalan 'MP'
    //     $lastBarang = Perintah_kerja::where('kode_perintah', 'like', 'SPK%')->latest()->first();

    //     // Mendapatkan bulan dari tanggal kode terakhir
    //     $lastMonth = $lastBarang ? date('m', strtotime($lastBarang->created_at)) : null;
    //     $currentMonth = date('m');

    //     // Jika tidak ada kode sebelumnya atau bulan saat ini berbeda dari bulan kode terakhir
    //     if (!$lastBarang || $currentMonth != $lastMonth) {
    //         $num = 1; // Mulai dari 1 jika bulan berbeda
    //     } else {
    //         // Jika ada kode sebelumnya, ambil nomor terakhir
    //         $lastCode = $lastBarang->kode_perintah;

    //         // Pisahkan kode menjadi bagian-bagian terpisah
    //         $parts = explode('/', $lastCode);
    //         $lastNum = end($parts); // Ambil bagian terakhir sebagai nomor terakhir
    //         $num = (int) $lastNum + 1; // Tambahkan 1 ke nomor terakhir
    //     }

    //     // Format nomor dengan leading zeros sebanyak 6 digit
    //     $formattedNum = sprintf("%03s", $num);

    //     // Awalan untuk kode baru
    //     $prefix = 'SPK';
    //     $tahun = date('y');
    //     $tanggal = date('dm');

    //     // Buat kode baru dengan menggabungkan awalan, tanggal, tahun, dan nomor yang diformat
    //     $newCode = $prefix . "/" . $tanggal . $tahun . "/" . $formattedNum;

    //     // Kembalikan kode
    //     return $newCode;
    // }

    public function kode()
    {
        $lastBarang = Perintah_kerja::latest()->first();
        if (!$lastBarang) {
            $num = 1;
        } else {
            $lastCode = $lastBarang->kode_perintah;
            $num = (int) substr($lastCode, strlen('SPK')) + 1;
        }
        $formattedNum = sprintf("%06s", $num);
        $prefix = 'SPK';
        $newCode = $prefix . $formattedNum;
        return $newCode;
    }

    public function cetakpdf($id)
    {
        $cetakpdf = Perintah_kerja::find($id);
        $karoseries = Typekaroseri::where('id', $cetakpdf->typekaroseri_id)->first();
        $spesifikasis = Spesifikasi::where('typekaroseri_id', $karoseries->id)->get();

        $parts = Detailperintah::where('perintah_kerja_id', $cetakpdf->id)->get();
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('admin.perintah_kerja.cetak_pdf', compact('cetakpdf', 'karoseries', 'spesifikasis', 'parts'));
        $pdf->setPaper('letter', 'portrait');

        // Return the PDF as a response
        return $pdf->stream('Surat_Penerimaan_pembayaran.pdf');
    }

    // public function cetakpdf($id)
    // {
    //     $cetakpdf = Perintah_kerja::find($id);
    //     $karoseries = Typekaroseri::where('id', $cetakpdf->typekaroseri_id)->first();
    //     $spesifikasis = Spesifikasi::where('typekaroseri_id', $karoseries->id)->get();

    //     $parts = Detailperintah::where('perintah_kerja_id', $cetakpdf->id)->get();
    //     $pdf = PDF::loadView('admin.perintah_kerja.cetak_pdf', compact('cetakpdf', 'karoseries', 'spesifikasis', 'parts'))->setPaper('a4', 'landscape');
    //     // Return the PDF as a response
    //     return $pdf->stream('Surat_Penerimaan_pembayaran.pdf');
    // }
}