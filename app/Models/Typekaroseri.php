<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Typekaroseri extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_type',
        'qrcode_karoseri',
        'nama_karoseri',
        'type_kendaraan',
        'panjang',
        'lebar',
        'tinggi',
        'aksesoris',
        'tanggal_awal',
        'tanggal_akhir',
    ];

    public function spesifikasi()
    {
        return $this->hasMany(Spesifikasi::class);
    }

    public static function getId()
    {
        return $getId = DB::table('typekaroseris')->orderBy('id', 'DESC')->take(1)->get();
    }
}
