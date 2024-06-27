<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice Deposit</title>
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
            margin: 10px;
            padding: 10px;
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif
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
    <table cellpadding="2" cellspacing="0">
        <tr>
            <td class="info-catatan2">CV. TIGER LOAD</td>
            <td class="info-catatan2" style=" margin-left: 40px; display: block;">Nama Pelanggan</td>
            <td style="text-align: left;">
                <span class="content2">
                    {{ $deposits->spk->pelanggan->nama_pelanggan }}
                </span>
                <br>
            </td>
        </tr>
        <tr>
            <td class="info-text info-left" style="">Jl. Ahmad Yani No. 42 Procot Slawi,
                {{-- <br>
                SLAWI TEGAL <br>
                Telp/ Fax 02836195326 02836195187 --}}
            </td>
            </td>
            <td class="info-catatan2" style=" margin-left: 40px; display: block;">Alamat</td>
            <td style="text-align: left; ">
                <span class="content2">
                    {{ $deposits->spk->pelanggan->alamat }} </span>
                <br>
            </td>
        </tr>
        <tr>
            <td class="info-text info-left" style="">Tegal 52411
            </td>
            <td class="info-catatan2" style=" margin-left: 40px; display: block;">Telp / Hp</td>
            <td style="text-align: left; ">
                <span class="content2">
                    {{ $deposits->spk->pelanggan->telp }}
                </span>
                <br>
            </td>
        </tr>
        <tr>
            <td class="info-text info-left" style="">Telp, (0283) 4563746
            </td>
            <td class="info-catatan2" style=" margin-left: 40px; display: block;">ID Pelanggan</td>

            <td style="text-align: left; ">
                <span class="content2">
                    {{ $deposits->spk->pelanggan->kode_pelanggan }} </span>
                <br>
            </td>
        </tr>
    </table>

    <br><br>

    <div style="font-weight: bold; text-align: center">
        <span style="font-weight: bold; font-size: 22px;">FAKTUR DEPOSIT PEMESANAN</span>
        <br>
        <br>
    </div>
    <hr style="border-top: 0.5px solid black; margin: 3px 0;">
    <table width="100%">
        <tr>
            <td>
                <span class="info-item">No. Faktur: {{ $deposits->kode_deposit }}</span>
                <br>
            </td>
            <td style="text-align: right;">
                {{-- <span class="info-item">Tanggal:{{ now()->format('d-m-Y') }}</span> --}}
                <span class="info-item">Tanggal:{{ $deposits->tanggal }}</span>
                <br>
            </td>
        </tr>
    </table>
    <hr style="border-top: 0.5px solid black; margin: 3px 0;">
    <table style="width: 100%;" cellpadding="2" cellspacing="0">
        <tr>
            <td class="td" style="text-align: center; padding: 0px;">No.</td>
            <td class="td" style="text-align: center; padding: 2px;">Kode SPK</td>
            <td class="td" style="text-align: center; padding: 2px;">Nama Pelanggan</td>
            <td class="td" style="text-align: center; padding: 2px;">Merek Kendaraan</td>
            <td class="td" style="text-align: center; padding: 2px;">Type Kendaraan</td>
            <td class="td" style="text-align: center; padding: 2px;">Kode Karoseri</td>
            <td class="td" style="text-align: center; padding: 2px;">Bentuk Karoseri</td>
            <td class="td" style="text-align: center; padding: 2px;">DP</td>
        </tr>
        <tr style="border-bottom: 1px solid black;">
            <td colspan="4" style="padding: 0px;">
            </td>
        </tr>
        {{-- @php
            $totalHarga = $deposits->harga + $deposits->vi_marketing;
        @endphp --}}
        {{-- @foreach ($kendaraans as $item) --}}
        <tr>
            <td class="td" style="text-align: center; padding: 0px;">1</td>
            <td class="td" style="text-align: center; padding: 2px;">
                {{ $deposits->spk->kode_spk }}
            </td>
            <td class="td" style="text-align: center; padding: 2px;">
                {{ $deposits->spk->pelanggan->nama_pelanggan }}
            </td>
            <td class="td" style="text-align: center; padding: 2px;">
                {{ $deposits->spk->detail_kendaraan->first()->merek->nama_merek }}
            </td>
            <td class="td" style="text-align: center; padding: 2px;">
                {{ $deposits->spk->detail_kendaraan->first()->merek->tipe->nama_tipe }}
            </td>
            <td class="td" style="text-align: center; padding: 2px;">
                {{ $deposits->spk->typekaroseri->kode_type }}
            </td>
            <td class="td" style="text-align: center; padding: 2px;">
                {{ $deposits->spk->typekaroseri->nama_karoseri }}
            </td>
            <td class="td" style="text-align: center; padding: 2px;">Rp
                {{ number_format($deposits->harga, 0, ',', '.') }}
            </td>
        </tr>

        @php
            $startFrom = 2;
            $totalSubtotal = $deposits->spk->harga; // Inisialisasi dengan harga awal
        @endphp

        {{-- <tr style="border-bottom: 1px solid black;">
            <td colspan="3" style="padding: 0px;">
            </td>
            <td class="td" style="text-align: center; padding: 2px;">Rp
                {{ number_format($totalSubtotal, 0, ',', '.') }}</td>
        </tr> --}}

        <tr style="border-bottom: 1px solid black;">
            <td colspan="4" style="padding: 0px;">
            </td>
        </tr>


    </table>

    <?php
    // function terbilang($angka)
    // {
    //     $angka = abs($angka); // Pastikan angka selalu positif
    //     $bilangan = ['', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan', 'Sepuluh', 'Sebelas'];
    //     $hasil = '';
    //     if ($angka < 12) {
    //         $hasil = $bilangan[$angka];
    //     } elseif ($angka < 20) {
    //         $hasil = terbilang($angka - 10) . ' Belas';
    //     } elseif ($angka < 100) {
    //         $hasil = terbilang($angka / 10) . ' Puluh ' . terbilang($angka % 10);
    //     } elseif ($angka < 200) {
    //         $hasil = 'Seratus ' . terbilang($angka - 100);
    //     } elseif ($angka < 1000) {
    //         $hasil = terbilang($angka / 100) . ' Ratus ' . terbilang($angka % 100);
    //     } elseif ($angka < 2000) {
    //         $hasil = 'Seribu ' . terbilang($angka - 1000);
    //     } elseif ($angka < 1000000) {
    //         $hasil = terbilang($angka / 1000) . ' Ribu ' . terbilang($angka % 1000);
    //     } elseif ($angka < 1000000000) {
    //         $hasil = terbilang($angka / 1000000) . ' Juta ' . terbilang($angka % 1000000);
    //     } elseif ($angka < 1000000000000) {
    //         $hasil = terbilang($angka / 1000000000) . ' Miliar ' . terbilang($angka % 1000000000);
    //     } elseif ($angka < 1000000000000000) {
    //         $hasil = terbilang($angka / 1000000000000) . ' Triliun ' . terbilang($angka % 1000000000000);
    //     }
    //     return $hasil;
    // }
    ?>
    <br>
    {{-- <span
        style="font-weight: bold; font-size: 18px; margin-left: 100px; font-style: italic;">({{ terbilang($deposits->harga) }}Rupiah)</span>
        --}}
    <br><br><br>
    <br><br><br>

    <table class="tdd" style="width: 100%;" cellpadding="10" cellspacing="0">
        <tr>
            <td style="text-align: center">Pelanggan</td>
            <td style="text-align: center">Direktur</td>
            <td style="text-align: center">Admin Penjualan</td>
        </tr>
    </table>
</body>

<div class="container">
    <a href="{{ url('admin/tabledeposit') }}" class="blue-button">Kembali</a>
    <a href="{{ url('admin/deposit_pemesanan/cetak-pdf/' . $deposits->id) }}" class="blue-button">Cetak</a>
</div>

</html>
