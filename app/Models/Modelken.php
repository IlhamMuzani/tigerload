<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Modelken extends Model
{
    use HasFactory;
    protected $fillable = [
        'kode_model',
        'nama_model',
        'qrcode_model',
        'tanggal_awal',
        'tanggal_akhir',
    ];

    public static function getId()
    {
        return $getId = DB::table('modelkens')->orderBy('id', 'DESC')->take(1)->get();
    }
}