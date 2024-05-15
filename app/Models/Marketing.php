<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Marketing extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'kode_marketing',
        'nama_marketing',
        'qrcode_marketing',
        'nama_alias',
        'alamat',
        'telp',
        'gender',
        'Laki-laki',
        'umur',
        'nama_alias',
        'email',
        'ig',
        'fb',
        'gambar_ktp',
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
    
    public function komisi()
    {
        return $this->hasMany(Komisi::class);
    }

    public static function getId()
    {
        return $getId = DB::table('marketings')->orderBy('id', 'DESC')->take(1)->get();
    }
}