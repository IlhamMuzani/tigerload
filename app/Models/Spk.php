<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Spk extends Model
{
    protected $fillable =
    [
        'kategori',
        'no_npwp',
        'gambar_npwp',
        'kategori',
        'kode_spk',
        'qrcode_spk',
        'typekaroseri_id',
        'marketing_id',
        'pelanggan_id',
        'warna_dalam',
        'warna_luar',
        'aksesoris',
        'harga',
        'vi_marketing',
        'status',
        'status_komisi',
        'tanggal',
        'tanggal_awal',
        'tanggal_akhir',
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function detail_kendaraan()
    {
        return $this->hasMany(Kendaraan::class);
    }

    public function typekaroseri()
    {
        return $this->belongsTo(Typekaroseri::class);
    }

    public function detail_deposit()
    {
        return $this->hasMany(Depositpemesanan::class);
    }

    public static function getId()
    {
        return $getId = DB::table('spks')->orderBy('id', 'DESC')->take(1)->get();
    }
}