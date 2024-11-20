@extends('layouts.app')

@section('title', 'Faktur Pajak Pembelian')

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
                    <h1 class="m-0">Faktur Pajak Pembelian</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Faktur Pajak Pembelian</li>
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
                    <h3 class="card-title">Data Faktur Pajak Pembelian</h3>
                    <div class="float-right">
                        <a href="{{ url('admin/faktur_pajakpembelian/create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Tambah
                        </a>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="form-group" style="flex: 8;">
                        <div class="col-md-2 mt-4 mb-3">
                            <label>Kategori</label>
                            <select class="custom-select form-control" id="kategori" name="kategori">
                                <option value="">- Pilih Kategori -</option>
                                <option value="pembelian"selected>PEMBELIAN</option>
                                <option value="penjualan">PENJUALAN</option>
                            </select>
                        </div>
                    </div>
                    <table id="datatables66" class="table table-bordered table-striped table-hover" style="font-size: 13px">
                        <thead class="thead-dark">
                            <tr>
                                <th class="text-center">No</th>
                                <th>Kode Faktur Pajak</th>
                                <th>Kode Pembelian</th>
                                <th>Nama Supplier</th>
                                <th>Tanggal</th>
                                <th class="text-right">Nominal</th>
                                <th class="text-right">PPN</th>
                                <th class="text-center" width="30">Opsi</th>
                            </tr>
                        </thead>
                        <tbody class="list">
                            @foreach ($inquery as $faktur_pajakpembelian)
                                <tr class="dropdown"{{ $faktur_pajakpembelian->id }}>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $faktur_pajakpembelian->kode_pajak }}</td>
                                    <td>
                                        @if ($faktur_pajakpembelian->pembelian)
                                            {{ $faktur_pajakpembelian->pembelian->kode_pembelian }}
                                        @else
                                            tidak ada
                                        @endif
                                    </td>
                                    <td>
                                        @if ($faktur_pajakpembelian->pembelian)
                                            {{ $faktur_pajakpembelian->pembelian->supplier->nama_supp }}
                                        @else
                                            tidak ada
                                        @endif
                                    </td>
                                    <td>
                                        {{ $faktur_pajakpembelian->tanggal_awal }}
                                    </td>
                                    <td>
                                        @if ($faktur_pajakpembelian->pembelian)
                                            Rp
                                            {{ number_format($faktur_pajakpembelian->pembelian->grand_total, 0, ',', '.') }}
                                        @else
                                            Rp 0
                                        @endif
                                    </td>
                                    <?php
                                    $total_price = $faktur_pajakpembelian->pembelian->grand_total ?? 0; // Default to 0 if grand_total is not set
                                    $tax_rate = 0.11;
                                    $original_price = $total_price / (1 + $tax_rate);
                                    ?>
                                    <td>
                                        Rp
                                        {{ number_format($original_price, 0, ',', '.') }}
                                    </td>

                                    <td class="text-center">
                                        @if ($faktur_pajakpembelian->status == 'posting')
                                            <button type="button" class="btn btn-success btn-sm">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        @endif
                                        @if ($faktur_pajakpembelian->status == 'selesai')
                                            <img src="{{ asset('storage/uploads/indikator/faktur.png') }}" height="40"
                                                width="40" alt="Roda Mobil">
                                        @endif
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            @if ($faktur_pajakpembelian->status == 'unpost')
                                                <a class="dropdown-item posting-btn"
                                                    data-memo-id="{{ $faktur_pajakpembelian->id }}">Posting</a>

                                                <a class="dropdown-item"
                                                    href="{{ url('admin/inquery_fakturpajak/' . $faktur_pajakpembelian->id . '/edit') }}">Update</a>

                                                <a class="dropdown-item"
                                                    href="{{ url('admin/faktur_pajakpembelian/' . $faktur_pajakpembelian->id) }}">Show</a>

                                                <form style="margin-top:5px" method="GET"
                                                    action="{{ route('hapus_pajakpembelian', ['id' => $faktur_pajakpembelian->id]) }}">
                                                    <button type="submit"
                                                        class="dropdown-item btn btn-outline-danger btn-block mt-2">
                                                        </i> Delete
                                                    </button>
                                                </form>
                                            @endif
                                            @if ($faktur_pajakpembelian->status == 'posting')
                                                <a class="dropdown-item unpost-btn"
                                                    data-memo-id="{{ $faktur_pajakpembelian->id }}">Unpost</a>

                                                <a class="dropdown-item"
                                                    href="{{ url('admin/faktur_pajakpembelian/' . $faktur_pajakpembelian->id) }}">Show</a>
                                            @endif
                                            @if ($faktur_pajakpembelian->status == 'selesai')
                                                <a class="dropdown-item"
                                                    href="{{ url('admin/faktur_pajakpembelian/' . $faktur_pajakpembelian->id) }}">Show</a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="modal fade" id="modal-loading" tabindex="-1" role="dialog"
                        aria-labelledby="modal-loading-label" aria-hidden="true" data-backdrop="static">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-body text-center">
                                    <i class="fas fa-spinner fa-spin fa-3x text-primary"></i>
                                    <h4 class="mt-2">Sedang Menyimpan...</h4>
                                </div>
                            </div>
                        </div>
                    </div>
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

    {{-- unpost memo  --}}
    <script>
        $(document).ready(function() {
            $('.unpost-btn').click(function() {
                var memoId = $(this).data('memo-id');

                // Tampilkan modal loading saat permintaan AJAX diproses
                $('#modal-loading').modal('show');

                // Kirim permintaan AJAX untuk melakukan unpost
                $.ajax({
                    url: "{{ url('admin/inquery_fakturpajak/unpostfakturpajak/') }}/" + memoId,
                    type: 'GET',
                    data: {
                        id: memoId
                    },
                    success: function(response) {
                        // Sembunyikan modal loading setelah permintaan selesai
                        $('#modal-loading').modal('hide');

                        // Tampilkan pesan sukses atau lakukan tindakan lain sesuai kebutuhan
                        console.log(response);

                        // Tutup modal setelah berhasil unpost
                        $('#modal-posting-' + memoId).modal('hide');

                        // Reload the page to refresh the table
                        location.reload();
                    },
                    error: function(error) {
                        // Sembunyikan modal loading setelah permintaan selesai
                        $('#modal-loading').modal('hide');

                        // Tampilkan pesan error atau lakukan tindakan lain sesuai kebutuhan
                        console.log(error);
                    }
                });
            });
        });
    </script>
    {{-- posting memo --}}
    <script>
        $(document).ready(function() {
            $('.posting-btn').click(function() {
                var memoId = $(this).data('memo-id');

                // Tampilkan modal loading saat permintaan AJAX diproses
                $('#modal-loading').modal('show');

                // Kirim permintaan AJAX untuk melakukan posting
                $.ajax({
                    url: "{{ url('admin/inquery_fakturpajak/postingfakturpajak/') }}/" + memoId,
                    type: 'GET',
                    data: {
                        id: memoId
                    },
                    success: function(response) {
                        // Sembunyikan modal loading setelah permintaan selesai
                        $('#modal-loading').modal('hide');

                        // Tampilkan pesan sukses atau lakukan tindakan lain sesuai kebutuhan
                        console.log(response);

                        // Tutup modal setelah berhasil posting
                        $('#modal-posting-' + memoId).modal('hide');

                        // Reload the page to refresh the table
                        location.reload();
                    },
                    error: function(error) {
                        // Sembunyikan modal loading setelah permintaan selesai
                        $('#modal-loading').modal('hide');

                        // Tampilkan pesan error atau lakukan tindakan lain sesuai kebutuhan
                        console.log(error);
                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('tbody tr.dropdown').click(function(e) {
                // Memeriksa apakah yang diklik adalah checkbox
                if ($(e.target).is('input[type="checkbox"]')) {
                    return; // Jika ya, hentikan eksekusi
                }

                // Menghapus kelas 'selected' dan mengembalikan warna latar belakang ke warna default dari semua baris
                $('tr.dropdown').removeClass('selected').css('background-color', '');

                // Menambahkan kelas 'selected' ke baris yang dipilih dan mengubah warna latar belakangnya
                $(this).addClass('selected').css('background-color', '#b0b0b0');

                // Menyembunyikan dropdown pada baris lain yang tidak dipilih
                $('tbody tr.dropdown').not(this).find('.dropdown-menu').hide();

                // Mencegah event klik menyebar ke atas (misalnya, saat mengklik dropdown)
                e.stopPropagation();
            });

            $('tbody tr.dropdown').contextmenu(function(e) {
                // Memeriksa apakah baris ini memiliki kelas 'selected'
                if ($(this).hasClass('selected')) {
                    // Menampilkan dropdown saat klik kanan
                    var dropdownMenu = $(this).find('.dropdown-menu');
                    dropdownMenu.show();

                    // Mendapatkan posisi td yang diklik
                    var clickedTd = $(e.target).closest('td');
                    var tdPosition = clickedTd.position();

                    // Menyusun posisi dropdown relatif terhadap td yang di klik
                    dropdownMenu.css({
                        'position': 'absolute',
                        'top': tdPosition.top + clickedTd
                            .height(), // Menempatkan dropdown sedikit di bawah td yang di klik
                        'left': tdPosition
                            .left // Menempatkan dropdown di sebelah kiri td yang di klik
                    });

                    // Mencegah event klik kanan menyebar ke atas (misalnya, saat mengklik dropdown)
                    e.stopPropagation();
                    e.preventDefault(); // Mencegah munculnya konteks menu bawaan browser
                }
            });

            // Menyembunyikan dropdown saat klik di tempat lain
            $(document).click(function() {
                $('.dropdown-menu').hide();
                $('tr.dropdown').removeClass('selected').css('background-color',
                    ''); // Menghapus warna latar belakang dari semua baris saat menutup dropdown
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // Detect the change event on the 'status' dropdown
            $('#kategori').on('change', function() {
                // Get the selected value
                var selectedValue = $(this).val();

                // Check the selected value and redirect accordingly
                switch (selectedValue) {
                    case 'pembelian':
                        window.location.href = "{{ url('admin/faktur_pajakpembelian') }}";
                        break;
                    case 'penjualan':
                        window.location.href = "{{ url('admin/faktur_pajak') }}";
                        break;
                    default:
                        // Handle other cases or do nothing
                        break;
                }
            });
        });
    </script>
@endsection
