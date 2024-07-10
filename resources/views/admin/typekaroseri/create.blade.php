@extends('layouts.app')

@section('title', 'Tambah Produk')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Produk</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/typekaroseri') }}">Produk</a></li>
                        <li class="breadcrumb-item active">Tambah</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <section class="content">
        <div class="container-fluid">
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
            <form action="{{ url('admin/typekaroseri') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tambah Produk</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="form-group">
                            <label for="kategori_produk_id">Kategori</label>
                            <select class="custom-select form-control" id="kategori_produk_id" name="kategori_produk_id">
                                <option value="">- Pilih Departemen -</option>
                                @foreach ($kategori_produks as $kategori_produk)
                                    <option value="{{ $kategori_produk->id }}"
                                        {{ old('kategori_produk_id') == $kategori_produk->id ? 'selected' : '' }}>
                                        {{ $kategori_produk->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nama_karoseri">Bentuk Karoseri</label>
                            <input type="text" class="form-control" id="nama_karoseri" name="nama_karoseri"
                                placeholder="masukkan bentuk karoseri" value="{{ old('nama_karoseri') }}">
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tambah Merek</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="mb-3">
                            <button class="btn btn-primary btn-sm" type="button" onclick="showCategoryModal(this.value)">
                                <i class="fas fa-plus mr-2"></i> Pilih Merek
                            </button>
                        </div>
                        <div class="mb-3" hidden>
                            <label class="form-label" for="merek_id">Merek_id *</label>
                            <input class="form-control @error('merek_id') is-invalid @enderror" id="merek_id"
                                name="merek_id" readonly type="text" placeholder="" value="{{ old('merek_id') }}" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="nama_merek">Merek *</label>
                            <input class="form-control @error('nama_merek') is-invalid @enderror" id="nama_merek"
                                name="nama_merek" readonly type="text" placeholder="" value="{{ old('nama_merek') }}" />
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

                        <div class="form-group">
                            <label for="varian">Varian</label>
                            <input type="text" class="form-control" id="varian" name="varian"
                                placeholder="Masukkan varian" value="{{ old('varian') }}">
                        </div>
                        <div class="form-group">
                            <label for="gambar_skrb">Gambar SKRB</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="gambar_skrb" name="gambar_skrb"
                                    accept="image/*">
                                <label class="custom-file-label" for="gambar_skrb">Masukkan gambar skrb</label>
                            </div>
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
                                    <th>Keterangan</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody id="tabel-pembelian">
                                <tr id="pembelian-0">
                                    <td style="width: 70px" class="text-center" id="urutan">1</td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="nama-0" name="nama[]">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="keterangan-0"
                                                name="keterangan[]">
                                        </div>
                                    </td>
                                    <td style="width: 50px">
                                        {{-- <button type="button" class="btn btn-primary btn-sm" onclick="barang(0)">
                                            <i class="fas fa-plus"></i>
                                        </button> --}}
                                        <button type="button" class="btn btn-danger btn-sm" onclick="removeBan(0)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="card-body">
                        {{-- <div class="form-group">
                            <textarea type="text" class="form-control" id="spesifikasi" readonly name="spesifikasi" placeholder="">{{ old('typekaroseri_id') }}</textarea>
                        </div> --}}
                        <div class="form-group">
                            <label for="aksesoris">Aksesoris</label>
                            <input type="text" class="form-control" name="aksesoris" value="{{ old('aksesoris') }}"
                                id="aksesoris" placeholder="">
                        </div>

                        <div class="form-group">
                            <label for="aksesoris">Harga</label>
                            <input type="text" class="form-control" id="harga" name="harga" placeholder=""
                                value="{{ old('harga') }}" oninput="formatRupiahform(this)"
                                onkeypress="return event.charCode >= 48 && event.charCode <= 57">
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

        <div class="modal fade" id="tableBarang" data-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Data Barang</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="m-2">
                            <input type="text" id="searchInput" class="form-control" placeholder="Search...">
                        </div>
                        <table id="tables" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Kode Barang</th>
                                    <th>Nama barang</th>
                                    <th>Spesifikasi</th>
                                    <th>Keterangan</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($barangs as $barang)
                                    <tr data-barang_id="{{ $barang->id }}"
                                        data-nama_barang="{{ $barang->nama_barang }}" data-param="{{ $loop->index }}">
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $barang->kode_barang }}</td>
                                        <td>{{ $barang->nama_barang }}</td>
                                        <td>{{ $barang->spesifikasi }}</td>
                                        <td>{{ $barang->keterangan }}</td>
                                        <td class="text-center">
                                            <button type="button" id="btnTambah" class="btn btn-primary btn-sm"
                                                onclick="getBarang({{ $loop->index }})">
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
    </section>

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


        var activeSpecificationIndex = 0;

        function barang(param) {
            activeSpecificationIndex = param;
            // Show the modal and filter rows if necessary
            $('#tableBarang').modal('show');
        }

        function getBarang(rowIndex) {
            var selectedRow = $('#tables tbody tr:eq(' + rowIndex + ')');
            var barang_id = selectedRow.data('barang_id');
            var nama_barang = selectedRow.data('nama_barang');

            // Update the form fields for the active specification
            $('#barang_id-' + activeSpecificationIndex).val(barang_id);
            $('#nama-' + activeSpecificationIndex).val(nama_barang);

            $('#tableBarang').modal('hide');
        }

        // filter rute 
        function filterMemo() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("searchInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("tables");
            tr = table.getElementsByTagName("tr");

            for (i = 0; i < tr.length; i++) {
                var displayRow = false;

                // Loop through columns (td 1, 2, and 3)
                for (j = 1; j <= 3; j++) {
                    td = tr[i].getElementsByTagName("td")[j];
                    if (td) {
                        txtValue = td.textContent || td.innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            displayRow = true;
                            break; // Break the loop if a match is found in any column
                        }
                    }
                }

                // Set the display style based on whether a match is found in any column
                tr[i].style.display = displayRow ? "" : "none";
            }
        }
        document.getElementById("searchInput").addEventListener("input", filterMemo);
    </script>

    <script>
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

            var tabel_pesanan = document.getElementById('tabel-pembelian');
            var pembelian = document.getElementById('pembelian-' + params);

            tabel_pesanan.removeChild(pembelian);

            if (jumlah_ban === 0) {
                var item_pembelian = '<tr>';
                item_pembelian += '<td class="text-center" colspan="11">- Memo belum ditambahkan -</td>';
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
            var keterangan = '';

            if (value !== null) {
                nama = value.nama;
                keterangan = value.keterangan;
            }

            // urutan 
            var item_pembelian = '<tr id="pembelian-' + urutan + '">';
            item_pembelian += '<td style="width: 70px; font-size:14px" class="text-center" id="urutan-' + urutan + '">' +
                urutan + '</td>';

            // nama 
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" id="nama-' + urutan +
                '" name="nama[]" value="' + nama + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // keterangan 
            item_pembelian += '<td onclick="MemoEkspedisi(' + urutan +
                ')">';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" style="font-size:14px" id="keterangan-' +
                urutan +
                '" name="keterangan[]" value="' + keterangan + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            item_pembelian += '<td style="width: 50px">';
            item_pembelian +=
                '<button type="button" class="btn btn-danger btn-sm" onclick="removeBan(' +
                urutan + ')">';
            item_pembelian += '<i class="fas fa-trash"></i>';
            item_pembelian += '</button>';
            item_pembelian += '</td>';
            item_pembelian += '</tr>';

            $('#tabel-pembelian').append(item_pembelian);
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
