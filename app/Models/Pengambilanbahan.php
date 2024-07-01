<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;


class Pengambilanbahan extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable =
    [
        'user_id',
        'kode_pengambilan',
        'qrcode_pengambilan',
        'perintah_kerja_id',
        'tanggal',
        'tanggal_awal',
        'tanggal_akhir',
        'status',
        'status_notif',

    ];

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable('*');
    }
    
    public static function getId()
    {
        return $getId = DB::table('pengambilanbahans')->orderBy('id', 'DESC')->take(1)->get();
    }

    public function perintah_kerja()
    {
        return $this->belongsTo(Perintah_kerja::class);
    }
    
    public function detailpengambilan()
    {
        return $this->hasMany(Detailpengambilan::class);
    }
}