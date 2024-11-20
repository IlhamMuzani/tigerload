@extends('layouts.app')

@section('title', 'Tambah Surat Penerimaan Pembayaran')

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
                    <h1 class="m-0">Surat Penerimaan Pembayaran</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/penerimaan_pembayaran') }}">Surat Penerimaan
                                Pembayaran</a></li>
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
                        <i class="icon fas fa-check"></i> Berhasil!
                    </h5>
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error_pelanggans') || session('error_pesanans'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5>
                        <i class="icon fas fa-ban"></i> Gagal!
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
            <form action="{{ url('admin/penerimaan_pembayaran') }}" method="POST" enctype="multipart/form-data"
                autocomplete="off">
                @csrf
                <div class="card">
                    <div></div>
                    {{-- <div class="card-header">
                        <h3 class="card-title">Tambah Pelanggan</h3>
                    </div> --}}
                    <div class="card-body">
                        <div class="mb-3 mt-4">
                            <button class="btn btn-primary btn-sm" type="button"
                                onclick="showCategoryModalsuratpenawaran(this.value)">
                                <i class="fas fa-plus mr-2"></i> Pilih Surat Penawaran Karoseri
                            </button>
                        </div>
                        <div hidden class="mb-3">
                            <label class="form-label" for="surat_penawaran_id">Surat Penawaran Id</label>
                            <input class="form-control @error('surat_penawaran_id') is-invalid @enderror"
                                id="surat_penawaran_id" name="surat_penawaran_id" type="text" placeholder=" "
                                value="{{ old('surat_penawaran_id') }}" readonly />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="kategori">Kategori</label>
                            <input class="form-control @error('kategori') is-invalid @enderror" id="kategori"
                                name="kategori" type="text" placeholder=" " value="{{ old('kategori') }}" readonly />
                        </div>
                        <div>
                            <div class="form-group" id="no_npwp_group">
                                <label for="no_npwp">No NPWP</label>
                                <input type="text" readonly class="form-control" id="no_npwp" name="no_npwp"
                                    placeholder="" value="{{ old('no_npwp') }}">
                            </div>
                        </div>
                        <label class="form-label" for="nama_pelanggan">Nama Pelanggan</label>
                        <div class="mb-2 d-flex">
                            <input class="form-control @error('nama_pelanggan') is-invalid @enderror" id="nama_pelanggan"
                                name="nama_pelanggan" type="text" placeholder="" value="{{ old('nama_pelanggan') }}"
                                readonly />
                        </div>
                        <div class="form-group" hidden>
                            <label for="pelanggan_id">Id Pelanggan</label>
                            <input type="text" class="form-control" id="pelanggan_id" name="pelanggan_id" placeholder=""
                                value="{{ old('pelanggan_id') }}">
                        </div>
                        <div class="form-group">
                            <label for="kode_pelanggan">Kode Pelanggan</label>
                            <input type="text" class="form-control" id="kode_pelanggan" name="kode_pelanggan" readonly
                                placeholder="" value="{{ old('kode_pelanggan') }}">
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
                        <h3 class="card-title">Kendaraan</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div hidden class="mb-3">
                            <label class="form-label" for="merek_id">Merek_id</label>
                            <input class="form-control @error('merek_id') is-invalid @enderror" id="merek_id"
                                name="merek_id" readonly type="text" placeholder="" value="{{ old('merek_id') }}" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="nama_merek">Merek</label>
                            <input class="form-control @error('nama_merek') is-invalid @enderror" id="nama_merek"
                                name="nama_merek" readonly type="text" placeholder=""
                                value="{{ old('nama_merek') }}" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="tipe">Type</label>
                            <input class="form-control @error('tipe') is-invalid @enderror" id="tipe" name="tipe"
                                readonly type="text" placeholder="" value="{{ old('tipe') }}" />
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
                                name="kode_type" type="text" placeholder=" " value="{{ old('kode_type') }}"
                                readonly />
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
                        <div class="form-group">
                            <label for="nama_karoseri">Harga</label>
                            <!-- /.card-header -->
                            <input type="text" class="form-control" id="harga" readonly name="harga"
                                placeholder="" value="{{ old('harga') }}">
                        </div>

                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Masukan keterangan">{{ old('keterangan') }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Pembayaran</h3>
                    </div>

                    <div class="card-body">
                        <label>Tanggal pembayaran:</label>
                        <div class="input-group date" id="reservationdatetime">
                            <input type="date" id="tanggal_pembayaran" name="tanggal_pembayaran"
                                placeholder="d M Y sampai d M Y"
                                data-options='{"mode":"range","dateFormat":"d M Y","disableMobile":true}'
                                value="{{ old('tanggal_pembayaran') }}" class="form-control datetimepicker-input"
                                data-target="#reservationdatetime">
                        </div>
                    </div>
                    <div class="card-body">
                        <label class="form-label" for="kategoris">
                            Jenis Pembayaran</label>
                        <select class="form-control" id="kategoris" name="kategoris">
                            <option value="">- Pilih -</option>
                            <option value="Bilyet Giro" {{ old('kategoris') == 'Bilyet Giro' ? 'selected' : null }}>
                                Bilyet Giro BG / Cek</option>
                            <option value="Transfer" {{ old('kategoris') == 'Transfer' ? 'selected' : null }}>
                                Transfer</option>
                            <option value="Tunai" {{ old('kategoris') == 'Tunai' ? 'selected' : null }}>
                                Tunai</option>
                        </select>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <label for="nama_karoseri">Nominal</label>
                        <input type="text" class="form-control" id="nominal" name="nominal" placeholder=""
                            value="{{ old('nominal') }}" oninput="formatRupiahform(this)"
                            onkeypress="return event.charCode >= 48 && event.charCode <= 57">
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

    <div class="modal fade" id="tablepenawaran" data-backdrop="static">
        <div class="modal-dialog modal-xl"> <!-- Changed modal-lg to modal-xl -->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Data Surat Penawaran</h4>
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
                                    <th>Kode Penawaran</th>
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
                                @foreach ($suratpenawarans as $suratpenawaran)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $suratpenawaran->kode_spk }}</td>
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
                                                    '{{ $suratpenawaran->kategori }}',
                                                    '{{ $suratpenawaran->no_npwp }}',
                                                '{{ $suratpenawaran->pelanggan_id }}',
                                                '{{ $suratpenawaran->kode_pelanggan }}',
                                                '{{ $suratpenawaran->nama_pelanggan }}',
                                                '{{ $suratpenawaran->telp }}',
                                                '{{ $suratpenawaran->alamat }}',
                                                '{{ $suratpenawaran->merek_id }}',
                                                '{{ $suratpenawaran->nama_merek }}',
                                                '{{ $suratpenawaran->tipe }}',
                                                '{{ $suratpenawaran->typekaroseri_id }}',
                                                '{{ $suratpenawaran->kode_type }}',
                                                '{{ $suratpenawaran->nama_karoseri }}',
                                                '{{ $suratpenawaran->panjang }}',
                                                '{{ $suratpenawaran->lebar }}',
                                                '{{ $suratpenawaran->tinggi }}',
                                                '{{ $suratpenawaran->spesifikasi }}',
                                                '{{ $suratpenawaran->aksesoris }}',
                                                '{{ $suratpenawaran->harga }}'
                                                )">
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

    <script>
        function showCategoryModalsuratpenawaran(selectedCategory) {
            $('#tablepenawaran').modal('show');
        }

        function getSelectedDatapelanggan(Id, Kategori, NoNpwp, pelanggan_id, kodePelanggan, namaPelanggan, Telp, Alamat,
            Merek_id,
            Nama_merek, Tipe, KodeKaroseri_id, KodeType, Namakaroseri, Panjang, Lebar, Tinggi, Spesifikasi, Aksesoris, Harga
        ) {
            // Set the values in the form fields
            document.getElementById('surat_penawaran_id').value = Id;
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

            var formattedNominal = parseFloat(Harga).toLocaleString('id-ID');
            document.getElementById('harga').value = formattedNominal;

            // Close the modal (if needed)
            $('#tablepenawaran').modal('hide');
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
