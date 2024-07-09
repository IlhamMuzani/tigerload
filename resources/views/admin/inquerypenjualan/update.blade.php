@extends('layouts.app')

@section('title', 'Inquery Penjualan')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Inquery Penjualan</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/inquery_penjualan') }}">Faktur Penjualan</a></li>
                        <li class="breadcrumb-item active">Tambah</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>


    <section class="content">
        <div class="container-fluid">
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
                <form action="{{ url('admin/inquery_penjualan/' . $penjualans->id) }}" method="POST"
                    enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    @method('put')
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
                                <label for="nopol">Id Deposit</label>
                                <input type="text" class="form-control" id="depositpemesanan_id"
                                    name="depositpemesanan_id" value="{{ $penjualans->depositpemesanan_id }}"
                                    readonly placeholder="" value="">
                            </div>
                            <div class="form-group" hidden>
                                <label for="nopol">Id SPK</label>
                                <input type="text" class="form-control" id="perintah_kerja_id" name="perintah_kerja_id"
                                    value="{{ $penjualans->perintah_kerja->id }}"
                                    readonly placeholder="" value="">
                            </div>
                            <div class="form-group">
                                <label for="nopol">Kode SPK</label>
                                <input type="text" class="form-control" id="kode_perintah" readonly placeholder=""
                                    value="{{ $penjualans->perintah_kerja->kode_perintah }}">
                            </div>
                            <div class="form-group">
                                <label for="nopol">Nama Pelanggan</label>
                                <input type="text" class="form-control" id="nama_pelanggan" readonly placeholder=""
                                    value="{{ $penjualans->perintah_kerja->spk->pelanggan->nama_pelanggan }}">
                            </div>
                            <div class="form-group">
                                <label for="nama">Merek Kendaraan</label>
                                <input type="text" class="form-control" id="merek" readonly placeholder=""
                                    value="{{ $penjualans->perintah_kerja->spk->typekaroseri->merek->nama_merek }}">
                            </div>
                            <div class="form-group">
                                <label for="nama">Type Kendaraan</label>
                                <input type="text" class="form-control" id="tipe" readonly placeholder=""
                                    value="{{ $penjualans->perintah_kerja->spk->typekaroseri->merek->tipe->nama_tipe }}">

                            </div>
                            <div class="form-group">
                                <label for="nama">Kode Karoseri</label>
                                <input type="text" class="form-control" id="kode_type"readonly placeholder=""
                                    value="{{ $penjualans->perintah_kerja->spk->typekaroseri->kode_type }}">

                            </div>
                            <div class="form-group">
                                <label for="nama">Bentuk Karoseri</label>
                                <input type="text" class="form-control" id="nama_karoseri" readonly placeholder=""
                                    value="{{ $penjualans->perintah_kerja->spk->typekaroseri->nama_karoseri }}">

                            </div>
                            <div class="form-group">
                                <label for="nama">Harga Pemesanan</label>
                                <input type="text" class="form-control" id="harga_awal" name="harga_awal" readonly
                                    placeholder="" value="{{ $penjualans->perintah_kerja->spk->harga }}">
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
                                        <th>Kode Barang</th>
                                        <th>Nama Barang</th>
                                        <th>Qty</th>
                                        <th>Harga</th>
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
                                                        id="nama-{{ $loop->index }}" name="nama[]"
                                                        value="{{ $detail['nama'] }}">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="jumlah-0"
                                                        name="jumlah[]" value="{{ $detail['jumlah'] }}">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="harga-0"
                                                        name="harga[]"
                                                        value="{{ number_format($detail['harga'], 0, ',', '.') }}"
                                                        oninput="formatRupiahform(this)"
                                                        onkeypress="return event.charCode >= 48 && event.charCode <= 57">
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
                        <div class="card-footer text-right">
                            <button type="reset" class="btn btn-secondary">Reset</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
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
                                    {{-- <th>Keterangan</th> --}}
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
                                        {{-- <td>{{ $barang->keterangan }}</td> --}}
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
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Data SPK</h4>
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

        function getSelectedData(Spk_id, KodeSPK, NamaPelanggan, Merek, Type, KodeKaroseri, BentukKaroseri, Harga, Dp_id) {
            // Set the values in the form fields
            document.getElementById('spk_id').value = Spk_id;
            document.getElementById('kode_spk').value = KodeSPK;
            document.getElementById('nama_pelanggan').value = NamaPelanggan;
            document.getElementById('merek').value = Merek;
            document.getElementById('tipe').value = Type;
            document.getElementById('kode_type').value = KodeKaroseri;
            document.getElementById('nama_karoseri').value = BentukKaroseri;
            document.getElementById('harga_awal').value = Harga;
            document.getElementById('depositpemesanan_id').value = Dp_id;
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
            var barang_id = selectedRow.data('barang_id');
            var kode_barang = selectedRow.data('kode_barang');
            var nama_barang = selectedRow.data('nama_barang');

            // Update the form fields for the active specification
            $('#barang_id-' + activeSpecificationIndex).val(barang_id);
            $('#kode_barang-' + activeSpecificationIndex).val(kode_barang);
            $('#nama-' + activeSpecificationIndex).val(nama_barang);

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
            var nama = '';
            var jumlah = '';
            var harga = '';

            if (value !== null) {
                barang_id = value.barang_id;
                nama = value.nama;
                kode_barang = value.kode_barang;
                jumlah = value.jumlah;
                harga = value.harga;
            }

            // urutan 
            var item_pembelian = '<tr id="pembelian-' + key + '">';
            item_pembelian += '<td class="text-center" id="urutan">' + key + '</td>';

            // barang_id 
            item_pembelian += '<td hidden>';
            item_pembelian += '<div class="form-group" >'
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

            // nama 
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" readonly id="nama-' + key +
                '" name="nama[]" value="' + nama + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // jumlah
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control jumlah" id="jumlah-' + key +
                '" name="jumlah[]" value="' + jumlah + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // kode_barang 
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" id="harga-' + key +
                '" name="harga[]" value="' + harga + '" ';
            item_pembelian += 'oninput="formatRupiahform(this)" ';
            item_pembelian += 'onkeypress="return event.charCode >= 48 && event.charCode <= 57">'
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
@endsection
