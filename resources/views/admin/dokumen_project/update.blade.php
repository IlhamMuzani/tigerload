@extends('layouts.app')

@section('title', 'Perbarui Kendaraan')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Kendaraan</h1>
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
            @if (session('success'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5>
                        <i class="icon fas fa-check"></i> Gagal!
                    </h5>
                    {{ session('success') }}
                </div>
            @endif
            <form action="{{ url('admin/kendaraan/' . $kendaraan->id) }}" method="POST" enctype="multipart/form-data"
                autocomplete="off">
                @csrf
                @method('put')
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Perbarui Kendaraan</h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label" for="no_rangka">No. Rangka *</label>
                            <input class="form-control @error('no_rangka') is-invalid @enderror" id="no_rangka"
                                name="no_rangka" type="text" placeholder="masukan no rangka"
                                value="{{ old('no_rangka', $kendaraan->no_rangka) }}" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="no_mesin">No. Mesin *</label>
                            <input class="form-control @error('no_mesin') is-invalid @enderror" id="no_mesin"
                                name="no_mesin" type="text" placeholder="masukan no mesin"
                                value="{{ old('no_mesin', $kendaraan->no_mesin) }}" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="tahun">Tahun *</label>
                            <select class="form-control" id="tahun" name="tahun">
                                <option value="">- Pilih -</option>
                                <option value="2025" {{ old('tahun', $kendaraan->tahun) == '2025' ? 'selected' : null }}>
                                    2025</option>
                                <option value="2024" {{ old('tahun', $kendaraan->tahun) == '2024' ? 'selected' : null }}>
                                    2024</option>
                                <option value="2023" {{ old('tahun', $kendaraan->tahun) == '2023' ? 'selected' : null }}>
                                    2023</option>
                                <option value="2022" {{ old('tahun', $kendaraan->tahun) == '2022' ? 'selected' : null }}>
                                    2022</option>
                                <option value="2021" {{ old('tahun', $kendaraan->tahun) == '2021' ? 'selected' : null }}>
                                    2021</option>
                                <option value="2020" {{ old('tahun', $kendaraan->tahun) == '2020' ? 'selected' : null }}>
                                    2020</option>
                                <option value="2019" {{ old('tahun', $kendaraan->tahun) == '2019' ? 'selected' : null }}>
                                    2019</option>
                                <option value="2018" {{ old('tahun', $kendaraan->tahun) == '2018' ? 'selected' : null }}>
                                    2018</option>
                                <option value="2017" {{ old('tahun', $kendaraan->tahun) == '2017' ? 'selected' : null }}>
                                    2017</option>
                                <option value="2016" {{ old('tahun', $kendaraan->tahun) == '2016' ? 'selected' : null }}>
                                    2016</option>
                                <option value="2015" {{ old('tahun', $kendaraan->tahun) == '2015' ? 'selected' : null }}>
                                    2015</option>
                                <option value="2014" {{ old('tahun', $kendaraan->tahun) == '2014' ? 'selected' : null }}>
                                    2014</option>
                                <option value="2013" {{ old('tahun', $kendaraan->tahun) == '2013' ? 'selected' : null }}>
                                    2013</option>
                                <option value="2012" {{ old('tahun', $kendaraan->tahun) == '2012' ? 'selected' : null }}>
                                    2012</option>
                                <option value="2011" {{ old('tahun', $kendaraan->tahun) == '2011' ? 'selected' : null }}>
                                    2011</option>
                                <option value="2010" {{ old('tahun', $kendaraan->tahun) == '2010' ? 'selected' : null }}>
                                    2010</option>
                                <option value="2009" {{ old('tahun', $kendaraan->tahun) == '2009' ? 'selected' : null }}>
                                    2009</option>
                                <option value="2008" {{ old('tahun', $kendaraan->tahun) == '2008' ? 'selected' : null }}>
                                    2008</option>
                                <option value="2007" {{ old('tahun', $kendaraan->tahun) == '2007' ? 'selected' : null }}>
                                    2007</option>
                                <option value="2006" {{ old('tahun', $kendaraan->tahun) == '2006' ? 'selected' : null }}>
                                    2006</option>
                                <option value="2005" {{ old('tahun', $kendaraan->tahun) == '2005' ? 'selected' : null }}>
                                    2005</option>
                                <option value="2004" {{ old('tahun', $kendaraan->tahun) == '2004' ? 'selected' : null }}>
                                    2004</option>
                                <option value="2003" {{ old('tahun', $kendaraan->tahun) == '2003' ? 'selected' : null }}>
                                    2003</option>
                                <option value="2002" {{ old('tahun', $kendaraan->tahun) == '2002' ? 'selected' : null }}>
                                    2002</option>
                                <option value="2001" {{ old('tahun', $kendaraan->tahun) == '2001' ? 'selected' : null }}>
                                    2001</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="warna">Warna *</label>
                            <select class="form-control" id="warna" name="warna">
                                <option value="">- Pilih -</option>
                                <option value="Hitam"
                                    {{ old('warna', $kendaraan->warna) == 'Hitam' ? 'selected' : null }}>
                                    Hitam</option>
                                <option value="Putih"
                                    {{ old('warna', $kendaraan->warna) == 'Putih' ? 'selected' : null }}>
                                    Putih</option>
                                <option value="Cokelat"
                                    {{ old('warna', $kendaraan->warna) == 'Cokelat' ? 'selected' : null }}>
                                    Cokelat</option>
                                <option value="Hijau"
                                    {{ old('warna', $kendaraan->warna) == 'Hijau' ? 'selected' : null }}>
                                    Hijau</option>
                                <option value="Orange"
                                    {{ old('warna', $kendaraan->warna) == 'Orange' ? 'selected' : null }}>
                                    Orange</option>
                                <option value="Merah"
                                    {{ old('warna', $kendaraan->warna) == 'Merah' ? 'selected' : null }}>
                                    Merah</option>
                                <option value="Ungu" {{ old('warna', $kendaraan->warna) == 'Ungu' ? 'selected' : null }}>
                                    Ungu</option>
                                <option value="Kuning"
                                    {{ old('warna', $kendaraan->warna) == 'Kuning' ? 'selected' : null }}>
                                    Kuning</option>
                                <option value="Biru" {{ old('warna', $kendaraan->warna) == 'Biru' ? 'selected' : null }}>
                                    Biru</option>
                                <option value="Silver"
                                    {{ old('warna', $kendaraan->warna) == 'Silver' ? 'selected' : null }}>
                                    Silver</option>
                                <option value="Hitam"
                                    {{ old('warna', $kendaraan->warna) == 'Hitam' ? 'selected' : null }}>
                                    Hitam</option>
                                <option value="Putih"
                                    {{ old('warna', $kendaraan->warna) == 'Putih' ? 'selected' : null }}>
                                    Putih</option>
                                <option value="Abu-abu"
                                    {{ old('warna', $kendaraan->warna) == 'Abu-abu' ? 'selected' : null }}>
                                    Abu-abu</option>
                            </select>
                        </div>
                        <div class="mb-3 mt-4">
                            <button class="btn btn-primary btn-sm" type="button"
                                onclick="showCategoryModal(this.value)">
                                Pilih Merek
                            </button>
                        </div>
                        <div class="mb-3" hidden>
                            <label class="form-label" for="merek_id">Merek_id *</label>
                            <input class="form-control @error('merek_id') is-invalid @enderror" id="merek_id"
                                name="merek_id" readonly type="text" placeholder=""
                                value="{{ old('merek_id', $kendaraan->merek->id) }}" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="nama_merek">Merek *</label>
                            <input class="form-control @error('nama_merek') is-invalid @enderror" id="nama_merek"
                                name="nama_merek" readonly type="text" placeholder=""
                                value="{{ old('nama_merek', $kendaraan->merek->nama_merek) }}" />
                        </div>
                        {{-- <div class="mb-3">
                            <label class="form-label" for="model">Model *</label>
                            <input class="form-control @error('model') is-invalid @enderror" id="model"
                                name="model" readonly type="text" placeholder=""
                                value="{{ old('model', $kendaraan->merek->modelken->nama_model) }}" />
                        </div> --}}
                        <div class="mb-3">
                            <label class="form-label" for="tipe">Tipe *</label>
                            <input class="form-control @error('tipe') is-invalid @enderror" id="tipe" name="tipe"
                                readonly type="text" placeholder=""
                                value="{{ old('tipe', $kendaraan->merek->tipe->nama_tipe) }}" />
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="gambar_faktur">Foto Faktur</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="gambar_faktur" name="gambar_faktur"
                                    accept="image/*">
                                <label class="custom-file-label" for="gambar_faktur">Masukkan foto</label>
                            </div>
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
                            <label for="gambar_rancangbangun">Foto Rancang Bangun</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="gambar_rancangbangun"
                                    name="gambar_rancangbangun" accept="image/*">
                                <label class="custom-file-label" for="gambar_rancangbangun">Masukkan foto</label>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="gambar_gesekannomesin">Foto gesekan nomor mesin</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="gambar_gesekannomesin"
                                    name="gambar_gesekannomesin" accept="image/*">
                                <label class="custom-file-label" for="gambar_gesekannomesin">Masukkan foto</label>
                            </div>
                        </div>
                        <div class="form-group mb-5">
                            <label for="gambar_gesekannorangka">Foto gesekan nomor rangka</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="gambar_gesekannorangka"
                                    name="gambar_gesekannorangka" accept="image/*">
                                <label class="custom-file-label" for="gambar_gesekannorangka">Masukkan foto</label>
                            </div>
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
                            <label for="gambar_belakang">Foto Belakang</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="gambar_belakang"
                                    name="gambar_belakang" accept="image/*">
                                <label class="custom-file-label" for="gambar_belakang">Masukkan foto</label>
                            </div>
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
                            <label for="gambar_kiri">Foto Kiri</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="gambar_kiri" name="gambar_kiri"
                                    accept="image/*">
                                <label class="custom-file-label" for="gambar_kiri">Masukkan foto</label>
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
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Kode Merek</th>
                                    <th>Merek</th>
                                    {{-- <th>Model</th> --}}
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
                                        {{-- <td>{{ $merek->modelken->nama_model }}</td> --}}
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

        <div class="modal fade" id="modal-merek"data-backdrop="static">
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
                                    <button type="button" class="btn btn-primary" id="btn-tambah-model">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="tipe_id">Nama Type *</label>
                                <div class="mb-3 d-flex">
                                    <select class="form-control" id="tipe_id" name="tipe_id"
                                        style="margin-right: 10px;">
                                        <option value="">- Pilih -</option>
                                        @foreach ($tipes as $tipe)
                                            <option value="{{ $tipe->id }}"
                                                {{ old('tipe_id') == $tipe->id ? 'selected' : '' }}>
                                                {{ $tipe->nama_tipe }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <!-- Tombol "Tambah Tipe" -->
                                    <button type="button" class="btn btn-primary" id="btn-tambah-tipe">
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

            function getSelectedData(merek_id, namaMerek, namaTipe) {
                // Set the values in the form fields
                document.getElementById('merek_id').value = merek_id;
                document.getElementById('nama_merek').value = namaMerek;
                // document.getElementById('model').value = namaModel;
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
        </script>
    </section>
@endsection
