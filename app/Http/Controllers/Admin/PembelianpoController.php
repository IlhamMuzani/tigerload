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
use App\Models\Detail_barang;
use App\Models\Detail_pembelian;
use App\Models\Detail_pembelianpart;
use App\Models\Detailpembelian;
use App\Models\Detailpopembelian;
use App\Models\Pembelian;
use App\Models\Popembelian;
use App\Models\Satuan;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class PembelianpoController extends Controller
{

    public function store(Request $request)
    {
        $po_pembelian_id = $request->po_pembelian_id;

        return redirect('admin/pembelianpo/' . $po_pembelian_id . '/edit');
    }


    public function edit($id)
    {
        $inquery = Popembelian::where('id', $id)->first();
        $suppliers = Supplier::all();
        $barangs = Barang::all();
        $satuans = Satuan::all();

        $details = Detailpopembelian::where('popembelian_id', $id)->get();

        return view('admin/pembelian.create', compact('inquery', 'satuans', 'barangs', 'suppliers', 'details'));
    }

    public function add_pembelian(Request $request)
    {
        $validasi_pelanggan = Validator::make(
            $request->all(),
            [
                'popembelian_id' => 'required',
                'supplier_id' => 'required',

            ],
            [
                'popembelian_id.required' => 'Pilih Purchase Order Pembelian',
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
                    'satuan_id.' . $i => 'required',
                    'jumlah.' . $i => 'required',
                    'harga.' . $i => 'required',
                    'harga_jual.' . $i => 'required',
                    // 'diskon.' . $i => 'required',
                    'total.' . $i => 'required',
                ]);

                if ($validasi_produk->fails()) {
                    array_push($error_pesanans, "Barang nomor " . $i + 1 . " belum dilengkapi!");
                }


                $barang_id = is_null($request->barang_id[$i]) ? '' : $request->barang_id[$i];
                $kode_barang = is_null($request->kode_barang[$i]) ? '' : $request->kode_barang[$i];
                $nama_barang = is_null($request->nama_barang[$i]) ? '' : $request->nama_barang[$i];
                $satuan_id = is_null($request->satuan_id[$i]) ? '' : $request->satuan_id[$i];
                $jumlah = is_null($request->jumlah[$i]) ? '' : $request->jumlah[$i];
                $harga = is_null($request->harga[$i]) ? '' : $request->harga[$i];
                $harga_jual = is_null($request->harga_jual[$i]) ? '' : $request->harga_jual[$i];
                $diskon = is_null($request->diskon[$i]) ? '' : $request->diskon[$i];
                $total = is_null($request->total[$i]) ? '' : $request->total[$i];

                $data_pembelians->push([
                    'barang_id' => $barang_id,
                    'kode_barang' => $kode_barang,
                    'nama_barang' => $nama_barang,
                    'satuan_id' => $satuan_id,
                    'jumlah' => $jumlah,
                    'harga' => $harga,
                    'harga_jual' => $harga_jual,
                    'diskon' => $diskon,
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

        $tanggal = Carbon::now()->format('Y-m-d');
        $transaksi = Pembelian::create([
            'kode_pembelian' => $this->kode(),
            'popembelian_id' => $request->popembelian_id,
            'kategori' => $request->kategori,
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
                // Create a new Detailpembelian
                $detailPembelian = Detailpembelian::create([
                    'pembelian_id' => $transaksi->id,
                    'barang_id' => $data_pesanan['barang_id'],
                    'kode_barang' => $data_pesanan['kode_barang'],
                    'nama_barang' => $data_pesanan['nama_barang'],
                    'satuan_id' => $data_pesanan['satuan_id'],
                    'jumlah' => $data_pesanan['jumlah'],
                    'harga' => $data_pesanan['harga'],
                    'harga_jual' => $data_pesanan['harga_jual'],
                    'diskon' => $data_pesanan['diskon'],
                    'total' => $data_pesanan['total'],
                ]);

                // Check if the Detail_barang already exists
                $existingDetailBarang = Detail_barang::where('supplier_id', $request->supplier_id)
                    ->where('barang_id', $data_pesanan['barang_id'])
                    ->where('harga', $data_pesanan['harga'])
                    ->first();

                if ($existingDetailBarang) {
                    // If exists, update the jumlah
                    $existingDetailBarang->jumlah += $data_pesanan['jumlah'];
                    $existingDetailBarang->save();
                } else {
                    // If not exists, create a new Detail_barang
                    Detail_barang::create([
                        'pembelian_id' => $transaksi->id,
                        'detailpembelian_id' => $detailPembelian->id,
                        'supplier_id' => $request->supplier_id,
                        'barang_id' => $data_pesanan['barang_id'],
                        'jumlah' => $data_pesanan['jumlah'],
                        'harga' => $data_pesanan['harga'],
                        'tanggal_awal' => $tanggal,
                        'status' => 'posting',
                    ]);
                }
            }
        }


        $pembelians = Pembelian::find($transaksi_id);

        $parts = Detailpembelian::where('pembelian_id', $pembelians->id)->get();

        return view('admin.pembelian.show', compact('parts', 'pembelians'));
    }

    public function show($id)
    {
        if (auth()->check() && auth()->user()->menu['pembelian']) {

            $pembelian_part = Pembelian::find($id);
            $parts = Detailpembelian::where('pembelian_part_id', $pembelian_part->id)->get();


            $pembelians = Pembelian::where('id', $id)->first();

            return view('admin.pembelian.show', compact('parts', 'pembelians'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }


    public function kode()
    {
        $pembelian_part = Pembelian::all();
        if ($pembelian_part->isEmpty()) {
            $num = "000001";
        } else {
            $id = Pembelian::getId();
            foreach ($id as $value);
            $idlm = $value->id;
            $idbr = $idlm + 1;
            $num = sprintf("%06s", $idbr);
        }

        $data = 'FS';
        $kode_pembelian_part = $data . $num;
        return $kode_pembelian_part;
    }

    public function cetakpdf($id)
    {
        if (auth()->check() && auth()->user()->menu['pembelian']) {

            $pembelians = Pembelian::find($id);
            $parts = Detailpembelian::where('pembelian_id', $pembelians->id)->get();

            // Load the view and set the paper size to portrait letter
            $pembelianbans = Pembelian::where('id', $id)->first();
            $pdf = PDF::loadView('admin.pembelian.cetak_pdf', compact('parts', 'pembelians', 'pembelianbans'));
            $pdf->setPaper('letter', 'portrait'); // Set the paper size to portrait letter

            return $pdf->stream('Faktur_Pembelian.pdf');
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }
}