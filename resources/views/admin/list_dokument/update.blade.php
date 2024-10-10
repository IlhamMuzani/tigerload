@extends('layouts.app')

@section('title', 'Tambah Dokumen Project')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dokumen Project</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/dokumen_project') }}">Dokumen Project</a></li>
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
            <form action="{{ url('admin/list_dokument', $inquery->id) }}" method="POST" enctype="multipart/form-data"
                autocomplete="off">
                @method('put')
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tambah Dokumen Project</h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 mt-4">
                            <button class="btn btn-primary btn-sm" type="button"
                                onclick="showCategoryModalsuratpenawaran(this.value)">
                                <i class="fas fa-plus mr-2"></i> Pilih SPK
                            </button>
                        </div>
                        @if (isset($inquery->perintah_kerja))
                            <div hidden class="mb-3">
                                <label class="form-label" for="perintah_kerja_id">Surat Perintah Kerja Id</label>
                                <input class="form-control @error('perintah_kerja_id') is-invalid @enderror"
                                    id="perintah_kerja_id" name="perintah_kerja_id" type="text" placeholder=" "
                                    value="{{ old('perintah_kerja_id', $inquery->perintah_kerja->id) }}" readonly />
                            </div>
                            <div hidden class="mb-3">
                                <label class="form-label" for="perintah_kerja_id">Surat Perintah Kerja Id</label>
                                <input class="form-control @error('perintah_kerja_id') is-invalid @enderror"
                                    id="perintah_kerja_id" name="perintah_kerja_id" type="text" placeholder=" "
                                    value="{{ old('perintah_kerja_id', $inquery->perintah_kerja->id) }}" readonly />
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="kode_spk">Kode SPK</label>
                                <input class="form-control @error('kode_spk') is-invalid @enderror" id="kode_spk"
                                    name="kode_spk" type="text" placeholder=" "
                                    value="{{ old('kode_spk', $inquery->perintah_kerja->kode_perintah) }}" readonly />
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="kategori">Kategori</label>
                                <input class="form-control @error('kategori') is-invalid @enderror" id="kategori"
                                    name="kategori" type="text" placeholder=" "
                                    value="{{ old('kategori', $inquery->perintah_kerja->kategori) }}" readonly />
                            </div>
                            <div>
                                <div class="form-group" id="no_npwp_group">
                                    <label for="no_npwp">No NPWP</label>
                                    <input type="text" readonly class="form-control" id="no_npwp" name="no_npwp"
                                        placeholder="" value="{{ old('no_npwp', $inquery->perintah_kerja->no_npwp) }}">
                                </div>
                            </div>
                            <label class="form-label" for="nama_pelanggan">Nama Pelanggan</label>
                            <div class="mb-2 d-flex">
                                <input class="form-control @error('nama_pelanggan') is-invalid @enderror"
                                    id="nama_pelanggan" name="nama_pelanggan" type="text" placeholder=""
                                    value="{{ old('nama_pelanggan', $inquery->perintah_kerja->pelanggan->nama_pelanggan) }}"
                                    readonly />
                            </div>
                            <div class="form-group" hidden>
                                <label for="pelanggan_id">Id Pelanggan</label>
                                <input type="text" class="form-control" id="pelanggan_id" name="pelanggan_id"
                                    placeholder=""
                                    value="{{ old('pelanggan_id', $inquery->perintah_kerja->pelanggan->id) }}">
                            </div>
                            <div class="form-group">
                                <label for="kode_pelanggan">Kode Pelanggan</label>
                                <input type="text" class="form-control" id="kode_pelanggan" name="kode_pelanggan"
                                    readonly placeholder=""
                                    value="{{ old('kode_pelanggan', $inquery->perintah_kerja->pelanggan->kode_pelanggan) }}">
                            </div>
                            {{-- <div class="form-group">
                            <label for="umur">Umur</label>
                            <input type="text" class="form-control" id="umur" name="umur" placeholder="" readonly
                                value="{{ old('umur') }}">
                        </div> --}}
                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <textarea type="text" class="form-control" id="alamat" name="alamat" readonly placeholder="">{{ old('alamat', $inquery->perintah_kerja->pelanggan->alamat) }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="telp">No. Telepon</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">+62</span>
                                    </div>
                                    <input type="text" id="telp" name="telp" class="form-control" readonly
                                        placeholder=""
                                        value="{{ old('telp', $inquery->perintah_kerja->pelanggan->telp) }}">
                                </div>
                            </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Kendaraan</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div hidden class="mb-3">
                            <label class="form-label" for="merek_id">Merek_id</label>
                            <input class="form-control @error('merek_id') is-invalid @enderror" id="merek_id"
                                name="merek_id" readonly type="text" placeholder=""
                                value="{{ old('merek_id', $inquery->perintah_kerja->typekaroseri->merek->id) }}" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="nama_merek">Merek</label>
                            <input class="form-control @error('nama_merek') is-invalid @enderror" id="nama_merek"
                                name="nama_merek" readonly type="text" placeholder=""
                                value="{{ old('nama_merek', $inquery->perintah_kerja->typekaroseri->merek->nama_merek) }}" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="tipe">Type</label>
                            <input class="form-control @error('tipe') is-invalid @enderror" id="tipe" name="tipe"
                                readonly type="text" placeholder=""
                                value="{{ old('tipe', $inquery->perintah_kerja->typekaroseri->merek->tipe->nama_tipe) }}" />
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Karoseri</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <label class="form-label" for="kode_type">Kode Karoseri</label>
                        <div class="mb-2 d-flex">
                            <input class="form-control @error('kode_type') is-invalid @enderror" id="kode_type"
                                name="kode_type" type="text" placeholder=" "
                                value="{{ old('kode_type', $inquery->perintah_kerja->typekaroseri->kode_type) }}"
                                readonly />
                        </div>
                        <div class="form-group">
                            <label for="nama_karoseri">Bentuk Karoseri</label>
                            <input type="text" class="form-control" id="nama_karoseri" name="nama_karoseri" readonly
                                placeholder=""
                                value="{{ old('nama_karoseri', $inquery->perintah_kerja->typekaroseri->nama_karoseri) }}">
                        </div>
                        <div class="form-group"hidden>
                            <label for="karoseri_id">Id Karoseri</label>
                            <input type="text" class="form-control" id="karoseri_id" name="typekaroseri_id"
                                placeholder=""
                                value="{{ old('typekaroseri_id', $inquery->perintah_kerja->typekaroseri->id) }}">
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
                                placeholder=""
                                value="{{ old('panjang', $inquery->perintah_kerja->typekaroseri->panjang) }}">
                        </div>
                        <div class="form-group">
                            <label for="lebar">Lebar</label>
                            <input type="text" class="form-control" id="lebar" name="lebar" readonly
                                placeholder="" value="{{ old('lebar', $inquery->perintah_kerja->typekaroseri->lebar) }}">
                        </div>
                        <div class="form-group">
                            <label for="tinggi">Tinggi</label>
                            <input type="text" class="form-control" id="tinggi" name="tinggi" readonly
                                placeholder=""
                                value="{{ old('tinggi', $inquery->perintah_kerja->typekaroseri->tinggi) }}">
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
                            <input type="text" class="form-control" id="spesifikasi" name="spesifikasi" readonly
                                placeholder=""
                                value=" {{ implode(', ', $inquery->typekaroseri->spesifikasi->pluck('nama')->toArray()) }}">
                        </div>
                        <div class="form-group">
                            <label for="aksesoris">Aksesoris</label>
                            <input type="text" class="form-control" readonly name="aksesoris"
                                value="{{ old('aksesoris', $inquery->typekaroseri->aksesoris) }}" id="aksesoris"
                                placeholder="">
                        </div>

                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Masukan keterangan">{{ old('keterangan', $inquery->keterangan) }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="no_serut">No Serut</label>
                            <input type="text" class="form-control" id="no_serut" name="no_serut" placeholder=""
                                value="{{ old('no_serut', $inquery->no_serut) }}">
                        </div>

                        <div class="form-group">
                            <label for="no_rangka">No Rangka</label>
                            <input type="text" class="form-control" id="no_rangka" name="no_rangka" placeholder=""
                                value="{{ old('no_rangka', $inquery->no_rangka) }}">
                        </div>

                        <div class="form-group">
                            <label for="no_mesin">No Mesin</label>
                            <input type="text" class="form-control" id="no_mesin" name="no_mesin" placeholder=""
                                value="{{ old('no_mesin', $inquery->no_mesin) }}">
                        </div>

                        <div class="form-group">
                            <label for="no_skrb">No Skrb</label>
                            <input type="text" class="form-control" id="no_skrb" name="no_skrb" placeholder=""
                                value="{{ old('no_skrb', $inquery->no_skrb) }}">
                        </div>

                        <div class="form-group">
                            <label for="tahun">Tahun</label>
                            <input type="text" class="form-control" id="tahun" name="tahun" placeholder=""
                                value="{{ old('tahun', $inquery->tahun) }}">
                        </div>
                    </div>
                </div>
                @endif
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Foto Dokumen</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="form-group mb-3">
                            @if ($inquery->gambar_depan == null)
                                <img class="mt-3" src="{{ asset('storage/uploads/gambaricon/imagenoimage.jpg') }}"
                                    alt="tigerload" height="180" width="200">
                            @else
                                <img class="mt-3" src="{{ asset('storage/uploads/' . $inquery->gambar_depan) }}"
                                    alt="tigerload" height="180" width="200">
                            @endif
                        </div>
                        <div class="form-group mb-3">
                            <label for="gambar_depan">Foto Depan</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="gambar_depan" name="gambar_depan"
                                    accept="image/*">
                                <label class="custom-file-label" for="gambar_depan">Masukkan foto</label>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            @if ($inquery->gambar_belakang == null)
                                <img class="mt-3" src="{{ asset('storage/uploads/gambaricon/imagenoimage.jpg') }}"
                                    alt="tigerload" height="180" width="200">
                            @else
                                <img class="mt-3" src="{{ asset('storage/uploads/' . $inquery->gambar_belakang) }}"
                                    alt="tigerload" height="180" width="200">
                            @endif
                        </div>
                        <div class="form-group mb-3">
                            <label for="gambar_belakang">Foto Belakang</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="gambar_belakang"
                                    name="gambar_belakang" accept="image/*">
                                <label class="custom-file-label" for="gambar_belakang">Masukkan foto</label>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            @if ($inquery->gambar_kanan == null)
                                <img class="mt-3" src="{{ asset('storage/uploads/gambaricon/imagenoimage.jpg') }}"
                                    alt="tigerload" height="180" width="200">
                            @else
                                <img class="mt-3" src="{{ asset('storage/uploads/' . $inquery->gambar_kanan) }}"
                                    alt="tigerload" height="180" width="200">
                            @endif
                        </div>
                        <div class="form-group mb-3">
                            <label for="gambar_kanan">Foto Kanan</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="gambar_kanan" name="gambar_kanan"
                                    accept="image/*">
                                <label class="custom-file-label" for="gambar_kanan">Masukkan foto</label>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            @if ($inquery->gambar_kiri == null)
                                <img class="mt-3" src="{{ asset('storage/uploads/gambaricon/imagenoimage.jpg') }}"
                                    alt="tigerload" height="180" width="200">
                            @else
                                <img class="mt-3" src="{{ asset('storage/uploads/' . $inquery->gambar_kiri) }}"
                                    alt="tigerload" height="180" width="200">
                            @endif
                        </div>
                        <div class="form-group mb-3">
                            <label for="gambar_kiri">Foto Kiri</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="gambar_kiri" name="gambar_kiri"
                                    accept="image/*">
                                <label class="custom-file-label" for="gambar_kiri">Masukkan foto</label>
                            </div>
                        </div>
                        {{-- <div class="form-group mb-3">
                            @if ($inquery->gambardepan_serongkanan == null)
                                <img class="mt-3" src="{{ asset('storage/uploads/gambaricon/imagenoimage.jpg') }}"
                                    alt="tigerload" height="180" width="200">
                            @else
                                <img class="mt-3"
                                    src="{{ asset('storage/uploads/' . $inquery->gambardepan_serongkanan) }}"
                                    alt="tigerload" height="180" width="200">
                            @endif
                        </div>
                        <div class="form-group mb-3">
                            <label for="gambardepan_serongkanan">Foto Depan Serong Kanan</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="gambardepan_serongkanan"
                                    name="gambardepan_serongkanan" accept="image/*">
                                <label class="custom-file-label" for="gambardepan_serongkanan">Masukkan foto</label>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            @if ($inquery->gambardepan_serongkiri == null)
                                <img class="mt-3" src="{{ asset('storage/uploads/gambaricon/imagenoimage.jpg') }}"
                                    alt="tigerload" height="180" width="200">
                            @else
                                <img class="mt-3"
                                    src="{{ asset('storage/uploads/' . $inquery->gambardepan_serongkiri) }}"
                                    alt="tigerload" height="180" width="200">
                            @endif
                        </div>
                        <div class="form-group mb-3">
                            <label for="gambardepan_serongkiri">Foto Depan Serong Kiri</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="gambardepan_serongkiri"
                                    name="gambardepan_serongkiri" accept="image/*">
                                <label class="custom-file-label" for="gambardepan_serongkiri">Masukkan foto</label>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            @if ($inquery->gambarbelakang_serongkanan == null)
                                <img class="mt-3" src="{{ asset('storage/uploads/gambaricon/imagenoimage.jpg') }}"
                                    alt="tigerload" height="180" width="200">
                            @else
                                <img class="mt-3"
                                    src="{{ asset('storage/uploads/' . $inquery->gambarbelakang_serongkanan) }}"
                                    alt="tigerload" height="180" width="200">
                            @endif
                        </div>
                        <div class="form-group mb-3">
                            <label for="gambarbelakang_serongkanan">Foto Belakang Serong Kanan</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="gambarbelakang_serongkanan"
                                    name="gambarbelakang_serongkanan" accept="image/*">
                                <label class="custom-file-label" for="gambarbelakang_serongkanan">Masukkan foto</label>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            @if ($inquery->gambarbelakang_serongkekiri == null)
                                <img class="mt-3" src="{{ asset('storage/uploads/gambaricon/imagenoimage.jpg') }}"
                                    alt="tigerload" height="180" width="200">
                            @else
                                <img class="mt-3"
                                    src="{{ asset('storage/uploads/' . $inquery->gambarbelakang_serongkekiri) }}"
                                    alt="tigerload" height="180" width="200">
                            @endif
                        </div>
                        <div class="form-group mb-3">
                            <label for="gambarbelakang_serongkekiri">Foto Belakang Serong Kiri</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="gambarbelakang_serongkekiri"
                                    name="gambarbelakang_serongkekiri" accept="image/*">
                                <label class="custom-file-label" for="gambarbelakang_serongkekiri">Masukkan foto</label>
                            </div>
                        </div> --}}
                        <div class="form-group mb-3">
                            @if ($inquery->gambar_faktur == null)
                                <img class="mt-3" src="{{ asset('storage/uploads/gambaricon/imagenoimage.jpg') }}"
                                    alt="tigerload" height="180" width="200">
                            @else
                                <img class="mt-3" src="{{ asset('storage/uploads/' . $inquery->gambar_faktur) }}"
                                    alt="tigerload" height="180" width="200">
                            @endif
                        </div>
                        <div class="form-group mb-3">
                            <label for="gambar_faktur">Foto Faktur</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="gambar_faktur" name="gambar_faktur"
                                    accept="image/*">
                                <label class="custom-file-label" for="gambar_faktur">Masukkan foto</label>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            @if ($inquery->gambar_serut == null)
                                <img class="mt-3" src="{{ asset('storage/uploads/gambaricon/imagenoimage.jpg') }}"
                                    alt="tigerload" height="180" width="200">
                            @else
                                <img class="mt-3" src="{{ asset('storage/uploads/' . $inquery->gambar_serut) }}"
                                    alt="tigerload" height="180" width="200">
                            @endif
                        </div>
                        <div class="form-group mb-3">
                            <label for="gambar_serut">Foto Serut</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="gambar_serut" name="gambar_serut"
                                    accept="image/*">
                                <label class="custom-file-label" for="gambar_serut">Masukkan foto</label>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            @if ($inquery->gambar_rancangbangun == null)
                                <img class="mt-3" src="{{ asset('storage/uploads/gambaricon/imagenoimage.jpg') }}"
                                    alt="tigerload" height="180" width="200">
                            @else
                                <img class="mt-3"
                                    src="{{ asset('storage/uploads/' . $inquery->gambar_rancangbangun) }}"
                                    alt="tigerload" height="180" width="200">
                            @endif
                        </div>
                        <div class="form-group mb-3">
                            <label for="gambar_rancangbangun">Foto Rancang Bangun</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="gambar_rancangbangun"
                                    name="gambar_rancangbangun" accept="image/*">
                                <label class="custom-file-label" for="gambar_rancangbangun">Masukkan foto</label>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            @if ($inquery->gambar_gesekannomesin == null)
                                <img class="mt-3" src="{{ asset('storage/uploads/gambaricon/imagenoimage.jpg') }}"
                                    alt="tigerload" height="180" width="200">
                            @else
                                <img class="mt-3"
                                    src="{{ asset('storage/uploads/' . $inquery->gambar_gesekannomesin) }}"
                                    alt="tigerload" height="180" width="200">
                            @endif
                        </div>
                        <div class="form-group mb-3">
                            <label for="gambar_gesekannomesin">Foto Gesekan Nomor Mesin Dan Rangka</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="gambar_gesekannomesin"
                                    name="gambar_gesekannomesin" accept="image/*">
                                <label class="custom-file-label" for="gambar_gesekannomesin">Masukkan foto</label>
                            </div>
                        </div>
                        {{-- <div class="form-group">
                            <label for="gambar_gesekanrangka">Foto gesekan nomor rangka</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="gambar_gesekanrangka"
                                    name="gambar_gesekanrangka" accept="image/*">
                                <label class="custom-file-label" for="gambar_gesekanrangka">Masukkan foto</label>
                            </div>
                        </div> --}}
                        <div class="form-group mb-3">
                            @if ($inquery->gambarberita_acara == null)
                                <img class="mt-3" src="{{ asset('storage/uploads/gambaricon/imagenoimage.jpg') }}"
                                    alt="tigerload" height="180" width="200">
                            @else
                                <img class="mt-3" src="{{ asset('storage/uploads/' . $inquery->gambarberita_acara) }}"
                                    alt="tigerload" height="180" width="200">
                            @endif
                        </div>
                        <div class="form-group mb-5">
                            <label for="gambarberita_acara">Foto Berita Acara</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="gambarberita_acara"
                                    name="gambarberita_acara" accept="image/*">
                                <label class="custom-file-label" for="gambarberita_acara">Masukkan foto</label>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="reset" class="btn btn-secondary" id="btnReset">Reset</button>
                        <button type="submit" class="btn btn-primary" id="btnSimpan">Simpan</button>
                        <div id="loading" style="display: none;">
                            <i class="fas fa-spinner fa-spin"></i> Sedang Menyimpan...
                        </div>
                    </div>
                </div>

            </form>
        </div>

        <div class="modal fade" id="tablepenawaran" data-backdrop="static">
            <div class="modal-dialog modal-xl"> <!-- Changed modal-lg to modal-xl -->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Data SPK</h4>
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
                                        <th>Kode SPK</th>
                                        <th>Kode Pelanggan</th>
                                        <th>Nama Pelanggan</th>
                                        <th>Kode Karoseri</th>
                                        <th>Bentuk Karoseri</th>
                                        <th>Merek</th>
                                        <th>Type</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($spks as $suratpenawaran)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $suratpenawaran->kode_perintah }}</td>
                                            <td>
                                                @if ($suratpenawaran->pelanggan)
                                                    {{ $suratpenawaran->pelanggan->kode_pelanggan }}
                                                @else
                                                    tidak ada
                                                @endif
                                            </td>
                                            <td>
                                                @if ($suratpenawaran->pelanggan)
                                                    {{ $suratpenawaran->pelanggan->nama_pelanggan }}
                                                @else
                                                    tidak ada
                                                @endif
                                            </td>
                                            <td>
                                                @if ($suratpenawaran->typekaroseri)
                                                    {{ $suratpenawaran->typekaroseri->kode_type }}
                                                @else
                                                    tidak ada
                                                @endif
                                            </td>
                                            <td>
                                                @if ($suratpenawaran->typekaroseri)
                                                    {{ $suratpenawaran->typekaroseri->nama_karoseri }}
                                                @else
                                                    tidak ada
                                                @endif
                                            </td>
                                            <td>
                                                @if ($suratpenawaran->typekaroseri->merek)
                                                    {{ $suratpenawaran->typekaroseri->merek->nama_merek }}
                                                @else
                                                    tidak ada
                                                @endif
                                            </td>
                                            <td>
                                                @if ($suratpenawaran->typekaroseri->merek)
                                                    {{ $suratpenawaran->typekaroseri->merek->tipe->nama_tipe }}
                                                @else
                                                    tidak ada
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    onclick="getSelectedDatapelanggan('{{ $suratpenawaran->id }}',
                                                '{{ $suratpenawaran->kode_perintah }}',
                                                '{{ $suratpenawaran->spk->kategori }}',
                                                '{{ $suratpenawaran->spk->no_npwp }}',
                                                '{{ $suratpenawaran->spk->pelanggan_id }}',
                                                '{{ $suratpenawaran->spk->kode_pelanggan }}',
                                                '{{ $suratpenawaran->spk->nama_pelanggan }}',
                                                '{{ $suratpenawaran->spk->telp }}',
                                                '{{ $suratpenawaran->spk->alamat }}',
                                                '{{ $suratpenawaran->spk->merek_id }}',
                                                '{{ $suratpenawaran->spk->nama_merek }}',
                                                '{{ $suratpenawaran->spk->tipe }}',
                                                '{{ $suratpenawaran->spk->typekaroseri_id }}',
                                                '{{ $suratpenawaran->spk->kode_type }}',
                                                '{{ $suratpenawaran->spk->nama_karoseri }}',
                                                '{{ $suratpenawaran->spk->panjang }}',
                                                '{{ $suratpenawaran->spk->lebar }}',
                                                '{{ $suratpenawaran->spk->tinggi }}',
                                                '{{ $suratpenawaran->spk->spesifikasi }}',
                                                '{{ $suratpenawaran->spk->aksesoris }}'                                                )">
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

    <script>
        function showCategoryModalsuratpenawaran(selectedCategory) {
            $('#tablepenawaran').modal('show');
        }

        function getSelectedDatapelanggan(Id, KodeSPk, Kategori, NoNpwp, pelanggan_id, kodePelanggan, namaPelanggan, Telp,
            Alamat,
            Merek_id,
            Nama_merek, Tipe, KodeKaroseri_id, KodeType, Namakaroseri, Panjang, Lebar, Tinggi, Spesifikasi, Aksesoris
        ) {
            // Set the values in the form fields
            document.getElementById('perintah_kerja_id').value = Id;
            document.getElementById('kode_spk').value = KodeSPk;
            document.getElementById('kategori').value = Kategori;
            document.getElementById('no_npwp').value = NoNpwp;
            document.getElementById('pelanggan_id').value = pelanggan_id;
            document.getElementById('kode_pelanggan').value = kodePelanggan;
            document.getElementById('nama_pelanggan').value = namaPelanggan;
            document.getElementById('telp').value = Telp;
            // document.getElementById('umur').value = Umur;
            document.getElementById('alamat').value = Alamat;
            document.getElementById('merek_id').value = Merek_id;
            document.getElementById('nama_merek').value = Nama_merek;
            document.getElementById('tipe').value = Tipe;
            document.getElementById('karoseri_id').value = KodeKaroseri_id;
            document.getElementById('kode_type').value = KodeType;
            document.getElementById('nama_karoseri').value = Namakaroseri;
            document.getElementById('panjang').value = Panjang;
            document.getElementById('lebar').value = Lebar;
            document.getElementById('tinggi').value = Tinggi;
            document.getElementById('spesifikasi').value = Spesifikasi;
            document.getElementById('aksesoris').value = Aksesoris;
            // Close the modal (if needed)
            $('#tablepenawaran').modal('hide');
        }
    </script>
@endsection
