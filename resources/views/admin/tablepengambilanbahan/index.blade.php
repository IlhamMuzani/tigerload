@extends('layouts.app')

@section('title', 'Pengambilan Bahan Baku')

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
                    <h1 class="m-0">Pengambilan Bahan Baku</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Pengambilan Bahan Baku</li>
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
                        <i class="icon fas fa-check"></i> Success!
                    </h5>
                    {{ session('success') }}
                </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Pengambilan bahan baku</h3>
                    <div class="float-right">
                        <a href="{{ url('admin/pengambilanbahan') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Tambah
                        </a>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form method="GET" id="form-action">
                        <div class="row">
                            <div class="col-md-4 mb-3">

                            </div>
                            <div class="col-md-3 mb-3">

                            </div>
                            <div class="col-md-3 mb-3">

                            </div>
                            <div class="col-md-2 mb-3">
                                <input type="hidden" name="ids" id="selectedIds" value="">
                                <button type="button" class="btn btn-primary btn-block mt-1" id="checkfilter"
                                    onclick="printSelectedData()" target="_blank">
                                    <i class="fas fa-print"></i> Cetak Filter
                                </button>
                                <button id="toggle-all" type="button" class="btn btn-info btn-block">
                                    All Toggle Detail
                                </button>
                            </div>
                        </div>
                    </form>
                    <table class="table table-bordered table-striped table-hover"style="font-size: 13px">
                        <thead class="thead-dark">
                            <tr>
                                <th> <input type="checkbox" name="" id="select_all_ids"></th>
                                <th class="text-center">No</th>
                                <th class="text-left">Kode Pengambilan BB</th>
                                <th class="text-left">Kode SPK</th>
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
                                <tr class="dropdown" data-target="#barang-{{ $index }}" class="accordion-toggle">
                                    <td><input type="checkbox" name="selectedIds[]" class="checkbox_ids"
                                            value="{{ $pengambilan->id }}">
                                    </td>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $pengambilan->kode_pengambilan }}</td>
                                    <td>{{ $pengambilan->perintah_kerja->kode_perintah ?? 'tidak ada' }}</td>
                                    <td>{{ $pengambilan->tanggal_awal }}</td>
                                    <td> {{ $pengambilan->perintah_kerja->spk->pelanggan->nama_pelanggan ?? 'tidak ada' }}
                                    </td>
                                    <td>{{ $pengambilan->perintah_kerja->spk->typekaroseri->nama_karoseri ?? 'tidak ada' }}</td>
                                    {{-- <td>
                                        <!-- Tombol untuk Menampilkan/Menyembunyikan Detail -->
                                    </td> --}}
                                    <td class="text-center">
                                        @if ($pengambilan->status == 'posting')
                                            <button type="button" class="btn btn-success btn-sm">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        @endif
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            @if ($pengambilan->status == 'unpost')
                                                <a class="dropdown-item posting-btn"
                                                    data-memo-id="{{ $pengambilan->id }}">Posting</a>

                                                <a class="dropdown-item"
                                                    href="{{ url('admin/inquery_pengambilanbahan/' . $pengambilan->id . '/edit') }}">Update</a>

                                                <a class="dropdown-item"
                                                    href="{{ url('admin/inquery_pengambilanbahan/' . $pengambilan->id) }}">Show</a>

                                                <form style="margin-top:5px" method="GET"
                                                    action="{{ route('hapuspengambilan', ['id' => $pengambilan->id]) }}">
                                                    <button type="submit"
                                                        class="dropdown-item btn btn-outline-danger btn-block mt-2">
                                                        </i> Delete
                                                    </button>
                                                </form>
                                            @endif
                                            @if ($pengambilan->status == 'posting')
                                                <a class="dropdown-item unpost-btn"
                                                    data-memo-id="{{ $pengambilan->id }}">Unpost</a>

                                                <a class="dropdown-item"
                                                    href="{{ url('admin/inquery_pengambilanbahan/' . $pengambilan->id) }}">Show</a>
                                            @endif
                                            @if ($pengambilan->status == 'selesai')
                                                <a class="dropdown-item"
                                                    href="{{ url('admin/inquery_pengambilanbahan/' . $pengambilan->id) }}">Show</a>
                                            @endif
                                        </div>
                                        {{-- <button class="btn btn-info" data-toggle="collapse"
                                            data-target="#barang-{{ $index }}">Toggle</button> --}}
                                    </td>
                                </tr>

                                <!-- Baris Detail Faktur -->
                                <tr>
                                    <td colspan="7"> <!-- Gabungkan kolom untuk detail -->
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
            form.action = "{{ url('admin/inquery_pengambilanbahan') }}";
            form.submit();
        }
    </script>

    <script>
        $(function(e) {
            $("#select_all_ids").click(function() {
                $('.checkbox_ids').prop('checked', $(this).prop('checked'))
            })
        });

        function printSelectedData() {
            var selectedIds = document.querySelectorAll(".checkbox_ids:checked");
            if (selectedIds.length === 0) {
                alert("Harap centang setidaknya satu item sebelum mencetak.");
            } else {
                var selectedCheckboxes = document.querySelectorAll('.checkbox_ids:checked');
                var selectedIds = [];
                selectedCheckboxes.forEach(function(checkbox) {
                    selectedIds.push(checkbox.value);
                });
                document.getElementById('selectedIds').value = selectedIds.join(',');
                var selectedIdsString = selectedIds.join(',');
                window.location.href = "{{ url('admin/cetak_pengambilanfilter') }}?ids=" + selectedIdsString;
                // var url = "{{ url('admin/ban/cetak_pdffilter') }}?ids=" + selectedIdsString;
            }
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
                    url: "{{ url('admin/inquery_pengambilanbahan/unpostpengambilan/') }}/" +
                        memoId,
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
                    url: "{{ url('admin/inquery_pengambilanbahan/postingpengambilan/') }}/" +
                        memoId,
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
