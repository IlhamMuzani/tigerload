<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Komisi extends Model
{
    use HasFactory;
    use LogsActivity;
    protected $fillable =
    [
        'kode_komisi',
        'kode_faktur',
        'qrcode_komisi',
        'kategori',
        'harga',
        'fee',
        'pembelian_id',
        'penjualan_id',
        'pelanggan_id',
        'kendaraan_id',
        'marketing_id',
        'status',
        'tanggal',
        'tanggal_awal',
        'tanggal_akhir',
    ];

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable('*');
    }

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function marketing()
    {
        return $this->belongsTo(Marketing::class);
    }
    
    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class);
    }

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class);
    }

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class);
    }

    public function detail_kendaraan()
    {
        return $this->hasMany(Kendaraan::class);
    }

    public static function getId()
    {
        return $getId = DB::table('komisis')->orderBy('id', 'DESC')->take(1)->get();
    }
}