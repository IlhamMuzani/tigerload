@extends('layouts.app')

@section('title', 'Lihat Pelanggan')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Pelanggan</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ url('admin/pelanggan') }}">Pelanggan</a>
                        </li>
                        <li class="breadcrumb-item active">Lihat</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Lihat pelanggan</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-5">
                            {{-- @if ($pelanggan->gambar)
                                <img src="{{ asset('storage/uploads/' . $pelanggan->gambar) }}"
                        class="w-100 rounded border">
                        @else
                        <img src="{{ asset('storage/uploads/pelanggan/user.png') }}" class="w-100 rounded border">
                        @endif --}}
                            {{-- <img src="{{ asset('storage/uploads/' . $pelanggan->gambar) }}"
                        alt="{{ $pelanggan->nama_lengkap }}" class="w-100 rounded"> --}}
                            @if ($pelanggan->gambar_ktp)
                                <img src="{{ asset('storage/uploads/' . $pelanggan->gambar_ktp) }}"
                                    alt="{{ $pelanggan->nama_pelanggan }}" class="w-100 rounded border">
                            @else
                                <img class="mt-3" src="{{ asset('storage/uploads/gambar_logo/tigerputihkotak.jpeg') }}"
                                    alt="AdminLTELogo" height="400" width="400">
                            @endif
                        </div>
                        <div class="col-md-6">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <strong>Qr Code</strong>
                                </div>
                                <div class="col-md-4">
                                    <div data-bs-toggle="modal" data-bs-target="#modal-qrcode-{{ $pelanggan->id }}"
                                        style="display: inline-block;">
                                        {!! DNS2D::getBarcodeHTML("$pelanggan->qrcode_pelanggan", 'QRCODE', 3, 3) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <strong>Kode Pelanggan</strong>
                                </div>
                                <div class="col-md-4">
                                    {{ $pelanggan->kode_pelanggan }}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <strong>Nama Pelanggan</strong>
                                </div>
                                <div class="col-md-4">
                                    {{ $pelanggan->nama_pelanggan }}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <strong>Nama alias</strong>
                                </div>
                                <div class="col-md-4">
                                    {{ $pelanggan->nama_alias }}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <strong>Telepon</strong>
                                </div>
                                <div class="col-md-4">
                                    {{ $pelanggan->telp }}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <strong>Alamat</strong>
                                </div>
                                <div class="col-md-4">
                                    {{ $pelanggan->alamat }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="modal-qrcode-{{ $pelanggan->id }}">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Gambar QR Code</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                {{-- <p>Yakin hapus kendaraan
                                                    <strong>{{ $kendaraan->kode_kendaraan }}</strong>?
                            </p> --}}
                                <div style="text-align: center;">
                                    <div style="display: inline-block;">
                                        {!! DNS2D::getBarcodeHTML("$pelanggan->qrcode_pelanggan", 'QRCODE', 15, 15) !!}
                                    </div>

                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-bs-dismiss="modal">Batal</button>
                                    {{-- <form action="{{ url('admin/ban/' . $golongan->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary">Cetak</button>
                                </form> --}}
                                    <a href="{{ url('admin/pelanggan/cetak-pdf/' . $pelanggan->id) }}"
                                        class="btn btn-primary btn-sm">
                                        <i class=""></i> Cetak
                                    </a>
                                    {{-- <a href="{{ url('admin/cetak-pdf/' . $golongan->id) }}" target="_blank"
                                class="btn btn-outline-primary btn-sm float-end">
                                <i class="fa-solid fa-print"></i> Cetak PDV
                                </a> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
