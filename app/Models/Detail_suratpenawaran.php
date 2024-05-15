<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Detail_suratpenawaran extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'surat_penawaran_id',
        'no_rangka',
        'no_mesin',
        'tahun',
        'warna',
        'qrcode_kendaraan',
        'kode_karoseri',
        'merek_id',
        'gambar_gesekannorangka',
        'gambar_gesekannomesin',
        'gambar_rancangbangun',
        'gambar_serut',
        'gambar_dokumen',
        'gambar_faktur',
        'gambar_depan',
        'gambar_belakang',
        'gambar_kanan',
        'gambar_kiri',
        'tanggal_awal',
        'tanggal_akhir',
        'status',
    ];

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable('*');
    }

    public function merek()
    {
        return $this->belongsTo(Merek::class);
    }

    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class);
    }

    public function surat_penawaran()
    {
        return $this->belongsTo(Surat_penawaran::class);
    }
    
    public static function getId()
    {
        return $getId = DB::table('detail_suratpenawarans')->orderBy('id', 'DESC')->take(1)->get();
    }
}