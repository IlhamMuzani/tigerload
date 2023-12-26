@extends('layouts.app')

@section('title', 'Perbarui Pembelian Ban')

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
                    <div class="form-group">
                        <label for="spk_id">Nomor SPK</label>
                        <select class="custom-select form-control" id="spk_id" name="spk_id" onchange="getData(0)">
                            <option value="">- Pilih Nomor SPK -</option>
                            @foreach ($spks as $spk)
                            <option value="{{ $spk->id }}"
                                {{ old('spk_id', $inquery->spk_id) == $spk->id ? 'selected' : '' }}>
                                {{ $spk->kode_spk }}
                            </option>
                            @endforeach
                        </select>
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
                                <th>id</th>
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
                                        <input type="text" class="form-control" id="id-0" name="detail_ids[]"
                                            value="{{ $detail['id'] }}">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="barang_id-{{ $loop->index }}"
                                            name="barang_id[]" value="{{ $detail['barang_id'] }}">
                                    </div>
                                </td>
                                <td>
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
                                        <input type="text" class="form-control" id="jumlah-0" name="jumlah[]"
                                            value="{{ $detail['jumlah'] }}">
                                    </div>
                                </td>
                                <td style="width: 120px">
                                    <button type="button" class="btn btn-primary" onclick="barang({{ $loop->index }})">
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
                    <table id="example1" class="table table-bordered table-striped">
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
                            <tr data-barang_id="{{ $barang->id }}" data-kode_barang="{{ $barang->kode_barang }}"
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
</section>
<script>
var activeSpecificationIndex = 0;

function barang(param) {
    activeSpecificationIndex = param;
    // Show the modal and filter rows if necessary
    $('#tableBarang').modal('show');
}

function getBarang(rowIndex) {
    var selectedRow = $('#example1 tbody tr:eq(' + rowIndex + ')');
    var barang_id = selectedRow.data('barang_id');
    var kode_barang = selectedRow.data('kode_barang');
    var nama_barang = selectedRow.data('nama_barang');

    // Update the form fields for the active specification
    $('#barang_id-' + activeSpecificationIndex).val(barang_id);
    $('#kode_barang-' + activeSpecificationIndex).val(kode_barang);
    $('#nama_barang-' + activeSpecificationIndex).val(nama_barang);

    $('#tableBarang').modal('hide');
}

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
    item_pembelian += '<td>';
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
@endsection