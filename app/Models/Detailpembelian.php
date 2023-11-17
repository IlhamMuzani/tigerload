<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Detailpembelian extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_barang',
        'pembelian_id',
        'barang_id',
        'qrcode_barang',
        'nama_barang',
        'jumlah',
        'satuan',
        'harga',
        'spesifikasi',
        'keterangan',
        'tanggal_awal',
        'tanggal_akhir',
    ];
    
    public function pembelian_part()
    {
        return $this->belongsTo(Pembelian_part::class);
    }

    public function detail_part()
    {
        return $this->hasMany(Detail_pemasanganpartdua::class);
    }


}