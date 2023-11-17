<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $karyawans = [
            [
                'karyawan_id' => '1',
                'kode_user' => 'AB000001',
                'qrcode_user' => '6714059572',
                'menu' => json_encode([
                    "user" => true,
                    "akses" => true,
                    "merek" => true,
                    "karyawan" => true,
                    "departemen" => true,
                    "supplier" => true,
                    "pelanggan" => true,
                    "merek" => true,
                    "type karoseri" => true,
                    "barang" => true,
                    "kendaraan" => true,
                    "po pembelian" => true,
                    "pembelian" => true,
                    "spk" => true,
                    "pengambilan bahan baku" => true,
                    "penjualan" => true,
                    "pelunasan" => true,
                    "deposit pemesanan" => true,
                    "inquery po pembelian" => true,
                    "inquery pembelian" => true,
                    "inquery spk" => true,
                    "inquery pengambilan bahan baku" => true,
                    "inquery deposit" => true,
                    "inquery penjualan" => true,
                    "inquery pelunasan" => true,
                    "laporan deposit" => true,
                    "laporan po pembelian" => true,
                    "laporan pembelian" => true,
                    "laporan spk" => true,
                    "laporan pengambilan bahan baku" => true,
                    "laporan penjualan" => true,
                    "laporan pelunasan" => true,
                ]),
                'password' => bcrypt('admin'),
                'cek_hapus' => 'tidak',
                'level' => 'admin',
            ],
        ];
        User::insert($karyawans);
    }
}