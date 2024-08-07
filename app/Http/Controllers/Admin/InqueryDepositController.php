<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Dompdf\Dompdf;
use App\Models\Divisi;
use App\Models\Golongan;
use App\Models\Kendaraan;
use Illuminate\Http\Request;
use App\Models\Jenis_kendaraan;
use App\Http\Controllers\Controller;
use App\Models\Depositpemesanan;
use App\Models\Gambar;
use App\Models\Marketing;
use App\Models\Merek;
use App\Models\Modelken;
use App\Models\Pelanggan;
use App\Models\Spesifikasi;
use App\Models\Perintah_kerja;
use App\Models\Typekaroseri;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Mockery\Matcher\Type;

class InqueryDepositController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->status;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        $inquery = Depositpemesanan::query();

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

        return view('admin/inquerydeposit.index', compact('inquery'));
    }


    public function show($id)
    {
        $deposits = Depositpemesanan::where('id', $id)->first();
        $spk = Perintah_kerja::where('id', $deposits->perintah_kerja_id)->first();

        return view('admin.inquerydeposit.show', compact('deposits', 'spk'));
    }


    public function edit($id)
    {
        $spks = Perintah_kerja::where(['status' => 'posting', 'status_deposit' => null])->get();

        $deposits = Depositpemesanan::where('id', $id)->first();

        return view('admin/inquerydeposit.update', compact('deposits', 'spks'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'perintah_kerja_id' => 'required',
                'tanggal_transfer' => 'required',
                'harga' => 'required',
            ],
            [
                'perintah_kerja_id.required' => 'Pilih Perintah kerja',
                'tanggal_transfer.required' => 'Pilih tanggal',
                'harga.required' => 'Masukkan harga',
            ]
        );

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return back()->withInput()->with('error', $errors);
        }

        $deposit = Depositpemesanan::findOrFail($id);

        Depositpemesanan::where('id', $id)->update([
            'perintah_kerja_id' => $request->perintah_kerja_id,
            'tanggal_transfer' => $request->tanggal_transfer,
            'harga' => str_replace(',', '.', str_replace('.', '', $request->harga)),
            'status' => 'posting',
        ]);

        // Retrieve the updated Depositpemesanan record to get the perintah_kerja_id
        $deposits = Depositpemesanan::where('id', $id)->first();

        // Update the Perintah_kerja record based on the perintah_kerja_id from deposits
        // Perintah_kerja::where('id', $deposits->perintah_kerja_id)->update([
        //     'status' => 'selesai',
        //     'status_deposit' => 'deposit',
        // ]);

        // Retrieve the updated Perintah_kerja record
        $spk = Perintah_kerja::where('id', $deposits->perintah_kerja_id)->first();

        // Return the view with the deposits and spk
        return view('admin.inquerydeposit.show', compact('deposits', 'spk'));
    }


    public function unpostdeposit($id)
    {
        $deposits = Depositpemesanan::where('id', $id)->first();

        // $spks = Perintah_kerja::where('id', $deposits->perintah_kerja_id)->update(['status_deposit' => null, 'status' => 'posting',]);

        $deposits->update([
            'status' => 'unpost'
        ]);

        return back()->with('success', 'Berhasil');
    }

    public function postingdeposit($id)
    {
        $deposits = Depositpemesanan::where('id', $id)->first();

        // $spks = Perintah_kerja::where('id', $deposits->perintah_kerja_id)->update(['status_deposit' => 'deposit', 'status' => 'selesai',]);

        $deposits->update([
            'status' => 'posting'
        ]);

        return back()->with('success', 'Berhasil');
    }

    public function hapusdeposit($id)
    {
        $tagihan = Depositpemesanan::where('id', $id)->first();
        $tagihan->delete();
        return back()->with('success', 'Berhasil menghapus Surat penawaran');
    }
}