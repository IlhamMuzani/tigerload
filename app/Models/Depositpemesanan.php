<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Depositpemesanan extends Model
{
    use HasFactory;
    use LogsActivity;
    
    protected $fillable =
    [
        'kode_deposit',
        'qrcode_deposit',
        'perintah_kerja_id',
        'harga',
        'tanggal',
        'tanggal_awal',
        'tanggal_akhir',
        'status',
    ];

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable('*');
    }
    
    public function spk()
    {
        return $this->belongsTo(Spk::class);
    }

    public function perintah_kerja()
    {
        return $this->belongsTo(Perintah_kerja::class);
    }

    public function detail_penjualan()
    {
        return $this->hasMany(Penjualan::class);
    }

    public static function getId()
    {
        return $getId = DB::table('depositpemesanans')->orderBy('id', 'DESC')->take(1)->get();
    }
}