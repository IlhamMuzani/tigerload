<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Detail_invoicesuratpesanan;
use App\Models\Detail_tariftambahan;
use App\Models\Invoice_suratpesanan;
use App\Models\Spk;
use App\Models\Pelanggan;
use App\Models\Tagihan_ekspedisi;
use App\Models\Tarif;
use Illuminate\Support\Facades\Validator;

class InqueryinvoicesuratpesananController extends Controller
{
    public function index(Request $request)
    {
        Invoice_suratpesanan::where([
            ['status', 'posting']
        ])->update([
            'status_notif' => true
        ]);

        $status = $request->status;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        $inquery = Invoice_suratpesanan::query();

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

        return view('admin.inquery_invoicesuratpesanan.index', compact('inquery'));
    }

    public function edit($id)
    {
        $inquery = Invoice_suratpesanan::where('id', $id)->first();
        $details = Detail_invoicesuratpesanan::where('invoice_suratpesanan_id', $id)->get();
        $detailtarifs = Detail_tariftambahan::where('invoice_suratpesanan_id', $id)->get();
        $surat_pesanans = Spk::get();

        return view('admin.inquery_invoicesuratpesanan.update', compact('detailtarifs', 'surat_pesanans', 'inquery', 'details'));
    }
    public function editnonppn($id)
    {
        $inquery = Invoice_suratpesanan::where('id', $id)->first();
        $details = Detail_invoicesuratpesanan::where('invoice_suratpesanan_id', $id)->get();
        $detailtarifs = Detail_tariftambahan::where('invoice_suratpesanan_id', $id)->get();
        $surat_pesanans = Spk::get();

        return view('admin.inquery_invoicesuratpesanan.updatenonppn', compact('detailtarifs', 'surat_pesanans', 'inquery', 'details'));
    }


    public function update(Request $request, $id)
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
        $data_pembelians4 = collect();

        if ($request->has('spk_id')) {
            for ($i = 0; $i < count($request->spk_id); $i++) {
                $validasi_produk = Validator::make($request->all(), [
                    'spk_id.' . $i => 'required',
                    'kode_pesanan.' . $i => 'required',
                    'tanggal_pesanan.' . $i => 'required',
                    'merek.' . $i => 'required',
                    'tipemerek.' . $i => 'required',
                    'kode_karoseri.' . $i => 'required',
                    'nama_karoseri.' . $i => 'required',
                    'harga.' . $i => 'required',
                ]);

                if ($validasi_produk->fails()) {
                    array_push($error_pesanans, "Faktur nomor " . ($i + 1) . " belum dilengkapi!"); // Corrected the syntax for concatenation and indexing
                }

                $spk_id = is_null($request->spk_id[$i]) ? '' : $request->spk_id[$i];
                $kode_pesanan = is_null($request->kode_pesanan[$i]) ? '' : $request->kode_pesanan[$i];
                $tanggal_pesanan = is_null($request->tanggal_pesanan[$i]) ? '' : $request->tanggal_pesanan[$i];
                $merek = is_null($request->merek[$i]) ? '' : $request->merek[$i];
                $tipemerek = is_null($request->merek[$i]) ? '' : $request->merek[$i];
                $kode_karoseri = is_null($request->kode_karoseri[$i]) ? '' : $request->kode_karoseri[$i];
                $nama_karoseri = is_null($request->nama_karoseri[$i]) ? '' : $request->nama_karoseri[$i];
                $harga = is_null($request->harga[$i]) ? '' : $request->harga[$i];

                $data_pembelians->push([
                    'detail_id' => $request->detail_ids[$i] ?? null,
                    'spk_id' => $spk_id,
                    'kode_pesanan' => $kode_pesanan,
                    'tanggal_pesanan' => $tanggal_pesanan,
                    'merek' => $merek,
                    'tipemerek' => $tipemerek,
                    'kode_karoseri' => $kode_karoseri,
                    'nama_karoseri' => $nama_karoseri,
                    'harga' => $harga,
                ]);
            }
        }

