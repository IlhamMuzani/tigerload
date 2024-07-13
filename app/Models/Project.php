<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory;
    use LogsActivity;
    
    protected $fillable =
    [
        'kode_project',
        'qrcode_project',
        'perintah_kerja_id',
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

    public static function getId()
    {
        return $getId = DB::table('projects')->orderBy('id', 'DESC')->take(1)->get();
    }
}