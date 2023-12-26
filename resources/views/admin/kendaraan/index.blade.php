@extends('layouts.app')

@section('title', 'Data Kendaraan')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Data Kendaraan</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Data Kendaraan</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5>
                        <i class="icon fas fa-check"></i> Success!
                    </h5>
                    {{ session('success') }}
                </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Kendaraan</h3>
                    <div class="float-right">
                        <a href="{{ url('admin/kendaraan/create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Tambah
                        </a>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead class="bg-200 text-900">
                        <tr>
                            <th class="text-center">No</th>
                            <th>Kode Karoseri</th>
                            <th>Merek</th>
                            <th>Model</th>
                            {{-- <th>Tahun</th>
                            <th>Warna</th> --}}
                            <th class="text-center">Qr Code</th>
                            <th class="text-center" width="100">Opsi</th>
                        </tr>
                    </thead>
                    <tbody class="list">
                        @foreach ($kendaraans as $kendaraan)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $kendaraan->kode_karoseri }}</td>
                                <td>
                                    @if ($kendaraan->merek)
                                        {{ $kendaraan->merek->nama_merek }}
                                    @else
                                        data tidak ada
                                    @endif
                                </td>
                                <td>
                                    @if ($kendaraan->merek)
                                        {{ $kendaraan->merek->tipe->nama_tipe }}
                                    @else
                                        data tidak ada
                                    @endif
                                </td>
                                {{-- <td>{{ $kendaraan->tahun}}</td>
                                <td>{{ $kendaraan->warna }}</td> --}}
                                {{-- <td>{{ $kendaraan->merek->nama_merek }}</td> --}}
                                <td data-bs-toggle="modal" data-bs-target="#modal-qrcode-{{ $kendaraan->id }}"
                                    style="text-align: center;">
                                    <div style="display: inline-block;">
                                        {!! DNS2D::getBarcodeHTML("$kendaraan->qrcode_kendaraan", 'QRCODE', 1, 1) !!}
                                    </div>
                                </td>
                                <td class="text-center">
                                    {{-- @if ($kendaraan->status == 'stok')
                                        <button type="submit" class="btn btn-success btn-sm mr-3" data-toggle="modal"
                                            data-target="#modal-detail-{{ $kendaraan->id }}">
                                            <img src="{{ asset('storage/uploads/gambaricon/car.png') }}" height="17"
                                                width="17" alt="Mobil">
                                        </button>
                                    @elseif($kendaraan->status == 'terjual')
                                        <button type="submit" class="btn btn-primary btn-sm mr-3">
                                            <img src="{{ asset('storage/uploads/gambaricon/car.png') }}" height="17"
                                                width="17" alt="Mobil">
                                        </button>
                                    @endif --}}

                                    <a href="{{ url('admin/kendaraan/' . $kendaraan->id) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ url('admin/kendaraan/' . $kendaraan->id . '/edit') }}"
                                        class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="submit" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#modal-hapus-{{ $kendaraan->id }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <div class="modal fade" id="modal-hapus-{{ $kendaraan->id }}">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Hapus Kendaraan</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Yakin hapus model <strong>{{ $kendaraan->nama_model }}</strong>?</p>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-default"
                                                data-dismiss="modal">Batal</button>
                                            <form action="{{ url('admin/kendaraan/' . $kendaraan->id) }}" method="POST">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-danger">Hapus</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="modal-qrcode-{{ $kendaraan->id }}">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Gambar QR Code</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div style="text-align: center;">
                                                <p style="font-size:20px; font-weight: bold;">
                                                    {{ $kendaraan->kode_kendaraan }}</p>
                                                <div style="display: inline-block;">
                                                    {!! DNS2D::getBarcodeHTML("$kendaraan->qrcode_kendaraan", 'QRCODE', 15, 15) !!}
                                                </div>
                                                <p style="font-size:20px; font-weight: bold;">{{ $kendaraan->no_pol }}</p>
                                            </div>
                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-default"
                                                    data-bs-dismiss="modal">Batal</button>
                                                <a href="{{ url('admin/kendaraan/cetak-qrcode/' . $kendaraan->id) }}"
                                                    class="btn btn-primary btn-sm">
                                                    <i class=""></i> Cetak
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </section>
    <!-- /.card -->
@endsection
