@extends('layouts.app')

@section('title', 'Perbarui Ban')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Ban</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/ban') }}">Ban</a></li>
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
            <form action="{{ url('admin/ban/' . $ban->id) }}" method="POST" enctype="multipart/form-data"
                autocomplete="off">
                @csrf
                @method('put')
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Perbarui Ban</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="no_seri">No. Seri</label>
                                    <input type="text" class="form-control" id="no_seri" name="no_seri"
                                        placeholder="Masukan no seri" value="{{ old('no_seri', $ban->no_seri) }}">
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="ukuran_id">Ukuran</label>
                                    <select class="custom-select form-control" id="ukuran_id" name="ukuran_id">
                                        <option value="">- Pilih Ukuran -</option>
                                        @foreach ($ukurans as $ukuran)
                                            <option value="{{ $ukuran->id }}"
                                                {{ old('ukuran_id', $ban->ukuran_id) == $ukuran->id ? 'selected' : '' }}>
                                                {{ $ukuran->ukuran }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label" for="kondisi_ban">Pilih Kondisi Ban</label>
                                <select class="form-control" id="kondisi_ban" name="kondisi_ban">
                                    <option value="">- Pilih -</option>
                                    <option value="baru"
                                        {{ old('kondisi_ban', $ban->kondisi_ban) == 'baru' ? 'selected' : null }}>
                                        BARU</option>
                                    <option value="bekas"
                                        {{ old('kondisi_ban', $ban->kondisi_ban) == 'bekas' ? 'selected' : null }}>
                                        BEKAS</option>
                                    <option value="kanisir"
                                        {{ old('kondisi_ban', $ban->kondisi_ban) == 'kanisir' ? 'selected' : null }}>
                                        KANISIR</option>
                                    <option value="afkir"
                                        {{ old('kondisi_ban', $ban->kondisi_ban) == 'afkir' ? 'selected' : null }}>
                                        AFKIR</option>
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="merek_id">Merek ban</label>
                                    <select class="custom-select form-control" id="merek_id" name="merek_id">
                                        <option value="">- Pilih -</option>
                                        @foreach ($mereks as $merek)
                                            <option value="{{ $merek->id }}"
                                                {{ old('merek_id', $ban->merek_id) == $merek->id ? 'selected' : '' }}>
                                                {{ $merek->nama_merek }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="harga">Harga</label>
                                    <input type="number" class="form-control" id="harga" name="harga"
                                        placeholder="Masukan harga" value="{{ old('harga', $ban->harga) }}">
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="umur_ban">Umur Ban</label>
                                    <input type="umur_ban" class="form-control" id="umur_ban" name="umur_ban"
                                        placeholder="Masukan umur ban" value="{{ old('umur_ban', $ban->umur_ban) }}">
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="target-km">Target Km</label>
                                    <input type="target" class="form-control" id="target_km_ban" name="target_km_ban"
                                        placeholder="Masukan target km"
                                        value="{{ old('target_km_ban', $ban->target_km_ban) }}">
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <button type="reset" class="btn btn-secondary">Reset</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
            {{-- </div> --}}
        </div>
    </section>
@endsection
