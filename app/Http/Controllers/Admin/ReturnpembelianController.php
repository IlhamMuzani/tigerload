<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Supplier;
use App\Models\Sparepart;
use Illuminate\Http\Request;
use App\Models\Pembelian_ban;
use App\Models\Pembelian_part;
use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Detail_pembelian;
use App\Models\Detail_pembelianpart;
use App\Models\Detailpembelianreturn;
use App\Models\Returnpembelian;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class ReturnpembelianController extends Controller
{
    public function index()
    {
        if (auth()->check() && auth()->user()->menu['pembelian']) {

            $pembelian_parts = Returnpembelian::all();
            $suppliers = Supplier::all();
            $barangs = Barang::all();

            return view('admin.return_pembelian.index', compact('pembelian_parts', 'suppliers', 'barangs'));
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
                'supplier_id.required' => 'Pilih supplier',
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
                    'satuan.' . $i => 'required',
                    'jumlah.' . $i => 'required',
                    'harga.' . $i => 'required',
                    // 'diskon.' . $i => 'required',
                    'total.' . $i => 'required',
                ]);

                if ($validasi_produk->fails()) {
                    array_push($error_pesanans, "Barang nomor " . $i + 1 . " belum dilengkapi!");
                }


                $barang_id = is_null($request->barang_id[$i]) ? '' : $request->barang_id[$i];
                $kode_barang = is_null($request->kode_barang[$i]) ? '' : $request->kode_barang[$i];
                $nama_barang = is_null($request->nama_barang[$i]) ? '' : $request->nama_barang[$i];
                $satuan = is_null($request->satuan[$i]) ? '' : $request->satuan[$i];
                $jumlah = is_null($request->jumlah[$i]) ? '' : $request->jumlah[$i];
                $harga = is_null($request->harga[$i]) ? '' : $request->harga[$i];
                $diskon = is_null($request->diskon[$i]) ? '' : $request->diskon[$i];
                $total = is_null($request->total[$i]) ? '' : $request->total[$i];

                $data_pembelians->push([
                    'barang_id' => $barang_id, 'kode_barang' => $kode_barang, 'nama_barang' => $nama_barang, 'satuan' => $satuan, 'jumlah' => $jumlah, 'harga' => $harga,
                    'diskon' => $diskon, 'total' => $total
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

        $tanggal = Carbon::now()->format('Y-m-d');
        $transaksi = Returnpembelian::create([
            'kode_pembelianreturn' => $this->kode(),
            'supplier_id' => $request->supplier_id,
            'tanggal' => $format_tanggal,
            'tanggal_awal' => $tanggal,
            'grand_total' => str_replace(',', '.', str_replace('.', '', $request->grand_total)),
            'status' => 'posting',
            'status_notif' => false,
        ]);

        $transaksi_id = $transaksi->id;

        if ($transaksi) {
            foreach ($data_pembelians as $data_pesanan) {
                // Create a new Detailpembelianreturn
                Detailpembelianreturn::create([
                    'returnpembelian_id' => $transaksi->id,
                    'barang_id' => $data_pesanan['barang_id'],
                    'kode_barang' => $data_pesanan['kode_barang'],
                    'nama_barang' => $data_pesanan['nama_barang'],
                    'satuan' => $data_pesanan['satuan'],
                    'jumlah' => $data_pesanan['jumlah'],
                    'harga' => $data_pesanan['harga'],
                    'diskon' => $data_pesanan['diskon'],
                    'total' => $data_pesanan['total'],
                ]);

                // decrement the quantity of the barang
                Barang::where('id', $data_pesanan['barang_id'])->decrement('jumlah', $data_pesanan['jumlah']);
            }
        }

        $pembelians = Returnpembelian::find($transaksi_id);

        $parts = Detailpembelianreturn::where('returnpembelian_id', $pembelians->id)->get();

        return view('admin.return_pembelian.show', compact('parts', 'pembelians'));
    }

    public function kode()
    {
        $pembelian_part = Returnpembelian::all();
        if ($pembelian_part->isEmpty()) {
            $num = "000001";
        } else {
            $id = Returnpembelian::getId();
            foreach ($id as $value);
            $idlm = $value->id;
            $idbr = $idlm + 1;
            $num = sprintf("%06s", $idbr);
        }

        $data = 'FR';
        $kode_pembelian_part = $data . $num;
        return $kode_pembelian_part;
    }

    public function show($id)
    {
        if (auth()->check() && auth()->user()->menu['pembelian']) {

            $pembelian_part = Returnpembelian::find($id);
            $parts = Detailpembelianreturn::where('pembelian_part_id', $pembelian_part->id)->get();


            $pembelians = Returnpembelian::where('id', $id)->first();

            return view('admin.return_pembelian.show', compact('parts', 'pembelians'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function cetakpdf($id)
    {
        if (auth()->check() && auth()->user()->menu['pembelian']) {

            $pembelians = Returnpembelian::find($id);
            $parts = Detailpembelianreturn::where('returnpembelian_id', $pembelians->id)->get();

            // Load the view and set the paper size to portrait letter
            $pembelianbans = Returnpembelian::where('id', $id)->first();
            $pdf = PDF::loadView('admin.return_pembelian.cetak_pdf', compact('parts', 'pembelians', 'pembelianbans'));
            $pdf->setPaper('letter', 'portrait'); // Set the paper size to portrait letter

            return $pdf->stream('Faktur_Pembelian.pdf');
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }
}