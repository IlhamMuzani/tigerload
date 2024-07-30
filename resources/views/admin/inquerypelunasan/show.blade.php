<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>faktur Pelunasan</title>
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
            padding: 20px;
            */
            /* Gunakan Arial atau font sans-serif lainnya yang mudah dibaca */
            /* margin: 40px;
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
            /* size: A4; */
            margin: 1cm;
        }
    </style>
</head>

<body style="margin: 0; padding: 0;">
    <table width="100%">
        <td style="text-align: left;">
            <img src="{{ asset('storage/uploads/gambar_logo/login2.png') }}" width="120" height="30"
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
                <div class="info-catatan" style="max-width: 230px;">
                    <table>
                        <tr>
                            <td class="info-catatan2" style="font-size: 13px;">CV. TIGER LOAD ENGINEERING</td>
                            {{-- <td class="info-item" style="font-size: 13px;">:</td>
                            <td class="info-text info-left" style="font-size: 13px;">Company Name</td> --}}
                        </tr>
                        <tr>
                            <td class="info-text info-left" style="font-size: 13px;">Jl. Ahmad Yani No. 42,</td>
                            {{-- <td class="info-item" style="font-size: 13px;">:</td>
                            <td class="info-text info-left" style="font-size: 13px;">Company Address</td> --}}
                        </tr>
                        <tr>
                            <td class="info-text info-left" style="font-size: 13px;">Procot Slawi, Tegal 52411</td>
                            {{-- <td class="info-item" style="font-size: 13px;">:</td>
                            <td class="info-text info-left" style="font-size: 13px;">123-456-7890</td> --}}
                        </tr>
                        <tr>
                            <td class="info-text info-left" style="font-size: 13px;">Telp, (0283) 4563746
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
                            <td class="info-catatan2" style="font-size: 13px;">Nama Pelanggan</td>
                            <td class="info-item" style="font-size: 13px;">:</td>
                            <td class="info-text info-left" style="font-size: 13px;">
                                @if ($pelunasans->penjualan)
                                    {{ $pelunasans->penjualan->perintah_kerja->spk->pelanggan->nama_pelanggan }}
                                @else
                                    tidak ada
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="info-catatan2" style="font-size: 13px;">Alamat</td>
                            <td class="info-item" style="font-size: 13px;">:</td>
                            <td class="info-text info-left" style="font-size: 13px;">
                                @if ($pelunasans->penjualan)
                                    {{ $pelunasans->penjualan->perintah_kerja->spk->pelanggan->alamat }}
                                @else
                                    tidak ada
                                @endif
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="info-catatan2" style="font-size: 13px;">Telp</td>
                            <td class="info-item" style="font-size: 13px;">:</td>
                            <td class="info-text info-left" style="font-size: 13px;">
                                @if ($pelunasans->penjualan)
                                    {{ $pelunasans->penjualan->perintah_kerja->spk->pelanggan->telp }}
                                @else
                                    tidak ada
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="info-catatan2" style="font-size: 13px;">ID Pelanggan</td>
                            <td class="info-item" style="font-size: 13px;">:</td>
                            <td class="info-text info-left" style="font-size: 13px;">
                                @if ($pelunasans->penjualan)
                                    {{ $pelunasans->penjualan->perintah_kerja->spk->pelanggan->kode_pelanggan }}
                                @else
                                    tidak ada
                                @endif
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>

    <div style="font-weight: bold; text-align: center;">
        <span style="font-weight: bold; font-size: 20px;">RINCIAN PEMBAYARAN</span>
        <br>
    </div>
    {{-- <hr style="border-top: 0.5px solid black; margin: 3px 0;"> --}}
    <table style="width: 100%; border-top: 1px solid black; margin-bottom:5px">
        <tr>
            <td>
                <span class="info-item" style="font-size: 15px; padding-left: 5px;">No. Faktur:
                    {{ $pelunasans->kode_pelunasan }}</span>
                <br>
            </td>
            <td style="text-align: right; padding-right: 45px;">
                <span class="info-item" style="font-size: 15px;">Tanggal:{{ $pelunasans->tanggal }}</span>
                <br>
            </td>
            <td style="text-align: right; padding-right: 45px;">
                <span class="info-item" style="font-size: 15px;">Status:{{ $pelunasans->status_pelunasan }}</span>
                <br>
            </td>
        </tr>
    </table>

    {{-- <hr style="border-top: 0.5px solid black; margin: 3px 0;"> --}}
    <table style="width: 100%; border-top: 1px solid black;" cellpadding="2" cellspacing="0">
        <tr>
            <td class="td" style="text-align: center; padding: 5px; font-size: 15px;">No.</td>
            <td class="td" style="text-align: center; padding: 5px; font-size: 15px;">F.Penjualan</td>
            <td class="td" style="text-align: center; padding: 5px; font-size: 15px;">Total Penjualan</td>
            <td class="td" style="text-align: center; padding: 5px; font-size: 15px;">Sub Total</td>
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
                {{ $pelunasans->penjualan->kode_penjualan }}
            </td>
            <td class="td" style="text-align: center;  font-size: 15px;">
                {{ number_format($pelunasans->totalpenjualan, 0, ',', '.') }} </td>
            <td class="td" style="text-align: center; font-size: 15px;">
                {{ number_format($pelunasans->totalpenjualan, 0, ',', '.') }}
            </td>
        </tr>
        {{-- @php
            $startFrom = 2;
            $totalSubtotal = $pelunasans->depositpemesanan->spk->harga; // Inisialisasi dengan harga awal
        @endphp --}}

        <tr style="border-bottom: 1px solid black;">
            <td colspan="4" style="padding: 0px;">
            </td>
        </tr>

        <table style="width: 100%; border-top: 1px solid black; margin-bottom:5px">
            <tr>
                <td>
                    <span class="info-item" style="font-size: 15px; font-weight:bold; padding-left: 5px;">Rincian
                        Pembayaran:
                    </span>
                    <br>
                </td>
                <td colspan="4" style="text-align: right; padding-right: 149px;">
                    <span class="info-item" style="font-size: 15px; font-weight:bold;">
                        {{ number_format($pelunasans->totalpenjualan, 0, ',', '.') }}</span>
                    <br>
                </td>
            </tr>
            <tr>
                <td>
                    <span class="info-item"
                        style="font-size: 15px; padding-left: 5px;">-{{ $pelunasans->kategori }}({{ $pelunasans->nomor }})
                        = ({{ number_format($pelunasans->nominal, 0, ',', '.') }}) ({{ $pelunasans->tanggal_awal }})
                    </span>
                    <br>
                </td>
            </tr>
        </table>
        <table style="width: 49%; margin-left:740px;margin-bottom:5px">
            <tr>
                <td>
                    <span class="info-item" style="font-size: 15px;"></span>
                    <br>
                </td>
                <td style="">
                    <span class="info-item" style="font-size: 15px;">Potongan Penjualan</span>
                </td>
                <td style="text-align: right; padding-right: 196px;">
                    <span class="info-item" style="font-size: 15px; margin;"></span>
                </td>
                <td style="text-align: right; padding-right: 156px;">
                    <span class="info-item" style="font-size: 15px; margin;">
                        @if ($pelunasans->potongan == null)
                            0
                        @else
                            {{ number_format($pelunasans->potongan, 0, ',', '.') }}
                        @endif
                    </span>
                </td>
            </tr>
            <tr>
                <td>
                    <span class="info-item" style="font-size: 15px;"></span>
                    <br>
                </td>
                <td style="">
                    <span class="info-item" style="font-size: 15px;">Sisa Tagihan</span>
                </td>
                <td style="text-align: right; padding-right: 196px;">
                    <span class="info-item" style="font-size: 15px; margin;"></span>
                </td>
                <td style="text-align: right; padding-right: 156px;">
                    <span class="info-item" style="font-size: 15px; margin;">
                        {{ number_format($pelunasans->totalpenjualan - $pelunasans->potongan, 0, ',', '.') }}
                </td>
            </tr>
        </table>
        <table style="width: 47%; margin-left:740px; margin-top:20px; border-top: 1px solid black; margin-bottom:5px">
            <tr>
                <td>
                    <span class="info-item" style="font-size: 15px;"></span>
                    <br>
                </td>
                <td style="">
                    <span class="info-item" style="font-size: 15px;">Total Tagihan</span>
                </td>
                <td style="text-align: right; padding-right: 184px;">
                    <span class="info-item" style="font-size: 15px; margin;"></span>
                </td>
                <td style="text-align: right; padding-right: 128px;">
                    <span class="info-item" style="font-size: 15px; margin;">
                        {{ number_format($pelunasans->totalpenjualan - $pelunasans->potongan, 0, ',', '.') }}</span>
                </td>
            </tr>
            <tr>
                <td>
                    <span class="info-item" style="font-size: 15px;"></span>
                    <br>
                </td>
                @php
                    $totalDP = 0;
                @endphp
                @foreach ($depositpemesanans as $index => $deposit)
                    <td style="">
                        <span class="info-item" style="font-size: 15px;"> DP
                            ({{ $deposit->kode_deposit }} {{ $deposit->tanggal }})
                        </span>
                    </td>
                    <td style="text-align: right; padding-right: 144px;">
                        <span class="info-item" style="font-size: 15px; margin;"></span>
                    </td>
                    <td style="text-align: right; padding-right: 128px;">
                        <span class="info-item" style="font-size: 15px; margin;">
                            {{ number_format($deposit->harga, 0, ',', '.') }}
                        </span>
                    </td>
                    @php
                        $totalDP += $deposit->harga;
                    @endphp
                @endforeach
            </tr>
            <tr>
                <td>
                    <span class="info-item" style="font-size: 15px;"></span>
                    <br>
                </td>
                <td style="">
                    <span class="info-item" style="font-size: 15px;">Pelunasan </span>
                </td>
                <td style="text-align: right; padding-right: 144px;">
                    <span class="info-item" style="font-size: 15px; margin;"></span>
                </td>
                <td style="text-align: right; padding-right: 128px;">
                    <span class="info-item" style="font-size: 15px; margin;">
                        {{ number_format($pelunasans->nominal, 0, ',', '.') }}</span>
                </td>
            </tr>
        </table>

        {{-- @php
            $startFrom = 2;
            $SisaTagihan = $pelunasans->depositpemesanan->spk->harga + $pelunasans->detail_penjualan->where('penjualan_id', $pelunasans->id)->sum('harga') - $pelunasans->nominal - $pelunasans->depositpemesanan->harga;
        @endphp --}}

        <table style="width: 47%; margin-left:740px; border-top: 1px solid black; margin-bottom:5px">
            <tr>
                <td>
                    <span class="info-item" style="font-size: 15px;"></span>
                    <br>
                </td>
                <td style="">
                    <span class="info-item" style="font-size: 15px;">Selisih Tagihan</span>
                </td>
                <td style="text-align: right; padding-right: 169px;">
                    <span class="info-item" style="font-size: 15px; margin;"></span>
                </td>
                <td style="text-align: right; padding-right: 127px;">
                    <span class="info-item" style="font-size: 15px; margin;">
                        {{ number_format($pelunasans->selisih, 0, ',', '.') }}
                    </span>
                </td>
            </tr>
        </table>
    </table>
    <br>

    @if ($pelunasans->penjualan)
        @if ($pelunasans->penjualan->perintah_kerja->spk->kategori == 'NON PPN')
            <table width="100%">
                <tr>
                    <td>
                        <div class="info-catatan" style="max-width: 400px;">
                            <table>
                                <tr>
                                    <td class="info-catatan2">Nama Bank</td>
                                    <td class="info-item">:</td>
                                    <td>BCA</td>
                                </tr>
                                <tr>
                                    <td class="info-catatan2">No. Rekening</td>
                                    <td class="info-item">:</td>
                                    <td>3629888889</td>
                                </tr>
                                <tr>
                                    <td class="info-catatan2">Atas Nama</td>
                                    <td class="info-item">:</td>
                                    <td>DJOHAN WAHYUDI</td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
            </table>
        @else
            <table width="100%">
                <tr>
                    <td>
                        <div class="info-catatan" style="max-width: 400px;">
                            <table>
                                <tr>
                                    <td class="info-catatan2">Nama Bank</td>
                                    <td class="info-item">:</td>
                                    <td>BCA</td>
                                </tr>
                                <tr>
                                    <td class="info-catatan2">No. Rekening</td>
                                    <td class="info-item">:</td>
                                    <td>3611889999</td>
                                </tr>
                                <tr>
                                    <td class="info-catatan2">Atas Nama</td>
                                    <td class="info-item">:</td>
                                    <td>CV Tiger Load Engineering</td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
            </table>
        @endif
    @else
        @if ($pelunasans->penjualan->perintah_kerja->spk->kategori == 'NON PPN')
            <table width="100%">
                <tr>
                    <td>
                        <div class="info-catatan" style="max-width: 400px;">
                            <table>
                                <tr>
                                    <td class="info-catatan2">Nama Bank</td>
                                    <td class="info-item">:</td>
                                    <td>BCA</td>
                                </tr>
                                <tr>
                                    <td class="info-catatan2">No. Rekening</td>
                                    <td class="info-item">:</td>
                                    <td>3629888889</td>
                                </tr>
                                <tr>
                                    <td class="info-catatan2">Atas Nama</td>
                                    <td class="info-item">:</td>
                                    <td>DJOHAN WAHYUDI</td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
            </table>
        @else
            <table width="100%">
                <tr>
                    <td>
                        <div class="info-catatan" style="max-width: 400px;">
                            <table>
                                <tr>
                                    <td class="info-catatan2">Nama Bank</td>
                                    <td class="info-item">:</td>
                                    <td>BCA</td>
                                </tr>
                                <tr>
                                    <td class="info-catatan2">No. Rekening</td>
                                    <td class="info-item">:</td>
                                    <td>3611889999</td>
                                </tr>
                                <tr>
                                    <td class="info-catatan2">Atas Nama</td>
                                    <td class="info-item">:</td>
                                    <td>CV Tiger Load Engineering</td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
            </table>
        @endif
    @endif




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
                        <td class="label">Accounting</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

<div class="container">
    <a href="{{ url('admin/inquery_pelunasan') }}" class="blue-button">Kembali</a>
    <a href="{{ url('admin/pelunasan_penjualan/cetak-pdf/' . $pelunasans->id) }}" class="blue-button">Cetak</a>
</div>

</html>
