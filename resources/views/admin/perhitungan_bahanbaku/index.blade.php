@extends('layouts.app')

@section('title', 'Perhitungan Pengambilan Bahan Baku')

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
                    <h1 class="m-0">Perhitungan Pengambilan Bahan Baku</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Perhitungan Pengambilan Bahan Baku</li>
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
                    <h3 class="card-title">Perhitungan Pengambilan Bahan Baku</h3>
                    <div class="float-right">
                        <a data-toggle="modal" data-target="#modal-tambah" style="text-align: center;"
                            class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Tambah
                        </a>
                    </div>
                </div>
                <div class="modal fade" id="modal-tambah">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Pilih SPK</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div style="text-align: center;">
                                    <form action="{{ url('admin/add_spks') }}" enctype="multipart/form-data"
                                        autocomplete="off" method="post">
                                        @csrf
                                        <div class="card">
                                            <div class="card-header">
                                                <h3 class="card-title">Perhitungan Pemakain Bahan Baku</h3>
                                            </div>
                                            <div class="card-body">
                                                <div class="form-group" style="flex: 8;"> <!-- Adjusted flex value -->
                                                    <select class="select2bs4 select2-hidden-accessible"
                                                        name="perintah_kerja_id" data-placeholder="Cari SPK.."
                                                        style="width: 100%;" data-select2-id="23" tabindex="-1"
                                                        aria-hidden="true" id="perintah_kerja_id" onchange="getData(0)">
                                                        <option value="">- Pilih -</option>
                                                        @foreach ($spks as $perintah_kerja)
                                                            <option value="{{ $perintah_kerja->id }}"
                                                                {{ old('perintah_kerja_id') == $perintah_kerja->id ? 'selected' : '' }}>
                                                                {{ $perintah_kerja->kode_perintah }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div hidden class="form-group">
                                                    <label for="nopol">id SPK</label>
                                                    <input type="text" class="form-control" id="id_perintahkerja"
                                                        name="id_perintahkerja" readonly placeholder=""
                                                        value="{{ old('id_perintahkerja') }}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="nopol">Tanggal</label>
                                                    <input type="text" class="form-control" id="tanggal" name="tanggal"
                                                        readonly placeholder="" value="{{ old('tanggal') }}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="nama">Bentuk Karoseri</label>
                                                    <input type="text" class="form-control" id="nama_karoseri"
                                                        name="nama_karoseri" readonly placeholder=""
                                                        value="{{ old('nama_karoseri') }}">
                                                </div>
                                                <div class="form-group" id="layoutjenis">
                                                    <label for="nama_pelanggan">Pelanggan</label>
                                                    <input type="text" class="form-control" id="nama_pelanggan"
                                                        name="nama_pelanggan" readonly placeholder=""
                                                        value="{{ old('nama_pelanggan') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer text-right">
                                            <button type="submit" class="btn btn-primary">Lanjutkan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered table-striped table-hover"style="font-size: 13px">
                        <thead class="thead-dark">
                            <tr>
                                <th> <input type="checkbox" name="" id="select_all_ids"></th>
                                <th class="text-center">No</th>
                                <th class="text-left">Kode Perhitungan</th>
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
                                    <td>{{ $pengambilan->kode_perhitungan }}</td>
                                    <td>{{ $pengambilan->tanggal_awal }}</td>
                                    <td> {{ $pengambilan->perintah_kerja->spk->pelanggan->nama_pelanggan }}
                                    </td>
                                    <td>{{ $pengambilan->perintah_kerja->spk->typekaroseri->nama_karoseri }}</td>
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
                                                    href="{{ url('admin/inquery_perhitunganbahanbaku/' . $pengambilan->id . '/edit') }}">Update</a>

                                                <a class="dropdown-item"
                                                    href="{{ url('admin/perhitungan_bahanbaku/' . $pengambilan->id) }}">Show</a>

                                                <form style="margin-top:5px" method="GET"
                                                    action="{{ route('hapusperhitunganbahan', ['id' => $pengambilan->id]) }}">
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
                                                    href="{{ url('admin/perhitungan_bahanbaku/' . $pengambilan->id) }}">Show</a>
                                            @endif
                                            @if ($pengambilan->status == 'selesai')
                                                <a class="dropdown-item"
                                                    href="{{ url('admin/perhitungan_bahanbaku/' . $pengambilan->id) }}">Show</a>
                                            @endif
                                        </div>
                                        {{-- <button class="btn btn-info" data-toggle="collapse"
                                            data-target="#barang-{{ $index }}">Toggle</button> --}}
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
            form.action = "{{ url('admin/inquery_penerimaanpembayaran') }}";
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
                    url: "{{ url('admin/inquery_perhitunganbahanbaku/unpostperhitungan/') }}/" +
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
                    url: "{{ url('admin/inquery_perhitunganbahanbaku/postingperhitungan/') }}/" +
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
            $('#modal-pilihkabin').modal('show');
        });


        function getData(id) {
            var kendaraan_id = document.getElementById('perintah_kerja_id');
            $.ajax({
                url: "{{ url('admin/perhitungan_bahanbaku/spk') }}" + "/" + perintah_kerja_id.value,
                type: "GET",
                dataType: "json",
                success: function(perintah_kerja_id) {

                    var perintah = document.getElementById('id_perintahkerja');
                    perintah.value = perintah_kerja_id.id;

                    var tanggal = document.getElementById('tanggal');
                    tanggal.value = perintah_kerja_id.tanggal_awal;

                    var nama_karoseri = document.getElementById('nama_karoseri');
                    nama_karoseri.value = perintah_kerja_id.typekaroseri.nama_karoseri;

                    var nama_pelanggan = document.getElementById('nama_pelanggan');
                    nama_pelanggan.value = perintah_kerja_id.pelanggan.nama_pelanggan;
                },
            });
        }
    </script>

@endsection
