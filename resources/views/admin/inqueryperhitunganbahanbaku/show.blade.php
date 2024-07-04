<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Perhitungan Pengambilan Bahan Baku</title>
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
            font-family: 'Times New Roman', Times, serif;
            color: black;
            padding: 30px;
        }

        span.h2 {
            font-size: 24px;
        }

        .label {
            font-size: 16px;
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

        .alamat,
        .nama-pt {
            color: black;
            font-weight: bold;
        }

        .label {
            color: black;
        }

        .info-catatan {
            display: flex;
            flex-direction: row;
            align-items: center;
            margin-bottom: 2px;
        }

        .info-catatan2 {
            font-weight: bold;
            margin-right: 5px;
            min-width: 120px;
        }

        .tdd1 td {
            text-align: center;
            font-size: 13px;
            position: relative;
            padding-top: 10px;
        }

        .tdd1 td::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            border-top: 1px solid black;
        }

        .separator {
            padding-top: 15px;
            text-align: center;
        }

        .separator span {
            display: inline-block;
            border-top: 1px solid black;
            width: 100%;
            position: relative;
            top: -8px;
        }

        .container {
            display: flex;
            justify-content: space-between;
            margin-top: 7rem;
        }

        .blue-button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            text-decoration: none;
            top: 50%;
            border-radius: 5px;
            transform: translateY(-50%);
        }

        @page {
            margin: 1cm;
        }
    </style>
</head>

