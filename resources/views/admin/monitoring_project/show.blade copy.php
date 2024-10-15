@extends('layouts.app')

@section('title', 'Progres Pengerjaan')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Progres Pengerjaan</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/progres_pengerjaan') }}">Progres Pengerjaan</a>
                        </li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <section class="content">
        <div class="container-fluid">
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5>
                        <i class="icon fas fa-ban"></i> Gagal Menyimpan!
                    </h5>
                    @foreach (session('error') as $error)
                        - {{ $error }} <br>
                    @endforeach
                </div>
            @endif
            <form action="{{ url('admin/progres_pengerjaan/' . $progres->id) }}" method="POST"
                enctype="multipart/form-data" autocomplete="off">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Progres Pengerjaan</h3>
                    </div>
                    <!-- /.card-header -->
                    @csrf
                    @method('put')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nama">No SPK</label>
                            <input readonly type="text" class="form-control" id="kode_perintah" name="kode_perintah"
                                placeholder="Masukan nama lengkap"
                                value="{{ old('kode_perintah', $progres->kode_perintah) }}">
                        </div>
                        <div class="form-group">
                            <label for="nama">Pelanggan</label>
                            <input readonly type="text" class="form-control" id="nama_pelanggan" name="nama_pelanggan"
                                placeholder="Masukan nama kecil"
                                value="{{ old('nama_pelanggan', $progres->pelanggan->nama_pelanggan ?? null) }}">
                        </div>
                        <div class="form-group">
                            <label for="nama">Bentuk Karoseri</label>
                            <input readonly type="text" class="form-control" id="nama_karoseri" name="nama_karoseri"
                                placeholder="Masukan nama lengkap"
                                value="{{ old('nama_karoseri', $progres->spk->typekaroseri->nama_karoseri ?? null) }}">
                        </div>
                        <div class="form-group">
                            <label for="nama">Tanggal</label>
                            <input readonly type="text" class="form-control" id="tanggal" name="tanggal"
                                placeholder="Masukan nama kecil" value="{{ old('tanggal', $progres->tanggal_awal) }}">
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="row text-center ml-4">
                        <div class="mb-5">
                            <div class="form-group mb-3">
                                <img class="mt-3" src="{{ asset('storage/uploads/gambaricon/loading.jpg') }}"
                                    alt="tigerload" height="120" width="140">
                            </div>
                            <div>
                                <!-- Kurangi margin pada elemen <p> -->
                                <p style="margin: 5px 0; font-weight:bold">TUNGGU PRODUKSI</p>
                                <p style="margin: 5px 0;">
                                    <i class="fas fa-calendar-alt" style="color: gray;"></i> Tanggal
                                </p>

                                <p style="margin: 5px 0;">Status : <span style="font-size: 12px"
                                        class="badge badge-success">Sedang diproses</span></p>
                            </div>
                        </div>


                        <div class="form-group mb-3">
                            <!-- Garis dengan panjang 5 cm -->
                            <hr style="border: 2px solid #000; width: 4cm; margin: 20px auto; margin-top:75px">
                        </div>

                        <div>
                            <div class="form-group mb-3">
                                <img class="mt-3" src="{{ asset('storage/uploads/gambaricon/loading.jpg') }}"
                                    alt="tigerload" height="120" width="140">
                            </div>
                            <div>
                                <!-- Kurangi margin pada elemen <p> -->
                                <p style="margin: 5px 0; font-weight:bold">NAIK PRODUKSI</p>
                                <p style="margin: 5px 0;">
                                    <i class="fas fa-calendar-alt" style="color: gray;"></i> Tanggal
                                </p>

                                <p style="margin: 5px 0;">Status : <span style="font-size: 12px"
                                        class="badge badge-info">Belum diproses</span></p>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <!-- Garis dengan panjang 5 cm -->
                            <hr style="border: 2px solid #000; width: 4cm; margin: 20px auto; margin-top:75px">
                        </div>

                        <div>
                            <div class="form-group mb-3">
                                <img class="mt-3" src="{{ asset('storage/uploads/gambaricon/loading.jpg') }}"
                                    alt="tigerload" height="120" width="140">
                            </div>
                            <div>
                                <!-- Kurangi margin pada elemen <p> -->
                                <p style="margin: 5px 0; font-weight:bold">PENGERJAAN LANTAI</p>
                                <p style="margin: 5px 0;">
                                    <i class="fas fa-calendar-alt" style="color: gray;"></i> Tanggal
                                </p>

                                <p style="margin: 5px 0;">Status : <span style="font-size: 12px"
                                        class="badge badge-info">Belum diproses</span></p>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <!-- Garis dengan panjang 5 cm -->
                            <hr style="border: 2px solid #000; width: 4cm; margin: 20px auto; margin-top:75px">
                        </div>

                        <div>
                            <div class="form-group mb-3">
                                <img class="mt-3" src="{{ asset('storage/uploads/gambaricon/loading.jpg') }}"
                                    alt="tigerload" height="120" width="140">
                            </div>
                            <div>
                                <!-- Kurangi margin pada elemen <p> -->
                                <p style="margin: 5px 0; font-weight:bold">PENGERJAAN DINDING</p>
                                <p style="margin: 5px 0;">
                                    <i class="fas fa-calendar-alt" style="color: gray;"></i> Tanggal
                                </p>

                                <p style="margin: 5px 0;">Status : <span style="font-size: 12px"
                                        class="badge badge-info">Belum diproses</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
