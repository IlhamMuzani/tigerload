<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Spesifikasi extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'typekaroseri_id',
        'penjualan_id',
        'barang_id',
        'kode_barang',
        'nama',
        'jumlah',
        'harga',
    ];

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable('*');
    }

    public function typekaroseri()
    {
        return $this->belongsTo(Typekaroseri::class);
    }
    
    public static function getId()
    {
        return $getId = DB::table('spesifikasis')->orderBy('id', 'DESC')->take(1)->get();
    }
}