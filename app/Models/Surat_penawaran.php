<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Surat_penawaran extends Model
{
    use HasFactory;
    use LogsActivity;
    protected $fillable =
    [
        'kode_spk',
        'kategori',
        'no_npwp',
        'gambar_npwp',
        'pelanggan_id',
        'nama_pelanggan',
        'kode_pelanggan',
        'alamat',
        'telp',
        'merek_id',
        'nama_merek',
        'tipe',
        'typekaroseri_id',
        'kode_type',
        'nama_karoseri',
        'panjang',
        'lebar',
        'tinggi',
        'spesifikasi',
        'aksesoris',
        'jumlah_unit',
        'harga',
        'qrcode_penawaran',
        'tanggal',
        'tanggal_awal',
        'status',
        'status_komisi',
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

    public function detail_suratpenawaran()
    {
        return $this->hasMany(Detail_suratpenawaran::class);
    }

    public function typekaroseri()
    {
        return $this->belongsTo(Typekaroseri::class);
    }

    public function detail_deposit()
    {
        return $this->hasMany(Depositpemesanan::class);
    }

    public static function getId()
    {
        return $getId = DB::table('surat_penawarans')->orderBy('id', 'DESC')->take(1)->get();
    }
}