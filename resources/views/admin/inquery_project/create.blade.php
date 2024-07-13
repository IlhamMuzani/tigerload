@extends('layouts.app')

@section('title', 'Faktur Deposit Pemesanan')

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
                    <h1 class="m-0">Faktur Deposit Pemesanan</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/project') }}">Faktur Deposit
                                Pemesanan</a></li>
                        <li class="breadcrumb-item active">Tambah</li>
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
            <form action="{{ url('admin/project') }}" method="POST" enctype="multipart/form-data"
                autocomplete="off">
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
                            <label for="nopol">Id SPK</label>
                            <input type="text" class="form-control" id="perintah_kerja_id" name="perintah_kerja_id"
                                value="{{ old('perintah_kerja_id') }}" readonly placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="nopol">Kode SPK</label>
                            <input type="text" class="form-control" id="kode_perintah" readonly placeholder=""
                                name="kode_perintah" value="{{ old('kode_perintah') }}">
                        </div>
                        <div class="form-group">
                            <label for="nopol">Jenis Karoseri</label>
                            <input type="text" class="form-control" id="nama_karoseri" readonly placeholder=""
                                name="nama_karoseri" value="{{ old('nama_karoseri') }}">
                        </div>
                        <div class="form-group">
                            <label for="nama">Tahun Karoseri</label>
                            <input type="text" class="form-control" id="tahun" readonly placeholder="" name="tahun"
                                value="{{ old('tahun') }}">
                        </div>
                        <div class="form-group">
                            <label for="nama">No Serut</label>
                            <input type="text" class="form-control" id="no_serut" readonly placeholder=""
                                name="no_serut" value="{{ old('no_serut') }}">
                        </div>
                        <div class="form-group">
                            <label for="nama">No Rangka</label>
                            <input type="text" class="form-control" id="no_rangka"readonly placeholder=""
                                name="no_rangka" value="{{ old('no_rangka') }}">
                        </div>
                    </div>
                    <div class="card-footer text-right mt-3">
                        <button type="reset" class="btn btn-secondary" id="btnReset">Reset</button>
                        <button type="submit" class="btn btn-primary" id="btnSimpan">Simpan</button>
                        <div id="loading" style="display: none;">
                            <i class="fas fa-spinner fa-spin"></i> Sedang Menyimpan...
                        </div>
                    </div>
                </div>
            </form>
            {{-- </div> --}}
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
                                        <th>Jenis Karoseri</th>
                                        <th>Tahun</th>
                                        <th>No Serut</th>
                                        <th>No Rangka</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($spks as $spk)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $spk->kode_perintah }}</td>
                                            <td>
                                                @if ($spk->spk)
                                                    {{ $spk->spk->typekaroseri->nama_karoseri }}
                                                @else
                                                    tidak ada
                                                @endif
                                            </td>
                                            <td>
                                                @if ($spk->dokumen_project->first())
                                                    {{ $spk->dokumen_project->first()->tahun }}
                                                @else
                                                    tidak ada
                                                @endif
                                            </td>
                                            <td>
                                                @if ($spk->dokumen_project->first())
                                                    {{ $spk->dokumen_project->first()->no_serut }}
                                                @else
                                                    tidak ada
                                                @endif
                                            </td>
                                            <td>
                                                @if ($spk->dokumen_project->first())
                                                    {{ $spk->dokumen_project->first()->no_rangka }}
                                                @else
                                                    tidak ada
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    onclick="getSelectedData(
                                                        '{{ $spk->id }}',
                                                        '{{ $spk->kode_perintah }}',
                                                        '{{ $spk->spk->typekaroseri->nama_karoseri }}',
                                                        '{{ $spk->dokumen_project->first() ? $spk->dokumen_project->first()->tahun : 'tidak ada' }}',
                                                        '{{ $spk->dokumen_project->first() ? $spk->dokumen_project->first()->no_serut : 'tidak ada' }}',
                                                        '{{ $spk->dokumen_project->first() ? $spk->dokumen_project->first()->no_rangka : 'tidak ada' }}'
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
        function showSpk(selectedCategory) {
            $('#tableSpk').modal('show');
        }

        function getSelectedData(Spk_id, KodeSPK, JenisKendaraan, Tahun, NoSerut, NoRangka) {
            // Set the values in the form fields
            document.getElementById('perintah_kerja_id').value = Spk_id;
            document.getElementById('kode_perintah').value = KodeSPK;
            document.getElementById('nama_karoseri').value = JenisKendaraan;
            document.getElementById('tahun').value = Tahun;
            document.getElementById('no_serut').value = NoSerut;
            document.getElementById('no_rangka').value = NoRangka;
            $('#tableSpk').modal('hide');
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

@endsection
