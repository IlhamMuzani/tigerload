<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Penerimaan_kaskecil;
use App\Models\Penerimaan_pembayaran;
use App\Models\Surat_penawaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PenerimaanpembayaranController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $inquery = Penerimaan_pembayaran::whereDate('created_at', $today)
            ->orWhere(function ($query) use ($today) {
                $query->where('status', 'unpost')
                    ->whereDate('created_at', '<', $today);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.penerimaan_pembayaran.index', compact('inquery'));
    }

    public function create()
    {
        $suratpenawarans = Surat_penawaran::get();
        return view('admin.penerimaan_pembayaran.create', compact('suratpenawarans'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'kategoris' => 'required',
                'surat_penawaran_id' => 'required',
                'pelanggan_id' => 'required',
                'typekaroseri_id' => 'required',
                'nominal' => 'required',
            ],
            [
                'kategoris.required' => 'Pilih kategoris',
                'surat_penawaran_id.required' => 'Pilih Surat Penawaran',
                'pelanggan_id.required' => 'Pilih pelanggan',
                'typekaroseri_id.required' => 'Pilih karoseri',
                'nominal.required' => 'Masukkan nominal',
            ]
        );

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return back()->withInput()->with('error', $errors);
        }

        $kode = $this->kode();
        $tanggal1 = Carbon::now('Asia/Jakarta');
        $format_tanggal = $tanggal1->format('d F Y');
        $tanggal = Carbon::now()->format('Y-m-d');
        $pembelian = Penerimaan_pembayaran::create(array_merge(
            $request->all(),
            [
                'user_id' => auth()->user()->id,
                'tanggal_pembayaran' => $request->tanggal_pembayaran,
                'keterangan' => $request->keterangan,
                'kategoris' => $request->kategoris,
                'nominal' => str_replace(',', '.', str_replace('.', '', $request->nominal)),
                'kode_penerimaan' => $this->kode(),
                'tanggal' => $format_tanggal,
                'tanggal_awal' => $tanggal,
                'status' => 'posting',
            ]
        ));

        // Now update the record with the QR code URL that includes the ID
        $pembelian->qrcode_penerimaan = 'https://tigerload.id/penerimaan_pembayaran/' . $pembelian->id;
        $pembelian->save();

        return view('admin.penerimaan_pembayaran.show', compact('pembelian'));
    }

    public function show($id)
    {
        $pembelian = Penerimaan_pembayaran::where('id', $id)->first();
        return view('admin/penerimaan_pembayaran.show', compact('pembelian'));
    }

    public function kode()
    {
        // Mengambil kode terbaru dari database dengan awalan 'MP'
        $lastBarang = Penerimaan_pembayaran::where('kode_penerimaan', 'like', 'PP%')->latest()->first();

        // Mendapatkan bulan dari tanggal kode terakhir
        $lastMonth = $lastBarang ? date('m', strtotime($lastBarang->created_at)) : null;
        $currentMonth = date('m');

        // Jika tidak ada kode sebelumnya atau bulan saat ini berbeda dari bulan kode terakhir
        if (!$lastBarang || $currentMonth != $lastMonth) {
            $num = 1; // Mulai dari 1 jika bulan berbeda
        } else {
            // Jika ada kode sebelumnya, ambil nomor terakhir
            $lastCode = $lastBarang->kode_penerimaan;

            // Pisahkan kode menjadi bagian-bagian terpisah
            $parts = explode('/', $lastCode);
            $lastNum = end($parts); // Ambil bagian terakhir sebagai nomor terakhir
            $num = (int) $lastNum + 1; // Tambahkan 1 ke nomor terakhir
        }

        // Format nomor dengan leading zeros sebanyak 6 digit
        $formattedNum = sprintf("%03s", $num);

        // Awalan untuk kode baru
        $prefix = 'PP';
        $tahun = date('y');
        $tanggal = date('dm');

        // Buat kode baru dengan menggabungkan awalan, tanggal, tahun, dan nomor yang diformat
        $newCode = $prefix . "/" . $tanggal . $tahun . "/" . $formattedNum;

        // Kembalikan kode
        return $newCode;
    }

    public function cetakpdf($id)
    {
        $cetakpdf = Penerimaan_pembayaran::find($id);
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('admin.penerimaan_pembayaran.cetak_pdf', compact('cetakpdf'));
        $pdf->setPaper('letter', 'portrait');

        // Return the PDF as a response
        return $pdf->stream('Surat_Penerimaan_pembayaran.pdf');
    }
}