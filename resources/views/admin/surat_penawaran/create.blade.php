@extends('layouts.app')

@section('title', 'Tambah Surat Penawaran Karoseri')

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
                    <h1 class="m-0">Surat Penawaran Karoseri</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/surat_penawaran') }}">Surat Penawaran
                                Karoseri</a>
                        </li>
                        <li class="breadcrumb-item active">Tambah</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <section class="content" style="display: none;" id="mainContentSection">
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
            @if (session('error_pelanggans') || session('error_pesanans'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5>
                        <i class="icon fas fa-ban"></i> Error!
                    </h5>
                    @if (session('error_pelanggans'))
                        @foreach (session('error_pelanggans') as $error)
                            - {{ $error }} <br>
                        @endforeach
                    @endif
                    @if (session('error_pesanans'))
                        @foreach (session('error_pesanans') as $error)
                            - {{ $error }} <br>
                        @endforeach
                    @endif
                </div>
            @endif
            {{-- <div class="card"> --}}
            {{-- <div class="card-header">
                    <h3 class="card-title">Tambah Pelanggan</h3>
                </div> --}}
            <!-- /.card-header -->
            <form action="{{ url('admin/surat_penawaran') }}" method="POST" enctype="multipart/form-data"
                autocomplete="off">
                @csrf
                <div class="card">
                    <div></div>
                    {{-- <div class="card-header">
                        <h3 class="card-title">Tambah Pelanggan</h3>
                    </div> --}}
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label" for="kategori">Kategori *</label>
                            <select class="form-control" id="kategori" name="kategori">
                                <option value="">- Pilih -</option>
                                <option value="PPN" {{ old('kategori') == 'PPN' ? 'selected' : null }}>
                                    PPN
                                </option>
                                <option value="NON PPN" {{ old('kategori') == 'NON PPN' ? 'selected' : null }}>
                                    NON PPN
                                </option>
                            </select>
                        </div>
                        <div class="form-group" id="no_npwp_group">
                            <label for="no_npwp">No NPWP</label>
                            <input type="text" class="form-control" id="no_npwp" name="no_npwp"
                                placeholder="Masukkan no npwp" value="{{ old('no_npwp') }}">
                        </div>
                        <div class="form-group" id="foto_npwp_group">
                            <label for="gambar_npwp">Foto NPWP</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="gambar_npwp" name="gambar_npwp"
                                    accept="image/*">
                                <label class="custom-file-label" for="gambar_npwp">Masukkan foto npwp</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-primary btn-sm" type="button"
                                onclick="showCategoryModalpelanggan(this.value)">
                                <i class="fas fa-plus mr-2"></i> Pilih Pelanggan
                            </button>
                        </div>
                        <label class="form-label" for="nama_pelanggan">Nama Pelanggan *</label>
                        <div class="mb-2 d-flex">
                            <input class="form-control @error('nama_pelanggan') is-invalid @enderror" id="nama_pelanggan"
                                name="nama_pelanggan" type="text" placeholder=" " value="{{ old('nama_pelanggan') }}"
                                readonly style="margin-right: 10px;" />
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                data-target="#modal-pelanggan">
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
                            <input type="text" class="form-control" id="kode_pelanggan" name="kode_pelanggan"
                                readonly placeholder="" value="{{ old('kode_pelanggan') }}">
                        </div>
                        {{-- <div class="form-group">
                            <label for="umur">Umur</label>
                            <input type="text" class="form-control" id="umur" name="umur" placeholder="" readonly
                                value="{{ old('umur') }}">
                        </div> --}}
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea type="text" class="form-control" id="alamat" name="alamat" readonly placeholder="">{{ old('alamat') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="telp">No. Telepon</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">+62</span>
                                </div>
                                <input type="text" id="telp" name="telp" class="form-control" readonly
                                    placeholder="" value="{{ old('telp') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tambah Karoseri</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="mb-3 mt-4">
                            <button class="btn btn-primary btn-sm" type="button"
                                onclick="showCategoryModalkaroseri(this.value)">
                                <i class="fas fa-plus mr-2"></i> Pilih Bentuk Karoseri
                            </button>
                        </div>

                        <label class="form-label" for="kode_type">Kode Karoseri *</label>
                        <div class="mb-2 d-flex">
                            <input class="form-control @error('kode_type') is-invalid @enderror" id="kode_type"
                                name="kode_type" type="text" placeholder=" " value="{{ old('kode_type') }}" readonly
                                style="margin-right: 10px;" />
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                data-target="#modal-karoseri">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                        <div class="form-group">
                            <label for="nama_karoseri">Bentuk Karoseri</label>
                            <input type="text" class="form-control" id="nama_karoseri" name="nama_karoseri" readonly
                                placeholder="" value="{{ old('nama_karoseri') }}">
                        </div>
                        <div class="form-group"hidden>
                            <label for="karoseri_id">Id Karoseri</label>
                            <input type="text" class="form-control" id="karoseri_id" name="typekaroseri_id"
                                placeholder="" value="{{ old('typekaroseri_id') }}">
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tambah Merek</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="mb-3" hidden>
                            <label class="form-label" for="merek_id">Merek_id *</label>
                            <input class="form-control @error('merek_id') is-invalid @enderror" id="merek_id"
                                name="merek_id" readonly type="text" placeholder="" value="{{ old('merek_id') }}" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="nama_merek">Merek *</label>
                            <input class="form-control @error('nama_merek') is-invalid @enderror" id="nama_merek"
                                name="nama_merek" readonly type="text" placeholder=""
                                value="{{ old('nama_merek') }}" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="tipe">Type *</label>
                            <input class="form-control @error('tipe') is-invalid @enderror" id="tipe" name="tipe"
                                readonly type="text" placeholder="" value="{{ old('tipe') }}" />
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Dimensi</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="form-group">
                            <label for="panjang">Panjang</label>
                            <input type="text" class="form-control" id="panjang" name="panjang" readonly
                                placeholder="" value="{{ old('panjang') }}">
                        </div>
                        <div class="form-group">
                            <label for="lebar">Lebar</label>
                            <input type="text" class="form-control" id="lebar" name="lebar" readonly
                                placeholder="" value="{{ old('lebar') }}">
                        </div>
                        <div class="form-group">
                            <label for="tinggi">Tinggi</label>
                            <input type="text" class="form-control" id="tinggi" name="tinggi" readonly
                                placeholder="" value="{{ old('tinggi') }}">
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Spesifikasi</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="form-group">
                            <textarea type="text" class="form-control" id="spesifikasi" readonly name="spesifikasi" placeholder="">{{ old('typekaroseri_id') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="aksesoris">Aksesoris</label>
                            <input type="text" class="form-control" readonly name="aksesoris"
                                value="{{ old('aksesoris') }}" id="aksesoris" placeholder="">
                        </div>
                    </div>
                </div>
                <div class="card">
                    <!-- /.card-header -->

                    <div class="card-header">
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <label for="aksesoris">Harga</label>
                        <input type="text" class="form-control" id="harga" name="harga" placeholder=""
                            value="{{ old('harga') }}" oninput="formatRupiahform(this)"
                            onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                    </div>

                    <div class="card-body">
                        <div class="form-group">
                            <label class="form-label" for="jumlah_unit">
                                Jumlah Unit</label>
                            <select class="form-control" id="jumlah_unit" name="jumlah_unit">
                                <option value="">- Pilih -</option>
                                <option value="1" {{ old('jumlah_unit') == '1' ? 'selected' : null }}>
                                    1 Unit</option>
                                <option value="2" {{ old('jumlah_unit') == '2' ? 'selected' : null }}>
                                    2 Unit</option>
                                <option value="3" {{ old('jumlah_unit') == '3' ? 'selected' : null }}>
                                    3 Unit</option>
                                <option value="4" {{ old('jumlah_unit') == '4' ? 'selected' : null }}>
                                    4 Unit</option>
                                <option value="5" {{ old('jumlah_unit') == '5' ? 'selected' : null }}>
                                    5 Unit</option>
                                <option value="6" {{ old('jumlah_unit') == '6' ? 'selected' : null }}>
                                    6 Unit</option>
                                <option value="7" {{ old('jumlah_unit') == '7' ? 'selected' : null }}>
                                    7 Unit</option>
                                <option value="8" {{ old('jumlah_unit') == '8' ? 'selected' : null }}>
                                    8 Unit</option>
                                <option value="9" {{ old('jumlah_unit') == '9' ? 'selected' : null }}>
                                    9 Unit</option>
                                <option value="10" {{ old('jumlah_unit') == '10' ? 'selected' : null }}>
                                    10 Unit</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-footer text-right mt-3">
                        <button type="reset" class="btn btn-secondary" id="btnReset">Reset</button>
                        <button type="submit" class="btn btn-primary" id="btnSimpan">Simpan</button>
                        <div id="loading" style="display: none;">
                            <i class="fas fa-spinner fa-spin"></i> Sedang Menyimpan...
                        </div>
                    </div>
                </div>
            </form>
            {{-- </div> --}}
        </div>

    </section>

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
                                                onclick="getSelectedDatapelanggan('{{ $pelanggan->id }}', '{{ $pelanggan->kode_pelanggan }}', '{{ $pelanggan->nama_pelanggan }}', '{{ $pelanggan->telp }}', '{{ $pelanggan->alamat }}')">
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
                        {{-- <div class="form-group">
                            <label for="umur">Umur</label>
                            <input type="text" class="form-control" id="umur" name="umur"
                                placeholder="Masukan umur" value="{{ old('umur') }}">
                        </div> --}}
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea type="text" class="form-control" id="alamat" name="alamat" placeholder="Masukan alamat">{{ old('alamat') }}</textarea>
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
                        {{-- <div class="form-group mb-3">
                            <label for="email">Email</label>
                            <input type="text" class="form-control" id="email" name="email"
                                placeholder="Masukan email" value="{{ old('email') }}">
                        </div> --}}
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
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Tambah Karoseri</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="form-group">
                                <label for="nama_karoseri">Bentuk Karoseri</label>
                                <input type="text" class="form-control" id="nama_karoseri" name="nama_karoseri"
                                    placeholder="masukkan bentuk karoseri" value="{{ old('nama_karoseri') }}">
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Dimensi</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="form-group">
                                <label for="panjang">Panjang</label>
                                <input type="text" class="form-control" id="panjang" name="panjang"
                                    placeholder="masukkan panjang" value="{{ old('panjang') }}">
                            </div>
                            <div class="form-group">
                                <label for="lebar">Lebar</label>
                                <input type="text" class="form-control" id="lebar" name="lebar"
                                    placeholder="masukkan lebar" value="{{ old('lebar') }}">
                            </div>
                            <div class="form-group">
                                <label for="tinggi">Tinggi</label>
                                <input type="text" class="form-control" id="tinggi" name="tinggi"
                                    placeholder="masukkan tinggi" value="{{ old('tinggi') }}">
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Tambah Spesifikasi</h3>
                            <div class="float-right">
                                <button type="button" class="btn btn-primary btn-sm" onclick="addPesanan()">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Spesifikasi</th>
                                    </tr>
                                </thead>
                                <tbody id="tabel-pembelian">
                                    <tr id="pembelian-0">
                                        <td style="width: 70px" class="text-center" id="urutan">1</td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="nama-0"
                                                    name="nama[]">
                                            </div>
                                        </td>
                                        <td style="width: 70px">
                                            <button type="button" class="btn btn-danger" onclick="removeBan(0)">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="aksesoris">Aksesoris</label>
                                    <input type="text" class="form-control" id="aksesoris" name="aksesoris"
                                        placeholder="masukkan aksesoris" value="{{ old('aksesoris') }}">
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
                                    <th>Bentuk Karoseri</th>
                                    <th>Merek</th>
                                    <th>Type</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($typekaroseris as $typekaroseri)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $typekaroseri->kode_type }}</td>
                                        <td>{{ $typekaroseri->nama_karoseri }}</td>
                                        <td>
                                            @if ($typekaroseri->merek)
                                                {{ $typekaroseri->merek->nama_merek }}
                                            @else
                                                tidak ada
                                            @endif
                                        </td>
                                        <td>
                                            @if ($typekaroseri->merek)
                                                {{ $typekaroseri->merek->tipe->nama_tipe }}
                                            @else
                                                tidak ada
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-primary btn-sm"
                                                onclick="getSelectedDatakaroseri('{{ $typekaroseri->id }}', '{{ $typekaroseri->kode_type }}', '{{ $typekaroseri->nama_karoseri }}', '{{ $typekaroseri->merek_id }}', '{{ $typekaroseri->nama_merek }}', '{{ $typekaroseri->tipe }}', '{{ $typekaroseri->panjang }}', '{{ $typekaroseri->lebar }}', '{{ $typekaroseri->tinggi }}', '{{ implode(', ', $typekaroseri->spesifikasi->pluck('nama')->toArray()) }}', '{{ $typekaroseri->aksesoris }}', '{{ $typekaroseri->harga }}')">
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
                            <input type="text" class="form-control" id="umur" name="umur"
                                placeholder="Masukan umur" value="{{ old('umur') }}">
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea type="text" class="form-control" id="alamat" name="alamat" placeholder="Masukan alamat">{{ old('alamat') }}</textarea>
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
                            <input type="text" class="form-control" id="harga" name="harga"
                                placeholder="Masukan harga" value="{{ old('harga') }}">
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
                                    <td>{{ $merek->tipe->nama_tipe }}</td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-primary btn-sm"
                                            onclick="getSelectedData('{{ $merek->id }}', '{{ $merek->nama_merek }}', '{{ $merek->tipe->nama_tipe }}')">
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
                <form action="{{ url('admin/mereks') }}" method="POST" enctype="multipart/form-data"
                    autocomplete="off">
                    @csrf
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label" for="nama_merek">Nama Merek *</label>
                            <input class="form-control @error('nama_merek') is-invalid @enderror" id="nama_merek"
                                name="nama_merek" type="text" placeholder="masukan nama  merek"
                                value="{{ old('nama_merek') }}" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="tipe_id">Nama Type *</label>
                            <div class="mb-3 d-flex">
                                <select class="form-control" id="tipe_id" name="tipe_id" style="margin-right: 10px;">
                                    <option value="">- Pilih -</option>
                                    @foreach ($tipes as $tipe)
                                        <option value="{{ $tipe->id }}"
                                            {{ old('tipe_id') == $tipe->id ? 'selected' : '' }}>
                                            {{ $tipe->nama_tipe }}
                                        </option>
                                    @endforeach
                                </select>
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
                <form action="{{ url('admin/tipe') }}" method="POST" enctype="multipart/form-data"
                    autocomplete="off">
                    @csrf
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label" for="nama_tipe">Nama Type *</label>
                            <input class="form-control @error('nama_tipe') is-invalid @enderror" id="nama_tipe"
                                name="nama_tipe" type="text" placeholder="masukan nama type"
                                value="{{ old('nama_tipe') }}" />
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

        function getSelectedData(merek_id, namaMerek, namaType) {
            // Set the values in the form fields
            document.getElementById('merek_id').value = merek_id;
            document.getElementById('nama_merek').value = namaMerek;
            document.getElementById('tipe').value = namaType;
            // Close the modal (if needed)
            $('#tableKategori').modal('hide');
        }

        document.getElementById('btn-tambah-tipe').addEventListener('click', function() {
            var modalTipe = new bootstrap.Modal(document.getElementById('modal-tipe'));
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

        function getSelectedDatakaroseri(karoseri_id, kodeKaroseri, namaKaroseri, MerekId, NamaMerek, Tipe, Panjang, Lebar,
            Tinggi, Spesifikasi,
            Aksesoris, Harga) {
            document.getElementById('karoseri_id').value = karoseri_id;
            document.getElementById('kode_type').value = kodeKaroseri;
            document.getElementById('nama_karoseri').value = namaKaroseri;
            document.getElementById('merek_id').value = MerekId;
            document.getElementById('nama_merek').value = NamaMerek;
            document.getElementById('tipe').value = Tipe;
            document.getElementById('panjang').value = Panjang;
            document.getElementById('lebar').value = Lebar;
            document.getElementById('tinggi').value = Tinggi;
            document.getElementById('spesifikasi').value = Spesifikasi;
            document.getElementById('aksesoris').value = Aksesoris;
            var formattedNominals = parseFloat(Harga).toLocaleString('id-ID');
            document.getElementById('harga').value = formattedNominals;
            $('#tableKaroseri').modal('hide');
        }

        function showCategoryModalpelanggan(selectedCategory) {
            $('#tablePelanggan').modal('show');
        }

        function getSelectedDatapelanggan(pelanggan_id, kodePelanggan, namaPelanggan, Telp, Alamat) {
            // Set the values in the form fields
            document.getElementById('pelanggan_id').value = pelanggan_id;
            document.getElementById('kode_pelanggan').value = kodePelanggan;
            document.getElementById('nama_pelanggan').value = namaPelanggan;
            document.getElementById('telp').value = Telp;
            // document.getElementById('umur').value = Umur;
            document.getElementById('alamat').value = Alamat;

            // Close the modal (if needed)
            $('#tablePelanggan').modal('hide');
        }

        var data_pembelian = @json(session('data_pembelians'));
        var jumlah_ban = 1;

        if (data_pembelian != null) {
            jumlah_ban = data_pembelian.length;
            $('#tabel-pembelian').empty();
            var urutan = 0;
            $.each(data_pembelian, function(key, value) {
                urutan = urutan + 1;
                itemPembelian(urutan, key, value);
            });
        }

        function addPesanan() {
            jumlah_ban = jumlah_ban + 1;

            if (jumlah_ban === 1) {
                $('#tabel-pembelian').empty();
            }

            itemPembelian(jumlah_ban, jumlah_ban - 1);
        }

        function removeBan(params) {
            jumlah_ban = jumlah_ban - 1;

            console.log(jumlah_ban);

            var tabel_pesanan = document.getElementById('tabel-pembelian');
            var pembelian = document.getElementById('pembelian-' + params);

            tabel_pesanan.removeChild(pembelian);

            if (jumlah_ban === 0) {
                var item_pembelian = '<tr>';
                item_pembelian += '<td class="text-center" colspan="5">- Spesifikasi belum ditambahkan -</td>';
                item_pembelian += '</tr>';
                $('#tabel-pembelian').html(item_pembelian);
            } else {
                var urutan = document.querySelectorAll('#urutan');
                for (let i = 0; i < urutan.length; i++) {
                    urutan[i].innerText = i + 1;
                }
            }
        }



        function itemPembelian(urutan, key, value = null) {
            var nama = '';

            if (value !== null) {
                nama = value.nama;
            }

            console.log(nama);
            // urutan 
            var item_pembelian = '<tr id="pembelian-' + urutan + '">';
            item_pembelian += '<td style="width: 70px" class="text-center" id="urutan">' + urutan + '</td>';
            item_pembelian += '<td>';

            // nama 
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" id="nama-' + key +
                '" name="nama[]" value="' +
                nama +
                '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';
            item_pembelian += '<td style="width: 70px">';
            item_pembelian += '<button type="button" class="btn btn-danger" onclick="removeBan(' + urutan + ')">';
            item_pembelian += '<i class="fas fa-trash"></i>';
            item_pembelian += '</button>';
            item_pembelian += '</td>';
            item_pembelian += '</tr>';

            $('#tabel-pembelian').append(item_pembelian);

            if (value !== null) {
                $('#nama-' + key).val(value.nama);
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            const kategoriSelect = document.getElementById("kategori");
            const fotoNpwpGroup = document.getElementById("foto_npwp_group");
            const noNPWPgroup = document.getElementById("no_npwp_group");

            // Initial state
            toggleFotoNpwpGroup();

            kategoriSelect.addEventListener("change", function() {
                toggleFotoNpwpGroup();
            });

            function toggleFotoNpwpGroup() {
                const selectedOption = kategoriSelect.value;

                if (selectedOption === "PPN") {
                    fotoNpwpGroup.style.display = "block";
                    noNPWPgroup.style.display = "block";
                } else {
                    fotoNpwpGroup.style.display = "none";
                    noNPWPgroup.style.display = "none";
                }
            }
        });
    </script>

    <script>
        function formatRupiahform(input) {
            // Hapus karakter selain angka
            var value = input.value.replace(/\D/g, "");

            // Format angka dengan menambahkan titik sebagai pemisah ribuan
            value = new Intl.NumberFormat('id-ID').format(value);

            // Tampilkan nilai yang sudah diformat ke dalam input
            input.value = value;
        }
    </script>

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

    <script>
        function formatRupiahform(input) {
            // Hapus karakter selain angka
            var value = input.value.replace(/\D/g, "");

            // Format angka dengan menambahkan titik sebagai pemisah ribuan
            value = new Intl.NumberFormat('id-ID').format(value);

            // Tampilkan nilai yang sudah diformat ke dalam input
            input.value = value;
        }
    </script>
@endsection
