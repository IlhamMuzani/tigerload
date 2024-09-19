<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;


class Pembelian extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable =
    [
        'popembelian_id',
        'kode_pembelian',
        'qrcode_pembelian',
        'kategori',
        'supplier_id',
        'grand_total',
        'tanggal',
        'tanggal_awal',
        'tanggal_akhir',
        'status',
        'status_notif',

    ];

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable('*');
    }

    public static function getId()
    {
        return $getId = DB::table('pembelians')->orderBy('id', 'DESC')->take(1)->get();
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function popembelian()
    {
        return $this->belongsTo(Popembelian::class);
    }

    public function detail_pembelian()
    {
        return $this->hasMany(Detailpembelian::class);
    }

    public function faktur_pajak()
    {
        return $this->hasMany(Faktur_pajak::class);
    }
}