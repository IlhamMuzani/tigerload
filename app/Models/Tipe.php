<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Tipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_tipe',
        'nama_tipe',
        'qrcode_tipe',
        'tanggal_awal',
        'tanggal_akhir',
    ];

    public static function getId()
    {
        return $getId = DB::table('tipes')->orderBy('id', 'DESC')->take(1)->get();
    }
}