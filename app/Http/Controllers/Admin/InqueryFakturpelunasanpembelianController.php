<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Detail_pelunasanpembelian;
use App\Models\Pembelian;
use App\Models\Supplier;
use App\Models\Faktur_pelunasanpembelian;
use App\Models\Nota_return;
use App\Models\Return_ekspedisi;
use App\Models\Satuan;
use Illuminate\Support\Facades\Validator;

class InqueryFakturpelunasanpembelianController extends Controller
{
    public function index(Request $request)
    {
        Faktur_pelunasanpembelian::where([
            ['status', 'posting']
        ])->update([
            'status_notif' => true
        ]);

        $status = $request->status;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        $inquery = Faktur_pelunasanpembelian::query();

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

        return view('admin.inquery_fakturpelunasanpembelian.index', compact('inquery'));
    }



    public function edit($id)
    {
        $inquery = Faktur_pelunasanpembelian::where('id', $id)->first();
        $details  = Detail_pelunasanpembelian::where('faktur_pelunasanpembelian_id', $id)->get();
        $suppliers = Supplier::all();
        $fakturs = Pembelian::where(['status_pelunasan' => null, 'status' => 'posting'])->get();
        return view('admin.inquery_fakturpelunasanpembelian.update', compact('details', 'inquery', 'suppliers', 'fakturs'));
    }

