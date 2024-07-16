<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Perintah_kerja;
use App\Models\Project;
use App\Models\Spk;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $inquery = Project::whereDate('created_at', $today)
            ->orWhere(function ($query) use ($today) {
                $query->where('status', 'unpost')
                    ->whereDate('created_at', '<', $today);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.project.index', compact('inquery'));
    }

    public function create()
    {
        $spks = Perintah_kerja::get();
        return view('admin.project.create', compact('spks'));
    }
    public function store(Request $request)
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

        $kode = $this->kode();
        $tanggal1 = Carbon::now('Asia/Jakarta');
        $format_tanggal = $tanggal1->format('d F Y');
        $tanggal = Carbon::now()->format('Y-m-d');

        $projects = Project::create(array_merge(
            $request->all(),
            [
                'perintah_kerja_id' => $request->perintah_kerja_id,
                'kode_project' => $kode,
                'tanggal_awal' => $tanggal,
                'tanggal' => $format_tanggal,
                'status' => 'posting',
                'qrcode_project' => 'https://tigerload.id/project/' . $kode,

            ]
        ));

        // $encryptedId = Crypt::encryptString($projects->id);
        // $projects->qrcode_project = 'https://tigerload.id/project/' . $encryptedId;
        $projects->save();

        return redirect('admin/project')->with('success', 'Berhasil menyimpan');
    }


    public function show($id)
    {
        $cetakpdf = Project::where('id', $id)->first();

        return view('admin.project.show', compact('cetakpdf'));
    }
    public function cetakpdf($id)
    {
        $projects = Project::where('id', $id)->first();
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('admin.project.cetak_pdf', compact('projects'));
        $pdf->setPaper('folio', 'portrait');
        return $pdf->stream('Faktur_Pembelian.pdf');
    }


    public function cetakqrcode($id)
    {
        $projects = Project::find($id);
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('admin.project.cetak_qrcode', compact('projects'));

        // Mengatur jenis kertas dan orientasi menjadi lanscape
        $pdf->setPaper([0, 0, 210, 105], 'portrait'); // 612x396 piksel setara dengan 8.5x5.5 inci

        return $pdf->stream('QrCodeKendaraan.pdf');
    }

    // public function cetakqrcode($id)
    // {
    //     $projects = Project::find($id);
    //     $pdf = app('dompdf.wrapper');
    //     $pdf->loadView('admin.project.cetak_qrcode', compact('projects'));

    //     // Mengatur jenis kertas dan orientasi menjadi lanscape
    //     $pdf->setPaper([0, 0, 200, 100], 'landscape'); // 612x396 piksel setara dengan 8.5x5.5 inci

    //     return $pdf->stream('QrCodeKendaraan.pdf');
    // }
    public function kode()
    {
        $lastBarang = Project::latest()->first();
        if (!$lastBarang) {
            $num = 1;
        } else {
            $lastCode = $lastBarang->qrcode_project;
            $num = (int) substr($lastCode, strlen('TGR')) + 1;
        }
        $formattedNum = sprintf("%06s", $num);
        $prefix = 'TGR';
        $newCode = $prefix . $formattedNum;
        return $newCode;
    }

    public function destroy($id)
    {
        $project = Pelanggan::find($id);
        $project->delete();

        return redirect('admin/deposit_pemesanan')->with('success', 'Berhasil menghapus DP');
    }

    public function cetak_projectfilter(Request $request)
    {
        $selectedIds = explode(',', $request->input('ids'));

        // Mengambil faktur berdasarkan id yang dipilih
        $cetakpdfs = Project::whereIn('id', $selectedIds)->orderBy('id', 'DESC')->get();

        $pdf = app('dompdf.wrapper');

        $pdf->setPaper([0, 0, 210, 90], 'portrait'); // 612x396 piksel setara dengan 8.5x5.5 inci

        $pdf->loadView('admin.project.cetak_qrcodefilter', compact('cetakpdfs'));

        return $pdf->stream('SelectedFaktur.pdf');
    }
}
