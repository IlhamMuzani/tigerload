<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Perintah_kerja;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ProgrespengerjaanController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $inquery = Perintah_kerja::whereDate('created_at', $today)
            ->orWhere(function ($query) use ($today) {
                $query->where('status', 'posting')
                    ->whereDate('created_at', '<', $today);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.progres_pengerjaan.index', compact('inquery'));
    }

    public function edit($id)
    {
        $progres = Perintah_kerja::where('id', $id)->first();
        return view('admin/progres_pengerjaan.update', compact('progres'));
    }

    public function update(Request $request, $id)
    {

        $tgl_tungguproduksi = $request->tgl_tungguproduksi;
        $tgl_naikproduksi = $request->tgl_naikproduksi;
        $tgl_pengerjaanlantai = $request->tgl_pengerjaanlantai;
        $tgl_pengerjaandinding = $request->tgl_pengerjaandinding;
        $tgl_pengelasan = $request->tgl_pengelasan;
        $tgl_naiksasis = $request->tgl_naiksasis;
        $tgl_prosespengecatan = $request->tgl_prosespengecatan;
        $tgl_selesaiproduksi = $request->tgl_selesaiproduksi;
        $tgl_pengajuanserut = $request->tgl_pengajuanserut;
        $tgl_selesaipemeriksaan = $request->tgl_selesaipemeriksaan;
        $tgl_ditrimacustomer = $request->tgl_ditrimacustomer;

        $error = [];

        // Memeriksa urutan tanggal
        if ($tgl_naikproduksi && !$tgl_tungguproduksi) {
            $error[] = 'Pilih tanggal tunggu produksi terlebih dahulu.';
        }

        if ($tgl_pengerjaanlantai && !$tgl_naikproduksi) {
            $error[] = 'Pilih tanggal naik produksi terlebih dahulu.';
        }

        if ($tgl_pengerjaandinding && !$tgl_pengerjaanlantai) {
            $error[] = 'Pilih tanggal pengerjaan lantai terlebih dahulu.';
        }

        if ($tgl_pengelasan && !$tgl_pengerjaandinding) {
            $error[] = 'Pilih tanggal pengerjaan dinding terlebih dahulu.';
        }

        if ($tgl_naiksasis && !$tgl_pengelasan) {
            $error[] = 'Pilih tanggal pengelasan terlebih dahulu.';
        }

        if ($tgl_prosespengecatan && !$tgl_naiksasis) {
            $error[] = 'Pilih tanggal naik sasis terlebih dahulu.';
        }

        if ($tgl_selesaiproduksi && !$tgl_prosespengecatan) {
            $error[] = 'Pilih tanggal proses pengecatan terlebih dahulu.';
        }

        if ($tgl_pengajuanserut && !$tgl_selesaiproduksi) {
            $error[] = 'Pilih tanggal selesai produksi terlebih dahulu.';
        }

        if ($tgl_selesaipemeriksaan && !$tgl_pengajuanserut) {
            $error[] = 'Pilih tanggal pengajuan serut terlebih dahulu.';
        }

        if ($tgl_ditrimacustomer && !$tgl_selesaipemeriksaan) {
            $error[] = 'Pilih tanggal selesai pemeriksaan terlebih dahulu.';
        }

        // Validasi jika tanggal sebelumnya lebih besar dari tanggal berikutnya
        if ($tgl_naikproduksi && $tgl_tungguproduksi > $tgl_naikproduksi) {
            $error[] = 'Tanggal Naik Produksi harus setelah atau sama dengan Tanggal Tunggu Produksi.';
        }

        if ($tgl_pengerjaanlantai && $tgl_naikproduksi > $tgl_pengerjaanlantai) {
            $error[] = 'Tanggal Pengerjaan Lantai harus setelah atau sama dengan Tanggal Naik Produksi.';
        }

        if ($tgl_pengerjaandinding && $tgl_pengerjaanlantai > $tgl_pengerjaandinding) {
            $error[] = 'Tanggal Pengerjaan Dinding harus setelah atau sama dengan Tanggal Pengerjaan Lantai.';
        }

        if ($tgl_pengelasan && $tgl_pengerjaandinding > $tgl_pengelasan) {
            $error[] = 'Tanggal Pengelasan harus setelah atau sama dengan Tanggal Pengerjaan Dinding.';
        }

        if ($tgl_naiksasis && $tgl_pengelasan > $tgl_naiksasis) {
            $error[] = 'Tanggal Naik Sasis harus setelah atau sama dengan Tanggal Pengelasan.';
        }

        if ($tgl_prosespengecatan && $tgl_naiksasis > $tgl_prosespengecatan) {
            $error[] = 'Tanggal Proses Pengecatan harus setelah atau sama dengan Tanggal Naik Sasis.';
        }

        if ($tgl_selesaiproduksi && $tgl_prosespengecatan > $tgl_selesaiproduksi) {
            $error[] = 'Tanggal Selesai Produksi harus setelah atau sama dengan Tanggal Proses Pengecatan.';
        }

        if ($tgl_pengajuanserut && $tgl_selesaiproduksi > $tgl_pengajuanserut) {
            $error[] = 'Tanggal Pengajuan Serut harus setelah atau sama dengan Tanggal Selesai Produksi.';
        }

        if ($tgl_selesaipemeriksaan && $tgl_pengajuanserut > $tgl_selesaipemeriksaan) {
            $error[] = 'Tanggal Selesai Pemeriksaan harus setelah atau sama dengan Tanggal Selesai Produksi.';
        }

        if ($tgl_ditrimacustomer && $tgl_selesaipemeriksaan > $tgl_ditrimacustomer) {
            $error[] = 'Tanggal Diterima Customer harus setelah atau sama dengan Tanggal Pengajuan Serut.';
        }

        // Jika ada error, kembalikan dengan pesan kesalahan
        if (!empty($error)) {
            return back()->withInput()->with('error', $error);
        }

        $progres = Perintah_kerja::findOrFail($id);

        if ($request->ft_pengerjaanlantai) {
            Storage::disk('local')->delete('public/uploads/' . $progres->ft_pengerjaanlantai);
            $gambar = str_replace(' ', '', $request->ft_pengerjaanlantai->getClientOriginalName());
            $namaGambar = 'ft_pengerjaanlantai/' . date('mYdHs') . rand(1, 10) . '_' . $gambar;
            $request->ft_pengerjaanlantai->storeAs('public/uploads/', $namaGambar);
        } else {
            $namaGambar = $progres->ft_pengerjaanlantai;
        }

        if ($request->ft_pengerjaandinding) {
            Storage::disk('local')->delete('public/uploads/' . $progres->ft_pengerjaandinding);
            $gambar = str_replace(' ', '', $request->ft_pengerjaandinding->getClientOriginalName());
            $namaGambar2 = 'ft_pengerjaandinding/' . date('mYdHs') . rand(1, 10) . '_' . $gambar;
            $request->ft_pengerjaandinding->storeAs('public/uploads/', $namaGambar2);
        } else {
            $namaGambar2 = $progres->ft_pengerjaandinding;
        }

        if ($request->ft_pengelasan) {
            Storage::disk('local')->delete('public/uploads/' . $progres->ft_pengelasan);
            $gambar = str_replace(' ', '', $request->ft_pengelasan->getClientOriginalName());
            $namaGambar4 = 'ft_pengelasan/' . date('mYdHs') . rand(1, 10) . '_' . $gambar;
            $request->ft_pengelasan->storeAs('public/uploads/', $namaGambar4);
        } else {
            $namaGambar4 = $progres->ft_pengelasan;
        }

        if ($request->ft_naiksasis) {
            Storage::disk('local')->delete('public/uploads/' . $progres->ft_naiksasis);
            $gambar = str_replace(' ', '', $request->ft_naiksasis->getClientOriginalName());
            $namaGambar5 = 'ft_naiksasis/' . date('mYdHs') . rand(1, 10) . '_' . $gambar;
            $request->ft_naiksasis->storeAs('public/uploads/', $namaGambar5);
        } else {
            $namaGambar5 = $progres->ft_naiksasis;
        }

        if ($request->ft_prosespengecatan) {
            Storage::disk('local')->delete('public/uploads/' . $progres->ft_prosespengecatan);
            $gambar = str_replace(' ', '', $request->ft_prosespengecatan->getClientOriginalName());
            $namaGambar6 = 'ft_prosespengecatan/' . date('mYdHs') . rand(1, 10) . '_' . $gambar;
            $request->ft_prosespengecatan->storeAs('public/uploads/', $namaGambar6);
        } else {
            $namaGambar6 = $progres->ft_prosespengecatan;
        }

        if ($request->ft_selesaiproduksi) {
            Storage::disk('local')->delete('public/uploads/' . $progres->ft_selesaiproduksi);
            $gambar = str_replace(' ', '', $request->ft_selesaiproduksi->getClientOriginalName());
            $namaGambar7 = 'ft_selesaiproduksi/' . date('mYdHs') . rand(1, 10) . '_' . $gambar;
            $request->ft_selesaiproduksi->storeAs('public/uploads/', $namaGambar7);
        } else {
            $namaGambar7 = $progres->ft_selesaiproduksi;
        }

        if ($request->ft_pengajuanserut) {
            Storage::disk('local')->delete('public/uploads/' . $progres->ft_pengajuanserut);
            $gambar = str_replace(' ', '', $request->ft_pengajuanserut->getClientOriginalName());
            $namaGambar8 = 'ft_pengajuanserut/' . date('mYdHs') . rand(1, 10) . '_' . $gambar;
            $request->ft_pengajuanserut->storeAs('public/uploads/', $namaGambar8);
        } else {
            $namaGambar8 = $progres->ft_pengajuanserut;
        }

        if ($request->ft_selesaipemeriksaan) {
            Storage::disk('local')->delete('public/uploads/' . $progres->ft_selesaipemeriksaan);
            $gambar = str_replace(' ', '', $request->ft_selesaipemeriksaan->getClientOriginalName());
            $namaGambar9 = 'ft_selesaipemeriksaan/' . date('mYdHs') . rand(1, 10) . '_' . $gambar;
            $request->ft_selesaipemeriksaan->storeAs('public/uploads/', $namaGambar9);
        } else {
            $namaGambar9 = $progres->ft_selesaipemeriksaan;
        }

        if ($request->ft_ditrimacustomer) {
            Storage::disk('local')->delete('public/uploads/' . $progres->ft_ditrimacustomer);
            $gambar = str_replace(' ', '', $request->ft_ditrimacustomer->getClientOriginalName());
            $namaGambar10 = 'ft_ditrimacustomer/' . date('mYdHs') . rand(1, 10) . '_' . $gambar;
            $request->ft_ditrimacustomer->storeAs('public/uploads/', $namaGambar10);
        } else {
            $namaGambar10 = $progres->ft_ditrimacustomer;
        }

        $statusPengerjaan = null;

        // Pengecekan tiap pasangan ft dan tgl
        if (!empty($request->tgl_tungguproduksi)) {
            $statusPengerjaan = 'Tunggu Produksi';
        }

        if (!empty($request->tgl_naikproduksi)) {
            $statusPengerjaan = 'Naik Produksi';
        }

        // Pengecekan tiap pasangan ft dan tgl
        if (!empty($request->tgl_pengerjaanlantai)) {
            $statusPengerjaan = 'Pengerjaan Lantai';
        }

        if (!empty($request->tgl_pengerjaandinding)) {
            $statusPengerjaan = 'Pengerjaan Dinding';
        }

        if (!empty($request->tgl_pengelasan)) {
            $statusPengerjaan = 'Pengelasan';
        }

        if (!empty($request->tgl_naiksasis)) {
            $statusPengerjaan = 'Naik Sasis';
        }

        if (!empty($request->tgl_prosespengecatan)) {
            $statusPengerjaan = 'Proses Pengecatan';
        }

        if (!empty($request->tgl_selesaiproduksi)) {
            $statusPengerjaan = 'Selesai Produksi';
        }

        if (!empty($request->tgl_pengajuanserut)) {
            $statusPengerjaan = 'Pengajuan Serut';
        }

        if (!empty($request->tgl_selesaipemeriksaan)) {
            $statusPengerjaan = 'Selesai Pemeriksaan';
        }

        if (!empty($request->tgl_ditrimacustomer)) {
            $statusPengerjaan = 'Diterima Customer';
        }

        $progres->update([
            'tgl_tungguproduksi' => $request->tgl_tungguproduksi,

            'tgl_naikproduksi' => $request->tgl_naikproduksi,

            'ft_pengerjaanlantai' => $namaGambar,
            'tgl_pengerjaanlantai' => $request->tgl_pengerjaanlantai,

            'ft_pengerjaandinding' => $namaGambar2,
            'tgl_pengerjaandinding' => $request->tgl_pengerjaandinding,

            'ft_pengelasan' => $namaGambar4,
            'tgl_pengelasan' => $request->tgl_pengelasan,

            'ft_naiksasis' => $namaGambar5,
            'tgl_naiksasis' => $request->tgl_naiksasis,

            'ft_prosespengecatan' => $namaGambar6,
            'tgl_prosespengecatan' => $request->tgl_prosespengecatan,

            'ft_selesaiproduksi' => $namaGambar7,
            'tgl_selesaiproduksi' => $request->tgl_selesaiproduksi,

            'ft_pengajuanserut' => $namaGambar8,
            'tgl_pengajuanserut' => $request->tgl_pengajuanserut,

            'ft_selesaipemeriksaan' => $namaGambar9,
            'tgl_selesaipemeriksaan' => $request->tgl_selesaipemeriksaan,

            'ft_ditrimacustomer' => $namaGambar10,
            'tgl_ditrimacustomer' => $request->tgl_ditrimacustomer,

            'status_pengerjaan' => $statusPengerjaan ?? null,
        ]);

        $inquery = Perintah_kerja::where('id', $id)->first();
        $pengambil = Perintah_kerja::find($id);

        return redirect('admin/progres_pengerjaan')->with('success', 'Berhasil');
    }
}