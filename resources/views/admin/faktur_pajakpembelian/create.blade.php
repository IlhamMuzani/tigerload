@extends('layouts.app')

@section('title', 'Faktur Pajak')

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
                    <h1 class="m-0">Faktur Pajak</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/faktur_pajak') }}">Faktur Pajak</a></li>
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
            <form action="{{ url('admin/faktur_pajakpembelian') }}" method="POST" enctype="multipart/form-data"
                autocomplete="off">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tambah</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group" style="flex: 8;">
                            <div class="col-md-0 mb-3">
                                <label>Kategori</label>
                                <select class="custom-select form-control" id="kategori" name="kategori">
                                    <option value="">- Pilih Kategori -</option>
                                    <option value="pembelian"selected>PEMBELIAN</option>
                                    <option value="penjualan">PENJUALAN</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 mt-4">
                            <button class="btn btn-primary btn-sm" type="button" onclick="showPenjualan(this.value)">
                                <i class="fas fa-plus mr-2"></i> Pilih Penjualan
                            </button>
                        </div>
                        <div class="form-group" hidden>
                            <label for="nopol">Id Penjualan</label>
                            <input type="text" class="form-control  @error('pembelian_id') is-invalid @enderror"
                                id="pembelian_id" name="pembelian_id" value="{{ old('pembelian_id') }}" readonly
                                placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="nopol">Kode Pembelian</label>
                            <input type="text" class="form-control  @error('kode_pembelian') is-invalid @enderror"
                                name="kode_pembelian" id="kode_pembelian" readonly placeholder=""
                                value="{{ old('kode_pembelian') }}">
                        </div>
                        <div class="form-group">
                            <label>Kode Supplier</label>
                            <input class="form-control @error('kode_supplier') is-invalid @enderror" id="kode_supplier"
                                name="kode_supplier" type="text" placeholder="" value="{{ old('kode_supplier') }}"
                                readonly />
                        </div>
                        <div class="form-group">
                            <label>Nama Supplier</label>
                            <input class="form-control @error('nama_supp') is-invalid @enderror" id="nama_supp"
                                name="nama_supp" type="text" placeholder="" value="{{ old('nama_supp') }}" readonly />
                        </div>
                        <div class="form-group">
                            <label for="nama">Telp</label>
                            <input type="text" class="form-control @error('telp') is-invalid @enderror" id="telp"
                                name="telp" readonly placeholder="" value="{{ old('telp') }}">
                        </div>
                        <div class="form-group">
                            <label for="nama">Harga</label>
                            <input type="text" class="form-control @error('harga') is-invalid @enderror" readonly
                                id="harga" name="harga" placeholder="" placeholder="" value="{{ old('harga') }}">
                        </div>
                        <div class="form-group">
                            <label for="gambar">Foto bukti </label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="gambar_pajak" name="gambar_pajak"
                                    accept="image/*">
                                <label class="custom-file-label" for="gambar_pajak">Masukkan Foto Bukti</label>
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
                                        <th>Kode Supplier</th>
                                        <th>Nama Supplier</th>
                                        <th>Bentuk Karoseri</th>
                                        <th>Harga</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($penjualans as $penjualan)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $penjualan->kode_pembelian }}</td>
                                            <td>{{ $penjualan->supplier->kode_supplier }}</td>
                                            <td>{{ $penjualan->supplier->nama_supp }}</td>
                                            <td>{{ $penjualan->supplier->telp }}</td>
                                            </td>
                                            <td class="text-right">
                                                {{ number_format($penjualan->grand_total, 0, ',', '.') }}
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    onclick="getSelectedData('{{ $penjualan->id }}', '{{ $penjualan->kode_pembelian }}',
                                                    '{{ $penjualan->supplier->kode_supplier }}',
                                                    '{{ $penjualan->supplier->nama_supp }}',
                                                    '{{ $penjualan->supplier->telp }}',
                                                    '{{ $penjualan->grand_total }}')">
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

        function getSelectedData(Spk_id, kodePenjualan, KodeSUpplier, NamaSupplier, Telp, Harga) {
            // Set the values in the form fields
            document.getElementById('pembelian_id').value = Spk_id;
            document.getElementById('kode_pembelian').value = kodePenjualan;
            document.getElementById('kode_supplier').value = KodeSUpplier;
            document.getElementById('nama_supp').value = NamaSupplier;
            document.getElementById('telp').value = Telp;
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

    <script>
        $(document).ready(function() {
            // Detect the change event on the 'status' dropdown
            $('#kategori').on('change', function() {
                // Get the selected value
                var selectedValue = $(this).val();

                // Check the selected value and redirect accordingly
                switch (selectedValue) {
                    case 'pembelian':
                        window.location.href = "{{ url('admin/faktur_pajakpembelian/create') }}";
                        break;
                    case 'penjualan':
                        window.location.href = "{{ url('admin/faktur_pajak/create') }}";
                        break;
                    default:
                        // Handle other cases or do nothing
                        break;
                }
            });
        });
    </script>

@endsection
