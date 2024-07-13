<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pengambilanbahan;
use App\Models\Dokumen_project;
use App\Models\Perintah_kerja;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class InqueryDokumenprojectController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->status;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        $inquery = Dokumen_project::query();

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

        return view('admin/inquery_dokumenproject.index', compact('inquery'));
    }


    public function show($id)
    {

        $inquery = Dokumen_project::where('id', $id)->first();

        return view('admin.inquery_dokumenproject.show', compact('inquery'));
    }


    public function edit($id)
    {
        // Fetch the Dokumen_project record by its ID
        $inquery = Dokumen_project::find($id);

        if (!$inquery) {
            return redirect()->back()->withErrors('Inquery not found.');
        }
        $spks = Perintah_kerja::get();

        // Pass the retrieved data to the view
        return view('admin.inquery_dokumenproject.update', compact('inquery', 'spks'));
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'perintah_kerja_id' => 'required',
                'no_serut' => 'required',
                'no_rangka' => 'required',
                'no_mesin' => 'required',
                'tahun' => 'required',
            ],
            [
                'perintah_kerja_id.required' => 'Pilih nomor SPK',
                'no_serut.required' => 'No Serut',
                'no_rangka.required' => 'No Rangka',
                'no_mesin.required' => 'No Mesin',
                'tahun.required' => 'Masukkan tahun pembuatan',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $dokumen_project = Dokumen_project::findOrFail($id);

        if ($request->gambar_rancangbangun) {
            Storage::disk('local')->delete('public/uploads/' . $dokumen_project->gambar_rancangbangun);
            $gambar = str_replace(' ', '', $request->gambar_rancangbangun->getClientOriginalName());
            $namaGambar = 'gambar_rancangbangun/' . date('mYdHs') . rand(1, 10) . '_' . $gambar;
            $request->gambar_rancangbangun->storeAs('public/uploads/', $namaGambar);
        } else {
            $namaGambar = $dokumen_project->gambar_rancangbangun;
        }

        if ($request->gambar_gesekannomesin) {
            Storage::disk('local')->delete('public/uploads/' . $dokumen_project->gambar_gesekannomesin);
            $gambar = str_replace(' ', '', $request->gambar_gesekannomesin->getClientOriginalName());
            $namaGambar2 = 'gambar_gesekannomesin/' . date('mYdHs') . rand(1, 10) . '_' . $gambar;
            $request->gambar_gesekannomesin->storeAs('public/uploads/', $namaGambar2);
        } else {
            $namaGambar2 = $dokumen_project->gambar_notisgambar_gesekannomesin;
        }

        if ($request->gambar_serut) {
            Storage::disk('local')->delete('public/uploads/' . $dokumen_project->gambar_serut);
            $gambar = str_replace(' ', '', $request->gambar_serut->getClientOriginalName());
            $namaGambar4 = 'gambar_serut/' . date('mYdHs') . rand(1, 10) . '_' . $gambar;
            $request->gambar_serut->storeAs('public/uploads/', $namaGambar4);
        } else {
            $namaGambar4 = $dokumen_project->gambar_serut;
        }

        if ($request->gambar_faktur) {
            Storage::disk('local')->delete('public/uploads/' . $dokumen_project->gambar_faktur);
            $gambar = str_replace(' ', '', $request->gambar_faktur->getClientOriginalName());
            $namaGambar5 = 'gambar_faktur/' . date('mYdHs') . rand(1, 10) . '_' . $gambar;
            $request->gambar_faktur->storeAs('public/uploads/', $namaGambar5);
        } else {
            $namaGambar5 = $dokumen_project->gambar_faktur;
        }

        if ($request->gambar_depan) {
            Storage::disk('local')->delete('public/uploads/' . $dokumen_project->gambar_depan);
            $gambar = str_replace(' ', '', $request->gambar_depan->getClientOriginalName());
            $namaGambar6 = 'gambar_depan/' . date('mYdHs') . rand(1, 10) . '_' . $gambar;
            $request->gambar_depan->storeAs('public/uploads/', $namaGambar6);
        } else {
            $namaGambar6 = $dokumen_project->gambar_depan;
        }

        if ($request->gambar_belakang) {
            Storage::disk('local')->delete('public/uploads/' . $dokumen_project->gambar_belakang);
            $gambar = str_replace(' ', '', $request->gambar_belakang->getClientOriginalName());
            $namaGambar7 = 'gambar_belakang/' . date('mYdHs') . rand(1, 10) . '_' . $gambar;
            $request->gambar_belakang->storeAs('public/uploads/', $namaGambar7);
        } else {
            $namaGambar7 = $dokumen_project->gambar_belakang;
        }

        if ($request->gambar_kanan) {
            Storage::disk('local')->delete('public/uploads/' . $dokumen_project->gambar_kanan);
            $gambar = str_replace(' ', '', $request->gambar_kanan->getClientOriginalName());
            $namaGambar8 = 'gambar_kanan/' . date('mYdHs') . rand(1, 10) . '_' . $gambar;
            $request->gambar_kanan->storeAs('public/uploads/', $namaGambar8);
        } else {
            $namaGambar8 = $dokumen_project->gambar_kanan;
        }

        if ($request->gambar_kiri) {
            Storage::disk('local')->delete('public/uploads/' . $dokumen_project->gambar_kiri);
            $gambar = str_replace(' ', '', $request->gambar_kiri->getClientOriginalName());
            $namaGambar9 = 'gambar_kiri/' . date('mYdHs') . rand(1, 10) . '_' . $gambar;
            $request->gambar_kiri->storeAs('public/uploads/', $namaGambar9);
        } else {
            $namaGambar9 = $dokumen_project->gambar_kiri;
        }

        if ($request->gambardepan_serongkanan) {
            Storage::disk('local')->delete('public/uploads/' . $dokumen_project->gambardepan_serongkanan);
            $gambar = str_replace(' ', '', $request->gambardepan_serongkanan->getClientOriginalName());
            $namaGambar10 = 'gambardepan_serongkanan/' . date('mYdHs') . rand(1, 10) . '_' . $gambar;
            $request->gambardepan_serongkanan->storeAs('public/uploads/', $namaGambar10);
        } else {
            $namaGambar10 = $dokumen_project->gambardepan_serongkanan;
        }

        if ($request->gambardepan_serongkiri) {
            Storage::disk('local')->delete('public/uploads/' . $dokumen_project->gambardepan_serongkiri);
            $gambar = str_replace(' ', '', $request->gambardepan_serongkiri->getClientOriginalName());
            $namaGambar11 = 'gambardepan_serongkiri/' . date('mYdHs') . rand(1, 10) . '_' . $gambar;
            $request->gambardepan_serongkiri->storeAs('public/uploads/', $namaGambar11);
        } else {
            $namaGambar11 = $dokumen_project->gambardepan_serongkiri;
        }

        if ($request->gambarbelakang_serongkanan) {
            Storage::disk('local')->delete('public/uploads/' . $dokumen_project->gambarbelakang_serongkanan);
            $gambar = str_replace(' ', '', $request->gambarbelakang_serongkanan->getClientOriginalName());
            $namaGambar12 = 'gambarbelakang_serongkanan/' . date('mYdHs') . rand(1, 10) . '_' . $gambar;
            $request->gambarbelakang_serongkanan->storeAs('public/uploads/', $namaGambar12);
        } else {
            $namaGambar12 = $dokumen_project->gambarbelakang_serongkanan;
        }

        if ($request->gambarberita_acara) {
            Storage::disk('local')->delete('public/uploads/' . $dokumen_project->gambarberita_acara);
            $gambar = str_replace(' ', '', $request->gambarberita_acara->getClientOriginalName());
            $namaGambar14 = 'gambarberita_acara/' . date('mYdHs') . rand(1, 10) . '_' . $gambar;
            $request->gambarberita_acara->storeAs('public/uploads/', $namaGambar14);
        } else {
            $namaGambar14 = $dokumen_project->gambarberita_acara;
        }

        if ($request->gambarbelakang_serongkekiri) {
            Storage::disk('local')->delete('public/uploads/' . $dokumen_project->gambarbelakang_serongkekiri);
            $gambar = str_replace(' ', '', $request->gambarbelakang_serongkekiri->getClientOriginalName());
            $namaGambar15 = 'gambarbelakang_serongkekiri/' . date('mYdHs') . rand(1, 10) . '_' . $gambar;
            $request->gambarbelakang_serongkekiri->storeAs('public/uploads/', $namaGambar15);
        } else {
            $namaGambar15 = $dokumen_project->gambarbelakang_serongkekiri;
        }

        $dokumen_project->update([
            'pelanggan_id' > $request->perintah_kerja_id,
            'typekaroseri_id' > $request->typekaroseri_id,
            'gambar_rancangbangun' => $namaGambar,
            'gambar_gesekannomesin' => $namaGambar2,
            'gambar_serut' => $namaGambar4,
            'gambar_faktur' => $namaGambar5,
            'gambar_depan' => $namaGambar6,
            'gambar_belakang' => $namaGambar7,
            'gambar_kanan' => $namaGambar8,
            'gambar_kiri' => $namaGambar9,
            'gambardepan_serongkanan' => $namaGambar10,
            'gambardepan_serongkiri' => $namaGambar11,
            // 'gambarbelakang_serongkekiri' => $namaGambar15,
            'gambarbelakang_serongkanan' => $namaGambar12,
            // 'gambarbelakang_serongkiri	' => $namaGambar13,
            'gambarbelakang_serongkekiri	' => $namaGambar15,
            'gambarberita_acara' => $namaGambar14,
            'no_serut' > $request->no_serut,
            'no_rangka' > $request->no_rangka,
            'no_mesin' > $request->no_mesin,
            'tahun' > $request->tahun,
            'status' => 'posting',
        ]);

        $pengambilans = Dokumen_project::where('id', $id)->first();
        $pengambil = Dokumen_project::find($id);
        $spks = Perintah_kerja::where('id', $pengambil->perintah_kerja_id)->first();

        $cetakpdfs = Pengambilanbahan::where('perintah_kerja_id', $spks->id)->get();

        return view('admin.inquery_dokumenproject.show', compact('cetakpdfs', 'pengambilans'));
    }

    public function unpostdokumenproject($id)
    {
        $item = Dokumen_project::where('id', $id)->first();
        $item->update([
            'status' => 'unpost'
        ]);

        return back()->with('success', 'Berhasil');
    }

    public function postingdokumenproject($id)
    {
        $item = Dokumen_project::where('id', $id)->first();
        $item->update([
            'status' => 'posting'
        ]);

        return back()->with('success', 'Berhasil');
    }


    public function hapusdokumenproject($id)
    {
        $tagihan = Dokumen_project::where('id', $id)->first();

        if ($tagihan) {
            $tagihan->delete();
            return back()->with('success', 'Berhasil menghapus Perhitungan');
        } else {
            // Handle the case where the Perhitungan with the given ID is not found
            return back()->with('error', 'Perhitungan tidak ditemukan');
        }
    }
}