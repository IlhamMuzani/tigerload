<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Detailpengambilan extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'barang_id',
        'pengambilanbahan_id',
        'detail_barang',
        'jumlah_tiapbarang',
        'kode_barang',
        'nama_barang',
        'jumlah',
        'harga',
        'total',
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