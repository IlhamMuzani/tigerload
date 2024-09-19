@extends('layouts.app')

@section('title', 'Pembelian')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="modal fade" id="modal-pilihpo">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Pilih Po Pembelian</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div style="text-align: center;">
                        <form action="{{ url('admin/pembelianpo') }}" enctype="multipart/form-data" autocomplete="off"
                            method="post">
                            @csrf
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Pembelian</h3>
                                </div>
                                <div class="card-body">
                                    <div class="form-group" style="flex: 8;"> <!-- Adjusted flex value -->
                                        <select class="select2bs4 select2-hidden-accessible" name="po_pembelian_id"
                                            data-placeholder="Cari Po.." style="width: 100%;" data-select2-id="23"
                                            tabindex="-1" aria-hidden="true" id="po_pembelian_id" onchange="getData(0)">
                                            <option value="">- Pilih -</option>
                                            @foreach ($popembelians as $popembelian)
                                                <option value="{{ $popembelian->id }}"
                                                    {{ old('po_pembelian_id') == $popembelian->id ? 'selected' : '' }}>
                                                    {{ $popembelian->kode_po_pembelian }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group" hidden>
                                        <label for="id_popembelian">id popembelian</label>
                                        <input type="text" class="form-control" id="id_popembelian" name="id_popembelian"
                                            readonly placeholder="" value="{{ old('id_popembelian') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="kode_supplier">Kode Supplier</label>
                                        <input type="text" class="form-control" id="kode_supplier" name="kode_supplier"
                                            readonly placeholder="" value="{{ old('kode_supplier') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="nama_supplier">Nama Supplier</label>
                                        <input type="text" class="form-control" id="nama_supplier" name="nama_supplier"
                                            readonly placeholder="" value="{{ old('nama_supplier') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Tanggal</label>
                                        <input type="text" class="form-control" id="tanggal" name="tanggal" readonly
                                            placeholder="" value="{{ old('tanggal') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button type="submit" class="btn btn-primary">Lanjutkan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </section>

    <script>
        $(document).ready(function() {
            $('#modal-pilihpo').modal('show');
        });

        function getData(id) {
            var kendaraan_id = document.getElementById('po_pembelian_id');
            $.ajax({
                url: "{{ url('admin/pembelian/popembelian') }}" + "/" + po_pembelian_id.value,
                type: "GET",
                dataType: "json",
                success: function(po_pembelian_id) {

                    var popembelian = document.getElementById('id_popembelian');
                    popembelian.value = po_pembelian_id.id;

                    var kode_supplier = document.getElementById('kode_supplier');
                    kode_supplier.value = po_pembelian_id.supplier.kode_supplier;

                    var nama_supplier = document.getElementById('nama_supplier');
                    nama_supplier.value = po_pembelian_id.supplier.nama_supp;

                    var tanggal = document.getElementById('tanggal');
                    tanggal.value = po_pembelian_id.tanggal;
                },
            });
        }
    </script>
@endsection
