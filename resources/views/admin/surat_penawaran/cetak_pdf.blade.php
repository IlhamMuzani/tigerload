<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Surat Penawaran Karoseri</title>
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

        .table,
        .tdd {
            border: 1px solid white;
        }

        html,
        body {
            /* margin: 30px;
            padding: 10px; */
            font-family: 'Times New Roman', Times, serif;
        }


        .info-container {
            display: flex;
            justify-content: space-between;
            /* font-weight: bold; */
            font-size: 16px;
            margin: 5px 0;
        }

        #logo-container img {
            max-width: 320px;
            /* Ubah sesuai kebutuhan */
            vertical-align: top;
            /* Mengatur gambar lebih tinggi ke atas */
        }

        .info-1 {}
    </style>
</head>

<body style="margin: 0; padding: 0;">
    <br>
    <table width="100%">
        <tr>
            {{-- </div> --}}
            {{-- <hr> --}}
            {{-- </td> --}}
            <td>
                <div style="display: flex; justify-content: center; align-items: center;">
                    <table style="text-align: center;">
                        <tr>
                            <td style="font-weight: bold; font-size:20px">CV. TIGER LOAD ENGINEERING</td>
                        </tr>
                        <tr>
                            <td style="font-size: 13px; font-weight: lighter;">Jl. Ahmad Yani No. 42 Procot Slawi,
                                Tegal 52411</td>
                        </tr>
                        <tr>
                            <td style="font-size: 13px; font-weight: lighter;">Telp, (0283) 4563746</td>
                        </tr>
                        <tr>
                            <td style="font-size: 13px; font-weight: lighter;">No. Izin Karoseri : 551.25/ 8502</td>
                        </tr>

                    </table>
                </div>
            </td>
            {{-- <td> --}}
            {{-- <div class="info-container"> --}}
            {{-- <div id="logo-container"> --}}
            <img src="{{ public_path('storage/uploads/gambar_logo/login2.png') }}" width="270" height="60"
                alt="Logo Tigerload">
            {{-- </div> --}}

        </tr>
    </table>
    <hr>
    <table width="100%">
        {{-- <div>
            <p style="font-size: 13px; text-align: right; margin-right: 50px;">Tegal,
                {{ $pembelians->tanggal }} </p>
        </div> --}}
        <div style="display: flex; justify-content: left; align-items: left; margin-left:20px">
            {{-- <p style="font-size: 13px; text-align: right; margin-right: 50px;">Tegal,
                {{ $pembelians->tanggal }} </p> --}}
            <div style="margin-bottom:25px">
                <table width="100%">
                    <tr>
                        <td style="font-size: 13px;">
                            <span class="info-item">No. Faktur: {{ $pembelians->kode_spk }}</span>
                            <br>
                        </td>
                        <td style="text-align: right; font-size: 13px;">
                            <span class="info-item">Tegal,
                                {{ $pembelians->tanggal }}</span>
                            <br>
                        </td>
                    </tr>
                </table>
            </div>

            <table style="text-align: letf;">
                <tr>
                    <td style="font-size: 13px; font-weight: lighter;">Kepada Yth,</td>
                </tr>
                <tr>
                    <td style="font-size: 13px; font-weight: lighter;">
                        {{ $pembelians->pelanggan->nama_pelanggan }}</td>
                </tr>
                <tr>
                    <td style="font-size: 13px; font-weight: lighter;">Di {{ $pembelians->pelanggan->alamat }}
                    </td>
                </tr>
                <tr>
                    <td style="font-size: 13px; font-weight: lighter;">Perihal : Surat Penawaran</td>
                </tr>
            </table>
        </div>
        <div style="display: flex; justify-content: left; align-items: left; margin-left:20px; margin-top:5px">
            <table style="text-align: letf;">
                <tr>
                    <td style="font-size: 13px; font-weight: lighter;">Dengan Hormat,</td>
                </tr>
                <tr>
                    <td style="font-size: 13px; font-weight: lighter;"><span style="margin-left:30px">
                            Bersama ini kami
                            sampaikan penawaran Karoseri Tiger Load dengan spesifikasi sebagai berikut :
                        </span>
                    </td>
                </tr>
            </table>
        </div>
        <div style="margin-left: 50px; font-size: 13px;">
            <table>
                <tr>
                    <td>
                        <img style="margin-top: 5px" src="{{ public_path('storage/uploads/gambar_logo/arrows.png') }}"
                            width="8" height="8" alt="Logo Tigerload">
                    </td>
                    <td>Model</td>
                    <td>
                        <div style="margin-left: 70px">
                            :
                        </div>
                    </td>
                    <td>{{ $pembelians->typekaroseri->nama_karoseri }} - {{ $kendaraans->merek->nama_merek }}
                        {{ $kendaraans->merek->tipe->nama_tipe }}</td>
                </tr>
                <tr>
                    <td>
                        <img style="margin-top: 5px" src="{{ public_path('storage/uploads/gambar_logo/arrows.png') }}"
                            width="8" height="8" alt="Logo Tigerload">
                    </td>
                    <td>Dimensi</td>
                    <td>
                        <div style="margin-left: 70px">
                            :
                        </div>
                    </td>
                    <td>- Panjang {{ $pembelians->typekaroseri->panjang }}, Lebar
                        {{ $pembelians->typekaroseri->lebar }} dan
                        Tinggi {{ $pembelians->typekaroseri->tinggi }}</td>
                </tr>
                @foreach ($spesifikasis as $key => $item)
                    <tr>
                        @if ($key === 0)
                            <td>
                                <img style="margin-top: 5px"
                                    src="{{ public_path('storage/uploads/gambar_logo/arrows.png') }}" width="8"
                                    height="8" alt="Logo Tigerload">
                            </td>
                            <td>Spesifikasi</td>
                        @else
                            <td></td>
                            <td></td>
                        @endif
                        <td>
                            <div style="margin-left: 70px">
                                :
                            </div>
                        </td>
                        <td>- {{ $item->nama }} {{ $item->jumlah }}</td>
                    </tr>
                @endforeach


                @if ($pembelians->typekaroseri->aksesoris == null)
                @else
                    <tr>
                        <td>
                            <img style="margin-top: 5px"
                                src="{{ public_path('storage/uploads/gambar_logo/arrows.png') }}" width="8"
                                height="8" alt="Logo Tigerload">
                        </td>
                        <td>Aksesoris</td>
                        <td>
                            <div style="margin-left: 70px">
                                :
                            </div>
                        </td>
                        <td>{{ $pembelians->typekaroseri->aksesoris }}</td>
                    </tr>
                @endif

                @php
                    $totalPrice = $pembelians->harga + 11396396; // Calculate the total price
                    $totalPrice2 = $pembelians->harga; // Calculate the total price

                    function numberToWords($number)
                    {
                        $words = [
                            'nol',
                            'satu',
                            'dua',
                            'tiga',
                            'empat',
                            'lima',
                            'enam',
                            'tujuh',
                            'delapan',
                            'sembilan',
                        ];
                        $unit = ['', 'ribu', 'juta', 'miliar', 'triliun']; // Extend as needed

                        $result = '';

                        $number = strval($number);

                        $chunks = str_split(strrev($number), 3);
                        $chunkCount = count($chunks);

                        for ($i = 0; $i < $chunkCount; $i++) {
                            $chunk = intval(strrev($chunks[$i]));
                            if ($chunk > 0) {
                                $wordsChunk = '';

                                $hundred = floor($chunk / 100);
                                $remainder = $chunk % 100;

                                if ($hundred > 0) {
                                    $wordsChunk .= $words[$hundred] . ' ratus';
                                }

                                if ($remainder > 0) {
                                    if ($hundred > 0) {
                                        $wordsChunk .= ' ';
                                    }

                                    if ($remainder < 10) {
                                        $wordsChunk .= $words[$remainder];
                                    } elseif ($remainder < 20) {
                                        $wordsChunk .= $words[$remainder - 10] . ' belas';
                                    } else {
                                        $tens = floor($remainder / 10);
                                        $ones = $remainder % 10;

                                        $wordsChunk .= $words[$tens] . ' puluh';
                                        if ($ones > 0) {
                                            $wordsChunk .= ' ' . $words[$ones];
                                        }
                                    }
                                }

                                $wordsChunk .= ' ' . $unit[$i];

                                if ($i == $chunkCount - 1) {
                                    $wordsChunk .= ' rupiah';
                                }

                                $result = $wordsChunk . ' ' . $result;
                            }
                        }

                        return $result;
                    }

                @endphp
                <tr>
                    <td>
                        <img style="margin-top: 5px" src="{{ public_path('storage/uploads/gambar_logo/arrows.png') }}"
                            width="8" height="8" alt="Logo Tigerload">
                    </td>
                    <td>Harga</td>
                    <td>
                        <div style="margin-left: 70px">:</div>
                    </td>
                    <td>Rp. {{ number_format($pembelians->harga, 0, ',', '.') }},-
                        @if ($pembelians->kategori == 'NON PPN')
                            <span>(
                                {{ numberToWords($totalPrice2) }} ) per unit</span>
                        @endif
                    </td>
                </tr>

                @if ($pembelians->kategori == 'PPN')
                    <tr>
                        <td>
                            <img style="margin-top: 5px"
                                src="{{ public_path('storage/uploads/gambar_logo/arrows.png') }}" width="8"
                                height="8" alt="Logo Tigerload">
                        </td>
                        <td>PPN 11%</td>
                        <td>
                            <div style="margin-left: 70px">:</div>
                        </td>
                        <td><span style="text-decoration: underline">Rp. 11.396.396,-</span> +</td>
                    </tr>

                    <tr style="font-weight: bold">
                        <td>
                            <img style="margin-top: 5px"
                                src="{{ public_path('storage/uploads/gambar_logo/arrows.png') }}" width="8"
                                height="8" alt="Logo Tigerload">
                        </td>
                        <td>Harga Satuan</td>
                        <td>
                            <div style="margin-left: 70px">:</div>
                        </td>
                        <td style="font-weight: bold">Rp. {{ number_format($totalPrice, 0, ',', '.') }},-
                            <span>( {{ numberToWords($totalPrice) }} ) per unit</span>
                        </td>
                    </tr>
                    <tr style="font-weight: bold">
                        <td>
                            <img style="margin-top: 5px"
                                src="{{ public_path('storage/uploads/gambar_logo/arrows.png') }}" width="8"
                                height="8" alt="Logo Tigerload">
                        </td>
                        <td>Total Harga</td>
                        <td>
                            <div style="margin-left: 70px">:</div>
                        </td>
                        <td style="font-weight: bold">{{ $pembelians->jumlah_unit }} Unit (
                            {{ number_format($pembelians->harga, 0, ',', '.') }} x {{ $pembelians->jumlah_unit }} =
                            {{ number_format($pembelians->harga * $pembelians->jumlah_unit, 0, ',', '.') }})
                        </td>
                    </tr>
                @else
                    @php
                        $totalPrice = $pembelians->harga; // Total price without PPN
                    @endphp
                @endif

                @if ($pembelians->kategori == 'NON PPN')
                    <tr style="font-weight: bold">
                        <td>
                            <img style="margin-top: 5px"
                                src="{{ public_path('storage/uploads/gambar_logo/arrows.png') }}" width="8"
                                height="8" alt="Logo Tigerload">
                        </td>
                        <td>Total Harga</td>
                        <td>
                            <div style="margin-left: 70px">:</div>
                        </td>
                        <td style="font-weight: bold">{{ $pembelians->jumlah_unit }} Unit (
                            {{ number_format($pembelians->harga, 0, ',', '.') }} x {{ $pembelians->jumlah_unit }} =
                            {{ number_format($pembelians->harga * $pembelians->jumlah_unit, 0, ',', '.') }})
                        </td>
                    </tr>
                @endif
                <tr>
                    <td>
                        <img style="margin-top: 5px" src="{{ public_path('storage/uploads/gambar_logo/arrows.png') }}"
                            width="8" height="8" alt="Logo Tigerload">
                    </td>
                    <td>Pembayaran</td>
                    <td>
                        <div style="margin-left: 70px">
                            :
                        </div>
                    </td>
                    <td>Uang Muka 50% dibayar saat pemesanan</td>
                </tr>
                <tr>
                    <td>
                        <img style="margin-top: 5px"
                            src="{{ public_path('storage/uploads/gambar_logo/arrows.png') }}" width="8"
                            height="8" alt="Logo Tigerload">
                    </td>
                    <td>Tempo Pembayaran</td>
                    <td>
                        <div style="margin-left: 70px">
                            :
                        </div>
                    </td>
                    <td>+/- 30 Hari</td>
                </tr>
                <tr>
                    <td>
                        <img style="margin-top: 5px"
                            src="{{ public_path('storage/uploads/gambar_logo/arrows.png') }}" width="8"
                            height="8" alt="Logo Tigerload">
                    </td>
                    <td>Rekening Bank</td>
                    <td>
                        <div style="margin-left: 70px">
                            :
                        </div>
                    </td>
                    <td>BCA 3629888889 Atas Nama : Djohan Wahyudi</td>
                </tr>
            </table>
        </div>
        <div style="display: flex; justify-content: left; align-items: left; margin-left:20px; margin-top:5px">
            <table style="text-align: letf;">
                <tr>
                    <td style="font-size: 13px; font-weight: lighter;"> <span style="margin-left:30px">Demikian surat
                            penawaran ini kami
                            sampaikan. Atas kerjasama dan kepercayaan yang diberikan kami</span></td>
                </tr>
                <tr>
                    <td style="font-size: 13px; font-weight: lighter;">
                        kami sampaikan terimakasih
                    </td>
                </tr>
            </table>
        </div>
        <div style="margin-top:10px">
            <p style="font-size: 13px; text-align: left; margin: 0; margin-left: 70px;">Hormat Kami,
            </p>
        </div>
        <table width="100%">
            <tr>
                {{-- <td> --}}
                <div class="info-container">
                    <div id="logo-container">
                        <p style="font-size: 13px; text-align: left; margin: 0; margin-left: 30px;">KAROSERI TIGER LOAD
                        </p>
                        <p
                            style="font-size: 13px; text-align: left; margin: 0; margin-left: 40px; text-decoration: underline; margin-top: 30px">
                            DJOHAN WAHYUDI</p>
                    </div>

                </div>
                {{-- <hr> --}}
                {{-- </td> --}}
                <td>
                    <div style="display: flex; justify-content: center; align-items: center;">
                        <table style="text-align: center;">
                            <tr>
                                <td style="font-size: 13px; font-weight: lighter; ">PEMESAN</td>
                            </tr>
                            <tr>
                                <td style="font-size: 13px; font-weight: lighter; color:white">.</td>
                            </tr>
                            <tr>
                                <td style="font-size: 2px; font-weight: lighter; color:white">.</td>
                            </tr>
                            <tr>
                                <td style="font-size: 13px; font-weight: lighter; text-decoration: underline;">
                                    {{ strtoupper($pembelians->pelanggan->nama_pelanggan) }}
                                </td>
                            </tr>
                        </table>
                    </div>

                </td>
            </tr>
        </table>
        <div
            style="font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif; border: 2px solid #000; margin-left: 20px; font-size: 10px;">
            <table>
                <tr>
                    <td>1.</td>
                    <td>
                        <div style="margin-left: 10px">
                            Harga sudah termasuk SRUT
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>2.</td>
                    <td>
                        @if ($pembelians->kategori == 'PPN')
                            <div style="margin-left: 10px">
                                Harga sudah termasuk PPN
                            </div>
                        @else
                            <div style="margin-left: 10px">
                                Harga belum termasuk PPN
                            </div>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>3.</td>
                    <td>
                        <div style="margin-left: 10px">
                            Adanya penambahan ukuran atau model diluar surat penawaran dikenakan biaya
                            tambahan.
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>4.</td>
                    <td>
                        <div style="margin-left: 10px">
                            Segala resiko yang timbul dikarenakan ukuran bak yang tidak sesuai standar dari
                            Dinas Perhubungan sepenuhnya menjadi
                        </div>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <div style="margin-left: 10px">
                            tanggung jawab pemesan.
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>5.</td>
                    <td>
                        <div style="margin-left: 10px">
                            Kerusakan yang diakibatkan oleh kelalain / kesalahan operator <span
                                style="text-decoration: underline;">bukan menjadi
                                tanggung jawab Karoseri Tiger Load.</span>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>6.</td>
                    <td>
                        <div style="margin-left: 10px">
                            Apabila terjadi pembatalan pemesanan oleh pihak pemesan, maka Uang Muka yang
                            sudah
                            masuk tidak dapat diambil
                        </div>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <div style="margin-left: 10px">
                            kembali ataupun diakumulasikan ke unit yang lain(jika pesanan lebih dari satu
                            unit)
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>7.</td>
                    <td>
                        <div style="margin-left: 10px">
                            Perhitungan pengerjaan dimulai setelah uang muka efektif diterima Karoseri.
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>8.</td>
                    <td>
                        <div style="margin-left: 10px">
                            Pesanan yang tidak segera diambil setelah konfirmasi barang jadi, maka pihak
                            Karoseri tidak bertanggung jawab terhadap
                        </div>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <div style="margin-left: 10px">
                            segala kerusakan fisik yang timbul setelahnya.
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>9.</td>
                    <td>
                        <div style="margin-left: 10px">
                            Harga belum termasuk biaya KIR pertama.
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </table>
</body>


</html>
