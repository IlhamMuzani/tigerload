<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Spesifikasi;
use App\Models\Typekaroseri;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class TypekaroseriController extends Controller
{
    public function index()
    {
        $typekaroseris = Typekaroseri::get();
        return view('admin/typekaroseri.index', compact('typekaroseris'));
    }

    public function create()
    {

        $barangs = Barang::all();
        return view('admin/typekaroseri.create', compact('barangs'));
    }

    public function store(Request $request)
    {
        $validasi_pelanggan = Validator::make(
            $request->all(),
            [
                'nama_karoseri' => 'required',
                // 'type_kendaraan' => 'required',
                'panjang' => 'required',
                'lebar' => 'required',
                'tinggi' => 'required',
            ],
            [
                'nama_karoseri.required' => 'Masukkan bentuk karoseri',
                // 'type_kendaraan.required' => 'Masukkan tipe kendaraan',
                'panjang.required' => 'Masukkan panjang',
                'lebar.required' => 'Masukkan lebar',
                'tinggi.required' => 'Masukkan tinggi',
            ]
        );

        $error_pelanggans = array();

        if ($validasi_pelanggan->fails()) {
            array_push($error_pelanggans, $validasi_pelanggan->errors()->all()[0]);
        }

        $error_pesanans = array();
        $data_pembelians = collect();

        if ($request->has('nama')) {
            for ($i = 0; $i < count($request->nama); $i++) {
                $validasi_produk = Validator::make($request->all(), [
                    'nama.' . $i => 'required',
                    'barang_id.' . $i => 'required',
                    'jumlah.' . $i => 'required',
                ]);

                if ($validasi_produk->fails()) {
                    array_push($error_pesanans, "Spesifikasi nomor " . $i + 1 . " belum dilengkapi!");
                }


                $nama = is_null($request->nama[$i]) ? '' : $request->nama[$i];
                $barang_id = is_null($request->barang_id[$i]) ? '' : $request->barang_id[$i];
                $jumlah = is_null($request->jumlah[$i]) ? '' : $request->jumlah[$i];

                $data_pembelians->push(['nama' => $nama, 'barang_id' => $barang_id, 'jumlah' => $jumlah]);
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

        $kode = $this->kode();
        $tanggal = Carbon::now()->format('Y-m-d');
        $transaksi = Typekaroseri::create(array_merge(
            $request->all(),
            [
                'kode_type' => $this->kode(),
                'qrcode_karoseri' => 'https://tigerload.id/typekaroseri/' . $kode,
                'tanggal_awal' => $tanggal,

            ]
        ));

        $transaksi_id = $transaksi->id;

        // $kodeban = $this->kodeban();

        if ($transaksi) {

            foreach ($data_pembelians as $data_pesanan) {
                Spesifikasi::create([
                    'typekaroseri_id' => $transaksi->id,
                    'nama' => $data_pesanan['nama'],
                    'barang_id' => $data_pesanan['barang_id'],
                    'jumlah' => $data_pesanan['jumlah'],
                ]);
            }
        }

        return redirect('admin/typekaroseri')->with('success', 'Berhasil menambahkan type karoseri');
    }

    public function kode()
    {
        $typekaroseri = Typekaroseri::all();
        if ($typekaroseri->isEmpty()) {
            $num = "000001";
        } else {
            $id = Typekaroseri::getId();
            foreach ($id as $value);
            $idlm = $value->id;
            $idbr = $idlm + 1;
            $num = sprintf("%06s", $idbr);
        }

        $data = 'AG';
        $kode_type = $data . $num;
        return $kode_type;
    }

    public function edit($id)
    {

        $typekaroseri = Typekaroseri::where('id', $id)->first();
        $details = Spesifikasi::where('typekaroseri_id', $id)->get();

        return view('admin/typekaroseri.update', compact('typekaroseri', 'details'));
    }

    public function update(Request $request, $id)
    {
        $validasi_pelanggan = Validator::make(
            $request->all(),
            [
                'nama_karoseri' => 'required',
                'panjang' => 'required',
                'lebar' => 'required',
                'tinggi' => 'required',
            ],
            [
                'nama_karoseri.required' => 'Masukkan bentuk karoseri',
                'panjang.required' => 'Masukkan panjang',
                'lebar.required' => 'Masukkan lebar',
                'tinggi.required' => 'Masukkan tinggi',
            ]
        );

        $error_pelanggans = array();
        $error_pesanans = array();
        $data_pembelians = collect();


        if ($validasi_pelanggan->fails()) {
            array_push($error_pelanggans, $validasi_pelanggan->errors()->all()[0]);
        }

        if ($request->has('nama')) {
            for ($i = 0; $i < count($request->nama); $i++) {
                $validasi_produk = Validator::make($request->all(), [
                    'nama.' . $i => 'required',
                ]);

                if ($validasi_produk->fails()) {
                    array_push($error_pesanans, "Spesifikasi nomor " . ($i + 1) . " belum dilengkapi!");
                }


                $nama = is_null($request->nama[$i]) ? '' : $request->nama[$i];

                $data_pembelians->push([
                    'detail_id' => $request->detail_ids[$i] ?? null,
                    'nama' => $nama,
                ]);
            }
        } else {
        }
        if ($validasi_pelanggan->fails() || $error_pesanans) {
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
        $transaksi = Typekaroseri::findOrFail($id);

        // Update the main transaction
        $transaksi->update([
            'nama_karoseri' => $request->nama_karoseri,
            'panjang' => $request->panjang,
            'lebar' => $request->lebar,
            'tinggi' => $request->tinggi,
            'aksesoris' => $request->aksesoris,
        ]);

        $transaksi_id = $transaksi->id;

        $detailIds = $request->input('detail_ids');

        foreach ($data_pembelians as $data_pesanan) {
            $detailId = $data_pesanan['detail_id'];

            if ($detailId) {
                Spesifikasi::where('id', $detailId)->update([
                    'typekaroseri_id' => $transaksi->id,
                    'nama' => $data_pesanan['nama'],
                ]);
            } else {
                $existingDetail = Spesifikasi::where([
                    'typekaroseri_id' => $transaksi->id,
                    'nama' => $data_pesanan['nama'],
                ])->first();

                if (!$existingDetail) {
                    Spesifikasi::create([
                        'typekaroseri_id' => $transaksi->id,
                        'nama' => $data_pesanan['nama'],
                    ]);
                }
            }
        }

        return redirect('admin/typekaroseri')->with('success', 'Berhasil memperbarui type karoseri');
    }

    public function delete_spesifikasi($id)
    {
        $part = Spesifikasi::find($id);
        $part->delete();

        return redirect('admin/inquery_pembelianpart')->with('success', 'Berhasil menghapus');
    }


    public function cetakqrcode($id)
    {
        $typerkaroserys = Typekaroseri::find($id);
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('admin.typekaroseri.cetak_pdf', compact('typerkaroserys'));
        $pdf->setPaper('letter', 'portrait');
        return $pdf->stream('QrCodeKaroseri.pdf');
    }

    public function show($id)
    {


        $typekaroseri = Typekaroseri::where('id', $id)->first();
        return view('admin/typekaroseri.show', compact('typekaroseri'));
    }


    public function destroy($id)
    {
        $tipe = Typekaroseri::find($id);
        $tipe->delete();

        return redirect('admin/typekaroseri')->with('success', 'Berhasil menghapus type karoseri');
    }
}