    public function update(Request $request, $id)
    {
        $validasi_pelanggan = Validator::make(
            $request->all(),
            [
                'supplier_id' => 'required',
                'pembelian_id' => 'required',
            ],
            [
                'supplier_id.required' => 'Pilih Supplier',
                'pembelian_id.required' => 'Pilih Faktur Pembelian',
            ]
        );

        $error_pelanggans = array();

        if ($validasi_pelanggan->fails()) {
            array_push($error_pelanggans, $validasi_pelanggan->errors()->all()[0]);
        }

        $error_pesanans = array();
        $data_pembelians = collect();

        if ($request->has('pembelian_id')) {
            for ($i = 0; $i < count($request->pembelian_id); $i++) {
                $validasi_produk = Validator::make($request->all(), [
                    'pembelian_id.' . $i => 'required',
                    'kode_pembelian.' . $i => 'required',
                    'tanggal_pembelian.' . $i => 'required',
                    'total.' . $i => 'required',
                ]);

                if ($validasi_produk->fails()) {
                    array_push($error_pesanans, "Faktur nomor " . ($i + 1) . " belum dilengkapi!"); // Corrected the syntax for concatenation and indexing
                }

                $pembelian_id = is_null($request->pembelian_id[$i]) ? '' : $request->pembelian_id[$i];
                $kode_pembelian = is_null($request->kode_pembelian[$i]) ? '' : $request->kode_pembelian[$i];
                $tanggal_pembelian = is_null($request->tanggal_pembelian[$i]) ? '' : $request->tanggal_pembelian[$i];
                $total = is_null($request->total[$i]) ? '' : $request->total[$i];

                $data_pembelians->push([
                    'detail_id' => $request->detail_ids[$i] ?? null,
                    'pembelian_id' => $pembelian_id,
                    'kode_pembelian' => $kode_pembelian,
                    'tanggal_pembelian' => $tanggal_pembelian,
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

        $tanggal1 = Carbon::now('Asia/Jakarta');
        $format_tanggal = $tanggal1->format('d F Y');

        $tanggal = Carbon::now()->format('Y-m-d');
        $cetakpdf = Faktur_pelunasanpembelian::findOrFail($id);

        // Update the main transaction
        $cetakpdf->update([
            'supplier_id' => $request->supplier_id,
            'kode_supplier' => $request->kode_supplier,
            'nama_supplier' => $request->nama_supplier,
            'alamat_supplier' => $request->alamat_supplier,
            'telp_supplier' => $request->telp_supplier,
            'keterangan' => $request->keterangan,
            'totalpenjualan' => str_replace(',', '.', str_replace('.', '', $request->totalpenjualan)),
            'dp' => str_replace(',', '.', str_replace('.', '', $request->dp)),
            'potonganselisih' => str_replace(',', '.', str_replace('.', '', $request->potonganselisih)),
            'totalpembayaran' => str_replace(',', '.', str_replace('.', '', $request->totalpembayaran)),
            'selisih' => str_replace(',', '.', str_replace('.', '', $request->selisih)),
            'potongan' => $request->potongan ? str_replace(',', '.', str_replace('.', '', $request->potongan)) : 0,
            'tambahan_pembayaran' => $request->tambahan_pembayaran ? str_replace(',', '.', str_replace('.', '', $request->tambahan_pembayaran)) : 0,
            'kategori' => $request->kategori,
            'nomor' => $request->nomor,
            'status' => 'posting',
            'tanggal_transfer' => $request->tanggal_transfer,
            // 'nominal' => str_replace('.', '', $request->nominal),
            'nominal' =>  $request->nominal ? str_replace(',', '.', str_replace('.', '', $request->nominal)) : 0,

        ]);

        $transaksi_id = $cetakpdf->id;
        $detailIds = $request->input('detail_ids');

        foreach ($data_pembelians as $data_pesanan) {
            $detailId = $data_pesanan['detail_id'];

            if ($detailId) {
                $detailPelunasan = Detail_pelunasanpembelian::where('id', $detailId)->update([
                    'faktur_pelunasanpembelian_id' => $cetakpdf->id,
                    'pembelian_id' => $data_pesanan['pembelian_id'],
                    'kode_pembelian' => $data_pesanan['kode_pembelian'],
                    'tanggal_pembelian' => $data_pesanan['tanggal_pembelian'],
                    'status' => 'posting',
                    'total' => str_replace(',', '.', str_replace('.', '', $data_pesanan['total'])),
                ]);

                // Update Pembelian
                Pembelian::where('id', $data_pesanan['pembelian_id'])->update(['status' => 'selesai', 'status_pelunasan' => 'aktif']);
            } else {
                $existingDetail = Detail_pelunasanpembelian::where([
                    'faktur_pelunasanpembelian_id' => $cetakpdf->id,
                    'pembelian_id' => $data_pesanan['pembelian_id'],
                    'kode_pembelian' => $data_pesanan['kode_pembelian'],
                    'tanggal_pembelian' => $data_pesanan['tanggal_pembelian'],
                    'total' => str_replace(',', '.', str_replace('.', '', $data_pesanan['total'])),
                ])->first();

                if (!$existingDetail) {
                    $detailPelunasan = Detail_pelunasanpembelian::create([
                        'faktur_pelunasanpembelian_id' => $cetakpdf->id,
                        'status' => 'posting',
                        'pembelian_id' => $data_pesanan['pembelian_id'],
                        'kode_pembelian' => $data_pesanan['kode_pembelian'],
                        'tanggal_pembelian' => $data_pesanan['tanggal_pembelian'],
                        'total' => str_replace(',', '.', str_replace('.', '', $data_pesanan['total'])),
                    ]);

                    // Update Pembelian
                    Pembelian::where('id', $detailPelunasan->pembelian_id)->update(['status' => 'selesai', 'status_pelunasan' => 'aktif']);
                }
            }
        }

        $details = Detail_pelunasanpembelian::where('faktur_pelunasanpembelian_id', $cetakpdf->id)->get();

        return view('admin.inquery_fakturpelunasanpembelian.show', compact('cetakpdf', 'details'));
    }

    public function show($id)
    {
        $cetakpdf = Faktur_pelunasanpembelian::where('id', $id)->first();
        $details = Detail_pelunasanpembelian::where('faktur_pelunasanpembelian_id', $id)->get();

        return view('admin.inquery_fakturpelunasanpembelian.show', compact('cetakpdf', 'details'));
    }

    public function unpostpelunasanpembelian($id)
    {
        // Menggunakan find untuk mendapatkan Faktur_pelunasanpembelian berdasarkan ID
        $item = Faktur_pelunasanpembelian::find($id);

        // Memeriksa apakah Faktur_pelunasanpembelian ditemukan
        if (!$item) {
            return back()->with('error', 'Faktur pembelian tidak ditemukan');
        }

        // Mendapatkan detail pelunasan terkait
        $detailpelunasan = Detail_pelunasanpembelian::where('faktur_pelunasanpembelian_id', $id)->get();

        // Melakukan loop pada setiap Detail_pelunasanpembelian dan memperbarui rekaman Pembelian terkait
        foreach ($detailpelunasan as $detail) {
            if ($detail->pembelian_id) {
                // Menggunakan find untuk mendapatkan Pembelian berdasarkan ID
                $fakturEkspedisi = Pembelian::find($detail->pembelian_id);

                // Memeriksa apakah Pembelian ditemukan
                if ($fakturEkspedisi) {
                    // Memperbarui status_pelunasan pada Pembelian menjadi 'aktif'
                    $fakturEkspedisi->update(['status' => 'posting', 'status_pelunasan' => null]);
                }
            }
        }

        try {
            // Memperbarui status pada Faktur_pelunasanpembelian menjadi 'unpost'
            $item->update(['status' => 'unpost']);

            // Melakukan loop pada setiap Detail_pelunasanpembelian dan memperbarui status menjadi 'unpost'
            foreach ($detailpelunasan as $detail) {
                $detail->update(['status' => 'unpost']);
            }

            return back()->with('success', 'Berhasil unposting faktur pembelian');
        } catch (\Exception $e) {
            // Menangani kesalahan pembaruan basis data
            return back()->with('error', 'Gagal unposting faktur pembelian: ' . $e->getMessage());
        }
    }


    public function postingpelunasanpembelian($id)
    {
        // Menggunakan find untuk mendapatkan Faktur_pelunasanpembelian berdasarkan ID
        $item = Faktur_pelunasanpembelian::find($id);

        // Memeriksa apakah Faktur_pelunasanpembelian ditemukan
        if (!$item) {
            return back()->with('error', 'Faktur pembelian tidak ditemukan');
        }

        // Mendapatkan detail pelunasan terkait
        $detailpelunasan = Detail_pelunasanpembelian::where('faktur_pelunasanpembelian_id', $id)->get();

        try {
            // Melakukan loop pada setiap Detail_pelunasanpembelian dan memperbarui status menjadi 'posting'
            foreach ($detailpelunasan as $detail) {
                $detail->update(['status' => 'posting']);
            }

            // Memperbarui status pada Faktur_pelunasanpembelian menjadi 'posting'
            $item->update(['status' => 'posting']);

            return back()->with('success', 'Berhasil posting pembelian');
        } catch (\Exception $e) {
            // Menangani kesalahan pembaruan basis data
            return back()->with('error', 'Gagal posting pembelian: ' . $e->getMessage());
        }
    }


    public function hapuspelunasanpembelian($id)
    {
        $item = Faktur_pelunasanpembelian::where('id', $id)->first();

        if ($item) {
            $detailpelunasan = Detail_pelunasanpembelian::where('faktur_pelunasanpembelian_id', $id)->get();

            // Loop through each Detail_pelunasanpembelian and update associated Pembelian records
            // foreach ($detailpelunasan as $detail) {
            //     if ($detail->pembelian_id) {
            //         Pembelian::where('id', $detail->pembelian_id)->update(['status_pelunasan' => null, 'status' => 'posting']);
            //     }
            // }
            // Delete related Detail_pelunasanpembelian instances
            Detail_pelunasanpembelian::where('faktur_pelunasanpembelian_id', $id)->delete();

            // Delete the main Faktur_pelunasanpembelian instance
            $item->delete();

            return back()->with('success', 'Berhasil menghapus pembelian');
        } else {
            // Handle the case where the Faktur_pelunasanpembelian with the given ID is not found
            return back()->with('error', 'pembelian tidak ditemukan');
        }
    }
}