<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Detail_penjualan extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable =
    [
        'typekaroseri_id',
        'penjualan_id',
        // 'barang_id',
        'kode_types',
        'nama_karoseri',
        'jumlah',
        'harga',
        'diskon',
        'total',
        'keterangan',
    ];

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable('*');
    }

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }
    
    public static function getId()
    {
        return $getId = DB::table('detail_penjualans')->orderBy('id', 'DESC')->take(1)->get();
    }
}