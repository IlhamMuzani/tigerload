<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice Faktur Pajak</title>
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
            margin: 20px;
            font-family: 'DOSVGA', monospace;
            color: black;
        }

        span.h2 {
            font-size: 15px;
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
            font-size: 13px;
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

        #logo-container {
            text-align: right;
            /* Posisi teks dan gambar ke kanan */
        }

        #logo-container img {
            max-width: 170px;
            /* Ubah sesuai kebutuhan */
            vertical-align: top;
            /* Mengatur gambar lebih tinggi ke atas */
        }

        .info-1 {}
    </style>
</head>

<body style="margin: 0; padding: 0;">
    <table width="100%">
        <td style="text-align: left;">
            <img src="{{ asset('storage/uploads/gambar_logo/login2.png') }}" width="120" height="30"
                alt="Logo Tigerload">
        </td>
    </table>

    <table cellpadding="2" cellspacing="0">
        <tr>
            <td class="info-catatan2">CV. TIGER LOAD</td>
            <td class="info-catatan2" style=" margin-left: 40px; display: block;">Nama Supplier</td>
            <td style="text-align: left;">
                <span class="content2">
                    {{ $cetakpdf->pembelian->supplier->nama_supp }}
                </span>
                <br>
            </td>
        </tr>
        <tr>
            <td class="info-text info-left" style="">Jl. Ahmad Yani No. 42 Procot Slawi,
            </td>
            </td>
            <td class="info-catatan2" style=" margin-left: 40px; display: block;">Alamat</td>
            <td style="text-align: left; ">
                <span class="content2">
                    {{ $cetakpdf->pembelian->supplier->alamat }} </span>
                <br>
            </td>
        </tr>
        <tr>
            <td class="info-text info-left" style="">Tegal 52411
            </td>
            <td class="info-catatan2" style=" margin-left: 40px; display: block;">Telp / Hp</td>
            <td style="text-align: left; ">
                <span class="content2">
                    {{ $cetakpdf->pembelian->supplier->telp }}
                </span>
                <br>
            </td>
        </tr>
        <tr>
            <td class="info-text info-left" style="">Telp, (0283) 4563746
            </td>
            <td class="info-catatan2" style=" margin-left: 40px; display: block;">ID Supplier</td>

            <td style="text-align: left; ">
                <span class="content2">
                    {{ $cetakpdf->pembelian->supplier->kode_supplier }} </span>
                <br>
            </td>
        </tr>
    </table>

    <br><br>


    <hr style="border-top: 0.5px solid black; margin: 3px 0; ">

    <table style="font-size:13px" width="100%">
        <tr>
            <td>
                <span class="info-item">No. Faktur: {{ $cetakpdf->kode_pajak }}</span>
                <br>
            </td>
            <td style="text-align: right;">
                {{-- <span class="info-item">Tanggal:{{ now()->format('d-m-Y') }}</span> --}}
                <span class="info-item">Tanggal:{{ $cetakpdf->tanggal }}</span>
                <br>
            </td>
        </tr>
    </table>
    <hr style="border-top: 0.5px solid black; margin: 3px 0;">
    <div style="font-weight: bold; text-align: center">
        <span style="font-weight: bold; font-size: 22px;">FOTO BUKTI PAJAK</span>
        <br>
        <br>
    </div>
    <table width="100%">
        <tr>
            <td style="width: 100%; text-align: center;">
                <div style="width: 100%;">
                    <img src="{{ asset('storage/uploads/' . $cetakpdf->gambar_pajak) }}"
                        alt="{{ $cetakpdf->gambar_pajak }}" style="width: 100%; height: auto; max-width: 100%;"
                        alt="Logo Tigerload">
                </div>
            </td>
        </tr>
    </table>
    <br>
</body>

</html>
