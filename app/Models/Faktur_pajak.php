<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Faktur_pajak extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable =
    [
        'kode_pajak',
        'kode_qrcode',
        'qrcode_pajak',
        'kategori',
        'penjualan_id',
        'pembelian_id',
        'gambar_pajak',
        'tanggal',
        'tanggal_awal',
        'tanggal_akhir',
        'status_pajak',
        'status',
    ];

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable('*');
    }

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class);
    }

    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class);
    }

    public static function getId()
    {
        return $getId = DB::table('faktur_pajaks')->orderBy('id', 'DESC')->take(1)->get();
    }
}