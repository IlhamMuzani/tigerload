@extends('layouts.app')

@section('title', 'Inquery Perhitungan Gaji Bulan')

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
                    <h1 class="m-0">Inquery Perhitungan Gaji Bulan</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Inquery Perhitungan Gaji Bulan</li>
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
                    <h3 class="card-title">Inquery Perhitungan Gaji Bulan</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form method="GET" id="form-action">
                        <div class="row">
                            <div class="col-md-2 mb-3">
                                <select class="custom-select form-control" id="statusx" name="statusx">
                                    <option value="">- Pilih Kategori -</option>
                                    <option value="memo_perjalanan">Gaji Mingguan</option>
                                    <option value="slip_mingguan">Slip Gaji Mingguan</option>
                                    <option value="memo_borong"selected>Gaji Bulanan</option>
                                    <option value="slip_bulanan">Slip Gaji Bulanan</option>
                                </select>
                                <label>(Kategori)</label>
                            </div>
                            <div class="col-md-2 mb-3">
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
                                <button type="button" class="btn btn-outline-primary btn-block" onclick="cari()">
                                    <i class="fas fa-search"></i> Cari
                                </button>
                                <input type="hidden" name="ids" id="selectedIds" value="">
                                <button type="button" class="btn btn-primary btn-block mt-1" id="checkfilter"
                                    onclick="printSelectedData()" target="_blank">
                                    <i class="fas fa-print"></i> Cetak Filter
                                </button>
                            </div>
                        </div>
                    </form>
                    <table id="datatables66" class="table table-bordered table-striped table-hover" style="font-size: 13px">
                        <thead class="thead-dark">
                            <tr>
                                <th class="text-center" width="10"> <input type="checkbox" name=""
                                        id="select_all_ids"></th>
                                <th class="text-center">No</th>
                                <th>Kode Gaji</th>
                                <th>Tanggal</th>
                                <th>Bag.Input</th>
                                <th>Periode Awal</th>
                                <th>Periode Akhir</th>
                                <th>Total</th>
                                <th class="text-center" width="20">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($inquery as $perhitungan)
                                <tr class="dropdown"{{ $perhitungan->id }}>
                                    <td><input type="checkbox" name="selectedIds[]" class="checkbox_ids"
                                            value="{{ $perhitungan->id }}">
                                    </td>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>
                                        {{ $perhitungan->kode_gaji }}
                                    </td>
                                    <td>
                                        {{ $perhitungan->tanggal_awal }}
                                    </td>
                                    <td>
                                        @if ($perhitungan->user)
                                            {{ $perhitungan->user->karyawan->nama_lengkap }}
                                        @else
                                            tidak ada
                                        @endif

                                    </td>
                                    <td>
                                        {{ $perhitungan->periode_awal }}
                                    </td>
                                    <td>
                                        {{ $perhitungan->periode_akhir }}
                                    </td>
                                    <td class="text-right">{{ number_format($perhitungan->grand_total, 2, ',', '.') }}
                                    </td>
                                    <td class="text-center">
                                        @if ($perhitungan->status == 'posting')
                                            <button type="button" class="btn btn-success btn-sm">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        @endif
                                        @if ($perhitungan->status == 'selesai')
                                            <img src="{{ asset('storage/uploads/indikator/perhitungan.png') }}"
                                                height="40" width="40" alt="Roda Mobil">
                                        @endif
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            @if ($perhitungan->status == 'unpost')
                                                {{-- @if (auth()->check() && auth()->user()->fitur['inquery perhitungan ekspedisi posting']) --}}
                                                <a class="dropdown-item posting-btn"
                                                    data-memo-id="{{ $perhitungan->id }}">Posting</a>
                                                {{-- @endif --}}
                                                {{-- @if (auth()->check() && auth()->user()->fitur['inquery perhitungan ekspedisi update']) --}}
                                                <a class="dropdown-item"
                                                    href="{{ url('admin/inquery_perhitungangajibulanan/' . $perhitungan->id . '/edit') }}">Update</a>
                                                {{-- @endif --}}
                                                {{-- @if (auth()->check() && auth()->user()->fitur['inquery perhitungan ekspedisi show']) --}}
                                                <a class="dropdown-item"
                                                    href="{{ url('admin/inquery_perhitungangajibulanan/' . $perhitungan->id) }}">Show</a>
                                                {{-- @endif --}}
                                                {{-- @if (auth()->check() && auth()->user()->fitur['inquery perhitungan ekspedisi delete']) --}}
                                                <form style="margin-top:5px" method="GET"
                                                    action="{{ route('hapusperhitunganbulanan', ['id' => $perhitungan->id]) }}">
                                                    <button type="submit"
                                                        class="dropdown-item btn btn-outline-danger btn-block mt-2">
                                                        </i> Delete
                                                    </button>
                                                </form>
                                                {{-- @endif --}}
                                            @endif
                                            @if ($perhitungan->status == 'posting')
                                                {{-- @if (auth()->check() && auth()->user()->fitur['inquery perhitungan ekspedisi unpost']) --}}
                                                <a class="dropdown-item unpost-btn"
                                                    data-memo-id="{{ $perhitungan->id }}">Unpost</a>
                                                {{-- @endif --}}
                                                {{-- @if (auth()->check() && auth()->user()->fitur['inquery perhitungan ekspedisi show']) --}}
                                                <a class="dropdown-item"
                                                    href="{{ url('admin/inquery_perhitungangajibulanan/' . $perhitungan->id) }}">Show</a>
                                                {{-- @endif --}}
                                            @endif
                                            @if ($perhitungan->status == 'selesai')
                                                {{-- @if (auth()->check() && auth()->user()->fitur['inquery perhitungan ekspedisi show']) --}}
                                                <a class="dropdown-item"
                                                    href="{{ url('admin/inquery_perhitungangajibulanan/' . $perhitungan->id) }}">Show</a>
                                                {{-- @endif --}}
                                            @endif
                                            <a class="dropdown-item"
                                                href="{{ url('admin/inquery_perhitungangaji/export-gm/' . $perhitungan->id) }}">Export</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- Modal Loading -->
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
            form.action = "{{ url('admin/inquery_perhitungangajibulanan') }}";
            form.submit();
        }
    </script>

    {{-- <script>
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
                window.location.href = "{{ url('admin/cetak_fakturekspedisifilter') }}?ids=" + selectedIdsString;
                // var url = "{{ url('admin/ban/cetak_pdffilter') }}?ids=" + selectedIdsString;
            }
        }
    </script> --}}

    {{-- unpost memo  --}}
    <script>
        $(document).ready(function() {
            $('.unpost-btn').click(function() {
                var memoId = $(this).data('memo-id');
                $(this).addClass('disabled');

                // Tampilkan modal loading saat permintaan AJAX diproses
                $('#modal-loading').modal('show');

                // Kirim permintaan AJAX untuk melakukan unpost
                $.ajax({
                    url: "{{ url('admin/inquery_perhitungangajibulanan/unpostperhitunganbulanan/') }}/" +
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
                $(this).addClass('disabled');

                // Tampilkan modal loading saat permintaan AJAX diproses
                $('#modal-loading').modal('show');

                // Kirim permintaan AJAX untuk melakukan posting
                $.ajax({
                    url: "{{ url('admin/inquery_perhitungangajibulanan/postingperhitunganbulanan/') }}/" +
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
            // Detect the change event on the 'status' dropdown
            $('#statusx').on('change', function() {
                // Get the selected value
                var selectedValue = $(this).val();

                // Check the selected value and redirect accordingly
                switch (selectedValue) {
                    case 'memo_perjalanan':
                        window.location.href = "{{ url('admin/inquery_perhitungangaji') }}";
                        break;
                    case 'slip_mingguan':
                        window.location.href = "{{ url('admin/inquery_slipgaji') }}";
                        break;
                    case 'memo_borong':
                        window.location.href = "{{ url('admin/inquery_perhitungangajibulanan') }}";
                        break;
                    case 'slip_bulanan':
                        window.location.href = "{{ url('admin/inquery_slipgajibulanan') }}";
                        break;
                    default:
                        // Handle other cases or do nothing
                        break;
                }
            });
        });
    </script>

@endsection
