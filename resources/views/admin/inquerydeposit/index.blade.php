@extends('layouts.app')

@section('title', 'Inquery Deposit')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Inquery Deposit</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Inquery Deposit</li>
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
                    <h3 class="card-title">Data Inquery Deposit</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form method="GET" id="form-action">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <select class="custom-select form-control" id="status" name="status">
                                    <option value="">- Semua Status -</option>
                                    <option value="posting" {{ Request::get('status') == 'posting' ? 'selected' : '' }}>
                                        Posting
                                    </option>
                                    <option value="unpost" {{ Request::get('status') == 'unpost' ? 'selected' : '' }}>
                                        Unpost</option>
                                </select>
                                <label for="status">(Pilih Status)</label>
                            </div>
                            <div class="col-md-3 mb-3">
                                <input class="form-control" id="tanggal_awal" name="tanggal_awal" type="date"
                                    value="{{ Request::get('tanggal_awal') }}" max="{{ date('Y-m-d') }}" />
                                <label for="tanggal_awal">(Tanggal Awal)</label>
                            </div>
                            <div class="col-md-3 mb-3">
                                <input class="form-control" id="tanggal_akhir" name="tanggal_akhir" type="date"
                                    value="{{ Request::get('tanggal_akhir') }}" max="{{ date('Y-m-d') }}" />
                                <label for="tanggal_awal">(Tanggal Akhir)</label>
                            </div>
                            <div class="col-md-2 mb-3">
                                <button type="button" class="btn btn-outline-primary mr-2" onclick="cari()">
                                    <i class="fas fa-search"></i> Cari
                                </button>
                            </div>
                        </div>
                    </form>
                    <table id="example1" class="table table-bordered table-striped">
                        <thead class="bg-200 text-900">
                            <tr>
                                <th class="text-center">No</th>
                                <th>Kode Deposit Pemesanan</th>
                                <th>Kode SPK</th>
                                <th>Nama Pelanggan</th>
                                <th>Kode Karoseri</th>
                                <th>Tanggal</th>
                                <th class="text-center" width="100">DP</th>
                                <th class="text-center" width="120">Opsi</th>
                            </tr>
                        </thead>
                        <tbody class="list">
                            @foreach ($inquery as $deposit)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $deposit->kode_deposit }}</td>
                                    <td>{{ $deposit->spk->kode_spk }}</td>
                                    <td>{{ $deposit->spk->pelanggan->nama_pelanggan }}</td>
                                    <td>{{ $deposit->spk->typekaroseri->kode_type }}</td>
                                    <td>{{ $deposit->tanggal_awal }}</td>
                                    {{-- <td>
                                        @if ($deposit->pelanggan)
                                            {{ $deposit->pelanggan->nama_pelanggan }}
                                        @else
                                            data tidak ada
                                        @endif
                                    </td> --}}

                                    <td>Rp {{ number_format($deposit->harga, 0, ',', '.') }}</td>

                                    <td class="text-center">
                                        @if ($deposit->status == 'unpost')
                                            <a href="{{ url('admin/inquery_deposit/' . $deposit->id) }}"
                                                class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ url('admin/inquery_deposit/' . $deposit->id . '/edit') }}"
                                                class="btn btn-info btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                                data-target="#modal-hapus-{{ $deposit->id }}">
                                                <i class="fas fa-times"></i>
                                            </button>
                                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                                data-target="#modal-posting-{{ $deposit->id }}">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        @endif
                                        @if ($deposit->status == 'posting')
                                            <a href="{{ url('admin/inquery_deposit/' . $deposit->id) }}"
                                                class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal"
                                                data-target="#modal-unpost-{{ $deposit->id }}">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                                <div class="modal fade" id="modal-unpost-{{ $deposit->id }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Unpost Deposit Pemesanan</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Unpost Deposit
                                                    <strong>{{ $deposit->kode_deposit }}</strong>?
                                                </p>
                                            </div>
                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-default"
                                                    data-dismiss="modal">Batal</button>
                                                <a class="btn btn-primary"
                                                    href="{{ route('unpostdeposit', ['id' => $deposit->id]) }}">Ya</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="modal-posting-{{ $deposit->id }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Posting Deposit</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Posting Deposit
                                                    <strong>{{ $deposit->kode_pembelian }}</strong>?
                                                </p>
                                            </div>
                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-default"
                                                    data-dismiss="modal">Batal</button>
                                                <a class="btn btn-primary"
                                                    href="{{ route('postingdeposit', ['id' => $deposit->id]) }}">Ya</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="modal-hapus-{{ $deposit->id }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Hapus Deposit</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Yakin hapus Deposit Pemesanan <strong>{{ $deposit->kode_pembelian }}</strong>?
                                                </p>
                                            </div>
                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-default"
                                                    data-dismiss="modal">Batal</button>
                                                <form action="{{ url('admin/inquery_deposit/' . $deposit->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="modal fade" id="modal-qrcode-{{ $deposit->id }}">
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
                                                        {!! DNS2D::getBarcodeHTML("$deposit->qrcode_spk", 'QRCODE', 15, 15) !!}
                                                    </div>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-default"
                                                        data-bs-dismiss="modal">Batal</button>
                                                    <a href="{{ url('admin/spk/cetak-pdf/' . $deposit->id) }}"
                                                        class="btn btn-primary btn-sm">
                                                        <i class=""></i> Cetak
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
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
            form.action = "{{ url('admin/inquery_deposit') }}";
            form.submit();
        }
    </script>
@endsection
