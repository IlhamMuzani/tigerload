<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Detailpopembelian extends Model
{
    use HasFactory;

    protected $fillable = [
        'popembelian_id',
        'barang_id',
        'kode_barang',
        'nama_barang',
        'jumlah',
        'satuan',
        'harga',
        'total',
        'tanggal_awal',
        'tanggal_akhir',
    ];
    
    public function Popembelian()
    {
        return $this->belongsTo(Popembelian::class);
    }


}