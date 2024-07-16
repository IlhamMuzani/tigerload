@extends('layouts.app')

@section('title', 'Inquery Faktur Pajak')

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
                    <h1 class="m-0">Inquery Faktur Pajak</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/inquery_fakturpajak/ . $inquery->id') }}">Inquery
                                Faktur Pajak</a></li>
                        <li class="breadcrumb-item active">Tambah</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>


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
            <form action="{{ url('admin/inquery_fakturpajak/' . $inquery->id) }}" method="POST"
                enctype="multipart/form-data" autocomplete="off">
                @csrf
                @method('put')
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Perbarui</h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 mt-4">
                            <button class="btn btn-primary btn-sm" type="button" onclick="showPenjualan(this.value)">
                                <i class="fas fa-plus mr-2"></i> Pilih Penjualan
                            </button>
                        </div>
                        <div class="form-group" hidden>
                            <label for="nopol">Id Penjualan</label>
                            <input type="text" class="form-control  @error('penjualan_id') is-invalid @enderror"
                                id="penjualan_id" name="penjualan_id"
                                value="{{ old('penjualan_id', $inquery->penjualan->id) }}" readonly placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="nopol">Kode Penjualan</label>
                            <input type="text" class="form-control  @error('kode_penjualan') is-invalid @enderror"
                                name="kode_penjualan" id="kode_penjualan" readonly placeholder=""
                                value="{{ old('kode_penjualan', $inquery->penjualan->kode_penjualan) }}">
                        </div>
                        <div class="form-group">
                            <label>Nama Pelanggan</label>
                            <input class="form-control @error('nama_pelanggan') is-invalid @enderror" id="nama_pelanggan"
                                name="nama_pelanggan" type="text" placeholder=""
                                value="{{ old('nama_pelanggan', $inquery->penjualan->perintah_kerja->spk->pelanggan->nama_pelanggan) }}"
                                readonly />
                        </div>
                        <div class="form-group">
                            <label for="nama">Merek Kendaraan</label>
                            <input type="text" class="form-control @error('merek') is-invalid @enderror" id="merek"
                                name="merek" readonly placeholder=""
                                value="{{ old('merek', $inquery->penjualan->perintah_kerja->spk->typekaroseri->merek->nama_merek) }}">
                        </div>
                        <div class="form-group">
                            <label for="nama">Type Kendaraan</label>
                            <input type="text" class="form-control @error('tipe') is-invalid @enderror" id="tipe"
                                name="tipe" readonly placeholder=""
                                value="{{ old('tipe', $inquery->penjualan->perintah_kerja->spk->tipe) }}">
                        </div>
                        <div class="form-group">
                            <label for="nama">Kode Karoseri</label>
                            <input type="text" class="form-control @error('kode_type') is-invalid @enderror"
                                name="kode_type" id="kode_type"readonly placeholder=""
                                value="{{ old('kode_type', $inquery->penjualan->perintah_kerja->spk->kode_type) }}">
                        </div>
                        <div class="form-group">
                            <label for="nama">Bentuk Karoseri</label>
                            <input type="text" class="form-control @error('nama_karoseri') is-invalid @enderror"
                                name="nama_karoseri" id="nama_karoseri" readonly placeholder=""
                                value="{{ old('nama_karoseri', $inquery->penjualan->perintah_kerja->spk->typekaroseri->nama_karoseri) }}">
                        </div>
                        <div class="form-group">
                            <label for="nama">Harga</label>
                            <input type="text" class="form-control @error('harga') is-invalid @enderror" readonly
                                id="harga" name="harga" placeholder="" placeholder=""
                                value="{{ old('harga', $inquery->penjualan->perintah_kerja->spk->harga) }}">
                        </div>


                        <div class="form-group mt-5">
                            @if ($inquery->gambar_pajak == null)
                                <p class="mt-3">Tidak ada PDF yang diunggah.</p>
                            @else
                                <p class="mt-3">
                                    <a href="{{ asset('storage/uploads/' . $inquery->gambar_pajak) }}"
                                        target="_blank">Lihat
                                        PDF yang diunggah</a>
                                </p>
                            @endif
                            <label for="nama">Dokumen Bukti</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="gambar_pajak" name="gambar_pajak"
                                    accept="application/pdf">
                                <label class="custom-file-label" for="gambar_pajak">Pilih PDF</label>
                            </div>
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

        <div class="modal fade" id="tableSpk" data-backdrop="static">
            <div class="modal-dialog modal-xl"> <!-- Changed modal-lg to modal-xl -->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Data Penjualan</h4>
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
                                        <th>Kode Penjualan</th>
                                        <th>Nama Pelanggan</th>
                                        <th>Bentuk Karoseri</th>
                                        <th>Harga</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($penjualans as $penjualan)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $penjualan->kode_penjualan }}</td>
                                            <td>{{ $penjualan->perintah_kerja->spk->pelanggan->nama_pelanggan }}</td>
                                            <td>{{ $penjualan->perintah_kerja->spk->typekaroseri->nama_karoseri }}</td>
                                            </td>
                                            <td class="text-right">
                                                {{ number_format($penjualan->perintah_kerja->spk->harga, 0, ',', '.') }}
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    onclick="getSelectedData('{{ $penjualan->id }}', '{{ $penjualan->kode_penjualan }}', '{{ $penjualan->perintah_kerja->spk->pelanggan->nama_pelanggan }}',
                                                    '{{ $penjualan->perintah_kerja->spk->detail_kendaraan->first()->merek->nama_merek }}',
                                                    '{{ $penjualan->perintah_kerja->spk->detail_kendaraan->first()->merek->tipe->nama_tipe }}',
                                                    '{{ $penjualan->perintah_kerja->spk->typekaroseri->kode_type }}',
                                                    '{{ $penjualan->perintah_kerja->spk->typekaroseri->nama_karoseri }}',
                                                    '{{ $penjualan->perintah_kerja->spk->harga }}')">
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
        function showPenjualan(selectedCategory) {
            $('#tableSpk').modal('show');
        }

        function getSelectedData(Spk_id, kodePenjualan, NamaPelanggan, Merek, Type, KodeKaroseri, BentukKaroseri, Harga) {
            // Set the values in the form fields
            document.getElementById('penjualan_id').value = Spk_id;
            document.getElementById('kode_penjualan').value = kodePenjualan;
            document.getElementById('nama_pelanggan').value = NamaPelanggan;
            document.getElementById('merek').value = Merek;
            document.getElementById('tipe').value = Type;
            document.getElementById('kode_type').value = KodeKaroseri;
            document.getElementById('nama_karoseri').value = BentukKaroseri;

            var formattedNominal = parseFloat(Harga).toLocaleString('id-ID');
            document.getElementById('harga').value = formattedNominal;
            // Close the modal (if needed)
            $('#tableSpk').modal('hide');
        }
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

@endsection
