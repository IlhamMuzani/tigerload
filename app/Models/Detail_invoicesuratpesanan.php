<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Detail_invoicesuratpesanan extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'invoice_suratpesanan_id',
        'spk_id',
        'kode_pesanan',
        'tanggal_pesanan',
        'merek',
        'tipemerek',
        'kode_karoseri',
        'nama_karoseri',
        'harga',
        'status',
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
    public function tagihan_ekspedisi()
    {
        return $this->belongsTo(Invoice_suratpesanan::class);
    }

    public function spk()
    {
        return $this->belongsTo(Spk::class);
    }
}