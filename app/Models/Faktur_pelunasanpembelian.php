<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Faktur_pelunasanpembelian extends Model
{
    use HasFactory;

    protected $fillable =
    [
        'user_id',
        'kode_pelunasan',
        'qrcode_pelunasan',
        'supplier_id',
        'kode_supplier',
        'nama_supplier',
        'alamat_supplier',
        'telp_supplier',
        'keterangan',
        'potongan',
        'tambahan_pembayaran',
        'kategori',
        'nomor',
        'tanggal_transfer',
        'nominal',
        'keterangan',
        'potonganselisih',
        'totalpenjualan',
        'dp',
        'totalpembayaran',
        'selisih',
        'tanggal',
        'tanggal_awal',
        'tanggal_akhir',
        'status',
        'status_notif',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function getId()
    {
        return $getId = DB::table('faktur_pelunasanpembelians')->orderBy('id', 'DESC')->take(1)->get();
    }

    public function detail_pelunasanbans()
    {
        return $this->hasMany(Detail_pelunasanpembelian::class);
    }
}