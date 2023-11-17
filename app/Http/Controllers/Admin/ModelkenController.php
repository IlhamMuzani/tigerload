<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Dompdf\Dompdf;
use App\Models\Modelken;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ModelkenController extends Controller
{
    public function index()
    {

        $modelkens = Modelken::paginate(4);
        return view('admin/modelken.index', compact('modelkens'));
    }

    public function create()
    {
        return view('admin/modelken.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama_model' => 'required',
            ],
            [
                'nama_model.required' => 'Masukkan nama model',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $kode = $this->kode();

        Modelken::create(array_merge(
            $request->all(),
            [
                'kode_model' => $this->kode(),
                'qrcode_model' => 'https://tigerload.id/modelken/' . $kode,
                'tanggal_awal' => Carbon::now('Asia/Jakarta'),
            ],
        ));

        return back()->with('success', 'Berhasil menambahkan model');
    }

    public function kode()
    {
        $model = Modelken::all();
        if ($model->isEmpty()) {
            $num = "000001";
        } else {
            $id = Modelken::getId();
            foreach ($id as $value);
            $idlm = $value->id;
            $idbr = $idlm + 1;
            $num = sprintf("%06s", $idbr);
        }

        $data = 'AE';
        $kodemodel = $data . $num;
        return $kodemodel;
    }

    public function edit($id)
    {

        $modelken = Modelken::where('id', $id)->first();
            return view('admin/modelken.update', compact('modelken'));
      
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_model' => 'required',
        ], [
            'nama_model.required' => 'Nama Model tidak boleh Kosong',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        Modelken::where('id', $id)->update([
            'nama_model' => $request->nama_model,
        ]);

        return redirect('admin/modelken')->with('success', 'Berhasil memperbarui Model');
    }

    public function destroy($id)
    {
        $model = Modelken::find($id);
        $model->delete();

        return redirect('admin/modelken')->with('success', 'Berhasil menghapus Model');
    }
}