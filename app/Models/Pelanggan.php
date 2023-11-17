<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Pelanggan extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_pelanggan',
        'nama_pelanggan',
        'qrcode_pelanggan',
        'nama_alias',
        'alamat',
        'telp',
        'gender',
        'Laki-laki',
        'umur',
        'nama_alias',
        'email',
        'ig',
        'fb',
        'gambar_ktp',
        'tanggal_awal',
        'tanggal_akhir',
    ];

    public function penjualan()
    {
        return $this->hasMany(Penjualan::class);
    }

    public static function getId()
    {
        return $getId = DB::table('pelanggans')->orderBy('id', 'DESC')->take(1)->get();
    }
}