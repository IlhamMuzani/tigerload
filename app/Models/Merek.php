<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Merek extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_merek',
        'modelken_id',
        'tipe_id',
        'nama_merek',
        'qrcode_merek',
        'tanggal_awal',
        'tanggal_akhir',
    ];

    public function modelken()
    {
        return $this->belongsTo(Modelken::class);
    }


    public function tipe()
    {
        return $this->belongsTo(Tipe::class);
    }


    public static function getId()
    {
        return $getId = DB::table('mereks')->orderBy('id', 'DESC')->take(1)->get();
    }
}