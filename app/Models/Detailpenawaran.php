<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Detailpenawaran extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable =
    [
        'surat_penawaran_id',
        'status',
        'tanggal_awal',
        'status_cicilan',
    ];

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable('*');
    }

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }
    
    public static function getId()
    {
        return $getId = DB::table('detailpenawarans')->orderBy('id', 'DESC')->take(1)->get();
    }
}