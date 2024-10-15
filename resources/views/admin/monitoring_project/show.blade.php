@extends('layouts.app')

@section('title', 'Monitoring Project')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Monitoring Project</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/progres_pengerjaan') }}">Monitoring Project</a>
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
                        <h3 class="card-title">Monitoring Project</h3>
                    </div>
                    <!-- /.card-header -->
                    @csrf
                    @method('put')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nama">No SPK</label>
                            <p class="form-control-plaintext" id="kode_perintah">
                                {{ old('kode_perintah', $progres->kode_perintah) }}</p>
                        </div>
                        <div class="form-group">
                            <label for="nama_pelanggan">Pelanggan</label>
                            <p class="form-control-plaintext" id="nama_pelanggan">
                                {{ old('nama_pelanggan', $progres->pelanggan->nama_pelanggan ?? 'Tidak ada pelanggan') }}
                            </p>
                        </div>
                        <div class="form-group">
                            <label for="nama_karoseri">Bentuk Karoseri</label>
                            <p class="form-control-plaintext" id="nama_karoseri">
                                {{ old('nama_karoseri', $progres->spk->typekaroseri->nama_karoseri ?? 'Tidak ada karoseri') }}
                            </p>
                        </div>
                        <div class="form-group">
                            <label for="tanggal">Tanggal</label>
                            <p class="form-control-plaintext" id="tanggal">{{ old('tanggal', $progres->tanggal_awal) }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="row text-center ml-4 mr-4" style="display: flex; flex-wrap: nowrap; overflow-x: auto;">
                        <div class="mb-5" style="flex: 0 0 auto; margin-right: 20px;">
                            <div class="form-group mb-3">
                                @if (
                                    $progres->status_pengerjaan == 'naik produksi' ||
                                        $progres->status_pengerjaan == 'pengerjaan lantai' ||
                                        $progres->status_pengerjaan == 'pengerjaan dinding' ||
                                        $progres->status_pengerjaan == 'pengelasan' ||
                                        $progres->status_pengerjaan == 'naik sasis' ||
                                        $progres->status_pengerjaan == 'proses pengecatan' ||
                                        $progres->status_pengerjaan == 'selesai produksi' ||
                                        $progres->status_pengerjaan == 'pengajuan serut' ||
                                        $progres->status_pengerjaan == 'selesai pemeriksaan' ||
                                        $progres->status_pengerjaan == 'diterima customer')
                                    <img class="mt-3" src="{{ asset('storage/uploads/gambaricon/check.jpg') }}"
                                        alt="tigerload" height="140" width="140">
                                @else
                                    <img class="mt-3" src="{{ asset('storage/uploads/gambaricon/loading.jpg') }}"
                                        alt="tigerload" height="140" width="140">
                                @endif
                            </div>
                            <div>
                                <p style="margin: 5px 0; font-weight:bold;">TUNGGU PRODUKSI</p>
                                <p style="margin: 5px 0;">
                                    <i class="fas fa-calendar-alt" style="color: gray;"></i> Tanggal :
                                    {{ $progres->tgl_tungguproduksi }}
                                </p>
                                @if ($progres->status_pengerjaan == 'tunggu produksi')
                                    <p style="margin: 5px 0;">Status : <span style="font-size: 12px"
                                            class="badge badge-warning">Sedang diproses</span></p>
                                @elseif(
                                    $progres->status_pengerjaan == 'naik produksi' ||
                                        $progres->status_pengerjaan == 'pengerjaan lantai' ||
                                        $progres->status_pengerjaan == 'pengerjaan dinding' ||
                                        $progres->status_pengerjaan == 'pengelasan' ||
                                        $progres->status_pengerjaan == 'naik sasis' ||
                                        $progres->status_pengerjaan == 'proses pengecatan' ||
                                        $progres->status_pengerjaan == 'selesai produksi' ||
                                        $progres->status_pengerjaan == 'pengajuan serut' ||
                                        $progres->status_pengerjaan == 'selesai pemeriksaan' ||
                                        $progres->status_pengerjaan == 'diterima customer')
                                    <p style="margin: 5px 0;">Status : <span style="font-size: 12px"
                                            class="badge badge-success">Selesai</span></p>
                                @else
                                    <p style="margin: 5px 0;">Status : <span style="font-size: 12px"
                                            class="badge badge-info">Belum diproses</span></p>
                                @endif
                            </div>
                        </div>

                        <div class="form-group mb-3" style="flex: 0 0 auto; margin-right: 20px;">
                            <hr style="border: 2px solid #000; width: 4cm; margin: 20px auto; margin-top:75px">
                        </div>

                        <div class="mb-5" style="flex: 0 0 auto; margin-right: 20px;">
                            <div class="form-group mb-3">
                                @if (
                                    $progres->status_pengerjaan == 'pengerjaan lantai' ||
                                        $progres->status_pengerjaan == 'pengerjaan dinding' ||
                                        $progres->status_pengerjaan == 'pengelasan' ||
                                        $progres->status_pengerjaan == 'naik sasis' ||
                                        $progres->status_pengerjaan == 'proses pengecatan' ||
                                        $progres->status_pengerjaan == 'selesai produksi' ||
                                        $progres->status_pengerjaan == 'pengajuan serut' ||
                                        $progres->status_pengerjaan == 'selesai pemeriksaan' ||
                                        $progres->status_pengerjaan == 'diterima customer')
                                    <img class="mt-3" src="{{ asset('storage/uploads/gambaricon/check.jpg') }}"
                                        alt="tigerload" height="140" width="140">
                                @else
                                    <img class="mt-3" src="{{ asset('storage/uploads/gambaricon/loading.jpg') }}"
                                        alt="tigerload" height="140" width="140">
                                @endif
                            </div>
                            <div>
                                <p style="margin: 5px 0; font-weight:bold">NAIK PRODUKSI</p>
                                <p style="margin: 5px 0;">
                                    <i class="fas fa-calendar-alt" style="color: gray;"></i> Tanggal :
                                    {{ $progres->tgl_naikproduksi }}
                                </p>
                                @if ($progres->status_pengerjaan == 'naik produksi')
                                    <p style="margin: 5px 0;">Status : <span style="font-size: 12px"
                                            class="badge badge-warning">Sedang diproses</span></p>
                                @elseif(
                                    $progres->status_pengerjaan == 'pengerjaan lantai' ||
                                        $progres->status_pengerjaan == 'pengerjaan dinding' ||
                                        $progres->status_pengerjaan == 'pengelasan' ||
                                        $progres->status_pengerjaan == 'naik sasis' ||
                                        $progres->status_pengerjaan == 'proses pengecatan' ||
                                        $progres->status_pengerjaan == 'selesai produksi' ||
                                        $progres->status_pengerjaan == 'pengajuan serut' ||
                                        $progres->status_pengerjaan == 'selesai pemeriksaan' ||
                                        $progres->status_pengerjaan == 'diterima customer')
                                    <p style="margin: 5px 0;">Status : <span style="font-size: 12px"
                                            class="badge badge-success">Selesai</span></p>
                                @else
                                    <p style="margin: 5px 0;">Status : <span style="font-size: 12px"
                                            class="badge badge-info">Belum diproses</span></p>
                                @endif
                            </div>
                        </div>

                        <div class="form-group mb-3" style="flex: 0 0 auto; margin-right: 20px;">
                            <hr style="border: 2px solid #000; width: 4cm; margin: 20px auto; margin-top:75px">
                        </div>

                        <div class="mb-5" style="flex: 0 0 auto; margin-right: 20px;">
                            <div class="form-group mb-3">
                                @if (
                                    $progres->status_pengerjaan == 'pengerjaan lantai' ||
                                        $progres->status_pengerjaan == 'pengerjaan dinding' ||
                                        $progres->status_pengerjaan == 'pengelasan' ||
                                        $progres->status_pengerjaan == 'naik sasis' ||
                                        $progres->status_pengerjaan == 'proses pengecatan' ||
                                        $progres->status_pengerjaan == 'selesai produksi' ||
                                        $progres->status_pengerjaan == 'pengajuan serut' ||
                                        $progres->status_pengerjaan == 'selesai pemeriksaan' ||
                                        $progres->status_pengerjaan == 'diterima customer')
                                    <img src="{{ asset('storage/uploads/' . $progres->ft_pengerjaanlantai) }}"
                                        height="140" width="140" class="w-100 rounded border mt-4">
                                @else
                                    <img class="mt-3" src="{{ asset('storage/uploads/gambaricon/loading.jpg') }}"
                                        alt="tigerload" height="140" width="140">
                                @endif
                            </div>
                            <div>
                                <p style="margin: 5px 0; font-weight:bold">PENGERJAAN LANTAI</p>
                                <p style="margin: 5px 0;">
                                    <i class="fas fa-calendar-alt" style="color: gray;"></i> Tanggal :
                                    {{ $progres->tgl_pengerjaanlantai }}
                                </p>
                                @if ($progres->status_pengerjaan == 'pengerjaan lantai')
                                    <p style="margin: 5px 0;">Status : <span style="font-size: 12px"
                                            class="badge badge-warning">Sedang diproses</span></p>
                                @elseif(
                                    $progres->status_pengerjaan == 'pengerjaan dinding' ||
                                        $progres->status_pengerjaan == 'pengelasan' ||
                                        $progres->status_pengerjaan == 'naik sasis' ||
                                        $progres->status_pengerjaan == 'proses pengecatan' ||
                                        $progres->status_pengerjaan == 'selesai produksi' ||
                                        $progres->status_pengerjaan == 'pengajuan serut' ||
                                        $progres->status_pengerjaan == 'selesai pemeriksaan' ||
                                        $progres->status_pengerjaan == 'diterima customer')
                                    <p style="margin: 5px 0;">Status : <span style="font-size: 12px"
                                            class="badge badge-success">Selesai</span></p>
                                @else
                                    <p style="margin: 5px 0;">Status : <span style="font-size: 12px"
                                            class="badge badge-info">Belum diproses</span></p>
                                @endif
                            </div>
                        </div>

                        <div class="form-group mb-3" style="flex: 0 0 auto; margin-right: 20px;">
                            <hr style="border: 2px solid #000; width: 4cm; margin: 20px auto; margin-top:75px">
                        </div>

                        <div class="mb-5" style="flex: 0 0 auto; margin-right: 20px;">
                            <div class="form-group mb-3">
                                @if (
                                    $progres->status_pengerjaan == 'pengerjaan dinding' ||
                                        $progres->status_pengerjaan == 'pengelasan' ||
                                        $progres->status_pengerjaan == 'naik sasis' ||
                                        $progres->status_pengerjaan == 'proses pengecatan' ||
                                        $progres->status_pengerjaan == 'selesai produksi' ||
                                        $progres->status_pengerjaan == 'pengajuan serut' ||
                                        $progres->status_pengerjaan == 'selesai pemeriksaan' ||
                                        $progres->status_pengerjaan == 'diterima customer')
                                    <img src="{{ asset('storage/uploads/' . $progres->ft_pengerjaandinding) }}"
                                        height="140" width="140" class="w-100 rounded border mt-4">
                                @else
                                    <img class="mt-3" src="{{ asset('storage/uploads/gambaricon/loading.jpg') }}"
                                        alt="tigerload" height="140" width="140">
                                @endif
                            </div>
                            <div>
                                <p style="margin: 5px 0; font-weight:bold">PENGERJAAN DINDING</p>
                                <p style="margin: 5px 0;">
                                    <i class="fas fa-calendar-alt" style="color: gray;"></i> Tanggal :
                                    {{ $progres->tgl_pengerjaandinding }}
                                </p>
                                @if ($progres->status_pengerjaan == 'pengerjaan dinding')
                                    <p style="margin: 5px 0;">Status : <span style="font-size: 12px"
                                            class="badge badge-warning">Sedang diproses</span></p>
                                @elseif(
                                    $progres->status_pengerjaan == 'pengelasan' ||
                                        $progres->status_pengerjaan == 'naik sasis' ||
                                        $progres->status_pengerjaan == 'proses pengecatan' ||
                                        $progres->status_pengerjaan == 'selesai produksi' ||
                                        $progres->status_pengerjaan == 'pengajuan serut' ||
                                        $progres->status_pengerjaan == 'selesai pemeriksaan' ||
                                        $progres->status_pengerjaan == 'diterima customer')
                                    <p style="margin: 5px 0;">Status : <span style="font-size: 12px"
                                            class="badge badge-success">Selesai</span></p>
                                @else
                                    <p style="margin: 5px 0;">Status : <span style="font-size: 12px"
                                            class="badge badge-info">Belum diproses</span></p>
                                @endif
                            </div>
                        </div>

                        <div class="form-group mb-3" style="flex: 0 0 auto; margin-right: 20px;">
                            <hr style="border: 2px solid #000; width: 4cm; margin: 20px auto; margin-top:75px">
                        </div>

                        <div class="mb-5" style="flex: 0 0 auto;">
                            <div class="form-group mb-3">
                                @if (
                                    $progres->status_pengerjaan == 'pengelasan' ||
                                        $progres->status_pengerjaan == 'naik sasis' ||
                                        $progres->status_pengerjaan == 'proses pengecatan' ||
                                        $progres->status_pengerjaan == 'selesai produksi' ||
                                        $progres->status_pengerjaan == 'pengajuan serut' ||
                                        $progres->status_pengerjaan == 'selesai pemeriksaan' ||
                                        $progres->status_pengerjaan == 'diterima customer')
                                    <img src="{{ asset('storage/uploads/' . $progres->ft_pengerjaandinding) }}"
                                        height="140" width="140" class="w-100 rounded border mt-4">
                                @else
                                    <img class="mt-3" src="{{ asset('storage/uploads/gambaricon/loading.jpg') }}"
                                        alt="tigerload" height="140" width="140">
                                @endif
                            </div>
                            <div>
                                <p style="margin: 5px 0; font-weight:bold">PENGELASAN</p>
                                <p style="margin: 5px 0;">
                                    <i class="fas fa-calendar-alt" style="color: gray;"></i> Tanggal :
                                    {{ $progres->tgl_pengelasan }}
                                </p>
                                @if ($progres->status_pengerjaan == 'pengelasan')
                                    <p style="margin: 5px 0;">Status : <span style="font-size: 12px"
                                            class="badge badge-warning">Sedang diproses</span></p>
                                @elseif(
                                    $progres->status_pengerjaan == 'naik sasis' ||
                                        $progres->status_pengerjaan == 'proses pengecatan' ||
                                        $progres->status_pengerjaan == 'selesai produksi' ||
                                        $progres->status_pengerjaan == 'pengajuan serut' ||
                                        $progres->status_pengerjaan == 'selesai pemeriksaan' ||
                                        $progres->status_pengerjaan == 'diterima customer')
                                    <p style="margin: 5px 0;">Status : <span style="font-size: 12px"
                                            class="badge badge-success">Selesai</span></p>
                                @else
                                    <p style="margin: 5px 0;">Status : <span style="font-size: 12px"
                                            class="badge badge-info">Belum diproses</span></p>
                                @endif
                            </div>
                        </div>
                        <div class="form-group mb-3" style="flex: 0 0 auto; margin-right: 20px;">
                            <hr style="border: 2px solid #000; width: 4cm; margin: 20px auto; margin-top:75px">
                        </div>

                        <div class="mb-5" style="flex: 0 0 auto;">
                            <div class="form-group mb-3">
                                @if (
                                    $progres->status_pengerjaan == 'naik sasis' ||
                                        $progres->status_pengerjaan == 'proses pengecatan' ||
                                        $progres->status_pengerjaan == 'selesai produksi' ||
                                        $progres->status_pengerjaan == 'pengajuan serut' ||
                                        $progres->status_pengerjaan == 'selesai pemeriksaan' ||
                                        $progres->status_pengerjaan == 'diterima customer')
                                    <img src="{{ asset('storage/uploads/' . $progres->ft_pengerjaandinding) }}"
                                        height="140" width="140" class="w-100 rounded border mt-4">
                                @else
                                    <img class="mt-3" src="{{ asset('storage/uploads/gambaricon/loading.jpg') }}"
                                        alt="tigerload" height="140" width="140">
                                @endif
                            </div>
                            <div>
                                <p style="margin: 5px 0; font-weight:bold">NAIK SASIS</p>
                                <p style="margin: 5px 0;">
                                    <i class="fas fa-calendar-alt" style="color: gray;"></i> Tanggal :
                                    {{ $progres->tgl_naiksasis }}
                                </p>
                                @if ($progres->status_pengerjaan == 'naik sasis')
                                    <p style="margin: 5px 0;">Status : <span style="font-size: 12px"
                                            class="badge badge-warning">Sedang diproses</span></p>
                                @elseif(
                                    $progres->status_pengerjaan == 'proses pengecatan' ||
                                        $progres->status_pengerjaan == 'selesai produksi' ||
                                        $progres->status_pengerjaan == 'pengajuan serut' ||
                                        $progres->status_pengerjaan == 'selesai pemeriksaan' ||
                                        $progres->status_pengerjaan == 'diterima customer')
                                    <p style="margin: 5px 0;">Status : <span style="font-size: 12px"
                                            class="badge badge-success">Selesai</span></p>
                                @else
                                    <p style="margin: 5px 0;">Status : <span style="font-size: 12px"
                                            class="badge badge-info">Belum diproses</span></p>
                                @endif
                            </div>
                        </div>
                        <div class="form-group mb-3" style="flex: 0 0 auto; margin-right: 20px;">
                            <hr style="border: 2px solid #000; width: 4cm; margin: 20px auto; margin-top:75px">
                        </div>

                        <div class="mb-5" style="flex: 0 0 auto;">
                            <div class="form-group mb-3">
                                @if (
                                    $progres->status_pengerjaan == 'proses pengecatan' ||
                                        $progres->status_pengerjaan == 'selesai produksi' ||
                                        $progres->status_pengerjaan == 'pengajuan serut' ||
                                        $progres->status_pengerjaan == 'selesai pemeriksaan' ||
                                        $progres->status_pengerjaan == 'diterima customer')
                                    <img src="{{ asset('storage/uploads/' . $progres->ft_pengerjaandinding) }}"
                                        height="140" width="140" class="w-100 rounded border mt-4">
                                @else
                                    <img class="mt-3" src="{{ asset('storage/uploads/gambaricon/loading.jpg') }}"
                                        alt="tigerload" height="140" width="140">
                                @endif
                            </div>
                            <div>
                                <p style="margin: 5px 0; font-weight:bold">PROSES PENGECATAN</p>
                                <p style="margin: 5px 0;">
                                    <i class="fas fa-calendar-alt" style="color: gray;"></i> Tanggal :
                                    {{ $progres->tgl_prosespengecatan }}
                                </p>
                                @if ($progres->status_pengerjaan == 'proses pengecatan')
                                    <p style="margin: 5px 0;">Status : <span style="font-size: 12px"
                                            class="badge badge-warning">Sedang diproses</span></p>
                                @elseif(
                                    $progres->status_pengerjaan == 'selesai produksi' ||
                                        $progres->status_pengerjaan == 'pengajuan serut' ||
                                        $progres->status_pengerjaan == 'selesai pemeriksaan' ||
                                        $progres->status_pengerjaan == 'diterima customer')
                                    <p style="margin: 5px 0;">Status : <span style="font-size: 12px"
                                            class="badge badge-success">Selesai</span></p>
                                @else
                                    <p style="margin: 5px 0;">Status : <span style="font-size: 12px"
                                            class="badge badge-info">Belum diproses</span></p>
                                @endif
                            </div>
                        </div>
                        <div class="form-group mb-3" style="flex: 0 0 auto; margin-right: 20px;">
                            <hr style="border: 2px solid #000; width: 4cm; margin: 20px auto; margin-top:75px">
                        </div>

                        <div class="mb-5" style="flex: 0 0 auto;">
                            <div class="form-group mb-3">
                                @if (
                                    $progres->status_pengerjaan == 'selesai produksi' ||
                                        $progres->status_pengerjaan == 'pengajuan serut' ||
                                        $progres->status_pengerjaan == 'selesai pemeriksaan' ||
                                        $progres->status_pengerjaan == 'diterima customer')
                                    <img src="{{ asset('storage/uploads/' . $progres->ft_pengerjaandinding) }}"
                                        height="140" width="140" class="w-100 rounded border mt-4">
                                @else
                                    <img class="mt-3" src="{{ asset('storage/uploads/gambaricon/loading.jpg') }}"
                                        alt="tigerload" height="140" width="140">
                                @endif
                            </div>
                            <div>
                                <p style="margin: 5px 0; font-weight:bold">SELESAI PRODUKSI</p>
                                <p style="margin: 5px 0;">
                                    <i class="fas fa-calendar-alt" style="color: gray;"></i> Tanggal :
                                    {{ $progres->tgl_selesaiproduksi }}
                                </p>
                                @if ($progres->status_pengerjaan == 'selesai produksi')
                                    <p style="margin: 5px 0;">Status : <span style="font-size: 12px"
                                            class="badge badge-warning">Sedang diproses</span></p>
                                @elseif(
                                    $progres->status_pengerjaan == 'pengajuan serut' ||
                                        $progres->status_pengerjaan == 'selesai pemeriksaan' ||
                                        $progres->status_pengerjaan == 'diterima customer')
                                    <p style="margin: 5px 0;">Status : <span style="font-size: 12px"
                                            class="badge badge-success">Selesai</span></p>
                                @else
                                    <p style="margin: 5px 0;">Status : <span style="font-size: 12px"
                                            class="badge badge-info">Belum diproses</span></p>
                                @endif
                            </div>
                        </div>
                        <div class="form-group mb-3" style="flex: 0 0 auto; margin-right: 20px;">
                            <hr style="border: 2px solid #000; width: 4cm; margin: 20px auto; margin-top:75px">
                        </div>

                        <div class="mb-5" style="flex: 0 0 auto;">
                            <div class="form-group mb-3">
                                @if (
                                    $progres->status_pengerjaan == 'pengajuan serut' ||
                                        $progres->status_pengerjaan == 'selesai pemeriksaan' ||
                                        $progres->status_pengerjaan == 'diterima customer')
                                    <img src="{{ asset('storage/uploads/' . $progres->ft_pengerjaandinding) }}"
                                        height="140" width="140" class="w-100 rounded border mt-4">
                                @else
                                    <img class="mt-3" src="{{ asset('storage/uploads/gambaricon/loading.jpg') }}"
                                        alt="tigerload" height="140" width="140">
                                @endif
                            </div>
                            <div>
                                <p style="margin: 5px 0; font-weight:bold">PENGAJUAN SERUT</p>
                                <p style="margin: 5px 0;">
                                    <i class="fas fa-calendar-alt" style="color: gray;"></i> Tanggal :
                                    {{ $progres->tgl_pengajuanserut }}
                                </p>
                                @if ($progres->status_pengerjaan == 'pengajuan serut')
                                    <p style="margin: 5px 0;">Status : <span style="font-size: 12px"
                                            class="badge badge-warning">Sedang diproses</span></p>
                                @elseif($progres->status_pengerjaan == 'selesai pemeriksaan' || $progres->status_pengerjaan == 'diterima customer')
                                    <p style="margin: 5px 0;">Status : <span style="font-size: 12px"
                                            class="badge badge-success">Selesai</span></p>
                                @else
                                    <p style="margin: 5px 0;">Status : <span style="font-size: 12px"
                                            class="badge badge-info">Belum diproses</span></p>
                                @endif
                            </div>
                        </div>

                        <div class="form-group mb-3" style="flex: 0 0 auto; margin-right: 20px;">
                            <hr style="border: 2px solid #000; width: 4cm; margin: 20px auto; margin-top:75px">
                        </div>

                        <div class="mb-5" style="flex: 0 0 auto;">
                            <div class="form-group mb-3">
                                @if ($progres->status_pengerjaan == 'selesai pemeriksaan' || $progres->status_pengerjaan == 'diterima customer')
                                    <img src="{{ asset('storage/uploads/' . $progres->ft_pengerjaandinding) }}"
                                        height="140" width="140" class="w-100 rounded border mt-4">
                                @else
                                    <img class="mt-3" src="{{ asset('storage/uploads/gambaricon/loading.jpg') }}"
                                        alt="tigerload" height="140" width="140">
                                @endif
                            </div>
                            <div>
                                <p style="margin: 5px 0; font-weight:bold">SELESAI PEMERIKSAAN</p>
                                <p style="margin: 5px 0;">
                                    <i class="fas fa-calendar-alt" style="color: gray;"></i> Tanggal :
                                    {{ $progres->tgl_selesaipemeriksaan }}
                                </p>
                                @if ($progres->status_pengerjaan == 'selesai pemeriksaan')
                                    <p style="margin: 5px 0;">Status : <span style="font-size: 12px"
                                            class="badge badge-warning">Sedang diproses</span></p>
                                @elseif($progres->status_pengerjaan == 'diterima customer')
                                    <p style="margin: 5px 0;">Status : <span style="font-size: 12px"
                                            class="badge badge-success">Selesai</span></p>
                                @else
                                    <p style="margin: 5px 0;">Status : <span style="font-size: 12px"
                                            class="badge badge-info">Belum diproses</span></p>
                                @endif
                            </div>
                        </div>
                        <div class="form-group mb-3" style="flex: 0 0 auto; margin-right: 20px;">
                            <hr style="border: 2px solid #000; width: 4cm; margin: 20px auto; margin-top:75px">
                        </div>

                        <div class="mb-5" style="flex: 0 0 auto;">
                            <div class="form-group mb-3">
                                @if ($progres->status_pengerjaan == 'diterima customer')
                                    <img src="{{ asset('storage/uploads/' . $progres->ft_pengerjaandinding) }}"
                                        height="140" width="140" class="w-100 rounded border mt-4">
                                @else
                                    <img class="mt-3" src="{{ asset('storage/uploads/gambaricon/loading.jpg') }}"
                                        alt="tigerload" height="140" width="140">
                                @endif
                            </div>
                            <div>
                                <p style="margin: 5px 0; font-weight:bold">DITERIMA CUSTOMER</p>
                                <p style="margin: 5px 0;">
                                    <i class="fas fa-calendar-alt" style="color: gray;"></i> Tanggal :
                                    {{ $progres->tgl_diterimacustomer }}
                                </p>
                                @if ($progres->status_pengerjaan == 'diterima customer')
                                    <p style="margin: 5px 0;">Status : <span style="font-size: 12px"
                                            class="badge badge-success">Selesai</span></p>
                                @else
                                    <p style="margin: 5px 0;">Status : <span style="font-size: 12px"
                                            class="badge badge-info">Belum diproses</span></p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
