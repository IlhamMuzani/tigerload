@extends('layouts.app')

@section('title', 'Tambah SPK')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Surat Pemesanan Kendaraan</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('admin/spk') }}">SPK</a></li>
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
                <i class="icon fas fa-ban"></i> Error!
            </h5>
            @foreach (session('error') as $error)
            - {{ $error }} <br>
            @endforeach
        </div>
        @endif
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
                <h3 class="card-title">Tambah SPK</h3>
            </div>
            <!-- /.card-header -->
            <form action="{{ url('admin/spk') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
                @csrf
                {{-- <div class="card-body">
                        <label class="form-label" for="no_pol">Pelanggan *</label>
                        <div class="mb-2 d-flex">
                            <select class="form-control" id="pelanggan_id" name="pelanggan_id" style="margin-right: 10px;">
                                <option value="">- Pilih -</option>
                                @foreach ($pelanggans as $pelanggan)
                                    <option value="{{ $pelanggan->id }}"
                {{ old('pelanggan_id') == $pelanggan->id ? 'selected' : '' }}>
                {{ $pelanggan->nama_pelanggan }}
                </option>
                @endforeach
                </select>
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-pelanggan">
                    <i class="fas fa-plus"></i>
                </button>
        </div>
        <div class="mb-3 mt-4">
            <button class="btn btn-primary btn-sm" type="button" onclick="showCategoryModalmarketing(this.value)">
                Pilih Marketing
            </button>
        </div>

        <label class="form-label" for="nama_marketing">Nama Marketing *</label>
        <div class="mb-2 d-flex">
            <input class="form-control @error('nama_marketing') is-invalid @enderror" id="nama_marketing"
                name="nama_marketing" type="text" placeholder=" " value="{{ old('nama_marketing') }}" readonly
                style="margin-right: 10px;" />
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-marketing">
                <i class="fas fa-plus"></i>
            </button>
        </div>
        <div class="form-group" hidden>
            <label for="marketing_id">Id Marketing</label>
            <input type="text" class="form-control" id="marketing_id" name="marketing_id" placeholder=""
                value="{{ old('marketing_id') }}">
        </div>
        <div class="form-group">
            <label for="kode_marketing">Kode Marketing</label>
            <input type="text" class="form-control" id="kode_marketing" name="kode_marketing" readonly placeholder=""
                value="{{ old('kode_marketing') }}">
        </div>
        <div class="form-group">
            <label for="umur">Umur</label>
            <input type="text" class="form-control" id="umur_marketing" name="umur" placeholder="" readonly
                value="{{ old('umur') }}">
        </div>
        <div class="form-group">
            <label for="alamat">Alamat</label>
            <textarea type="text" class="form-control" id="alamat_marketing" name="alamat" readonly
                placeholder="">{{ old('alamat') }}</textarea>
        </div>
        <div class="form-group">
            <label for="telp">No. Telepon</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">+62</span>
                </div>
                <input type="text" id="telp_marketing" name="telp" class="form-control" readonly placeholder=""
                    value="{{ old('telp') }}">
            </div>
        </div>
    </div> --}}


    <div class="card-body">
        {{-- <div class="mb-3">
                            <h3 class="card-title">Tambah Kendaraan</h3>
                        </div> --}}

        <div class="mb-3">
            <button class="btn btn-primary btn-sm" type="button" onclick="showCategoryModalpelanggan(this.value)">
                Pilih Pelanggan
            </button>
        </div>

        <label class="form-label" for="nama_pelanggan">Nama Pelanggan *</label>
        <div class="mb-2 d-flex">
            <input class="form-control @error('nama_pelanggan') is-invalid @enderror" id="nama_pelanggan"
                name="nama_pelanggan" type="text" placeholder=" " value="{{ old('nama_pelanggan') }}" readonly
                style="margin-right: 10px;" />
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-pelanggan">
                <i class="fas fa-plus"></i>
            </button>
        </div>
        <div class="form-group" hidden>
            <label for="pelanggan_id">Id Pelanggan</label>
            <input type="text" class="form-control" id="pelanggan_id" name="pelanggan_id" placeholder=""
                value="{{ old('pelanggan_id') }}">
        </div>
        <div class="form-group">
            <label for="kode_pelanggan">Kode Pelanggan</label>
            <input type="text" class="form-control" id="kode_pelanggan" name="kode_pelanggan" readonly placeholder=""
                value="{{ old('kode_pelanggan') }}">
        </div>
        <div class="form-group">
            <label for="umur">Umur</label>
            <input type="text" class="form-control" id="umur" name="umur" placeholder="" readonly
                value="{{ old('umur') }}">
        </div>
        <div class="form-group">
            <label for="alamat">Alamat</label>
            <textarea type="text" class="form-control" id="alamat" name="alamat" readonly
                placeholder="">{{ old('alamat') }}</textarea>
        </div>
        <div class="form-group">
            <label for="telp">No. Telepon</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">+62</span>
                </div>
                <input type="text" id="telp" name="telp" class="form-control" readonly placeholder=""
                    value="{{ old('telp') }}">
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label" for="no_rangka">Tambah Kendaraan</label>
        </div>

        <div class="mb-3">
            <label class="form-label" for="no_rangka">No. Rangka *</label>
            <input class="form-control @error('no_rangka') is-invalid @enderror" id="no_rangka" name="no_rangka"
                type="text" placeholder="masukan no rangka" value="{{ old('no_rangka') }}" />
        </div>
        <div class="mb-3">
            <label class="form-label" for="no_mesin">No. Mesin *</label>
            <input class="form-control @error('no_mesin') is-invalid @enderror" id="no_mesin" name="no_mesin"
                type="text" placeholder="masukan no mesin" value="{{ old('no_mesin') }}" />
        </div>
        <div class="mb-3">
            <label class="form-label" for="tahun">Tahun *</label>
            <select class="form-control" id="tahun" name="tahun">
                <option value="">- Pilih -</option>
                <option value="2025" {{ old('tahun') == '2025' ? 'selected' : null }}>
                    2025</option>
                <option value="2024" {{ old('tahun') == '2024' ? 'selected' : null }}>
                    2024</option>
                <option value="2023" {{ old('tahun') == '2023' ? 'selected' : null }}>
                    2023</option>
                <option value="2022" {{ old('tahun') == '2022' ? 'selected' : null }}>
                    2022</option>
                <option value="2021" {{ old('tahun') == '2021' ? 'selected' : null }}>
                    2021</option>
                <option value="2020" {{ old('tahun') == '2020' ? 'selected' : null }}>
                    2020</option>
                <option value="2019" {{ old('tahun') == '2019' ? 'selected' : null }}>
                    2019</option>
                <option value="2018" {{ old('tahun') == '2018' ? 'selected' : null }}>
                    2018</option>
                <option value="2017" {{ old('tahun') == '2017' ? 'selected' : null }}>
                    2017</option>
                <option value="2016" {{ old('tahun') == '2016' ? 'selected' : null }}>
                    2016</option>
                <option value="2015" {{ old('tahun') == '2015' ? 'selected' : null }}>
                    2015</option>
                <option value="2014" {{ old('tahun') == '2014' ? 'selected' : null }}>
                    2014</option>
                <option value="2013" {{ old('tahun') == '2013' ? 'selected' : null }}>
                    2013</option>
                <option value="2012" {{ old('tahun') == '2012' ? 'selected' : null }}>
                    2012</option>
                <option value="2011" {{ old('tahun') == '2011' ? 'selected' : null }}>
                    2011</option>
                <option value="2010" {{ old('tahun') == '2010' ? 'selected' : null }}>
                    2010</option>
                <option value="2009" {{ old('tahun') == '2009' ? 'selected' : null }}>
                    2009</option>
                <option value="2008" {{ old('tahun') == '2008' ? 'selected' : null }}>
                    2008</option>
                <option value="2007" {{ old('tahun') == '2007' ? 'selected' : null }}>
                    2007</option>
                <option value="2006" {{ old('tahun') == '2006' ? 'selected' : null }}>
                    2006</option>
                <option value="2005" {{ old('tahun') == '2005' ? 'selected' : null }}>
                    2005</option>
                <option value="2004" {{ old('tahun') == '2004' ? 'selected' : null }}>
                    2004</option>
                <option value="2003" {{ old('tahun') == '2003' ? 'selected' : null }}>
                    2003</option>
                <option value="2002" {{ old('tahun') == '2002' ? 'selected' : null }}>
                    2002</option>
                <option value="2001" {{ old('tahun') == '2001' ? 'selected' : null }}>
                    2001</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label" for="warna">Warna *</label>
            <select class="form-control" id="warna" name="warna">
                <option value="">- Pilih -</option>
                <option value="Hitam" {{ old('warna') == 'Hitam' ? 'selected' : null }}>
                    Hitam</option>
                <option value="Putih" {{ old('warna') == 'Putih' ? 'selected' : null }}>
                    Putih</option>
                <option value="Cokelat" {{ old('warna') == 'Cokelat' ? 'selected' : null }}>
                    Cokelat</option>
                <option value="Hijau" {{ old('warna') == 'Hijau' ? 'selected' : null }}>
                    Hijau</option>
                <option value="Orange" {{ old('warna') == 'Orange' ? 'selected' : null }}>
                    Orange</option>
                <option value="Merah" {{ old('warna') == 'Merah' ? 'selected' : null }}>
                    Merah</option>
                <option value="Ungu" {{ old('warna') == 'Ungu' ? 'selected' : null }}>
                    Ungu</option>
                <option value="Kuning" {{ old('warna') == 'Kuning' ? 'selected' : null }}>
                    Kuning</option>
                <option value="Biru" {{ old('warna') == 'Biru' ? 'selected' : null }}>
                    Biru</option>
                <option value="Silver" {{ old('warna') == 'Silver' ? 'selected' : null }}>
                    Silver</option>
                <option value="Hitam" {{ old('warna') == 'Hitam' ? 'selected' : null }}>
                    Hitam</option>
                <option value="Putih" {{ old('warna') == 'Putih' ? 'selected' : null }}>
                    Putih</option>
                <option value="Abu-abu" {{ old('warna') == 'Abu-abu' ? 'selected' : null }}>
                    Abu-abu</option>
            </select>
        </div>
        <div class="mb-3 mt-4">
            <button class="btn btn-primary btn-sm" type="button" onclick="showCategoryModal(this.value)">
                Pilih Merek
            </button>
        </div>
        <div class="mb-3" hidden>
            <label class="form-label" for="merek_id">Merek_id *</label>
            <input class="form-control @error('merek_id') is-invalid @enderror" id="merek_id" name="merek_id" readonly
                type="text" placeholder="" value="{{ old('merek_id') }}" />
        </div>
        <div class="mb-3">
            <label class="form-label" for="nama_merek">Merek *</label>
            <input class="form-control @error('nama_merek') is-invalid @enderror" id="nama_merek" name="nama_merek"
                readonly type="text" placeholder="" value="{{ old('nama_merek') }}" />
        </div>
        <div class="mb-3">
            <label class="form-label" for="model">Model *</label>
            <input class="form-control @error('model') is-invalid @enderror" id="model" name="model" readonly
                type="text" placeholder="" value="{{ old('model') }}" />
        </div>
        <div class="mb-3">
            <label class="form-label" for="tipe">Tipe *</label>
            <input class="form-control @error('tipe') is-invalid @enderror" id="tipe" name="tipe" readonly type="text"
                placeholder="" value="{{ old('tipe') }}" />
        </div>
    </div>
    <div class="card-body">
        <div class="form-group mb-3">
            <label for="gambar_faktur">Foto Faktur</label>
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="gambar_faktur" name="gambar_faktur" accept="image/*">
                <label class="custom-file-label" for="gambar_faktur">Masukkan foto</label>
            </div>
        </div>

        <div class="form-group mb-3">
            <label for="gambar_serut">Foto Srut</label>
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="gambar_serut" name="gambar_serut" accept="image/*">
                <label class="custom-file-label" for="gambar_serut">Masukkan foto</label>
            </div>
        </div>
        <div class="form-group mb-3">
            <label for="gambar_rancangbangun">Foto Rancang Bangun</label>
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="gambar_rancangbangun" name="gambar_rancangbangun"
                    accept="image/*">
                <label class="custom-file-label" for="gambar_rancangbangun">Masukkan foto</label>
            </div>
        </div>
        <div class="form-group mb-3">
            <label for="gambar_gesekanmesin">Foto gesekan nomor mesin</label>
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="gambar_gesekanmesin" name="gambar_gesekanmesin"
                    accept="image/*">
                <label class="custom-file-label" for="gambar_gesekanmesin">Masukkan foto</label>
            </div>
        </div>
        <div class="form-group mb-5">
            <label for="gambar_gesekanrangka">Foto gesekan nomor rangka</label>
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="gambar_gesekanrangka" name="gambar_gesekanrangka"
                    accept="image/*">
                <label class="custom-file-label" for="gambar_gesekanrangka">Masukkan foto</label>
            </div>
        </div>
        <div class="form-group mb-3">
            <label for="gambar_depan">Foto Depan</label>
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="gambar_depan" name="gambar_depan" accept="image/*">
                <label class="custom-file-label" for="gambar_depan">Masukkan foto</label>
            </div>
        </div>
        <div class="form-group mb-3">
            <label for="gambar_belakang">Foto Belakang</label>
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="gambar_belakang" name="gambar_belakang"
                    accept="image/*">
                <label class="custom-file-label" for="gambar_belakang">Masukkan foto</label>
            </div>
        </div>
        <div class="form-group mb-3">
            <label for="gambar_kanan">Foto Kanan</label>
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="gambar_kanan" name="gambar_kanan" accept="image/*">
                <label class="custom-file-label" for="gambar_kanan">Masukkan foto</label>
            </div>
        </div>
        <div class="form-group mb-3">
            <label for="gambar_kiri">Foto Kiri</label>
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="gambar_kiri" name="gambar_kiri" accept="image/*">
                <label class="custom-file-label" for="gambar_kiri">Masukkan foto</label>
            </div>
        </div>

        <div class="mb-3 mt-4">
            <button class="btn btn-primary btn-sm" type="button" onclick="showCategoryModalkaroseri(this.value)">
                Pilih Karoseri
            </button>
        </div>

        <label class="form-label" for="kode_type">Kode Karoseri *</label>
        <div class="mb-2 d-flex">
            <input class="form-control @error('kode_type') is-invalid @enderror" id="kode_type" name="kode_type"
                type="text" placeholder=" " value="{{ old('kode_type') }}" readonly style="margin-right: 10px;" />
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-karoseri">
                <i class="fas fa-plus"></i>
            </button>
        </div>
        <div class="form-group">
            <label for="nama_karoseri">Nama Karoseri</label>
            <input type="text" class="form-control" id="nama_karoseri" name="nama_karoseri" readonly placeholder=""
                value="{{ old('nama_karoseri') }}">
        </div>
        <div class="form-group" hidden>
            <label for="karoseri_id">Id Karoseri</label>
            <input type="text" class="form-control" id="karoseri_id" name="typekaroseri_id" placeholder=""
                value="{{ old('typekaroseri_id') }}">
        </div>
        <div class="form-group">
            <label for="type_kendaraan">Type Kendaraan</label>
            <input type="text" class="form-control" id="type_kendaraan" name="type_kendaraan" placeholder="" readonly
                value="{{ old('type_kendaraan') }}">
        </div>
        <div class="form-group">
            <label for="panjang">Panjang</label>
            <input type="text" class="form-control" id="panjang" name="panjang" readonly placeholder=""
                value="{{ old('panjang') }}">
        </div>
        <div class="form-group">
            <label for="lebar">Lebar</label>
            <input type="text" class="form-control" id="lebar" name="lebar" readonly placeholder=""
                value="{{ old('lebar') }}">
        </div>
        <div class="form-group">
            <label for="tinggi">Tinggi</label>
            <input type="text" class="form-control" id="tinggi" name="tinggi" readonly placeholder=""
                value="{{ old('tinggi') }}">
        </div>
        <div class="form-group">
            <label for="sasis">Chasis</label>
            <input type="text" class="form-control" id="sasis" name="sasis" readonly placeholder=""
                value="{{ old('sasis') }}">
        </div>
        <div class="form-group">
            <label for="cros_member">Cross Member</label>
            <input type="text" class="form-control" id="cros_member" name="cros_member" readonly placeholder=""
                value="{{ old('cros_member') }}">
        </div>
        <div class="form-group">
            <label for="fream_samping">Frame Samping</label>
            <input type="text" class="form-control" id="fream_samping" name="fream_samping" readonly placeholder=""
                value="{{ old('fream_samping') }}">
        </div>
        <div class="form-group">
            <label for="diafragma">Diafragma</label>
            <input type="text" class="form-control" id="diafragma" name="diafragma" readonly placeholder=""
                value="{{ old('diafragma') }}">
        </div>
        <div class="form-group">
            <label for="lantai">Lantai</label>
            <input type="text" class="form-control" id="lantai" name="lantai" readonly placeholder=""
                value="{{ old('lantai') }}">
        </div>
        <div class="form-group">
            <label for="dinding">Dinding</label>
            <input type="text" class="form-control" id="dinding" name="dinding" readonly placeholder=""
                value="{{ old('dinding') }}">
        </div>

        <div class="mb-3">
            <label class="form-label" for="harga">Harga *</label>
            <input class="form-control @error('harga') is-invalid @enderror" id="harga" name="harga" type="text"
                placeholder="masukan harga" value="{{ old('harga') }}" />
        </div>
    </div>
    <div class="card-footer text-right">
        <button type="reset" class="btn btn-secondary">Reset</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
    </form>
    </div>
    </div>

    <div class="modal fade" id="tablePelanggan" data-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Data Pelanggan</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive scrollbar m-2">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead class="bg-200 text-900">
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Kode Pelanggan</th>
                                    <th>Nama Pelanggan</th>
                                    <th>Alamat</th>
                                    <th>Telepon</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pelanggans as $pelanggan)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $pelanggan->kode_pelanggan }}</td>
                                    <td>{{ $pelanggan->nama_pelanggan }}</td>
                                    <td>{{ $pelanggan->alamat }}</td>
                                    <td>{{ $pelanggan->telp }}</td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-primary btn-sm"
                                            onclick="getSelectedDatapelanggan('{{ $pelanggan->id }}', '{{ $pelanggan->kode_pelanggan }}', '{{ $pelanggan->nama_pelanggan }}', '{{ $pelanggan->telp }}', '{{ $pelanggan->umur }}', '{{ $pelanggan->alamat }}')">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-pelanggan">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Pelanggan</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('admin/pelanggans') }}" method="POST" enctype="multipart/form-data"
                    autocomplete="off">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nama_pelanggan">Nama Pelanggan</label>
                            <input type="text" class="form-control" id="nama_pelanggan" name="nama_pelanggan"
                                placeholder="Masukan nama pelanggan" value="{{ old('nama_pelanggan') }}">
                        </div>
                        <div class="form-group">
                            <label for="nama">Nama Alias</label>
                            <input type="text" class="form-control" id="nama_alias" name="nama_alias"
                                placeholder="Masukan nama alias" value="{{ old('nama_alias') }}">
                        </div>
                        <div class="form-group">
                            <label for="umur">Umur</label>
                            <input type="text" class="form-control" id="umur" name="umur" placeholder="Masukan umur"
                                value="{{ old('umur') }}">
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea type="text" class="form-control" id="alamat" name="alamat"
                                placeholder="Masukan alamat">{{ old('alamat') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="telp">No. Telepon</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">+62</span>
                                </div>
                                <input type="text" id="telp" name="telp" class="form-control"
                                    placeholder="Masukan nomor telepon" value="{{ old('telp') }}">
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="email">Email</label>
                            <input type="text" class="form-control" id="email" name="email" placeholder="Masukan email"
                                value="{{ old('email') }}">
                        </div>
                        <div class="form-group mb-3">
                            <label for="ig">Instagram</label>
                            <input type="text" class="form-control" id="ig" name="ig" placeholder="Masukan ig"
                                value="{{ old('ig') }}">
                        </div>
                        <div class="form-group mb-3">
                            <label for="fb">Facebook</label>
                            <input type="text" class="form-control" id="fb" name="fb" placeholder="Masukan fb"
                                value="{{ old('fb') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="jk">Jenis Kelamin *</label>
                            <select class="form-control" id="gender" name="gender">
                                <option value="">- Pilih -</option>
                                <option value="Laki-laki" {{ old('gender') == 'Laki-laki' ? 'selected' : null }}>
                                    Laki-laki</option>
                                <option value="Perempuan" {{ old('gender') == 'Perempuan' ? 'selected' : null }}>
                                    Perempuan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="gambar_ktp">Foto KTP</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="gambar_ktp" name="gambar_ktp"
                                    accept="image/*">
                                <label class="custom-file-label" for="gambar_ktp">Masukkan gambar</label>
                            </div>
                        </div>

                    </div>
                    <div class="card-footer text-end">
                        <button class="btn btn-secondary me-1" type="reset">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-karoseri">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Karoseri</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('admin/karoseris') }}" method="POST" enctype="multipart/form-data"
                    autocomplete="off">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nama_karoseri">Nama Karoseri</label>
                            <input type="text" class="form-control" id="nama_karoseri" name="nama_karoseri"
                                placeholder="Masukan nama karoseri" value="{{ old('nama_karoseri') }}">
                        </div>
                        <div class="form-group">
                            <label for="type_kendaraan">Type Kendaraan</label>
                            <input type="text" class="form-control" id="type_kendaraan" name="type_kendaraan"
                                placeholder="Masukan type kendaraan" value="{{ old('type_kendaraan') }}">
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="panjang">Panjang</label>
                            <input type="text" class="form-control" id="panjang" name="panjang"
                                placeholder="Masukan panjang" value="{{ old('panjang') }}">
                        </div>
                        <div class="form-group">
                            <label for="lebar">Lebar</label>
                            <input type="text" class="form-control" id="lebar" name="lebar" placeholder="Masukan lebar"
                                value="{{ old('lebar') }}">
                        </div>
                        <div class="form-group">
                            <label for="Tinggi">Tinggi</label>
                            <input type="text" class="form-control" id="tinggi" name="tinggi"
                                placeholder="Masukan tinggi" value="{{ old('tinggi') }}">
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nama">Sasis</label>
                            <input type="text" class="form-control" id="sasis" name="sasis" placeholder="Masukan sasis"
                                value="{{ old('sasis') }}">
                        </div>
                        <div class="form-group">
                            <label for="cros_member">Cros Member</label>
                            <input type="text" class="form-control" id="cros_member" name="cros_member"
                                placeholder="Masukan cros member" value="{{ old('cros_member') }}">
                        </div>
                        <div class="form-group">
                            <label for="fream_samping">Fream Samping</label>
                            <input type="text" class="form-control" id="fream_samping" name="fream_samping"
                                placeholder="Masukan fream samping" value="{{ old('fream_samping') }}">
                        </div>
                        <div class="form-group">
                            <label for="diafragma">Diafragma</label>
                            <input type="text" class="form-control" id="diafragma" name="diafragma"
                                placeholder="Masukan diafragma" value="{{ old('diafragma') }}">
                        </div>
                        <div class="form-group">
                            <label for="lantai">Lantai</label>
                            <input type="text" class="form-control" id="lantai" name="lantai"
                                placeholder="Masukan lantai" value="{{ old('lantai') }}">
                        </div>
                        <div class="form-group">
                            <label for="dinding">Dinding</label>
                            <input type="text" class="form-control" id="dinding" name="dinding"
                                placeholder="Masukan dinding" value="{{ old('dinding') }}">
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="reset" class="btn btn-secondary">Reset</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="tableMarketing" data-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Data Marketing</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive scrollbar m-2">
                        <table id="datatables3" class="table table-bordered table-striped">
                            <thead class="bg-200 text-900">
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Kode Marketing</th>
                                    <th>Nama Marketing</th>
                                    <th>Alamat</th>
                                    <th>Telepon</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($marketings as $marketing)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $marketing->kode_marketing }}</td>
                                    <td>{{ $marketing->nama_marketing }}</td>
                                    <td>{{ $marketing->alamat }}</td>
                                    <td>{{ $marketing->telp }}</td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-primary btn-sm"
                                            onclick="getSelectedDatamarketing('{{ $marketing->id }}', '{{ $marketing->kode_marketing }}', '{{ $marketing->nama_marketing }}', '{{ $marketing->telp }}', '{{ $marketing->umur }}', '{{ $marketing->alamat }}')">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="tableKaroseri" data-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Data Karoseri</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive scrollbar m-2">
                        <table id="example2" class="table table-bordered table-striped">
                            <thead class="bg-200 text-900">
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Kode Type Karoseri</th>
                                    <th>Nama Karoseri</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($typekaroseris as $typekaroseri)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $typekaroseri->kode_type }}</td>
                                    <td>{{ $typekaroseri->nama_karoseri }}</td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-primary btn-sm"
                                            onclick="getSelectedDatakaroseri('{{ $typekaroseri->id }}', '{{ $typekaroseri->kode_type }}', '{{ $typekaroseri->nama_karoseri }}', '{{ $typekaroseri->type_kendaraan }}', '{{ $typekaroseri->panjang }}', '{{ $typekaroseri->lebar }}', '{{ $typekaroseri->tinggi }}', '{{ $typekaroseri->sasis }}', '{{ $typekaroseri->cros_member }}', '{{ $typekaroseri->fream_samping }}', '{{ $typekaroseri->diafragma }}', '{{ $typekaroseri->lantai }}', '{{ $typekaroseri->dinding }}')">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-marketing">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Marketing</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('admin/marketings') }}" method="POST" enctype="multipart/form-data"
                    autocomplete="off">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nama_marketing">Nama Marketing</label>
                            <input type="text" class="form-control" id="nama_marketing" name="nama_marketing"
                                placeholder="Masukan nama marekting" value="{{ old('nama_marketing') }}">
                        </div>
                        <div class="form-group">
                            <label for="nama">Nama Alias</label>
                            <input type="text" class="form-control" id="nama_alias" name="nama_alias"
                                placeholder="Masukan nama alias" value="{{ old('nama_alias') }}">
                        </div>
                        <div class="form-group">
                            <label for="umur">Umur</label>
                            <input type="text" class="form-control" id="umur" name="umur" placeholder="Masukan umur"
                                value="{{ old('umur') }}">
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea type="text" class="form-control" id="alamat" name="alamat"
                                placeholder="Masukan alamat">{{ old('alamat') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="telp">No. Telepon</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">+62</span>
                                </div>
                                <input type="text" id="telp" name="telp" class="form-control"
                                    placeholder="Masukan nomor telepon" value="{{ old('telp') }}">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="jk">Jenis Kelamin *</label>
                            <select class="form-control" id="gender" name="gender">
                                <option value="">- Pilih -</option>
                                <option value="Laki-laki" {{ old('gender') == 'Laki-laki' ? 'selected' : null }}>
                                    Laki-laki</option>
                                <option value="Perempuan" {{ old('gender') == 'Perempuan' ? 'selected' : null }}>
                                    Perempuan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="gambar_ktp">Foto KTP</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="gambar_ktp" name="gambar_ktp"
                                    accept="image/*">
                                <label class="custom-file-label" for="gambar_ktp">Masukkan gambar</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="harga">Harga</label>
                            <input type="text" class="form-control" id="harga" name="harga" placeholder="Masukan harga"
                                value="{{ old('harga') }}">
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <button class="btn btn-secondary me-1" type="reset">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- <div class="modal fade" id="modal-pelanggan">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Tambah Pelanggan</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ url('admin/pelanggans') }}" method="POST" enctype="multipart/form-data"
    autocomplete="off">
    @csrf
    <div class="card-body">
        <div class="form-group">
            <label for="nama_pelanggan">Nama Pelanggan</label>
            <input type="text" class="form-control" id="nama_pelanggan" name="nama_pelanggan"
                placeholder="Masukan nama pelanggan" value="{{ old('nama_pelanggan') }}">
        </div>
        <div class="form-group">
            <label for="nama">Nama Alias</label>
            <input type="text" class="form-control" id="nama_alias" name="nama_alias" placeholder="Masukan nama alias"
                value="{{ old('nama_alias') }}">
        </div>
        <div class="form-group">
            <label for="umur">Umur</label>
            <input type="text" class="form-control" id="umur" name="umur" placeholder="Masukan umur"
                value="{{ old('umur') }}">
        </div>
        <div class="form-group">
            <label for="alamat">Alamat</label>
            <textarea type="text" class="form-control" id="alamat" name="alamat"
                placeholder="Masukan alamat">{{ old('alamat') }}</textarea>
        </div>
        <div class="form-group">
            <label for="telp">No. Telepon</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">+62</span>
                </div>
                <input type="text" id="telp" name="telp" class="form-control" placeholder="Masukan nomor telepon"
                    value="{{ old('telp') }}">
            </div>
        </div>
        <div class="form-group mb-3">
            <label for="email">Email</label>
            <input type="text" class="form-control" id="email" name="email" placeholder="Masukan email"
                value="{{ old('email') }}">
        </div>
        <div class="form-group mb-3">
            <label for="ig">Instagram</label>
            <input type="text" class="form-control" id="ig" name="ig" placeholder="Masukan ig" value="{{ old('ig') }}">
        </div>
        <div class="form-group mb-3">
            <label for="fb">Facebook</label>
            <input type="text" class="form-control" id="fb" name="fb" placeholder="Masukan fb" value="{{ old('fb') }}">
        </div>
        <div class="mb-3">
            <label class="form-label" for="jk">Jenis Kelamin *</label>
            <select class="form-control" id="gender" name="gender">
                <option value="">- Pilih -</option>
                <option value="Laki-laki" {{ old('gender') == 'Laki-laki' ? 'selected' : null }}>
                    Laki-laki</option>
                <option value="Perempuan" {{ old('gender') == 'Perempuan' ? 'selected' : null }}>
                    Perempuan</option>
            </select>
        </div>
        <div class="form-group">
            <label for="gambar_ktp">Foto KTP</label>
            <input class="form-control @error('gambar_ktp') is-invalid @enderror" id="gambar_ktp" name="gambar_ktp"
                type="file" accept="image/*" />
            @error('gambar_ktp')
            <span class="invalid-feedback" role="alert">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="card-footer text-end">
        <button class="btn btn-secondary me-1" type="reset">
            <i class="fas fa-undo"></i> Reset
        </button>
        <button class="btn btn-primary" type="submit">
            <i class="fas fa-save"></i> Simpan
        </button>
    </div>
    </form>
    </div>
    </div>
    </div> --}}

    <div class="modal fade" id="tableKategori" data-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Data Merek</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <button type="button" data-toggle="modal" data-target="#modal-merek"
                        class="btn btn-primary btn-sm mb-2" data-dismiss="modal">
                        Tambah
                    </button>
                    <table id="example3" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th>Kode Merek</th>
                                <th>Merek</th>
                                <th>Model</th>
                                <th>Type</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($mereks as $merek)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $merek->kode_merek }}</td>
                                <td>{{ $merek->nama_merek }}</td>
                                <td>{{ $merek->modelken->nama_model }}</td>
                                <td>{{ $merek->tipe->nama_tipe }}</td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-primary btn-sm"
                                        onclick="getSelectedData('{{ $merek->id }}', '{{ $merek->nama_merek }}', '{{ $merek->modelken->nama_model }}', '{{ $merek->tipe->nama_tipe }}')">
                                        <i class="fas fa-plus"></i>
                                    </button>

                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-merek" data-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Merek</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('admin/mereks') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label" for="nama_merek">Nama Merek *</label>
                            <input class="form-control @error('nama_merek') is-invalid @enderror" id="nama_merek"
                                name="nama_merek" type="text" placeholder="masukan nama  merek"
                                value="{{ old('nama_merek') }}" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="modelken_id">Nama Model *</label>
                            <div class="mb-3 d-flex">
                                <select class="form-control" id="modelken_id" name="modelken_id"
                                    style="margin-right: 10px;">
                                    <option value="">- Pilih -</option>
                                    @foreach ($modelkens as $model)
                                    <option value="{{ $model->id }}"
                                        {{ old('modelken_id') == $model->id ? 'selected' : '' }}>
                                        {{ $model->nama_model }}
                                    </option>
                                    @endforeach
                                </select>
                                <button type="button" class="btn btn-primary btn-sm" id="btn-tambah-model">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="tipe_id">Nama Type *</label>
                            <div class="mb-3 d-flex">
                                <select class="form-control" id="tipe_id" name="tipe_id" style="margin-right: 10px;">
                                    <option value="">- Pilih -</option>
                                    @foreach ($tipes as $tipe)
                                    <option value="{{ $tipe->id }}" {{ old('tipe_id') == $tipe->id ? 'selected' : '' }}>
                                        {{ $tipe->nama_tipe }}
                                    </option>
                                    @endforeach
                                </select>
                                <!-- Tombol "Tambah Tipe" -->
                                <button type="button" class="btn btn-primary btn-sm" id="btn-tambah-tipe">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <button class="btn btn-secondary me-1" type="reset">
                                <i class="fas fa-undo"></i> Reset
                            </button>
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                        </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-tipe">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Type</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
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
                            <div class="card-footer text-end">
                                <button class="btn btn-secondary me-1" type="reset">
                                    <i class="fas fa-undo"></i> Reset
                                </button>
                                <button class="btn btn-primary" type="submit" id="simpanButton">
                                    <i class="fas fa-save"></i> Simpan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-model">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Model</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('admin/modelken') }}" method="POST" enctype="multipart/form-data"
                    autocomplete="off">
                    @csrf
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label" for="nama_model">Nama Model *</label>
                            <input class="form-control @error('nama_model') is-invalid @enderror" id="nama_model"
                                name="nama_model" type="text" placeholder="masukan nama model"
                                value="{{ old('nama_model') }}" />
                        </div>
                        <div class="card-footer text-end">
                            <button class="btn btn-secondary me-1" type="reset">
                                <i class="fas fa-undo"></i> Reset
                            </button>
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
    function showCategoryModal(selectedCategory) {
        $('#tableKategori').modal('show');
    }

    function getSelectedData(merek_id, namaMerek, namaModel, namaTipe) {
        // Set the values in the form fields
        document.getElementById('merek_id').value = merek_id;
        document.getElementById('nama_merek').value = namaMerek;
        document.getElementById('model').value = namaModel;
        document.getElementById('tipe').value = namaTipe;

        // Close the modal (if needed)
        $('#tableKategori').modal('hide');
    }

    document.getElementById('btn-tambah-tipe').addEventListener('click', function() {
        var modalTipe = new bootstrap.Modal(document.getElementById('modal-tipe'));
        modalTipe.show();
    });

    document.getElementById('btn-tambah-model').addEventListener('click', function() {
        var modalTipe = new bootstrap.Modal(document.getElementById('modal-model'));
        modalTipe.show();
    });

    function showCategoryModalmarketing(selectedCategory) {
        $('#tableMarketing').modal('show');
    }

    function getSelectedDatamarketing(marketing_id, kodeMarketing, namaMarketing, Telp, Umur, Alamat) {
        // Set the values in the form fields
        document.getElementById('marketing_id').value = marketing_id;
        document.getElementById('kode_marketing').value = kodeMarketing;
        document.getElementById('nama_marketing').value = namaMarketing;
        document.getElementById('telp_marketing').value = Telp;
        document.getElementById('umur_marketing').value = Umur;
        document.getElementById('alamat_marketing').value = Alamat;

        // Close the modal (if needed)
        $('#tableMarketing').modal('hide');
    }

    function showCategoryModalkaroseri(selectedCategory) {
        $('#tableKaroseri').modal('show');
    }

    function getSelectedDatakaroseri(karoseri_id, kodeKaroseri, namaKaroseri, tipeKendaraan, Panjang, Lebar, Tinggi,
        Sasis, CrosMember, freamSamping, Diafragma, Lantai, Dinding) {
        document.getElementById('karoseri_id').value = karoseri_id;
        document.getElementById('kode_type').value = kodeKaroseri;
        document.getElementById('nama_karoseri').value = namaKaroseri;
        document.getElementById('type_kendaraan').value = tipeKendaraan;
        document.getElementById('panjang').value = Panjang;
        document.getElementById('lebar').value = Lebar;
        document.getElementById('tinggi').value = Tinggi;
        document.getElementById('sasis').value = Sasis;
        document.getElementById('cros_member').value = CrosMember;
        document.getElementById('fream_samping').value = freamSamping;
        document.getElementById('diafragma').value = Diafragma;
        document.getElementById('lantai').value = Lantai;
        document.getElementById('dinding').value = Dinding;

        $('#tableKaroseri').modal('hide');
    }

    function showCategoryModalpelanggan(selectedCategory) {
        $('#tablePelanggan').modal('show');
    }

    function getSelectedDatapelanggan(pelanggan_id, kodePelanggan, namaPelanggan, Telp, Umur, Alamat) {
        // Set the values in the form fields
        document.getElementById('pelanggan_id').value = pelanggan_id;
        document.getElementById('kode_pelanggan').value = kodePelanggan;
        document.getElementById('nama_pelanggan').value = namaPelanggan;
        document.getElementById('telp').value = Telp;
        document.getElementById('umur').value = Umur;
        document.getElementById('alamat').value = Alamat;

        // Close the modal (if needed)
        $('#tablePelanggan').modal('hide');
    }
    </script>

    @endsection