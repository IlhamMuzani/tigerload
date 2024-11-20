@extends('layouts.app')

@section('title', 'Perbarui Merek')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Merek</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/kendaraan') }}">Kendaraan</a></li>
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
            <form action="{{ url('admin/merek/' . $merek->id) }}" method="POST" enctype="multipart/form-data"
                autocomplete="off">
                @csrf
                @method('put')
                <div class="card-body">
                    {{-- <div class="row"> --}}
                    <div class="form-group">
                        <label class="form-label" for="nama_merek">Nama Merek *</label>
                        <input class="form-control @error('nama_merek') is-invalid @enderror" id="nama_merek"
                            name="nama_merek" type="text" placeholder="masukan nama  merek"
                            value="{{ old('nama_merek', $merek->nama_merek) }}" />
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="tipe_id">Nama Type *</label>
                        <div class="mb-3 d-flex">
                            <select class="form-control" id="tipe_id" name="tipe_id" style="margin-right: 10px;">
                                <option value="">- Pilih -</option>
                                @foreach ($tipes as $tipe)
                                    <option value="{{ $tipe->id }}"
                                        {{ old('tipe_id', $merek->tipe_id) == $tipe->id ? 'selected' : '' }}>
                                        {{ $tipe->nama_tipe }}</option>
                                @endforeach
                            </select>
                            
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-tipe">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <button type="reset" class="btn btn-secondary">Reset</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
            {{-- </div> --}}
            <div class="modal fade" id="modal-tipe">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Tambah Type</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ url('admin/tipe') }}" method="POST" enctype="multipart/form-data"
                            autocomplete="off">
                            @csrf
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label" for="nama_tipe">Nama Type *</label>
                                    <input class="form-control @error('nama_tipe') is-invalid @enderror" id="nama_tipe"
                                        name="nama_tipe" type="text" placeholder="masukan nama tipe"
                                        value="{{ old('nama_tipe') }}" />
                                </div>
                                <div class="card-footer text-right">
                                    <button type="reset" class="btn btn-secondary">Reset</button>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
