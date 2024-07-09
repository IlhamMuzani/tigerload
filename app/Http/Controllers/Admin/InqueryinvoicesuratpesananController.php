<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Detail_invoicesuratpesanan;
use App\Models\Invoice_suratpesanan;
use App\Models\Spk;
use App\Models\Pelanggan;
use App\Models\Tagihan_ekspedisi;
use App\Models\Tarif;
use Illuminate\Support\Facades\Validator;

class InqueryinvoicesuratpesananController extends Controller
{
    public function index()
    {
        // $pelanggans = Pelanggan::all();
        $surat_pesanans = Spk::get();

        return view('admin.invoice_suratpesanan.index', compact('surat_pesanans'));
    }

    public function get_fakturtagihan($pelanggan_id)
    {
        $surat_pesanans = Spk::get();
        return response()->json($surat_pesanans);
    }


    public function store(Request $request)
    {
        $validasi_pelanggan = Validator::make(
            $request->all(),
            [
                'kategori' => 'required',
                'pelanggan_id' => 'required',
                'grand_total' => 'required',
            ],
            [
                'kategori.required' => 'Pilih kategori',
                'pelanggan_id.required' => 'Pilih Pelanggan',
                'grand_total.required' => 'Masukkan grand total',
            ]
        );

        $error_pelanggans = array();

        if ($validasi_pelanggan->fails()) {
            array_push($error_pelanggans, $validasi_pelanggan->errors()->all()[0]);
        }

        $error_pesanans = array();
        $data_pembelians = collect();

        if ($request->has('faktur_ekspedisi_id')) {
            for ($i = 0; $i < count($request->faktur_ekspedisi_id); $i++) {
                $validasi_produk = Validator::make($request->all(), [
                    'faktur_ekspedisi_id.' . $i => 'required',
                    'kode_faktur.' . $i => 'required',
                    'nama_rute.' . $i => 'required',
                    // 'no_memo.' . $i => 'required',
                    'no_do.' . $i => 'required',
                    // 'no_po.' . $i => 'required',
                    'tanggal_memo.' . $i => 'required',
                    // 'no_kabin.' . $i => 'required',
                    'no_pol.' . $i => 'required',
                    'jumlah.' . $i => 'required',
                    'satuan.' . $i => 'required',
                    'harga.' . $i => 'required',
                    'total.' . $i => 'required',
                ]);

                if ($validasi_produk->fails()) {
                    array_push($error_pesanans, "Faktur nomor " . ($i + 1) . " belum dilengkapi!"); // Corrected the syntax for concatenation and indexing
                }

                $faktur_ekspedisi_id = is_null($request->faktur_ekspedisi_id[$i]) ? '' : $request->faktur_ekspedisi_id[$i];
                $kode_faktur = is_null($request->kode_faktur[$i]) ? '' : $request->kode_faktur[$i];
                $nama_rute = is_null($request->nama_rute[$i]) ? '' : $request->nama_rute[$i];
                $no_memo = is_null($request->no_memo[$i]) ? '' : $request->no_memo[$i];
                $no_do = is_null($request->no_do[$i]) ? '' : $request->no_do[$i];
                // $no_po = is_null($request->no_po[$i]) ? '' : $request->no_po[$i];
                $tanggal_memo = is_null($request->tanggal_memo[$i]) ? '' : $request->tanggal_memo[$i];
                $no_kabin = is_null($request->no_kabin[$i]) ? '' : $request->no_kabin[$i];
                $no_pol = is_null($request->no_pol[$i]) ? '' : $request->no_pol[$i];
                $jumlah = is_null($request->jumlah[$i]) ? '' : $request->jumlah[$i];
                $satuan = is_null($request->satuan[$i]) ? '' : $request->satuan[$i];
                $harga = is_null($request->harga[$i]) ? '' : $request->harga[$i];
                $total = is_null($request->total[$i]) ? '' : $request->total[$i];

                $data_pembelians->push([
                    'faktur_ekspedisi_id' => $faktur_ekspedisi_id,
                    'kode_faktur' => $kode_faktur,
                    'nama_rute' => $nama_rute,
                    'no_memo' => $no_memo,
                    'no_do' => $no_do,
                    'tanggal_memo' => $tanggal_memo,
                    'no_kabin' => $no_kabin,
                    'no_pol' => $no_pol,
                    'jumlah' => $jumlah,
                    'satuan' => $satuan,
                    'harga' => $harga,
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

        $kodePelanggan = $request->kode_pelanggan; // Mendapatkan kode pelanggan dari request
        $kode = $this->kode($kodePelanggan); // Memanggil fungsi kode() dengan melewatkan kode pelanggan

        $tanggal1 = Carbon::now('Asia/Jakarta');
        $format_tanggal = $tanggal1->format('d F Y');

        $tanggal = Carbon::now()->format('Y-m-d');
        $cetakpdf = Invoice_suratpesanan::create([
            'user_id' => auth()->user()->id,
            'kode_tagihan' => $kode,
            'kategori' => $request->kategori,
            'pelanggan_id' => $request->pelanggan_id,
            'kode_pelanggan' => $request->kode_pelanggan,
            'nama_pelanggan' => $request->nama_pelanggan,
            'alamat_pelanggan' => $request->alamat_pelanggan,
            'telp_pelanggan' => $request->telp_pelanggan,
            'periode_awal' => $request->periode_awal,
            'periode_akhir' => $request->periode_akhir,
            'pph' => str_replace(',', '.', str_replace('.', '', $request->pph)),
            'sub_total' => str_replace(',', '.', str_replace('.', '', $request->sub_total)),
            'grand_total' => str_replace(',', '.', str_replace('.', '', $request->grand_total)),
            'keterangan' => $request->keterangan,
            'tanggal' => $format_tanggal,
            'tanggal_awal' => $tanggal,
            'qrcode_tagihan' => 'https://javaline.id/invoice_suratpesanan/' . $kode,
            'status' => 'posting',
            'status_notif' => false,
        ]);

        $transaksi_id = $cetakpdf->id;

        if ($cetakpdf) {
            foreach ($data_pembelians as $data_pesanan) {
                $detailTagihan = Detail_invoicesuratpesanan::create([
                    'tagihan_ekspedisi_id' => $cetakpdf->id,
                    'faktur_ekspedisi_id' => $data_pesanan['faktur_ekspedisi_id'],
                    'kode_faktur' => $data_pesanan['kode_faktur'],
                    'nama_rute' => $data_pesanan['nama_rute'],
                    'no_memo' => $data_pesanan['no_memo'],
                    'no_do' => $data_pesanan['no_do'],
                    'tanggal_memo' => $data_pesanan['tanggal_memo'],
                    'no_kabin' => $data_pesanan['no_kabin'],
                    'no_pol' => $data_pesanan['no_pol'],
                    'jumlah' => $data_pesanan['jumlah'],
                    'satuan' => $data_pesanan['satuan'],
                    'harga' =>  str_replace(',', '.', str_replace('.', '', $data_pesanan['harga'])),
                    'total' =>  str_replace(',', '.', str_replace('.', '', $data_pesanan['total'])),

                ]);

                Spk::where('id', $detailTagihan->faktur_ekspedisi_id)->update(['status_tagihan' => 'aktif', 'status' => 'selesai']);
            }
        }

        $details = Detail_invoicesuratpesanan::where('tagihan_ekspedisi_id', $cetakpdf->id)->get();

        return view('admin.invoice_suratpesanan.show', compact('cetakpdf', 'details'));
    }


    public function kode()
    {
        $pelanggan = Invoice_suratpesanan::all();
        if ($pelanggan->isEmpty()) {
            $num = "000001";
        } else {
            $id = Invoice_suratpesanan::getId();
            foreach ($id as $value);
            $idlm = $value->id;
            $idbr = $idlm + 1;
            $num = sprintf("%06s", $idbr);
        }

        $data = 'AI';
        $kode_pelanggan = $data . $num;
        return $kode_pelanggan;
    }


    public function show($id)
    {
        $cetakpdf = Spk::where('id', $id)->first();

        return view('admin.memo_ekspedisi.show', compact('cetakpdf'));
    }

    // public function cetakpdf($id)
    // {
    //     $cetakpdf = Tagihan_ekspedisi::where('id', $id)->first();
    //     $details = Detail_invoicesuratpesanan::where('tagihan_ekspedisi_id', $cetakpdf->id)->get();

    //     $pdf = PDF::loadView('admin.invoice_suratpesanan.cetak_pdf', compact('cetakpdf', 'details'));
    //     $pdf->setPaper('letter', 'portrait'); // Set the paper size to portrait letter

    //     return $pdf->stream('Invoice_ekspedisi.pdf');
    // }

    public function unpostpesanan($id)
    {
        $invoices = Invoice_suratpesanan::where('id', $id)->first();
        $invoices->update([
            'status' => 'unpost'
        ]);

        return back()->with('success', 'Berhasil');
    }

    public function postingpesanan($id)
    {
        $invoices = Invoice_suratpesanan::where('id', $id)->first();
        $invoices->update([
            'status' => 'posting'
        ]);

        return back()->with('success', 'Berhasil');
    }


    public function hapuspesanan($id)
    {
        $item = Invoice_suratpesanan::where('id', $id)->first();
        $item->delete();
        return back()->with('success', 'Berhasil');
    }
}