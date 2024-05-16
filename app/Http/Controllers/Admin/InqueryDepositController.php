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
use App\Models\Spk;
use App\Models\Tipe;
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
        $spk = Spk::where('id', $deposits->spk_id)->first();

        return view('admin.inquerydeposit.show', compact('deposits', 'spk'));
    }


    public function edit($id)
    {
        $spks = Spk::where('status_deposit', null)->get();
        $deposits = Depositpemesanan::where('id', $id)->first();

        return view('admin/inquerydeposit.update', compact('deposits', 'spks'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'spk_id' => 'required',
                'harga' => 'required',
            ],
            [
                'spk_id.required' => 'Pilih Spk',
                'harga.required' => 'Masukkan harga',
            ]
        );

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return back()->withInput()->with('error', $errors);
        }

        $deposit = Depositpemesanan::findOrFail($id);

        $deposits = Depositpemesanan::where('id', $id)->update(
            [
                'spk_id' => $request->spk_id,
                'harga' => str_replace(',', '.', str_replace('.', '', $request->harga)),
                'status' => 'posting',
            ]
        );
        $spks = Spk::where('id', $deposits->spk_id)->update(['status_deposit' => 'deposit']);
        $deposits = Depositpemesanan::where('id', $id)->first();
        $spk = Spk::where('id', $deposits->spk_id)->first();

        return view('admin.inquerydeposit.show', compact('deposits', 'spk'));
    }


    public function unpostdeposit($id)
    {
        $deposits = Depositpemesanan::where('id', $id)->first();

        $spks = Spk::where('id', $deposits->spk_id)->update(['status_deposit' => null]);

        $deposits->update([
            'status' => 'unpost'
        ]);

        return back()->with('success', 'Berhasil');
    }

    public function postingdeposit($id)
    {
        $deposits = Depositpemesanan::where('id', $id)->first();

        $spks = Spk::where('id', $deposits->spk_id)->update(['status_deposit' => 'deposit']);

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