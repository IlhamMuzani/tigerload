<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Detailpembelian;
use App\Models\Detailpopembelian;
use App\Models\Pembelian;
use App\Models\Popembelian;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class PopembelianController extends Controller
{
    public function index()
    {
        if (auth()->check() && auth()->user()->menu['po pembelian']) {

            $poPembelians = Popembelian::all();
            $suppliers = Supplier::all();
            $barangs = Barang::all();
            return view('admin.popembelian.index', compact('poPembelians', 'suppliers', 'barangs'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function store(Request $request)
    {
        $validasi_pelanggan = Validator::make(
            $request->all(),
            [
                'supplier_id' => 'required',
            ],
            [
                'supplier_id.required' => 'Pilih nama supplier',
            ]
        );

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
                    'harga.' . $i => 'required',
                    'jumlah.' . $i => 'required',
                    'satuan.' . $i => 'required',
                    'total.' . $i => 'required',
                ]);

                if ($validasi_produk->fails()) {
                    array_push($error_pesanans, "Barang nomor " . $i + 1 . " belum dilengkapi!");
                }


                $barang_id = is_null($request->barang_id[$i]) ? '' : $request->barang_id[$i];
                $kode_barang = is_null($request->kode_barang[$i]) ? '' : $request->kode_barang[$i];
                $nama_barang = is_null($request->nama_barang[$i]) ? '' : $request->nama_barang[$i];
                $harga = is_null($request->harga[$i]) ? '' : $request->harga[$i];
                $jumlah = is_null($request->jumlah[$i]) ? '' : $request->jumlah[$i];
                $satuan = is_null($request->satuan[$i]) ? '' : $request->satuan[$i];
                $total = is_null($request->total[$i]) ? '' : $request->total[$i];

                $data_pembelians->push([
                    'barang_id' => $barang_id,
                    'kode_barang' => $kode_barang,
                    'nama_barang' => $nama_barang,
                    'harga' => $harga,
                    'jumlah' => $jumlah,
                    'satuan' => $satuan,
                    'total' => $total
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

        // format tanggal indo
        $tanggal1 = Carbon::now('Asia/Jakarta');
        $format_tanggal = $tanggal1->format('d F Y');
        $kode = $this->kode();

        $tanggal = Carbon::now()->format('Y-m-d');
        $transaksi = Popembelian::create([
            'kode_po_pembelian' => $this->kode(),
            'supplier_id' => $request->supplier_id,
            'qrcode_popembelian' => 'https://tigerload.id/popembelian/' . $kode,
            'tanggal' => $format_tanggal,
            'tanggal_awal' => $tanggal,
            'status' => 'posting',
            'status_notif' => false,
        ]);

        $transaksi_id = $transaksi->id;

        if ($transaksi) {
            foreach ($data_pembelians as $data_pembelian) {
                Detailpopembelian::create([
                    'popembelian_id' => $transaksi->id,
                    'barang_id' => $data_pembelian['barang_id'],
                    'kode_barang' => $data_pembelian['kode_barang'],
                    'nama_barang' => $data_pembelian['nama_barang'],
                    'harga' => $data_pembelian['harga'],
                    'jumlah' => $data_pembelian['jumlah'],
                    'total' => $data_pembelian['total'],
                    'satuan' => $data_pembelian['satuan'],
                ]);
            }
        }

        $pembelians = Popembelian::find($transaksi_id);

        $parts = Detailpopembelian::where('popembelian_id', $pembelians->id)->get();

        return view('admin.popembelian.show', compact('parts', 'pembelians'));
    }

    public function kode()
    {
        $pembelian_part = Popembelian::all();
        if ($pembelian_part->isEmpty()) {
            $num = "000001";
        } else {
            $id = Popembelian::getId();
            foreach ($id as $value);
            $idlm = $value->id;
            $idbr = $idlm + 1;
            $num = sprintf("%06s", $idbr);
        }

        $data = 'AJ';
        $kode_pembelian_part = $data . $num;
        return $kode_pembelian_part;
    }


    public function show($id)
    {
        if (auth()->check() && auth()->user()->menu['po pembelian']) {

            $pembelian = Popembelian::find($id);
            $barangs = Detailpopembelian::where('popembelian_id', $pembelian->id)->get();


            $pembelians = Popembelian::where('id', $id)->first();

            return view('admin.popembelian.show', compact('barangs', 'pembelians'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function cetakpdf($id)
    {
        if (auth()->check() && auth()->user()->menu['po pembelian']) {

            $pembelians = Popembelian::find($id);
            $parts = Detailpopembelian::where('popembelian_id', $pembelians->id)->get();

            // Load the view and set the paper size to portrait letter
            $pembelianss = Popembelian::where('id', $id)->first();
            $pdf = PDF::loadView('admin.popembelian.cetak_pdf', compact('parts', 'pembelians', 'pembelianss'));
            $pdf->setPaper('letter', 'portrait'); // Set the paper size to portrait letter

            return $pdf->stream('Faktur_PO_Pembelian.pdf');
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }
}