<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-11px">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pengambilan Bahan Baku</title>
    <style>
        html,
        body {
            font-family: 'DOSVGA', Arial, Helvetica, sans-serif;
            color: black;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .td {
            text-align: center;
            padding: 5px;
            font-size: 11px;
            /* border: 1px solid black; */
        }

        .container {
            position: relative;
            margin-top: 7rem;
        }

        .info-container {
            display: flex;
            justify-content: space-between;
            font-size: 16px;
            margin: 5px 0;
        }

        .info-text {
            text-align: left;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }


        .info-catatan2 {
            font-weight: bold;
            margin-right: 5px;
            min-width: 120px;
            /* Menetapkan lebar minimum untuk kolom pertama */
        }

        .alamat,
        .nama-pt {
            color: black;
        }

        .separator {
            padding-top: 11px;
            text-align: center;
        }

        .separator span {
            display: inline-block;
            border-top: 1px solid black;
            width: 100%;
            position: relative;
            top: -8px;
        }

        @page {
            /* size: A4; */
            margin: 1cm;
        }
    </style>
</head>

<body style="margin: 0; padding: 0;">
    <div id="logo-container">
        <img src="{{ public_path('storage/uploads/gambar_logo/login2.png') }}" width="120" height="30"
            alt="Logo Tigerload">
    </div>
    <div style="font-weight: bold; text-align: center">
        <span style="font-weight: bold; font-size: 22px;">PENGAMBILAN BAHAN BAKU</span>
    </div>
    <br>
    {{-- <hr style="border-top: 0.1px solid black; margin: 1px 0;"> --}}

    </div>
    {{-- <hr style="border-top: 0.1px solid black; margin: 1px 0;"> --}}
    <table style="width: 100%; border-top: 1px solid black;" cellpadding="2" cellspacing="0">
        <!-- Header row -->
        <tr>
            <td class="td" style="text-align: left; padding: 5px; font-weight:bold; font-size: 11px; width:25%">
                Kode Pengambilan</td>
            <td class="td" style="text-align: left; padding: 5px; font-weight:bold; font-size: 11px; width:30%">
                Tanggal
            </td>
            <td class="td" style="text-align: left; padding: 5px; font-weight:bold; font-size: 11px; width:30%">
                Kode SPK</td>
            <td class="td" style="text-align: left; padding: 5px; font-weight:bold; font-size: 11px; width:39%">
                Pelanggan
            </td>
            <td class="td" style="text-align: left; padding: 5px; font-weight:bold; font-size: 11px; width:39%">
                Bentuk Karoseri
            </td>
        </tr>
        <tr style="border-bottom: 1px solid black;">
            <td colspan="5" style="padding: 0px;"></td>
        </tr>
        @foreach ($cetakpdfs as $cetakpdf)
            <tr style="background:rgb(181, 181, 181)">
                <td class="td" style="text-align: left; padding: 5px; font-size: 11px;">
                    {{ $cetakpdf->kode_pengambilan }}
                </td>
                <td class="td" style="text-align: left; padding: 5px; font-size: 11px;">
                    {{ $cetakpdf->tanggal_awal }}
                </td>
                <td class="td" style="text-align: left; padding: 5px; font-size: 11px;">
                    {{ $cetakpdf->perintah_kerja->kode_perintah ?? 'tidak ada' }}
                </td>
                <td class="td" style="text-align: left; padding: 5px; font-size: 11px;">
                    {{ $cetakpdf->perintah_kerja->spk->nama_pelanggan ?? 'tidak ada' }}
                </td>
                <td class="td" style="text-align: left; padding: 5px; font-size: 11px;">
                    {{ $cetakpdf->perintah_kerja->spk->typekaroseri->nama_karoseri ?? 'tidak ada' }}
                </td>
            </tr>
            <tr>
                <td class="td" style="text-align: left; padding: 5px; font-size: 11px; font-weight:bold">
                    Kode Barang
                </td>
                <td class="td" style="text-align: left; padding: 5px; font-size: 11px; font-weight:bold">
                    Nama Barang
                </td>
                <td class="td" style="text-align: right; padding: 5px; font-size: 11px; font-weight:bold">
                    Qty
                </td>
            </tr>
            @foreach ($cetakpdf->detailpengambilan as $item)
                <tr>
                    <td class="td" style="text-align: left; padding: 5px; font-size: 11px;">
                        {{ $item->kode_barang }}
                    </td>
                    <td class="td" style="text-align: left; padding: 5px; font-size: 11px;">
                        {{ $item->nama_barang }}
                    </td>
                    <td class="td" style="text-align: right; padding: 5px; font-size: 11px;">
                        {{ $item->jumlah }}
                    </td>
                </tr>
            @endforeach
        @endforeach

        <tr style="border-bottom: 1px solid black;">
            <td colspan="" style="padding: 0px;"></td>
        </tr>
        <tr>
            <td colspan="4" style="text-align: right; font-weight: bold; padding: 5px; font-size: 11px;">
                {{-- Sub Total --}}
            </td>
            <td style="text-align: right; font-weight: bold; padding: 5px; font-size: 11px;">
                {{-- {{ number_format($total, 0, ',', '.') }} --}}
            </td>
        </tr>
    </table>

    <div style="text-align: right; font-size:11px">
        <span style="font-style: italic;">Printed Date
            {{ \Carbon\Carbon::now()->format('Y-m-d H:i:s') }}</span>
    </div>
</body>

</html>
