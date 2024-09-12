<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $query = Barang::where('kategori', 'besi');

        if ($request->has('keyword')) {
            $keyword = $request->keyword;

            $query->where(function ($q) use ($keyword) {
                $q->where('kode_barang', 'like', "%$keyword%")
                    ->orWhere('nama_barang', 'like', "%$keyword%");
            });
        }

        $barangs = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin/barang.index', compact('barangs'));
    }

    public function create()
    {
        return view('admin/barang.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama_barang' => 'required',
                'jumlah' => 'required',
                'spesifikasi' => 'required',
                'keterangan' => 'required',
                'harga' => 'required',
            ],
            [
                'nama_barang.required' => 'Masukkan nama barang',
                'jumlah.required' => 'Masukkan ukuran',
                'spesifikasi.required' => 'Masukkan spesifikasi',
                'keterangan.required' => 'Masukkan keterangan',
                'harga.required' => 'Masukkan harga',
            ]
        );

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return back()->withInput()->with('error', $errors);
        }

        $kode = $this->kode();

        $tanggal = Carbon::now()->format('Y-m-d');
        Barang::create(array_merge(
            $request->all(),
            [
                'kode_barang' => $this->kode(),
                'qrcode_barang' => 'https://tigerload.id/barang/' . $kode,
                'tanggal_awal' => $tanggal,

            ]
        ));

        return redirect('admin/barang')->with('success', 'Berhasil menambahkan barang');
    }

    public function kode()
    {
        $barang = Barang::all();
        if ($barang->isEmpty()) {
            $num = "000001";
        } else {
            $id = Barang::getId();
            foreach ($id as $value);
            $idlm = $value->id;
            $idbr = $idlm + 1;
            $num = sprintf("%06s", $idbr);
        }

        $data = 'AE';
        $kode_barang = $data . $num;
        return $kode_barang;
    }

    public function edit($id)
    {

        $barang = Barang::where('id', $id)->first();
        return view('admin/barang.update', compact('barang'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama_barang' => 'required',
                'jumlah' => 'required',
                'spesifikasi' => 'required',
                'keterangan' => 'required',
                'harga' => 'required',
            ],
            [
                'nama_barang.required' => 'Masukkan nama barang',
                'jumlah.required' => 'Masukkan ukuran',
                'spesifikasi.required' => 'Masukkan spesifikasi',
                'keterangan.required' => 'Masukkan keterangan',
                'harga.required' => 'Masukkan harga',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $barang = Barang::findOrFail($id);

        Barang::where('id', $id)->update([
            'kategori' => $request->kategori,
            'nama_barang' => $request->nama_barang,
            'jumlah' => $request->jumlah,
            'spesifikasi' => $request->spesifikasi,
            'keterangan' => $request->keterangan,
            'harga' => $request->harga,
        ]);

        return redirect('admin/barang')->with('success', 'Berhasil memperbarui barang');
    }


    public function cetakqrcode($id)
    {
        $barangs = Barang::find($id);
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('admin.barang.cetak_pdf', compact('barangs'));
        $pdf->setPaper('letter', 'portrait');
        return $pdf->stream('QrCodeBarang.pdf');
    }

    public function show($id)
    {


        $barang = Barang::where('id', $id)->first();
        return view('admin/barang.show', compact('barang'));
    }


    public function destroy($id)
    {
        $tipe = Barang::find($id);
        $tipe->delete();

        return redirect('admin/barang')->with('success', 'Berhasil menghapus barang');
    }
}
