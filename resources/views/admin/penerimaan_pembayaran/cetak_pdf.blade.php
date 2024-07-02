<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Surat Penerimaan Pembayaran</title>
    <style>
        .b {
            border: 1px solid black;
        }

        html,
        body {
            font-family: 'Times New Roman', Times, serif;
        }

        .center-table {
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            width: 100%;
        }

        .center-table table {
            text-align: center;
            margin: 0 auto;
        }

        .signature-table table {
            margin: 0 20px;
        }

        .label {
            font-size: 13px;
            text-align: center;
            /* Teks menjadi berada di tengah */

        }

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
    </style>
</head>

<body style="margin: 0; padding: 0;">
    <div class="">
        <table>
            <tr>
                <img src="{{ public_path('storage/uploads/gambar_logo/login2.png') }}" style="margin-top:10px"
                    width="150" height="35" alt="Logo Tigerload">
                <td>
                    <div class="center-table" style="margin-left:20px">
                        <table>
                            <tr>
                                <td style="font-weight: bold; font-size:20px">CV. TIGER LOAD ENGINEERING</td>
                            </tr>
                            <tr>
                                <td style="font-size: 15px; font-weight: lighter;">Jl. Ahmad Yani No. 42 Procot Slawi,
                                    Tegal 52411</td>
                            </tr>
                            <tr>
                                <td style="font-size: 15px; font-weight: lighter;">Telp, (0283) 4563746</td>
                            </tr>
                            <tr>
                                <td style="font-size: 15px; font-weight: lighter;">No. Izin Karoseri : 551.25/ 8502</td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <hr>
    <div style="display: flex; justify-content: left; align-items: left; margin-left:20px; margin-top:5px">
    </div>
    <div style="margin-bottom:0px">
        <table width="100%">
            <tr>
                <td style="font-size: 13px;">
                    <span class="info-item">No.{{ $cetakpdf->kode_penerimaan }}</span>
                    <br>
                </td>
                <td style="font-size: 18px; padding-left:40px">
                    <span class="info-item" style="font-weight: bold">TANDA TERIMA PEMBAYARAN</span>
                    <br>
                </td>
                <td style="text-align: right; font-size: 13px;">
                </td>
            </tr>
            <tr>
                <td style="font-size: 13px;">
                </td>
                <td style="font-size: 18px; padding-left:40px">

                </td>
                <td style="text-align: right; font-size: 13px;">
                    <div class="">
                        <table>
                            <tr>
                                <td data-toggle="modal" data-target="#modal-qrcode-{{ $cetakpdf->id }}"
                                    style="display: inline-block;">
                                    {!! DNS2D::getBarcodeHTML("$cetakpdf->qrcode_penerimaan", 'QRCODE', 1.5, 1.5) !!}
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <div style="margin-left: 20px; font-size: 13px;">
        <table>
            <tr>
                <td>Kode Pelanggan</td>
                <td>
                    <div style="margin-left: 70px">
                        :
                    </div>
                </td>
                <td>{{ $cetakpdf->pelanggan->kode_pelanggan }}</td>
            </tr>
            <tr>
                <td>Nama Pelanggan</td>
                <td>
                    <div style="margin-left: 70px">
                        :
                    </div>
                </td>
                <td>{{ $cetakpdf->pelanggan->nama_pelanggan }}</td>
            </tr>
            <tr>
                <td>Tanggal Pembayaran</td>
                <td>
                    <div style="margin-left: 70px">
                        :
                    </div>
                </td>
                <td>{{ \Carbon\Carbon::parse($cetakpdf->tanggal_pembayaran)->locale('id')->isoFormat('D MMMM YYYY') }}
                </td>
            </tr>

            <tr>
                <td>Nominal</td>
                <td>
                    <div style="margin-left: 70px">
                        :
                    </div>
                </td>
                <td>Rp. {{ number_format($cetakpdf->nominal, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Terbilang</td>
                <td>
                    <div style="margin-left: 70px">
                        :
                    </div>
                </td>
                <td>({{ terbilang($cetakpdf->nominal) }} Rupiah) </td>
            </tr>
            <tr>
                <td>Keterangan</td>
                <td>
                    <div style="margin-left: 70px">
                        :
                    </div>
                </td>
                <td>{{ $cetakpdf->keterangan }}</td>
            </tr>
            <?php
            function terbilang($angka)
            {
                $angka = abs($angka); // Pastikan angka selalu positif
                $bilangan = ['', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan', 'Sepuluh', 'Sebelas'];
                $hasil = '';
                if ($angka < 12) {
                    $hasil = $bilangan[$angka];
                } elseif ($angka < 20) {
                    $hasil = terbilang($angka - 10) . ' Belas';
                } elseif ($angka < 100) {
                    $hasil = terbilang($angka / 10) . ' Puluh ' . terbilang($angka % 10);
                } elseif ($angka < 200) {
                    $hasil = 'Seratus ' . terbilang($angka - 100);
                } elseif ($angka < 1000) {
                    $hasil = terbilang($angka / 100) . ' Ratus ' . terbilang($angka % 100);
                } elseif ($angka < 2000) {
                    $hasil = 'Seribu ' . terbilang($angka - 1000);
                } elseif ($angka < 1000000) {
                    $hasil = terbilang($angka / 1000) . ' Ribu ' . terbilang($angka % 1000);
                } elseif ($angka < 1000000000) {
                    $hasil = terbilang($angka / 1000000) . ' Juta ' . terbilang($angka % 1000000);
                } elseif ($angka < 1000000000000) {
                    $hasil = terbilang($angka / 1000000000) . ' Miliar ' . terbilang($angka % 1000000000);
                } elseif ($angka < 1000000000000000) {
                    $hasil = terbilang($angka / 1000000000000) . ' Triliun ' . terbilang($angka % 1000000000000);
                }
                return $hasil;
            }
            ?>
        </table>
    </div>

    <br>
    <br>
    <table width="100%">
        <tr style="font-size: 12px">
            <td style="width: 10%; text-align: left;">
                <table class="tdd" cellpadding="10" cellspacing="0" style="margin: 0 auto;">
                    <tr>
                        <td style="text-align: center;">
                            <table style="margin: 0 auto;">
                                <tr style="text-align: center;">
                                    <td class="label">
                                        <span class="info-item" style="font-size: 13px; padding-right:0px">
                                        </span>
                                        <br>
                                        <span class="info-item"
                                            style="font-size: 13px; padding-right:0px; margin-top:5px">
                                            Penerima,
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="color:white" class="">.</td>
                                </tr>
                                <tr>
                                    <td style="color:white" class="">.</td>
                                </tr>
                                <tr>
                                    <td style="color:white" class="">.</td>
                                </tr>
                                <tr style="text-align: center;">
                                    <table style="margin: 0 auto;">
                                        <tr style="text-align: center; color:white">
                                            <td class="label">{{ auth()->user()->karyawan->nama_lengkap }}</td>
                                        </tr>
                                        <tr>
                                            <td class="separator" colspan="2"><span></span></td>
                                        </tr>
                                        <tr style="text-align: center;">
                                            <td class="label"><span class="info-item"
                                                    style="font-size: 14px; padding-right:0px; font-weight:bold; text-transform: uppercase;">
                                                    CV. TIGER LOAD ENGINEERING
                                                </span></td>
                                        </tr>
                                    </table>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
            <td style="width: 10%; text-align: left;">
                <table class="tdd" cellpadding="10" cellspacing="0" style="margin: 0 auto;">
                    <tr>
                        <td style="text-align: center;">
                            <table style="margin: 0 auto;">
                                <tr style="text-align: center;">
                                    <td class="label">
                                        <span class="info-item" style="font-size: 13px; padding-right:0px">
                                            Tegal,
                                            {{ \Carbon\Carbon::parse($cetakpdf->tanggal_awal)->locale('id')->isoFormat('D MMMM YYYY') }}
                                        </span>
                                        <br>
                                        <span class="info-item"
                                            style="font-size: 13px; padding-right:0px; margin-top:5px">
                                            Pengirim,
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="color:white" class="">.</td>
                                </tr>
                                <tr>
                                    <td style="color:white" class="">.</td>
                                </tr>
                                <tr>
                                    <td style="color:white" class="">.</td>
                                </tr>
                                <tr>
                                    <td style="color:white" class="">.</td>
                                </tr>
                                <tr>
                                    <td class="separator" colspan="2"><span></span></td>
                                </tr>
                                <tr style="text-align: center;">
                                    <td class="label">
                                        <span class="info-item"
                                            style="font-size: 14px; padding-right:0px; font-weight:bold; text-transform: uppercase;">
                                            {{ $cetakpdf->pelanggan->nama_pelanggan }}
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
