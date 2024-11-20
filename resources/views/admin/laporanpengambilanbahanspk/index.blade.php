@extends('layouts.app')

@section('title', 'Laporan Pengambilan Bahan Baku')

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
                    <h1 class="m-0">Laporan Pengambilan Bahan Baku SPK</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Laporan Pengambilan Bahan Baku SPK</li>
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
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Laporan Pengambilan Bahan Baku SPK</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form method="GET" id="form-action">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="created_at">Kategori</label>
                                <select class="custom-select form-control" id="kategori" name="kategori">
                                    <option value="">- Pilih Laporan -</option>
                                    <option value="laporanglobal">Laporan Global</option>
                                    <option value="laporandetail"selected>Laporan Detail SPK</option>
                                </select>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label for="created_at">SPK</label>
                                <select class="select2bs4 select2-hidden-accessible" name="perintah_kerja_id"
                                    data-placeholder="Cari Spk.." style="width: 100%;" data-select2-id="23" tabindex="-1"
                                    aria-hidden="true" id="perintah_kerja_id">
                                    <option value="">- Pilih -</option>
                                    @foreach ($spks as $spk)
                                        <option value="{{ $spk->id }}"
                                            {{ Request::get('perintah_kerja_id') == $spk->id ? 'selected' : '' }}>
                                            {{ $spk->kode_perintah }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label for="tanggal_awal">Tanggal Awal</label>
                                <input class="form-control" id="tanggal_awal" name="tanggal_awal" type="date"
                                    value="{{ Request::get('tanggal_awal') }}" max="{{ date('Y-m-d') }}" />
                            </div>
                            <div class="col-md-2 mb-3">
                                <label for="tanggal_akhir">Tanggal Akhir</label>
                                <input class="form-control" id="tanggal_akhir" name="tanggal_akhir" type="date"
                                    value="{{ Request::get('tanggal_akhir') }}" max="{{ date('Y-m-d') }}" />
                            </div>
                            <div class="col-md-3 mb-3">
                                <button type="button" class="btn btn-outline-primary btn-block" onclick="cari()">
                                    <i class="fas fa-search"></i> Cari
                                </button>
                                <button type="button" class="btn btn-primary btn-block" onclick="printReport()"
                                    target="_blank">
                                    <i class="fas fa-print"></i> Cetak
                                </button>
                                <button id="toggle-all" type="button" class="btn btn-info btn-block">
                                    All Toggle Detail
                                </button>
                            </div>
                        </div>
                    </form>
                    <table class="table table-bordered table-striped table-hover" style="font-size: 13px">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-left">Kode Pengambilan BB</th>
                                <th class="text-left">Tanggal</th>
                                <th class="text-left">Pelanggan</th>
                                <th class="text-left">Bentuk Karoseri</th>
                                <th class="text-left">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($inquery as $index => $pengambilan)
                                <!-- Gunakan index untuk ID unik -->
                                <!-- Baris Faktur Utama -->
                                <tr data-toggle="collapse" data-target="#barang-{{ $index }}"
                                    class="accordion-toggle" style="background: rgb(156, 156, 156)">
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $pengambilan->kode_pengambilan }}</td>
                                    <td>{{ $pengambilan->tanggal_awal }}</td>
                                    <td> {{ $pengambilan->perintah_kerja->spk->nama_pelanggan }}
                                    </td>
                                    <td>{{ $pengambilan->perintah_kerja->spk->typekaroseri->nama_karoseri }}</td>
                                    <td>
                                        <!-- Tombol untuk Menampilkan/Menyembunyikan Detail -->
                                        <button class="btn btn-info" data-toggle="collapse"
                                            data-target="#barang-{{ $index }}">Toggle Detail</button>
                                    </td>
                                </tr>

                                <!-- Baris Detail Faktur -->
                                <tr>
                                    <td colspan="6"> <!-- Gabungkan kolom untuk detail -->
                                        <div id="barang-{{ $index }}" class="collapse">
                                            <table class="table table-sm" style="margin: 0;">
                                                <thead>
                                                    <tr>
                                                        <th>Kode Barang</th>
                                                        <th>Tanggal</th>
                                                        <th>Nama Barang</th>
                                                        <th>Qty</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($pengambilan->detailpengambilan as $item)
                                                        <tr>
                                                            <td>{{ $item->kode_barang }}</td>
                                                            <td>{{ $pengambilan->tanggal_awal }}</td>
                                                            <td>{{ $item->nama_barang }}</td>
                                                            <td>{{ $item->jumlah }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </td>
                                </tr>
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
            };
            tanggalAkhir.value = "";
            var today = new Date().toISOString().split('T')[0];
            tanggalAkhir.value = today;
            tanggalAkhir.setAttribute('min', this.value);
        });
        var form = document.getElementById('form-action')

        function cari() {
            form.action = "{{ url('admin/laporan_pengambilanbahanspk') }}";
            form.submit();
        }

        function printReport() {
            var startDate = tanggalAwal.value;
            var endDate = tanggalAkhir.value;

            if (startDate && endDate) {
                form.action = "{{ url('admin/print_laporanpengambilanbahanspk') }}" + "?start_date=" + startDate +
                    "&end_date=" +
                    endDate;
                form.submit();
            } else {
                alert("Silakan isi kedua tanggal sebelum mencetak.");
            }
        }
    </script>

    <script>
        $(document).ready(function() {
            // Detect the change event on the 'status' dropdown
            $('#kategori').on('change', function() {
                // Get the selected value
                var selectedValue = $(this).val();

                // Check the selected value and redirect accordingly
                switch (selectedValue) {
                    case 'laporanglobal':
                        window.location.href = "{{ url('admin/laporan_pengambilanbahan') }}";
                        break;
                    case 'laporandetail':
                        window.location.href = "{{ url('admin/laporan_pengambilanbahanspk') }}";
                        break;
                    default:
                        break;
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            var toggleAll = $("#toggle-all");
            var isExpanded = false; // Status untuk melacak apakah semua detail telah dibuka

            toggleAll.click(function() {
                if (isExpanded) {
                    $(".collapse").collapse("hide");
                    toggleAll.text("All Toggle Detail");
                    isExpanded = false;
                } else {
                    $(".collapse").collapse("show");
                    toggleAll.text("All Close Detail");
                    isExpanded = true;
                }
            });

            // Event listener untuk mengubah status jika ada interaksi manual
            $(".accordion-toggle").click(function() {
                var target = $(this).data("target");
                if ($("#" + target).hasClass("show")) {
                    $("#" + target).collapse("hide");
                } else {
                    $("#" + target).collapse("show");
                }
            });
        });
    </script>
@endsection
