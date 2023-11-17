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


Route::get('golongan/{kode}', [\App\Http\Controllers\GolonganController::class, 'detail']);
Route::get('nokir/{kode}', [\App\Http\Controllers\NokirController::class, 'detail']);
Route::get('karyawan/{kode}', [\App\Http\Controllers\KaryawanController::class, 'detail']);
Route::get('kendaraan/{kode}', [\App\Http\Controllers\KendaraanController::class, 'detail']);
Route::get('ban/{kode}', [\App\Http\Controllers\BanController::class, 'detail']);
Route::get('supplier/{kode}', [\App\Http\Controllers\SupplierController::class, 'detail']);
Route::get('pelanggan/{kode}', [\App\Http\Controllers\PelangganController::class, 'detail']);
Route::get('stnk/{kode}', [\App\Http\Controllers\StnkController::class, 'detail']);


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
    Route::get('pelunasan/cetak-pdf/{id}', [\App\Http\Controllers\Admin\PelunasanController::class, 'cetakpdf']);
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
    Route::get('deposit_pemesanan/cetak-pdf/{id}', [\App\Http\Controllers\Admin\DepositpemesananController::class, 'cetakpdf']);
    Route::resource('sparepart', \App\Http\Controllers\Admin\SparepartController::class);
    Route::get('unpost/{id}', [\App\Http\Controllers\Admin\InquerySpkController::class, 'unpost'])->name('unpost');
    Route::get('posting/{id}', [\App\Http\Controllers\Admin\InquerySpkController::class, 'posting'])->name('posting');
    Route::get('unpostdeposit/{id}', [\App\Http\Controllers\Admin\InqueryDepositController::class, 'unpostdeposit'])->name('unpostdeposit');
    Route::get('postingdeposit/{id}', [\App\Http\Controllers\Admin\InqueryDepositController::class, 'postingdeposit'])->name('postingdeposit');
    Route::get('print_laporanspk', [\App\Http\Controllers\Admin\LaporanSpkController::class, 'print_laporanspk']);
    Route::get('laporan_spk', [\App\Http\Controllers\Admin\LaporanSpkController::class, 'index']);
    Route::get('pembelian/supplier/{id}', [\App\Http\Controllers\Admin\PembelianController::class, 'supplier']);
    Route::get('inquery_pembelian', [\App\Http\Controllers\Admin\InqueryPembelianController::class, 'index']);
    Route::get('inquery_pelunasan', [\App\Http\Controllers\Admin\InqueryPelunasanController::class, 'index']);

    Route::get('laporan_deposit', [\App\Http\Controllers\Admin\LaporanDepositController::class, 'index']);
    Route::get('laporan_pelunasan', [\App\Http\Controllers\Admin\LaporanPelunasanController::class, 'index']);
    Route::get('print_laporandeposit', [\App\Http\Controllers\Admin\LaporanDepositController::class, 'print_laporandeposit']);
    Route::get('print_laporanpelunasan', [\App\Http\Controllers\Admin\LaporanPelunasanController::class, 'print_laporanpelunasan']);

    Route::get('unpostbarang/{id}', [\App\Http\Controllers\Admin\InqueryPembelianController::class, 'unpostbarang'])->name('unpostbarang');
    Route::get('postingbarang/{id}', [\App\Http\Controllers\Admin\InqueryPembelianController::class, 'postingbarang'])->name('postingbarang');
    Route::get('pembelian/cetak-pdf/{id}', [\App\Http\Controllers\Admin\PembelianController::class, 'cetakpdf']);

    Route::get('unpostpengambilan/{id}', [\App\Http\Controllers\Admin\InqueryPengambilanbahanController::class, 'unpostpengambilan'])->name('unpostpengambilan');
    Route::get('postingpengambilan/{id}', [\App\Http\Controllers\Admin\InqueryPengambilanbahanController::class, 'postingpengambilan'])->name('postingpengambilan');
    Route::get('pengambilanbahan/cetak-pdf/{id}', [\App\Http\Controllers\Admin\PengambilanbahanController::class, 'cetakpdf']);
    Route::get('inquery_pengambilan', [\App\Http\Controllers\Admin\InqueryPengambilanbahanController::class, 'index']);

    Route::get('inquery_popembelian', [\App\Http\Controllers\Admin\InqueryPopembelianController::class, 'index']);
    Route::get('unpostbarangpo/{id}', [\App\Http\Controllers\Admin\InqueryPopembelianController::class, 'unpostbarangpo'])->name('unpostbarangpo');
    Route::get('postingbarangpo/{id}', [\App\Http\Controllers\Admin\InqueryPopembelianController::class, 'postingbarangpo'])->name('postingbarangpo');
    Route::get('popembelian/cetak-pdf/{id}', [\App\Http\Controllers\Admin\PopembelianController::class, 'cetakpdf']);

    Route::get('unpostpelunasan/{id}', [\App\Http\Controllers\Admin\InqueryPelunasanController::class, 'unpostpelunasan'])->name('unpostpelunasan');
    Route::get('postingpelunasan/{id}', [\App\Http\Controllers\Admin\InqueryPelunasanController::class, 'postingpelunasan'])->name('postingpelunasan');

    Route::get('laporan_pembelian', [\App\Http\Controllers\Admin\LaporanPembelianController::class, 'index']);
    Route::get('laporan_popembelian', [\App\Http\Controllers\Admin\LaporanPopembelianController::class, 'index']);
    Route::get('laporan_pengambilanbahan', [\App\Http\Controllers\Admin\LaporanPengambilanbahanController::class, 'index']);

    Route::get('print_laporanpopembelian', [\App\Http\Controllers\Admin\LaporanPopembelianController::class, 'print_laporanpopembelian']);
    Route::get('print_laporanpembelian', [\App\Http\Controllers\Admin\LaporanPembelianController::class, 'print_laporanpembelian']);
    Route::get('print_laporanpengambilanbahan', [\App\Http\Controllers\Admin\LaporanPengambilanbahanController::class, 'print_laporanpengambilanbahan']);

    Route::resource('pelunasan', \App\Http\Controllers\Admin\PelunasanController::class);
    Route::resource('spk', \App\Http\Controllers\Admin\SpkController::class);
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
    Route::resource('barang', \App\Http\Controllers\Admin\BarangController::class);
    Route::resource('typekaroseri', \App\Http\Controllers\Admin\TypekaroseriController::class);
    Route::resource('deposit_pemesanan', \App\Http\Controllers\Admin\DepositpemesananController::class);
    Route::resource('pembelian', \App\Http\Controllers\Admin\PembelianController::class);
    Route::resource('popembelian', \App\Http\Controllers\Admin\PopembelianController::class);
    Route::resource('pengambilanbahan', \App\Http\Controllers\Admin\PengambilanbahanController::class);
    Route::resource('inquery_pembelian', \App\Http\Controllers\Admin\InqueryPembelianController::class);
    Route::resource('inquery_popembelian', \App\Http\Controllers\Admin\InqueryPopembelianController::class);
    Route::resource('inquery_pelunasan', \App\Http\Controllers\Admin\InqueryPelunasanController::class);
    Route::resource('inquery_pengambilanbahan', \App\Http\Controllers\Admin\InqueryPengambilanbahanController::class);

});