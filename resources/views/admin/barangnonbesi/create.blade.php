@extends('layouts.app')

@section('title', 'Tambah Barang Non Besi')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Barang Non Besi</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/barang') }}">Barang Non Besi</a></li>
                        <li class="breadcrumb-item active">Tambah</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <section class="content">
        <div class="container-fluid">
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5>
                        <i class="icon fas fa-ban"></i> Gagal!
                    </h5>
                    @foreach (session('error') as $error)
                        - {{ $error }} <br>
                    @endforeach
                </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tambah Barang Non Besi</h3>
                </div>
                <!-- /.card-header -->
                <form action="{{ url('admin/barang') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label class="form-label" for="kategori">Pilih Kategori</label>
                            <select class="form-control" id="kategori" name="kategori">
                                <option value="">- Pilih -</option>
                                <option value="besi" {{ old('kategori') == 'besi' ? 'selected' : null }}>
                                    Besi</option>
                                <option value="non besi" {{ old('kategori') == 'non besi' ? 'selected' : null }}>
                                    Non Besi</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nama">Nama Barang</label>
                            <input type="text" class="form-control" id="nama_barang" name="nama_barang"
                                placeholder="Masukan nama barang" value="{{ old('nama_barang') }}">
                        </div>
                        <div class="form-group">
                            <label for="nama">Ukuran</label>
                            <input type="text" class="form-control" id="jumlah" name="jumlah"
                                placeholder="Masukan ukuran" value="{{ old('jumlah') }}">
                        </div>
                        <div class="form-group">
                            <label for="nama">Spesifikasi</label>
                            <input type="text" class="form-control" id="spesifikasi" name="spesifikasi"
                                placeholder="Masukan spesifikasi" value="{{ old('spesifikasi') }}">
                        </div>
                        <div class="form-group">
                            <label for="nama">Keterangan</label>
                            <input type="text" class="form-control" id="keterangan" name="keterangan"
                                placeholder="Masukan keterangan" value="{{ old('keterangan') }}">
                        </div>
                        <div class="form-group">
                            <label for="nama">Harga</label>
                            <input type="number" class="form-control" id="harga" name="harga"
                                placeholder="Masukan harga" value="{{ old('harga') }}">
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="reset" class="btn btn-secondary" id="btnReset">Reset</button>
                        <button type="submit" class="btn btn-primary" id="btnSimpan">Simpan</button>
                        <div id="loading" style="display: none;">
                            <i class="fas fa-spinner fa-spin"></i> Sedang Menyimpan...
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <script>
        $(document).ready(function() {
            // Tambahkan event listener pada tombol "Simpan"
            $('#btnSimpan').click(function() {
                // Sembunyikan tombol "Simpan" dan "Reset", serta tampilkan elemen loading
                $(this).hide();
                $('#btnReset').hide(); // Tambahkan id "btnReset" pada tombol "Reset"
                $('#loading').show();

                // Lakukan pengiriman formulir
                $('form').submit();
            });
        });
    </script>
@endsection
