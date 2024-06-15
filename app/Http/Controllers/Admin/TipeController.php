<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Dompdf\Dompdf;
use App\Models\Tipe;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class TipeController extends Controller
{
    public function index()
    {

        $tipes = Tipe::paginate(4);
        return view('admin/tipe.index', compact('tipes'));
    }

    public function create()
    {
        return view('admin/tipe.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama_tipe' => 'required',
            ],
            [
                'nama_tipe.required' => 'Masukkan nama tipe',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $kode = $this->kode();

        Tipe::create(array_merge(
            $request->all(),
            [
                'kode_tipe' => $this->kode(),
                'qrcode_tipe' => 'https://tigerload.id/tipe/' . $kode,
                'tanggal_awal' => Carbon::now('Asia/Jakarta'),
            ],
        ));

        return back()->with('success', 'Berhasil menambahkan tipe');
    }

    public function add_tipe(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama_tipe' => 'required',
            ],
            [
                'nama_tipe.required' => 'Masukkan nama tipe',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $kode = $this->kode();

        Tipe::create(array_merge(
            $request->all(),
            [
                'kode_tipe' => $this->kode(),
                'qrcode_tipe' => 'https://tigerload.id/tipe/' . $kode,
                'tanggal_awal' => Carbon::now('Asia/Jakarta'),
            ],
        ));

        return redirect('admin/tipe')->with('success', 'Berhasil menambahkan tipe');
    }
    public function kode()
    {
        $tipe = Tipe::all();
        if ($tipe->isEmpty()) {
            $num = "000001";
        } else {
            $id = Tipe::getId();
            foreach ($id as $value);
            $idlm = $value->id;
            $idbr = $idlm + 1;
            $num = sprintf("%06s", $idbr);
        }

        $data = 'AF';
        $kodetipe = $data . $num;
        return $kodetipe;
    }

    public function edit($id)
    {

        $tipe = Tipe::where('id', $id)->first();
        return view('admin/tipe.update', compact('tipe'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_tipe' => 'required',
        ], [
            'nama_tipe.required' => 'Nama Tipe tidak boleh Kosong',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        Tipe::where('id', $id)->update([
            'nama_tipe' => $request->nama_tipe,
        ]);

        return redirect('admin/tipe')->with('success', 'Berhasil memperbarui Tipe');
    }

    public function destroy($id)
    {
        $tipe = Tipe::find($id);
        $tipe->delete();

        return redirect('admin/tipe')->with('success', 'Berhasil menghapus Tipe');
    }
}