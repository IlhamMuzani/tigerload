<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Surat Perintah Kerja</title>
    <style>
        /* * {
            border: 1px solid black;
        } */
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
            margin: 40px;
            padding: 10px;
        }

        span.h2 {
            font-size: 24px;
            font-weight: 500;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
        }

        .tdd td {
            border: none;
        }

        .faktur {
            text-align: center
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

        .nama-pt {
            color: black;
            font-weight: bold;
        }

        .alamat {
            color: black;
            font-weight: bold;
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
            font-size: 15px;
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

        .label {
            font-size: 15px;
            text-align: center;
            /* Teks menjadi berada di tengah */

        }

        .separator {
            padding-top: 25px;
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
    </style>
</head>

<body style="margin: 0; padding: 0;">
    <div id="logo-container">
        <img src="{{ asset('storage/uploads/gambar_logo/login2.png') }}" width="120" height="30"
            alt="Logo Tigerload">
    </div>
    <br>
    <div style="font-weight: bold; text-align: center">
        <span style="font-weight: bold; font-size: 25px;">SURAT PERINTAH KERJA</span>
        <br>
        <br>
    </div>
    <hr style="border-top: 0.5px solid black; margin: 3px 0;">
    <div style="font-size: 25px; font-weight:bold">
        Nomor Project : {{ $inquery->kode_perintah }}
    </div>
    <br>
    <br>
    <table width="100%">
        <tr>
            <td style="width:70%;">
                <table>
                    <div style="font-size: 25px; font-weight:bold">Pelanggan</div>
                    <br>
                    <tr>
                        <td class="info-column">
                            <span class="info-item" style="font-size: 15px;">Nomor Pesanan</span>
                        </td>
                        <td class="info-column">
                            <span class="info-titik" style="font-size: 15px;">:</span>
                        </td>
                        <td class="info-column">
                            <span class="info-item" style="font-size: 15px;">{{ $inquery->spk->kode_spk }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="info-column">
                            <span class="info-item" style="font-size: 15px;">Kode Pelanggan</span>
                        </td>
                        <td class="info-column">
                            <span class="info-titik" style="font-size: 15px;">:</span>
                        </td>
                        <td class="info-column">
                            <span class="info-item"
                                style="font-size: 15px;">{{ $inquery->pelanggan->kode_pelanggan }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="info-column">
                            <span class="info-item" style="font-size: 15px;">Nama Pelanggan</span>
                        </td>
                        <td class="info-column">
                            <span class="info-titik" style="font-size: 15px;">:</span>
                        </td>
                        <td class="info-column">
                            <span class="info-item"
                                style="font-size: 15px;">{{ $inquery->pelanggan->nama_pelanggan }}</span>
                        </td>
                    </tr>
                </table>
            </td>

            <td style="width: 50%; text-align: left;">
                <table style="width: 100%; margin-top:4px">
                    <div style="font-size: 25px; font-weight:bold">Type Karoseri</div>
                    <br>
                    <tr>
                        <td style="width: 40%;">
                            <span class="info-item"
                                style="font-size: 15px; text-align: left; display: inline-block;">Kode Type
                                Karoseri</span>
                        </td>
                        <td style="width: 60%;">
                            <span class="info-item" style="font-size: 15px; text-align: left; display: inline-block;">:
                                {{ $inquery->typekaroseri->kode_type }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 40%;">
                            <span class="info-item"
                                style="font-size: 15px; text-align: left; display: inline-block;">Bentuk Karoseri</span>
                        </td>
                        <td style="width: 60%;">
                            <span class="info-item" style="font-size: 15px; text-align: left; display: inline-block;">:
                                {{ $inquery->typekaroseri->nama_karoseri }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 40%;">
                            <span class="info-item"
                                style="font-size: 15px; text-align: left; display: inline-block;">Merek / Type</span>
                        </td>
                        <td style="width: 60%;">
                            <span class="info-item" style="font-size: 15px; text-align: left; display: inline-block;">:
                                {{ $inquery->typekaroseri->merek->nama_merek }} /
                                {{ $inquery->typekaroseri->merek->tipe->nama_tipe }}
                            </span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <br>
            </td>
        </tr>
        <tr>
            <td style="width:70%;">
                <table>
                    <div style="font-size: 25px; font-weight:bold">Spesifikasi</div>
                    <br>
                    <div>
                        @foreach ($spesifikasis as $key => $item)
                            <span class="info-item" style="font-size: 15px; text-align: left; display: inline-block;">:
                                - {{ $item->nama }} {{ $item->jumlah }}
                            </span>
                            <br>
                        @endforeach
                        <span class="info-item" style="font-size: 15px; text-align: left; display: inline-block;">:
                            - Warna {{ $inquery->spk->warna }}
                        </span>
                    </div>
                </table>
            </td>

            <td style="width: 50%; text-align: left;">
                <table style="width: 100%; margin-top:4px">
                    <div style="font-size: 25px; font-weight:bold">Dimensi</div>
                    <br>
                    <tr>
                        <td style="width: 40%;">
                            <span class="info-item"
                                style="font-size: 15px; text-align: left; display: inline-block;">Panjang
                            </span>
                        </td>
                        <td style="width: 60%;">
                            <span class="info-item" style="font-size: 15px; text-align: left; display: inline-block;">:
                                {{ $inquery->typekaroseri->panjang }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 40%;">
                            <span class="info-item"
                                style="font-size: 15px; text-align: left; display: inline-block;">Lebar</span>
                        </td>
                        <td style="width: 60%;">
                            <span class="info-item" style="font-size: 15px; text-align: left; display: inline-block;">:
                                {{ $inquery->typekaroseri->lebar }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 40%;">
                            <span class="info-item"
                                style="font-size: 15px; text-align: left; display: inline-block;">Tinggi</span>
                        </td>
                        <td style="width: 60%;">
                            <span class="info-item" style="font-size: 15px; text-align: left; display: inline-block;">:
                                {{ $inquery->typekaroseri->tinggi }}
                            </span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <br>
    <div style="font-size: 25px; font-weight:bold">GAMBAR SKRB</div>
    <br>
    <table width="100%">
        <tr>
            <td style="width: 100%; text-align: center;">
                <div style="width: 100%;">
                    <img src="{{ asset('storage/uploads/' . $inquery->typekaroseri->gambar_skrb) }}"
                        alt="{{ $inquery->typekaroseri->nama_karoseri }}"
                        style="width: 100%; height: auto; max-width: 100%;" alt="Logo Tigerload">
                </div>
            </td>
        </tr>
    </table>
    <br>
    <br>
    <div style="font-size: 25px; font-weight:bold">Komponen Bahan Baku</div>
    <br>
    <table style="width: 100%; border-top: 1px solid black;" cellpadding="2" cellspacing="0">
        <tr>
            <td class="td" style="text-align: center; padding: 5px; font-size: 15px;">No.</td>
            <td class="td" style="text-align: left; padding: 5px; font-size: 15px;">Kode Barang</td>
            <td class="td" style="text-align: left; padding: 5px; font-size: 15px;">Nama Barang</td>
            <td class="td" style="text-align: right; padding: 5px; font-size: 15px;">Qty</td>
        </tr>
        <tr style="border-bottom: 1px solid black;">
            <td colspan="6" style="padding: 0px;"></td>
        </tr>
        @foreach ($parts as $item)
            <tr>
                <td class="td" style="text-align: center;  font-size: 15px;">{{ $loop->iteration }}
                </td>
                <td class="td" style="text-align: left;  font-size: 15px;">{{ $item->kode_barang }}</td>
                <td class="info-text info-left" style="font-size: 15px; text-align: left;">
                    {{ $item->nama_barang }}
                </td>
                <td class="td" style="text-align: right; font-size: 15px;">
                    {{ $item->jumlah }}
                </td>
            </tr>
        @endforeach
        <tr style="border-bottom: 1px solid black;">
            <td colspan="6" style="padding: 0px;"></td>
        </tr>
    </table>
    {{-- <table class="tdd" cellpadding="10" cellspacing="0">
        <tr>
            <td>
                <table>
                    <tr>
                        <td class="label">
                            @if ($inquery->user)
                                {{ $inquery->user->karyawan->nama_lengkap }}
                            @else
                                user tidak ada
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="separator" colspan="2"><span></span></td>
                    </tr>
                    <tr>
                        <td class="label">Operasional</td>
                    </tr>
                </table>
            </td>
            <td>
                <table>
                    <tr>
                        <td class="label">.</td>
                    </tr>
                    <tr>
                        <td class="separator" colspan="2"><span></span></td>
                    </tr>
                    <tr>
                        <td class="label">SPV Ban</td>
                    </tr>
                </table>
            </td>
            <td>
                <table>
                    <tr>
                        <td class="label">.</td>
                    </tr>
                    <tr>
                        <td class="separator" colspan="2"><span></span></td>
                    </tr>
                    <tr>
                        <td class="label">Accounting</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table> --}}
</body>

<div class="container">
    <a href="{{ url('admin/perintah_kerja') }}" class="blue-button">Kembali</a>
    <a href="{{ url('admin/perintah_kerja/cetak-pdf/' . $inquery->id) }}" class="blue-button">Cetak</a>
</div>

</html>
