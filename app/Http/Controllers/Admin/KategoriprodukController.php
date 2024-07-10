<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Dompdf\Dompdf;
use App\Models\Kategori_produk;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class KategoriprodukController extends Controller
{
    public function index()
    {

        $kategori_produks = Kategori_produk::all();
        return view('admin/kategori_produk.index', compact('kategori_produks'));
    }

    public function create()
    {
        return view('admin/kategori_produk.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama_kategori' => 'required',
            ],
            [
                'nama_kategori.required' => 'Masukkan nama kategori',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $kode = $this->kode();
        Kategori_produk::create(array_merge(
            $request->all(),
            [
                'qrcode_kategori' => 'https://tigerload.id/kategori_produk/' . $kode,
                'tanggal_awal' => Carbon::now('Asia/Jakarta'),
            ]
        ));

        return redirect('admin/kategori_produk')->with('success', 'Berhasil menambahkan kategori produk');
    }

    public function kode()
    {
        $barang = Kategori_produk::all();
        if ($barang->isEmpty()) {
            $num = "000001";
        } else {
            $id = Kategori_produk::getId();
            foreach ($id as $value);
            $idlm = $value->id;
            $idbr = $idlm + 1;
            $num = sprintf("%06s", $idbr);
        }

        $data = 'KP';
        $kode_barang = $data . $num;
        return $kode_barang;
    }

    public function cetakpdf($id)
    {
        $cetakpdf = Kategori_produk::where('id', $id)->first();
        $html = view('admin/kategori_produk.cetak_pdf', compact('cetakpdf'));

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');

        $dompdf->render();

        $dompdf->stream();
    }

    public function edit($id)
    {

        $kategori_produk = Kategori_produk::where('id', $id)->first();
        return view('admin/kategori_produk.update', compact('kategori_produk'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_kategori' => 'required',
        ], [
            'nama_kategori.required' => 'Nama tidak boleh Kosong',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        Kategori_produk::where('id', $id)->update([
            'nama_kategori' => $request->nama_kategori,
            'tanggal_awal' => Carbon::now('Asia/Jakarta'),
        ]);

        return redirect('admin/kategori_produk')->with('success', 'Berhasil memperbarui Kategori produk');
    }

    public function destroy($id)
    {
        $kategori_produk = Kategori_produk::find($id);
        $kategori_produk->delete();

        return redirect('admin/kategori_produk')->with('success', 'Berhasil menghapus Kategori produk');
    }
}