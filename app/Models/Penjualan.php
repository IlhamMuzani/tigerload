<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Penjualan extends Model
{
    protected $fillable =
    [
        'kode_penjualan',
        'qrcode_penjualan',
        'depositpemesanan_id',
        'spesifikasi_id',
        'status',
        'status_pelunasan',
        'tanggal',
        'tanggal_awal',
        'tanggal_akhir',
    ];

    public function depositpemesanan()
    {
        return $this->belongsTo(Depositpemesanan::class);
    }

    public function detail_penjualan()
    {
        return $this->hasMany(Spesifikasi::class);
    }

    public function pelunasan()
    {
        return $this->hasMany(Pelunasan::class);
    }

    public static function getId()
    {
        return $getId = DB::table('penjualans')->orderBy('id', 'DESC')->take(1)->get();
    }
}