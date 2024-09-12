<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Dompdf\Dompdf;
use App\Models\Satuan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class SatuanController extends Controller
{
    public function index()
    {

        $satuans = Satuan::all();
        return view('admin/satuan.index', compact('satuans'));
    }

    public function create()
    {

        return view('admin/satuan.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'kode_satuan' => 'required',
                'nama_satuan' => 'required',
            ],
            [
                'kode_satuan.required' => 'Masukkan kode satuan',
                'nama_satuan.required' => 'Masukkan nama satuan',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        Satuan::create(array_merge(
            $request->all(),
            [
                'tanggal_awal' => Carbon::now('Asia/Jakarta'),
            ]
        ));

        return redirect('admin/satuan')->with('success', 'Berhasil menambahkan satuan');
    }


    public function edit($id)
    {

        $satuan = Satuan::where('id', $id)->first();
        return view('admin/satuan.update', compact('satuan'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'kode_satuan' => 'required',
                'nama_satuan' => 'required',
            ],
            [
                'kode_satuan.required' => 'Masukkan kode satuan',
                'nama_satuan.required' => 'Masukkan nama satuan',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        Satuan::where('id', $id)->update([
            'kode_satuan' => $request->kode_satuan,
            'nama_satuan' => $request->nama_satuan,
        ]);

        return redirect('admin/satuan')->with('success', 'Berhasil memperbarui Satuan');
    }

    public function destroy($id)
    {
        $satuan = Satuan::find($id);
        $satuan->delete();

        return redirect('admin/satuan')->with('success', 'Berhasil menghapus Satuan');
    }
}