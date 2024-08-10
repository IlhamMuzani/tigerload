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
            font-family: Arial, sans-serif;
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
            font-size: 13px;
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
            font-size: 13px;
            text-align: center;

        } */

        .separator {
            padding-top: 13px;
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
    </table>

    <table width="100%">
        <tr>
            <!-- First column (Nama PT) -->
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
                            <td class="info-text info-left" style="font-size: 13px;">Telp, (0283) 4563746
                            </td>

                        </tr>
                    </table>
                </div>
            </td>
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
                <span class="info-item" style="font-size: 13px; padding-left: 5px;">No. Faktur:
                    {{ $pelunasans->kode_pelunasan }}</span>
                <br>
            </td>
            <td style="text-align: right; padding-right: 45px;">
                <span class="info-item" style="font-size: 13px;">Tanggal:{{ $pelunasans->tanggal }}</span>
                <br>
            </td>
            <td style="text-align: right;">
                <span class="info-item" style="font-size: 13px;">Status: <span
                        style="font-style: bold">{{ $pelunasans->status_pelunasan }}</span></span>
                <br>
            </td>
        </tr>
    </table>

    {{-- <hr style="border-top: 0.5px solid black; margin: 3px 0;"> --}}
    <table style="width: 100%; border-top: 1px solid black;" cellpadding="2" cellspacing="0">
        <tr>
            <td class="td" style="text-align: center; padding: 5px; font-size: 13px;">No.</td>
            <td class="td" style="text-align: center; paddin 5px; font-size: 13px;">F. Penjualan</td>
            <td class="td" style="text-align: right; font-size: 13px;">Total Penjualan</td>
            <td class="td" style="text-align: right; font-size: 13px;">Sub Total</td>
        </tr>
        <tr style="border-bottom: 1px solid black;">
            <td colspan="4" style="padding: 0px;"></td>
        </tr>
        @php
            $totalQuantity = 0;
            $totalHarga = 0;
            $startFrom = 2;
        @endphp
        <tr>
            <td class="td" style="text-align: center;  font-size: 13px;">1
            </td>
            <td class="info-text info-left" style="font-size: 13px; text-align: center;">
                {{ $pelunasans->penjualan->kode_penjualan }}
            </td>
            <td class="td" style="text-align: right;  font-size: 13px;">
                {{ number_format($pelunasans->totalpenjualan, 0, ',', '.') }} </td>
            </td>
            <td class="td" style="text-align: right;  font-size: 13px;">
                {{ number_format($pelunasans->totalpenjualan, 0, ',', '.') }}
            </td>
        </tr>
        @foreach ($detail_penjualans as $item)
            <tr>
                <td class="td" style="text-align: center;  font-size: 13px;">{{ $startFrom }}
                </td>
                @php
                    $startFrom++;
                @endphp
                <td class="info-text info-left" style="font-size: 13px; text-align: center;">
                    {{ $item->kode_types }} </td>
                <td class="td" style="text-align: right;  font-size: 13px;">
                    {{ number_format($item->total, 0, ',', '.') }}
                </td>
                <td class="td" style="text-align: right;  font-size: 13px;">
                    {{ number_format($item->total, 0, ',', '.') }}
                </td>
            </tr>
        @endforeach
        <tr style="border-bottom: 1px solid black;">
            <td colspan="4" style="padding: 0px;">
            </td>
        </tr>
    </table>
    <table style="width: 100%; border-top: 1px solid black; margin-bottom:5px">
        <tr>
            <td>
                <span class="info-item" style="font-size: 13px; padding-left: 5px; font-weight:bold">RINCIAN
                    PEMBAYARAN</span>
                <br>
            </td>
            <td style="text-align: right;">
                <span class="info-item" style="font-size: 13px;"><span
                        style="font-style: bold">{{ number_format($pelunasans->totalpenjualan + $pelunasans->biaya_tambahan, 0, ',', '.') }}</span></span>
                <br>
            </td>
        </tr>
        <tr>
            <td>
                <span class="info-item"
                    style="font-size: 13px; padding-left: 5px;">-{{ $pelunasans->kategori }}({{ $pelunasans->nomor }})=({{ number_format($pelunasans->nominal, 0, ',', '.') }})({{ $pelunasans->tanggal_awal }})
                </span>
                <br>
            </td>
        </tr>
    </table>


    <table width="100%">
        <tr>
            <!-- First column (Nama PT) -->
            <td style="width: 50%;">
                <div class="info-catatan" style="max-width: 230px;">
                    <table>
                        <tr>
                            <td class="info-catatan2" style="font-size: 13px; color:white">.</td>

                        </tr>
                        <tr>
                            <td class="info-text info-left" style="font-size: 13px; color:white">.</td>

                        </tr>
                        <tr>
                            <td class="info-text info-left" style="font-size: 13px; color:white">.</td>

                        </tr>
                        <tr>
                            <td class="info-text info-left" style="font-size: 13px; color:white">.
                            </td>

                        </tr>
                    </table>
                </div>
            </td>
            <!-- Second column (Nama Supplier) -->
            <td style="width: 70%;" style="max-width: 230px;">
                <div class="info-catatan">
                    <hr>
                    <table>
                        <tr>
                            <td class="" style="font-size: 13px;">Potongan penjualan</td>
                            <td class="info-item" style="font-size: 13px;"></td>
                            <td class="info-text info-left" style="font-size: 13px; text-align: right;">
                                @if ($pelunasans->potongan == null)
                                    0
                                @else
                                    {{ number_format($pelunasans->potongan, 0, ',', '.') }}
                                @endif
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="" style="font-size: 13px;">Sisa Tagihan</td>
                            <td class="info-item" style="font-size: 13px;"></td>
                            <td class="info-text info-left" style="font-size: 13px; text-align: right;">
                                {{ number_format($pelunasans->totalpenjualan + $pelunasans->biaya_tambahan - $pelunasans->potongan, 0, ',', '.') }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="" style="font-size: 13px;">
                                <hr>
                            </td>
                            <td class="info-item" style="font-size: 13px;">
                                <hr>
                            </td>
                            <td class="info-text info-left" style="font-size: 13px; text-align: right;">
                                <hr>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="" style="font-size: 13px;">Total Tagihan</td>
                            <td class="info-item" style="font-size: 13px;"></td>
                            <td class="info-text info-left" style="font-size: 13px; text-align: right;">
                                {{ number_format($pelunasans->totalpenjualan + $pelunasans->biaya_tambahan - $pelunasans->potongan, 0, ',', '.') }}
                                </span>
                            </td>
                        </tr>

                        @php
                            $totalDP = 0;
                        @endphp
                        @foreach ($depositpemesanans as $index => $deposit)
                            <tr>
                                <td class="" style="font-size: 13px;">DP
                                    ({{ $deposit->kode_deposit }}
                                    {{ \Carbon\Carbon::parse($deposit->tanggal_transfer)->locale('id')->isoFormat('D MMMM YYYY') }})
                                    </span>
                                </td>
                                <td class="info-item" style="font-size: 13px;"></td>
                                <td class="info-text info-left" style="font-size: 13px; text-align: right;">
                                    {{ number_format($deposit->harga, 0, ',', '.') }}
                                    </span>
                                </td>
                            </tr>
                            @php
                                $totalDP += $deposit->harga;
                            @endphp
                        @endforeach
                        <tr>
                            <td class="" style="font-size: 13px;">Pelunasan</td>
                            <td class="info-item" style="font-size: 13px;"></td>
                            <td class="info-text info-left" style="font-size: 13px; text-align: right;">
                                {{ number_format($pelunasans->nominal, 0, ',', '.') }} </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="" style="font-size: 13px;">
                                <hr>
                            </td>
                            <td class="info-item" style="font-size: 13px;">
                                <hr>
                            </td>
                            <td class="info-text info-left" style="font-size: 13px; text-align: right;">
                                <hr>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="" style="font-size: 13px;">Selisih Tagihan</td>
                            <td class="info-item" style="font-size: 13px;"></td>
                            <td class="info-text info-left" style="font-size: 13px; text-align: right;">
                                {{ number_format($pelunasans->selisih, 0, ',', '.') }}</span>
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>

    @if ($pelunasans->penjualan)
        @if ($pelunasans->penjualan->perintah_kerja->spk->kategori == 'NON PPN')
            <table width="100%">
                <tr>
                    <td>
                        <div class="info-catatan" style="max-width: 400px; font-size: 13px;">
                            <table>
                                <tr>
                                    <td>Nama Bank</td>
                                    <td>:</td>
                                    <td>BCA</td>
                                </tr>
                                <tr>
                                    <td>No. Rekening</td>
                                    <td>:</td>
                                    <td>3629888889</td>
                                </tr>
                                <tr>
                                    <td>Atas Nama</td>
                                    <td>:</td>
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
                        <div class="info-catatan" style="max-width: 400px; font-size: 13px;">
                            <table>
                                <tr>
                                    <td>Nama Bank</td>
                                    <td>:</td>
                                    <td>BCA</td>
                                </tr>
                                <tr>
                                    <td>No. Rekening</td>
                                    <td>:</td>
                                    <td>3611889999</td>
                                </tr>
                                <tr>
                                    <td>Atas Nama</td>
                                    <td>:</td>
                                    <td>CV Tiger Load Engineering</td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
            </table>
        @endif
    @else
        @if ($pelunasans->penjualan->spk->kategori == 'NON PPN')
            <table width="100%">
                <tr>
                    <td>
                        <div class="info-catatan" style="max-width: 400px; font-size: 13px;">
                            <table>
                                <tr>
                                    <td>Nama Bank</td>
                                    <td>:</td>
                                    <td>BCA</td>
                                </tr>
                                <tr>
                                    <td>No. Rekening</td>
                                    <td>:</td>
                                    <td>3629888889</td>
                                </tr>
                                <tr>
                                    <td>Atas Nama</td>
                                    <td>:</td>
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
                        <div class="info-catatan" style="max-width: 400px; font-size: 13px;">
                            <table>
                                <tr>
                                    <td>Nama Bank</td>
                                    <td>:</td>
                                    <td>BCA</td>
                                </tr>
                                <tr>
                                    <td>No. Rekening</td>
                                    <td>:</td>
                                    <td>3611889999</td>
                                </tr>
                                <tr>
                                    <td>Atas Nama</td>
                                    <td>:</td>
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
    <a href="{{ url('admin/tablepelunasanpenjualan') }}" class="blue-button">Kembali</a>
    <a href="{{ url('admin/pelunasan_penjualan/cetak-pdf/' . $pelunasans->id) }}" class="blue-button">Cetak</a>
</div>

</html>
