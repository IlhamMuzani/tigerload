<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Pelunasan extends Model
{
    protected $fillable =
    [
        'kode_pelunasan',
        'qrcode_pelunasan',
        'penjualan_id',
        'potongan',
        'kategori',
        'nomor',
        'tanggal_transfer',
        'nominal',
        'totalpenjualan',
        'dp',
        'totalpembayaran',
        'selisih',
        'status_pelunasan',
        'status',
        'tanggal',
        'tanggal_awal',
        'tanggal_akhir',
    ];

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class);
    }

    public static function getId()
    {
        return $getId = DB::table('pelunasans')->orderBy('id', 'DESC')->take(1)->get();
    }
}