        if ($request->has('keterangan_tambahan') || $request->has('nominal_tambahan') || $request->has('qty_tambahan') || $request->has('satuan_tambahan')) {
            for ($i = 0; $i < count($request->keterangan_tambahan); $i++) {
                // Check if either 'keterangan_tambahan' or 'nominal_tambahan' has input
                if (empty($request->keterangan_tambahan[$i]) && empty($request->nominal_tambahan[$i]) && empty($request->qty_tambahan[$i]) && empty($request->satuan_tambahan[$i])) {
                    continue; // Skip validation if both are empty
                }

                $validasi_produk = Validator::make($request->all(), [
                    'keterangan_tambahan.' . $i => 'required',
                    'nominal_tambahan.' . $i => 'required',
                    'qty_tambahan.' . $i => 'required',
                    'satuan_tambahan.' . $i => 'required',
                ]);

                if ($validasi_produk->fails()) {
                    array_push($error_pesanans, "Biaya tambahan nomor " . ($i + 1) . " belum dilengkapi!");
                }

                $keterangan_tambahan = $request->keterangan_tambahan[$i] ?? '';
                $nominal_tambahan = $request->nominal_tambahan[$i] ?? '';
                $qty_tambahan = $request->qty_tambahan[$i] ?? '';
                $satuan_tambahan = $request->satuan_tambahan[$i] ?? '';

                $data_pembelians4->push([
                    'detail_idd' => $request->detail_idss[$i] ?? null,
                    'keterangan_tambahan' => $keterangan_tambahan,
                    'nominal_tambahan' => $nominal_tambahan,
                    'qty_tambahan' => $qty_tambahan,
                    'satuan_tambahan' => $satuan_tambahan
                ]);
            }
        }

        if ($error_pelanggans || $error_pesanans) {
            return back()
                ->withInput()
                ->with('error_pelanggans', $error_pelanggans)
                ->with('error_pesanans', $error_pesanans)
                ->with('data_pembelians', $data_pembelians)
                ->with('data_pembelians4', $data_pembelians4);
        }

        $tanggal1 = Carbon::now('Asia/Jakarta');
        $format_tanggal = $tanggal1->format('d F Y');

        $tanggal = Carbon::now()->format('Y-m-d');
        $cetakpdf = Invoice_suratpesanan::findOrFail($id);

        // Update the main transaction
        $cetakpdf->update([
            'kategori' => $request->kategori,
            'pelanggan_id' => $request->pelanggan_id,
            'ppn' => $request->ppn !== null ? str_replace(',', '.', str_replace('.', '', $request->ppn)) : 0,
            'biaya_tambahan' => str_replace(',', '.', str_replace('.', '', $request->biaya_tambahan)),
            'sub_total' => str_replace(',', '.', str_replace('.', '', $request->sub_total)),
            'grand_total' => str_replace(',', '.', str_replace('.', '', $request->grand_total)),
            'keterangan' => $request->keterangan,
            'status' => 'posting',
            'status_notif' => false,
        ]);

        $transaksi_id = $cetakpdf->id;
        $detailIds = $request->input('detail_ids');

