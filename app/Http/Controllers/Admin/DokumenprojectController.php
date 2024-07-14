<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Dompdf\Dompdf;
use App\Models\Divisi;
use App\Models\Golongan;
use Illuminate\Http\Request;
use App\Models\Jenis_kendaraan;
use App\Http\Controllers\Controller;
use App\Models\Dokumen_project;
use App\Models\Gambar;
use App\Models\Merek;
use App\Models\Modelken;
use App\Models\Perintah_kerja;
use App\Models\Tipe;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;

class DokumenprojectController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $inquery = Dokumen_project::whereDate('created_at', $today)
            ->orWhere(function ($query) use ($today) {
                $query->where('status', 'unpost')
                    ->whereDate('created_at', '<', $today);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.dokumen_project.index', compact('inquery'));
    }


    public function create()
    {
        $spks = Perintah_kerja::get();
        return view('admin/dokumen_project.create', compact('spks'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'perintah_kerja_id' => 'required',
                'no_serut' => 'required',
                'no_rangka' => 'required',
                'no_mesin' => 'required',
                'no_skrb' => 'required',
                'tahun' => 'required',
            ],
            [
                'perintah_kerja_id.required' => 'Pilih nomor SPK',
                'no_serut.required' => 'No Serut',
                'no_rangka.required' => 'No Rangka',
                'no_mesin.required' => 'No Mesin',
                'no_skrb.required' => 'No Skrb',
                'tahun.required' => 'Masukkan tahun pembuatan',
            ]
        );

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return back()->withInput()->with('error', $errors);
        }


        if ($request->gambar_rancangbangun) {
            $gambar = str_replace(' ', '', $request->gambar_rancangbangun->getClientOriginalName());
            $namaGambar = 'gambar_rancangbangun/' . date('mYdHs') . rand(1, 10) . '_' . $gambar;
            $request->gambar_rancangbangun->storeAs('public/uploads/', $namaGambar);
        } else {
            $namaGambar = null;
        }

        if ($request->gambar_gesekannomesin) {
            $gambar = str_replace(' ', '', $request->gambar_gesekannomesin->getClientOriginalName());
            $namaGambar2 = 'gambar_gesekannomesin/' . date('mYdHs') . rand(1, 10) . '_' . $gambar;
            $request->gambar_gesekannomesin->storeAs('public/uploads/', $namaGambar2);
        } else {
            $namaGambar2 = null;
        }

        if ($request->gambar_serut) {
            $gambar = str_replace(' ', '', $request->gambar_serut->getClientOriginalName());
            $namaGambar4 = 'gambar_serut/' . date('mYdHs') . rand(1, 10) . '_' . $gambar;
            $request->gambar_serut->storeAs('public/uploads/', $namaGambar4);
        } else {
            $namaGambar4 = null;
        }

        if ($request->gambar_faktur) {
            $gambar = str_replace(' ', '', $request->gambar_faktur->getClientOriginalName());
            $namaGambar5 = 'gambar_faktur/' . date('mYdHs') . rand(1, 10) . '_' . $gambar;
            $request->gambar_faktur->storeAs('public/uploads/', $namaGambar5);
        } else {
            $namaGambar5 = null;
        }

        if ($request->gambar_depan) {
            $gambar = str_replace(' ', '', $request->gambar_depan->getClientOriginalName());
            $namaGambar6 = 'gambar_depan/' . date('mYdHs') . rand(1, 10) . '_' . $gambar;
            $request->gambar_depan->storeAs('public/uploads/', $namaGambar6);
        } else {
            $namaGambar6 = null;
        }

        if ($request->gambar_belakang) {
            $gambar = str_replace(' ', '', $request->gambar_depan->getClientOriginalName());
            $namaGambar7 = 'gambar_belakang/' . date('mYdHs') . rand(1, 10) . '_' . $gambar;
            $request->gambar_belakang->storeAs('public/uploads/', $namaGambar7);
        } else {
            $namaGambar7 = null;
        }

        if ($request->gambar_kanan) {
            $gambar = str_replace(' ', '', $request->gambar_kanan->getClientOriginalName());
            $namaGambar8 = 'gambar_kanan/' . date('mYdHs') . rand(1, 10) . '_' . $gambar;
            $request->gambar_kanan->storeAs('public/uploads/', $namaGambar8);
        } else {
            $namaGambar8 = null;
        }

        if ($request->gambar_kiri) {
            $gambar = str_replace(' ', '', $request->gambar_kiri->getClientOriginalName());
            $namaGambar9 = 'gambar_kiri/' . date('mYdHs') . rand(1, 10) . '_' . $gambar;
            $request->gambar_kiri->storeAs('public/uploads/', $namaGambar9);
        } else {
            $namaGambar9 = null;
        }

        if ($request->gambardepan_serongkanan) {
            $gambar = str_replace(' ', '', $request->gambardepan_serongkanan->getClientOriginalName());
            $namaGambar10 = 'gambardepan_serongkanan/' . date('mYdHs') . rand(1, 10) . '_' . $gambar;
            $request->gambardepan_serongkanan->storeAs('public/uploads/', $namaGambar10);
        } else {
            $namaGambar10 = null;
        }


        if ($request->gambardepan_serongkiri) {
            $gambar = str_replace(' ', '', $request->gambardepan_serongkiri->getClientOriginalName());
            $namaGambar11 = 'gambardepan_serongkiri/' . date('mYdHs') . rand(1, 10) . '_' . $gambar;
            $request->gambardepan_serongkiri->storeAs('public/uploads/', $namaGambar11);
        } else {
            $namaGambar11 = null;
        }


        if ($request->gambarbelakang_serongkanan) {
            $gambar = str_replace(' ', '', $request->gambarbelakang_serongkanan->getClientOriginalName());
            $namaGambar12 = 'gambarbelakang_serongkanan/' . date('mYdHs') . rand(1, 10) . '_' . $gambar;
            $request->gambarbelakang_serongkanan->storeAs('public/uploads/', $namaGambar12);
        } else {
            $namaGambar12 = null;
        }


        // if ($request->gambarbelakang_serongkiri) {
        //     $gambar = str_replace(' ', '', $request->gambarbelakang_serongkiri->getClientOriginalName());
        //     $namaGambar13 = 'gambarbelakang_serongkiri/' . date('mYdHs') . rand(1, 10) . '_' . $gambar;
        //     $request->gambarbelakang_serongkiri->storeAs('public/uploads/', $namaGambar13);
        // } else {
        //     $namaGambar13 = null;
        // }

        if ($request->gambarberita_acara) {
            $gambar = str_replace(' ', '', $request->gambarberita_acara->getClientOriginalName());
            $namaGambar14 = 'gambarberita_acara/' . date('mYdHs') . rand(1, 10) . '_' . $gambar;
            $request->gambarberita_acara->storeAs('public/uploads/', $namaGambar14);
        } else {
            $namaGambar14 = null;
        }

        if ($request->gambarbelakang_serongkekiri) {
            $gambar = str_replace(' ', '', $request->gambarbelakang_serongkekiri->getClientOriginalName());
            $namaGambar15 = 'gambarbelakang_serongkekiri/' . date('mYdHs') . rand(1, 10) . '_' . $gambar;
            $request->gambarbelakang_serongkekiri->storeAs('public/uploads/', $namaGambar15);
        } else {
            $namaGambar15 = null;
        }

        $kode = $this->kode();

        $tanggal = Carbon::now()->format('Y-m-d');
        $dokumen_project = Dokumen_project::create(array_merge(
            $request->all(),
            [
                'user_id' => auth()->user()->id,
                'perintah_kerja_id' > $request->perintah_kerja_id,
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
                'gambarbelakang_serongkanan' => $namaGambar12,
                // 'gambarbelakang_serongkiri	' => $namaGambar13,
                'gambarbelakang_serongkekiri' => $namaGambar15,
                'gambarberita_acara' => $namaGambar14,
                'kode_dokumen' => $this->kode(),
                'tanggal_awal' => $tanggal,
                'status' => 'posting',
            ]
        ));

        $encryptedId = Crypt::encryptString($dokumen_project->id);
        $dokumen_project->qrcode_dokumen = 'https://tigerload.id/dokumen_project/' . $encryptedId;
        $dokumen_project->save();

        return redirect('admin/dokumen_project')->with('success', 'Berhasil menambahkan dokumen_project');
    }

    public function show($id)
    {

        $inquery = Dokumen_project::where('id', $id)->first();
        return view('admin/dokumen_project.show', compact('inquery'));
    }

    public function cetakpdf($id)
    {
        $cetakpdf = Dokumen_project::where('id', $id)->first();

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('admin.dokumen_project.cetak_pdf', compact('cetakpdf'));
        $pdf->setPaper('letter', 'portrait');

        // Return the PDF as a response
        return $pdf->stream('Surat_Penerimaan_pembayaran.pdf');
    }

    public function kode()
    {
        $typekaroseri = Dokumen_project::all();
        if ($typekaroseri->isEmpty()) {
            $num = "000001";
        } else {
            $id = Dokumen_project::getId();
            foreach ($id as $value);
            $idlm = $value->id;
            $idbr = $idlm + 1;
            $num = sprintf("%06s", $idbr);
        }

        $data = 'DD';
        $kode_type = $data . $num;
        return $kode_type;
    }
}