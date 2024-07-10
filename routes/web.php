<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [AuthController::class, 'index']);
Route::get('login', [AuthController::class, 'index']);
Route::get('loginn', [AuthController::class, 'tologin']);
Route::get('register', [AuthController::class, 'toregister']);
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'registeruser']);
Route::get('logout', [AuthController::class, 'logout']);
Route::get('check-user', [HomeController::class, 'check_user']);
Route::get('surat_penawaran/{kode}', [\App\Http\Controllers\SuratPenawaranController::class, 'detail']);
Route::get('spk/{kode}', [\App\Http\Controllers\SpkController::class, 'detail']);
Route::get('perintah_kerja/{kode}', [\App\Http\Controllers\PerintahkerjaController::class, 'detail']);
Route::get('penerimaan_pembayaran/{kode}', [\App\Http\Controllers\PenerimaanpembayaranController::class, 'detail']);

Route::middleware('admin')->prefix('admin')->group(function () {
    Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index']);
    Route::get('user/access/{id}', [\App\Http\Controllers\Admin\UserController::class, 'access']);
    Route::post('user-access/{id}', [\App\Http\Controllers\Admin\UserController::class, 'access_user']);
    Route::post('user-create', [\App\Http\Controllers\Admin\UserController::class, 'update_user']);
    Route::get('user/karyawan/{id}', [\App\Http\Controllers\Admin\UserController::class, 'karyawan']);
    Route::get('akses/access/{id}', [\App\Http\Controllers\Admin\AksesController::class, 'access']);
    Route::post('akses-access/{id}', [\App\Http\Controllers\Admin\AksesController::class, 'access_user']);
    Route::post('mereks', [\App\Http\Controllers\Admin\KendaraanController::class, 'merek']);
    Route::post('marketings', [\App\Http\Controllers\Admin\KomisiController::class, 'tambah_marketing']);
    Route::get('penjualan/cetak-pdf/{id}', [\App\Http\Controllers\Admin\PenjualanController::class, 'cetakpdf']);
    Route::get('dokumen_project/cetak-pdf/{id}', [\App\Http\Controllers\Admin\DokumenprojectController::class, 'cetakpdf']);
    Route::get('list_dokument/cetak-pdf/{id}', [\App\Http\Controllers\Admin\ListdokumentController::class, 'cetakpdf']);
    Route::get('pelunasan_penjualan/cetak-pdf/{id}', [\App\Http\Controllers\Admin\PelunasanController::class, 'cetakpdf']);
    Route::get('unpostpenjualan/{id}', [\App\Http\Controllers\Admin\InqueryPenjualanController::class, 'unpostpenjualan'])->name('unpostpenjualan');
    Route::get('postingpenjualan/{id}', [\App\Http\Controllers\Admin\InqueryPenjualanController::class, 'postingpenjualan'])->name('postingpenjualan');
    Route::get('print_laporanpenjualan', [\App\Http\Controllers\Admin\LaporanPenjualanController::class, 'print_laporanpenjualan']);
    Route::get('laporan_penjualan', [\App\Http\Controllers\Admin\LaporanPenjualanController::class, 'index']);
    Route::post('pelanggans', [\App\Http\Controllers\Admin\SpkController::class, 'pelanggan']);
    Route::post('karoseris', [\App\Http\Controllers\Admin\SpkController::class, 'karoseri']);
    Route::get('profile', [\App\Http\Controllers\Admin\ProfileController::class, 'index']);
    Route::post('profile/update', [\App\Http\Controllers\Admin\ProfileController::class, 'update']);
    Route::delete('typekaroseri/spesifikasi/{id}', [\App\Http\Controllers\Admin\TypekaroseriController::class, 'delete_spesifikasi']);
    Route::get('deposit_pemesanan/spk/{id}', [\App\Http\Controllers\Admin\DepositpemesananController::class, 'spk']);
    Route::resource('supplier', \App\Http\Controllers\Admin\SupplierController::class);
    Route::get('spk/cetak-pdf/{id}', [\App\Http\Controllers\Admin\SpkController::class, 'cetakpdf']);
    Route::get('surat_penawaran/cetak-pdf/{id}', [\App\Http\Controllers\Admin\SuratPenawaranController::class, 'cetakpdf']);
    Route::get('deposit_pemesanan/cetak-pdf/{id}', [\App\Http\Controllers\Admin\DepositpemesananController::class, 'cetakpdf']);
    // Route::resource('sparepart', \App\Http\Controllers\Admin\SparepartController::class);
    Route::get('unpost/{id}', [\App\Http\Controllers\Admin\InquerySpkController::class, 'unpost'])->name('unpost');
    Route::get('posting/{id}', [\App\Http\Controllers\Admin\InquerySpkController::class, 'posting'])->name('posting');
    Route::get('laporan_slipgaji', [\App\Http\Controllers\Admin\LaporanSlipgajiController::class, 'index']);
    Route::get('print_slipgaji', [\App\Http\Controllers\Admin\LaporanSlipgajiController::class, 'print_slipgaji']);
    Route::resource('laporan_slipgaji', \App\Http\Controllers\Admin\LaporanSlipgajiController::class);
    Route::post('add_tipe', [\App\Http\Controllers\Admin\TipeController::class, 'add_tipe']);

    Route::resource('tablesurat', \App\Http\Controllers\Admin\TablesuratpenawaranController::class);
    Route::resource('tablepesanan', \App\Http\Controllers\Admin\TablepesananController::class);
    Route::resource('tabledeposit', \App\Http\Controllers\Admin\TabledepositController::class);
    Route::resource('tablepengambilanbahan', \App\Http\Controllers\Admin\TablepengambilanbahanController::class);
    Route::resource('tablepenjualan', \App\Http\Controllers\Admin\TablepenjualanController::class);
    Route::resource('tablepelunasanpenjualan', \App\Http\Controllers\Admin\TablepelunasanController::class);
    Route::resource('tablepembelian', \App\Http\Controllers\Admin\TablepembelianController::class);
    Route::resource('tablepelunasanpembelian', \App\Http\Controllers\Admin\TablepelunasanpembelianController::class);
    Route::resource('tablereturn', \App\Http\Controllers\Admin\TablereturnController::class);
    Route::resource('tablepopembelian', \App\Http\Controllers\Admin\TablepoController::class);
    Route::resource('tablekasbon', \App\Http\Controllers\Admin\TablekasbonController::class);

    Route::get('perhitungan_bahanbaku/spk/{id}', [\App\Http\Controllers\Admin\PerhitunganbahanbakuController::class, 'spk']);
    Route::post('add_spks', [\App\Http\Controllers\Admin\PerhitunganbahanbakuController::class, 'add_spks']);

    Route::get('inquery_penerimaanpembayaran/unpostpenerimaan/{id}', [\App\Http\Controllers\Admin\InquerypenerimaanpembayaranController::class, 'unpostpenerimaan']);
    Route::get('inquery_penerimaanpembayaran/postingpenerimaan/{id}', [\App\Http\Controllers\Admin\InquerypenerimaanpembayaranController::class, 'postingpenerimaan']);

    Route::get('inquery_pembelian/unpostpembelian/{id}', [\App\Http\Controllers\Admin\InqueryPembelianController::class, 'unpostpembelian']);
    Route::get('inquery_pembelian/postingpembelian/{id}', [\App\Http\Controllers\Admin\InqueryPembelianController::class, 'postingpembelian']);

    Route::get('inquery_pembelianreturn/unpostpembelianreturn/{id}', [\App\Http\Controllers\Admin\InqueryReturnpembelianController::class, 'unpostpembelianreturn']);
    Route::get('inquery_pembelianreturn/postingpembelianreturn/{id}', [\App\Http\Controllers\Admin\InqueryReturnpembelianController::class, 'postingpembelianreturn']);

    Route::get('inquery_dokumenproject/unpostdokumenproject/{id}', [\App\Http\Controllers\Admin\InqueryDokumenprojectController::class, 'unpostdokumenproject']);
    Route::get('inquery_dokumenproject/postingdokumenproject/{id}', [\App\Http\Controllers\Admin\InqueryDokumenprojectController::class, 'postingdokumenproject']);

    Route::get('inquery_penjualan/unpostpenjualan/{id}', [\App\Http\Controllers\Admin\InqueryPenjualanController::class, 'unpostpenjualan']);
    Route::get('inquery_penjualan/postingpenjualan/{id}', [\App\Http\Controllers\Admin\InqueryPenjualanController::class, 'postingpenjualan']);

    Route::get('inquery_penawaran/unpostpenawaran/{id}', [\App\Http\Controllers\Admin\InquerySuratpenawaranController::class, 'unpostpenawaran']);
    Route::get('inquery_penawaran/postingpenawaran/{id}', [\App\Http\Controllers\Admin\InquerySuratpenawaranController::class, 'postingpenawaran']);

    Route::get('inquery_deposit/unpostdeposit/{id}', [\App\Http\Controllers\Admin\InqueryDepositController::class, 'unpostdeposit']);
    Route::get('inquery_deposit/postingdeposit/{id}', [\App\Http\Controllers\Admin\InqueryDepositController::class, 'postingdeposit']);

    Route::get('inquery_spk/unpost/{id}', [\App\Http\Controllers\Admin\InquerySpkController::class, 'unpost']);
    Route::get('inquery_spk/posting/{id}', [\App\Http\Controllers\Admin\InquerySpkController::class, 'posting']);

    Route::get('inquery_pengambilanbahan/unpostpengambilan/{id}', [\App\Http\Controllers\Admin\InqueryPengambilanbahanController::class, 'unpostpengambilan']);
    Route::get('inquery_pengambilanbahan/postingpengambilan/{id}', [\App\Http\Controllers\Admin\InqueryPengambilanbahanController::class, 'postingpengambilan']);

    Route::get('inquery_perhitunganbahanbaku/unpostperhitungan/{id}', [\App\Http\Controllers\Admin\InqueryPerhitunganbahanbakuController::class, 'unpostperhitungan']);
    Route::get('inquery_perhitunganbahanbaku/postingperhitungan/{id}', [\App\Http\Controllers\Admin\InqueryPerhitunganbahanbakuController::class, 'postingperhitungan']);

    Route::get('inquery_pelunasan/unpostpelunasan/{id}', [\App\Http\Controllers\Admin\InqueryPelunasanController::class, 'unpostpelunasan']);
    Route::get('inquery_pelunasan/postingpelunasan/{id}', [\App\Http\Controllers\Admin\InqueryPelunasanController::class, 'postingpelunasan']);
    
    Route::get('unpostpenawaran/{id}', [\App\Http\Controllers\Admin\InquerySuratpenawaranController::class, 'unpostpenawaran'])->name('unpostpenawaran');
    Route::get('postingpenawaran/{id}', [\App\Http\Controllers\Admin\InquerySuratpenawaranController::class, 'postingpenawaran'])->name('postingpenawaran');
    Route::get('unpostdeposit/{id}', [\App\Http\Controllers\Admin\InqueryDepositController::class, 'unpostdeposit'])->name('unpostdeposit');
    Route::get('postingdeposit/{id}', [\App\Http\Controllers\Admin\InqueryDepositController::class, 'postingdeposit'])->name('postingdeposit');
    Route::get('print_laporanspk', [\App\Http\Controllers\Admin\LaporanSpkController::class, 'print_laporanspk']);
    Route::get('laporan_spk', [\App\Http\Controllers\Admin\LaporanSpkController::class, 'index']);
    Route::get('pembelian/supplier/{id}', [\App\Http\Controllers\Admin\PembelianController::class, 'supplier']);
    Route::get('inquery_pembelian', [\App\Http\Controllers\Admin\InqueryPembelianController::class, 'index']);
    Route::get('inquery_pelunasan', [\App\Http\Controllers\Admin\InqueryPelunasanController::class, 'index']);
    Route::post('tambah_supplier', [\App\Http\Controllers\Admin\PopembelianController::class, 'tambah_supplier']);
    Route::get('inquery_slipgaji', [\App\Http\Controllers\Admin\InqueryslipgajiController::class, 'index']);

    Route::get('laporan_deposit', [\App\Http\Controllers\Admin\LaporanDepositController::class, 'index']);
    Route::get('laporan_pelunasan', [\App\Http\Controllers\Admin\LaporanPelunasanController::class, 'index']);
    Route::get('print_laporandeposit', [\App\Http\Controllers\Admin\LaporanDepositController::class, 'print_laporandeposit']);
    Route::get('print_laporanpelunasan', [\App\Http\Controllers\Admin\LaporanPelunasanController::class, 'print_laporanpelunasan']);
    Route::get('laporan_pelunasanglobalpembelian', [\App\Http\Controllers\Admin\LaporanPelunasanpembelianController::class, 'indexglobalpembelian']);
    Route::get('print_pelunasanglobalpembelian', [\App\Http\Controllers\Admin\LaporanPelunasanpembelianController::class, 'print_pelunasanglobalpembelian']);
    Route::get('pembelian/cetak-pdf/{id}', [\App\Http\Controllers\Admin\PembelianController::class, 'cetakpdf']);
    Route::get('return_pembelian/cetak-pdf/{id}', [\App\Http\Controllers\Admin\ReturnpembelianController::class, 'cetakpdf']);
    Route::get('perhitungan_bahanbaku/cetak-pdf/{id}', [\App\Http\Controllers\Admin\PerhitunganbahanbakuController::class, 'cetakpdf']);

    Route::get('hapuspenjualan/{id}', [\App\Http\Controllers\Admin\InqueryPenjualanController::class, 'hapuspenjualan'])->name('hapuspenjualan');
    Route::get('hapuspenerimaanpembayaran/{id}', [\App\Http\Controllers\Admin\InquerypenerimaanpembayaranController::class, 'hapuspenerimaanpembayaran'])->name('hapuspenerimaanpembayaran');
    Route::get('hapusperhitunganbahan/{id}', [\App\Http\Controllers\Admin\InqueryPerhitunganbahanbakuController::class, 'hapusperhitunganbahan'])->name('hapusperhitunganbahan');
    Route::get('hapusdokumenproject/{id}', [\App\Http\Controllers\Admin\InqueryDokumenprojectController::class, 'hapusdokumenproject'])->name('hapusdokumenproject');

    Route::get('hapusperintahkerja/{id}', [\App\Http\Controllers\Admin\InqueryperintahkerjaController::class, 'hapusperintahkerja'])->name('hapusperintahkerja');
    Route::get('inquery_perintahkerja/unpostperintahkerja/{id}', [\App\Http\Controllers\Admin\InqueryperintahkerjaController::class, 'unpostperintahkerja']);
    Route::get('inquery_perintahkerja/postingperintahkerja/{id}', [\App\Http\Controllers\Admin\InqueryperintahkerjaController::class, 'postingperintahkerja']);
    
    Route::get('hapusdeposit/{id}', [\App\Http\Controllers\Admin\InqueryDepositController::class, 'hapusdeposit'])->name('hapusdeposit');
    Route::get('hapuspengambilan/{id}', [\App\Http\Controllers\Admin\InqueryPengambilanbahanController::class, 'hapuspengambilan'])->name('hapuspengambilan');
    Route::get('hapuspenawaran/{id}', [\App\Http\Controllers\Admin\InquerySuratpenawaranController::class, 'hapuspenawaran'])->name('hapuspenawaran');
    Route::get('hapusspk/{id}', [\App\Http\Controllers\Admin\InquerySpkController::class, 'hapusspk'])->name('hapusspk');

    Route::get('hapuspembelian/{id}', [\App\Http\Controllers\Admin\InqueryPembelianController::class, 'hapuspembelian'])->name('hapuspembelian');
    Route::get('unpostpengambilan/{id}', [\App\Http\Controllers\Admin\InqueryPengambilanbahanController::class, 'unpostpengambilan'])->name('unpostpengambilan');
    Route::get('postingpengambilan/{id}', [\App\Http\Controllers\Admin\InqueryPengambilanbahanController::class, 'postingpengambilan'])->name('postingpengambilan');
    Route::get('pengambilanbahan/cetak-pdf/{id}', [\App\Http\Controllers\Admin\PengambilanbahanController::class, 'cetakpdf']);
    Route::get('inquery_pengambilan', [\App\Http\Controllers\Admin\InqueryPengambilanbahanController::class, 'index']);
    Route::get('penerimaan_pembayaran/cetak-pdf/{id}', [\App\Http\Controllers\Admin\PenerimaanpembayaranController::class, 'cetakpdf']);
    Route::get('perintah_kerja/cetak-pdf/{id}', [\App\Http\Controllers\Admin\PerintahkerjaController::class, 'cetakpdf']);

    Route::get('inquery_popembelian', [\App\Http\Controllers\Admin\InqueryPopembelianController::class, 'index']);
    Route::get('unpostbarangpo/{id}', [\App\Http\Controllers\Admin\InqueryPopembelianController::class, 'unpostbarangpo'])->name('unpostbarangpo');
    Route::get('postingbarangpo/{id}', [\App\Http\Controllers\Admin\InqueryPopembelianController::class, 'postingbarangpo'])->name('postingbarangpo');
    Route::get('popembelian/cetak-pdf/{id}', [\App\Http\Controllers\Admin\PopembelianController::class, 'cetakpdf']);

    Route::get('unpostpelunasan/{id}', [\App\Http\Controllers\Admin\InqueryPelunasanController::class, 'unpostpelunasan'])->name('unpostpelunasan');
    Route::get('postingpelunasan/{id}', [\App\Http\Controllers\Admin\InqueryPelunasanController::class, 'postingpelunasan'])->name('postingpelunasan');

    Route::get('laporan_pembelian', [\App\Http\Controllers\Admin\LaporanPembelianController::class, 'index']);
    Route::get('laporan_popembelian', [\App\Http\Controllers\Admin\LaporanPopembelianController::class, 'index']);
    Route::get('laporan_pengambilanbahan', [\App\Http\Controllers\Admin\LaporanPengambilanbahanController::class, 'index']);
    Route::get('laporan_returnpembelian', [\App\Http\Controllers\Admin\LaporanPembelianreturnController::class, 'index']);

    Route::get('modal_tambah', [\App\Http\Controllers\Admin\PerhitunganbahanbakuController::class, 'modal_tambah']);

    Route::get('laporan_pengambilanbahanspk', [\App\Http\Controllers\Admin\LaporanPengambilanbahanspkController::class, 'index']);
    Route::get('print_laporanpengambilanbahanspk', [\App\Http\Controllers\Admin\LaporanPengambilanbahanspkController::class, 'print_laporanpengambilanbahanspk']);

    Route::get('print_laporanpopembelian', [\App\Http\Controllers\Admin\LaporanPopembelianController::class, 'print_laporanpopembelian']);
    Route::get('print_laporanpembelian', [\App\Http\Controllers\Admin\LaporanPembelianController::class, 'print_laporanpembelian']);
    Route::get('print_laporanpembelianreturn', [\App\Http\Controllers\Admin\LaporanPembelianreturnController::class, 'print_laporanpembelianreturn']);
    Route::get('print_laporanpengambilanbahan', [\App\Http\Controllers\Admin\LaporanPengambilanbahanController::class, 'print_laporanpengambilanbahan']);

    Route::get('faktur_pelunasanpembelian/cetak-pdf/{id}', [\App\Http\Controllers\Admin\PelunasanpembelianController::class, 'cetakpdf']);
    Route::get('unpostpelunasanpembelian/{id}', [\App\Http\Controllers\Admin\InqueryFakturpelunasanpembelianController::class, 'unpostpelunasanpembelian'])->name('unpostpelunasanpembelian');
    Route::get('postingpelunasanpembelian/{id}', [\App\Http\Controllers\Admin\InqueryFakturpelunasanpembelianController::class, 'postingpelunasanpembelian'])->name('postingpelunasanpembelian');
    Route::get('hapuspelunasanpembelian/{id}', [\App\Http\Controllers\Admin\InqueryFakturpelunasanpembelianController::class, 'hapuspelunasanpembelian'])->name('hapuspelunasanpembelian');
    Route::get('laporan_fakturpelunasanpembelian', [\App\Http\Controllers\Admin\LaporanPelunasanpembelianController::class, 'index']);
    Route::get('hapuspelunasan/{id}', [\App\Http\Controllers\Admin\InqueryPelunasanController::class, 'hapuspelunasan'])->name('hapuspelunasan');

    Route::get('editnonppn/{id}', [\App\Http\Controllers\Admin\InqueryinvoicesuratpesananController::class, 'editnonppn'])->name('editnonppn');

    Route::get('inquery_penerimaankaskecil/unpostpenerimaan/{id}', [\App\Http\Controllers\Admin\InqueryPenerimaankaskecilController::class, 'unpostpenerimaan']);
    Route::get('inquery_penerimaankaskecil/postingpenerimaan/{id}', [\App\Http\Controllers\Admin\InqueryPenerimaankaskecilController::class, 'postingpenerimaan']);

    Route::get('inquery_invoicesuratpesanan/unpostpesanan/{id}', [\App\Http\Controllers\Admin\InqueryinvoicesuratpesananController::class, 'unpostpesanan']);
    Route::get('inquery_invoicesuratpesanan/postingpesanan/{id}', [\App\Http\Controllers\Admin\InqueryinvoicesuratpesananController::class, 'postingpesanan']);
    Route::get('hapuspesanan/{id}', [\App\Http\Controllers\Admin\InqueryinvoicesuratpesananController::class, 'hapuspesanan'])->name('hapuspesanan');

    Route::get('unpostpenerimaan/{id}', [\App\Http\Controllers\Admin\InqueryPenerimaankaskecilController::class, 'unpostpenerimaan'])->name('unpostpenerimaan');
    Route::get('postingpenerimaan/{id}', [\App\Http\Controllers\Admin\InqueryPenerimaankaskecilController::class, 'postingpenerimaan'])->name('postingpenerimaan');
    Route::get('hapuspenerimaan/{id}', [\App\Http\Controllers\Admin\InqueryPenerimaankaskecilController::class, 'hapuspenerimaan'])->name('hapuspenerimaan');
    Route::get('perhitungan_gaji/cetak-pdf/{id}', [\App\Http\Controllers\Admin\PerhitungangajiController::class, 'cetakpdf']);
    Route::get('perhitungan_gajibulanan/cetak-pdf/{id}', [\App\Http\Controllers\Admin\PerhitungangajibulananController::class, 'cetakpdf']);
    Route::delete('inquery_perhitungangaji/deletedetailperhitungangaji/{id}', [\App\Http\Controllers\Admin\InqueryPerhitungangajiController::class, 'deletedetailperhitungangaji']);
    Route::delete('inquery_perhitungangajibulanan/deletedetailperhitungan/{id}', [\App\Http\Controllers\Admin\InqueryPerhitungangajibulananController::class, 'deletedetailperhitungan']);
    Route::get('inquery_perhitungangaji/unpostperhitungan/{id}', [\App\Http\Controllers\Admin\InqueryPerhitungangajiController::class, 'unpostperhitungan']);
    Route::get('inquery_perhitungangaji/postingperhitungan/{id}', [\App\Http\Controllers\Admin\InqueryPerhitungangajiController::class, 'postingperhitungan']);
    Route::get('hapusperhitungan/{id}', [\App\Http\Controllers\Admin\InqueryPerhitungangajiController::class, 'hapusperhitungan'])->name('hapusperhitungan');
    Route::get('inquery_perhitungangajibulanan/unpostperhitunganbulanan/{id}', [\App\Http\Controllers\Admin\InqueryPerhitungangajibulananController::class, 'unpostperhitunganbulanan']);
    Route::get('inquery_perhitungangajibulanan/postingperhitunganbulanan/{id}', [\App\Http\Controllers\Admin\InqueryPerhitungangajibulananController::class, 'postingperhitunganbulanan']);
    Route::get('hapusperhitunganbulanan/{id}', [\App\Http\Controllers\Admin\InqueryPerhitungangajibulananController::class, 'hapusperhitunganbulanan'])->name('hapusperhitunganbulanan');
    Route::get('kasbon_karyawan/cetak-pdf/{id}', [\App\Http\Controllers\Admin\KasbonkaryawanController::class, 'cetakpdf']);
    Route::get('inquery_kasbonkaryawan/unpostkasbon/{id}', [\App\Http\Controllers\Admin\InqueryKasbonkaryawanController::class, 'unpostkasbon']);
    Route::get('inquery_kasbonkaryawan/postingkasbon/{id}', [\App\Http\Controllers\Admin\InqueryKasbonkaryawanController::class, 'postingkasbon']);
    Route::delete('inquery_kasbonkaryawan/deletedetailcicilan/{id}', [\App\Http\Controllers\Admin\InqueryKasbonkaryawanController::class, 'deletedetailcicilan']);
    Route::get('hapuskasbon/{id}', [\App\Http\Controllers\Admin\InqueryKasbonkaryawanController::class, 'hapuskasbon'])->name('hapuskasbon');
    Route::delete('inquery_pembelian/deletebarangs/{id}', [\App\Http\Controllers\Admin\InqueryPembelianController::class, 'deletebarangs']);

    Route::get('inquery_pengeluarankaskecil/unpostpengeluaran/{id}', [\App\Http\Controllers\Admin\InqueryPengeluarankaskecilController::class, 'unpostpengeluaran']);
    Route::get('inquery_pengeluarankaskecil/postingpengeluaran/{id}', [\App\Http\Controllers\Admin\InqueryPengeluarankaskecilController::class, 'postingpengeluaran']);
    Route::get('laporan_pengeluarankaskecil', [\App\Http\Controllers\Admin\LaporanPengeluarankaskecilController::class, 'index']);
    Route::get('print_pengeluarankaskecil', [\App\Http\Controllers\Admin\LaporanPengeluarankaskecilController::class, 'print_pengeluarankaskecil']);
    Route::get('laporan_pengeluarankaskecilakun', [\App\Http\Controllers\Admin\LaporanPengeluarankaskecilakunController::class, 'index']);
    Route::get('print_pengeluarankaskecilakun', [\App\Http\Controllers\Admin\LaporanPengeluarankaskecilakunController::class, 'print_pengeluarankaskecilakun']);
    Route::get('unpostpengeluaran/{id}', [\App\Http\Controllers\Admin\InqueryPengeluarankaskecilController::class, 'unpostpengeluaran'])->name('unpostpengeluaran');
    Route::get('postingpengeluaran/{id}', [\App\Http\Controllers\Admin\InqueryPengeluarankaskecilController::class, 'postingpengeluaran'])->name('postingpengeluaran');
    Route::get('hapuspengeluaran/{id}', [\App\Http\Controllers\Admin\InqueryPengeluarankaskecilController::class, 'hapuspengeluaran'])->name('hapuspengeluaran');
    Route::get('pengeluaran_kaskecil/cetak-pdf/{id}', [\App\Http\Controllers\Admin\PengeluarankaskecilController::class, 'cetakpdf']);
    Route::delete('inquery_pengeluarankaskecil/deletedetailpengeluaran/{id}', [\App\Http\Controllers\Admin\InqueryPengeluarankaskecilController::class, 'deletedetailpengeluaran']);
    Route::get('postingpengeluaranfilter', [\App\Http\Controllers\Admin\InqueryPengeluarankaskecilController::class, 'postingpengeluaranfilter']);
    Route::get('unpostpengeluaranfilter', [\App\Http\Controllers\Admin\InqueryPengeluarankaskecilController::class, 'unpostpengeluaranfilter']);
    // Route::get('cetak_pengeluaranfilter', [\App\Http\Controllers\Admin\InqueryMemoekspedisiController::class, 'cetak_pengeluaranfilter']);
    Route::get('laporan_saldokas', [\App\Http\Controllers\Admin\LaporanSaldokasController::class, 'index']);
    Route::get('print_saldokas', [\App\Http\Controllers\Admin\LaporanSaldokasController::class, 'print_saldokas']);
    Route::get('laporan_penerimaankaskecil', [\App\Http\Controllers\Admin\LaporanPenerimaankaskecilController::class, 'index']);
    Route::get('print_penerimaankaskecil', [\App\Http\Controllers\Admin\LaporanPenerimaankaskecilController::class, 'print_penerimaankaskecil']);
    Route::resource('laporan_kasbonkaryawan', \App\Http\Controllers\Admin\LaporanKasbonkaryawanController::class);
    Route::get('print_kasbonkaryawan', [\App\Http\Controllers\Admin\LaporanKasbonkaryawanController::class, 'print_kasbonkaryawan']);

    Route::get('laporan_perhitungangaji', [\App\Http\Controllers\Admin\LaporanPerhitungangajiController::class, 'index']);
    Route::get('print_perhitungangaji', [\App\Http\Controllers\Admin\LaporanPerhitungangajiController::class, 'print_perhitungangaji']);
    Route::get('laporan_perhitungangajibulanan', [\App\Http\Controllers\Admin\LaporanPerhitungangajibulananController::class, 'index']);
    Route::get('print_perhitungangajibulanan', [\App\Http\Controllers\Admin\LaporanPerhitungangajibulananController::class, 'print_perhitungangajibulanan']);


    Route::resource('laporan_suratpenawaran', \App\Http\Controllers\Admin\LaporansuratpenawaranController::class);
    Route::get('print_laporansuratpenawaran', [\App\Http\Controllers\Admin\LaporansuratpenawaranController::class, 'print_laporansuratpenawaran']);

    Route::resource('laporan_penerimaanpembayaran', \App\Http\Controllers\Admin\LaporanpenerimaanpembayaranController::class);
    Route::get('print_laporanpenerimaanpembayaran', [\App\Http\Controllers\Admin\LaporanpenerimaanpembayaranController::class, 'print_laporanpenerimaanpembayaran']);

    Route::get('print_laporanperintahkerja', [\App\Http\Controllers\Admin\LaporanperintahkerjaController::class, 'print_laporanperintahkerja']);
    Route::get('invoice_suratpesanannonpp', [\App\Http\Controllers\Admin\InvoicesuratpesananController::class, 'createnonppn']);

    
    Route::resource('laporan_perhitunganbahan', \App\Http\Controllers\Admin\LaporanPerhitunganbahanbakuController::class);
    Route::get('print_laporanperhitunganbahan', [\App\Http\Controllers\Admin\LaporanPerhitunganbahanbakuController::class, 'print_laporanperhitunganbahan']);
    
    Route::resource('laporan_perintahkerja', \App\Http\Controllers\Admin\LaporanperintahkerjaController::class);
    Route::get('print_laporanperintahkerja', [\App\Http\Controllers\Admin\LaporanperintahkerjaController::class, 'print_laporanperintahkerja']);
    
    Route::resource('laporan_dokumenproject', \App\Http\Controllers\Admin\LaporanDokumenprojectController::class);
    Route::get('print_laporandokumenproject', [\App\Http\Controllers\Admin\LaporanDokumenprojectController::class, 'print_laporandokumenproject']);
    
    Route::get('cetak_pengambilanfilter', [\App\Http\Controllers\Admin\PengambilanbahanController::class, 'cetak_pengambilanfilter']);
    Route::get('invoice_suratpesanan/get_suratpesanan/{id}', [\App\Http\Controllers\Admin\InvoicesuratpesananController::class, 'get_suratpesanan']);
    Route::get('penerimaan_kaskecil/cetak-pdf/{id}', [\App\Http\Controllers\Admin\PenerimaankaskecilController::class, 'cetakpdf']);
    
    Route::resource('pilih_laporankaskecil', \App\Http\Controllers\Admin\PilihLaporankaskecilController::class);
    Route::resource('laporan_perintahkerja', \App\Http\Controllers\Admin\LaporanperintahkerjaController::class);
    Route::resource('tablepengeluaran', \App\Http\Controllers\Admin\TablepengeluaranController::class);
    Route::resource('inquery_penerimaankaskecil', \App\Http\Controllers\Admin\InqueryPenerimaankaskecilController::class);
    Route::resource('penerimaan_kaskecil', \App\Http\Controllers\Admin\PenerimaankaskecilController::class);
    Route::resource('pelunasan_penjualan', \App\Http\Controllers\Admin\PelunasanController::class);
    Route::resource('spk', \App\Http\Controllers\Admin\SpkController::class);
    Route::resource('surat_penawaran', \App\Http\Controllers\Admin\SuratPenawaranController::class);
    Route::resource('penjualan', \App\Http\Controllers\Admin\PenjualanController::class);
    Route::resource('karyawan', \App\Http\Controllers\Admin\KaryawanController::class);
    Route::resource('user', \App\Http\Controllers\Admin\UserController::class);
    Route::resource('departemen', \App\Http\Controllers\Admin\DepartemenController::class);
    Route::resource('akses', \App\Http\Controllers\Admin\AksesController::class);
    Route::resource('merek', \App\Http\Controllers\Admin\MerekController::class);
    Route::resource('modelken', \App\Http\Controllers\Admin\ModelkenController::class);
    Route::resource('tipe', \App\Http\Controllers\Admin\TipeController::class);
    Route::resource('kendaraan', \App\Http\Controllers\Admin\KendaraanController::class);
    Route::resource('pelanggan', \App\Http\Controllers\Admin\PelangganController::class);
    Route::resource('inquery_penjualan', \App\Http\Controllers\Admin\InqueryPenjualanController::class);
    Route::resource('inquery_deposit', \App\Http\Controllers\Admin\InqueryDepositController::class);
    Route::resource('inquery_spk', \App\Http\Controllers\Admin\InquerySpkController::class);
    Route::resource('inquery_penawaran', \App\Http\Controllers\Admin\InquerySuratpenawaranController::class);
    Route::resource('barang', \App\Http\Controllers\Admin\BarangController::class);
    Route::resource('barangnonbesi', \App\Http\Controllers\Admin\BarangnonbesiController::class);
    Route::resource('typekaroseri', \App\Http\Controllers\Admin\TypekaroseriController::class);
    Route::resource('deposit_pemesanan', \App\Http\Controllers\Admin\DepositpemesananController::class);
    Route::resource('pembelian', \App\Http\Controllers\Admin\PembelianController::class);
    Route::resource('popembelian', \App\Http\Controllers\Admin\PopembelianController::class);
    Route::resource('pengambilanbahan', \App\Http\Controllers\Admin\PengambilanbahanController::class);
    Route::resource('inquery_pembelian', \App\Http\Controllers\Admin\InqueryPembelianController::class);
    Route::resource('inquery_pembelianreturn', \App\Http\Controllers\Admin\InqueryReturnpembelianController::class);
    Route::resource('inquery_popembelian', \App\Http\Controllers\Admin\InqueryPopembelianController::class);
    Route::resource('inquery_pelunasan', \App\Http\Controllers\Admin\InqueryPelunasanController::class);
    Route::resource('inquery_pengambilanbahan', \App\Http\Controllers\Admin\InqueryPengambilanbahanController::class);
    Route::resource('pelunasan_pembelian', \App\Http\Controllers\Admin\PelunasanpembelianController::class);
    Route::resource('faktur_pelunasanpembelian', \App\Http\Controllers\Admin\PelunasanpembelianController::class);
    Route::resource('inquery_fakturpelunasanpembelian', \App\Http\Controllers\Admin\InqueryFakturpelunasanpembelianController::class);
    Route::resource('perhitungan_gaji', \App\Http\Controllers\Admin\PerhitungangajiController::class);
    Route::resource('perhitungan_gajibulanan', \App\Http\Controllers\Admin\PerhitungangajibulananController::class);
    Route::resource('kasbon_karyawan', \App\Http\Controllers\Admin\KasbonkaryawanController::class);
    Route::resource('inquery_kasbonkaryawan', \App\Http\Controllers\Admin\InqueryKasbonkaryawanController::class);
    Route::resource('inquery_perhitungangaji', \App\Http\Controllers\Admin\InqueryPerhitungangajiController::class);
    Route::resource('inquery_perhitungangajibulanan', \App\Http\Controllers\Admin\InqueryPerhitungangajibulananController::class);
    Route::resource('pengeluaran_kaskecil', \App\Http\Controllers\Admin\PengeluarankaskecilController::class);
    Route::resource('inquery_pengeluarankaskecil', \App\Http\Controllers\Admin\InqueryPengeluarankaskecilController::class);
    Route::resource('akun', \App\Http\Controllers\Admin\BarangakunController::class);
    Route::resource('gaji_karyawan', \App\Http\Controllers\Admin\GajikaryawanController::class);
    Route::resource('return_pembelian', \App\Http\Controllers\Admin\ReturnpembelianController::class);
    Route::resource('penerimaan_pembayaran', \App\Http\Controllers\Admin\PenerimaanpembayaranController::class);
    Route::resource('inquery_penerimaanpembayaran', \App\Http\Controllers\Admin\InquerypenerimaanpembayaranController::class);
    Route::resource('perintah_kerja', \App\Http\Controllers\Admin\PerintahkerjaController::class);
    Route::resource('inquery_perintahkerja', \App\Http\Controllers\Admin\InqueryperintahkerjaController::class);
    Route::resource('perhitungan_bahanbaku', \App\Http\Controllers\Admin\PerhitunganbahanbakuController::class);
    Route::resource('inquery_perhitunganbahanbaku', \App\Http\Controllers\Admin\InqueryPerhitunganbahanbakuController::class);
    Route::resource('dokumen_project', \App\Http\Controllers\Admin\DokumenprojectController::class);
    Route::resource('inquery_dokumenproject', \App\Http\Controllers\Admin\InqueryDokumenprojectController::class);
    Route::resource('invoice_suratpesanan', \App\Http\Controllers\Admin\InvoicesuratpesananController::class);
    Route::resource('inquery_invoicesuratpesanan', \App\Http\Controllers\Admin\InqueryinvoicesuratpesananController::class);
    Route::resource('list_dokument', \App\Http\Controllers\Admin\ListdokumentController::class);
    Route::resource('kategori_produk', \App\Http\Controllers\Admin\KategoriprodukController::class);

});