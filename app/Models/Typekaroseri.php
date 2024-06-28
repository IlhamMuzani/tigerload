<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Typekaroseri extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'kode_type',
        'merek_id',
        'nama_merek',
        'tipe',
        'qrcode_karoseri',
        'nama_karoseri',
        'type_kendaraan',
        'panjang',
        'lebar',
        'tinggi',
        'aksesoris',
        'harga',
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
    
    public function spesifikasi()
    {
        return $this->hasMany(Spesifikasi::class);
    }

    public function merek()
    {
        return $this->belongsTo(Merek::class);
    }

    public function penerimaan_pembayaran()
    {
        return $this->hasMany(Penerimaan_pembayaran::class);
    }


    public static function getId()
    {
        return $getId = DB::table('typekaroseris')->orderBy('id', 'DESC')->take(1)->get();
    }
}