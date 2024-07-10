<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kategori_produk extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'nama_kategori',
        'qrcode_kategori',
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

    public function typerkaroseri()
    {
        return $this->hasMany(Typekaroseri::class);
    }

    public static function getId()
    {
        return $getId = DB::table('kategori_produks')->orderBy('id', 'DESC')->take(1)->get();
    }

}