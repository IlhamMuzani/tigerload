@extends('layouts.app')

@section('title', 'Perhitungan Pengambilan Bahan Baku')

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
                    <h1 class="m-0">Perhitungan Pengambilan Bahan Baku</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/tablepengambilanbahan') }}">Transaksi</a></li>
                        <li class="breadcrumb-item active">Perhitungan Pengambilan Bahan Baku</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <section class="content" style="display: none;" id="mainContentSection">
        <div class="container-fluid">
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
            @if (session('success'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5>
                        <i class="icon fas fa-check"></i> Berhasil!
                    </h5>
                    {{ session('success') }}
                </div>
            @endif
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
            <form action="{{ url('admin/inquery_perhitunganbahanbaku', $inquery->id) }}" method="post" autocomplete="off">
                @csrf
                @method('put')
                <div class="card">
                    <div></div>
                    {{-- <div class="card-header">
                        <h3 class="card-title">Tambah Pelanggan</h3>
                    </div> --}}
                    <div class="card-body">
                        <div hidden class="mb-3">
                            <label class="form-label" for="perintah_kerja_id">Surat Perintah Kerja Id</label>
                            <input class="form-control @error('perintah_kerja_id') is-invalid @enderror"
                                id="perintah_kerja_id" name="perintah_kerja_id" type="text" placeholder=" "
                                value="{{ old('perintah_kerja_id', $spks->id) }}" readonly />
                        </div>
                        <div class="form-group">
                            <label for="kode_spk">Kode SPK</label>
                            <input type="text" class="form-control" id="kode_spk" name="kode_spk" readonly
                                placeholder="" value="{{ old('kode_spk', $spks->kode_perintah) }}">
                        </div>
                        <label class="form-label" for="nama_pelanggan">Nama Pelanggan</label>
                        <div class="mb-2 d-flex">
                            <input class="form-control @error('nama_pelanggan') is-invalid @enderror" id="nama_pelanggan"
                                name="nama_pelanggan" type="text" placeholder=""
                                value="{{ old('nama_pelanggan', $spks->pelanggan->nama_pelanggan) }}" readonly />
                        </div>
                        <div class="form-group" hidden>
                            <label for="pelanggan_id">Id Pelanggan</label>
                            <input type="text" class="form-control" id="pelanggan_id" name="pelanggan_id" placeholder=""
                                value="{{ old('pelanggan_id', $spks->pelanggan->id) }}">
                        </div>
                        <div class="form-group">
                            <label for="kode_pelanggan">Kode Pelanggan</label>
                            <input type="text" class="form-control" id="kode_pelanggan" name="kode_pelanggan" readonly
                                placeholder="" value="{{ old('kode_pelanggan', $spks->pelanggan->kode_pelanggan) }}">
                        </div>
                        {{-- <div class="form-group">
                            <label for="umur">Umur</label>
                            <input type="text" class="form-control" id="umur" name="umur" placeholder="" readonly
                                value="{{ old('umur') }}">
                        </div> --}}
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea type="text" class="form-control" id="alamat" name="alamat" readonly placeholder="">{{ old('alamat', $spks->pelanggan->alamat) }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="telp">No. Telepon</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">+62</span>
                                </div>
                                <input type="text" id="telp" name="telp" class="form-control" readonly
                                    placeholder="" value="{{ old('telp', $spks->pelanggan->telp) }}">
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
                                    value="{{ old('merek_id', $spks->spk->merek->id) }}" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="nama_merek">Merek</label>
                                <input class="form-control @error('nama_merek') is-invalid @enderror" id="nama_merek"
                                    name="nama_merek" readonly type="text" placeholder=""
                                    value="{{ old('nama_merek', $spks->spk->merek->nama_merek) }}" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="tipe">Type</label>
                                <input class="form-control @error('tipe') is-invalid @enderror" id="tipe"
                                    name="tipe" readonly type="text" placeholder=""
                                    value="{{ old('tipe', $spks->spk->merek->tipe->nama_tipe) }}" />
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
                                    value="{{ old('kode_type', $spks->spk->typekaroseri->kode_type) }}" readonly />
                            </div>
                            <div class="form-group">
                                <label for="nama_karoseri">Bentuk Karoseri</label>
                                <input type="text" class="form-control" id="nama_karoseri" name="nama_karoseri"
                                    readonly placeholder=""
                                    value="{{ old('nama_karoseri', $spks->spk->typekaroseri->nama_karoseri) }}">
                            </div>
                            <div class="form-group"hidden>
                                <label for="karoseri_id">Id Karoseri</label>
                                <input type="text" class="form-control" id="karoseri_id" name="typekaroseri_id"
                                    placeholder=""
                                    value="{{ old('typekaroseri_id', $spks->spk->typekaroseri->typekaroseri_id) }}">
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
                                    placeholder="" value="{{ old('panjang', $spks->spk->typekaroseri->panjang) }}">
                            </div>
                            <div class="form-group">
                                <label for="lebar">Lebar</label>
                                <input type="text" class="form-control" id="lebar" name="lebar" readonly
                                    placeholder="" value="{{ old('lebar', $spks->spk->typekaroseri->lebar) }}">
                            </div>
                            <div class="form-group">
                                <label for="tinggi">Tinggi</label>
                                <input type="text" class="form-control" id="tinggi" name="tinggi" readonly
                                    placeholder="" value="{{ old('tinggi', $spks->spk->typekaroseri->tinggi) }}">
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
                                <textarea type="text" class="form-control" id="spesifikasi" readonly name="spesifikasi" placeholder="">{{ implode(', ', $spks->spk->typekaroseri->spesifikasi->pluck('nama')->toArray()) }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="aksesoris">Aksesoris</label>
                                <input type="text" class="form-control" readonly name="aksesoris"
                                    value="{{ old('aksesoris', $spks->spk->typekaroseri->aksesoris) }}" id="aksesoris"
                                    placeholder="">
                            </div>
                            {{-- <div class="form-group">
                                <label for="nama_karoseri">Harga</label>
                                <!-- /.card-header -->
                                <input type="text" class="form-control" id="harga_spk" readonly name="harga_spk"
                                    placeholder="" value="{{ old('harga_spk', $spks->spk->typekaroseri->harga) }}">
                            </div> --}}

                            <div class="form-group">
                                <label for="keterangan">Keterangan</label>
                                <textarea type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Masukan keterangan">{{ old('keterangan', $inquery->keterangan) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">List Pengambilan Bahan Baku</h3>
                        <div class="float-right">
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="datatables66" class="table table-bordered table-striped table-hover"
                            style="font-size: 13px">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Kode Pengambilan</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($details as $index => $pengambilan)
                                    <tr style="background: rgb(240, 242, 246)">
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $pengambilan->kode_pengambilan }}</td>
                                        <td>{{ $pengambilan->tanggal_awal }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4"> <!-- Gabungkan kolom untuk detail -->
                                            <div id="pengambilan-{{ $index }}">
                                                <table class="table table-sm" style="margin: 0;">
                                                    <thead>
                                                        <tr>
                                                            <th>Kode Barang</th>
                                                            <th>Nama Barang</th>
                                                            <th>Qty</th>
                                                            <th>Harga</th>
                                                            <th>Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($pengambilan->detailpengambilan as $item)
                                                            <tr>
                                                                <td>{{ $item->kode_barang }}</td>
                                                                <td>{{ $item->nama_barang }}</td>
                                                                <td>{{ $item->jumlah }}</td>
                                                                <td>{{ number_format($item->harga, 2, ',', '.') }}</td>
                                                                <td>{{ number_format($item->total, 2, ',', '.') }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        @php
                            $totalHarga = 0;
                            $totalJumlah = 0;
                            foreach ($details as $pengambilan) {
                                foreach ($pengambilan->detailpengambilan as $item) {
                                    $totalHarga += $item->harga * $item->jumlah;
                                    $totalJumlah += $item->jumlah;
                                }
                            }
                            $hasil = $totalJumlah ? $totalHarga / $totalJumlah : 0;
                        @endphp
                        <br>
                        <div class="form-group">
                            <label for="grand_total">Total Harga</label>
                            <input style="text-align: end" type="text" class="form-control" readonly
                                name="grand_total" value="{{ number_format($totalHarga, 2, ',', '.') }}"
                                id="grand_total" placeholder="">
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
