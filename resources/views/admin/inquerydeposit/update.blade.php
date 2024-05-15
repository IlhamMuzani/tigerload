@extends('layouts.app')

@section('title', 'Inquery Deposit Pemesanan')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Inquery Deposit Pemesanan</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/inquery_deposit') }}">Inquery Deposit Pemesanan</a>
                        </li>
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
            <form action="{{ url('admin/inquery_deposit/' . $deposits->id) }}" method="POST" enctype="multipart/form-data"
                autocomplete="off">
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
                            <label for="nopol">Id SPK</label>
                            <input type="text" class="form-control" id="spk_id" name="spk_id"
                                value="{{ old('spk_id', $deposits->spk->id) }}" readonly placeholder="" value="">
                        </div>
                        <div class="form-group">
                            <label for="nopol">Kode SPK</label>
                            <input type="text" class="form-control" id="kode_spk" readonly placeholder=""
                                value="{{ old('kode_spk', $deposits->spk->kode_spk) }}">
                        </div>
                        <div class="form-group">
                            <label for="nopol">Nama Pelanggan</label>
                            <input type="text" class="form-control" id="nama_pelanggan" readonly placeholder=""
                                value="{{ old('nama_pelanggan', $deposits->spk->pelanggan->nama_pelanggan) }}">
                        </div>
                        <div class="form-group">
                            <label for="nama">Merek Kendaraan</label>
                            <input type="text" class="form-control" id="merek" readonly placeholder=""
                                value="{{ old('nama_merek', $deposits->spk->detail_kendaraan->first()->merek->nama_merek) }}">
                        </div>
                        <div class="form-group">
                            <label for="nama">Type Kendaraan</label>
                            <input type="text" class="form-control" id="tipe" readonly placeholder=""
                                value="{{ old('nama_tipe', $deposits->spk->detail_kendaraan->first()->merek->tipe->nama_tipe) }}">
                        </div>
                        <div class="form-group">
                            <label for="nama">Kode Karoseri</label>
                            <input type="text" class="form-control" id="kode_type"readonly placeholder=""
                                value="{{ old('kode_tipe', $deposits->spk->typekaroseri->kode_type) }}">
                        </div>
                        <div class="form-group">
                            <label for="nama">Bentuk Karoseri</label>
                            <input type="text" class="form-control" id="nama_karoseri" readonly placeholder=""
                                value="{{ old('nama_karoseri', $deposits->spk->typekaroseri->nama_karoseri) }}">
                        </div>
                        <div class="form-group">
                            <label for="nama">Harga Pemesanan</label>
                            <input type="text" class="form-control" id="harga_awal" name="harga_awal" readonly
                                placeholder=""
                                value="{{ number_format(old('harga_awal', $deposits->spk->harga), 0, ',', '.') }}">
                        </div>
                        <div class="form-group mb-3">
                            <label for="nama">DP</label>
                            <input type="text" class="form-control" id="harga" name="harga" placeholder=""
                                value="{{ number_format(old('harga', $deposits->harga), 0, ',', '.') }}"
                                oninput="formatRupiahform(this)"
                                onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="reset" class="btn btn-secondary">Reset</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
            {{-- </div> --}}
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
                                            <td>{{ $spk->kode_spk }}</td>
                                            <td>{{ $spk->pelanggan->nama_pelanggan }}</td>
                                            <td>{{ $spk->detail_kendaraan->first()->merek->nama_merek }}</td>
                                            <td>{{ $spk->detail_kendaraan->first()->merek->tipe->nama_tipe }}</td>
                                            <td>{{ $spk->typekaroseri->kode_type }}</td>
                                            <td>{{ $spk->typekaroseri->nama_karoseri }}</td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    onclick="getSelectedData('{{ $spk->id }}', '{{ $spk->kode_spk }}', '{{ $spk->pelanggan->nama_pelanggan }}',
                                                    '{{ $spk->detail_kendaraan->first()->merek->nama_merek }}',
                                                     '{{ $spk->detail_kendaraan->first()->merek->tipe->nama_tipe }}',
                                                     '{{ $spk->typekaroseri->kode_type }}',
                                                     '{{ $spk->typekaroseri->nama_karoseri }}',
                                                      '{{ $spk->harga }}')">
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

        function getSelectedData(Spk_id, KodeSPK, NamaPelanggan, Merek, Type, KodeKaroseri, BentukKaroseri, Harga) {
            // Set the values in the form fields
            document.getElementById('spk_id').value = Spk_id;
            document.getElementById('kode_spk').value = KodeSPK;
            document.getElementById('nama_pelanggan').value = KodeSPK;
            document.getElementById('merek').value = Merek;
            document.getElementById('tipe').value = Type;
            document.getElementById('kode_type').value = KodeKaroseri;
            document.getElementById('nama_karoseri').value = BentukKaroseri;

            var formattedNominal = parseFloat(Harga).toLocaleString('id-ID');
            document.getElementById('harga_awal').value = formattedNominal;
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
@endsection
