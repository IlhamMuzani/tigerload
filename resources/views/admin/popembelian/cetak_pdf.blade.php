<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PO Pembelian</title>
    <style>
        html,
        body {
            font-family: Arial, sans-serif;
            color: black;
            /* Gunakan Arial atau font sans-serif lainnya yang mudah dibaca */
            /* margin: 40px; */
            margin-top:10px;
            margin-left: 20px;
            margin-right: 20px;
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
    </style>
</head>

<body style="margin: 0; padding: 0;">
    <table width="100%">
        <tr>
            <!-- First column (Nama PT) -->
            <td style="width:0%;">
            </td>
            <td style="width: 70%; text-align: right;">
                <img src="{{ public_path('storage/uploads/gambar_logo/login2.png') }}" width="120" height="30"
                    alt="Logo Tigerload">
            </td>
        </tr>
    </table>
    <div style="text-align: center;">
        <span style="font-weight: bold; font-size: 20px;">CV. TIGER LOAD ENGINEERING</span>
        <br>
        <span style=" font-size: 13px;">Jl. Ahmad Yani No. 42 Procot Slawi, <br>
            Tegal 52411</span>
        <br>
        <span style=" font-size: 13px;">Telp, (0283) 4563746</span>
    </div>
    <hr style="border: 1px solid;">
    <div style="text-align: center;">
        <span style="font-weight: bold; font-size: 18px; text-decoration: underline;">PURCHASE ORDER</span>
    </div>
    <table style="width: 100%; margin-bottom:5px">
        <tr>
            <td>
                <span class="info-item" style="font-size: 13px; padding-left: 0px;">No:
                    {{ $pembelians->kode_po_pembelian }}</span>
                <br>
            </td>
            <td style="text-align: right; padding-right: 45px;">
                <span class="info-item" style="font-size: 13px;">Tegal, {{ $pembelians->tanggal }}</span>
                <br>
            </td>
        </tr>
    </table>

    <div style="display: flex; justify-content: left; align-items: left; margin-top:20px">
        <table style="text-align: letf;">
            <tr>
                <td style="font-size: 13px; font-weight: lighter;">Kepada Yth,</td>
            </tr>
            <tr>
                <td style="font-size: 13px; font-weight: lighter; font-weight:bold">
                    {{ $pembelians->supplier->nama_supp }}</td>
            </tr>
            <tr>
                <td style="font-size: 13px; font-weight: lighter; max-width: 200px; word-wrap: break-word;">
                    {{ $pembelians->supplier->alamat }}
                </td>
            </tr>

        </table>
    </div>

    <div style="display: flex; justify-content: left; align-items: left; margin-top:30px">
        <table style="text-align: letf;">
            <tr>
                <td style="font-size: 13px; font-weight: lighter;">Dengan Hormat,</td>
            </tr>
        </table>
    </div>

    <div style="display: flex; justify-content: left; align-items: left; margin-top:30px">
        <table style="text-align: letf;">
            <tr>
                <td style="font-size: 13px; font-weight: lighter;"> Dengan ini CV. Tiger Load engineering bermaksud
                    untuk memesan barang dengan spesifikasi berikut :</td>
            </tr>
        </table>
    </div>

    <table style="width: 100%; border-collapse: collapse; margin-top:10px" cellpadding="2" cellspacing="0"
        border="1">
        <tr>
            <td class="td" style="text-align: left; padding: 5px; font-size: 13px; border: 1px solid black;">No.
            </td>
            <td class="td" style="text-align: left; padding: 5px; font-size: 13px; border: 1px solid black;">Kode
                Barang</td>
            <td class="td" style="text-align: left; padding: 5px; font-size: 13px; border: 1px solid black;">Nama
                Barang</td>
            {{-- <td class="td" style="text-align: left; padding: 5px; font-size: 13px; border: 1px solid black;">Harga
            </td> --}}
            <td class="td"
                style="text-align: right; padding-right: 10px; font-size: 13px; border: 1px solid black;">Qty
            </td>
            <td class="td" style="text-align: left; padding: 5px; font-size: 13px; border: 1px solid black;">Satuan
            </td>
            {{-- 
            <td class="td" style="text-align: left; padding: 5px; font-size: 13px; border: 1px solid black;">Total
            </td> --}}
        </tr>
        {{-- <tr style="border-bottom: 0.1px solid black;">
            <td colspan="5" style="padding: 0px;"></td>
        </tr> --}}
        @php
            $grandTotal = 0;
        @endphp
        @foreach ($parts as $item)
            <tr>
                <td class="td" style="text-align: left; font-size: 13px; border: 1px solid black;">
                    {{ $loop->iteration }}</td>
                <td class="td" style="text-align: left; font-size: 13px; border: 1px solid black;">
                    {{ $item->kode_barang }}</td>
                <td class="td" style="text-align: left; font-size: 13px; border: 1px solid black;">
                    {{ $item->nama_barang }}</td>
                {{-- <td class="info-text info-left" style="font-size: 13px; text-align: left; border: 1px solid black;">
                    {{ number_format($item->harga, 0, ',', '.') }}
                </td> --}}
                <td class="td"
                    style="text-align: right; font-size: 13px; border: 1px solid black; padding-right:10px">
                    {{ $item->jumlah }}</td>
                <td class="td" style="text-align: left; font-size: 13px; border: 1px solid black;">
                    {{ $item->satuan->kode_satuan ?? null }}</td>
                {{--
                <td class="td" style="text-align: left; font-size: 13px; border: 1px solid black;">
                    Rp.{{ number_format($item->total, 0, ',', '.') }}</td> --}}
            </tr>
            @php
                $grandTotal += $item->total;
            @endphp
        @endforeach
        {{-- <tr style="border-bottom: 0.1px solid black;">
            <td colspan="5" style="padding: 0px;"></td>
        </tr> --}}
        {{-- <tr>
            <td colspan="6"
                style="text-align: right; font-weight: bold; padding: 5px; font-size: 13px; border: 1px solid black;">
                Sub Total</td>
            <td class="td"
                style="text-align: left; font-weight: bold; padding: 5px; font-size: 13px; border: 1px solid black;">
                Rp.{{ number_format($grandTotal, 0, ',', '.') }}</td>
        </tr> --}}
    </table>

    <div>
        <p style="font-size: 13px; text-align: left;">Demikian purchase order dari kami, atas perhatian dan kerjasamanya
            kami ucapkan terimakasih.</p>
    </div>

    <div>
        <p style="font-size: 13px; text-align: left;">Hormat Kami,</p>
        <p style="font-size: 13px; text-align: left; font-weight:bold">CV. Tiger Load Engineering</p>
        <br>
        <br>
        <br>
        <br>
        <p style="font-size: 13px; text-align: left; text-decoration: underline;">Djohan Wahyudi</p>
        <p style="font-size: 13px; text-align: left;">Direktur</p>
    </div>
</body>

</html>
