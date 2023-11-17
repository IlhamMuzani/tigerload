@extends('layouts.app')

@section('title', 'Faktur Pelunasan')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Faktur Pelunasan</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('admin/pelunasan') }}">Faktur Pelunasan</a></li>
                    <li class="breadcrumb-item active">Tambah</li>
                </ol>
            </div>
        </div>
    </div>
</div>


<section class="content">
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
        <form action="{{ url('admin/pelunasan') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
            @csrf
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tambah</h3>
                </div>
                <div class="card-body">

                    <div class="mb-3 mt-4">
                        <button class="btn btn-primary btn-sm" type="button" onclick="showPenjualan(this.value)">
                            <i class="fas fa-plus mr-2"></i> Pilih Penjualan
                        </button>
                    </div>

                    <div class="form-group" hidden>
                        <label for="nopol">Id Penjualan</label>
                        <input type="text" class="form-control" id="penjualan_id" name="penjualan_id"
                            value="{{ old('penjualan_id') }}" readonly placeholder="" value="">
                    </div>
                    <div class="form-group">
                        <label for="nopol">Kode Penjualan</label>
                        <input type="text" class="form-control" id="kode_penjualan" readonly placeholder="" value="">
                    </div>
                    <div class="form-group">
                        <label for="nopol">Nama Pelanggan</label>
                        <input type="text" class="form-control" id="nama_pelanggan" readonly placeholder="" value="">
                    </div>
                    <div class="form-group">
                        <label for="nama">Tanggal Penjualan</label>
                        <input type="text" class="form-control" id="tanggal" readonly placeholder="" value="">
                    </div>
                    <div class="form-group">
                        <label for="nama">Total</label>
                        <input type="text" class="form-control" id="total" readonly placeholder="" value="">
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Rincian Pembayaran <span>
                        </span></h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <tbody id="tabel-pembelian">
                            <tr id="pembelian-0">
                                <td hidden>
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="barang_id-0" name="barang_id[]">
                                    </div>
                                </td>
                                <td>
                                    <p style="margin-bottom:5px">Potongan Penjualan :</p>
                                    <div class="form-group" style="width: 140px">
                                        <input type="text" class="form-control" id="barang_id-0" name="barang_id[]"
                                            style="height: 25px;">
                                    </div>
                                    <p style="margin-bottom:5px">Pembayaran</p>
                                    <table>
                                        <td>
                                            <p style="font-weight:bold; margin-left:4px">Bilyet Giro(BG)/Cek</p>
                                            <div class="row">
                                                <div class="form-group" style="width: 100px;">
                                                    <p style="margin-left: 14px;">No. BG/Cek</p>
                                                </div>
                                                <div class="form-group" style="width: 120px;">
                                                    <input type="text" class="form-control" id="barang_id-0"
                                                        name="barang_id[]" style="height: 25px;">
                                                </div>
                                            </div>
                                            <div class="row" style="margin-bottom:0px">
                                                <div class="form-group" style="width: 100px;;">
                                                    <p style="margin-left: 14px; ">Tanggal</p>
                                                </div>
                                                <div class="form-group" style="width: 120px;">
                                                    <input type="text" class="form-control" id="barang_id-0"
                                                        name="barang_id[]" style="height: 25px;">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group" style="width: 100px;">
                                                    <p style="margin-left: 14px; ">Nominal</p>
                                                </div>
                                                <div class="form-group" style="width: 120px;">
                                                    <input type="text" class="form-control" id="barang_id-0"
                                                        name="barang_id[]" style="height: 25px;">
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p style="font-weight:bold; margin-left:4px">Transfer</p>
                                            <div class="row">
                                                <div class="form-group" style="width: 100px;">
                                                    <p style="margin-left: 14px;">No. Transfer</p>
                                                </div>
                                                <div class="form-group" style="width: 120px;">
                                                    <input type="text" class="form-control" id="barang_id-0"
                                                        name="barang_id[]" style="height: 25px;">
                                                </div>
                                            </div>
                                            <div class="row" style="margin-bottom:0px">
                                                <div class="form-group" style="width: 100px;;">
                                                    <p style="margin-left: 14px; ">Tanggal</p>
                                                </div>
                                                <div class="form-group" style="width: 120px;">
                                                    <input type="text" class="form-control" id="barang_id-0"
                                                        name="barang_id[]" style="height: 25px;">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group" style="width: 100px;">
                                                    <p style="margin-left: 14px; ">Nominal</p>
                                                </div>
                                                <div class="form-group" style="width: 120px;">
                                                    <input type="text" class="form-control" id="barang_id-0"
                                                        name="barang_id[]" style="height: 25px;">
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p style="font-weight:bold; margin-left:4px">Tunai</p>
                                            <div class="row">
                                                <div class="form-group" style="width: 100px;">
                                                    <p style="margin-left: 14px;">Nominal</p>
                                                </div>
                                                <div class="form-group" style="width: 120px;">
                                                    <input type="text" class="form-control" id="barang_id-0"
                                                        name="barang_id[]" style="height: 25px;">
                                                </div>
                                            </div>
                                            <div class="row" style="margin-bottom:0px">
                                                <div class="form-group" style="width: 100px;;">
                                                    <p style="margin-left: 14px; ">Tanggal</p>
                                                </div>
                                                <div class="form-group" style="width: 120px;">
                                                    <input type="text" class="form-control" id="barang_id-0"
                                                        name="barang_id[]" style="height: 25px;">
                                                </div>
                                            </div>
                                            <div class="form-check" style="margin-left:140px; margin-top:30px">
                                                <input type="checkbox" name="nama" class="form-check-input"
                                                    id="exampleCheck1" onchange="updateNamaValue(this)">
                                                <label class="form-check-label" for="exampleCheck1">LUNAS</label>
                                            </div>
                                        </td>
                                        <td>
                                            <p style="font-weight:bold; margin-left:350px; color:white">.</p>
                                            <div class="row">
                                                <div class="form-group" style="width: 150px;">
                                                    <p style="margin-left: 50px; font-weight:bold">Total Tagihan</p>
                                                </div>
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="barang_id-0"
                                                        name="barang_id[]" style="height: 25px;">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group" style="width: 150px;">
                                                    <p style="margin-left: 20px;font-weight:bold">Total Pembayaran</p>
                                                </div>
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="barang_id-0"
                                                        name="barang_id[]" style="height: 25px;">
                                                </div>
                                            </div>
                                        </td>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer text-right">
                    <button type="reset" class="btn btn-secondary">Reset</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
        {{-- </div> --}}
    </div>

    <div class="modal fade" id="tablePenjualan" data-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Data Penjualan</h4>
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
                                    <th>Kode Penjualan</th>
                                    <th>Nama Pelanggan</th>
                                    <th>Tanggal</th>
                                    <th>Total</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($penjualans as $penjualan)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $penjualan->kode_penjualan }}</td>
                                    <td>{{ $penjualan->depositpemesanan->spk->pelanggan->nama_pelanggan }}</td>
                                    <td>{{ $penjualan->tanggal }}</td>
                                    <td>Rp
                                        {{ number_format($penjualan->depositpemesanan->spk->harga + $penjualan->detail_penjualan->where('penjualan_id', $penjualan->id)->sum('harga'), 0, ',', '.') }}
                                    </td>
                                    {{-- <td>{{ $penjualan->depositpemesanan->spk->detail_kendaraan->first()->merek->nama_merek }}
                                    </td>
                                    <td>{{ $penjualan->depositpemesanan->spk->detail_kendaraan->first()->merek->tipe->nama_tipe }}
                                    </td>
                                    <td>{{ $penjualan->depositpemesanan->spk->typekaroseri->kode_type }}</td> --}}
                                    <td class="text-center">
                                        <button type="button" class="btn btn-primary btn-sm" onclick="getSelectedData('{{ $penjualan->id }}',
                                                     '{{ $penjualan->kode_penjualan }}',
                                                     '{{ $penjualan->depositpemesanan->spk->pelanggan->nama_pelanggan }}',
                                                      '{{ $penjualan->tanggal }}',
                                                      '{{ number_format($penjualan->depositpemesanan->spk->harga + $penjualan->detail_penjualan->where('penjualan_id', $penjualan->id)->sum('harga'), 0, ',', '.') }}',
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
function updateNamaValue(checkbox) {
    var namaInput = document.querySelector('input[name="nama"]');

    if (checkbox.checked) {
        namaInput.value = 'LUNAS'; // Set the value when checked
    } else {
        namaInput.value = 'BELUM LUNAS'; // Clear the value when unchecked
    }
}


function showPenjualan(selectedCategory) {
    $('#tablePenjualan').modal('show');
}

function getSelectedData(Penjualan_id, KodePenjualan, NamaPelanggan, Tanggal, Total) {
    // Set the values in the form fields
    document.getElementById('penjualan_id').value = Penjualan_id;
    document.getElementById('kode_penjualan').value = KodePenjualan;
    document.getElementById('nama_pelanggan').value = NamaPelanggan;
    document.getElementById('tanggal').value = Tanggal;
    document.getElementById('total').value = Total;
    // Close the modal (if needed)
    $('#tablePenjualan').modal('hide');
}
</script>
@endsection