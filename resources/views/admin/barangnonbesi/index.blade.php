@extends('layouts.app')

@section('title', 'Data Barang Non Besi')

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
                    <h1 class="m-0">Data Barang Non Besi</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Data Barang Non Besi</li>
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
                    <h3 class="card-title">Data barang Non Besi</h3>
                    <div class="float-right">
                        <a href="{{ url('admin/barangnonbesi/create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Tambah
                        </a>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form action="{{ url('admin/barangnonbesi') }}" method="GET" id="get-keyword" autocomplete="off">
                        @csrf
                        <div class="row">
                            <div class="col-md-2 mb-3">
                                <label for="kategori">Kategori</label>
                                <select class="custom-select form-control" id="kategori" name="kategori">
                                    <option value="">- Pilih -</option>
                                    <option value="barang">Barang Besi</option>
                                    <option value="barangnon" selected>Barang Non Besi</option>
                                </select>
                            </div>

                            <div class="col-md-2 mb-3">
                                <label for="show_all">Show All</label>
                                <button id="toggle-all" type="button" class="btn btn-info btn-block">
                                    All Toggle Detail
                                </button>
                            </div>

                            <!-- Bagian pencarian berada di sebelah kanan -->
                            <div class="col-md-4 offset-md-4">
                                <label for="keyword">Cari Barang :</label>
                                <div class="input-group">
                                    <input type="search" class="form-control" name="keyword" id="keyword"
                                        value="{{ Request::get('keyword') }}"
                                        onsubmit="event.preventDefault();
                                        document.getElementById('get-keyword').submit();">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <table id="datatables66" class="table table-bordered table-striped table-hover" style="font-size: 13px">
                        <thead class="thead-dark">
                            <tr>
                                <th class="text-center">No</th>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Stok</th>
                                {{-- <th>Harga</th> --}}
                                <th class="text-center">Qr Code</th>
                                <th class="text-center" width="120">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($barangs as $index => $barang)
                                <tr data-toggle="collapse" data-target="#barang-{{ $index }}"
                                    class="accordion-toggle" style="background: rgb(240, 242, 246)">
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $barang->kode_barang }}</td>
                                    <td>{{ $barang->nama_barang }}</td>
                                    <td>{{ $barang->detail_barang->where('status', 'posting')->sum('jumlah') }}</td>
                                    {{-- <td>{{ $barang->harga }}</td> --}}
                                    <td data-toggle="modal" data-target="#modal-qrcode-{{ $barang->id }}"
                                        style="text-align: center;">
                                        <div style="display: inline-block;">
                                            {!! DNS2D::getBarcodeHTML("$barang->qrcode_barang", 'QRCODE', 1, 1) !!}
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <button type="submit" class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#modal-hapus-{{ $barang->id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        <a href="{{ url('admin/barangnonbesi/' . $barang->id . '/edit') }}"
                                            class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button class="btn btn-info btn-sm" data-toggle="collapse"
                                            data-target="#barang-{{ $index }}"><i class="fas fa-eye"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="7"> <!-- Gabungkan kolom untuk detail -->
                                        <div id="barang-{{ $index }}" class="collapse">
                                            <table class="table table-sm" style="margin: 0;">
                                                <thead>
                                                    <tr>
                                                        <th>Nama Supplier</th>
                                                        <th>Tanggal Pembelian</th>
                                                        <th>Harga</th>
                                                        <th>Qty</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($barang->detail_barang as $item)
                                                        @if ($item->jumlah != 0)
                                                            <tr>
                                                                <td>{{ $item->supplier->nama_supp }}</td>
                                                                <td>{{ $item->tanggal_awal }}</td>
                                                                <td>{{ number_format($item->harga, 0, ',', '.') }}</td>
                                                                <td>{{ $item->jumlah }}</td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </td>
                                </tr>
                                <div class="modal fade" id="modal-hapus-{{ $barang->id }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Hapus barang</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Yakin hapus barang <strong>{{ $barang->nama }}</strong>?</p>
                                            </div>
                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-default"
                                                    data-dismiss="modal">Batal</button>
                                                <form action="{{ url('admin/barang/' . $barang->id) }}" method="POST">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal fade" id="modal-qrcode-{{ $barang->id }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Gambar QR Code</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div style="text-align: center;">
                                                    <div style="display: inline-block;">
                                                        {!! DNS2D::getBarcodeHTML("$barang->qrcode_barang", 'QRCODE', 15, 15) !!}
                                                    </div>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-default"
                                                        data-dismiss="modal">Batal</button>
                                                    <a href="{{ url('admin/barang/cetak-pdf/' . $barang->id) }}"
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
                @if ($barangs->total() > 10)
                    <div class="card-footer">
                        <div class="pagination float-right">
                            {{ $barangs->appends(Request::all())->links('pagination::simple-bootstrap-4') }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <script>
        $(document).ready(function() {
            // Detect the change event on the 'status' dropdown
            $('#kategori').on('change', function() {
                // Get the selected value
                var selectedValue = $(this).val();

                // Check the selected value and redirect accordingly
                switch (selectedValue) {
                    case 'barang':
                        window.location.href = "{{ url('admin/barang') }}";
                        break;
                    case 'barangnon':
                        window.location.href = "{{ url('admin/barangnonbesi') }}";
                        break;
                    default:
                        // Handle other cases or do nothing
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
    <!-- /.card -->
@endsection
