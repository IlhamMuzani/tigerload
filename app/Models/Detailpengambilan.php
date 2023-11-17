<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Detailpengambilan extends Model
{
    use HasFactory;

    protected $fillable = [
        'barang_id',
        'pengambilanbahan_id',
        'kode_barang',
        'nama_barang',
        'jumlah',
        'tanggal_awal',
        'tanggal_akhir',
    ];
    
    public function pengambilan_bahan()
    {
        return $this->belongsTo(Pengambilanbahan::class);
    }

}