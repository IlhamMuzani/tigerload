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
                                @if ($inquery->perintah_kerja)
                                    {{ $inquery->perintah_kerja->kode_perintah }}
                                @else
                                    tidak ada
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="info-catatan2" style="font-size: 13px;">Nama Pelanggan</td>
                            <td class="info-item" style="font-size: 13px;">:</td>
                            <td class="info-text info-left" style="font-size: 13px;">
                                @if ($inquery->perintah_kerja)
                                    {{ $inquery->perintah_kerja->pelanggan->nama_pelanggan }}
                                @else
                                    tidak ada
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="info-catatan2" style="font-size: 13px;">Type Karoseri</td>
                            <td class="info-item" style="font-size: 13px;">:</td>
                            <td class="info-text info-left" style="font-size: 13px;">
                                @if ($inquery->perintah_kerja)
                                    {{ $inquery->perintah_kerja->typekaroseri->nama_karoseri }}
                                @else
                                    tidak ada
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="info-catatan2" style="font-size: 13px; color:white">Type Karoseri</td>
                            <td class="info-item" style="font-size: 13px; color:white">:</td>
                            <td class="info-text info-left" style="font-size: 13px; color:white">
                                @if ($inquery->perintah_kerja)
                                    {{ $inquery->perintah_kerja->typekaroseri->kode_type }}
                                @else
                                    tidak ada
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>
    <br>
    <div style="font-weight: bold; text-align: center;">
        <span style="font-weight: bold; font-size: 20px;">DOKUMEN PROJECT</span>
        <br>
    </div>
    <br>
    <table style="width: 100%; border-top: 1px solid black; margin-bottom:5px">
        <tr>
            <td>
                <span class="info-item" style="font-size: 15px; padding-left: 5px;">No. Dokumen:
                    {{ $inquery->kode_dokumen }}</span>
                <br>
            </td>
            <td style="text-align: right; padding-right: 45px;">
                <span class="info-item" style="font-size: 15px;">Tanggal:{{ $inquery->tanggal_awal }}</span>
                <br>
            </td>
        </tr>
    </table>
    <br>

    <table style="width: 100%; margin-bottom:5px">
        <tr>
            <td style="width: 50%; text-align: center;">
                <div style="width: 100%;">
                    <p>Foto Depan</p>
                </div>
            </td>
            <td style="width: 50%; text-align: center;">
                <div style="width: 100%;">
                    <p>Foto Belakang</p>
                </div>
            </td>
        </tr>
        <tr>
            <td style="width: 50%; text-align: center;">
                <div style="width: 100%;">
                    <img src="{{ asset('storage/uploads/' . $inquery->gambar_depan) }}"
                        alt="{{ $inquery->gambar_depan }}" style="width: 100%; height: auto; max-width: 100%;"
                        alt="Logo Tigerload">
                </div>
            </td>
            <td style="width: 50%; text-align: center;">
                <div style="width: 100%;">
                    <img src="{{ asset('storage/uploads/' . $inquery->gambar_belakang) }}"
                        alt="{{ $inquery->gambar_belakang }}" style="width: 100%; height: auto; max-width: 100%;"
                        alt="Logo Tigerload">
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <br>
            </td>
        </tr>
        <tr>
            <td style="width: 50%; text-align: center;">
                <div style="width: 100%;">
                    <p>Foto Kanan</p>
                </div>
            </td>
            <td style="width: 50%; text-align: center;">
                <div style="width: 100%;">
                    <p>Foto Kiri</p>
                </div>
            </td>
        </tr>
        <tr>
            <td style="width: 50%; text-align: center;">
                <div style="width: 100%;">
                    <img src="{{ asset('storage/uploads/' . $inquery->gambar_kanan) }}"
                        alt="{{ $inquery->gambar_kanan }}" style="width: 100%; height: auto; max-width: 100%;"
                        alt="Logo Tigerload">
                </div>
            </td>
            <td style="width: 50%; text-align: center;">
                <div style="width: 100%;">
                    <img src="{{ asset('storage/uploads/' . $inquery->gambar_kiri) }}"
                        alt="{{ $inquery->gambar_kiri }}" style="width: 100%; height: auto; max-width: 100%;"
                        alt="Logo Tigerload">
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <br>
            </td>
        </tr>
        <tr>
            <td style="width: 50%; text-align: center;">
                <div style="width: 100%;">
                    <p>Foto Depan Serong Kanan</p>
                </div>
            </td>
            <td style="width: 50%; text-align: center;">
                <div style="width: 100%;">
                    <p>Foto Depan Serong Kiri</p>
                </div>
            </td>
        </tr>
        <tr>
            <td style="width: 50%; text-align: center;">
                <div style="width: 100%;">
                    <img src="{{ asset('storage/uploads/' . $inquery->gambardepan_serongkanan) }}"
                        alt="{{ $inquery->gambardepan_serongkanan }}"
                        style="width: 100%; height: auto; max-width: 100%;" alt="Logo Tigerload">
                </div>
            </td>
            <td style="width: 50%; text-align: center;">
                <div style="width: 100%;">
                    <img src="{{ asset('storage/uploads/' . $inquery->gambardepan_serongkiri) }}"
                        alt="{{ $inquery->gambardepan_serongkiri }}"
                        style="width: 100%; height: auto; max-width: 100%;" alt="Logo Tigerload">
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <br>
            </td>
        </tr>
        <tr>
            <td style="width: 50%; text-align: center;">
                <div style="width: 100%;">
                    <p>Foto Belakang Serong Kanan</p>
                </div>
            </td>
            <td style="width: 50%; text-align: center;">
                <div style="width: 100%;">
                    <p>Foto Belakang Serong Kiri</p>
                </div>
            </td>
        </tr>
        <tr>
            <td style="width: 50%; text-align: center;">
                <div style="width: 100%;">
                    <img src="{{ asset('storage/uploads/' . $inquery->gambarbelakang_serongkanan) }}"
                        alt="{{ $inquery->gambarbelakang_serongkanan }}"
                        style="width: 100%; height: auto; max-width: 100%;" alt="Logo Tigerload">
                </div>
            </td>
            <td style="width: 50%; text-align: center;">
                <div style="width: 100%;">
                    <img src="{{ asset('storage/uploads/' . $inquery->gambarbelakang_serongkekiri) }}"
                        alt="{{ $inquery->gambarbelakang_serongkekiri }}"
                        style="width: 100%; height: auto; max-width: 100%;" alt="Logo Tigerload">
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <br>
            </td>
        </tr>
        <tr>
            <td style="width: 50%; text-align: center;">
                <div style="width: 100%;">
                    <p>Foto Gesekan Nomor Mesin Dan Rangka</p>
                </div>
            </td>
            <td style="width: 50%; text-align: center;">
                <div style="width: 100%;">
                    <p>Foto Faktur</p>
                </div>
            </td>
        </tr>
        <tr>
            <td style="width: 50%; text-align: center;">
                <div style="width: 100%;">
                    <img src="{{ asset('storage/uploads/' . $inquery->gambar_gesekannomesin) }}"
                        alt="{{ $inquery->gambar_gesekannomesin }}"
                        style="width: 100%; height: auto; max-width: 100%;" alt="Logo Tigerload">
                </div>
            </td>
            <td style="width: 50%; text-align: center;">
                <div style="width: 100%;">
                    <img src="{{ asset('storage/uploads/' . $inquery->gambar_faktur) }}"
                        alt="{{ $inquery->gambar_faktur }}" style="width: 100%; height: auto; max-width: 100%;"
                        alt="Logo Tigerload">
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <br>
            </td>
        </tr>
        <tr>
            <td style="width: 50%; text-align: center;">
                <div style="width: 100%;">
                    <p>Foto Serut</p>
                </div>
            </td>
            <td style="width: 50%; text-align: center;">
                <div style="width: 100%;">
                    <p>Foto Berita Acara</p>
                </div>
            </td>
        </tr>
        <tr>
            <td style="width: 50%; text-align: center;">
                <div style="width: 100%;">
                    <img src="{{ asset('storage/uploads/' . $inquery->gambar_serut) }}"
                        alt="{{ $inquery->gambar_serut }}" style="width: 100%; height: auto; max-width: 100%;"
                        alt="Logo Tigerload">
                </div>
            </td>
            <td style="width: 50%; text-align: center;">
                <div style="width: 100%;">
                    <img src="{{ asset('storage/uploads/' . $inquery->gambarberita_acara) }}"
                        alt="{{ $inquery->gambarberita_acara }}" style="width: 100%; height: auto; max-width: 100%;"
                        alt="Logo Tigerload">
                </div>
            </td>
        </tr>
    </table>
    <br>
    <br>
    <div style="font-size: 15px;">Gambar Rancang Bangun</div>
    <table width="100%">
        <tr>
            <td style="width: 100%; text-align: center;">
                <div style="width: 100%;">
                    <img src="{{ asset('storage/uploads/' . $inquery->gambar_rancangbangun) }}"
                        alt="{{ $inquery->gambar_rancangbangun }}"
                        style="width: 100%; height: auto; max-width: 100%;" alt="Logo Tigerload">
                </div>
            </td>
        </tr>
    </table>
</body>
<div class="container">
    <a href="{{ url('admin/list_dokument') }}" class="blue-button">Kembali</a>
    <a href="{{ url('admin/list_dokument/cetak-pdf/' . $inquery->id) }}" class="blue-button">Cetak</a>
</div>

</html>
