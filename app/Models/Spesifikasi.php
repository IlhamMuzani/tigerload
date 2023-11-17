<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Spesifikasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'typekaroseri_id',
        'penjualan_id',
        'barang_id',
        'nama',
        'jumlah',
        'harga',
    ];

    public function typekaroseri()
    {
        return $this->belongsTo(Typekaroseri::class);
    }
    
    public static function getId()
    {
        return $getId = DB::table('spesifikasis')->orderBy('id', 'DESC')->take(1)->get();
    }
}