<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Penerimaan_pembayaran extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable =
    [
        'kode_penerimaan',
        'kode_qrcode',
        'qrcode_penerimaan',
        'user_id',
        'pelanggan_id',
        'surat_penawaran_id',
        'typekaroseri_id',
        'kategoris',
        'nominal',
        'keterangan',
        'tanggal_pembayaran',
        'tanggal',
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function typekaroseri()
    {
        return $this->belongsTo(Typekaroseri::class);
    }

    public function surat_penawaran()
    {
        return $this->belongsTo(Surat_penawaran::class);
    }

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }

    public static function getId()
    {
        return $getId = DB::table('penerimaan_pembayaran')->orderBy('id', 'DESC')->take(1)->get();
    }
}