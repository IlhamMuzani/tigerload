@extends('layouts.app')

@section('title', 'Perbarui Barang Non Besi')

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
                        <li class="breadcrumb-item"><a href="{{ url('admin/barangnonbesi') }}">Barang Non Besi</a></li>
                        <li class="breadcrumb-item active">Perbarui</li>
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
                    <h3 class="card-title">Perbarui Barang Non Besi</h3>
                </div>
                <!-- /.card-header -->
                <form action="{{ url('admin/barangnonbesi/' . $barangnonbesi->id) }}" method="POST"
                    enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    @method('put')
                    <div class="card-body">
                        <div class="form-group">
                            <label class="form-label" for="kategori">Pilih Kategori</label>
                            <select class="form-control" id="kategori" name="kategori">
                                <option value="">- Pilih -</option>
                                <option value="besi"
                                    {{ old('kategori', $barangnonbesi->kategori) == 'besi' ? 'selected' : null }}>
                                    Besi</option>
                                <option value="non besi"
                                    {{ old('kategori', $barangnonbesi->kategori) == 'non besi' ? 'selected' : null }}>
                                    Non Besi</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nama_barang">Nama Barang</label>
                            <input type="text" class="form-control" id="nama_barang" name="nama_barang"
                                placeholder="Masukan nama barang"
                                value="{{ old('nama_barang', $barangnonbesi->nama_barang) }}">
                        </div>
                        <div class="form-group">
                            <label for="jumlah">Ukuran</label>
                            <input type="text" class="form-control" id="jumlah" name="jumlah"
                                placeholder="Masukan jumlah" value="{{ old('jumlah', $barangnonbesi->jumlah) }}">
                        </div>
                        <div class="form-group">
                            <label for="nama">Spesifikasi</label>
                            <input type="text" class="form-control" id="spesifikasi" name="spesifikasi"
                                placeholder="Masukan spesifikasi"
                                value="{{ old('spesifikasi', $barangnonbesi->spesifikasi) }}">
                        </div>
                        <div class="form-group">
                            <label for="nama">Keterangan</label>
                            <input type="text" class="form-control" id="keterangan" name="keterangan"
                                placeholder="Masukan keterangan"
                                value="{{ old('keterangan', $barangnonbesi->keterangan) }}">
                        </div>
                        <div class="form-group">
                            <label for="harga">Harga</label>
                            <input type="text" class="form-control" id="harga" name="harga"
                                placeholder="Masukan harga" value="{{ old('harga', $barangnonbesi->harga) }}">
                        </div>
                    </div>
            </div>
            <div class="card-footer text-right">
                <button type="reset" class="btn btn-secondary">Reset</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
            </form>
        </div>
        </div>
    </section>
@endsection
