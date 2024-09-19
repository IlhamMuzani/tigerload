<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Popembelian extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable =
    [
        'kode_po_pembelian',
        'kode_qrcode',
        'qrcode_popembelian',
        'supplier_id',
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
        return $getId = DB::table('popembelians')->orderBy('id', 'DESC')->take(1)->get();
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function detail_popembelian()
    {
        return $this->hasMany(Detailpopembelian::class);
    }

    public function pembelian()
    {
        return $this->hasMany(Pembelian::class);
    }
}
