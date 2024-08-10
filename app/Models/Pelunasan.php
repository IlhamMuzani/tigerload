<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pelunasan extends Model
{
    use HasFactory;
    use LogsActivity;
    protected $fillable =
    [
        'kode_pelunasan',
        'qrcode_pelunasan',
        'penjualan_id',
        'potongan',
        'kategori',
        'nomor',
        'tanggal_transfer',
        'nominal',
        'totalpenjualan',
        'biaya_tambahan',
        'dp',
        'totalpembayaran',
        'selisih',
        'status_pelunasan',
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
    
    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class);
    }

    public static function getId()
    {
        return $getId = DB::table('pelunasans')->orderBy('id', 'DESC')->take(1)->get();
    }
}