<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Detailperintah extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'barang_id',
        'perintah_kerja_id',
        'kode_barang',
        'nama_barang',
        'jumlah',
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
    
    public function perintah_kerja()
    {
        return $this->belongsTo(Perintah_kerja::class);
    }

}