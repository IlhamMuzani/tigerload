<!DOCTYPE html>
<html>

<head>
    <!-- Basic -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- Site Metas -->
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <link rel="shortcut icon" href="{{ asset('qrcode/images/fevicon.png') }}" type="">

    <title> TIGER LOAD ENGINEERING</title>


    <!-- bootstrap core css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('qrcode/css/bootstrap.css') }}" />

    <!-- fonts style -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">

    <!--owl slider stylesheet -->
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />

    <!-- font awesome style -->
    <link href="{{ asset('qrcode/css/font-awesome.min.css') }}" rel="stylesheet" />

    <!-- Custom styles for this template -->
    <link href="{{ asset('qrcode/css/style.css') }}" rel="stylesheet" />
    <!-- responsive style -->
    <link href="{{ asset('qrcode/css/responsive.css') }}" rel="stylesheet" />

</head>

<body>

    <div class="hero_area">
        <!-- header section strats -->
        <header class="header_section">
            <div class="header_top">
                <div class="container-fluid ">
                    <div class="">
                        <a href="">
                            <span style="color: aliceblue; margin-left:10px; font-weight:bold">
                                {{ $cetakpdf->kode_project }}
                            </span>
                        </a>

                    </div>
                </div>
            </div>
            <div class="header_bottom">
                <div class="container-fluid">
                    <nav class="navbar navbar-expand-lg custom_nav-container ">
                        <a class="navbar-brand" href="{{ asset('qrcode/index.html') }}">
                            <span>
                                <img src="{{ asset('storage/uploads/gambar_logo/login2.png') }}" alt="TIGER LOAD"
                                    width="185" height="45">
                            </span>
                        </a>
                    </nav>
                </div>
            </div>
        </header>
        <!-- end header section -->
        <!-- slider section -->
        <section class="slider_section ">
            <div class="slider_bg_box">
                @if ($cetakpdf->perintah_kerja->dokumen_project->first()->gambar_depan == null)
                    <img src="{{ asset('qrcode/images/slider-bg.jpg') }}" alt="">
                @else
                    <img class="mt-3"
                        src="{{ asset('storage/uploads/' . $cetakpdf->perintah_kerja->dokumen_project->first()->gambar_depan) }}"
                        alt="tigerload" style="max-width: 100%; max-height: 100%; object-fit: cover;">
                @endif
            </div>
            <div id="customCarousel1" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="container ">
                            <div class="row">
                                <div class="col-md-7 ">
                                    <div class="detail-box">
                                        {{-- <h1>
                                            KAROSERI <br>
                                            TIGER LOAD ENGINEERING
                                        </h1> --}}
                                        {{-- <p>
                                            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Eum magnam,
                                            voluptates distinctio, officia architecto tenetur debitis hic aspernatur
                                            libero commodi atque fugit adipisci, blanditiis quidem dolorum odit
                                            voluptas? Voluptate, eveniet?
                                        </p> --}}

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </section>
        <!-- end slider section -->
    </div>


    <!-- service section -->

    <section class="service_section" style="margin-top:70px">
        <div class="service_container">
            <div class="container ">
                <div class="heading_container">
                    <h2 style="font-size: 28px">
                        Data Pelanggan</span>
                    </h2>
                    <p>

                    </p>
                </div>
                <div class="detail-box">
                    <style>
                        table {
                            font-family: arial, sans-serif;
                            border-collapse: collapse;
                            width: 100%;
                        }

                        td,
                        th {
                            border: 1px solid #cacaca;
                            text-align: left;
                            padding: 8px;
                        }

                        tr:nth-child(even) {
                            background-color: #dddddd;
                        }
                    </style>
                    <table width="100%">
                        <tr>
                            <td width="50%" valign="top">
                                Kode Pelanggan
                            </td>
                            <td width="50%">{{ $cetakpdf->perintah_kerja->pelanggan->kode_pelanggan }}</td>
                        </tr>
                        <tr>
                            <td width="50%" valign="top">
                                Nama Pelanggan
                            </td>
                            <td width="50%">{{ $cetakpdf->perintah_kerja->pelanggan->nama_pelanggan }}</td>
                        </tr>
                        {{-- <tr>
                            <td width="50%" valign="top">
                                Telp
                            </td>
                            <td width="50%">{{ $cetakpdf->perintah_kerja->pelanggan->telp }}</td>
                        </tr>
                        <tr>
                            <td width="50%" valign="top">
                                Alamat
                            </td>
                            <td width="50%">{{ $cetakpdf->perintah_kerja->pelanggan->alamat }}</td>
                        </tr> --}}
                    </table>

                </div>
            </div>
        </div>
    </section>

    <section class="service_section" style="margin-top:70px">
        <div class="service_container">
            <div class="container">
                <div class="heading_container">
                    <h2 style="font-size: 28px">
                        Karoseri</span>
                    </h2>
                    <p>
                    </p>
                </div>
                <div class="detail-box">
                    <table width="100%">
                        <tr>
                            <td width="50%" valign="top">
                                Kode Karoseri
                            </td>
                            <td>{{ $cetakpdf->perintah_kerja->spk->surat_penawaran->typekaroseri->kode_type }}</td>
                        </tr>
                        <tr>
                            <td valign="top">
                                Jenis Karoseri
                            </td>
                            <td>{{ $cetakpdf->perintah_kerja->spk->surat_penawaran->typekaroseri->nama_karoseri }}</td>
                        </tr>
                        <tr>
                            <td width="50%" valign="top">
                                Merek
                            </td>
                            <td>{{ $cetakpdf->perintah_kerja->spk->surat_penawaran->typekaroseri->merek->nama_merek }}
                            </td>
                        </tr>
                        <tr>
                            <td width="50%" valign="top">
                                Type
                            </td>
                            <td>{{ $cetakpdf->perintah_kerja->spk->surat_penawaran->typekaroseri->merek->tipe->nama_tipe }}
                            </td>
                        </tr>
                        <tr>
                            <td width="50%" valign="top">
                                Nomor Rangka
                            </td>
                            <td>
                                @if ($cetakpdf->perintah_kerja->dokumen_project && $cetakpdf->perintah_kerja->dokumen_project->isNotEmpty())
                                    {{ $cetakpdf->perintah_kerja->dokumen_project->first()->no_rangka }}
                                @else
                                    -
                                @endif
                            </td>

                        </tr>
                        <tr>
                            <td width="50%" valign="top">
                                Tahun Pembuatan
                            </td>
                            <td>
                                @if ($cetakpdf->perintah_kerja->dokumen_project && $cetakpdf->perintah_kerja->dokumen_project->isNotEmpty())
                                    {{ $cetakpdf->perintah_kerja->dokumen_project->first()->tahun }}
                                @else
                                    -
                                @endif
                            </td>

                        </tr>
                        {{-- <tr>
                            <td width="50%" valign="top">
                                Nomor Mesin
                            </td>
                            <td width="50%" valign="top">
                                @if ($cetakpdf->perintah_kerja->dokumen_project && $cetakpdf->perintah_kerja->dokumen_project->isNotEmpty())
                                    {{ $cetakpdf->perintah_kerja->dokumen_project->first()->no_mesin }}
                                @else
                                    -
                                @endif
                            </td>
                        </tr> --}}
                        <tr>
                            <td width="50%" valign="top">
                                Nomor SRUT
                            </td>
                            <td width="50%" valign="top">
                                @if ($cetakpdf->perintah_kerja->dokumen_project && $cetakpdf->perintah_kerja->dokumen_project->isNotEmpty())
                                    {{ $cetakpdf->perintah_kerja->dokumen_project->first()->no_serut }}
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td width="50%" valign="top">
                                Nomor SKRB
                            </td>
                            <td width="50%" valign="top">
                                @if ($cetakpdf->perintah_kerja->dokumen_project && $cetakpdf->perintah_kerja->dokumen_project->isNotEmpty())
                                    {{ $cetakpdf->perintah_kerja->dokumen_project->first()->no_serut }}
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td width="50%" valign="top">
                                Panjang
                            </td>
                            <td width="50%" valign="top">
                                {{ $cetakpdf->perintah_kerja->spk->surat_penawaran->typekaroseri->panjang }}
                            </td>
                        </tr>
                        <tr>
                            <td width="50%" valign="top">
                                Lebar
                            </td>
                            <td width="50%" valign="top">
                                {{ $cetakpdf->perintah_kerja->spk->surat_penawaran->typekaroseri->lebar }}
                            </td>
                        </tr>
                        <tr>
                            <td width="50%" valign="top">
                                Tinggi
                            </td>
                            <td width="50%" valign="top">
                                {{ $cetakpdf->perintah_kerja->spk->surat_penawaran->typekaroseri->tinggi }}
                            </td>
                        </tr>
                        <tr>
                            <td width="50%" valign="top">
                                Spesifikasi
                            </td>
                            <td width="50%" valign="top">

                                @foreach ($cetakpdf->perintah_kerja->spk->surat_penawaran->typekaroseri->spesifikasi as $spesifikasi)
                                    <li>{{ $spesifikasi->nama }}</li>
                                @endforeach
                            </td>
                        </tr>

                    </table>
                </div>
            </div>
        </div>
    </section>


    <section class="service_section" style="margin-top:70px; margin-bottom:10px">
        <div class="service_container">
            <div class="container ">
                <div class="heading_container">
                    <h2 style="font-size: 28px">
                        Bentuk Fisik Karoseri
                    </h2>
                </div>
                <br>
                <div class="row justify-content-center">
                    <div class="col-md-3 col-sm-6 text-center mb-4">
                        <div class="d-flex justify-content-center align-items-center flex-column">
                            <div class="boxs"
                                style="width: 200px; height: 200px; border: 1px solid #ccc; overflow: hidden; position: relative;">
                                @if ($cetakpdf->perintah_kerja->dokumen_project->first()->gambar_depan == null)
                                    <img src="{{ asset('storage/uploads/gambaricon/imagenoimage.jpg') }}"
                                        alt="tigerload" style="max-width: 100%; max-height: 100%; object-fit: cover;">
                                @else
                                    <img class="mt-3"
                                        src="{{ asset('storage/uploads/' . $cetakpdf->perintah_kerja->dokumen_project->first()->gambar_depan) }}"
                                        alt="tigerload" style="max-width: 100%; max-height: 100%; object-fit: cover;">
                                @endif
                            </div>
                            <p style="text-align: center; margin-top:5px">Tampak Depan</p>
                        </div>
                    </div>


                    <div class="col-md-3 col-sm-6 text-center mb-4">
                        <div class="d-flex justify-content-center align-items-center flex-column">
                            <div class="boxs"
                                style="width: 200px; height: 200px; border: 1px solid #ccc; overflow: hidden; position: relative;">
                                @if ($cetakpdf->perintah_kerja->dokumen_project->first()->gambar_belakang == null)
                                    <img src="{{ asset('storage/uploads/gambaricon/imagenoimage.jpg') }}"
                                        alt="tigerload" style="max-width: 100%; max-height: 100%; object-fit: cover;">
                                @else
                                    <img class="mt-3"
                                        src="{{ asset('storage/uploads/' . $cetakpdf->perintah_kerja->dokumen_project->first()->gambar_belakang) }}"
                                        alt="tigerload" style="max-width: 100%; max-height: 100%; object-fit: cover;">
                                @endif
                            </div>
                            <p style="text-align: center; margin-top:5px">Tampak Belakang</p>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6 text-center mb-4">
                        <div class="d-flex justify-content-center align-items-center flex-column">
                            <div class="boxs"
                                style="width: 200px; height: 200px; border: 1px solid #ccc; overflow: hidden; position: relative;">
                                @if ($cetakpdf->perintah_kerja->dokumen_project->first()->gambar_kanan == null)
                                    <img src="{{ asset('storage/uploads/gambaricon/imagenoimage.jpg') }}"
                                        alt="tigerload" style="max-width: 100%; max-height: 100%; object-fit: cover;">
                                @else
                                    <img class="mt-3"
                                        src="{{ asset('storage/uploads/' . $cetakpdf->perintah_kerja->dokumen_project->first()->gambar_kanan) }}"
                                        alt="tigerload" style="max-width: 100%; max-height: 100%; object-fit: cover;">
                                @endif
                            </div>
                            <p style="text-align: center; margin-top:5px">Tampak Kanan</p>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6 text-center mb-4">
                        <div class="d-flex justify-content-center align-items-center flex-column">
                            <div class="boxs"
                                style="width: 200px; height: 200px; border: 1px solid #ccc; overflow: hidden; position: relative;">
                                @if ($cetakpdf->perintah_kerja->dokumen_project->first()->gambar_kiri == null)
                                    <img src="{{ asset('storage/uploads/gambaricon/imagenoimage.jpg') }}"
                                        alt="tigerload" style="max-width: 100%; max-height: 100%; object-fit: cover;">
                                @else
                                    <img class="mt-3"
                                        src="{{ asset('storage/uploads/' . $cetakpdf->perintah_kerja->dokumen_project->first()->gambar_kiri) }}"
                                        alt="tigerload" style="max-width: 100%; max-height: 100%; object-fit: cover;">
                                @endif
                            </div>
                            <p style="text-align: center; margin-top:5px">Tampak Kiri</p>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6 text-center mb-4">
                        <div class="d-flex justify-content-center align-items-center flex-column">
                            <div class="boxs"
                                style="width: 200px; height: 200px; border: 1px solid #ccc; overflow: hidden; position: relative;">
                                @if ($cetakpdf->perintah_kerja->typekaroseri->gambar_skrb == null)
                                    <img src="{{ asset('storage/uploads/gambaricon/imagenoimage.jpg') }}"
                                        alt="tigerload" style="max-width: 100%; max-height: 100%; object-fit: cover;">
                                @else
                                    <img class="mt-3"
                                        src="{{ asset('storage/uploads/' . $cetakpdf->perintah_kerja->typekaroseri->gambar_skrb) }}"
                                        alt="tigerload" style="max-width: 100%; max-height: 100%; object-fit: cover;">
                                @endif
                            </div>
                            <p style="text-align: center; margin-top:5px">Gambar SKRB</p>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </section>

    <!-- end client section -->

    <!-- contact section -->

    <!-- end contact section -->

    <!-- info section -->

    <section class="info_section layout_padding2">
        <div class="container">
            <div style="text-align: center">
                <div class="info_contact">
                    <h4>
                        CV. TIGER LOAD ENGINEERING
                    </h4>
                    <div class="contact_link_box">
                        <a href="">
                            <i aria-hidden="true"></i>
                            <span>
                                Jl. Ahmad Yani No. 42 Procot Slawi, Tegal 52411
                            </span>
                        </a>
                        <a href="">
                            <i aria-hidden="true"></i>
                            <span>
                                Telp, (0283) 4563746
                            </span>
                        </a>
                        <a href="">
                            <i aria-hidden="true"></i>
                            <span>
                                No. Izin Karoseri : 400.7.22/ 11428
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- end info section -->

    <!-- footer section -->
    <section class="footer_section">
        <div class="container">
            <p>
                {{-- &copy; <span id="displayYear"></span> All Rights Reserved By
                <a href="https://html.design/">Free Html Templates</a>
                Distributed By
                <a href="https://themewagon.com">ThemeWagon</a> --}}
            </p>
        </div>
    </section>
    <!-- footer section -->

    <!-- jQery -->
    <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
    <!-- popper js -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <!-- bootstrap js -->
    <script type="text/javascript" src="{{ asset('qrcode/js/bootstrap.js') }}"></script>
    <!-- owl slider -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js">
    </script>
    <!-- custom js -->
    <script type="text/javascript" src="{{ asset('qrcode/js/custom.js') }}"></script>
    <!-- Google Map -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCh39n5U-4IoWpsVGUHWdqB6puEkhRLdmI&callback=myMap">
    </script>
    <!-- End Google Map -->

</body>

</html>
