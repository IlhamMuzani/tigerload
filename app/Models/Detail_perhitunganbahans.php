<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Detail_perhitunganbahans extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'kode_pengambilan',
        'pengambilanbahan_id',
        'detail_barang',
        'tanggal',
        'harga',
        'jumlah',
        'harga',
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
    
    public function pengambilan_bahan()
    {
        return $this->belongsTo(Pengambilanbahan::class);
    }

}