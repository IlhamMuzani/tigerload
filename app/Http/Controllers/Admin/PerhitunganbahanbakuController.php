<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Penerimaan_kaskecil;
use App\Models\Pengambilanbahan;
use App\Models\Perhitunganbahanbaku;
use App\Models\Perintah_kerja;
use App\Models\Surat_penawaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;

class PerhitunganbahanbakuController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $spks = Perintah_kerja::orderBy('created_at', 'desc')->get();

        $inquery = Perhitunganbahanbaku::whereDate('created_at', $today)
            ->orWhere(function ($query) use ($today) {
                $query->where('status', 'unpost')
                    ->whereDate('created_at', '<', $today);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.perhitungan_bahanbaku.index', compact('inquery', 'spks'));
    }

    public function spk($id)
    {
        $perintah_kerja = Perintah_kerja::where('id', $id)->with('pelanggan', 'typekaroseri')->first();

        return json_decode($perintah_kerja);
    }

    // public function modal_tambah()
    // {
    //     $spks = Perintah_kerja::get();
    //     return view('admin.perhitungan_bahanbaku.modal_tambah', compact('spks'));
    // }

    public function add_spks(Request $request)
    {
        $spks = Perintah_kerja::where('id', $request->id_perintahkerja)->first();
        $details = Pengambilanbahan::where('perintah_kerja_id', $spks->id)->get();

        return view('admin.perhitungan_bahanbaku.create', compact('spks', 'details'));
    }

    public function create()
    {
        $spks = Perintah_kerja::get();
        return view('admin.perhitungan_bahanbaku.create', compact('spks'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'perintah_kerja_id' => 'required',
            ],
            [
                'perintah_kerja_id.required' => 'Pilih nomor SPK',
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
        $pembelian = Perhitunganbahanbaku::create(array_merge(
            $request->all(),
            [
                'user_id' => auth()->user()->id,
                'perintah_kerja_id' => $request->perintah_kerja_id,
                'keterangan' => $request->keterangan,
                'grand_total' => str_replace(',', '.', str_replace('.', '', $request->grand_total)),
                'kode_perhitungan' => $this->kode(),
                'tanggal' => $format_tanggal,
                'tanggal_awal' => $tanggal,
                'status' => 'posting',
            ]
        ));

        $encryptedId = Crypt::encryptString($pembelian->id);
        $pembelian->qrcode_perhitungan = 'https://tigerload.id/perhitungan_bahanbaku/' . $encryptedId;
        $pembelian->save();

        $pengambilans = Perhitunganbahanbaku::find($pembelian->id);
        $pengambil = Perhitunganbahanbaku::find($pembelian->id);
        $spks = Perintah_kerja::where('id', $pengambil->perintah_kerja_id)->first();

        $cetakpdfs = Pengambilanbahan::where('perintah_kerja_id', $spks->id)->get();
        return view('admin.perhitungan_bahanbaku.show', compact('pengambilans', 'pengambil', 'spks', 'cetakpdfs'));
    }

    public function show($id)
    {
        $pengambilans = Perhitunganbahanbaku::find($id);
        $pengambil = Perhitunganbahanbaku::find($id);
        $spks = Perintah_kerja::where('id', $pengambil->perintah_kerja_id)->first();

        $cetakpdfs = Pengambilanbahan::where('perintah_kerja_id', $spks->id)->get();
        return view('admin.perhitungan_bahanbaku.show', compact('pengambil', 'spks', 'cetakpdfs', 'pengambilans'));
    }

    public function kode()
    {
        // Mengambil kode terbaru dari database dengan awalan 'MP'
        $lastBarang = Perhitunganbahanbaku::where('kode_perhitungan', 'like', 'PB%')->latest()->first();

        // Mendapatkan bulan dari tanggal kode terakhir
        $lastMonth = $lastBarang ? date('m', strtotime($lastBarang->created_at)) : null;
        $currentMonth = date('m');

        // Jika tidak ada kode sebelumnya atau bulan saat ini berbeda dari bulan kode terakhir
        if (!$lastBarang || $currentMonth != $lastMonth) {
            $num = 1; // Mulai dari 1 jika bulan berbeda
        } else {
            // Jika ada kode sebelumnya, ambil nomor terakhir
            $lastCode = $lastBarang->kode_perhitungan;

            // Pisahkan kode menjadi bagian-bagian terpisah
            $parts = explode('/', $lastCode);
            $lastNum = end($parts); // Ambil bagian terakhir sebagai nomor terakhir
            $num = (int) $lastNum + 1; // Tambahkan 1 ke nomor terakhir
        }

        // Format nomor dengan leading zeros sebanyak 6 digit
        $formattedNum = sprintf("%03s", $num);

        // Awalan untuk kode baru
        $prefix = 'PB';
        $tahun = date('y');
        $tanggal = date('dm');

        // Buat kode baru dengan menggabungkan awalan, tanggal, tahun, dan nomor yang diformat
        $newCode = $prefix . "/" . $tanggal . $tahun . "/" . $formattedNum;

        // Kembalikan kode
        return $newCode;
    }

    public function cetakpdf($id)
    {
        $pengambilans = Perhitunganbahanbaku::find($id);
        $pengambil = Perhitunganbahanbaku::find($id);
        $spks = Perintah_kerja::where('id', $pengambil->perintah_kerja_id)->first();

        $cetakpdfs = Pengambilanbahan::where('perintah_kerja_id', $spks->id)->get();

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('admin.perhitungan_bahanbaku.cetak_pdf', compact('cetakpdfs', 'pengambilans'));
        $pdf->setPaper('letter', 'portrait');

        // Return the PDF as a response
        return $pdf->stream('Surat_Penerimaan_pembayaran.pdf');
    }
}
