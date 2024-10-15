@extends('layouts.app')

@section('title', 'Monitoring Project')

@section('content')
    <!-- Content Header (Page header) -->
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
                    <h1 class="m-0">Monitoring Project</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Monitoring Project</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <style>
        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Gaya untuk header tabel */
        .thead-custom {
            color: white;
            /* Warna teks putih */
        }

        .thead-custom th {
            background: linear-gradient(to bottom, #11b3d7, #687275);
            /* Gradient biru di atas, hitam di bawah */
        }

        /* Gaya untuk tabel */
        table {
            font-size: 13px;
            min-width: 1000px;
        }
    </style>
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
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Monitoring Project</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form method="GET" id="form-action">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <select class="select2bs4 select2-hidden-accessible" name="pelanggan_id"
                                    data-placeholder="Cari Pelanggan.." style="width: 100%;" id="pelanggan_id">
                                    <option value="">- Pilih -</option>
                                    <option value="all" {{ Request::get('pelanggan_id') === 'all' ? 'selected' : '' }}>
                                        -Semua Pelanggan-</option>
                                    @foreach ($pelanggans as $pelanggan)
                                        <option value="{{ $pelanggan->id }}"
                                            {{ Request::get('pelanggan_id') == $pelanggan->id ? 'selected' : '' }}>
                                            {{ $pelanggan->nama_pelanggan }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="status">(Cari Pelanggan)</label>
                            </div>
                            <div class="col-md-2 col-sm-12">
                                {{-- <div class="input-group mb-2"> --}}
                                <div class="form-group">
                                    <select class="custom-select form-control" id="status"
                                        name="status">
                                        <option value="">-Semua Status-</option>
                                        <option value="Tunggu Produksi"
                                            {{ Request::get('status') == 'Tunggu Produksi' ? 'selected' : '' }}>
                                            Tunggu Produksi
                                        </option>
                                        <option value="Naik Produksi"
                                            {{ Request::get('status') == 'Naik Produksi' ? 'selected' : '' }}>
                                            Naik Produksi
                                        </option>
                                        <option value="Pengerjaan Lantai"
                                            {{ Request::get('status') == 'Pengerjaan Lantai' ? 'selected' : '' }}>
                                            Pengerjaan Lantai
                                        </option>
                                        <option value="Pengerjaan Dinding"
                                            {{ Request::get('status') == 'Pengerjaan Dinding' ? 'selected' : '' }}>
                                            Pengerjaan Dinding
                                        </option>
                                        <option value="Pengelasan"
                                            {{ Request::get('status') == 'Pengelasan' ? 'selected' : '' }}>
                                            Pengelasan
                                        </option>
                                        <option value="Naik Sasis"
                                            {{ Request::get('status') == 'Naik Sasis' ? 'selected' : '' }}>
                                            Naik Sasis
                                        </option>
                                        <option value="Proses Pengecatan"
                                            {{ Request::get('status') == 'Proses Pengecatan' ? 'selected' : '' }}>
                                            Proses Pengecatan
                                        </option>
                                        <option value="Selesai Produksi"
                                            {{ Request::get('status') == 'Selesai Produksi' ? 'selected' : '' }}>
                                            Selesai Produksi
                                        </option>
                                        <option value="Pengajuan Serut"
                                            {{ Request::get('status') == 'Pengajuan Serut' ? 'selected' : '' }}>
                                            Pengajuan Serut
                                        </option>
                                        <option value="Selesai Pemeriksaan"
                                            {{ Request::get('status') == 'Selesai Pemeriksaan' ? 'selected' : '' }}>
                                            Selesai Pemeriksaan
                                        </option>
                                        <option value="Diterima Customer"
                                            {{ Request::get('status') == 'Diterima Customer' ? 'selected' : '' }}>
                                            Diterima Customer
                                        </option>
                                    </select>
                                    <label for="status">(Cari Status)</label>
                                </div>
                                {{-- </div> --}}
                            </div>
                            <div class="col-md-2 mb-3">
                                <input class="form-control" id="tanggal_awal" name="tanggal_awal" type="date"
                                    value="{{ Request::get('tanggal_awal') }}" max="{{ date('Y-m-d') }}" />
                                <label for="tanggal_awal">(Tanggal Awal)</label>
                            </div>
                            <div class="col-md-2 mb-3">
                                <input class="form-control" id="tanggal_akhir" name="tanggal_akhir" type="date"
                                    value="{{ Request::get('tanggal_akhir') }}" max="{{ date('Y-m-d') }}" />
                                <label for="tanggal_awal">(Tanggal Akhir)</label>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-outline-primary btn-block" onclick="cari()">
                                        <i class="fas fa-search"></i> Cari
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive" style="overflow-x: auto;">
                        <table id="datatables66" class="table table-bordered table-striped table-hover"
                            style="font-size: 13px; min-width: 1000px;">
                            <thead class="thead-custom">
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>No Surat</th>
                                    <th>Pelanggan</th>
                                    <th>Bentuk Karoseri</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th style="width:20px">Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($inquery as $surat)
                                    <tr class="dropdown"{{ $surat->id }}>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $surat->kode_perintah }}</td>
                                        <td>
                                            @if ($surat->pelanggan)
                                                {{ $surat->pelanggan->nama_pelanggan }}
                                            @else
                                                tidak ada
                                            @endif
                                        </td>
                                        <td>{{ $surat->spk->typekaroseri->nama_karoseri ?? 'tidak ada' }}
                                        </td>
                                        <td>{{ $surat->tanggal_awal }}</td>
                                        <td>{{ $surat->status_pengerjaan }}</td>
                                        <td class="text-center">
                                            <a href="{{ url('admin/monitoring_project/' . $surat->id) }}"
                                                class="btn btn-info btn-sm">
                                                <i class="fas fa-share"> Lihat Progres</i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </section>
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
            form.action = "{{ url('admin/monitoring_project') }}";
            form.submit();
        }
    </script>

@endsection
