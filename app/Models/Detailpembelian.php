<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Detailpembelian extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'kode_barang',
        'pembelian_id',
        'barang_id',
        'qrcode_barang',
        'nama_barang',
        'jumlah',
        // 'satuan',
        'satuan_id',
        'harga',
        'harga_jual',
        'diskon',
        'total',
        'spesifikasi',
        'keterangan',
        'tanggal_awal',
        'tanggal_akhir',
    ];

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable('*');
    }

    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class);
    }

    public function satuan()
    {
        return $this->belongsTo(Satuan::class);
    }


}