@extends('layouts.app')

@section('title', 'Inquery Invoice Surat Pesanan')

@section('content')
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
                    <h1 class="m-0">Inquery Invoice Surat Pesanan</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/tagihan_ekspedisi') }}">Invoice Surat Pesanan</a>
                        </li>
                        <li class="breadcrumb-item active">Perbarui</li>
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
            @if (session('erorrss'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5>
                        <i class="icon fas fa-ban"></i> Error!
                    </h5>
                    {{ session('erorrss') }}
                </div>
            @endif

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
            <form action="{{ url('admin/inquery_invoicesuratpesanan/' . $inquery->id) }}" method="POST"
                enctype="multipart/form-data" autocomplete="off">
                @method('put')
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Perbarui Invoice Surat Pesanan</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="form-group" style="flex: 8;">
                            <div class="form-group">
                                <label style="font-size:14px" class="form-label" for="kategori">Pilih Kategori</label>
                                <input type="text" class="form-control" id="kategori" readonly name="kategori"
                                    placeholder="" value="{{ old('kategori', $inquery->kategori) }}">
                            </div>
                            <div class="row">
                                <div hidden class="form-group">
                                    <label for="pelanggan_id">pelanggan Id</label>
                                    <input type="text" class="form-control" id="pelanggan_id" readonly
                                        name="pelanggan_id" placeholder=""
                                        value="{{ old('pelanggan_id', $inquery->pelanggan_id) }}">
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label style="font-size:14px" for="kode_pelanggan">Kode Pelanggan</label>
                                        <input onclick="showCategoryModalPelanggan(this.value)" style="font-size:14px"
                                            type="text" class="form-control" id="kode_pelanggan" readonly
                                            name="kode_pelanggan" placeholder=""
                                            value="{{ old('kode_pelanggan', $inquery->pelanggan->kode_pelanggan) }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label style="font-size:14px" class="form-label" for="nama_pelanggan">Nama
                                        Pelanggan</label>
                                    <div class="form-group d-flex">
                                        <input onclick="showCategoryModalPelanggan(this.value)" class="form-control"
                                            id="nama_pelanggan" name="nama_pelanggan" type="text" placeholder=""
                                            value="{{ old('nama_pelanggan', $inquery->pelanggan->nama_pelanggan) }}"
                                            readonly style="margin-right: 10px; font-size:14px" />
                                        <button class="btn btn-primary" type="button"
                                            onclick="showCategoryModalPelanggan(this.value)">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label style="font-size:14px" for="telp_pelanggan">No. Telp</label>
                                        <input onclick="showCategoryModalPelanggan(this.value)" style="font-size:14px"
                                            type="text" class="form-control" id="telp_pelanggan" readonly
                                            name="telp_pelanggan" placeholder=""
                                            value="{{ old('telp_pelanggan', $inquery->pelanggan->telp) }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label style="font-size:14px" for="alamat_pelanggan">Alamat</label>
                                        <input onclick="showCategoryModalPelanggan(this.value)" style="font-size:14px"
                                            type="text" class="form-control" id="alamat_pelanggan" readonly
                                            name="alamat" placeholder=""
                                            value="{{ old('alamat', $inquery->pelanggan->alamat) }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Surat Pesanan Karoseri <span>
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
                                    <th style="font-size:14px" class="text-center">No</th>
                                    <th style="font-size:14px">Kode Pesanan</th>
                                    <th style="font-size:14px">Tanggal</th>
                                    <th style="font-size:14px">Merek</th>
                                    <th style="font-size:14px">Type</th>
                                    <th style="font-size:14px">Kode Typekaroseri</th>
                                    <th style="font-size:14px">Bentuk Typekaroseri</th>
                                    <th style="font-size:14px">Harga</th>
                                    <th style="font-size:14px; text-align:center">Opsi</th>
                                </tr>
                            </thead>
                            <tbody id="tabel-pembelian">
                                @foreach ($details as $detail)
                                    <tr id="pembelian-{{ $loop->index }}">
                                        <td style="width: 70px; font-size:14px" class="text-center" id="urutan">
                                            {{ $loop->index + 1 }}
                                        </td>
                                        <td hidden>
                                            <div class="form-group" hidden>
                                                <input type="text" class="form-control"
                                                    id="nomor_seri-{{ $loop->index }}" name="detail_ids[]"
                                                    value="{{ $detail['id'] }}">
                                            </div>
                                        </td>
                                        <td hidden>
                                            <div class="form-group">
                                                <input type="text" class="form-control"
                                                    id="spk_id-{{ $loop->index }}" name="spk_id[]"
                                                    value="{{ $detail['spk_id'] }}">
                                            </div>
                                        </td>
                                        <td style="width: 150px">
                                            <div class="form-group">
                                                <input onclick="Surat_pesanan(0)" style="font-size:14px" readonly
                                                    type="text" class="form-control"
                                                    id="kode_pesanan-{{ $loop->index }}"
                                                    name="kode_pesanan[]"value="{{ $detail['kode_pesanan'] }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input onclick="Surat_pesanan(0)" style="font-size:14px" readonly
                                                    type="text" class="form-control"
                                                    id="tanggal_pesanan-{{ $loop->index }}" name="tanggal_pesanan[]"
                                                    value="{{ $detail['tanggal_pesanan'] }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input style="font-size:14px" type="text" readonly
                                                    class="form-control" id="merek-{{ $loop->index }}" name="merek[]"
                                                    value="{{ $detail['merek'] }}">
                                            </div>
                                        </td>

                                        <td style="width: 150px">
                                            <div class="form-group">
                                                <input onclick="Surat_pesanan(0)" style="font-size:14px" readonly
                                                    type="text" class="form-control"
                                                    id="tipemerek-{{ $loop->index }}" name="tipemerek[]"
                                                    value="{{ $detail['tipemerek'] }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input onclick="Surat_pesanan(0)" style="font-size:14px" readonly
                                                    type="text" class="form-control"
                                                    id="kode_karoseri-{{ $loop->index }}" name="kode_karoseri[]"
                                                    value="{{ $detail['kode_karoseri'] }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input onclick="Surat_pesanan(0)" style="font-size:14px" readonly
                                                    type="text" class="form-control"
                                                    id="nama_karoseri-{{ $loop->index }}" name="nama_karoseri[]"
                                                    value="{{ $detail['nama_karoseri'] }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input onclick="Surat_pesanan(0)" style="font-size:14px" readonly
                                                    type="text" class="form-control" id="harga-{{ $loop->index }}"
                                                    name="harga[]" value="{{ $detail['harga'] }}">
                                            </div>
                                        </td>
                                        <td style="width: 100px">
                                            <button type="button" class="btn btn-primary btn-sm"
                                                onclick="Surat_pesanan(0)">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                            <button style="margin-left:5px" type="button" class="btn btn-danger btn-sm"
                                                onclick="removeBan(0)">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="form-group mt-2">
                            <label style="font-size:14px" for="keterangan">Keterangan</label>
                            <textarea style="font-size:14px" type="text" class="form-control" id="keterangan" name="keterangan"
                                placeholder="Masukan keterangan">{{ old('keterangan', $inquery->keterangan) }}</textarea>
                        </div>
                    </div>
                </div>
                <div>
                    <div>
                        <div class="card">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card" id="form_biayatambahan">
                                        <div class="card-header">
                                            <h3 class="card-title">Biaya Tambahan <span>
                                                </span></h3>
                                            <div class="float-right">
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    onclick="addMemotambahan()">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th style="font-size:14px" class="text-center">No</th>
                                                        <th style="font-size:14px">Keterangan</th>
                                                        <th style="font-size:14px">Nominal</th>
                                                        <th style="font-size:14px">Qty</th>
                                                        <th style="font-size:14px">Satuan</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tabel-memotambahan">
                                                    @foreach ($detailtarifs as $detail)
                                                        <tr id="memotambahan-{{ $loop->index }}">
                                                            <td style="width: 70px; font-size:14px" class="text-center"
                                                                id="urutantambahan">
                                                                {{ $loop->index + 1 }}
                                                            </td>
                                                            <td>
                                                                <div class="form-group" hidden>
                                                                    <input type="text" class="form-control"
                                                                        id="nomor_seri-{{ $loop->index }}"
                                                                        name="detail_idss[]" value="{{ $detail['id'] }}">
                                                                </div>
                                                                <div class="form-group">
                                                                    <input style="font-size:14px" type="text"
                                                                        class="form-control"
                                                                        id="keterangan_tambahan-{{ $loop->index }}"
                                                                        name="keterangan_tambahan[]"
                                                                        value="{{ $detail['keterangan_tambahan'] }}">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <input style="font-size:14px" type="number"
                                                                        class="form-control"
                                                                        id="nominal_tambahan-{{ $loop->index }}"
                                                                        name="nominal_tambahan[]"
                                                                        value="{{ $detail['nominal_tambahan'] }}">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <input style="font-size:14px" type="number"
                                                                        class="form-control"
                                                                        id="qty_tambahan-{{ $loop->index }}"
                                                                        name="qty_tambahan[]"
                                                                        value="{{ $detail['qty_tambahan'] }}">
                                                                </div>
                                                            </td>
                                                            <td>

                                                                <select style="font-size:14px" class="form-control"
                                                                    id="satuan_tambahan-0" name="satuan_tambahan[]">
                                                                    <option value="">- Pilih -</option>
                                                                    <option value="M3"
                                                                        {{ old('satuan_tambahan', $detail['satuan_tambahan']) == 'M3' ? 'selected' : null }}>
                                                                        M&sup3;</option>
                                                                    <option value="ton"
                                                                        {{ old('satuan_tambahan', $detail['satuan_tambahan']) == 'ton' ? 'selected' : null }}>
                                                                        ton</option>
                                                                    <option value="krtn"
                                                                        {{ old('satuan_tambahan', $detail['satuan_tambahan']) == 'krtn' ? 'selected' : null }}>
                                                                        krtn</option>
                                                                    <option value="dus"
                                                                        {{ old('satuan_tambahan', $detail['satuan_tambahan']) == 'dus' ? 'selected' : null }}>
                                                                        dus</option>
                                                                    <option value="rit"
                                                                        {{ old('satuan_tambahan', $detail['satuan_tambahan']) == 'rit' ? 'selected' : null }}>
                                                                        rit</option>
                                                                    <option value="kg"
                                                                        {{ old('satuan_tambahan', $detail['satuan_tambahan']) == 'kg' ? 'selected' : null }}>
                                                                        kg</option>
                                                                    <option value="ltr"
                                                                        {{ old('satuan_tambahan', $detail['satuan_tambahan']) == 'ltr' ? 'selected' : null }}>
                                                                        ltr</option>
                                                                    <option value="pcs"
                                                                        {{ old('satuan_tambahan', $detail['satuan_tambahan']) == 'pcs' ? 'selected' : null }}>
                                                                        pcs</option>
                                                                    <option value="hr"
                                                                        {{ old('satuan_tambahan', $detail['satuan_tambahan']) == 'hr' ? 'selected' : null }}>
                                                                        hr</option>
                                                                    <option value="ZAK"
                                                                        {{ old('satuan_tambahan', $detail['satuan_tambahan']) == 'ZAK' ? 'selected' : null }}>
                                                                        ZAK</option>
                                                                </select>
                                                            </td>
                                                            <td style="width: 50px">
                                                                <button style="margin-left:5px" type="button"
                                                                    class="btn btn-danger btn-sm"
                                                                    onclick="removememotambahans({{ $loop->index }}, {{ $detail['id'] }})">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div id="form_pph">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label style="font-size:14px; margin-top:5px" for="sub_total">Sub
                                                        Total
                                                        <span style="margin-left:61px">:</span></label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input style="text-align: end; font-size:14px;" type="text"
                                                        class="form-control sub_total" readonly id="sub_total"
                                                        name="sub_total" placeholder=""
                                                        value="{{ old('sub_total', $inquery->sub_total) }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label style="font-size:14px; margin-top:5px" for="tarif">Biaya
                                                        Tambahan
                                                        <span class="ml-3">:</span></label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input style="text-align: end; font-size:14px;" type="text"
                                                        class="form-control" readonly id="biaya_tambahan"
                                                        name="biaya_tambahan" placeholder=""
                                                        value="{{ old('biaya_tambahan', $inquery->biaya_tambahan) }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label style="font-size:14px; margin-top:5px" for="ppn">PPN 11%
                                                        <span style="margin-left:69px">:</span></label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input style="text-align: end; font-size:14px;" type="text"
                                                        class="form-control ppn" readonly id="ppn" name="ppn"
                                                        placeholder="" value="{{ old('ppn', $inquery->ppn) }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <hr
                                                style="border: 2px solid black; display: inline-block; width: 97%; vertical-align: middle;">
                                            <span
                                                style="display: inline-block; margin-left: 0px; margin-right: 0; font-size: 18px; vertical-align: middle;">+</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label style="font-size:14px; margin-top:5px" for="grand_total">Grand
                                            Total <span style="margin-left:46px">:</span></label>
                                        <input style="text-align: end; margin:right:10px; font-size:14px;" type="text"
                                            class="form-control grand_total" readonly id="grand_total" name="grand_total"
                                            placeholder="" value="{{ old('grand_total', $inquery->grand_total) }}">
                                    </div>
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
                    </div>
            </form>
        </div>

        <div class="modal fade" id="tablePelanggan" data-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Data Pelanggan</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table id="datatables4" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    {{-- <th>nomor</th> --}}
                                    <th>Kode Pelanggan</th>
                                    <th>Nama Pelanggan</th>
                                    <th>Alamat</th>
                                    <th>No. Telp</th>
                                    {{-- <th>Kategori</th> --}}
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $uniqueCustomerIds = [];
                                @endphp

                                @foreach ($surat_pesanans as $faktur)
                                    @php
                                        $customerId = $faktur->pelanggan->id;
                                    @endphp

                                    @if (!in_array($customerId, $uniqueCustomerIds))
                                        <tr
                                            onclick="getSelectedDataPelanggan('{{ $faktur->pelanggan->id }}', '{{ $faktur->pelanggan->kode_pelanggan }}', '{{ $faktur->pelanggan->nama_pelanggan }}', '{{ $faktur->pelanggan->alamat }}', '{{ $faktur->pelanggan->telp }}')">
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $faktur->pelanggan->kode_pelanggan }}</td>
                                            <td>{{ $faktur->pelanggan->nama_pelanggan }}</td>
                                            <td>{{ $faktur->pelanggan->alamat }}</td>
                                            <td>{{ $faktur->pelanggan->telp }}</td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    onclick="getSelectedDataPelanggan('{{ $faktur->pelanggan->id }}', '{{ $faktur->pelanggan->kode_pelanggan }}', '{{ $faktur->pelanggan->nama_pelanggan }}', '{{ $faktur->pelanggan->alamat }}', '{{ $faktur->pelanggan->telp }}')">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @php
                                            $uniqueCustomerIds[] = $customerId;
                                        @endphp
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="tableSuratpesanan" data-backdrop="static">
            <div class="modal-dialog modal-lg" style="max-width: 90%;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Data Surat Pesanan</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="m-2">
                            <input type="text" id="searchInputrutes" class="form-control" placeholder="Search...">
                        </div>
                        <table id="tablefaktur" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Kode Pesanan</th>
                                    <th>Tanggal</th>
                                    <th>Merek</th>
                                    <th>Type</th>
                                    <th>Kode Karoseri</th>
                                    <th>Bentuk Karoseri</th>
                                    <th>Harga</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <script>
        function filterTablefaktur() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("searchInputrutes");
            filter = input.value.toUpperCase();
            table = document.getElementById("tablefaktur");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                var displayRow = false;

                // Loop through columns (td 1, 2, and 3)
                for (j = 1; j <= 4; j++) {
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
        document.getElementById("searchInputrutes").addEventListener("input", filterTablefaktur);
    </script>

    <script>
        function showCategoryModalPelanggan(selectedCategory) {
            $('#tablePelanggan').modal('show');
        }

        function getSelectedDataPelanggan(Pelanggan_id, KodePelanggan, NamaPell, AlamatPel, Telpel) {
            // Set the values in the form fields
            document.getElementById('pelanggan_id').value = Pelanggan_id;
            document.getElementById('kode_pelanggan').value = KodePelanggan;
            document.getElementById('nama_pelanggan').value = NamaPell;
            document.getElementById('alamat_pelanggan').value = AlamatPel;
            document.getElementById('telp_pelanggan').value = Telpel;

            $('#pelanggan_id').trigger('input');

            // Close the modal (if needed)
            $('#tablePelanggan').modal('hide');
        }
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
                item_pembelian += '<td class="text-center" colspan="9">- Surat Pesanan belum ditambahkan -</td>';
                item_pembelian += '</tr>';
                $('#tabel-pembelian').html(item_pembelian);
            } else {
                var urutan = document.querySelectorAll('#urutan');
                for (let i = 0; i < urutan.length; i++) {
                    urutan[i].innerText = i + 1;
                }
            }
            updateTotalPembayaran();
        }

        function itemPembelian(urutan, key, value = null) {
            var spk_id = '';
            var kode_pesanan = '';
            var tanggal_pesanan = '';
            var merek = '';
            var tipemerek = '';
            var kode_karoseri = '';
            var nama_karoseri = '';
            var harga = '';

            if (value !== null) {
                spk_id = value.spk_id;
                kode_pesanan = value.kode_pesanan;
                tanggal_pesanan = value.tanggal_pesanan;
                merek = value.merek;
                tipemerek = value.tipemerek;
                kode_karoseri = value.kode_karoseri;
                nama_karoseri = value.nama_karoseri;
                harga = value.harga;
            }

            // urutan 
            var item_pembelian = '<tr id="pembelian-' + urutan + '">';
            item_pembelian += '<td style="width: 70px; font-size:14px" class="text-center" id="urutan-' + urutan + '">' +
                urutan + '</td>';

            // spk_id 
            item_pembelian += '<td hidden>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" id="spk_id-' + urutan +
                '" name="spk_id[]" value="' + spk_id + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // kode_pesanan 
            item_pembelian += '<td style="width: 150px" onclick="Surat_pesanan(' + urutan +
                ')">';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" style="font-size:14px" readonly id="kode_pesanan-' +
                urutan +
                '" name="kode_pesanan[]" value="' + kode_pesanan + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // tanggal_pesanan 
            item_pembelian += '<td onclick="Surat_pesanan(' + urutan +
                ')">';
            item_pembelian += '<div class="form-group">'
            item_pembelian +=
                '<input type="text" class="form-control" style="font-size:14px" readonly id="tanggal_pesanan-' +
                urutan +
                '" name="tanggal_pesanan[]" value="' + tanggal_pesanan + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // merek 
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian +=
                '<input type="text" class="form-control" readonly style="font-size:14px" id="merek-' +
                urutan +
                '" name="merek[]" value="' + merek + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // tipemerek 
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" readonly style="font-size:14px" id="tipemerek-' +
                urutan +
                '" name="tipemerek[]" value="' + tipemerek + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // kode_karoseri 
            item_pembelian += '<td onclick="Surat_pesanan(' + urutan +
                ')">';
            item_pembelian += '<div class="form-group">'
            item_pembelian +=
                '<input type="text" class="form-control" style="font-size:14px" readonly id="kode_karoseri-' +
                urutan +
                '" name="kode_karoseri[]" value="' + kode_karoseri + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // nama_karoseri 
            item_pembelian += '<td onclick="Surat_pesanan(' + urutan +
                ')">';
            item_pembelian += '<div class="form-group">'
            item_pembelian +=
                '<input type="text" class="form-control" style="font-size:14px" readonly id="nama_karoseri-' +
                urutan +
                '" name="nama_karoseri[]" value="' + nama_karoseri + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // harga 
            item_pembelian += '<td onclick="Surat_pesanan(' + urutan +
                ')">';
            item_pembelian += '<div class="form-group">'
            item_pembelian +=
                '<input type="text" class="form-control" style="font-size:14px" readonly id="harga-' +
                urutan +
                '" name="harga[]" value="' + harga + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            item_pembelian += '<td style="width: 100px">';
            item_pembelian += '<button type="button" class="btn btn-primary btn-sm" onclick="Surat_pesanan(' + urutan +
                ')">';
            item_pembelian += '<i class="fas fa-plus"></i>';
            item_pembelian += '</button>';
            item_pembelian +=
                '<button style="margin-left:5px" type="button" class="btn btn-danger btn-sm" onclick="removeBan(' +
                urutan + ')">';
            item_pembelian += '<i class="fas fa-trash"></i>';
            item_pembelian += '</button>';
            item_pembelian += '</td>';
            item_pembelian += '</tr>';

            $('#tabel-pembelian').append(item_pembelian);
        }
    </script>

    <script>
        var activeSpecificationIndex = 0;
        var fakturAlreadySelected = []; // Simpan daftar kode faktur yang sudah dipilih

        function Surat_pesanan(param) {
            activeSpecificationIndex = param;
            // Show the modal and filter rows if necessary
            $('#tableSuratpesanan').modal('show');
        }

        function getFaktur(rowIndex) {
            var selectedRow = $('#tablefaktur tbody tr:eq(' + rowIndex + ')');
            var spk_id = selectedRow.data('id');
            var kode_pesanan = selectedRow.data('kode_pesanan');
            if (fakturAlreadySelected.includes(kode_pesanan)) {
                alert('Kode faktur sudah dipilih sebelumnya.');
                return;
            }
            fakturAlreadySelected.push(kode_pesanan);
            var tanggal_pesanan = selectedRow.data('tanggal_pesanan');
            var merek = selectedRow.data('merek');
            var tipemerek = selectedRow.data('tipemerek');
            var kode_karoseri = selectedRow.data('kode_karoseri');
            var nama_karoseri = selectedRow.data('nama_karoseri');
            var harga = selectedRow.data('harga');
            // membuat validasi jika kode sudah ada 

            $('#spk_id-' + activeSpecificationIndex).val(spk_id);
            $('#kode_pesanan-' + activeSpecificationIndex).val(kode_pesanan);
            $('#tanggal_pesanan-' + activeSpecificationIndex).val(tanggal_pesanan);
            $('#merek-' + activeSpecificationIndex).val(merek);
            $('#tipemerek-' + activeSpecificationIndex).val(tipemerek);
            $('#kode_karoseri-' + activeSpecificationIndex).val(kode_karoseri);
            $('#nama_karoseri-' + activeSpecificationIndex).val(nama_karoseri);
            $('#harga-' + activeSpecificationIndex).val(parseFloat(harga).toLocaleString('id-ID'));

            updateTotalPembayaran();

            $('#tableSuratpesanan').modal('hide');
        }
    </script>

    <script>
        function updateTotalPembayaran() {
            var grandTotal = 0;

            // Iterate through all input elements with IDs starting with 'harga-'
            $('input[id^="harga-"]').each(function() {
                // Remove dots and replace comma with dot, then parse as float
                var nilaiTotal = parseFloat($(this).val().replace(/\./g, '').replace(',', '.')) || 0;
                grandTotal += nilaiTotal;
            });

            // Format grandTotal as currency in Indonesian Rupiah
            var formattedGrandTotal = grandTotal.toLocaleString('id-ID');
            console.log(formattedGrandTotal);
            $('#sub_total').val(formattedGrandTotal);
            var biaya_tambahan = parseFloat($("#biaya_tambahan").val().replace(/\./g, "")) || 0;
            var grandjumlah = biaya_tambahan + grandTotal
            // Calculate 11% tax
            var taxRate = 0.11;
            var taxAmount = grandjumlah * taxRate;
            var formattedTaxAmount = taxAmount.toLocaleString('id-ID');
            console.log(formattedTaxAmount);

            // Set the formatted tax amount to the target element
            $('#ppn').val(formattedTaxAmount);

            // Calculate the total price including tax
            var totalPriceWithTax = grandjumlah + taxAmount;
            var formattedTotalPriceWithTax = totalPriceWithTax.toLocaleString('id-ID');
            console.log(formattedTotalPriceWithTax);

            // Set the formatted total price including tax to the target element
            $('#grand_total').val(formattedTotalPriceWithTax);
        }
    </script>

    <script>
        function formatRupiah(number) {
            var formatted = new Intl.NumberFormat('id-ID', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }).format(number);
            return '' + formatted;
        }
    </script>

    <script>
        function setPphValue() {
            var kategori = document.getElementById("kategori").value;
            var pphInput = document.getElementById("ppn");
            var FormPPH = document.getElementById("form_pph");

            // Jika kategori adalah NON PPH, atur nilai ppn menjadi 0
            if (kategori === "NON PPN") {
                pphInput.value = 0;
                FormPPH.style.display = "none";
            }
            // Jika kategori adalah PPH, atur nilai ppn sesuai dengan nilai dari server
            else if (kategori === "PPN") {
                FormPPH.style.display = "block";
            }
            updateGrandTotal();
        }

        // Panggil fungsi setPphValue() saat halaman dimuat ulang
        document.addEventListener("DOMContentLoaded", setPphValue);

        // Tambahkan event listener untuk mendeteksi perubahan pada elemen <select>
        document.getElementById("kategori").addEventListener("change", setPphValue);
        document.getElementById("kategori").addEventListener("change", updateGrandTotal);
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
        var tanggalAwal = document.getElementById('periode_awal');
        var tanggalAkhir = document.getElementById('periode_akhir');
        if (tanggalAwal.value == "") {
            tanggalAkhir.readOnly = true;
        }
        tanggalAwal.addEventListener('change', function() {
            if (this.value == "") {
                tanggalAkhir.readOnly = true;
            } else {
                tanggalAkhir.readOnly = false;
            };
            tanggalAkhir.value = "";
            var today = new Date().toISOString().split('T')[0];
            tanggalAkhir.value = today;
            tanggalAkhir.setAttribute('min', this.value);
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#pelanggan_id').on('input', function() {
                var pelangganID = $(this).val();

                if (pelangganID) {
                    $.ajax({
                        url: "{{ url('admin/inquery_invoicesuratpesanan/get_suratpesanan') }}" + '/' +
                            pelangganID,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('#tablefaktur tbody').empty();
                            if (data.length > 0) {
                                $.each(data, function(index, surat) {
                                    var row = '<tr data-id="' + surat.id +
                                        '" data-kode_pesanan="' + surat.kode_spk +
                                        '" data-tanggal_pesanan="' + surat
                                        .tanggal_awal +
                                        '" data-merek="' + surat.merek.nama_merek +
                                        '" data-tipemerek="' + surat.tipe +

                                        '" data-kode_karoseri="' + surat.typekaroseri
                                        .kode_type +
                                        '" data-nama_karoseri="' + surat.typekaroseri
                                        .nama_karoseri +
                                        '" data-harga="' + surat.harga +
                                        '" data-param="' + index + '">' +
                                        '<td class="text-center">' + (index + 1) +
                                        '</td>' +
                                        '<td>' + surat.kode_spk + '</td>' +
                                        '<td>' + surat.tanggal_awal + '</td>' +
                                        '<td>' + surat.merek.nama_merek +
                                        '</td>' +
                                        '<td>' + surat.tipe + '</td>' +
                                        '<td>' + surat.typekaroseri.kode_type +
                                        '</td>' +
                                        '<td>' + surat.typekaroseri.nama_karoseri +
                                        '</td>' +
                                        '<td>' + surat.harga +
                                        '</td>' +
                                        '<td class="text-center">' +
                                        '<button type="button" id="btnTambah" class="btn btn-primary btn-sm" onclick="getFaktur(' +
                                        index + ')">' +
                                        '<i class="fas fa-plus"></i>' +
                                        '</button>' +
                                        '</td>' +
                                        '</tr>';
                                    $('#tablefaktur tbody').append(row);
                                });
                            } else {
                                $('#tablefaktur tbody').append(
                                    '<tr><td colspan="7" class="text-center">No data available</td></tr>'
                                );
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error("AJAX Error:", status, error);
                            $('#tablefaktur tbody').empty();
                            $('#tablefaktur tbody').append(
                                '<tr><td colspan="7" class="text-center">Error loading data</td></tr>'
                            );
                        }
                    });
                } else {
                    $('#tablefaktur tbody').empty();
                    $('#tablefaktur tbody').append(
                        '<tr><td colspan="7" class="text-center">No data available</td></tr>'
                    );
                }
            });

            // Trigger the input event manually on page load if there's a value in the pelanggan_id field
            if ($('#pelanggan_id').val()) {
                $('#pelanggan_id').trigger('input');
            }
        });
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
            var row = document.getElementById('pembelian-' + identifier);
            row.remove();

            $.ajax({
                url: "{{ url('admin/inquery_fakturekspedisi/deletedetailfaktur/') }}/" + detailId,
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

            updateUrutans();
            updateTotalPembayaran();
        }

        function itemPembelian(identifier, key, value = null) {
            var spk_id = '';
            var kode_pesanan = '';
            var tanggal_pesanan = '';
            var merek = '';
            var tipemerek = '';
            var kode_karoseri = '';
            var nama_karoseri = '';
            var harga = '';

            if (value !== null) {
                spk_id = value.spk_id;
                kode_pesanan = value.kode_pesanan;
                tanggal_pesanan = value.tanggal_pesanan;
                merek = value.merek;
                tipemerek = value.tipemerek;
                kode_karoseri = value.kode_karoseri;
                nama_karoseri = value.nama_karoseri;
                harga = value.harga;
            }

            // urutan 
            var item_pembelian = '<tr id="pembelian-' + key + '">';
            item_pembelian += '<td  style="width: 70px; font-size:14px" class="text-center" id="urutan">' + key +
                '</td>';

            // spk_id 
            item_pembelian += '<td hidden>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" id="spk_id-' + key +
                '" name="spk_id[]" value="' + spk_id + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // kode_pesanan 
            item_pembelian += '<td style="width: 150px" onclick="Surat_pesanan(' + key +
                ')">';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" style="font-size:14px" readonly id="kode_pesanan-' +
                key +
                '" name="kode_pesanan[]" value="' + kode_pesanan + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // tanggal_pesanan 
            item_pembelian += '<td onclick="Surat_pesanan(' + key +
                ')">';
            item_pembelian += '<div class="form-group">'
            item_pembelian +=
                '<input type="text" class="form-control" style="font-size:14px" readonly id="tanggal_pesanan-' +
                key +
                '" name="tanggal_pesanan[]" value="' + tanggal_pesanan + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // merek 
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian +=
                '<input type="text" class="form-control" readonly style="font-size:14px" id="merek-' +
                key +
                '" name="merek[]" value="' + merek + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // tipemerek 
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" readonly style="font-size:14px" id="tipemerek-' +
                key +
                '" name="tipemerek[]" value="' + tipemerek + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // kode_karoseri 
            item_pembelian += '<td onclick="Surat_pesanan(' + key +
                ')">';
            item_pembelian += '<div class="form-group">'
            item_pembelian +=
                '<input type="text" class="form-control" style="font-size:14px" readonly id="kode_karoseri-' +
                key +
                '" name="kode_karoseri[]" value="' + kode_karoseri + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // nama_karoseri 
            item_pembelian += '<td onclick="Surat_pesanan(' + key +
                ')">';
            item_pembelian += '<div class="form-group">'
            item_pembelian +=
                '<input type="text" class="form-control" style="font-size:14px" readonly id="nama_karoseri-' +
                key +
                '" name="nama_karoseri[]" value="' + nama_karoseri + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // harga 
            item_pembelian += '<td onclick="Surat_pesanan(' + key +
                ')">';
            item_pembelian += '<div class="form-group">'
            item_pembelian +=
                '<input type="text" class="form-control" style="font-size:14px" readonly id="harga-' +
                key +
                '" name="harga[]" value="' + harga + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            //
            item_pembelian += '<td style="width: 100px">';
            item_pembelian += '<button type="button" class="btn btn-primary btn-sm" onclick="Surat_pesanan(' + key +
                ')">';
            item_pembelian += '<i class="fas fa-plus"></i>';
            item_pembelian += '</button>';
            item_pembelian +=
                '<button style="margin-left:10px" type="button" class="btn btn-danger btn-sm" onclick="removeBan(' +
                key + ')">';
            item_pembelian += '<i class="fas fa-trash"></i>';
            item_pembelian += '</button>';
            item_pembelian += '</td>';
            item_pembelian += '</tr>';

            $('#tabel-pembelian').append(item_pembelian);
        }
    </script>

    <script>
        var data_pembelian = @json(session('data_pembelians4'));
        var jumlah_ban = 1;

        if (data_pembelian != null) {
            jumlah_ban = data_pembelian.length;
            $('#tabel-memotambahan').empty();
            var urutan = 0;
            $.each(data_pembelian, function(key, value) {
                urutan = urutan + 1;
                itemPembelians(urutan, key, value);
            });
        }

        function updateUrutan() {
            var urutan = document.querySelectorAll('#urutantambahan');
            for (let i = 0; i < urutan.length; i++) {
                urutan[i].innerText = i + 1;
            }
        }

        var counter = 0;

        function addMemotambahan() {
            counter++;
            jumlah_ban = jumlah_ban + 1;

            if (jumlah_ban === 1) {
                $('#tabel-memotambahan').empty();
            }

            itemPembelians(jumlah_ban, jumlah_ban - 1);
            updateUrutan();
        }

        function removememotambahans(identifier, detailId) {
            var row = document.getElementById('memotambahan-' + identifier);
            row.remove();

            $.ajax({
                url: "{{ url('admin/inquery_fakturekspedisi/delettariftambahan/') }}/" + detailId,
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

            updateUrutan();

            updateGrandTotaltambahan();
            updateTotalPembayaran();
        }


        function itemPembelians(identifier, key, value = null) {
            var keterangan_tambahan = '';
            var nominal_tambahan = '';
            var qty_tambahan = '';
            var satuan_tambahan = '';

            if (value !== null) {
                keterangan_tambahan = value.keterangan_tambahan;
                nominal_tambahan = value.nominal_tambahan;
                qty_tambahan = value.qty_tambahan;
                satuan_tambahan = value.satuan_tambahan;
            }

            // urutan 
            var item_pembelian = '<tr id="memotambahan-' + urutan + '">';
            item_pembelian += '<td style="width: 70px; font-size:14px" class="text-center" id="urutantambahan">' + urutan +
                '</td>';

            // keterangan_tambahan 
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" style="font-size:14px" id="keterangan_tambahan-' +
                key +
                '" name="keterangan_tambahan[]" value="' + keterangan_tambahan + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // nominal_tambahan 
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" style="font-size:14px" id="nominal_tambahan-' +
                key +
                '" name="nominal_tambahan[]" value="' + nominal_tambahan + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // qty_tambahan 
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="number" class="form-control" style="font-size:14px" id="nominal_tambahan-' +
                urutan +
                '" name="qty_tambahan[]" value="' + qty_tambahan + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';


            // satuan_tambahan
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">';
            item_pembelian += '<select style="font-size:14px" class="form-control" id="satuan_tambahan-' + key +
                '" name="satuan_tambahan[]">';
            item_pembelian += '<option value="">- Pilih -</option>';
            item_pembelian += '<option value="M3"' + (satuan_tambahan === 'M3' ? ' selected' : '') +
                '>M&sup3;</option>';
            item_pembelian += '<option value="ton"' + (satuan_tambahan === 'ton' ? ' selected' : '') +
                '>ton</option>';
            item_pembelian += '<option value="krtn"' + (satuan_tambahan === 'krtn' ? ' selected' : '') +
                '>krtn</option>';
            item_pembelian += '<option value="dus"' + (satuan_tambahan === 'dus' ? ' selected' : '') +
                '>dus</option>';
            item_pembelian += '<option value="rit"' + (satuan_tambahan === 'rit' ? ' selected' : '') +
                '>rit</option>';
            item_pembelian += '<option value="kg"' + (satuan_tambahan === 'kg' ? ' selected' : '') +
                '>kg</option>';
            item_pembelian += '<option value="ltr"' + (satuan_tambahan === 'ltr' ? ' selected' : '') +
                '>ltr</option>';
            item_pembelian += '<option value="pcs"' + (satuan_tambahan === 'pcs' ? ' selected' : '') + '>pcs</option>';
            item_pembelian += '<option value="hr"' + (satuan_tambahan === 'hr' ? ' selected' : '') +
                '>hr</option>';
            item_pembelian += '<option value="ZAK"' + (satuan_tambahan === 'ZAK' ? ' selected' : '') +
                '>ZAK</option>';
            item_pembelian += '</select>';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            item_pembelian += '<td style="width: 50px">';
            item_pembelian +=
                '<button style="margin-left:5px" type="button" class="btn btn-danger btn-sm" onclick="removememotambahans(' +
                urutan + ')">';
            item_pembelian += '<i class="fas fa-trash"></i>';
            item_pembelian += '</button>';
            item_pembelian += '</td>';
            item_pembelian += '</tr>';

            $('#tabel-memotambahan').append(item_pembelian);
        }

        function updateGrandTotaltambahan() {
            var grandTotal = 0;
            // Loop through all elements with name "nominal_tambahan[]"
            $('input[name^="nominal_tambahan"]').each(function() {
                var nominalValue = parseFloat($(this).val()) || 0;
                grandTotal += nominalValue;
            });

            // $('#grand_total').val(grandTotal.toLocaleString(
            //     'id-ID'));

            $('#biaya_tambahan').val(grandTotal.toLocaleString('id-ID'));
        }

        $('body').on('input', 'input[name^="nominal_tambahan"]', function() {
            updateGrandTotaltambahan();
            updateTotalPembayaran();
        });

        $(document).ready(function() {
            updateGrandTotaltambahan();
        });
    </script>

@endsection
