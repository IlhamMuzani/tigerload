<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Dompdf\Dompdf;
use App\Models\User;
use App\Models\Karyawan;
use App\Models\Pelanggan;
use App\Models\Departemen;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PelangganController extends Controller
{
    public function index()
    {
        $pelanggans = Pelanggan::get();
        return view('admin/pelanggan.index', compact('pelanggans'));
    }

    public function create()
    {
        return view('admin/pelanggan.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama_pelanggan' => 'required',
                'nama_alias' => 'required',
                // 'gender' => 'required',
                // 'umur' => 'required',
                'telp' => 'required',
                'alamat' => 'required',
                // 'gambar_ktp' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            ],
            [
                'nama_pelanggan.required' => 'Masukkan nama lengkap',
                'nama_alias.required' => 'Masukkan nama alias',
                // 'gender.required' => 'Pilih gender',
                // 'umur.required' => 'Masukkan umur',
                'telp.required' => 'Masukkan no telepon',
                'alamat.required' => 'Masukkan alamat',
                // 'gambar_ktp.image' => 'Gambar yang dimasukan salah!',
            ]
        );

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return back()->withInput()->with('error', $errors);
        }

        if ($request->gambar_ktp) {
            $gambar = str_replace(' ', '', $request->gambar_ktp->getClientOriginalName());
            $namaGambar = 'gambar_ktp/' . date('mYdHs') . rand(1, 10) . '_' . $gambar;
            $request->gambar_ktp->storeAs('public/uploads/', $namaGambar);
        } else {
            $namaGambar = null;
        }

        $kode = $this->kode();

        $tanggal = Carbon::now()->format('Y-m-d');
        $pelanggan = Pelanggan::create(array_merge(
            $request->all(),
            [
                'gambar_ktp' => $namaGambar,
                'kode_pelanggan' => $this->kode(),
                'qrcode_pelanggan' => 'https://tigerload.id/pelanggan/' . $kode,
                'tanggal_awal' => $tanggal,

            ]
        ));

        User::create(array_merge(
            $request->all(),
            [
                'pelanggan_id' => $pelanggan->id,
                'karyawan_id' => null,
                'kode_user' => $pelanggan->kode_pelanggan,
                'level' => 'pelanggan',
            ]
        ));

        return redirect('admin/pelanggan')->with('success', 'Berhasil menambahkan pelanggan');
    }

    public function kode()
    {
        $pelanggan = Pelanggan::all();
        if ($pelanggan->isEmpty()) {
            $num = "000001";
        } else {
            $id = Pelanggan::getId();
            foreach ($id as $value);
            $idlm = $value->id;
            $idbr = $idlm + 1;
            $num = sprintf("%06s", $idbr);
        }

        $data = 'AH';
        $kode_pelanggan = $data . $num;
        return $kode_pelanggan;
    }

    public function edit($id)
    {

        $pelanggan = Pelanggan::where('id', $id)->first();
        return view('admin/pelanggan.update', compact('pelanggan'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama_pelanggan' => 'required',
                'nama_alias' => 'required',
                // 'gender' => 'required',
                // 'umur' => 'required',
                'telp' => 'required',
                'alamat' => 'required',
                // 'gambar_ktp' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            ],
            [
                'nama_pelanggan.required' => 'Masukkan nama lengkap',
                'nama_alias.required' => 'Masukkan nama alias',
                // 'gender.required' => 'Pilih gender',
                // 'umur.required' => 'Masukkan umur',
                'telp.required' => 'Masukkan no telepon',
                'alamat.required' => 'Masukkan alamat',
                // 'gambar_ktp.image' => 'Gambar yang dimasukan salah!',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $pelanggan = Pelanggan::findOrFail($id);

        if ($request->gambar_ktp) {
            Storage::disk('local')->delete('public/uploads/' . $pelanggan->gambar_ktp);
            $gambar = str_replace(' ', '', $request->gambar_ktp->getClientOriginalName());
            $namaGambar = 'gambar_ktp/' . date('mYdHs') . rand(1, 10) . '_' . $gambar;
            $request->gambar_ktp->storeAs('public/uploads/', $namaGambar);
        } else {
            $namaGambar = $pelanggan->gambar_ktp;
        }

        Pelanggan::where('id', $id)->update([
            'gambar_ktp' => $namaGambar,
            'nama_pelanggan' => $request->nama_pelanggan,
            'nama_alias' => $request->nama_alias,
            // 'gender' => $request->gender,
            // 'umur' => $request->umur,
            'telp' => $request->telp,
            'alamat' => $request->alamat,
        ]);

        return redirect('admin/pelanggan')->with('success', 'Berhasil memperbarui Pelanggan');
    }


    public function cetakqrcode($id)
    {
        $pelanggans = Pelanggan::find($id);
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('admin.pelanggan.cetak_pdf', compact('pelanggans'));
        $pdf->setPaper('letter', 'portrait');
        return $pdf->stream('QrCodePelanggan.pdf');
    }

    public function show($id)
    {


        $pelanggan = Pelanggan::where('id', $id)->first();
        return view('admin/pelanggan.show', compact('pelanggan'));
    }


    public function destroy($id)
    {
        $tipe = Pelanggan::find($id);
        $tipe->delete();

        return redirect('admin/pelanggan')->with('success', 'Berhasil menghapus Pelanggan');
    }
}