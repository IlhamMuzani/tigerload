@extends('layouts.app')

@section('title', 'Pelunasan Faktur Pembelian')

@section('content')
    <div id="loadingSpinner" style="display: flex; align-items: center; justify-content: center; height: 100vh;">
        <i class="fas fa-spinner fa-spin" style="font-size: 3rem;"></i>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            setTimeout(function() {
                document.getElementById("loadingSpinner").style.display = "none";
                document.getElementById("mainContent").style.display = "block";
                document.getElementById("mainContentSection").style.display = "block";
            }, 100); // Adjust the delay time as needed
        });
    </script>

    <!-- Content Header (Page header) -->
    <div class="content-header" style="display: none;" id="mainContent">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Pelunasan Faktur Pembelian</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Pelunasan Faktur Pembelian</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content" style="display: none;" id="mainContentSection">
        <div class="container-fluid">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5>
                        <i class="icon fas fa-check"></i> Berhasil!
                    </h5>
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5>
                        <i class="icon fas fa-ban"></i> Gagal!
                    </h5>
                    {{ session('error') }}
                </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Pelunasan Faktur Pembelian</h3>
                    <div class="float-right">
                        <a href="{{ url('admin/faktur_pelunasanpembelian') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Tambah
                        </a>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="datatables66" class="table table-bordered table-striped table-hover" style="font-size: 13px">
                        <thead class="thead-dark">
                            <tr>
                                <th class="text-center">No</th>
                                <th>No Faktur </th>
                                <th>Tanggal</th>
                                <th>Admin</th>
                                <th>Supplier</th>
                                {{-- <th>PPH</th> --}}
                                <th style="text-align: end">Total</th>
                                <th style="width: 20px">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($inquery as $fakturpelunasan)
                                <tr id="editMemoekspedisi" data-toggle="modal"
                                    data-target="#modal-posting-{{ $fakturpelunasan->id }}" style="cursor: pointer;">
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $fakturpelunasan->kode_pelunasan }}</td>
                                    <td>{{ $fakturpelunasan->tanggal_awal }}</td>
                                    <td>
                                        {{ $fakturpelunasan->user->karyawan->nama_lengkap }}
                                    </td>
                                    <td>
                                        {{ $fakturpelunasan->nama_supplier }}
                                    </td>
                                    {{-- <td style="text-align: end">
                                        {{ number_format($fakturpelunasan->pph, 0, ',', '.') }}
                                    </td> --}}
                                    <td style="text-align: end">
                                        {{ number_format($fakturpelunasan->totalpembayaran, 0, ',', '.') }}
                                    </td>
                                    <td class="text-center">
                                        @if ($fakturpelunasan->status == 'posting')
                                            <button type="button" class="btn btn-success btn-sm">
                                                <i class="fas fa-check"></i>
                                            </button>
                                            {{-- <button type="button" class="btn btn-primary btn-sm">
                                                <i class="fas fa-truck-moving"></i>
                                            </button> --}}
                                        @endif
                                    </td>
                                </tr>
                                <div class="modal fade" id="modal-posting-{{ $fakturpelunasan->id }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Opsi menu</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Pelunasan Faktur Pembelian
                                                    <strong>{{ $fakturpelunasan->kode_pelunasan }}</strong>
                                                </p>
                                                @if ($fakturpelunasan->status == 'unpost')
                                                    <form method="GET"
                                                        action="{{ route('hapuspelunasanpembelian', ['id' => $fakturpelunasan->id]) }}">
                                                        <button type="submit"
                                                            class="btn btn-outline-danger btn-block mt-2">
                                                            <i class="fas fa-trash-alt"></i> Delete
                                                        </button>
                                                    </form>

                                                    <a href="{{ url('admin/inquery_fakturpelunasanpembelian/' . $fakturpelunasan->id) }}"
                                                        type="button" class="btn btn-outline-info btn-block">
                                                        <i class="fas fa-eye"></i> Show
                                                    </a>

                                                    <a href="{{ url('admin/inquery_fakturpelunasanpembelian/' . $fakturpelunasan->id . '/edit') }}"
                                                        type="button" class="btn btn-outline-warning btn-block">
                                                        <i class="fas fa-edit"></i> Update
                                                    </a>

                                                    <form method="GET"
                                                        action="{{ route('postingpelunasanpembelian', ['id' => $fakturpelunasan->id]) }}">
                                                        <button type="submit"
                                                            class="btn btn-outline-success btn-block mt-2">
                                                            <i class="fas fa-check"></i> Posting
                                                        </button>
                                                    </form>
                                                @endif
                                                @if ($fakturpelunasan->status == 'posting')
                                                    <a href="{{ url('admin/inquery_fakturpelunasanpembelian/' . $fakturpelunasan->id) }}"
                                                        type="button" class="btn btn-outline-info btn-block">
                                                        <i class="fas fa-eye"></i> Show
                                                    </a>
                                                    <form method="GET"
                                                        action="{{ route('unpostpelunasanpembelian', ['id' => $fakturpelunasan->id]) }}">
                                                        <button type="submit"
                                                            class="btn btn-outline-primary btn-block mt-2">
                                                            <i class="fas fa-check"></i> Unpost
                                                        </button>
                                                    </form>
                                                @endif
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
    <script>
        var tanggalAwal = document.getElementById('tanggal_awal');
        var tanggalAkhir = document.getElementById('tanggal_akhir');

        if (tanggalAwal.value == "") {
            tanggalAkhir.readOnly = true;
        }

        tanggalAwal.addEventListener('change', function() {
            if (this.value == "") {
                tanggalAkhir.readOnly = true;
            } else {
                tanggalAkhir.readOnly = false;
            }

            tanggalAkhir.value = "";
            var today = new Date().toISOString().split('T')[0];
            tanggalAkhir.value = today;
            tanggalAkhir.setAttribute('min', this.value);
        });

        var form = document.getElementById('form-action');

        function cari() {
            form.action = "{{ url('admin/inquery_fakturpelunasanpembelian') }}";
            form.submit();
        }
    </script>

@endsection
