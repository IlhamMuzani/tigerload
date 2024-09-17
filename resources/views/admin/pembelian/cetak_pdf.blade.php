<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>faktur Pembelian</title>
    <style>
        .b {
            border: 1px solid black;
        }

        .table,
        .td {
            /* border: 1px solid black; */
        }

        .table,
        .tdd {
            border: 1px solid white;
        }

        html,
        body {
            font-family: Arial, sans-serif;
            color: black;
            /* Gunakan Arial atau font sans-serif lainnya yang mudah dibaca */
            /* margin: 40px;
            padding: 10px; */
        }

        span.h2 {
            font-size: 24px;
            /* font-weight: 500; */
        }

        .label {
            font-size: 16px;
            /* Sesuaikan ukuran label sesuai preferensi Anda */
            text-align: center;
        }


        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
        }

        .tdd td {
            border: none;
        }

        .container {
            position: relative;
            margin-top: 7rem;
        }

        .faktur {
            text-align: center
        }

        .info-container {
            display: flex;
            justify-content: space-between;
            font-weight: bold;
            font-size: 16px;
            margin: 5px 0;
        }

        .right-col {
            text-align: right;
        }

        .info-text {
            text-align: left;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .info-left {
            text-align: left;
            /* Apply left-align specifically for the info-text class */
        }

        .info-item {
            flex: 1;
        }

        .alamat {
            color: black;
            font-weight: bold;
        }

        .blue-button:hover {
            background-color: #0056b3;
        }

        /* .nama-pt {
            color: black;
            font-weight: bold;
        }

        .alamat {
            color: black;
            font-weight: bold;
        } */

        .alamat,
        .nama-pt {
            color: black;
            font-weight: bold;
        }

        .label {
            color: black;
            /* Atur warna sesuai kebutuhan Anda */
        }


        .info-catatan {
            display: flex;
            flex-direction: row;
            /* Mengatur arah menjadi baris */
            align-items: center;
            /* Posisi elemen secara vertikal di tengah */
            margin-bottom: 2px;
            /* Menambah jarak antara setiap baris */
        }

        .info-catatan2 {
            font-weight: bold;
            margin-right: 5px;
            min-width: 120px;
            /* Menetapkan lebar minimum untuk kolom pertama */
        }

        .tdd1 td {
            text-align: center;
            font-size: 13px;
            position: relative;
            padding-top: 10px;
            /* Sesuaikan dengan kebutuhan Anda */
        }

        .tdd1 td::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            border-top: 1px solid black;
        }

        .info-1 {}

        /* .label {
            font-size: 12px;
            text-align: center;

        } */

        .separator {
            padding-top: 12px;
            /* Atur sesuai kebutuhan Anda */
            text-align: center;
            /* Teks menjadi berada di tengah */

        }

        .separator span {
            display: inline-block;
            border-top: 1px solid black;
            width: 100%;
            position: relative;
            top: -8px;
            /* Sesuaikan posisi vertikal garis tengah */
        }

        @page {
            /* size: A4; */
            margin: 1cm;
        }
    </style>
</head>

