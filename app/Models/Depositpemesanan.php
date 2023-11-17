<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Depositpemesanan extends Model
{
    protected $fillable =
    [
        'kode_deposit',
        'qrcode_deposit',
        'spk_id',
        'harga',
        'tanggal',
        'tanggal_awal',
        'tanggal_akhir',
        'status',
    ];

    public function spk()
    {
        return $this->belongsTo(Spk::class);
    }

    public function detail_penjualan()
    {
        return $this->hasMany(Penjualan::class);
    }

    public static function getId()
    {
        return $getId = DB::table('depositpemesanans')->orderBy('id', 'DESC')->take(1)->get();
    }
}