<body style="margin: 0; padding: 0;">
    <table width="100%">
        <tr>
            <td style="text-align: left;">
                <img src="{{ asset('storage/uploads/gambar_logo/login2.png') }}" width="120" height="30"
                    alt="Logo Tigerload">
            </td>
        </tr>
    </table>
    <table width="100%">
        <tr>
            <td style="width: 50%;">
                <div class="info-catatan" style="max-width: 230px;">
                    <table>
                        <tr>
                            <td class="info-catatan2" style="font-size: 13px;">CV. TIGER LOAD ENGINEERING</td>
                        </tr>
                        <tr>
                            <td class="info-text info-left" style="font-size: 13px;">Jl. Ahmad Yani No. 42,</td>
                        </tr>
                        <tr>
                            <td class="info-text info-left" style="font-size: 13px;">Procot Slawi, Tegal 52411</td>
                        </tr>
                        <tr>
                            <td class="info-text info-left" style="font-size: 13px;">Telp, (0283) 4563746</td>
                        </tr>
                    </table>
                </div>
            </td>
            <td style="width: 50%;">
                <div class="info-catatan">
                    <table>
                        <tr>
                            <td class="info-catatan2" style="font-size: 13px;">Nomor SPK</td>
                            <td class="info-item" style="font-size: 13px;">:</td>
                            <td class="info-text info-left" style="font-size: 13px;">
                                {{ $pengambilans->perintah_kerja->kode_perintah }}
                            </td>
                        </tr>
                        <tr>
                            <td class="info-catatan2" style="font-size: 13px;">Nama Pelanggan</td>
                            <td class="info-item" style="font-size: 13px;">:</td>
                            <td class="info-text info-left" style="font-size: 13px;">
                                {{ $pengambilans->perintah_kerja->pelanggan->nama_pelanggan }}
                            </td>
                        </tr>
                        <tr>
                            <td class="info-catatan2" style="font-size: 13px;">Type Karoseri</td>
                            <td class="info-item" style="font-size: 13px;">:</td>
                            <td class="info-text info-left" style="font-size: 13px;">
                                {{ $pengambilans->perintah_kerja->typekaroseri->nama_karoseri }}
                            </td>
                        </tr>
                        <tr>
                            <td class="info-catatan2" style="font-size: 13px; color:white">Type Karoseri</td>
                            <td class="info-item" style="font-size: 13px; color:white">:</td>
                            <td class="info-text info-left" style="font-size: 13px; color:white">
                                {{ $pengambilans->perintah_kerja->typekaroseri->kode_type }}
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>
    <br>
    <div style="font-weight: bold; text-align: center;">
        <span style="font-weight: bold; font-size: 20px;">SURAT PERHITUNGAN PENGAMBILAN BAHAN BAKU</span>
        <br>
    </div>
    <br>
    <table style="width: 100%; border-top: 1px solid black; margin-bottom:5px">
        <tr>
            <td>
                <span class="info-item" style="font-size: 15px; padding-left: 5px;">No. Perhitungan:
                    {{ $pengambilans->kode_perhitungan }}</span>
                <br>
            </td>
            <td style="text-align: right; padding-right: 45px;">
                <span class="info-item" style="font-size: 15px;">Tanggal:{{ $pengambilans->tanggal }}</span>
                <br>
            </td>
        </tr>
    </table>
    <table style="width: 100%; border-top: 1px solid black;" cellpadding="2" cellspacing="0">
        <!-- Header row -->
        <tr>
            <td class="td" style="text-align: left; padding: 5px; font-weight:bold; font-size: 12px; width:25%">
                No</td>
            <td class="td" style="text-align: left; padding: 5px; font-weight:bold; font-size: 12px; width:30%">
                Kode Pengambilan
            </td>
            <td class="td" style="text-align: left; padding: 5px; font-weight:bold; font-size: 12px; width:30%">
                Tanggal</td>
            <td class="td" style="text-align: left; padding: 5px; font-weight:bold; font-size: 12px; width:39%">

            </td>
            <td class="td" style="text-align: left; padding: 5px; font-weight:bold; font-size: 12px; width:39%">

            </td>
        </tr>
        <tr style="border-bottom: 1px solid black;">
            <td colspan="5" style="padding: 0px;"></td>
        </tr>
        @foreach ($cetakpdfs as $cetakpdf)
            <tr style="background:rgb(181, 181, 181)">
                <td class="td" style="text-align: left; padding: 5px; font-size: 12px;">
                    {{ $loop->iteration }}
                </td>
                <td class="td" style="text-align: left; padding: 5px; font-size: 12px;">
                    {{ $cetakpdf->kode_pengambilan }}
                </td>
                <td class="td" style="text-align: left; padding: 5px; font-size: 12px;">
                    {{ $cetakpdf->tanggal_awal }}
                </td>
                <td class="td" style="text-align: left; padding: 5px; font-size: 12px;">

                </td>
                <td class="td" style="text-align: left; padding: 5px; font-size: 12px;">

                </td>
            </tr>
            <tr>
                <td class="td" style="text-align: left; padding: 5px; font-size: 12px; font-weight:bold">
                    Kode Barang
                </td>
                <td class="td" style="text-align: left; padding: 5px; font-size: 12px; font-weight:bold">
                    Nama Barang
                </td>
                <td class="td" style="text-align: right; padding: 5px; font-size: 12px; font-weight:bold">
                    Qty
                </td>
                <td class="td" style="text-align: right; padding: 5px; font-size: 12px; font-weight:bold">
                    Harga
                </td>
                <td class="td" style="text-align: right; padding: 5px; font-size: 12px; font-weight:bold">
                    Total
                </td>
            </tr>
            @foreach ($cetakpdf->detailpengambilan as $item)
                <tr>
                    <td class="td" style="text-align: left; padding: 5px; font-size: 12px;">
                        {{ $item->kode_barang }}
                    </td>
                    <td class="td" style="text-align: left; padding: 5px; font-size: 12px;">
                        {{ $item->nama_barang }}
                    </td>
                    <td class="td" style="text-align: right; padding: 5px; font-size: 12px;">
                        {{ $item->jumlah }}
                    </td>
                    <td class="td" style="text-align: right; padding: 5px; font-size: 12px;">
                        {{ number_format($item->harga, 2, ',', '.') }}
                    </td>
                    <td class="td" style="text-align: right; padding: 5px; font-size: 12px;">
                        {{ number_format($item->total, 2, ',', '.') }}
                    </td>
                </tr>
            @endforeach
        @endforeach

        @php
            $totalHarga = 0;
            $totalJumlah = 0;
            foreach ($cetakpdfs as $pengambilan) {
                foreach ($pengambilan->detailpengambilan as $item) {
                    $totalHarga += $item->harga * $item->jumlah;
                    $totalJumlah += $item->jumlah;
                }
            }
            $hasil = $totalJumlah ? $totalHarga / $totalJumlah : 0;
        @endphp
        <tr style="border-bottom: 1px solid black;">
            <td colspan="" style="padding: 0px;"></td>
        </tr>
        <tr>
            <td class="td" style="text-align: left; padding: 5px; font-size: 12px;">

            </td>
            <td class="td" style="text-align: left; padding: 5px; font-size: 12px;">

            </td>
            <td class="td" style="text-align: right; padding: 5px; font-size: 12px;">

            </td>
            <td class="td" style="text-align: right; padding: 5px; font-size: 12px;">
                Sub Total
            </td>
            <td class="td" style="text-align: right; padding: 5px; font-size: 12px; font-weight:bold">
                {{ number_format($totalHarga, 2, ',', '.') }}
            </td>
        </tr>
        <tr>
            <td colspan="4" style="text-align: right; font-weight: bold; padding: 5px; font-size: 12px;">
                {{-- Sub Total --}}
            </td>
            <td style="text-align: right; font-weight: bold; padding: 5px; font-size: 12px;">
                {{-- {{ number_format($total, 0, ',', '.') }} --}}
            </td>
        </tr>
    </table>
    <br>
</body>
<div class="container">
    <a href="{{ url('admin/inquery_pengambilanbahan') }}" class="blue-button">Kembali</a>
    <a href="{{ url('admin/perhitungan_bahanbaku/cetak-pdf/' . $pengambilans->id) }}" class="blue-button">Cetak</a>
</div>

</html>
