@extends('layouts.app')

@section('title', 'Perbarui Pengambilan')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Inquery Pengambilan Bahan Baku</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/inquery_pengambilanbahan') }}">Transaksi</a></li>
                        <li class="breadcrumb-item active">Inquery Pengambilan Bahan Baku</li>
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
            <form action="{{ url('admin/inquery_pengambilanbahan/' . $inquery->id) }}" method="post" autocomplete="off">
                @csrf
                @method('put')
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Inquery Pengambilan Bahan Baku</h3>
                        <div class="float-right">
                            {{-- <button type="button" data-toggle="modal" data-target="#modal-supplier"
                                class="btn btn-primary btn-sm">
                                Tambah
                            </button> --}}
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="mb-3 mt-4">
                            <button class="btn btn-primary btn-sm" type="button"
                                onclick="showCategoryModalspk(this.value)">
                                <i class="fas fa-plus mr-2"></i> Pilih SPK
                            </button>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="perintah_kerja_id">Surat Perintah Kerja Id</label>
                            <input class="form-control @error('perintah_kerja_id') is-invalid @enderror" id="perintah_kerja_id"
                                name="perintah_kerja_id" type="text" placeholder=""
                                value="{{ old('perintah_kerja_id', $inquery->perintah_kerja_id) }}" readonly />
                        </div>
                        <div hidden class="mb-3">
                            <label class="form-label" for="kategori">Kategori</label>
                            <input class="form-control @error('kategori') is-invalid @enderror" id="kategori"
                                name="kategori" type="text" placeholder=" "
                                value="{{ old('kategori', $inquery->perintah_kerja->spk->kategori) }}" readonly />
                        </div>
                        <div>
                            <div class="form-group" id="no_npwp_group">
                                <label for="no_npwp">No NPWP</label>
                                <input type="text" readonly class="form-control" id="no_npwp" name="no_npwp"
                                    placeholder="" value="{{ old('no_npwp', $inquery->perintah_kerja->spk->no_npwp) }}">
                            </div>
                        </div>
                        <label class="form-label" for="nama_pelanggan">Nama Pelanggan</label>
                        <div class="mb-2 d-flex">
                            <input class="form-control @error('nama_pelanggan') is-invalid @enderror" id="nama_pelanggan"
                                name="nama_pelanggan" type="text" placeholder=""
                                value="{{ old('nama_pelanggan', $inquery->perintah_kerja->spk->nama_pelanggan) }}"
                                readonly />
                        </div>
                        <div class="form-group" hidden>
                            <label for="pelanggan_id">Id Pelanggan</label>
                            <input type="text" class="form-control" id="pelanggan_id" name="pelanggan_id" placeholder=""
                                value="{{ old('pelanggan_id', $inquery->perintah_kerja->spk->pelanggan_id) }}">
                        </div>
                        <div class="form-group">
                            <label for="kode_pelanggan">Kode Pelanggan</label>
                            <input type="text" class="form-control" id="kode_pelanggan" name="kode_pelanggan" readonly
                                placeholder=""
                                value="{{ old('kode_pelanggan', $inquery->perintah_kerja->spk->kode_pelanggan) }}">
                        </div>
                        {{-- <div class="form-group">
                            <label for="umur">Umur</label>
                            <input type="text" class="form-control" id="umur" name="umur" placeholder="" readonly
                                value="{{ old('umur') }}">
                        </div> --}}
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea type="text" class="form-control" id="alamat" name="alamat" readonly placeholder="">{{ old('alamat', $inquery->perintah_kerja->spk->alamat) }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="telp">No. Telepon</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">+62</span>
                                </div>
                                <input type="text" id="telp" name="telp" class="form-control" readonly
                                    placeholder="" value="{{ old('telp', $inquery->perintah_kerja->spk->telp) }}">
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
                                    value="{{ old('merek_id', $inquery->perintah_kerja->spk->merek_id) }}" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="nama_merek">Merek</label>
                                <input class="form-control @error('nama_merek') is-invalid @enderror" id="nama_merek"
                                    name="nama_merek" readonly type="text" placeholder=""
                                    value="{{ old('nama_merek', $inquery->perintah_kerja->spk->nama_merek) }}" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="tipe">Type</label>
                                <input class="form-control @error('tipe') is-invalid @enderror" id="tipe"
                                    name="tipe" readonly type="text" placeholder=""
                                    value="{{ old('tipe', $inquery->perintah_kerja->spk->tipe) }}" />
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
                                    value="{{ old('kode_type', $inquery->perintah_kerja->spk->kode_tipe) }}" readonly />
                            </div>
                            <div class="form-group">
                                <label for="nama_karoseri">Bentuk Karoseri</label>
                                <input type="text" class="form-control" id="nama_karoseri" name="nama_karoseri"
                                    readonly placeholder=""
                                    value="{{ old('nama_karoseri', $inquery->perintah_kerja->spk->nama_karoseri) }}">
                            </div>
                            <div class="form-group"hidden>
                                <label for="karoseri_id">Id Karoseri</label>
                                <input type="text" class="form-control" id="karoseri_id" name="typekaroseri_id"
                                    placeholder=""
                                    value="{{ old('typekaroseri_id', $inquery->perintah_kerja->spk->typekaroseri_id) }}">
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
                                    placeholder="" value="{{ old('panjang', $inquery->perintah_kerja->spk->panjang) }}">
                            </div>
                            <div class="form-group">
                                <label for="lebar">Lebar</label>
                                <input type="text" class="form-control" id="lebar" name="lebar" readonly
                                    placeholder="" value="{{ old('lebar', $inquery->perintah_kerja->spk->lebar) }}">
                            </div>
                            <div class="form-group">
                                <label for="tinggi">Tinggi</label>
                                <input type="text" class="form-control" id="tinggi" name="tinggi" readonly
                                    placeholder="" value="{{ old('tinggi', $inquery->perintah_kerja->spk->tinggi) }}">
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
                                    value=" {{ implode(', ', $inquery->perintah_kerja->spk->typekaroseri->spesifikasi->pluck('nama')->toArray()) }}">
                            </div>
                            <div class="form-group">
                                <label for="aksesoris">Aksesoris</label>
                                <input type="text" class="form-control" readonly name="aksesoris"
                                    value="{{ old('aksesoris', $inquery->perintah_kerja->spk->aksesoris) }}"
                                    id="aksesoris" placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="nama_karoseri">Harga</label>
                                <!-- /.card-header -->
                                <input type="text" class="form-control" id="harga" readonly name="harga"
                                    placeholder="" value="{{ old('harga', $inquery->perintah_kerja->spk->harga) }}">
                            </div>

                            <div class="form-group">
                                <label for="keterangan">Keterangan</label>
                                <textarea type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Masukan keterangan">{{ old('keterangan', $inquery->keterangan) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tambah Barang</h3>
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
                                    <th>Kode Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Qty</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody id="tabel-pembelian">
                                @foreach ($details as $detail)
                                    <tr id="pembelian-{{ $loop->index }}">
                                        <td class="text-center" id="urutan">{{ $loop->index + 1 }}</td>
                                        <td style="width: 240px">
                                            <div class="form-group" hidden>
                                                <input type="text" class="form-control" id="id-0"
                                                    name="detail_ids[]" value="{{ $detail['id'] }}">
                                            </div>
                                            <div class="form-group" hidden>
                                                <input type="text" class="form-control"
                                                    id="barang_id-{{ $loop->index }}" name="barang_id[]"
                                                    value="{{ $detail['barang_id'] }}">
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control" readonly
                                                    id="kode_barang-{{ $loop->index }}" name="kode_barang[]"
                                                    value="{{ $detail['kode_barang'] }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" class="form-control" readonly
                                                    id="nama_barang-{{ $loop->index }}" name="nama_barang[]"
                                                    value="{{ $detail['nama_barang'] }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="jumlah-0"
                                                    name="jumlah[]" value="{{ $detail['jumlah'] }}">
                                            </div>
                                        </td>
                                        <td style="width: 120px">
                                            <button type="button" class="btn btn-primary"
                                                onclick="barang({{ $loop->index }})">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                            <button style="margin-left:5px" type="button" class="btn btn-danger"
                                                onclick="removeBan({{ $loop->index }})">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <button type="reset" class="btn btn-secondary">Reset</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
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
                                        data-kode_barang="{{ $barang->kode_barang }}"
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
                                                '{{ $suratpenawaran->spk->aksesoris }}',
                                                '{{ $suratpenawaran->spk->harga }}'
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

    </section>
    <script>
        var activeSpecificationIndex = 0;

        function barang(param) {
            activeSpecificationIndex = param;
            // Show the modal and filter rows if necessary
            $('#tableBarang').modal('show');
        }

        function getBarang(rowIndex) {
            var selectedRow = $('#tables tbody tr:eq(' + rowIndex + ')');
            var barang_id = selectedRow.data('barang_id');
            var kode_barang = selectedRow.data('kode_barang');
            var nama_barang = selectedRow.data('nama_barang');

            // Update the form fields for the active specification
            $('#barang_id-' + activeSpecificationIndex).val(barang_id);
            $('#kode_barang-' + activeSpecificationIndex).val(kode_barang);
            $('#nama_barang-' + activeSpecificationIndex).val(nama_barang);

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

        function updateUrutan() {
            var urutan = document.querySelectorAll('#urutan');
            for (let i = 0; i < urutan.length; i++) {
                urutan[i].innerText = i + 1;
            }
        }

        var counter = 0;

        function addPesanan() {
            counter++;
            jumlah_ban = jumlah_ban + 1;

            if (jumlah_ban === 1) {
                $('#tabel-pembelian').empty();
            } else {
                // Find the last row and get its index to continue the numbering
                var lastRow = $('#tabel-pembelian tr:last');
                var lastRowIndex = lastRow.find('#urutan').text();
                jumlah_ban = parseInt(lastRowIndex) + 1;
            }

            console.log('Current jumlah_ban:', jumlah_ban);
            itemPembelian(jumlah_ban, jumlah_ban - 1);
            updateUrutan();
        }

        function removeBan(identifier) {
            var row = $('#pembelian-' + identifier);
            var detailId = row.find("input[name='detail_ids[]']").val();

            row.remove();

            if (detailId) {
                $.ajax({
                    url: "{{ url('admin/ban/') }}/" + detailId,
                    type: "POST",
                    data: {
                        _method: 'DELETE',
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        console.log('Data deleted successfully');
                    },
                    error: function(error) {
                        console.error('Failed to delete data:', error);
                    }
                });
            }

            updateUrutan();
        }

        function itemPembelian(identifier, key, value = null) {
            var barang_id = '';
            var kode_barang = '';
            var nama_barang = '';
            var jumlah = '';

            if (value !== null) {
                barang_id = value.barang_id;
                kode_barang = value.kode_barang;
                nama_barang = value.nama_barang;
                jumlah = value.jumlah;
            }

            // urutan 
            var item_pembelian = '<tr id="pembelian-' + key + '">';
            item_pembelian += '<td class="text-center" id="urutan">' + key + '</td>';

            // barang_id 
            item_pembelian += '<td hidden>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" id="barang_id-' + key +
                '" name="barang_id[]" value="' + barang_id + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // kode_barang 
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" readonly id="kode_barang-' + key +
                '" name="kode_barang[]" value="' + kode_barang + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // nama_barang 
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" readonly id="nama_barang-' + key +
                '" name="nama_barang[]" value="' + nama_barang + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // jumlah
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control jumlah" id="jumlah-' + key +
                '" name="jumlah[]" value="' + jumlah + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            item_pembelian += '<td style="width: 120px">';
            item_pembelian += '<button type="button" class="btn btn-primary" onclick="barang(' + key + ')">';
            item_pembelian += '<i class="fas fa-plus"></i>';
            item_pembelian += '</button>';
            item_pembelian += '<button style="margin-left:5px" type="button" class="btn btn-danger" onclick="removeBan(' +
                key + ')">';
            item_pembelian += '<i class="fas fa-trash"></i>';
            item_pembelian += '</button>';
            item_pembelian += '</td>';
            item_pembelian += '</tr>';

            $('#tabel-pembelian').append(item_pembelian);

            if (value !== null) {
                $('#barang_id-' + key).val(value.barang_id);
                $('#kode_barang-' + key).val(value.kode_barang);
                $('#nama_barang-' + key).val(value.nama_barang);
                $('#jumlah-' + key).val(value.jumlah);
            }
        }
    </script>

    <script>
        function showCategoryModalspk(selectedCategory) {
            $('#tablepenawaran').modal('show');
        }

        function getSelectedDatapelanggan(Id, Kategori, NoNpwp, pelanggan_id, kodePelanggan, namaPelanggan, Telp, Alamat,
            Merek_id,
            Nama_merek, Tipe, KodeKaroseri_id, KodeType, Namakaroseri, Panjang, Lebar, Tinggi, Spesifikasi, Aksesoris, Harga
        ) {
            // Set the values in the form fields
            document.getElementById('perintah_kerja_id').value = Id;
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
@endsection
