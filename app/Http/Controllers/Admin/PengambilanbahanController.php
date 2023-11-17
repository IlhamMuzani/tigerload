<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Detailpengambilan;
use App\Models\Pengambilanbahan;
use App\Models\Spesifikasi;
use App\Models\Spk;
use App\Models\Typekaroseri;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;

class PengambilanbahanController extends Controller
{
    public function index()
    {
        $spks = Spk::get();
        $barangs = Barang::get();
        return view('admin/pengambilanbahan.index', compact('spks', 'barangs'));
    }

    public function store(Request $request)
    {
        $validasi_pelanggan = Validator::make(
            $request->all(),
            [
                'spk_id' => 'required',
            ],
            [
                'spk_id.required' => 'Pilih nomor SPK',
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
                    'jumlah.' . $i => 'required',
                ]);

                if ($validasi_produk->fails()) {
                    array_push($error_pesanans, "Barang nomor " . $i + 1 . " belum dilengkapi!");
                }


                $barang_id = is_null($request->barang_id[$i]) ? '' : $request->barang_id[$i];
                $kode_barang = is_null($request->kode_barang[$i]) ? '' : $request->kode_barang[$i];
                $nama_barang = is_null($request->nama_barang[$i]) ? '' : $request->nama_barang[$i];
                $jumlah = is_null($request->jumlah[$i]) ? '' : $request->jumlah[$i];

                $data_pembelians->push(['nama_barang' => $nama_barang, 'kode_barang' => $kode_barang, 'barang_id' => $barang_id, 'jumlah' => $jumlah]);
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

        $kode = $this->kode();
        $tanggal1 = Carbon::now('Asia/Jakarta');
        $format_tanggal = $tanggal1->format('d F Y');

        $tanggal1 = Carbon::now('Asia/Jakarta');
        $tanggal = Carbon::now()->format('Y-m-d');
        $transaksi = Pengambilanbahan::create(array_merge(
            $request->all(),
            [
                'kode_pengambilan' => $this->kode(),
                'qrcode_pengambilan' => 'https://tigerload.id/pengambilanbahan/' . $kode,
                'tanggal' => $format_tanggal,
                'tanggal_awal' => $tanggal,
                'status' => 'posting',

            ]
        ));

        $transaksi_id = $transaksi->id;

        if ($transaksi) {
            foreach ($data_pembelians as $data_pesanan) {
                $sparepart = Barang::find($data_pesanan['barang_id']);
                if ($sparepart) {
                    // Mengurangkan jumlah sparepart yang dipilih dengan jumlah yang dikirim dalam request
                    $jumlah_sparepart = $sparepart->jumlah - $data_pesanan['jumlah'];

                    // Memperbarui jumlah sparepart
                    $sparepart->update(['jumlah' => $jumlah_sparepart]);

                    Detailpengambilan::create([
                        'pengambilanbahan_id' => $transaksi->id,
                        'barang_id' => $data_pesanan['barang_id'],
                        'kode_barang' => $data_pesanan['kode_barang'],
                        'nama_barang' => $data_pesanan['nama_barang'],
                        'tanggal_awal' => Carbon::now('Asia/Jakarta'),
                        'jumlah' => $data_pesanan['jumlah'],
                    ]);
                }
            }
        }

        $pengambilans = Pengambilanbahan::find($transaksi_id);

        $parts = Detailpengambilan::where('pengambilanbahan_id', $pengambilans->id)->get();

        return view('admin.pengambilanbahan.show', compact('parts', 'pengambilans'));

        // return redirect('admin/pengambilanbahan')->with('success', 'Berhasil menambahkan pengambilan bahan baku');
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