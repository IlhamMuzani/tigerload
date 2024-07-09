<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>faktur Penjualan</title>
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
            font-family: 'DOSVGA', monospace;
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
            font-size: 15px;
            text-align: center;

        } */

        .separator {
            padding-top: 15px;
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
        {{-- <tr>
            <!-- First column (Nama PT) -->
            <td style="width:0%;">
            </td>
            <td style="width: 70%; text-align: right;">
                <img src="{{ asset('storage/uploads/gambar_logo/login2.png') }}" width="120" height="30"
                    alt="Logo Tigerload">
            </td>
        </tr> --}}
    </table>
    <table width="100%">
        <tr>
            <!-- First column (Nama PT) -->
            <td style="width: 50%;">
                <div class="info-catatan" style="max-width: 240px;">
                    <table>
                        <tr>
                            <td class="info-catatan2" style="font-size: 15px;">CV. TIGER LOAD ENGINEERING</td>
                            {{-- <td class="info-item" style="font-size: 13px;">:</td>
                            <td class="info-text info-left" style="font-size: 13px;">Company Name</td> --}}
                        </tr>
                        <tr>
                            <td class="info-text info-left" style="font-size: 15px;">Jl. Ahmad Yani No. 42,</td>
                            {{-- <td class="info-item" style="font-size: 13px;">:</td>
                            <td class="info-text info-left" style="font-size: 13px;">Company Address</td> --}}
                        </tr>
                        <tr>
                            <td class="info-text info-left" style="font-size: 15px;">Procot Slawi, Tegal 52411</td>
                            {{-- <td class="info-item" style="font-size: 13px;">:</td>
                            <td class="info-text info-left" style="font-size: 13px;">123-456-7890</td> --}}
                        </tr>
                        <tr>
                            <td class="info-text info-left" style="font-size: 15px;">Telp, (0283) 4563746
                            </td>
                            {{-- <td class="info-item" style="font-size: 13px;">:</td>
                            <td class="info-text info-left" style="font-size: 13px;">123-456-7890</td> --}}
                        </tr>
                    </table>
                </div>
            </td>
            <!-- Second column (Nama Supplier) -->
            <td style="width: 70%;" style="max-width: 230px;">
                <div class="info-catatan">
                    <table>
                        <tr>
                            <td class="info-catatan2" style="font-size: 15px;">Nama Pelanggan</td>
                            <td class="info-item" style="font-size: 15px;">:</td>
                            <td class="info-text info-left" style="font-size: 15px;">
                                @if ($penjualans->perintah_kerja)
                                    {{ $penjualans->perintah_kerja->spk->pelanggan->nama_pelanggan }}
                                @else
                                    {{ $penjualans->spk->pelanggan->nama_pelanggan }}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="info-catatan2" style="font-size: 15px;">Alamat</td>
                            <td class="info-item" style="font-size: 15px;">:</td>
                            <td class="info-text info-left" style="font-size: 15px;">
                                @if ($penjualans->perintah_kerja)
                                    {{ $penjualans->perintah_kerja->spk->pelanggan->alamat }} </span>
                                @else
                                    {{ $penjualans->spk->pelanggan->alamat }} </span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="info-catatan2" style="font-size: 15px;">Telp</td>
                            <td class="info-item" style="font-size: 15px;">:</td>
                            <td class="info-text info-left" style="font-size: 15px;">
                                @if ($penjualans->perintah_kerja)
                                    {{ $penjualans->perintah_kerja->spk->pelanggan->telp }}
                                @else
                                    {{ $penjualans->spk->pelanggan->telp }}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="info-catatan2" style="font-size: 15px;">ID Pelanggan</td>
                            <td class="info-item" style="font-size: 15px;">:</td>
                            <td class="info-text info-left" style="font-size: 15px;">
                                @if ($penjualans->perintah_kerja)
                                    {{ $penjualans->perintah_kerja->spk->pelanggan->kode_pelanggan }}
                                @else
                                    {{ $penjualans->spk->pelanggan->kode_pelanggan }}
                                @endif </span>
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>

    <div style="font-weight: bold; text-align: center;">
        <span style="font-weight: bold; font-size: 20px;">FAKTUR PENJUALAN</span>
        <br>
    </div>
    {{-- <hr style="border-top: 0.5px solid black; margin: 3px 0;"> --}}
    <table style="width: 100%; border-top: 1px solid black; margin-bottom:5px">
        <tr>
            <td>
                <span class="info-item" style="font-size: 15px; padding-left: 5px;">No. Faktur:
                    {{ $penjualans->kode_penjualan }}</span>
                <br>
            </td>
            <td style="text-align: right; padding-right: 45px;">
                <span class="info-item" style="font-size: 15px;">Tanggal:{{ $penjualans->tanggal }}</span>
                <br>
            </td>
        </tr>
    </table>
    {{-- <hr style="border-top: 0.5px solid black; margin: 3px 0;"> --}}
    <table style="width: 100%; border-top: 1px solid black;" cellpadding="2" cellspacing="0">
        <tr>
            <td class="td" style="text-align: center; padding: 5px; font-size: 15px;">No.</td>
            <td class="td" style="text-align: left; padding: 5px; font-size: 15px;">Kode Barang</td>
            <td class="td" style="text-align: left; padding: 5px; font-size: 15px;">Nama Barang</td>
            <td class="td" style="text-align: left; padding: 5px; font-size: 15px;">Qty</td>
            <td class="td" style="text-align: right; padding: 5px; font-size: 15px;">Harga</td>
        </tr>
        <tr style="border-bottom: 1px solid black;">
            <td colspan="4" style="padding: 0px;"></td>
        </tr>
        @php
            $totalQuantity = 0;
            $totalHarga = 0;
        @endphp
        {{-- @foreach ($parts as $item) --}}
        <tr>
            <td class="td" style="text-align: center;  font-size: 15px;">1
            </td>
            <td class="info-text info-left" style="font-size: 15px; text-align: center;">
            </td>
            <td class="info-text info-left" style="font-size: 15px; text-align: left;">
                @if ($penjualans->perintah_kerja)
                    {{ $penjualans->perintah_kerja->spk->typekaroseri->nama_karoseri }}
                @else
                    {{ $penjualans->spk->typekaroseri->nama_karoseri }}
                @endif
            </td>
            <td class="td" style="text-align: left;  font-size: 15px;">
                1 </td>
            <td class="td" style="font-size: 15px; text-align: right;">
                <span style="float: center;">Rp.</span>
                <span style="float: right">
                    @if ($penjualans->perintah_kerja)
                        {{ number_format($penjualans->perintah_kerja->spk->harga, 0, ',', '.') }}
                    @else
                        {{ number_format($penjualans->spk->harga, 0, ',', '.') }}
                    @endif
                </span>
            </td>
        </tr>
        @if ($penjualans->perintah_kerja)
            @php
                $startFrom = 2;
                $totalSubtotalharga = $penjualans->perintah_kerja->spk->harga; // Inisialisasi dengan harga awal
            @endphp
        @else
            @php
                $startFrom = 2;
                $totalSubtotalharga = $penjualans->spk->harga; // Inisialisasi dengan harga awal
            @endphp
        @endif

          @php
                $totalSubtotaldp = 0; // Menambahkan harga saat iterasi
            @endphp
        @foreach ($spesifikasis as $item)
            <tr>
                <td class="td" style="text-align: center; padding: 0px;">{{ $startFrom }}</td>
                @php
                    $startFrom++;
                @endphp
                <td class="td" style="text-align: left; padding: 2px;">
                    {{ $item->kode_barang }}
                </td>
                <td class="td" style="text-align: left; padding: 2px;">
                    {{ $item->nama }}
                </td>
                <td class="td" style="text-align: left; padding: 2px;">{{ $item->jumlah }}</td>
                <td class="td" style="font-size: 15px; text-align: right;">
                    <span style="float: center;">Rp.</span>
                    <span style="float: right"> {{ number_format($item->harga, 0, ',', '.') }}
                    </span>
                </td>
            </tr>
            @php
                $totalSubtotaldp += $item->harga; // Menambahkan harga saat iterasi
            @endphp
        @endforeach

        <tr style="border-bottom: 1px solid black;">
            <td colspan="5" style="padding: 0px;">
            </td>
        </tr>

        <tr>
            <td colspan="4" style="text-align: right; font-weight: bold; padding: 5px;">Sub Total</td>
            {{-- <td class="td" style="text-align: right; font-weight: bold;">Rp.
                {{ number_format($totalSubtotal, 0, ',', '.') }}
            </td> --}}
            <td class="td" style="font-size: 15px; text-align: right; font-weight: bold;">
                <span style="float: center;">Rp.</span>
                <span style="float: right"> {{ number_format($totalSubtotalharga + $totalSubtotaldp, 0, ',', '.') }}
                </span>
            </td>
        </tr>
        <tr>
            <td colspan="4" style="text-align: right; font-weight: bold; padding: 5px;">DP
                @if ($penjualans->depositpemesanan)
                    ({{ $penjualans->depositpemesanan->tanggal }})
                @else
                @endif
            </td>
            {{-- <td class="td" style="text-align: right; font-weight: bold;">Rp.
                <span
                    style="text-decoration: underline">{{ number_format($penjualans->perintah_kerja->harga, 0, ',', '.') }}</span>
            </td> --}}
            <td class="td" style="font-size: 15px; text-align: right; font-weight: bold;">
                <span style="float: center;">Rp.</span>
                <span style="float: right; text-decoration: underline">
                    @if ($penjualans->depositpemesanan)
                        {{ number_format($penjualans->depositpemesanan->harga, 0, ',', '.') }}
                    @else
                        0
                    @endif
                </span>
            </td>
        </tr>
        <tr>
            <td colspan="4" style="text-align: right; font-weight: bold; padding: 5px;">Total</td>
            {{-- <td class="td" style="text-align: right; font-weight: bold;">Rp.
                {{ number_format($totalSubtotal - $penjualans->perintah_kerja->harga, 0, ',', '.') }}
            </td> --}}
            <td class="td" style="font-size: 15px; text-align: right; font-weight: bold;">
                <span style="float: center;">Rp.</span>
                <span style="float: right;">
                    @if ($penjualans->depositpemesanan)
                        {{ number_format(($totalSubtotalharga + $totalSubtotaldp) - $penjualans->depositpemesanan->harga, 0, ',', '.') }}
                    @else
                        {{ number_format($totalSubtotalharga + $totalSubtotaldp - 0, 0, ',', '.') }}
                    @endif
                </span>
            </td>
        </tr>
    </table>
    <br>
    <table class="tdd" cellpadding="10" cellspacing="0" style="margin: 0 auto;">
        <tr>
            <td style="text-align: center;">
                <table style="margin: 0 auto;">
                    <tr style="text-align: center;">
                        <td class="label" style="min-height: 16px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="separator" colspan="2"><span></span></td>
                    </tr>
                    <tr style="text-align: center;">
                        <td class="label">Pelanggan</td>
                    </tr>
                </table>
            </td>
            <td style="text-align: center;">
                <table style="margin: 0 auto;">
                    <tr style="text-align: center;">
                        <td class="label" style="min-height: 16px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="separator" colspan="2"><span></span></td>
                    </tr>
                    <tr style="text-align: center;">
                        <td class="label">Direktur</td>
                    </tr>
                </table>
            </td>
            <td style="text-align: center;">
                <table style="margin: 0 auto;">
                    <tr style="text-align: center;">
                        <td class="label">{{ auth()->user()->karyawan->nama_lengkap }}</td>
                    </tr>
                    <tr>
                        <td class="separator" colspan="2"><span></span></td>
                    </tr>
                    <tr style="text-align: center;">
                        <td class="label">Admin Penjualan</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
