@extends('layouts.app')

@section('title', 'Progres Pengerjaan')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Progres Pengerjaan</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/progres_pengerjaan') }}">Progres Pengerjaan</a>
                        </li>
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
            <form action="{{ url('admin/progres_pengerjaan/' . $progres->id) }}" method="POST"
                enctype="multipart/form-data" autocomplete="off">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Progres Pengerjaan</h3>
                    </div>
                    <!-- /.card-header -->
                    @csrf
                    @method('put')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nama">No SPK</label>
                            <input readonly type="text" class="form-control" id="kode_perintah" name="kode_perintah"
                                placeholder="Masukan nama lengkap"
                                value="{{ old('kode_perintah', $progres->kode_perintah) }}">
                        </div>
                        <div class="form-group">
                            <label for="nama">Pelanggan</label>
                            <input readonly type="text" class="form-control" id="nama_pelanggan" name="nama_pelanggan"
                                placeholder="Masukan nama kecil"
                                value="{{ old('nama_pelanggan', $progres->pelanggan->nama_pelanggan ?? null) }}">
                        </div>
                        <div class="form-group">
                            <label for="nama">Bentuk Karoseri</label>
                            <input readonly type="text" class="form-control" id="nama_karoseri" name="nama_karoseri"
                                placeholder="Masukan nama lengkap"
                                value="{{ old('nama_karoseri', $progres->spk->typekaroseri->nama_karoseri ?? null) }}">
                        </div>
                        <div class="form-group">
                            <label for="nama">Tanggal</label>
                            <input readonly type="text" class="form-control" id="tanggal" name="tanggal"
                                placeholder="Masukan nama kecil" value="{{ old('tanggal', $progres->tanggal_awal) }}">
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tunggu Produksi</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3  col-md-4">
                            <label for="tgl_tungguproduksi">Tanggal Tunggu Produksi</label>
                            <div class="input-group date" id="reservationdatetime">
                                <input type="date" id="tgl_tungguproduksi" name="tgl_tungguproduksi"
                                    placeholder="d M Y sampai d M Y"
                                    data-options='{"mode":"range","dateFormat":"d M Y","disableMobile":true}'
                                    value="{{ old('tgl_tungguproduksi', $progres->tgl_tungguproduksi) }}"
                                    class="form-control datetimepicker-input" data-target="#reservationdatetime">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Naik Produksi</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3  col-md-4">
                            <label for="tgl_naikproduksi">Tanggal Naik Produksi</label>
                            <div class="input-group date" id="reservationdatetime">
                                <input type="date" id="tgl_naikproduksi" name="tgl_naikproduksi"
                                    placeholder="d M Y sampai d M Y"
                                    data-options='{"mode":"range","dateFormat":"d M Y","disableMobile":true}'
                                    value="{{ old('tgl_naikproduksi', $progres->tgl_naikproduksi) }}"
                                    class="form-control datetimepicker-input" data-target="#reservationdatetime">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Pengerjaan Lantai</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            @if ($progres->ft_pengerjaanlantai == null)
                                <img class="mt-3" src="{{ asset('storage/uploads/gambaricon/imagenoimage.jpg') }}"
                                    alt="tigerload" height="180" width="200">
                            @else
                                <img class="mt-3" src="{{ asset('storage/uploads/' . $progres->ft_pengerjaanlantai) }}"
                                    alt="tigerload" height="180" width="200">
                            @endif
                        </div>
                        <div class="row">
                            <div class="form-group mb-3 col-md-4">
                                <label for="ft_pengerjaanlantai">Pengerjaan Lantai</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="ft_pengerjaanlantai"
                                        name="ft_pengerjaanlantai" accept="image/*">
                                    <label class="custom-file-label" for="ft_pengerjaanlantai">Masukkan Foto</label>
                                </div>
                            </div>
                            <div class="form-group mb-3  col-md-4">
                                <label for="tgl_pengerjaanlantai">Tanggal Pengerjaan</label>
                                <div class="input-group date" id="reservationdatetime">
                                    <input type="date" id="tgl_pengerjaanlantai" name="tgl_pengerjaanlantai"
                                        placeholder="d M Y sampai d M Y"
                                        data-options='{"mode":"range","dateFormat":"d M Y","disableMobile":true}'
                                        value="{{ old('tgl_pengerjaanlantai', $progres->tgl_pengerjaanlantai) }}"
                                        class="form-control datetimepicker-input" data-target="#reservationdatetime">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Pengerjaan Dinding</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            @if ($progres->ft_pengerjaandinding == null)
                                <img class="mt-3" src="{{ asset('storage/uploads/gambaricon/imagenoimage.jpg') }}"
                                    alt="tigerload" height="180" width="200">
                            @else
                                <img class="mt-3"
                                    src="{{ asset('storage/uploads/' . $progres->ft_pengerjaandinding) }}"
                                    alt="tigerload" height="180" width="200">
                            @endif
                        </div>
                        <div class="row">
                            <div class="form-group mb-3 col-md-4">
                                <label for="ft_pengerjaandinding">Pengerjaan Dinding</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="ft_pengerjaandinding"
                                        name="ft_pengerjaandinding" accept="image/*">
                                    <label class="custom-file-label" for="ft_pengerjaandinding">Masukkan Foto</label>
                                </div>
                            </div>
                            <div class="form-group mb-3  col-md-4">
                                <label for="tgl_pengerjaandinding">Tanggal Pengerjaan</label>
                                <div class="input-group date" id="reservationdatetime">
                                    <input type="date" id="tgl_pengerjaandinding" name="tgl_pengerjaandinding"
                                        placeholder="d M Y sampai d M Y"
                                        data-options='{"mode":"range","dateFormat":"d M Y","disableMobile":true}'
                                        value="{{ old('tgl_pengerjaandinding', $progres->tgl_pengerjaandinding) }}"
                                        class="form-control datetimepicker-input" data-target="#reservationdatetime">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Pengelasan</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            @if ($progres->ft_pengelasan == null)
                                <img class="mt-3" src="{{ asset('storage/uploads/gambaricon/imagenoimage.jpg') }}"
                                    alt="tigerload" height="180" width="200">
                            @else
                                <img class="mt-3" src="{{ asset('storage/uploads/' . $progres->ft_pengelasan) }}"
                                    alt="tigerload" height="180" width="200">
                            @endif
                        </div>
                        <div class="row">
                            <div class="form-group mb-3 col-md-4">
                                <label for="tgl_pengelasan">Pengelasan</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="ft_pengelasan"
                                        name="ft_pengelasan" accept="image/*">
                                    <label class="custom-file-label" for="ft_pengelasan">Masukkan Foto</label>
                                </div>
                            </div>
                            <div class="form-group mb-3  col-md-4">
                                <label for="tgl_pengelasan">Tanggal Pengelasan</label>
                                <div class="input-group date" id="reservationdatetime">
                                    <input type="date" id="tgl_pengelasan" name="tgl_pengelasan"
                                        placeholder="d M Y sampai d M Y"
                                        data-options='{"mode":"range","dateFormat":"d M Y","disableMobile":true}'
                                        value="{{ old('tgl_pengelasan', $progres->tgl_pengelasan) }}"
                                        class="form-control datetimepicker-input" data-target="#reservationdatetime">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Naik Sasis</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            @if ($progres->ft_naiksasis == null)
                                <img class="mt-3" src="{{ asset('storage/uploads/gambaricon/imagenoimage.jpg') }}"
                                    alt="tigerload" height="180" width="200">
                            @else
                                <img class="mt-3" src="{{ asset('storage/uploads/' . $progres->ft_naiksasis) }}"
                                    alt="tigerload" height="180" width="200">
                            @endif
                        </div>
                        <div class="row">
                            <div class="form-group mb-3 col-md-4">
                                <label for="tgl_pengelasan">Naik Sasis</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="ft_naiksasis"
                                        name="ft_naiksasis" accept="image/*">
                                    <label class="custom-file-label" for="ft_naiksasis">Masukkan Foto</label>
                                </div>
                            </div>
                            <div class="form-group mb-3  col-md-4">
                                <label for="tgl_naiksasis">Tanggal Naik Sasis</label>
                                <div class="input-group date" id="reservationdatetime">
                                    <input type="date" id="tgl_naiksasis" name="tgl_naiksasis"
                                        placeholder="d M Y sampai d M Y"
                                        data-options='{"mode":"range","dateFormat":"d M Y","disableMobile":true}'
                                        value="{{ old('tgl_naiksasis', $progres->tgl_naiksasis) }}"
                                        class="form-control datetimepicker-input" data-target="#reservationdatetime">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Proses Pengecatan</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            @if ($progres->ft_prosespengecatan == null)
                                <img class="mt-3" src="{{ asset('storage/uploads/gambaricon/imagenoimage.jpg') }}"
                                    alt="tigerload" height="180" width="200">
                            @else
                                <img class="mt-3" src="{{ asset('storage/uploads/' . $progres->ft_prosespengecatan) }}"
                                    alt="tigerload" height="180" width="200">
                            @endif
                        </div>
                        <div class="row">
                            <div class="form-group mb-3 col-md-4">
                                <label for="tgl_pengelasan">Proses Pengecatan</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="ft_prosespengecatan"
                                        name="ft_prosespengecatan" accept="image/*">
                                    <label class="custom-file-label" for="ft_prosespengecatan">Masukkan Foto</label>
                                </div>
                            </div>
                            <div class="form-group mb-3  col-md-4">
                                <label for="tgl_prosespengecatan">Tanggal Proses Pengecatan</label>
                                <div class="input-group date" id="reservationdatetime">
                                    <input type="date" id="tgl_prosespengecatan" name="tgl_prosespengecatan"
                                        placeholder="d M Y sampai d M Y"
                                        data-options='{"mode":"range","dateFormat":"d M Y","disableMobile":true}'
                                        value="{{ old('tgl_prosespengecatan', $progres->tgl_prosespengecatan) }}"
                                        class="form-control datetimepicker-input" data-target="#reservationdatetime">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Selesai Produksi</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            @if ($progres->ft_selesaiproduksi == null)
                                <img class="mt-3" src="{{ asset('storage/uploads/gambaricon/imagenoimage.jpg') }}"
                                    alt="tigerload" height="180" width="200">
                            @else
                                <img class="mt-3" src="{{ asset('storage/uploads/' . $progres->ft_selesaiproduksi) }}"
                                    alt="tigerload" height="180" width="200">
                            @endif
                        </div>
                        <div class="row">
                            <div class="form-group mb-3 col-md-4">
                                <label for="tgl_pengelasan">Selesai Produksi</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="ft_selesaiproduksi"
                                        name="ft_selesaiproduksi" accept="image/*">
                                    <label class="custom-file-label" for="ft_selesaiproduksi">Masukkan Foto</label>
                                </div>
                            </div>
                            <div class="form-group mb-3  col-md-4">
                                <label for="tgl_selesaiproduksi">Tanggal Selesai Produksi</label>
                                <div class="input-group date" id="reservationdatetime">
                                    <input type="date" id="tgl_selesaiproduksi" name="tgl_selesaiproduksi"
                                        placeholder="d M Y sampai d M Y"
                                        data-options='{"mode":"range","dateFormat":"d M Y","disableMobile":true}'
                                        value="{{ old('tgl_selesaiproduksi', $progres->tgl_selesaiproduksi) }}"
                                        class="form-control datetimepicker-input" data-target="#reservationdatetime">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Pengajuan Serut</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            @if ($progres->ft_pengajuanserut == null)
                                <img class="mt-3" src="{{ asset('storage/uploads/gambaricon/imagenoimage.jpg') }}"
                                    alt="tigerload" height="180" width="200">
                            @else
                                <img class="mt-3" src="{{ asset('storage/uploads/' . $progres->ft_pengajuanserut) }}"
                                    alt="tigerload" height="180" width="200">
                            @endif
                        </div>
                        <div class="row">
                            <div class="form-group mb-3 col-md-4">
                                <label for="tgl_pengelasan">Pengajuan Serut</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="ft_pengajuanserut"
                                        name="ft_pengajuanserut" accept="image/*">
                                    <label class="custom-file-label" for="ft_pengajuanserut">Masukkan Foto</label>
                                </div>
                            </div>
                            <div class="form-group mb-3  col-md-4">
                                <label for="tgl_pengajuanserut">Tanggal Pengajuan Serut</label>
                                <div class="input-group date" id="reservationdatetime">
                                    <input type="date" id="tgl_pengajuanserut" name="tgl_pengajuanserut"
                                        placeholder="d M Y sampai d M Y"
                                        data-options='{"mode":"range","dateFormat":"d M Y","disableMobile":true}'
                                        value="{{ old('tgl_pengajuanserut', $progres->tgl_pengajuanserut) }}"
                                        class="form-control datetimepicker-input" data-target="#reservationdatetime">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Selesai Pemeriksaan</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            @if ($progres->ft_selesaipemeriksaan == null)
                                <img class="mt-3" src="{{ asset('storage/uploads/gambaricon/imagenoimage.jpg') }}"
                                    alt="tigerload" height="180" width="200">
                            @else
                                <img class="mt-3"
                                    src="{{ asset('storage/uploads/' . $progres->ft_selesaipemeriksaan) }}"
                                    alt="tigerload" height="180" width="200">
                            @endif
                        </div>
                        <div class="row">
                            <div class="form-group mb-3 col-md-4">
                                <label for="tgl_pengelasan">Selesai Pemeriksaan</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="ft_selesaipemeriksaan"
                                        name="ft_selesaipemeriksaan" accept="image/*">
                                    <label class="custom-file-label" for="ft_selesaipemeriksaan">Masukkan Foto</label>
                                </div>
                            </div>
                            <div class="form-group mb-3  col-md-4">
                                <label for="tgl_selesaipemeriksaan">Tanggal Selesai Pemeriksaan</label>
                                <div class="input-group date" id="reservationdatetime">
                                    <input type="date" id="tgl_selesaipemeriksaan" name="tgl_selesaipemeriksaan"
                                        placeholder="d M Y sampai d M Y"
                                        data-options='{"mode":"range","dateFormat":"d M Y","disableMobile":true}'
                                        value="{{ old('tgl_selesaipemeriksaan', $progres->tgl_selesaipemeriksaan) }}"
                                        class="form-control datetimepicker-input" data-target="#reservationdatetime">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Ditrima Customer</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            @if ($progres->ft_ditrimacustomer == null)
                                <img class="mt-3" src="{{ asset('storage/uploads/gambaricon/imagenoimage.jpg') }}"
                                    alt="tigerload" height="180" width="200">
                            @else
                                <img class="mt-3" src="{{ asset('storage/uploads/' . $progres->ft_ditrimacustomer) }}"
                                    alt="tigerload" height="180" width="200">
                            @endif
                        </div>
                        <div class="row">
                            <div class="form-group mb-3 col-md-4">
                                <label for="tgl_pengelasan">Ditrima Customer</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="ft_ditrimacustomer"
                                        name="ft_ditrimacustomer" accept="image/*">
                                    <label class="custom-file-label" for="ft_ditrimacustomer">Masukkan Foto</label>
                                </div>
                            </div>
                            <div class="form-group mb-3  col-md-4">
                                <label for="tgl_ditrimacustomer">Tanggal Ditrima Customer</label>
                                <div class="input-group date" id="reservationdatetime">
                                    <input type="date" id="tgl_ditrimacustomer" name="tgl_ditrimacustomer"
                                        placeholder="d M Y sampai d M Y"
                                        data-options='{"mode":"range","dateFormat":"d M Y","disableMobile":true}'
                                        value="{{ old('tgl_ditrimacustomer', $progres->tgl_ditrimacustomer) }}"
                                        class="form-control datetimepicker-input" data-target="#reservationdatetime">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="reset" class="btn btn-secondary">Reset</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
