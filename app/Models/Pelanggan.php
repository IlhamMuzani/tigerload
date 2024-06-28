<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pelanggan extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'kode_pelanggan',
        'nama_pelanggan',
        'qrcode_pelanggan',
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
    
    public function penjualan()
    {
        return $this->hasMany(Penjualan::class);
    }

    public function penerimaan_pembayaran()
    {
        return $this->hasMany(Penerimaan_pembayaran::class);
    }


    public static function getId()
    {
        return $getId = DB::table('pelanggans')->orderBy('id', 'DESC')->take(1)->get();
    }
}