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
use App\Models\Project;
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

class InqueryProjectController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->status;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        $inquery = Project::query();

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

        return view('admin/inquery_project.index', compact('inquery'));
    }


    public function show($id)
    {
        $cetakpdf = Project::where('id', $id)->first();

        return view('admin.inquery_project.show', compact('cetakpdf'));
    }


    public function edit($id)
    {
        $spks = Perintah_kerja::get();
        $inquery = Project::where('id', $id)->first();

        return view('admin/inquery_project.update', compact('inquery', 'spks'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'perintah_kerja_id' => 'required',
            ],
            [
                'perintah_kerja_id.required' => 'Pilih Perintah kerja',
            ]
        );

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return back()->withInput()->with('error', $errors);
        }

        $deposit = Project::findOrFail($id);

        Project::where('id', $id)->update([
            'perintah_kerja_id' => $request->perintah_kerja_id,
            'status' => 'posting',
        ]);

        // Retrieve the updated Project record to get the perintah_kerja_id
        $deposits = Project::where('id', $id)->first();
        // Return the view with the deposits and spk
        // return view('admin.inquery_project.show', compact('deposits', 'spk'));
        return redirect('admin/inquery_project')->with('success', 'Berhasil menyimpan');

    }


    public function unpostproject($id)
    {
        $deposits = Project::where('id', $id)->first();
        $deposits->update([
            'status' => 'unpost'
        ]);

        return back()->with('success', 'Berhasil');
    }

    public function postingproject($id)
    {
        $deposits = Project::where('id', $id)->first();
        $deposits->update([
            'status' => 'posting'
        ]);

        return back()->with('success', 'Berhasil');
    }

    public function hapusproject($id)
    {
        $tagihan = Project::where('id', $id)->first();
        $tagihan->delete();
        return back()->with('success', 'Berhasil menghapus Surat penawaran');
    }
}