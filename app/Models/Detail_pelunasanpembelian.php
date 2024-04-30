<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Detail_pelunasanpembelian extends Model
{
    use HasFactory;

    protected $fillable = [
        'faktur_pelunasanpembelian_id',
        'pembelian_id',
        'kode_pembelian',
        'tanggal_pembelian',
        'status',
        'total',
        'tanggal_awal',
        'tanggal_akhir',
    ];
    

    public function faktur_pelunasanpembelian()
    {
        return $this->belongsTo(Faktur_pelunasanpembelian::class);
    }
    public function pembelian_ban()
    {
        return $this->belongsTo(Pembelian::class);
    }

}