<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Penjualan extends Model
{
    use HasFactory;
    use LogsActivity;
    protected $fillable =
    [
        'kode_penjualan',
        'qrcode_penjualan',
        'spk_id',
        'depositpemesanan_id',
        'spesifikasi_id',
        'status',
        'status_pelunasan',
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

    public function depositpemesanan()
    {
        return $this->belongsTo(Depositpemesanan::class);
    }

    public function spk()
    {
        return $this->belongsTo(Spk::class);
    }


    public function detail_penjualan()
    {
        return $this->hasMany(Spesifikasi::class);
    }

    public function pelunasan()
    {
        return $this->hasMany(Pelunasan::class);
    }

    public static function getId()
    {
        return $getId = DB::table('penjualans')->orderBy('id', 'DESC')->take(1)->get();
    }
}
