<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Detail_barang extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'pembelian_id',
        'detailpembelian_id',
        'supplier_id',
        'barang_id',
        'kategori',
        'kode_barang',
        'nama_barang',
        'jumlah',
        'keterangan',
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

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public static function getId()
    {
        return $getId = DB::table('detail_barangs')->orderBy('id', 'DESC')->take(1)->get();
    }
}