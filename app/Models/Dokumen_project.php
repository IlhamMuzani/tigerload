<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dokumen_project extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable =
    [
        'kode_dokumen',
        'qrcode_dokumen',
        'user_id',
        'perintah_kerja_id',
        'typekaroseri_id',
        'pelanggan_id',
        'keterangan',
        'no_rangka',
        'no_mesin',
        'tahun',
        'warna',
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
        'gambar_depan',
        'gambar_belakang',
        'gambar_kanan',
        'gambar_kiri',
        'gambardepan_serongkanan',
        'gambardepan_serongkiri',
        'gambarbelakang_serongkanan',
        'gambarberita_acara',
        'gambarbelakang_serongkekiri',
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

    public function perintah_kerja()
    {
        return $this->belongsTo(Perintah_kerja::class);
    }

    public function typekaroseri()
    {
        return $this->belongsTo(Typekaroseri::class);
    }

    public static function getId()
    {
        return $getId = DB::table('dokumen_projects')->orderBy('id', 'DESC')->take(1)->get();
    }
}