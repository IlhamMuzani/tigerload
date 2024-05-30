@extends('layouts.app')

@section('title', 'Perbarui Pembelian')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Perbarui Pembelian</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('admin/pembelian_ban') }}">Transaksi</a></li>
                    <li class="breadcrumb-item active">Perbarui Pembelian ban</li>
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
        <form action="{{ url('admin/inquery_pembelian/' . $inquery->id) }}" method="post" autocomplete="off">
            @csrf
            @method('put')
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Detail Supplier</h3>
                    <div class="float-right">
                        <button type="button" data-toggle="modal" data-target="#modal-supplier"
                            class="btn btn-primary btn-sm">
                            Tambah
                        </button>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="form-group">
                        <label for="supplier_id">Nama Supplier</label>
                        <select class="select2bs4 select2-hidden-accessible" name="supplier_id"
                            data-placeholder="Cari Supplier.." style="width: 100%;" tabindex="-1" aria-hidden="true"
                            id="supplier_id" onchange="getData(0)">
                            <option value="">- Pilih -</option>
                            @foreach ($suppliers as $supplier)
                            <option value="{{ $supplier->id }}"
                                {{ old('supplier_id', $inquery->supplier_id) == $supplier->id ? 'selected' : '' }}>
                                {{ $supplier->nama_supp }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <textarea type="text" class="form-control" readonly id="alamat" name="alamat"
                            placeholder="Masukan alamat"
                            value="">{{ old('alamat', $inquery->supplier->alamat) }}</textarea>
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
                                <th>Satuan</th>
                                <th>Jumlah</th>
                                <th>Harga</th>
                                <th>Diskon</th>
                                <th>Total</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody id="tabel-pembelian">
                            @foreach ($details as $detail)
                            <tr id="pembelian-{{ $loop->index }}">
                                <td style="width: 70px; font-size:14px" class="text-center" id="urutan">
                                    {{ $loop->index + 1 }}
                                </td>
                                <div class="form-group" hidden>
                                    <input type="text" class="form-control" id="nomor_seri-{{ $loop->index }}"
                                        name="detail_ids[]" value="{{ $detail['id'] }}">
                                </div>
                                <td>
                                    <@extends('layouts.app') @section('title', 'Perbarui Pembelian' )
                                        @section('content') <!-- Content Header (Page header) -->
                                        <div class="content-header">
                                            <div class="container-fluid">
                                                <div class="row mb-2">
                                                    <div class="col-sm-6">
                                                        <h1 class="m-0">Perbarui Pembelian</h1>
                                                    </div><!-- /.col -->
                                                    <div class="col-sm-6">
                                                        <ol class="breadcrumb float-sm-right">
                                                            <li class="breadcrumb-item"><a
                                                                    href="{{ url('admin/pembelian_ban') }}">Transaksi</a>
                                                            </li>
                                                            <li class="breadcrumb-item active">Perbarui Pembelian ban
                                                            </li>
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
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-hidden="true">&times;</button>
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
                                                <form action="{{ url('admin/inquery_pembelian/' . $inquery->id) }}"
                                                    method="post" autocomplete="off">
                                                    @csrf
                                                    @method('put')
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h3 class="card-title">Detail Supplier</h3>
                                                            <div class="float-right">
                                                                <button type="button" data-toggle="modal"
                                                                    data-target="#modal-supplier"
                                                                    class="btn btn-primary btn-sm">
                                                                    Tambah
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <!-- /.card-header -->
                                                        <div class="card-body">
                                                            <div class="form-group">
                                                                <label for="supplier_id">Nama Supplier</label>
                                                                <select class="select2bs4 select2-hidden-accessible"
                                                                    name="supplier_id"
                                                                    data-placeholder="Cari Supplier.."
                                                                    style="width: 100%;" tabindex="-1"
                                                                    aria-hidden="true" id="supplier_id"
                                                                    onchange="getData(0)">
                                                                    <option value="">- Pilih -</option>
                                                                    @foreach ($suppliers as $supplier)
                                                                    <option value="{{ $supplier->id }}"
                                                                        {{ old('supplier_id', $inquery->supplier_id) == $supplier->id ? 'selected' : '' }}>
                                                                        {{ $supplier->nama_supp }}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="alamat">Alamat</label>
                                                                <textarea type="text" class="form-control" readonly
                                                                    id="alamat" name="alamat"
                                                                    placeholder="Masukan alamat"
                                                                    value="">{{ old('alamat', $inquery->supplier->alamat) }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h3 class="card-title">Tambah Barang</h3>
                                                            <div class="float-right">
                                                                <button type="button" class="btn btn-primary btn-sm"
                                                                    onclick="addPesanan()">
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
                                                                        <th>Satuan</th>
                                                                        <th>Jumlah</th>
                                                                        <th>Harga</th>
                                                                        <th>Diskon</th>
                                                                        <th>Total</th>
                                                                        <th>Opsi</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="tabel-pembelian">
                                                                    @foreach ($details as $detail)
                                                                    <tr id="pembelian-{{ $loop->index }}">
                                                                        <td style="width: 70px; font-size:14px"
                                                                            class="text-center" id="urutan">
                                                                            {{ $loop->index + 1 }}
                                                                        </td>
                                                                        <div class="form-group" hidden>
                                                                            <input type="text" class="form-control"
                                                                                id="nomor_seri-{{ $loop->index }}"
                                                                                name="detail_ids[]"
                                                                                value="{{ $detail['id'] }}">
                                                                        </div>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input type="text" class="form-control"
                                                                                    id="barang_id-{{ $loop->index }}"
                                                                                    name="barang_id[]"
                                                                                    value="{{ $detail['barang_id'] }}">
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input type="text" class="form-control"
                                                                                    readonly
                                                                                    id="kode_barang-{{ $loop->index }}"
                                                                                    name="kode_barang[]"
                                                                                    value="{{ $detail['kode_barang'] }}">
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input type="text" class="form-control"
                                                                                    readonly
                                                                                    id="nama_barang-{{ $loop->index }}"
                                                                                    name="nama_barang[]"
                                                                                    value="{{ $detail['nama_barang'] }}">
                                                                            </div>
                                                                        </td>
                                                                        <td style="width: 150px">
                                                                            <div class="form-group">
                                                                                <select class="form-control"
                                                                                    id="satuan-0" name="satuan[]">
                                                                                    <option value="">- Pilih -</option>
                                                                                    <option value="M3"
                                                                                        {{ old('satuan', $detail['satuan']) == 'M3' ? 'selected' : null }}>
                                                                                        M&sup3;</option>
                                                                                    <option value="ton"
                                                                                        {{ old('satuan', $detail['satuan']) == 'ton' ? 'selected' : null }}>
                                                                                        ton</option>
                                                                                    <option value="krtn"
                                                                                        {{ old('satuan', $detail['satuan']) == 'krtn' ? 'selected' : null }}>
                                                                                        krtn</option>
                                                                                    <option value="dus"
                                                                                        {{ old('satuan', $detail['satuan']) == 'dus' ? 'selected' : null }}>
                                                                                        dus</option>
                                                                                    <option value="rit"
                                                                                        {{ old('satuan', $detail['satuan']) == 'rit' ? 'selected' : null }}>
                                                                                        rit</option>
                                                                                    <option value="kg"
                                                                                        {{ old('satuan', $detail['satuan']) == 'kg' ? 'selected' : null }}>
                                                                                        kg</option>
                                                                                    <option value="ltr"
                                                                                        {{ old('satuan', $detail['satuan']) == 'ltr' ? 'selected' : null }}>
                                                                                        ltr</option>
                                                                                    <option value="pcs"
                                                                                        {{ old('satuan', $detail['satuan']) == 'pcs' ? 'selected' : null }}>
                                                                                        pcs</option>
                                                                                    <option value="hr"
                                                                                        {{ old('satuan', $detail['satuan']) == 'hr' ? 'selected' : null }}>
                                                                                        hr</option>
                                                                                    <option value="ZAK"
                                                                                        {{ old('satuan', $detail['satuan']) == 'ZAK' ? 'selected' : null }}>
                                                                                        ZAK</option>
                                                                                </select>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input type="number"
                                                                                    class="form-control jumlah"
                                                                                    id="jumlah-0" name="jumlah[]"
                                                                                    data-row-id="0"
                                                                                    value="{{ $detail['jumlah'] }}">
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input type="number"
                                                                                    class="form-control harga"
                                                                                    id="harga-0" name="harga[]"
                                                                                    data-row-id="0"
                                                                                    value="{{ $detail['harga'] }}">
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input type="number"
                                                                                    class="form-control diskon"
                                                                                    id="diskon-0" name="diskon[]"
                                                                                    data-row-id="0"
                                                                                    value="{{ $detail['diskon'] }}">
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input type="text"
                                                                                    class="form-control total"
                                                                                    id="total-0" name="total[]"
                                                                                    value="{{ $detail['total'] }}">
                                                                            </div>
                                                                        </td>
                                                                        <td style="width: 120px">
                                                                            <button type="button"
                                                                                class="btn btn-primary"
                                                                                onclick="barang({{ $loop->index }})">
                                                                                <i class="fas fa-plus"></i>
                                                                            </button>
                                                                            <button style="margin-left:5px"
                                                                                type="button" class="btn btn-danger"
                                                                                onclick="removeBan({{ $loop->index }}, {{ $detail['id'] }})">
                                                                                <i class="fas fa-trash"></i>
                                                                            </button>
                                                                        </td>
                                                                    </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                            <div class="form-group">
                                                                <label style="font-size:14px" class="mt-3"
                                                                    for="nopol">Grand Total</label>
                                                                <input style="font-size:14px" type="text"
                                                                    class="form-control text-right" id="grand_total"
                                                                    name="grand_total" readonly placeholder=""
                                                                    value="{{ $inquery->grand_total }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-footer text-right">
                                                        <button type="reset" class="btn btn-secondary">Reset</button>
                                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                                    </div>
                                                </form>

                                            </div>
                                            <div class="modal fade" id="modal-supplier">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Tambah Supplier</h4>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div style="text-align: center;">
                                                                <form action="{{ url('admin/tambah_supplier') }}"
                                                                    method="POST" enctype="multipart/form-data"
                                                                    autocomplete="off">
                                                                    @csrf
                                                                    <div class="card">
                                                                        <div class="card-header">
                                                                            <h3 class="card-title">Tambah Supplier</h3>
                                                                        </div>
                                                                        <div class="card-body">
                                                                            <div class="form-group">
                                                                                <label for="nama">Nama Supplier</label>
                                                                                <input type="text" class="form-control"
                                                                                    id="nama_supp" name="nama_supp"
                                                                                    placeholder="Masukan nama supplier"
                                                                                    value="{{ old('nama_supp') }}">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="alamat">Alamat</label>
                                                                                <textarea type="text"
                                                                                    class="form-control" id="alamat"
                                                                                    name="alamat"
                                                                                    placeholder="Masukan alamat">{{ old('alamat') }}</textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    {{-- div diatas ini --}}

                                                                    <div class="card">
                                                                        <div class="card-header">
                                                                            <h3 class="card-title">Kotak Person</h3>
                                                                        </div>
                                                                        <!-- /.card-header -->
                                                                        <div class="card-body">
                                                                            <div class="form-group">
                                                                                <label for="nama">Nama</label>
                                                                                <input type="text" class="form-control"
                                                                                    id="nama_person" name="nama_person"
                                                                                    placeholder="Masukan nama"
                                                                                    value="{{ old('nama_person') }}">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="nama">Jabatan</label>
                                                                                <input type="text" class="form-control"
                                                                                    id="jabatan" name="jabatan"
                                                                                    placeholder="Masukan jabatan"
                                                                                    value="{{ old('jabatan') }}">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="nama">No. Telepon</label>
                                                                                <input type="number"
                                                                                    class="form-control" id="telp"
                                                                                    name="telp"
                                                                                    placeholder="Masukan no telepon"
                                                                                    value="{{ old('telp') }}">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="nama">Fax</label>
                                                                                <input type="number"
                                                                                    class="form-control" id="fax"
                                                                                    name="fax"
                                                                                    placeholder="Masukan no fax"
                                                                                    value="{{ old('fax') }}">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="telp">Hp</label>
                                                                                <div class="input-group mb-3">
                                                                                    <div class="input-group-prepend">
                                                                                        <span
                                                                                            class="input-group-text">+62</span>
                                                                                    </div>
                                                                                    <input type="number" id="hp"
                                                                                        name="hp" class="form-control"
                                                                                        placeholder="Masukan nomor hp"
                                                                                        value="{{ old('hp') }}">
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="nama">Email</label>
                                                                                <input type="text" class="form-control"
                                                                                    id="email" name="email"
                                                                                    placeholder="Masukan email"
                                                                                    value="{{ old('email') }}">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="nama">No. NPWP</label>
                                                                                <input type="text" class="form-control"
                                                                                    id="npwp" name="npwp"
                                                                                    placeholder="Masukan no npwp"
                                                                                    value="{{ old('npwp') }}">
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="card">
                                                                        <div class="card-header">
                                                                            <h3 class="card-title">Informasi Bank</h3>
                                                                        </div>
                                                                        <!-- /.card-header -->
                                                                        <div class="card-body">
                                                                            <div class="mb-3">
                                                                                <label class="form-label"
                                                                                    for="nama_bank">Nama Bank</label>
                                                                                <select class="form-control"
                                                                                    id="nama_bank" name="nama_bank">
                                                                                    <option value="">- Pilih -</option>
                                                                                    <option value="BRI"
                                                                                        {{ old('nama_bank') == 'BRI' ? 'selected' : null }}>
                                                                                        BRI</option>
                                                                                    <option value="MANDIRI"
                                                                                        {{ old('nama_bank') == 'MANDIRI' ? 'selected' : null }}>
                                                                                        MANDIRI</option>
                                                                                    <option value="BNI"
                                                                                        {{ old('nama_bank') == 'BNI' ? 'selected' : null }}>
                                                                                        BNI</option>
                                                                                    <option value="BTN"
                                                                                        {{ old('nama_bank') == 'BTN' ? 'selected' : null }}>
                                                                                        BTN</option>
                                                                                    <option value="DANAMON"
                                                                                        {{ old('nama_bank') == 'DANAMON' ? 'selected' : null }}>
                                                                                        DANAMON</option>
                                                                                    <option value="BCA"
                                                                                        {{ old('nama_bank') == 'BCA' ? 'selected' : null }}>
                                                                                        BCA</option>
                                                                                    <option value="PERMATA"
                                                                                        {{ old('nama_bank') == 'PERMATA' ? 'selected' : null }}>
                                                                                        PERMATA</option>
                                                                                    <option value="PAN"
                                                                                        {{ old('nama_bank') == 'PAN' ? 'selected' : null }}>
                                                                                        PAN</option>
                                                                                    <option value="CIMB NIAGA"
                                                                                        {{ old('nama_bank') == 'CIMB NIAGA' ? 'selected' : null }}>
                                                                                        CIMB NIAGA</option>
                                                                                    <option value="UOB"
                                                                                        {{ old('nama_bank') == 'UOB' ? 'selected' : null }}>
                                                                                        UOB</option>
                                                                                    <option value="ARTHA GRAHA"
                                                                                        {{ old('nama_bank') == 'ARTHA GRAHA' ? 'selected' : null }}>
                                                                                        ARTHA GRAHA</option>
                                                                                    <option value="BUMI ARTHA"
                                                                                        {{ old('nama_bank') == 'BUMI ARTHA' ? 'selected' : null }}>
                                                                                        BUMI ARTHA</option>
                                                                                    <option value="MEGA"
                                                                                        {{ old('nama_bank') == 'MEGA' ? 'selected' : null }}>
                                                                                        MEGA</option>
                                                                                    <option value="SYARIAH"
                                                                                        {{ old('nama_bank') == 'SYARIAH' ? 'selected' : null }}>
                                                                                        SYARIAH</option>
                                                                                    <option value="MEGA SYARIAH"
                                                                                        {{ old('nama_bank') == 'MEGA SYARIAH' ? 'selected' : null }}>
                                                                                        MEGA SYARIAH</option>
                                                                                </select>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="atas_nama">Atas nama</label>
                                                                                <input type="text" class="form-control"
                                                                                    id="atas_nama" name="atas_nama"
                                                                                    placeholder="Masukan atas nama"
                                                                                    value="{{ old('atas_nama') }}">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="norek">No. Rekening</label>
                                                                                <input type="number"
                                                                                    class="form-control" id="norek"
                                                                                    name="norek"
                                                                                    placeholder="Masukan no rekening"
                                                                                    value="{{ old('norek') }}">
                                                                            </div>
                                                                        </div>
                                                                        <div class="card-footer text-right">
                                                                            <button type="reset"
                                                                                class="btn btn-secondary">Reset</button>
                                                                            <button type="submit"
                                                                                class="btn btn-primary">Simpan</button>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal fade" id="tableBarang" data-backdrop="static">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Data Barang</h4>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <table id="example1"
                                                                class="table table-bordered table-striped">
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
                                                                        data-nama_barang="{{ $barang->nama_barang }}"
                                                                        data-param="{{ $loop->index }}">
                                                                        <td class="text-center">{{ $loop->iteration }}
                                                                        </td>
                                                                        <td>{{ $barang->kode_barang }}</td>
                                                                        <td>{{ $barang->nama_barang }}</td>
                                                                        <td>{{ $barang->spesifikasi }}</td>
                                                                        <td>{{ $barang->keterangan }}</td>
                                                                        <td class="text-center">
                                                                            <button type="button" id="btnTambah"
                                                                                class="btn btn-primary btn-sm"
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
                                        function getData(id) {
                                            var supplier_id = document.getElementById('supplier_id');
                                            $.ajax({
                                                url: "{{ url('admin/pembelian/supplier') }}" + "/" + supplier_id
                                                    .value,
                                                type: "GET",
                                                dataType: "json",
                                                success: function(supplier_id) {
                                                    var alamat = document.getElementById('alamat');
                                                    alamat.value = supplier_id.alamat;
                                                },
                                            });
                                        }
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

                                        $(document).on("input", ".harga, .jumlah, .diskon", function() {
                                            var currentRow = $(this).closest('tr');
                                            var harga = parseFloat(currentRow.find(".harga").val()) || 0;
                                            var jumlah = parseFloat(currentRow.find(".jumlah").val()) || 0;
                                            var diskon = parseFloat(currentRow.find(".diskon").val()) || 0;
                                            var total = harga * jumlah - diskon;
                                            currentRow.find(".total").val(total);

                                            updateGrandTotal()

                                        });

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
                                            updateUrutans();
                                        }

                                        function updateUrutans() {
                                            var urutan = document.querySelectorAll('#urutan');
                                            for (let i = 0; i < urutan.length; i++) {
                                                urutan[i].innerText = i + 1;
                                            }
                                        }

                                        function removeBan(identifier) {
                                            var row = $('#pembelian-' + identifier);
                                            var detailId = row.find("input[name='detail_ids[]']").val();

                                            row.remove();

                                            if (detailId) {
                                                $.ajax({
                                                    url: "{{ url('admin/inquery_pembelian/deletebarangs/') }}/" +
                                                        detailId,
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
                                            updateGrandTotal();
                                            updateUrutans();
                                        }

                                        function itemPembelian(identifier, key, value = null) {
                                            var barang_id = '';
                                            var kode_barang = '';
                                            var nama_barang = '';
                                            var satuan = '';
                                            var jumlah = '';
                                            var harga = '';
                                            var diskon = '';
                                            var total = '';

                                            if (value !== null) {
                                                barang_id = value.barang_id;
                                                kode_barang = value.kode_barang;
                                                nama_barang = value.nama_barang;
                                                satuan = value.satuan;
                                                jumlah = value.jumlah;
                                                harga = value.harga;
                                                diskon = value.diskon;
                                                total = value.total;
                                            }

                                            // urutan 
                                            var item_pembelian = '<tr id="pembelian-' + key + '">';
                                            item_pembelian += '<td class="text-center" id="urutan">' + key + '</td>';

                                            // barang_id 
                                            item_pembelian += '<td>';
                                            item_pembelian += '<div class="form-group">'
                                            item_pembelian += '<input type="text" class="form-control" id="barang_id-' +
                                                key +
                                                '" name="barang_id[]" value="' + barang_id + '" ';
                                            item_pembelian += '</div>';
                                            item_pembelian += '</td>';

                                            // kode_barang 
                                            item_pembelian += '<td>';
                                            item_pembelian += '<div class="form-group">'
                                            item_pembelian +=
                                                '<input type="text" class="form-control" readonly id="kode_barang-' +
                                                key +
                                                '" name="kode_barang[]" value="' + kode_barang + '" ';
                                            item_pembelian += '</div>';
                                            item_pembelian += '</td>';

                                            // nama_barang 
                                            item_pembelian += '<td>';
                                            item_pembelian += '<div class="form-group">'
                                            item_pembelian +=
                                                '<input type="text" class="form-control" readonly id="nama_barang-' +
                                                key +
                                                '" name="nama_barang[]" value="' + nama_barang + '" ';
                                            item_pembelian += '</div>';
                                            item_pembelian += '</td>';

                                            // satuan 
                                            item_pembelian += '<td>';
                                            item_pembelian += '<div class="form-group">';
                                            item_pembelian +=
                                                '<select style="font-size:14px" class="form-control" id="satuan-' +
                                                key +
                                                '" name="satuan[]">';
                                            item_pembelian += '<option value="">- Pilih -</option>';
                                            item_pembelian += '<option value="M3"' + (satuan === 'M3' ? ' selected' :
                                                    '') +
                                                '>M&sup3;</option>';
                                            item_pembelian += '<option value="ton"' + (satuan === 'ton' ? ' selected' :
                                                    '') +
                                                '>ton</option>';
                                            item_pembelian += '<option value="krtn"' + (satuan === 'krtn' ?
                                                    ' selected' : '') +
                                                '>krtn</option>';
                                            item_pembelian += '<option value="dus"' + (satuan === 'dus' ? ' selected' :
                                                    '') +
                                                '>dus</option>';
                                            item_pembelian += '<option value="rit"' + (satuan === 'rit' ? ' selected' :
                                                    '') +
                                                '>rit</option>';
                                            item_pembelian += '<option value="kg"' + (satuan === 'kg' ? ' selected' :
                                                    '') +
                                                '>kg</option>';
                                            item_pembelian += '<option value="ltr"' + (satuan === 'ltr' ? ' selected' :
                                                    '') +
                                                '>ltr</option>';
                                            item_pembelian += '<option value="pcs"' + (satuan === 'pcs' ? ' selected' :
                                                '') + '>pcs</option>';
                                            item_pembelian += '<option value="hr"' + (satuan === 'hr' ? ' selected' :
                                                    '') +
                                                '>hr</option>';
                                            item_pembelian += '<option value="ZAK"' + (satuan === 'ZAK' ? ' selected' :
                                                    '') +
                                                '>ZAK</option>';
                                            item_pembelian += '</select>';
                                            item_pembelian += '</div>';
                                            item_pembelian += '</td>';

                                            // jumlah
                                            item_pembelian += '<td>';
                                            item_pembelian += '<div class="form-group">'
                                            item_pembelian +=
                                                '<input type="text" class="form-control jumlah" id="jumlah-' + key +
                                                '" name="jumlah[]" value="' + jumlah + '" ';
                                            item_pembelian += '</div>';
                                            item_pembelian += '</td>';

                                            // harga
                                            item_pembelian += '<td>';
                                            item_pembelian += '<div class="form-group">'
                                            item_pembelian +=
                                                '<input type="number" class="form-control harga" id="harga-' + key +
                                                '" name="harga[]" value="' + harga + '" ';
                                            item_pembelian += '</div>';
                                            item_pembelian += '</td>';

                                            // diskon
                                            item_pembelian += '<td>';
                                            item_pembelian += '<div class="form-group">'
                                            item_pembelian +=
                                                '<input type="text" class="form-control diskon" id="diskon-' + key +
                                                '" name="diskon[]" value="' + diskon + '" ';
                                            item_pembelian += '</div>';
                                            item_pembelian += '</td>';

                                            // total
                                            item_pembelian += '<td>';
                                            item_pembelian += '<div class="form-group">'
                                            item_pembelian +=
                                                '<input type="number" class="form-control total" id="total-' + key +
                                                '" name="total[]" value="' + total + '" readonly';
                                            item_pembelian += '</div>';
                                            item_pembelian += '</td>';
                                            item_pembelian += '<td style="width: 120px">';
                                            item_pembelian +=
                                                '<button type="button" class="btn btn-primary" onclick="barang(' + key +
                                                ')">';
                                            item_pembelian += '<i class="fas fa-plus"></i>';
                                            item_pembelian += '</button>';
                                            item_pembelian +=
                                                '<button style="margin-left:5px" type="button" class="btn btn-danger" onclick="removeBan(' +
                                                key + ')">';
                                            item_pembelian += '<i class="fas fa-trash"></i>';
                                            item_pembelian += '</button>';
                                            item_pembelian += '</td>';
                                            item_pembelian += '</tr>';

                                            $('#tabel-pembelian').append(item_pembelian);
                                        }
                                        </script>

                                        <script>
                                        function updateGrandTotal() {
                                            var grandTotal = 0;

                                            // Loop through all elements with name "total[]"
                                            $('input[name^="total"]').each(function() {
                                                var nominalValue = parseFloat($(this).val().replace(/\./g, '')
                                                    .replace(',', '.')) || 0;
                                                grandTotal += nominalValue;
                                            });
                                            // $('#sub_total').val(grandTotal.toLocaleString('id-ID'));
                                            // $('#pph2').val(pph2Value.toLocaleString('id-ID'));
                                            $('#grand_total').val(formatRupiahsss(grandTotal));
                                        }

                                        $('body').on('input', 'input[name^="total"]', function() {
                                            updateGrandTotal();
                                        });

                                        // Panggil fungsi saat halaman dimuat untuk menginisialisasi grand total
                                        $(document).ready(function() {
                                            updateGrandTotal();
                                        });

                                        function formatRupiahsss(number) {
                                            var formatted = new Intl.NumberFormat('id-ID', {
                                                minimumFractionDigits: 1,
                                                maximumFractionDigits: 1
                                            }).format(number);
                                            return '' + formatted;
                                        }
                                        </script>
                                        @endsection
                                        div class="form-group">
                                        <input type="text" class="form-control" id="barang_id-{{ $loop->index }}"
                                            name="barang_id[]" value="{{ $detail['barang_id'] }}">
                </div>
                </td>
                <td>
                    <div class="form-group">
                        <input type="text" class="form-control" readonly id="kode_barang-{{ $loop->index }}"
                            name="kode_barang[]" value="{{ $detail['kode_barang'] }}">
                    </div>
                </td>
                <td>
                    <div class="form-group">
                        <input type="text" class="form-control" readonly id="nama_barang-{{ $loop->index }}"
                            name="nama_barang[]" value="{{ $detail['nama_barang'] }}">
                    </div>
                </td>
                <td style="width: 150px">
                    <div class="form-group">
                        <select class="form-control" id="satuan-0" name="satuan[]">
                            <option value="">- Pilih -</option>
                            <option value="M3" {{ old('satuan', $detail['satuan']) == 'M3' ? 'selected' : null }}>
                                M&sup3;</option>
                            <option value="ton" {{ old('satuan', $detail['satuan']) == 'ton' ? 'selected' : null }}>
                                ton</option>
                            <option value="krtn" {{ old('satuan', $detail['satuan']) == 'krtn' ? 'selected' : null }}>
                                krtn</option>
                            <option value="dus" {{ old('satuan', $detail['satuan']) == 'dus' ? 'selected' : null }}>
                                dus</option>
                            <option value="rit" {{ old('satuan', $detail['satuan']) == 'rit' ? 'selected' : null }}>
                                rit</option>
                            <option value="kg" {{ old('satuan', $detail['satuan']) == 'kg' ? 'selected' : null }}>
                                kg</option>
                            <option value="ltr" {{ old('satuan', $detail['satuan']) == 'ltr' ? 'selected' : null }}>
                                ltr</option>
                            <option value="pcs" {{ old('satuan', $detail['satuan']) == 'pcs' ? 'selected' : null }}>
                                pcs</option>
                            <option value="hr" {{ old('satuan', $detail['satuan']) == 'hr' ? 'selected' : null }}>
                                hr</option>
                            <option value="ZAK" {{ old('satuan', $detail['satuan']) == 'ZAK' ? 'selected' : null }}>
                                ZAK</option>
                        </select>
                    </div>
                </td>
                <td>
                    <div class="form-group">
                        <input type="number" class="form-control jumlah" id="jumlah-0" name="jumlah[]" data-row-id="0"
                            value="{{ $detail['jumlah'] }}">
                    </div>
                </td>
                <td>
                    <div class="form-group">
                        <input type="number" class="form-control harga" id="harga-0" name="harga[]" data-row-id="0"
                            value="{{ $detail['harga'] }}">
                    </div>
                </td>
                <td>
                    <div class="form-group">
                        <input type="number" class="form-control diskon" id="diskon-0" name="diskon[]" data-row-id="0"
                            value="{{ $detail['diskon'] }}">
                    </div>
                </td>
                <td>
                    <div class="form-group">
                        <input type="text" class="form-control total" id="total-0" name="total[]"
                            value="{{ $detail['total'] }}">
                    </div>
                </td>
                <td style="width: 120px">
                    <button type="button" class="btn btn-primary" onclick="barang({{ $loop->index }})">
                        <i class="fas fa-plus"></i>
                    </button>
                    <button style="margin-left:5px" type="button" class="btn btn-danger"
                        onclick="removeBan({{ $loop->index }}, {{ $detail['id'] }})">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
                </tr>
                @endforeach
                </tbody>
                </table>
                <div class="form-group">
                    <label style="font-size:14px" class="mt-3" for="nopol">Grand Total</label>
                    <input style="font-size:14px" type="text" class="form-control text-right" id="grand_total"
                        name="grand_total" readonly placeholder="" value="{{ $inquery->grand_total }}">
                </div>
            </div>
    </div>
    <div class="card-footer text-right">
        <button type="reset" class="btn btn-secondary">Reset</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
    </form>

    </div>
    <div class="modal fade" id="modal-supplier">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Supplier</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div style="text-align: center;">
                        <form action="{{ url('admin/tambah_supplier') }}" method="POST" enctype="multipart/form-data"
                            autocomplete="off">
                            @csrf
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Tambah Supplier</h3>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="nama">Nama Supplier</label>
                                        <input type="text" class="form-control" id="nama_supp" name="nama_supp"
                                            placeholder="Masukan nama supplier" value="{{ old('nama_supp') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="alamat">Alamat</label>
                                        <textarea type="text" class="form-control" id="alamat" name="alamat"
                                            placeholder="Masukan alamat">{{ old('alamat') }}</textarea>
                                    </div>
                                </div>
                            </div>
                            {{-- div diatas ini --}}

                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Kotak Person</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="nama">Nama</label>
                                        <input type="text" class="form-control" id="nama_person" name="nama_person"
                                            placeholder="Masukan nama" value="{{ old('nama_person') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="nama">Jabatan</label>
                                        <input type="text" class="form-control" id="jabatan" name="jabatan"
                                            placeholder="Masukan jabatan" value="{{ old('jabatan') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="nama">No. Telepon</label>
                                        <input type="number" class="form-control" id="telp" name="telp"
                                            placeholder="Masukan no telepon" value="{{ old('telp') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="nama">Fax</label>
                                        <input type="number" class="form-control" id="fax" name="fax"
                                            placeholder="Masukan no fax" value="{{ old('fax') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="telp">Hp</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">+62</span>
                                            </div>
                                            <input type="number" id="hp" name="hp" class="form-control"
                                                placeholder="Masukan nomor hp" value="{{ old('hp') }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="nama">Email</label>
                                        <input type="text" class="form-control" id="email" name="email"
                                            placeholder="Masukan email" value="{{ old('email') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="nama">No. NPWP</label>
                                        <input type="text" class="form-control" id="npwp" name="npwp"
                                            placeholder="Masukan no npwp" value="{{ old('npwp') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Informasi Bank</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label" for="nama_bank">Nama Bank</label>
                                        <select class="form-control" id="nama_bank" name="nama_bank">
                                            <option value="">- Pilih -</option>
                                            <option value="BRI" {{ old('nama_bank') == 'BRI' ? 'selected' : null }}>
                                                BRI</option>
                                            <option value="MANDIRI"
                                                {{ old('nama_bank') == 'MANDIRI' ? 'selected' : null }}>
                                                MANDIRI</option>
                                            <option value="BNI" {{ old('nama_bank') == 'BNI' ? 'selected' : null }}>
                                                BNI</option>
                                            <option value="BTN" {{ old('nama_bank') == 'BTN' ? 'selected' : null }}>
                                                BTN</option>
                                            <option value="DANAMON"
                                                {{ old('nama_bank') == 'DANAMON' ? 'selected' : null }}>
                                                DANAMON</option>
                                            <option value="BCA" {{ old('nama_bank') == 'BCA' ? 'selected' : null }}>
                                                BCA</option>
                                            <option value="PERMATA"
                                                {{ old('nama_bank') == 'PERMATA' ? 'selected' : null }}>
                                                PERMATA</option>
                                            <option value="PAN" {{ old('nama_bank') == 'PAN' ? 'selected' : null }}>
                                                PAN</option>
                                            <option value="CIMB NIAGA"
                                                {{ old('nama_bank') == 'CIMB NIAGA' ? 'selected' : null }}>
                                                CIMB NIAGA</option>
                                            <option value="UOB" {{ old('nama_bank') == 'UOB' ? 'selected' : null }}>
                                                UOB</option>
                                            <option value="ARTHA GRAHA"
                                                {{ old('nama_bank') == 'ARTHA GRAHA' ? 'selected' : null }}>
                                                ARTHA GRAHA</option>
                                            <option value="BUMI ARTHA"
                                                {{ old('nama_bank') == 'BUMI ARTHA' ? 'selected' : null }}>
                                                BUMI ARTHA</option>
                                            <option value="MEGA" {{ old('nama_bank') == 'MEGA' ? 'selected' : null }}>
                                                MEGA</option>
                                            <option value="SYARIAH"
                                                {{ old('nama_bank') == 'SYARIAH' ? 'selected' : null }}>
                                                SYARIAH</option>
                                            <option value="MEGA SYARIAH"
                                                {{ old('nama_bank') == 'MEGA SYARIAH' ? 'selected' : null }}>
                                                MEGA SYARIAH</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="atas_nama">Atas nama</label>
                                        <input type="text" class="form-control" id="atas_nama" name="atas_nama"
                                            placeholder="Masukan atas nama" value="{{ old('atas_nama') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="norek">No. Rekening</label>
                                        <input type="number" class="form-control" id="norek" name="norek"
                                            placeholder="Masukan no rekening" value="{{ old('norek') }}">
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <button type="reset" class="btn btn-secondary">Reset</button>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
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
function getData(id) {
    var supplier_id = document.getElementById('supplier_id');
    $.ajax({
        url: "{{ url('admin/pembelian/supplier') }}" + "/" + supplier_id.value,
        type: "GET",
        dataType: "json",
        success: function(supplier_id) {
            var alamat = document.getElementById('alamat');
            alamat.value = supplier_id.alamat;
        },
    });
}
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

$(document).on("input", ".harga, .jumlah, .diskon", function() {
    var currentRow = $(this).closest('tr');
    var harga = parseFloat(currentRow.find(".harga").val()) || 0;
    var jumlah = parseFloat(currentRow.find(".jumlah").val()) || 0;
    var diskon = parseFloat(currentRow.find(".diskon").val()) || 0;
    var total = harga * jumlah - diskon;
    currentRow.find(".total").val(total);

    updateGrandTotal()

});

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
    updateUrutans();
}

function updateUrutans() {
    var urutan = document.querySelectorAll('#urutan');
    for (let i = 0; i < urutan.length; i++) {
        urutan[i].innerText = i + 1;
    }
}

function removeBan(identifier, detailId) {
    var row = $('#pembelian-' + identifier);
    var detailId = row.find("input[name='detail_ids[]']").val();

    row.remove();

    if (detailId) {
        $.ajax({
            url: "{{ url('admin/inquery_pembelian/deletebarangs/') }}/" + detailId,
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
    updateGrandTotal();
    updateUrutans();
}

function itemPembelian(identifier, key, value = null) {
    var barang_id = '';
    var kode_barang = '';
    var nama_barang = '';
    var satuan = '';
    var jumlah = '';
    var harga = '';
    var diskon = '';
    var total = '';

    if (value !== null) {
        barang_id = value.barang_id;
        kode_barang = value.kode_barang;
        nama_barang = value.nama_barang;
        satuan = value.satuan;
        jumlah = value.jumlah;
        harga = value.harga;
        diskon = value.diskon;
        total = value.total;
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

    // satuan 
    item_pembelian += '<td>';
    item_pembelian += '<div class="form-group">';
    item_pembelian += '<select style="font-size:14px" class="form-control" id="satuan-' + key +
        '" name="satuan[]">';
    item_pembelian += '<option value="">- Pilih -</option>';
    item_pembelian += '<option value="M3"' + (satuan === 'M3' ? ' selected' : '') +
        '>M&sup3;</option>';
    item_pembelian += '<option value="ton"' + (satuan === 'ton' ? ' selected' : '') +
        '>ton</option>';
    item_pembelian += '<option value="krtn"' + (satuan === 'krtn' ? ' selected' : '') +
        '>krtn</option>';
    item_pembelian += '<option value="dus"' + (satuan === 'dus' ? ' selected' : '') +
        '>dus</option>';
    item_pembelian += '<option value="rit"' + (satuan === 'rit' ? ' selected' : '') +
        '>rit</option>';
    item_pembelian += '<option value="kg"' + (satuan === 'kg' ? ' selected' : '') +
        '>kg</option>';
    item_pembelian += '<option value="ltr"' + (satuan === 'ltr' ? ' selected' : '') +
        '>ltr</option>';
    item_pembelian += '<option value="pcs"' + (satuan === 'pcs' ? ' selected' : '') + '>pcs</option>';
    item_pembelian += '<option value="hr"' + (satuan === 'hr' ? ' selected' : '') +
        '>hr</option>';
    item_pembelian += '<option value="ZAK"' + (satuan === 'ZAK' ? ' selected' : '') +
        '>ZAK</option>';
    item_pembelian += '</select>';
    item_pembelian += '</div>';
    item_pembelian += '</td>';

    // jumlah
    item_pembelian += '<td>';
    item_pembelian += '<div class="form-group">'
    item_pembelian += '<input type="text" class="form-control jumlah" id="jumlah-' + key +
        '" name="jumlah[]" value="' + jumlah + '" ';
    item_pembelian += '</div>';
    item_pembelian += '</td>';

    // harga
    item_pembelian += '<td>';
    item_pembelian += '<div class="form-group">'
    item_pembelian += '<input type="number" class="form-control harga" id="harga-' + key +
        '" name="harga[]" value="' + harga + '" ';
    item_pembelian += '</div>';
    item_pembelian += '</td>';

    // diskon
    item_pembelian += '<td>';
    item_pembelian += '<div class="form-group">'
    item_pembelian += '<input type="text" class="form-control diskon" id="diskon-' + key +
        '" name="diskon[]" value="' + diskon + '" ';
    item_pembelian += '</div>';
    item_pembelian += '</td>';

    // total
    item_pembelian += '<td>';
    item_pembelian += '<div class="form-group">'
    item_pembelian += '<input type="number" class="form-control total" id="total-' + key +
        '" name="total[]" value="' + total + '" readonly';
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
function updateGrandTotal() {
    var grandTotal = 0;

    // Loop through all elements with name "total[]"
    $('input[name^="total"]').each(function() {
        var nominalValue = parseFloat($(this).val().replace(/\./g, '').replace(',', '.')) || 0;
        grandTotal += nominalValue;
    });
    // $('#sub_total').val(grandTotal.toLocaleString('id-ID'));
    // $('#pph2').val(pph2Value.toLocaleString('id-ID'));
    $('#grand_total').val(formatRupiahsss(grandTotal));
    console.log(grandTotal);
}

$('body').on('input', 'input[name^="total"]', function() {
    updateGrandTotal();
});

// Panggil fungsi saat halaman dimuat untuk menginisialisasi grand total
$(document).ready(function() {
    updateGrandTotal();
});

function formatRupiahsss(number) {
    var formatted = new Intl.NumberFormat('id-ID', {
        minimumFractionDigits: 1,
        maximumFractionDigits: 1
    }).format(number);
    return '' + formatted;
}
</script>
@endsection item_pembelian += '</div>';
item_pembelian += '</td>';

// harga
item_pembelian += '<td>';
    item_pembelian += '<div class="form-group">'
        item_pembelian += '<input type="number" class="form-control harga" id="harga-' + key +
        '" name="harga[]" value="' + harga + '" ';
    item_pembelian += ' </div>';
        item_pembelian += '</td>';

// diskon
item_pembelian += '<td>';
    item_pembelian += '<div class="form-group">'
        item_pembelian += '<input type="text" class="form-control diskon" id="diskon-' + key +
        '" name="diskon[]" value="' + diskon + '" ';
    item_pembelian += ' </div>';
        item_pembelian += '</td>';

// total
item_pembelian += '<td>';
    item_pembelian += '<div class="form-group">'
        item_pembelian += '<input type="number" class="form-control total" id="total-' + key +
        '" name="total[]" value="' + total + '" readonly'; item_pembelian +='</div>' ; item_pembelian +='</td>' ;
            item_pembelian +='<td style="width: 120px">' ; item_pembelian
            +='<button type="button" class="btn btn-primary" onclick="barang(' + key + ')">' ; item_pembelian
            +='<i class="fas fa-plus"></i>' ; item_pembelian +='</button>' ; item_pembelian
            +='<button style="margin-left:5px" type="button" class="btn btn-danger" onclick="removeBan(' + key + ')">' ;
            item_pembelian +='<i class="fas fa-trash"></i>' ; item_pembelian +='</button>' ; item_pembelian +='</td>' ;
            item_pembelian +='</tr>' ; $('#tabel-pembelian').append(item_pembelian); } </script>

        <script>
        function updateGrandTotal() {
            var grandTotal = 0;

            // Loop through all elements with name "total[]"
            $('input[name^="total"]').each(function() {
                var nominalValue = parseFloat($(this).val().replace(/\./g, '').replace(',', '.')) || 0;
                grandTotal += nominalValue;
            });
            // $('#sub_total').val(grandTotal.toLocaleString('id-ID'));
            // $('#pph2').val(pph2Value.toLocaleString('id-ID'));
            $('#grand_total').val(formatRupiahsss(grandTotal));
            console.log(grandTotal);
        }

        $('body').on('input', 'input[name^="total"]', function() {
            updateGrandTotal();
        });

        // Panggil fungsi saat halaman dimuat untuk menginisialisasi grand total
        $(document).ready(function() {
            updateGrandTotal();
        });

        function formatRupiahsss(number) {
            var formatted = new Intl.NumberFormat('id-ID', {
                minimumFractionDigits: 1,
                maximumFractionDigits: 1
            }).format(number);
            return '' + formatted;
        }
        </script>
        @endsection