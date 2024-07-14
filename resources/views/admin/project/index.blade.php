@extends('layouts.app')

@section('title', 'Cetak Qrcode Project')

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
                    <h1 class="m-0">Cetak Qrcode Project</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Cetak Qrcode Project</li>
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
                    <h3 class="card-title">Data Cetak Qrcode Project</h3>
                    <div class="float-right">
                        <a href="{{ url('admin/project/create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Tambah
                        </a>
                    </div>
                </div>
                <!-- /.card-header -->

                <div class="card-body">
                    <div class="col-md-3 mb-3">
                        <input type="hidden" name="ids" id="selectedIds" value="">
                        <button type="button" class="btn btn-outline-primary btn-block mt-1" id="checkfilter"
                            onclick="printSelectedData()" target="_blank">
                            <i class="fas fa-print"></i> Cetak Qrcode
                        </button>
                    </div>
                    <table id="datatables66" class="table table-bordered table-striped table-hover" style="font-size: 13px">
                        <thead class="thead-dark">
                            <tr>
                                <th> <input type="checkbox" name="" id="select_all_ids"></th>
                                <th class="text-center">No</th>
                                <th>Kode Cetak</th>
                                <th>Kode Project</th>
                                <th>Jenis Karoseri</th>
                                <th>Tahun Pembuatan</th>
                                <th>No Serut</th>
                                <th>No Rangka</th>
                                <th>QR Code</th>
                                <th>Tanggal</th>
                                <th class="text-center" width="30">Opsi</th>
                            </tr>
                        </thead>
                        <tbody class="list">
                            @foreach ($inquery as $project)
                                <tr class="dropdown"{{ $project->id }}>
                                    <td><input type="checkbox" name="selectedIds[]" class="checkbox_ids"
                                            value="{{ $project->id }}">
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $project->kode_project }}</td>
                                    <td>
                                        @if ($project->perintah_kerja)
                                            {{ $project->perintah_kerja->kode_perintah }}
                                        @else
                                            tidak ada
                                        @endif
                                    </td>
                                    <td>
                                        @if ($project->perintah_kerja)
                                            {{ $project->perintah_kerja->spk->typekaroseri->nama_karoseri }}
                                        @else
                                            tidak ada
                                        @endif
                                    </td>
                                    <td>
                                        @if ($project->perintah_kerja)
                                            @if ($project->perintah_kerja->dokumen_project->first())
                                                {{ $project->perintah_kerja->dokumen_project->first()->tahun }}
                                            @else
                                                tidak ada
                                            @endif
                                        @else
                                            tidak ada
                                        @endif
                                    </td>
                                    <td>
                                        @if ($project->perintah_kerja)
                                            @if ($project->perintah_kerja->dokumen_project->first())
                                                {{ $project->perintah_kerja->dokumen_project->first()->no_serut }}
                                            @else
                                                tidak ada
                                            @endif
                                        @else
                                            tidak ada
                                        @endif
                                    </td>
                                    <td>
                                        @if ($project->perintah_kerja)
                                            @if ($project->perintah_kerja->dokumen_project->first())
                                                {{ $project->perintah_kerja->dokumen_project->first()->no_rangka }}
                                            @else
                                                tidak ada
                                            @endif
                                        @else
                                            tidak ada
                                        @endif
                                    </td>
                                    <td data-toggle="modal" data-target="#modal-qrcode-{{ $project->id }}"
                                        style="text-align: center;">
                                        <div style="display: inline-block;">
                                            {!! DNS2D::getBarcodeHTML("$project->qrcode_project", 'QRCODE', 1.5, 1.5) !!}
                                        </div>
                                    </td>
                                    <td>
                                        {{ $project->tanggal_awal }}
                                    </td>
                                    <td class="text-center">
                                        @if ($project->status == 'posting')
                                            <button type="button" class="btn btn-success btn-sm">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        @endif
                                        @if ($project->status == 'selesai')
                                            <img src="{{ asset('storage/uploads/indikator/faktur.png') }}" height="40"
                                                width="40" alt="Roda Mobil">
                                        @endif
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            @if ($project->status == 'unpost')
                                                <a class="dropdown-item posting-btn"
                                                    data-memo-id="{{ $project->id }}">Posting</a>

                                                <a class="dropdown-item"
                                                    href="{{ url('admin/inquery_project/' . $project->id . '/edit') }}">Update</a>

                                                <a class="dropdown-item"
                                                    href="{{ url('admin/project/' . $project->id) }}">Show</a>

                                                <a class="dropdown-item"
                                                    href="{{ url('admin/project/cetakqrcode/' . $project->id) }}">Cetak
                                                    Qrcode</a>

                                                <form style="margin-top:5px" method="GET"
                                                    action="{{ route('hapusproject', ['id' => $project->id]) }}">
                                                    <button type="submit"
                                                        class="dropdown-item btn btn-outline-danger btn-block mt-2">
                                                        </i> Delete
                                                    </button>
                                                </form>
                                            @endif
                                            @if ($project->status == 'posting')
                                                <a class="dropdown-item unpost-btn"
                                                    data-memo-id="{{ $project->id }}">Unpost</a>

                                                <a class="dropdown-item"
                                                    href="{{ url('admin/project/' . $project->id) }}">Show</a>

                                                <a class="dropdown-item"
                                                    href="{{ url('admin/project/cetakqrcode/' . $project->id) }}">Cetak
                                                    Qrcode</a>
                                            @endif
                                            @if ($project->status == 'selesai')
                                                <a class="dropdown-item"
                                                    href="{{ url('admin/project/' . $project->id) }}">Show</a>
                                                <a class="dropdown-item"
                                                    href="{{ url('admin/project/cetakqrcode/' . $project->id) }}">Cetak
                                                    Qrcode</a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                <div class="modal fade" id="modal-qrcode-{{ $project->id }}">
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
                                                    <p style="font-size:20px; font-weight: bold;">
                                                        {{ $project->kode_project }}
                                                    </p>
                                                    <div style="display: inline-block;">
                                                        {!! DNS2D::getBarcodeHTML("$project->qrcode_project", 'QRCODE', 15, 15) !!}
                                                    </div>
                                                    <p style="font-size:20px; font-weight: bold;">
                                                        {{ $project->nama_lengkap }}
                                                    </p>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-default"
                                                        data-dismiss="modal">Batal</button>
                                                    <a href="{{ url('admin/project/cetak-pdf/' . $project->id) }}"
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
            form.action = "{{ url('admin/inquery_project') }}";
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
                    url: "{{ url('admin/inquery_project/unpostproject/') }}/" + memoId,
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
                    url: "{{ url('admin/inquery_project/postingproject/') }}/" + memoId,
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
                window.location.href = "{{ url('admin/cetak_projectfilter') }}?ids=" + selectedIdsString;
                // var url = "{{ url('admin/ban/cetak_pdffilter') }}?ids=" + selectedIdsString;
            }
        }
    </script>

@endsection