<body style="margin: 0; padding: 0;">
    <table width="100%">
        <td style="text-align: left;">
            <img src="{{ public_path('storage/uploads/gambar_logo/login2.png') }}" width="120" height="30"
                alt="Logo Tigerload">
        </td>
    </table>

    <table class="tdd" cellpadding="10" cellspacing="0" style="margin: 0 auto;">
        <tr>
            {{-- pemilik pt  --}}
            <td style="text-align: left; width: 30%;">
                <table style="margin: 0 auto;">
                    <tr style="text-align: left;">
                        <td style="font-size: 12px; font-weight:bold" class="label2">CV. TIGER LOAD ENGINEERING
                        </td>
                    </tr>
                    <tr>
                        <td style="font-size: 12px" class="label2">Jl. Ahmad Yani No. 42,</td>
                    </tr>
                    <tr style="text-align: left;font-size: 12px">
                        <td class="label2">Procot Slawi, Tegal 52411</td>
                    </tr>
                    <tr style="text-align: left;font-size: 12px">
                        <td class="label2">Telp, (0283) 4563746</td>
                    </tr>
                    <tr style="text-align: left; background:white; font-size: 12px">
                        <td class="label2">.</td>
                    </tr>
                </table>
            </td>
            {{-- pelanggan --}}
            <td style="text-align: left; width: 50%; font-size: 12px">
                <table style="margin: 0 auto;">
                    <tr style="text-align: left;">
                        <td class="label2" style="width: 23%; font-weight:bold">Nama Pelanggan</td>
                        <td class="label2" style="width: 5%;">:</td>
                        <td class="label2" style="width: 67%;"> {{ $pembelians->supplier->nama_supp }}
                        </td>
                    </tr>
                    <tr>
                        <td class="label2" style="font-weight:bold">Alamat</td>
                        <td class="label2">:</td>
                        <td class="label2"> {{ $pembelians->supplier->alamat }}</td>
                    </tr>
                    <tr style="text-align: left;">
                        <td class="label2" style="font-weight:bold">Telp</td>
                        <td class="label2">:</td>
                        <td class="label2">{{ $pembelians->supplier->telp }} /
                            {{ $pembelians->supplier->hp }}</td>
                    </tr>
                    <tr style="text-align: left;">
                        <td class="label2" style="font-weight:bold">Id Supplier</td>
                        <td class="label2">:</td>
                        <td class="label2"> {{ $pembelians->supplier->kode_supplier }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <div style="font-weight: bold; text-align: center;">
        <span style="font-weight: bold; font-size: 17px;">FAKTUR PEMBELIAN</span>
        <br>
    </div>
    {{-- <hr style="border-top: 0.5px solid black; margin: 3px 0;"> --}}
    <table style="width: 100%; border-top: 1px solid black; margin-bottom:5px; font-size: 12px">
        <tr>
            <td>
                <span class="info-item" style="font-size: 12px; padding-left: 5px;">No. Faktur:
                    {{ $pembelians->kode_pembelian }}</span>
                <br>
            </td>
            <td style="text-align: right; padding-right: 45px;">
                <span class="info-item" style="font-size: 12px;">Tanggal:{{ $pembelians->tanggal }}</span>
                <br>
            </td>
        </tr>
    </table>
    {{-- <hr style="border-top: 0.5px solid black; margin: 3px 0;"> --}}
    <table style="width: 100%; border-top: 1px solid black;" cellpadding="2" cellspacing="0">
        <tr>
            <td class="td" style="text-align: center; padding: 5px; font-size: 12px;">No.</td>
            <td class="td" style="text-align: left; padding: 5px; font-size: 12px;">Kode Barang</td>
            <td class="td" style="text-align: left; padding: 5px; font-size: 12px;">Nama Barang</td>
            <td class="td" style="text-align: right; font-size: 12px;">Qty</td>
            <td class="td" style="text-align: right; padding: 5px; font-size: 12px;">Harga</td>
            <td class="td" style="text-align: left; padding: 5px; font-size: 12px;">Satuan</td>
            <td class="td" style="text-align: right; padding: 5px; font-size: 12px;">Total</td>
        </tr>
        <tr style="border-bottom: 1px solid black;">
            <td colspan="7" style="padding: 0px;"></td>
        </tr>
        @php
            $totalQuantity = 0;
            $totalHarga = 0;
        @endphp
        @foreach ($parts as $item)
            <tr>
                <td class="td" style="text-align: center;  font-size: 12px;">{{ $loop->iteration }}
                </td>
                <td class="td" style="text-align: left;  font-size: 12px;">{{ $item->kode_barang }}</td>
                <td class="info-text info-left" style="font-size: 12px; text-align: left;">
                    {{ $item->nama_barang }}
                </td>
                <td class="td" style="text-align: right; font-size: 12px;">
                    {{ $item->jumlah }}
                </td>
                <td class="td" style="text-align: right;  font-size: 12px;">
                    {{ number_format($item->harga, 2, ',', '.') }}
                </td>
                <td class="td" style="text-align: left;  font-size: 12px;">

                    {{ $item->satuan->kode_satuan ?? null }}
                </td>
                <td class="td" style="text-align: right;  font-size: 12px;">
                    {{ number_format($item->total, 2, ',', '.') }}
                </td>
            </tr>
            @php
                $totalQuantity += 1; // Increment by 1 for each item (you can use your actual quantity field here)
                $totalHarga += $item->total; // Add the item's harga to the total harga
            @endphp
        @endforeach
        <tr style="border-bottom: 1px solid black;">
            <td colspan="7" style="padding: 0px;"></td>
        </tr>
        <tr>
            <td colspan="6" style="text-align: right; font-weight: bold; padding: 5px; font-size: 12px;">Sub Total
            </td>
            <td class="td" style="text-align: right; font-weight: bold; font-size: 12px;">Rp.
                {{ number_format($totalHarga, 2, ',', '.') }}
            </td>
        </tr>
    </table>
    <table width="100%">
        <tr>
            <td>
                <div class="info-catatan" style="max-width: 230px;">
                    <table>
                        <tr>
                            <td class="info-catatan2" style="font-size: 12px;">Nama Supplier</td>
                            <td class="info-item" style="font-size: 12px;">:</td>
                            <td class="info-text info-left" style="font-size: 12px;">
                                {{ $pembelians->supplier->nama_bank }}
                            </td>
                        </tr>
                        <tr>
                            <td class="info-catatan2" style="font-size: 12px;">No. Rekening</td>
                            <td class="info-item" style="font-size: 12px;">:</td>
                            <td class="info-text info-left" style="font-size: 12px;">
                                {{ $pembelians->supplier->norek }}
                            </td>
                        </tr>
                        <tr>
                            <td class="info-catatan2" style="font-size: 12px;">Atas Nama</td>
                            <td class="info-item" style="font-size: 12px;">:</td>
                            <td class="info-text info-left" style="font-size: 12px;">
                                {{ $pembelians->supplier->atas_nama }}
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>
    <br>
    <table class="tdd" cellpadding="10" cellspacing="0" style="margin: 0 auto;">
        <tr>
            <td style="text-align: center; ">
                <table style="margin: 0 auto;">
                    <tr style="text-align: center;">
                        <td class="label" style="min-height: 16px; font-size: 12px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="font-size: 12px;" class="separator" colspan="2"><span></span></td>
                    </tr>
                    <tr style="text-align: center;">
                        <td style="font-size: 12px;" class="label">Gudang</td>
                    </tr>
                </table>
            </td>
            <td style="text-align: center;">
                <table style="margin: 0 auto;">
                    <tr style="text-align: center;">
                        <td style="font-size: 12px;" class="label">{{ auth()->user()->karyawan->nama_lengkap }}</td>
                    </tr>
                    <tr>
                        <td style="font-size: 12px;" class="separator" colspan="2"><span></span></td>
                    </tr>
                    <tr style="text-align: center;">
                        <td style="font-size: 12px;" class="label">Pembelian</td>
                    </tr>
                </table>
            </td>
            <td style="text-align: center;">
                <table style="margin: 0 auto;">
                    <tr style="text-align: center;">
                        <td style="font-size: 12px;" class="label" style="min-height: 16px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="font-size: 12px;" class="separator" colspan="2"><span></span></td>
                    </tr>
                    <tr style="text-align: center;">
                        <td style="font-size: 12px;" class="label">Accounting</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
