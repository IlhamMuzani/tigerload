@extends('layouts.app')

@section('title', 'Faktur Penjualan')

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
                    <h1 class="m-0">Faktur Penjualan</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/penjualan') }}">Faktur Penjualan</a></li>
                        <li class="breadcrumb-item active">Tambah</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content" style="display: none;" id="mainContentSection">
        <div class="container-fluid">
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
                <form action="{{ url('admin/penjualan') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Tambah</h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-3 mt-4">
                                <button class="btn btn-primary btn-sm" type="button" onclick="showSpk(this.value)">
                                    <i class="fas fa-plus mr-2"></i> Pilih Spk
                                </button>
                            </div>
                            <div class="form-group" hidden>
                                <label for="kategori">Kategori</label>
                                <input type="text" class="form-control" id="kategori" name="kategori"
                                    value="{{ old('kategori') }}" readonly placeholder="">
                            </div>
                            <div class="form-group" hidden>
                                <label for="depositpemesanan_id">Id Deposit</label>
                                <input type="text" class="form-control" id="depositpemesanan_id"
                                    name="depositpemesanan_id" value="{{ old('depositpemesanan_id') }}" readonly
                                    placeholder="">
                            </div>
                            <div class="form-group" hidden>
                                <label>Id SPK</label>
                                <input type="text" class="form-control" id="perintah_kerja_id" name="perintah_kerja_id"
                                    value="{{ old('perintah_kerja_id') }}" readonly placeholder="">
                            </div>
                            <div class="form-group">
                                <label>Kode SPK</label>
                                <input type="text" class="form-control" id="kode_spk" name="kode_spk" readonly placeholder=""
                                    value="{{ old('kode_spk') }}">
                            </div>
                            <div class="form-group">
                                <label>Nama Pelanggan</label>
                                <input class="form-control @error('nama_pelanggan') is-invalid @enderror"
                                    id="nama_pelanggan" name="nama_pelanggan" type="text" placeholder=""
                                    value="{{ old('nama_pelanggan') }}" readonly />
                            </div>
                            <div class="form-group">
                                <label for="nama">Merek Kendaraan</label>
                                <input type="text" class="form-control" name="merek" id="merek" readonly placeholder=""
                                    value="{{ old('merek') }}">
                            </div>
                            <div class="form-group">
                                <label for="nama">Type Kendaraan</label>
                                <input type="text" class="form-control" name="tipe" id="tipe" readonly placeholder=""
                                    value="{{ old('tipe') }}">
                            </div>
                            <div class="form-group">
                                <label for="nama">Kode Karoseri</label>
                                <input type="text" class="form-control" name="kode_type" id="kode_type"readonly placeholder=""
                                    value="{{ old('kode_type') }}">
                            </div>
                            <div class="form-group">
                                <label for="nama">Bentuk Karoseri</label>
                                <input type="text" class="form-control" name="nama_karoseri" id="nama_karoseri" readonly placeholder=""
                                    value="{{ 'nama_karoseri' }}">
                            </div>
                            <div class="form-group">
                                <label for="nama">Harga Pemesanan</label>
                                <input type="text" class="form-control" id="harga_awal" name="harga_awal" readonly
                                    placeholder="" value="{{ 'harga_awal' }}">
                            </div>

                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Tambah Spesifikasi <span>
                                    <p style="font-size: 13px">(Tambahkan spesifikasi jika ada tambahan)</p>
                                </span></h3>
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
                                        <th>Kode Produk</th>
                                        <th>Nama Produk</th>
                                        <th>Qty</th>
                                        <th>Harga</th>
                                        <th>Diskon</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody id="tabel-pembelian">
                                    <tr id="pembelian-0">
                                        <td style="width: 70px" class="text-center" id="urutan">1</td>
                                        <td hidden>
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="typekaroseri_id-0"
                                                    name="typekaroseri_id[]">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" class="form-control" readonly id="kode_types-0"
                                                    name="kode_types[]">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" class="form-control" readonly id="nama_karoseri-0"
                                                    name="nama_karoseri[]">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" class="form-control jumlah" style="font-size:14px"
                                                    id="jumlah-0" name="jumlah[]" data-row-id="0"
                                                    oninput="formatRupiahform(this)"
                                                    onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" class="form-control harga" style="font-size:14px"
                                                    id="harga-0" name="harga[]" data-row-id="0"
                                                    oninput="formatRupiahform(this)"
                                                    onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" class="form-control diskon" style="font-size:14px"
                                                    id="diskon-0" name="diskon[]" data-row-id="0"
                                                    oninput="formatRupiahform(this)"
                                                    onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" class="form-control total" style="font-size:14px"
                                                    id="total-0" name="total[]" readonly
                                                    oninput="formatRupiahform(this)"
                                                    onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                            </div>
                                        </td>
                                        <td style="width: 120px">
                                            <button type="button" class="btn btn-primary" onclick="barang(0)">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                            <button style="margin-left:5px" type="button" class="btn btn-danger"
                                                onclick="removeBan(0)">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer text-right">
                            <button type="reset" class="btn btn-secondary" id="btnReset">Reset</button>
                            <button type="submit" class="btn btn-primary" id="btnSimpan">Simpan</button>
                            <div id="loading" style="display: none;">
                                <i class="fas fa-spinner fa-spin"></i> Sedang Menyimpan...
                            </div>
                        </div>
                    </div>
            </div>
            </form>
            {{-- </div> --}}
        </div>

        <div class="modal fade" id="tableBarang" data-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Data Produk</h4>
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
                                    <th>Kode Produk</th>
                                    <th>Nama Produk</th>
                                    <th>Harga</th>
                                    {{-- <th>Keterangan</th> --}}
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($barangs as $barang)
                                    <tr data-typekaroseri_id="{{ $barang->id }}"
                                        data-kode_type="{{ $barang->kode_type }}"
                                        data-nama_karoseri="{{ $barang->nama_karoseri }}"
                                        data-harga="{{ $barang->harga }}" data-param="{{ $loop->index }}">
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $barang->kode_type }}</td>
                                        <td>{{ $barang->nama_karoseri }}</td>
                                        <td style="text-align: right">{{ number_format($barang->harga, 0, ',', '.') }}
                                        </td>
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

        <div class="modal fade" id="tableSpk" data-backdrop="static">
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
                                        <th>Kode Spk</th>
                                        <th>Nama Pelanggan</th>
                                        <th>Deposit</th>
                                        <th>Merek</th>
                                        <th>Type</th>
                                        <th>Kode Karoseri</th>
                                        <th>Bentuk Karoseri</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($spks as $spk)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $spk->kode_perintah }}</td>
                                            <td>{{ $spk->spk->pelanggan->nama_pelanggan }}</td>
                                            <td>
                                                @if ($spk->depositpemesanan->first())
                                                    {{ $spk->depositpemesanan->first()->kode_deposit }}
                                                @else
                                                    tidak ada
                                                @endif
                                            </td>
                                            <td>{{ $spk->spk->merek->nama_merek }}</td>
                                            <td>{{ $spk->spk->merek->tipe->nama_tipe }}</td>
                                            <td>{{ $spk->typekaroseri->kode_type }}</td>
                                            <td>{{ $spk->typekaroseri->nama_karoseri }}</td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    onclick="getSelectedData('{{ $spk->id }}', '{{ $spk->kode_perintah }}', '{{ $spk->spk->pelanggan->nama_pelanggan }}',
                                                    '{{ $spk->spk->merek->nama_merek }}',
                                                    '{{ $spk->spk->merek->tipe->nama_tipe }}',
                                                    '{{ $spk->spk->typekaroseri->kode_type }}',
                                                    '{{ $spk->spk->typekaroseri->nama_karoseri }}',
                                                    '{{ $spk->spk->harga }}',
                                                    '{{ $spk->spk->kategori }}',
                                                    '{{ $spk->depositpemesanan->first() ? $spk->depositpemesanan->first()->id : '' }}')">
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
        function showSpk(selectedCategory) {
            $('#tableSpk').modal('show');
        }

        function getSelectedData(Spk_id, KodeSPK, NamaPelanggan, Merek, Type, KodeKaroseri, BentukKaroseri, Harga, Kategori,
            Dp_id) {
            // Set the values in the form fields
            document.getElementById('perintah_kerja_id').value = Spk_id;
            document.getElementById('kode_spk').value = KodeSPK;
            document.getElementById('nama_pelanggan').value = NamaPelanggan;
            document.getElementById('merek').value = Merek;
            document.getElementById('tipe').value = Type;
            document.getElementById('kode_type').value = KodeKaroseri;
            document.getElementById('nama_karoseri').value = BentukKaroseri;
            document.getElementById('depositpemesanan_id').value = Dp_id;
            document.getElementById('kategori').value = Kategori;

            var formattedNominal = parseFloat(Harga).toLocaleString('id-ID');
            document.getElementById('harga_awal').value = formattedNominal;
            // Close the modal (if needed)
            $('#tableSpk').modal('hide');
        }


        var activeSpecificationIndex = 0;

        function barang(param) {
            activeSpecificationIndex = param;
            // Show the modal and filter rows if necessary
            $('#tableBarang').modal('show');
        }

        function getBarang(rowIndex) {
            var selectedRow = $('#tables tbody tr:eq(' + rowIndex + ')');
            var typekaroseri_id = selectedRow.data('typekaroseri_id');
            var kode_type = selectedRow.data('kode_type');
            var nama_karoseri = selectedRow.data('nama_karoseri');
            var harga = selectedRow.data('harga');
            var jumlah = 0;
            var diskon = 0;
            var total = 0;

            // Update the form fields for the active specification
            $('#typekaroseri_id-' + activeSpecificationIndex).val(typekaroseri_id);
            $('#kode_types-' + activeSpecificationIndex).val(kode_type);
            $('#nama_karoseri-' + activeSpecificationIndex).val(nama_karoseri);
            $('#harga-' + activeSpecificationIndex).val(Number(harga).toLocaleString('id-ID'));
            $('#jumlah-' + activeSpecificationIndex).val(jumlah);
            $('#diskon-' + activeSpecificationIndex).val(diskon);
            $('#total-' + activeSpecificationIndex).val(total);

            $('#tableBarang').modal('hide');
        }


        // Function to filter the table rows based on the search input
        function filterTable() {
            var input, filter, table, tr, td, i, j, txtValue;
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
        document.getElementById("searchInput").addEventListener("input", filterTable);


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
            var typekaroseri_id = '';
            var nama_karoseri = '';
            var kode_types = '';
            var jumlah = '';
            var harga = '';
            var diskon = '';
            var total = '';

            if (value !== null) {
                typekaroseri_id = value.typekaroseri_id;
                nama_karoseri = value.nama_karoseri;
                kode_types = value.kode_types;
                jumlah = value.jumlah;
                harga = value.harga;
                diskon = value.diskon;
                total = value.total;
            }

            // urutan 
            var item_pembelian = '<tr id="pembelian-' + urutan + '">';
            item_pembelian += '<td style="width: 70px" class="text-center" id="urutan-' + urutan + '">' + urutan + '</td>';

            // typekaroseri_id 
            item_pembelian += '<td hidden>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" id="typekaroseri_id-' + urutan +
                '" name="typekaroseri_id[]" value="' + typekaroseri_id + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // kode_types 
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" readonly id="kode_types-' + urutan +
                '" name="kode_types[]" value="' + kode_types + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // nama_karoseri 
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" readonly id="nama_karoseri-' + urutan +
                '" name="nama_karoseri[]" value="' + nama_karoseri + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // jumlah
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control jumlah" style="font-size:14px" id="jumlah-' + urutan +
                '" name="jumlah[]" value="' + jumlah + '" ';
            item_pembelian += 'oninput="formatRupiahform(this)" ';
            item_pembelian += 'onkeypress="return event.charCode >= 48 && event.charCode <= 57">'
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // harga
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control harga" style="font-size:14px" id="harga-' + urutan +
                '" name="harga[]" value="' + harga + '" ';
            item_pembelian += 'oninput="formatRupiahform(this)" ';
            item_pembelian += 'onkeypress="return event.charCode >= 48 && event.charCode <= 57">'
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // diskon
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control diskon" style="font-size:14px" id="diskon-' + urutan +
                '" name="diskon[]" value="' + diskon + '" ';
            item_pembelian += 'oninput="formatRupiahform(this)" ';
            item_pembelian += 'onkeypress="return event.charCode >= 48 && event.charCode <= 57">'
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // total
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" readonly class="form-control total" style="font-size:14px" id="total-' +
                urutan +
                '" name="total[]" value="' + total + '" readonly';
            item_pembelian += 'oninput="formatRupiahform(this)" ';
            item_pembelian += 'onkeypress="return event.charCode >= 48 && event.charCode <= 57">'
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            item_pembelian += '<td style="width: 120px">';
            item_pembelian += '<button type="button" class="btn btn-primary" onclick="barang(' + urutan + ')">';
            item_pembelian += '<i class="fas fa-plus"></i>';
            item_pembelian += '</button>';
            item_pembelian += '<button style="margin-left:5px" type="button" class="btn btn-danger" onclick="removeBan(' +
                urutan + ')">';
            item_pembelian += '<i class="fas fa-trash"></i>';
            item_pembelian += '</button>';
            item_pembelian += '</td>';
            item_pembelian += '</tr>';

            $('#tabel-pembelian').append(item_pembelian);
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
        $(document).on("input", ".harga, .jumlah, .diskon", function() {
            var currentRow = $(this).closest('tr');

            // Function to remove non-numeric characters and convert to float
            function parseCurrency(value) {
                return parseFloat(value.replace(/[^0-9,-]+/g, "").replace(",", ".")) || 0;
            }

            var harga = parseCurrency(currentRow.find(".harga").val());
            var jumlah = parseFloat(currentRow.find(".jumlah").val()) || 0;
            var diskon = parseCurrency(currentRow.find(".diskon").val());
            var total = harga * jumlah - diskon;

            currentRow.find(".total").val(total.toLocaleString('id-ID'));

            updateGrandTotal();
        });
    </script>

@endsection