        foreach ($data_pembelians as $data_pesanan) {
            $detailId = $data_pesanan['detail_id'];

            if ($detailId) {
                $existingDetail = Detail_invoicesuratpesanan::findOrFail($detailId);
                $existingDetail->update([
                    'invoice_suratpesanan_id' => $cetakpdf->id,
                    'spk_id' => $data_pesanan['spk_id'],
                    'kode_pesanan' => $data_pesanan['kode_pesanan'],
                    'tanggal_pesanan' => $data_pesanan['tanggal_pesanan'],
                    'merek' => $data_pesanan['merek'],
                    'tipemerek' => $data_pesanan['tipemerek'],
                    'kode_karoseri' => $data_pesanan['kode_karoseri'],
                    'nama_karoseri' => $data_pesanan['nama_karoseri'],
                    'harga' =>  str_replace(',', '.', str_replace('.', '', $data_pesanan['harga'])),
                ]);
            } else {
                $existingDetail = Detail_invoicesuratpesanan::where([
                    'invoice_suratpesanan_id' => $cetakpdf->id,
                    'spk_id' => $data_pesanan['spk_id'],
                    'kode_pesanan' => $data_pesanan['kode_pesanan'],
                    'tanggal_pesanan' => $data_pesanan['tanggal_pesanan'],
                    'merek' => $data_pesanan['merek'],
                    'tipemerek' => $data_pesanan['tipemerek'],
                    'kode_karoseri' => $data_pesanan['kode_karoseri'],
                    'nama_karoseri' => $data_pesanan['nama_karoseri'],
                    'harga' =>  str_replace(',', '.', str_replace('.', '', $data_pesanan['harga'])),
                ])->first();

                if (!$existingDetail) {
                    $detailTagihan = Detail_invoicesuratpesanan::create([
                        'invoice_suratpesanan_id' => $cetakpdf->id,
                        'spk_id' => $data_pesanan['spk_id'],
                        'kode_pesanan' => $data_pesanan['kode_pesanan'],
                        'tanggal_pesanan' => $data_pesanan['tanggal_pesanan'],
                        'merek' => $data_pesanan['merek'],
                        'tipemerek' => $data_pesanan['tipemerek'],
                        'kode_karoseri' => $data_pesanan['kode_karoseri'],
                        'nama_karoseri' => $data_pesanan['nama_karoseri'],
                        'harga' =>  str_replace(',', '.', str_replace('.', '', $data_pesanan['harga'])),

                    ]);
                }
            }
        }

        foreach ($data_pembelians4 as $data_pesanan) {
            $detailId = $data_pesanan['detail_idd'];

            if ($detailId) {
                Detail_tariftambahan::where('id', $detailId)->update([
                    'invoice_suratpesanan_id' => $cetakpdf->id,
                    'keterangan_tambahan' => $data_pesanan['keterangan_tambahan'],
                    'nominal_tambahan' => str_replace('.', '', $data_pesanan['nominal_tambahan']),
                    'qty_tambahan' => str_replace('.', '', $data_pesanan['qty_tambahan']),
                    'satuan_tambahan' => $data_pesanan['satuan_tambahan'],
                ]);
            } else {
                $existingDetail = Detail_tariftambahan::where([
                    'invoice_suratpesanan_id' => $cetakpdf->id,
                    'keterangan_tambahan' => $data_pesanan['keterangan_tambahan'],
                    'nominal_tambahan' => str_replace('.', '', $data_pesanan['nominal_tambahan']),
                    'qty_tambahan' => str_replace('.', '', $data_pesanan['qty_tambahan']),
                    'satuan_tambahan' => $data_pesanan['satuan_tambahan'],
                ])->first();


                if (!$existingDetail) {
                    Detail_tariftambahan::create([
                        'invoice_suratpesanan_id' => $cetakpdf->id,
                        'keterangan_tambahan' => $data_pesanan['keterangan_tambahan'],
                        'nominal_tambahan' => str_replace('.', '', $data_pesanan['nominal_tambahan']),
                        'qty_tambahan' => str_replace('.', '', $data_pesanan['qty_tambahan']),
                        'satuan_tambahan' => $data_pesanan['satuan_tambahan'],
                    ]);
                }
            }
        }

        // return view('admin.inquery_invoicesuratpesanan.show', compact('cetakpdf', 'details'));
        return back();
    }


    public function show($id)
    {
        $cetakpdf = Spk::where('id', $id)->first();

        return view('admin.inquery_invoicesuratpesanan.show', compact('cetakpdf'));
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