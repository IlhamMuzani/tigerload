<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Merek extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'kode_merek',
        'modelken_id',
        'tipe_id',
        'nama_merek',
        'qrcode_merek',
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
    
    public function modelken()
    {
        return $this->belongsTo(Modelken::class);
    }


    public function tipe()
    {
        return $this->belongsTo(Tipe::class);
    }


    public static function getId()
    {
        return $getId = DB::table('mereks')->orderBy('id', 'DESC')->take(1)->get();
    }
}