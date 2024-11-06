<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>faktur Penjualan</title>
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
            /* Gunakan Arial atau font sans-serif lainnya yang mudah dibaca */
            margin: 15px;
            /* padding: 10px; */
        }

        span.h2 {
            font-size: 24px;
            /* font-weight: 500; */
        }

        .label {
            font-size: 16px;
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
            font-size: 14px;
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
            font-size: 14px;
            text-align: center;

        } */

        .separator {
            padding-top: 14px;
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

        @page {
            /* size: A4; */
            margin: 1cm;
        }
    </style>
</head>

<body style="margin: 0; padding: 0;">
    <table width="100%">
        <td style="text-align: left;">
            <img src="{{ public_path('storage/uploads/gambar_logo/login2.png') }}" width="120" height="30"
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
    <table width="100%">
        <tr>
            <!-- First column (Nama PT) -->
            <td style="width: 50%;">
                <div class="info-catatan" style="max-width: 240px;">
                    <table>
                        <tr>
                            <td class="info-catatan2" style="font-size: 14px;">CV. TIGER LOAD ENGINEERING</td>
                            {{-- <td class="info-item" style="font-size: 14px;">:</td>
                            <td class="info-text info-left" style="font-size: 14px;">Company Name</td> --}}
                        </tr>
                        <tr>
                            <td class="info-text info-left" style="font-size: 14px;">Jl. Ahmad Yani No. 42,</td>
                            {{-- <td class="info-item" style="font-size: 14px;">:</td>
                            <td class="info-text info-left" style="font-size: 14px;">Company Address</td> --}}
                        </tr>
                        <tr>
                            <td class="info-text info-left" style="font-size: 14px;">Procot Slawi, Tegal 52411</td>
                            {{-- <td class="info-item" style="font-size: 14px;">:</td>
                            <td class="info-text info-left" style="font-size: 14px;">123-456-7890</td> --}}
                        </tr>
                        <tr>
                            <td class="info-text info-left" style="font-size: 14px;">Telp, (0283) 4563746
                            </td>
                            {{-- <td class="info-item" style="font-size: 14px;">:</td>
                            <td class="info-text info-left" style="font-size: 14px;">123-456-7890</td> --}}
                        </tr>
                    </table>
                </div>
            </td>
            <!-- Second column (Nama Supplier) -->
            <td style="width: 70%;" style="max-width: 230px;">
                <div class="info-catatan">
                    <table>
                        <tr>
                            <td class="info-catatan2" style="font-size: 14px;">Nama Pelanggan</td>
                            <td class="info-item" style="font-size: 14px;">:</td>
                            <td class="info-text info-left" style="font-size: 14px;">
                                @if ($penjualans->perintah_kerja)
                                    {{ $penjualans->perintah_kerja->spk->pelanggan->nama_pelanggan }}
                                @else
                                    {{ $penjualans->spk->pelanggan->nama_pelanggan }}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="info-catatan2" style="font-size: 14px;">Alamat</td>
                            <td class="info-item" style="font-size: 14px;">:</td>
                            <td class="info-text info-left" style="font-size: 14px;">
                                @if ($penjualans->perintah_kerja)
                                    {{ $penjualans->perintah_kerja->spk->pelanggan->alamat }} </span>
                                @else
                                    {{ $penjualans->spk->pelanggan->alamat }} </span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="info-catatan2" style="font-size: 14px;">Telp</td>
                            <td class="info-item" style="font-size: 14px;">:</td>
                            <td class="info-text info-left" style="font-size: 14px;">
                                @if ($penjualans->perintah_kerja)
                                    {{ $penjualans->perintah_kerja->spk->pelanggan->telp }}
                                @else
                                    {{ $penjualans->spk->pelanggan->telp }}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="info-catatan2" style="font-size: 14px;">ID Pelanggan</td>
                            <td class="info-item" style="font-size: 14px;">:</td>
                            <td class="info-text info-left" style="font-size: 14px;">
                                @if ($penjualans->perintah_kerja)
                                    {{ $penjualans->perintah_kerja->spk->pelanggan->kode_pelanggan }}
                                @else
                                    {{ $penjualans->spk->pelanggan->kode_pelanggan }}
                                @endif </span>
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>

    <div style="font-weight: bold; text-align: center;">
        <span style="font-weight: bold; font-size: 20px;">FAKTUR PENJUALAN</span>
        <br>
    </div>
    {{-- <hr style="border-top: 0.5px solid black; margin: 3px 0;"> --}}
    <table style="width: 100%; border-top: 1px solid black; margin-bottom:5px">
        <tr>
            <td>
                <span class="info-item" style="font-size: 14px; padding-left: 5px;">No. Faktur:
                    {{ $penjualans->kode_penjualan }}</span>
                <br>
            </td>
            <td style="text-align: right; padding-right: 45px;">
                <span class="info-item" style="font-size: 14px;">Tanggal:{{ $penjualans->tanggal }}</span>
                <br>
            </td>
        </tr>
    </table>
    {{-- <hr style="border-top: 0.5px solid black; margin: 3px 0;"> --}}
    <table style="width: 100%; border-top: 1px solid black;" cellpadding="2" cellspacing="0">
        <tr>
            <td class="td" style="text-align: center; font-size: 14px; width:5%">No.</td>
            <td class="td" style="text-align: left; font-size: 14px; width:15%">Kode Produk</td>
            <td class="td"
                style="text-align: left; font-size: 14px; width:45%; word-wrap: break-word; white-space: normal;">Nama
                Produk</td>
            <td class="td" style="text-align: left; font-size: 14px; width: 15%">Qty</td>
            <td class="td" style="text-align: right; padding-right:20px; font-size: 14px; width:10%">Harga</td>
            <td class="td" style="text-align: right; padding-right:20px; font-size: 14px; width:10%">Diskon</td>
            <td class="td" style="text-align: right; font-size: 14px; width:10%">Total</td>
        </tr>
        <tr style="border-bottom: 1px solid black;">
            <td colspan="6" style="padding: 0px;"></td>
        </tr>
        @php
            $totalQuantity = 0;
            $totalHarga = 0;
        @endphp
        {{-- @foreach ($parts as $item) --}}
        <tr>
            <td class="td" style="text-align: center;  font-size: 14px;">1
            </td>
            <td class="info-text info-left" style="font-size: 14px; text-align: left;">
                @if ($penjualans->perintah_kerja)
                    {{ $penjualans->perintah_kerja->spk->typekaroseri->kode_type }}
                @else
                    {{ $penjualans->spk->typekaroseri->kode_type }}
                @endif
            </td>
            <td class="info-text info-left"
                style="font-size: 14px; text-align: left; word-wrap: break-word; white-space: normal;">
                @if ($penjualans->perintah_kerja)
                    {{ $penjualans->perintah_kerja->spk->typekaroseri->nama_karoseri }}
                    {{ $penjualans->perintah_kerja->spk->typekaroseri->merek->nama_merek }}
                    {{ $penjualans->perintah_kerja->spk->typekaroseri->merek->tipe->nama_tipe }}
                @else
                    {{ $penjualans->spk->typekaroseri->nama_karoseri }}
                    {{ $penjualans->spk->typekaroseri->merek->nama_merek }}
                    {{ $penjualans->spk->typekaroseri->merek->tipe->nama_tipe }}
                @endif
            </td>
            <td class="td" style="text-align: left;  font-size: 14px;">
                1 </td>
            <?php
            // Calculate the increase and round it
            $total_price = $penjualans->perintah_kerja->spk->harga;
            $tax_rate = 0.11;
            // Calculate original price
            $original_price = $total_price / (1 + $tax_rate);
            
            // Calculate tax amount
            $tax_amount = $original_price * $tax_rate;
            ?>
            <td class="td" style="font-size: 14px; padding-right: 20px; text-align: right;">
                <span style="float: right">
                    @if ($penjualans->perintah_kerja->spk->surat_penawaran->kategori == 'PPN')
                        <span style="float: right">
                            @if ($penjualans->perintah_kerja)
                                {{ number_format($original_price, 2, ',', '.') }}
                            @endif
                        </span>
                    @else
                        <span style="float: right">
                            @if ($penjualans->perintah_kerja)
                                {{ number_format($penjualans->perintah_kerja->spk->harga, 2, ',', '.') }}
                            @else
                                {{ number_format($penjualans->spk->harga, 2, ',', '.') }}
                            @endif
                        </span>
                    @endif
                </span>
            </td>
            <td class="td" style="font-size: 14px; padding-right: 20px; text-align: right;">
                <span style="float: right">
                    0.00
                </span>
            </td>
            <td class="td" style="font-size: 14px; text-align: right;">
                @if ($penjualans->perintah_kerja->spk->surat_penawaran->kategori == 'PPN')
                    <span style="float: right">
                        @if ($penjualans->perintah_kerja)
                            {{ number_format($original_price, 2, ',', '.') }}
                        @endif
                    </span>
                @else
                    <span style="float: right">
                        @if ($penjualans->perintah_kerja)
                            {{ number_format($penjualans->perintah_kerja->spk->harga, 2, ',', '.') }}
                        @else
                            {{ number_format($penjualans->spk->harga, 2, ',', '.') }}
                        @endif
                    </span>
                @endif
            </td>
        </tr>
        @if ($penjualans->perintah_kerja)
            @php
                $startFrom = 2;
                $totalSubtotalharga = $penjualans->perintah_kerja->spk->harga; // Inisialisasi dengan harga awal
            @endphp
        @else
            @php
                $startFrom = 2;
                $totalSubtotalharga = $penjualans->spk->harga; // Inisialisasi dengan harga awal
            @endphp
        @endif

        @php
            $totalSubtotalppn = 0; // Menambahkan harga saat iterasi
        @endphp
        @foreach ($spesifikasis as $item)
            <tr>
                <td class="td" style="text-align: center; font-size:14px; padding: 0px;">{{ $startFrom }}</td>
                @php
                    $startFrom++;
                @endphp
                <td class="td" style="text-align: left; font-size:14px; padding: 2px;">
                    {{ $item->kode_types }}
                </td>
                <td class="td" style="text-align: left; font-size:14px; padding: 2px;">
                    {{ $item->nama_karoseri }}
                </td>
                <td class="td" style="text-align: left; font-size:14px; padding: 2px;">{{ $item->jumlah }}</td>
                <td class="td" style="font-size: 14px; padding-right: 20px; text-align: right;">
                    {{-- <span style="float: center;">Rp.</span> --}}
                    <span style="float: right"> {{ number_format($item->harga, 2, ',', '.') }}
                        {{-- </span> --}}
                </td>
                <td class="td" style="font-size: 14px; padding-right: 20px; text-align: right;">
                    {{-- <span style="float: center;">Rp.</span> --}}
                    <span style="float: right"> {{ number_format($item->diskon, 2, ',', '.') }}
                        {{-- </span> --}}
                </td>
                <td class="td" style="font-size: 14px; text-align: right;">
                    {{-- <span style="float: center;">Rp.</span> --}}
                    <span style="float: right"> {{ number_format($item->total, 2, ',', '.') }}
                        {{-- </span> --}}
                </td>
            </tr>
            @php
                $totalSubtotalppn += $item->total; // Menambahkan harga saat iterasi
            @endphp
        @endforeach

        <tr style="border-bottom: 1px solid black;">
            <td colspan="7" style="padding: 0px;">
            </td>
        </tr>

        @if ($penjualans->perintah_kerja->spk->surat_penawaran->kategori == 'PPN')
            <tr>
                <td colspan="6"
                    style="text-align: right; padding-right: 10px; font-weight: bold; font-size: 14px;">Total</td>
                <td class="td" style="font-size: 14px; text-align: right; font-weight: bold;">
                    <span style="float: right">
                        {{ number_format($original_price + $totalSubtotalppn, 2, ',', '.') }}
                </td>
            </tr>
            <?php
            // Calculate the increase and round it
            $total_price22 = $penjualans->perintah_kerja->spk->harga;
            $tax_rate22 = 0.11;
            // Calculate original price
            $original_price22 = $total_price22 / (1 + $tax_rate22);
            
            // Calculate tax amount
            $tax_amount22 = $original_price22 * $tax_rate22;
            ?>
            <tr>
                <td colspan="6"
                    style="text-align: right; padding-right: 10px; font-weight: bold; font-size: 14px;">PPN
                    11%</td>
                <td class="td"
                    style="font-size: 14px; text-align: right; text-decoration: underline; font-weight: bold;">
                    <span style="float: right">
                        {{ number_format($tax_amount22, 2, ',', '.') }}
                </td>
            </tr>
            <tr>
                <td colspan="6"
                    style="text-align: right; padding-right: 10px; font-weight: bold; font-size: 14px;">Sub Total</td>
                <td class="td" style="font-size: 14px; text-align: right; font-weight: bold;">
                    <span style="float: right">
                        {{ number_format($original_price + $totalSubtotalppn + $tax_amount22, 2, ',', '.') }}
                </td>
            </tr>
            <tr><br></tr>

            @php
                $totalDP = 0;
            @endphp
            @foreach ($depositpemesanans as $index => $deposit)
                <tr>
                    <td colspan="6"
                        style="text-align: right; padding-right: 10px; font-weight: bold; font-size: 14px;">
                        DP
                        ({{ $deposit->kode_deposit }}
                        {{ \Carbon\Carbon::parse($deposit->tanggal_transfer)->locale('id')->isoFormat('D MMMM YYYY') }})
                    </td>
                    <td class="td" style="font-size: 14px; text-align: right; font-weight: bold;">
                        <span style="float: right;">
                            {{ number_format($deposit->harga, 2, ',', '.') }}
                    </td>
                </tr>
                @php
                    $totalDP += $deposit->harga;
                @endphp
            @endforeach
            <tr>
                <td colspan="6"
                    style="text-align: right; padding-right: 10px; font-weight: bold; font-size: 14px; border-bottom: 1px solid black;">
                </td>
                <td class="td"
                    style="font-size: 14px; text-align: right; font-weight: bold; border-bottom: 1px solid black;">
                    <span style="float: right;">
                        <!-- Your subtotal value here -->
                    </span>
                </td>
            </tr>
            <tr>
                <td colspan="6"
                    style="text-align: right; padding-right: 10px; font-weight: bold; font-size: 14px;">
                    Grand Total</td>
                <td class="td" style="font-size: 14px; text-align: right; font-weight: bold;">
                    <span style="float: right">
                        @if ($penjualans->depositpemesanan)
                            {{ number_format($original_price + $totalSubtotalppn + $tax_amount22 - $totalDP, 2, ',', '.') }}
                        @else
                            {{ number_format($original_price + $totalSubtotalppn + $tax_amount22 - $totalDP, 2, ',', '.') }}
                        @endif
                </td>
            </tr>
        @else
            <tr>
                <td colspan="6"
                    style="text-align: right; padding-right: 10px; font-weight: bold; font-size: 14px;">Sub
                    Total</td>
                <td class="td" style="font-size: 14px; text-align: right; font-weight: bold;">
                    <span style="float: right">
                        {{ number_format($totalSubtotalharga + $totalSubtotalppn, 2, ',', '.') }}
                </td>
            </tr>
            @php
                $totalDP1 = 0;
            @endphp
            @foreach ($depositpemesanans as $index => $deposit)
                <tr>
                    <td colspan="6"
                        style="text-align: right; padding-right: 10px; font-weight: bold; font-size: 14px;">
                        DP
                        ({{ $deposit->kode_deposit }}
                        {{ \Carbon\Carbon::parse($deposit->tanggal_transfer)->locale('id')->isoFormat('D MMMM YYYY') }})
                    </td>
                    <td class="td" style="font-size: 14px; text-align: right; font-weight: bold;">
                        <span style="float: right;">
                            {{ number_format($deposit->harga, 2, ',', '.') }}
                    </td>
                </tr>
                @php
                    $totalDP1 += $deposit->harga;
                @endphp
            @endforeach

            <tr>
                <td colspan="6"
                    style="text-align: right; padding-right: 10px; font-weight: bold; font-size: 14px; border-bottom: 1px solid black;">
                </td>
                <td class="td"
                    style="font-size: 14px; text-align: right; font-weight: bold; border-bottom: 1px solid black;">
                    <span style="float: right;">
                        <!-- Your subtotal value here -->
                    </span>
                </td>
            </tr>

            <tr>
                <td colspan="6"
                    style="text-align: right; padding-right: 10px; font-weight: bold; font-size: 14px;">
                    Grand Total</td>
                {{-- <td class="td" style="text-align: right; font-weight: bold;">Rp.
                {{ number_format($totalSubtotal, 0, ',', '.') }}
            </td> --}}
                <td class="td" style="font-size: 14px; text-align: right; font-weight: bold;">
                    {{-- <span style="float: center;">Rp.</span> --}}
                    <span style="float: right">
                        @if ($penjualans->depositpemesanan)
                            {{ number_format($totalSubtotalharga + $totalSubtotalppn - $totalDP1, 2, ',', '.') }}
                        @else
                            {{ number_format($totalSubtotalharga + $totalSubtotalppn - 0, 2, ',', '.') }}
                        @endif
                        {{-- </span> --}}
                </td>
            </tr>
        @endif
    </table>

    @if ($penjualans->perintah_kerja->spk->surat_penawaran->kategori == 'PPN')
        <div style="font-size: 14px; font-weight:bold">Pembayaran :</div>
        <div style="font-size: 14px; font-weight:bold">Bank BCA No.Rek. 3621889999 an. CV Tiger Load Engineering</div>
    @else
        <div style="font-size: 14px; font-weight:bold">Pembayaran :</div>
        <div style="font-size: 14px; font-weight:bold">Bank BCA No.Rek. 3629888889 an. DJOHAN WAHYUDI</div>
    @endif
    <br>
    <table class="tdd" cellpadding="10" cellspacing="0" style="margin: 0 auto;">
        <tr>
            <td style="text-align: center;">
                <table style="margin: 0 auto;">
                    <tr style="text-align: center;">
                        <td style="font-size: 14px" class="label" style="min-height: 16px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="font-size: 14px" class="separator" colspan="2"><span></span></td>
                    </tr>
                    <tr style="text-align: center;">
                        <td style="font-size: 14px" class="label">Pelanggan</td>
                    </tr>
                </table>
            </td>
            <td style="text-align: center;">
                <table style="margin: 0 auto;">
                    <tr style="text-align: center;">
                        <td class="label" style="min-height: 16px; font-size:14px">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="font-size: 14px" class="separator" colspan="2"><span></span></td>
                    </tr>
                    <tr style="text-align: center;">
                        <td style="font-size: 14px" class="label">Direktur</td>
                    </tr>
                </table>
            </td>
            <td style="text-align: center;">
                <table style="margin: 0 auto;">
                    <tr style="text-align: center;">
                        <td style="font-size: 14px" class="label">{{ auth()->user()->karyawan->nama_lengkap }}</td>
                    </tr>
                    <tr>
                        <td style="font-size: 14px" class="separator" colspan="2"><span></span></td>
                    </tr>
                    <tr style="text-align: center;">
                        <td style="font-size: 14px" class="label">Admin Penjualan</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
