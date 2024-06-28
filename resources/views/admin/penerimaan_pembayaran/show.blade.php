<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Surat Penawaran Karoseri</title>
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


        .container {
            display: flex;
            justify-content: space-between;
            margin-top: 7rem;
            padding: 20px;
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
    </style>
</head>

<body style="margin: 0; padding: 0;">
    <br>
    <br>
    <div class="center-table">
        <table>
            <tr>
                <td>
                    <div>
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
    <div style="display: flex; justify-content: left; align-items: left; margin-left:20px">
    </div>
    <div style="display: flex; justify-content: left; align-items: left; margin-left:20px; margin-top:5px">
    </div>

    <div class="center-table">
        <div style="display: flex; justify-content: center; align-items: center;">
            <table style="text-align: center;">
                <tr>
                    <td style="font-weight: bold; font-size:15px">TANDA TERIMA PEMBAYARAN</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; font-size:15px">No. {{ $pembelian->kode_penerimaan }}</td>
                </tr>
            </table>
        </div>
    </div>
    <br>
    <div style="margin-left: 50px; font-size: 15px;">
        <table>
            <tr>
                <td>Telah diterima dari</td>
                <td>
                    <div style="margin-left: 70px">
                        :
                    </div>
                </td>
                <td>{{ $pembelian->pelanggan->nama_pelanggan }}</td>
            </tr>
            <tr>
                <td>Tanggal Pembayaran</td>
                <td>
                    <div style="margin-left: 70px">
                        :
                    </div>
                </td>
                <td>{{ \Carbon\Carbon::parse($pembelian->tanggal_pembayaran)->locale('id')->isoFormat('D MMMM YYYY') }}</td>
            </tr>

            <tr>
                <td>Nominal</td>
                <td>
                    <div style="margin-left: 70px">
                        :
                    </div>
                </td>
                <td>Rp. {{ number_format($pembelian->nominal, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Terbilang</td>
                <td>
                    <div style="margin-left: 70px">
                        :
                    </div>
                </td>
                <td>({{ terbilang($pembelian->nominal) }} Rupiah) </td>
            </tr>
            <tr>
                <td>Keterangan</td>
                <td>
                    <div style="margin-left: 70px">
                        :
                    </div>
                </td>
                <td>{{ $pembelian->keterangan }}</td>
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
            <td style="width: 30%; text-align: left;">
                <table class="tdd" cellpadding="10" cellspacing="0" style="margin: 0 auto;">
                    <tr>
                        <td style="text-align: center;">
                            <table style="margin: 0 auto;">
                                <tr style="text-align: center;">
                                    <td class="label">
                                        <span class="info-item" style="font-size: 15px; padding-right:0px">
                                            Tegal,
                                            {{ \Carbon\Carbon::parse($pembelian->tanggal_awal)->locale('id')->isoFormat('D MMMM YYYY') }}
                                        </span>
                                        <br>
                                        <span class="info-item"
                                            style="font-size: 15px; padding-right:0px; margin-top:5px">
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
                                    <td style="color:white" class="">.</td>
                                </tr>
                                <tr>
                                <tr>
                                    <td class="separator" colspan="2"><span></span></td>
                                </tr>
                                <tr style="text-align: center;">
                                    <td class="label">
                                        <span class="info-item"
                                            style="font-size: 14px; padding-right:0px; font-weight:bold; text-transform: uppercase;">
                                            CV. TIGER LOAD ENGINEERING
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
            <td style="width: 30%; text-align: left;">
                <table class="tdd" cellpadding="10" cellspacing="0" style="margin: 0 auto;">
                    <tr>
                        <td style="text-align: center;">
                            <table style="margin: 0 auto;">
                                <tr style="text-align: center;">
                                    <td class="label">
                                        <span class="info-item" style="font-size: 15px; padding-right:0px">
                                        </span>
                                        <br>
                                        <span class="info-item"
                                            style="font-size: 15px; padding-right:0px; margin-top:5px">
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
                                            {{ $pembelian->pelanggan->nama_pelanggan }}
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

    <div class="container">
        <a href="{{ url('admin/penerimaan_pembayaran') }}" class="blue-button">Kembali</a>
        <a href="{{ url('admin/penerimaan_pembayaran/cetak-pdf/' . $pembelian->id) }}" class="blue-button">Cetak</a>
    </div>
</body>

</html>
