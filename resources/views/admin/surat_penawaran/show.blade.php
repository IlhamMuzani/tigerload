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
            margin: 30px;
            padding: 10px;
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
            max-width: 500px;
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
            <td>
                <div class="info-container">

                    <div style="display: flex; justify-content: center; align-items: center;">
                        <table style="text-align: center;">
                            <tr>
                                <td style="font-weight: bold; font-size:40px">CV. TIGER LOAD ENGINEERING</td>
                            </tr>
                            <tr>
                                <td style="font-size: 25px; font-weight: lighter;">Jl. Ahmad Yani No. 42 Procot Slawi,
                                    Tegal 52411</td>
                            </tr>
                            <tr>
                                <td style="font-size: 25px; font-weight: lighter;">Telp, (0283) 4563746</td>
                            </tr>
                            <tr>
                                <td style="font-size: 25px; font-weight: lighter;">No. Izin Karoseri : 551.25/ 8502</td>
                            </tr>

                        </table>
                    </div>
                    <div id="logo-container">
                        <img src="{{ asset('storage/uploads/gambar_logo/login2.png') }}" width="600" height="100"
                            alt="Logo Tigerload">
                    </div>
                </div>
                <hr>
                {{-- <div>
                    <p style="font-size: 25px; text-align: right; margin-right: 100px;">Tegal,
                        {{ $pembelians->tanggal }} </p>
                </div> --}}

                <div style="padding-left: 80px; padding-right: 100px; margin-top:25px; margin-bottom:40px">
                    <table width="100%">
                        <tr>
                            <td style="font-size: 25px;">
                                <span class="info-item">No. Faktur: {{ $pembelians->kode_spk }}</span>
                                <br>
                            </td>
                            <td style="text-align: right; font-size: 25px;">
                                <span class="info-item">Tegal,
                                    {{ $pembelians->tanggal }}</span>
                                <br>
                            </td>
                        </tr>
                    </table>
                </div>

                <div style="display: flex; justify-content: left; align-items: left; margin-left:80px">
                    <table style="text-align: letf;">
                        <tr>
                            <td style="font-size: 25px; font-weight: lighter;">Kepada Yth,</td>
                        </tr>
                        <tr>
                            <td style="font-size: 25px; font-weight: lighter;">
                                {{ $pembelians->pelanggan->nama_pelanggan }}</td>
                        </tr>
                        <tr>
                            <td style="font-size: 25px; font-weight: lighter;">Di {{ $pembelians->pelanggan->alamat }}
                            </td>
                        </tr>
                        <tr>
                            <td style="font-size: 25px; font-weight: lighter;">Perihal : Surat Penawaran</td>
                        </tr>
                    </table>
                </div>

                <div>
                    <p style="font-size: 25px; text-align: left; margin-left: 80px; margin-top:30px">Dengan Hormat, </p>
                    <p style="font-size: 25px; text-align: left; margin-left: 170px; margin-top:30px">Bersama ini kami
                        sampaikan penawaran Karoseri Tiger Load dengan spesifikasi sebagai berikut : </p>
                </div>
                <div style="margin-left: 80px; font-size: 25px;">
                    <table>
                        <tr>
                            <td>
                                <img style="margin-top: 5px" src="{{ asset('storage/uploads/gambar_logo/arrows.png') }}"
                                    width="8" height="8" alt="Logo Tigerload">
                            </td>
                            <td>Model</td>
                            <td>
                                <div style="margin-left: 70px">
                                    :
                                </div>
                            </td>
                            <td>{{ $pembelians->typekaroseri->kode_type }} -
                                {{ $pembelians->typekaroseri->nama_karoseri }}</td>
                        </tr>
                        <tr>
                            <td>
                                <img style="margin-top: 5px" src="{{ asset('storage/uploads/gambar_logo/arrows.png') }}"
                                    width="8" height="8" alt="Logo Tigerload">
                            </td>
                            <td>Merek / Type</td>
                            <td>
                                <div style="margin-left: 70px">
                                    :
                                </div>
                            </td>
                            <td>
                                {{ $kendaraans->merek->nama_merek }}
                                {{ $kendaraans->merek->tipe->nama_tipe }}</td>
                        </tr>
                        <tr>
                            <td>
                                <img style="margin-top: 5px"
                                    src="{{ asset('storage/uploads/gambar_logo/arrows.png') }}" width="8"
                                    height="8" alt="Logo Tigerload">
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
                                            src="{{ asset('storage/uploads/gambar_logo/arrows.png') }}" width="8"
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


                        @if ($pembelians->aksesoris == null)
                        @else
                            <tr>
                                <td>
                                    <img style="margin-top: 5px"
                                        src="{{ asset('storage/uploads/gambar_logo/arrows.png') }}" width="8"
                                        height="8" alt="Logo Tigerload">
                                </td>
                                <td>Aksesoris</td>
                                <td>
                                    <div style="margin-left: 70px">
                                        :
                                    </div>
                                </td>
                                <td>{{ $pembelians->aksesoris }}</td>
                            </tr>
                        @endif

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
                        <tr>
                            <td>
                                <img style="margin-top: 5px"
                                    src="{{ asset('storage/uploads/gambar_logo/arrows.png') }}" width="8"
                                    height="8" alt="Logo Tigerload">
                            </td>
                            <td>Harga</td>
                            <td>
                                <div style="margin-left: 70px">:</div>
                            </td>
                            <td>Rp. {{ number_format($pembelians->harga, 0, ',', '.') }},-
                                @if ($pembelians->kategori == 'NON PPN')
                                    <span>(
                                        {{ terbilang($pembelians->harga) }} ) per unit</span>
                                @endif
                            </td>
                        </tr>

                        @if ($pembelians->kategori == 'PPN')
                            <tr>
                                <td>
                                    <img style="margin-top: 5px"
                                        src="{{ asset('storage/uploads/gambar_logo/arrows.png') }}" width="8"
                                        height="8" alt="Logo Tigerload">
                                </td>
                                <td>PPN 11%</td>
                                <td>
                                    <div style="margin-left: 70px">:</div>
                                </td>
                                <td><span style="text-decoration: underline">Rp.
                                        {{ number_format($pembelians->harga * 0.11, 0, ',', '.') }},-</span> +</td>
                            </tr>

                            <tr style="font-weight: bold">
                                <td>
                                    <img style="margin-top: 5px"
                                        src="{{ asset('storage/uploads/gambar_logo/arrows.png') }}" width="8"
                                        height="8" alt="Logo Tigerload">
                                </td>
                                <td>Harga Satuan</td>
                                <td>
                                    <div style="margin-left: 70px">:</div>
                                </td>
                                <td style="font-weight: bold; font-size:25px">Rp.
                                    {{ number_format($pembelians->harga + $pembelians->harga * 0.11, 0, ',', '.') }},-
                                </td>
                            </tr>
                            <tr style="font-weight: bold">
                                <td>
                                    <img style="margin-top: 5px"
                                        src="{{ asset('storage/uploads/gambar_logo/arrows.png') }}" width="8"
                                        height="8" alt="Logo Tigerload">
                                </td>
                                <td>Total Harga</td>
                                <td>
                                    <div style="margin-left: 70px">:</div>
                                </td>
                                <td style="font-weight: bold">
                                    {{ $pembelians->jumlah_unit }} Unit x
                                    {{ number_format($pembelians->harga + $pembelians->harga * 0.11, 0, ',', '.') }},-
                                    =
                                    {{ number_format(($pembelians->harga + $pembelians->harga * 0.11) * $pembelians->jumlah_unit, 0, ',', '.') }}
                                    {{-- ( {{ terbilang($pembelians->harga * $pembelians->jumlah_unit, 0, ',', '.') }} Rupiah ) --}}
                                </td>
                            </tr>
                            <tr style="font-weight: bold">
                                <td>

                                </td>
                                <td></td>
                                <td>
                                    <div style="margin-left: 70px">:</div>
                                </td>
                                <td style="font-weight: bold">
                                    (
                                    {{ terbilang(($pembelians->harga + $pembelians->harga * 0.11) * $pembelians->jumlah_unit, 0, ',', '.') }}
                                    Rupiah )
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
                                        src="{{ asset('storage/uploads/gambar_logo/arrows.png') }}" width="8"
                                        height="8" alt="Logo Tigerload">
                                </td>
                                <td>Total Harga</td>
                                <td>
                                    <div style="margin-left: 70px">:</div>
                                </td>
                                <td style="font-weight: bold">
                                    {{ $pembelians->jumlah_unit }} Unit x
                                    {{ number_format($pembelians->harga, 0, ',', '.') }}
                                    = {{ number_format($pembelians->harga * $pembelians->jumlah_unit, 0, ',', '.') }}
                                    ( {{ terbilang($pembelians->harga * $pembelians->jumlah_unit, 0, ',', '.') }} )
                                </td>
                            </tr>
                        @endif
                        <tr>
                            <td>
                                <img style="margin-top: 5px"
                                    src="{{ asset('storage/uploads/gambar_logo/arrows.png') }}" width="8"
                                    height="8" alt="Logo Tigerload">
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
                                    src="{{ asset('storage/uploads/gambar_logo/arrows.png') }}" width="8"
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
                                    src="{{ asset('storage/uploads/gambar_logo/arrows.png') }}" width="8"
                                    height="8" alt="Logo Tigerload">
                            </td>
                            <td>Rekening Bank</td>
                            <td>
                                <div style="margin-left: 70px">
                                    :
                                </div>
                            </td>
                            <td>
                                @if ($pembelians->kategori == 'PPN')
                                    BCA 3621889999 Atas Nama : CV Tiger Load Engineering
                                @else
                                    BCA 3629888889 Atas Nama : Djohan Wahyudi
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
                <div style="margin-top:30px">
                    <p style="font-size: 25px; text-align: left; margin: 0; margin-left: 147px;">Demikian surat
                        penawaran ini kami
                        sampaikan. Atas kerjasama dan kepercayaan yang diberikan kami </p>
                    <p style="font-size: 25px; text-align: left; margin: 0; margin-left: 70px;">sampaikan terimakasih.
                    </p>
                </div>
                <div style="margin-top:10px">
                    <p style="font-size: 25px; text-align: left; margin: 0; margin-left: 70px;">Hormat Kami,
                    </p>
                </div>

                <div class="info-container">
                    <div id="logo-container">
                        <div style="margin-top:30px; margin-bottom:100px">
                            <p style="font-size: 25px; text-align: left; margin: 0; margin-left: 70px;">KAROSERI TIGER
                                LOAD
                            </p>
                        </div>

                        <p
                            style="font-size: 25px; text-align: left; margin: 0; margin-left: 90px; text-decoration: underline;">
                            DJOHAN WAHYUDI</p>

                    </div>
                    <div style="display: flex; justify-content: center; align-items: center;">
                        <div id="logo-container">
                            <div style="margin-top:30px">
                                <p style="font-size: 25px; text-align: center; margin: 0; margin-left: 70px;">PEMESAN
                                </p>
                            </div>
                            <img style="margin-left: 60px;"
                                src="{{ asset('storage/uploads/gambar_logo/kotak.png') }}" width="410"
                                height="100" alt="Logo Tigerload">
                            <p
                                style="font-size: 25px; text-align: center; margin: 0; margin-left: 70px; text-decoration: underline;">
                                {{ strtoupper($pembelians->pelanggan->nama_pelanggan) }}
                            </p>

                        </div>
                    </div>
                </div>

                <div
                    style="font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif; border: 3px solid #000; padding: 10px; margin-left: 80px; font-size: 21px;">
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
                                @if ($pembelians->kategori == 'NON PPN')
                                    <div style="margin-left: 10px">
                                        Harga belum termasuk PPN
                                    </div>
                                @else
                                    <div style="margin-left: 10px">
                                        Harga sudah termasuk PPN
                                    </div>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>3.</td>
                            <td>
                                <div style="margin-left: 10px">
                                    Adanya penambahan ukuran atau model diluar surat penawaran dikenakan biaya tambahan.
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
                                    Apabila terjadi pembatalan pemesanan oleh pihak pemesan, maka Uang Muka yang sudah
                                    masuk tidak dapat diambil
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <div style="margin-left: 10px">
                                    kembali ataupun diakumulasikan ke unit yang lain(jika pesanan lebih dari satu unit)
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
            </td>
        </tr>
    </table>

    <div class="container">
        <a href="{{ url('admin/tablesurat') }}" class="blue-button">Kembali</a>
        <a href="{{ url('admin/surat_penawaran/cetak-pdf/' . $pembelians->id) }}" class="blue-button">Cetak</a>
    </div>
</body>


</html>
