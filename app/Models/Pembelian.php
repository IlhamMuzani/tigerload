<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Pembelian extends Model
{
    use HasFactory;

    protected $fillable =
    [
        'kode_pembelian',
        'qrcode_pembelian',
        'supplier_id',
        'tanggal',
        'tanggal_awal',
        'tanggal_akhir',
        'status',
        'status_notif',

    ];

    public static function getId()
    {
        return $getId = DB::table('pembelians')->orderBy('id', 'DESC')->take(1)->get();
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function detail_pembelian()
    {
        return $this->hasMany(Detailpembelian::class);
    }
}