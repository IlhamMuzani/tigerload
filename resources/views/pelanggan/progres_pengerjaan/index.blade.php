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
                                            <a href="{{ url('pelanggan/progres_pengerjaan/' . $surat->id) }}"
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


@endsection
