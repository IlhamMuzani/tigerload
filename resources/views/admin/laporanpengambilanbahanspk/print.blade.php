<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-11px">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Faktur Ekspedisi Mobil Logistik</title>
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
        <img src="{{ public_path('storage/uploads/gambar_logo/login2.png') }}" width="120px" height="40px"
            alt="Logo Tigerload">
    </div>
    <div style="font-weight: bold; text-align: center">
        <span style="font-weight: bold; font-size: 22px;">PENGAMBILAN BAHAN BAKU - RANGKUMAN</span>
        <br>
        <div class="text">
            @php
                $startDate = request()->query('tanggal_awal');
                $endDate = request()->query('tanggal_akhir');
                $kendaraan = request()->query('kendaraan_id');

            @endphp
            @if ($startDate && $endDate)
                <p>Periode:{{ $startDate }} s/d {{ $endDate }} / Kode SPK :
                    {{ $inquery->first()->spk->kode_spk }}
                </p>
            @else
                <p>Periode: Tidak ada tanggal awal dan akhir yang diteruskan.</p>
            @endif
        </div>
    </div>
    {{-- <hr style="border-top: 0.1px solid black; margin: 1px 0;"> --}}

    </div>
    {{-- <hr style="border-top: 0.1px solid black; margin: 1px 0;"> --}}
    <table style="width: 100%; border-top: 1px solid black;" cellpadding="2" cellspacing="0">
        <!-- Header row -->
        <tr>
            <td class="td" style="text-align: left; padding: 5px; font-weight:bold; font-size: 11px; width:20%">
                Kode Pengambilan</td>
            <td class="td" style="text-align: left; padding: 5px; font-weight:bold; font-size: 11px; width:15%">
                Tanggal
            </td>
            <td class="td" style="text-align: left; padding: 5px; font-weight:bold; font-size: 11px; width:15%">
            </td>
        </tr>
        <tr style="border-bottom: 1px solid black;">
            <td colspan="3" style="padding: 0px;"></td>
        </tr>
        @php
            $created_at = isset($created_at) ? $created_at : null;
            $tanggal_akhir = isset($tanggal_akhir) ? $tanggal_akhir : null;
        @endphp
        @foreach ($inquery as $pengambilan)
            <tr style="background:rgb(181, 181, 181)">
                <td class="td" style="text-align: left; padding: 5px; font-size: 11px;">
                    {{ $pengambilan->kode_pengambilan }}
                </td>
                <td class="td" style="text-align: left; padding: 5px; font-size: 11px;">
                    {{ $pengambilan->tanggal_awal }}
                </td>
                <td class="td" style="text-align: left; padding: 5px; font-size: 11px;">
                    {{ $pengambilan->nama_pelanggan }}
                </td>
            </tr>
            <tr>
                <td class="td" style="text-align: left; padding: 5px; font-size: 11px;">
                    Kode Barang
                </td>
                <td class="td" style="text-align: left; padding: 5px; font-size: 11px;">
                    Nama Barang </td>
                <td class="td" style="text-align: left; padding: 5px; font-size: 11px;">
                    Jumlah
                </td>
            </tr>
            @foreach ($pengambilan->detailpengambilan as $item)
                <tr>
                    <td class="td" style="text-align: left; padding: 5px; font-size: 11px;">
                        {{ $item->kode_barang }}
                    </td>
                    <td class="td" style="text-align: left; padding: 5px; font-size: 11px;">
                        {{ $item->nama_barang }}
                    </td>
                    <td class="td" style="text-align: left; padding: 5px; font-size: 11px;">
                        {{ $item->jumlah }}
                    </td>
                </tr>
            @endforeach
        @endforeach

        <tr style="border-bottom: 1px solid black;">
            <td colspan="3" style="padding: 0px;"></td>
        </tr>

    </table>
    <br>
    <br>

</body>

</html>
