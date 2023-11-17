<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Marketing extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_marketing',
        'nama_marketing',
        'qrcode_marketing',
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

    public function komisi()
    {
        return $this->hasMany(Komisi::class);
    }

    public static function getId()
    {
        return $getId = DB::table('marketings')->orderBy('id', 'DESC')->take(1)->get();
    }
}