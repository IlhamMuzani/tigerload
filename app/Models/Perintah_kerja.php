<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Perintah_kerja extends Model
{
    use HasFactory;
    use LogsActivity;
    protected $fillable =
    [
        'kode_perintah',
        'qrcode_perintah',
        'user_id',
        'pelanggan_id',
        'spk_id',
        'typekaroseri_id',
        'keterangan',
        'tanggal',
        'tanggal_awal',
        'tanggal_akhir',
        'status',
        'status_penjualan',
        'status_deposit',
        'status_dokumen',
    ];

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable('*');
    }

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function typekaroseri()
    {
        return $this->belongsTo(Typekaroseri::class);
    }

    public function spk()
    {
        return $this->belongsTo(Spk::class);
    }

    public function surat_pesanan()
    {
        return $this->belongsTo(Spk::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pengambilanbahan()
    {
        return $this->hasMany(Pengambilanbahan::class);
    }

    public function depositpemesanan()
    {
        return $this->hasMany(Depositpemesanan::class);
    }

    public function perhitunganbahanbaku()
    {
        return $this->hasMany(Perhitunganbahanbaku::class);
    }

    public function dokumen_project()
    {
        return $this->hasMany(Dokumen_project::class);
    }


    public static function getId()
    {
        return $getId = DB::table('perintah_kerjas')->orderBy('id', 'DESC')->take(1)->get();
    }
}