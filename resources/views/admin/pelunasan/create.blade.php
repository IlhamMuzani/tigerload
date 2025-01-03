@extends('layouts.app')

@section('title', 'Faktur Pelunasan Penjualan')

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
                    <h1 class="m-0">Faktur Pelunasan Penjualan</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/pelunasan_penjualan') }}">Faktur Pelunasan
                                Penjualan</a>
                        </li>
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
                        <i class="icon fas fa-ban"></i> Gagal!
                    </h5>
                    @foreach (session('error') as $error)
                        - {{ $error }} <br>
                    @endforeach
                </div>
            @endif
            <form action="{{ url('admin/pelunasan_penjualan') }}" method="POST" enctype="multipart/form-data"
                autocomplete="off">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tambah</h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 mt-4">
                            <button class="btn btn-primary btn-sm" type="button" onclick="showPenjualan(this.value)">
                                <i class="fas fa-plus mr-2"></i> Pilih Faktur Penjualan
                            </button>
                        </div>

                        <div hidden class="form-group">
                            <label for="penjualan_id">Penjualan Id</label>
                            <input type="text" class="form-control" id="penjualan_id" readonly name="penjualan_id"
                                placeholder="" value="{{ old('penjualan_id') }}">
                        </div>
                        <div class="form-group">
                            <label for="nopol">Kode Faktur Penjualan</label>
                            <input type="text" class="form-control" id="kode_penjualan" name="kode_penjualan" readonly
                                placeholder="" value="{{ old('kode_penjualan') }}">
                        </div>
                        <div class="form-group">
                            <label for="nopol">Nama Pelanggan</label>
                            <input type="text" class="form-control" name="nama_pelanggan" id="nama_pelanggan" readonly
                                placeholder="" value="{{ old('nama_pelanggan') }}">
                        </div>
                        <div class="form-group">
                            <label for="nama">Tanggal Penjualan</label>
                            <input type="text" class="form-control" name="tanggal" id="tanggal" readonly placeholder=""
                                value="{{ old('tanggal') }}">
                        </div>
                        <div class="form-group">
                            <label for="nama">Total</label>
                            <input type="text" class="form-control" name="total" id="total" readonly placeholder=""
                                value="{{ old('total') }}">
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="modal-header">
                        <h4 class="modal-title">Data Item Tambahan</h4>
                    </div>
                    <div class="modal-body">
                        <table id="detail_penjualan" class="table table-bordered table-striped">
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
                            <tbody>
                                {{-- data  --}}
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Rincian Pembelian</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="potongan">Potongan Penjualan</label>
                                    <input type="number" class="form-control" id="potongan" name="potongan"
                                        placeholder="masukkan potong" value="{{ old('potongan') }}">
                                </div>
                                <div class="form-group">
                                    <label for="panjang">Kategori Pembayaran</label>
                                    <select class="form-control" id="kategori" name="kategori">
                                        <option value="">- Pilih -</option>
                                        <option value="Bilyet Giro"
                                            {{ old('kategori') == 'Bilyet Giro' ? 'selected' : null }}>
                                            Bilyet Giro BG / Cek</option>
                                        <option value="Transfer" {{ old('kategori') == 'Transfer' ? 'selected' : null }}>
                                            Transfer</option>
                                        <option value="Tunai" {{ old('kategori') == 'Tunai' ? 'selected' : null }}>
                                            Tunai</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label id="bg" for="lebar">No. BG/Cek</label>
                                    <label id="trans" for="lebar">No. Transfer</label>
                                    <label id="tun" for="lebar">Tunai</label>
                                    <input type="text" class="form-control" id="nomor" name="nomor"
                                        placeholder="masukkan no" value="{{ old('nomor') }}">
                                </div>
                                <div class="form-group">
                                    <label for="tinggi">Tanggal</label>
                                    <div class="input-group date" id="reservationdatetime">
                                        <input type="date" id="tanggal" name="tanggal_transfer"
                                            placeholder="d M Y sampai d M Y"
                                            data-options='{"mode":"range","dateFormat":"d M Y","disableMobile":true}'
                                            value="{{ old('tanggal_transfer') }}"
                                            class="form-control datetimepicker-input" data-target="#reservationdatetime">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="tinggi">Nominal</label>
                                    <input type="text" class="form-control" id="nominal"
                                        placeholder="masukkan nominal" name="nominal" value="{{ old('nominal') }}">
                                </div>
                            </div>
                            <div class="col-md-6" style="margin-left: 80px">
                                <div class="form-group">
                                    <label for="totalpenjualan">Sub Total</label>
                                    <input style="text-align: end" type="text" class="form-control"
                                        id="totalpembayaran" readonly name="totalpenjualan" placeholder=""
                                        value="{{ old('totalpenjualan') }}">
                                </div>
                                <div class="form-group">
                                    <label for="tinggi">Biaya Tambahan</label>
                                    <input style="text-align: end" type="text" class="form-control"
                                        id="biaya_tambahan" readonly name="biaya_tambahan" placeholder=""
                                        value="{{ old('biaya_tambahan') }}">
                                </div>
                                <div class="form-group">
                                    <label for="tinggi">DP</label>
                                    <input style="text-align: end" type="text" class="form-control" id="dp"
                                        readonly name="dp" placeholder="" value="{{ old('dp') }}">
                                </div>
                                <div class="form-group">
                                    <label for="tinggi">Potongan</label>
                                    <input style="text-align: end" type="text" class="form-control"
                                        id="potonganselisih" readonly name="potonganselisih" placeholder=""
                                        value="{{ old('potonganselisih') }}">
                                </div>
                                <hr style="border: 2px solid black;">
                                <div class="form-group">
                                    <label for="tinggi">Total Pembayaran</label>
                                    <input style="text-align: end" type="text" class="form-control" id="KurangiDP"
                                        readonly name="totalpembayaran" value="{{ old('totalpembayaran') }}"
                                        placeholder="">
                                </div>
                                <div class="form-group">
                                    <label for="tinggi">Selisih Pembayaran</label>
                                    <input style="text-align: end" type="text" class="form-control" id="hasilDP"
                                        readonly name="selisih" value="{{ old('selisih') }}" placeholder="">
                                </div>
                            </div>
                        </div>
                    </div>
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
                        <div class="m-2">
                            <input type="text" id="searchInput" class="form-control" placeholder="Search...">
                        </div>
                        <div class="table-responsive scrollbar m-2">
                            <table id="tables" class="table table-bordered table-striped">
                                <thead class="bg-200 text-900">
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Kode Penjualan</th>
                                        <th>Kode SPK</th>
                                        <th>Nama Pelanggan</th>
                                        <th>Tanggal</th>
                                        <th>DP</th>
                                        <th>Biaya Tambahan</th>
                                        <th>Total</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($penjualans as $penjualan)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $penjualan->kode_penjualan }}</td>
                                            <td>{{ $penjualan->perintah_kerja->kode_perintah }}</td>
                                            <td>
                                                @if ($penjualan->perintah_kerja)
                                                    {{ $penjualan->perintah_kerja->spk->pelanggan->nama_pelanggan }}
                                                @else
                                                    {{ $penjualan->perintah_kerja->spk->pelanggan->nama_pelanggan }}
                                                @endif
                                            </td>
                                            <td>{{ $penjualan->tanggal }}</td>
                                            <td>Rp
                                                @if ($penjualan->perintah_kerja)
                                                    @if ($penjualan->perintah_kerja)
                                                        {{ number_format($penjualan->perintah_kerja->depositpemesanan->sum('harga'), 0, ',', '.') }}
                                                    @else
                                                        0
                                                    @endif
                                                @else
                                                    0
                                                @endif
                                            </td>
                                            <td>Rp
                                                @if ($penjualan->detail_penjualan)
                                                    {{ number_format($penjualan->detail_penjualan->sum('total'), 0, ',', '.') }}
                                                @else
                                                    0
                                                @endif
                                            </td>
                                            <td>Rp
                                                @if ($penjualan->perintah_kerja)
                                                    {{ number_format($penjualan->perintah_kerja->spk->harga + $penjualan->detail_penjualan->where('penjualan_id', $penjualan->id)->sum('harga'), 0, ',', '.') }}
                                                @else
                                                    {{ number_format($penjualan->perintah_kerja->spk->harga + $penjualan->detail_penjualan->where('penjualan_id', $penjualan->id)->sum('harga'), 0, ',', '.') }}
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    onclick="getSelectedData('{{ $penjualan->id }}',
                                                    '{{ $penjualan->kode_penjualan }}',
                                                    '@if ($penjualan->perintah_kerja) {{ $penjualan->perintah_kerja->spk->pelanggan->nama_pelanggan }} @else {{ $penjualan->spk->pelanggan->nama_pelanggan }} @endif',
                                                    '{{ $penjualan->tanggal }}',
                                                    '@if ($penjualan->perintah_kerja) {{ number_format($penjualan->perintah_kerja->spk->harga, 0, ',', '.') }}@else {{ number_format($penjualan->spk->harga, 0, ',', '.') }} @endif',
                                                    '@if ($penjualan->perintah_kerja) {{ number_format($penjualan->perintah_kerja->spk->harga, 0, ',', '.') }}@else{{ number_format($penjualan->spk->harga, 0, ',', '.') }} @endif',
                                                    '@if ($penjualan->perintah_kerja) @if ($penjualan->perintah_kerja)  {{ number_format($penjualan->perintah_kerja->depositpemesanan->sum('harga'), 0, ',', '.') }} @endif
@else
{{ 0 }} @endif',
                                                    '@if ($penjualan->perintah_kerja) @if ($penjualan->perintah_kerja)  {{ number_format($penjualan->perintah_kerja->spk->harga - $penjualan->perintah_kerja->depositpemesanan->sum('harga') + $penjualan->detail_penjualan->sum('total'), 0, ',', '.') }} @endif @else{{ number_format($penjualan->perintah_kerja->spk->harga + $penjualan->detail_penjualan->where('penjualan_id', $penjualan->id)->sum('harga'), 0, ',', '.') }} @endif',
                                                    '@if ($penjualan->detail_penjualan) {{ number_format($penjualan->detail_penjualan->sum('total'), 0, ',', '.') }}@else {{ 0 }} @endif',
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
        // filter rute 
        function filterMemo() {
            var input, filter, table, tr, td, i, txtValue;
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
        document.getElementById("searchInput").addEventListener("input", filterMemo);
    </script>

    <script>
        PenyamaanDP()

        function PenyamaanDP() {
            function formatRupiah(angka) {
                var reverse = angka.toString().split('').reverse().join(''),
                    ribuan = reverse.match(/\d{1,3}/g);
                ribuan = ribuan.join('.').split('').reverse().join('');
                return ribuan;
            }

            document.getElementById('potonganselisih').value = '0';

            // Mendengarkan perubahan pada input "potongan"
            document.getElementById('potongan').addEventListener('input', function() {
                var potonganValue = this.value;
                if (potonganValue === '') {
                    document.getElementById('potonganselisih').value = '0'; // Set to 0 when 'potongan' is empty
                } else {
                    var formattedValue = formatRupiah(potonganValue);
                    document.getElementById('potonganselisih').value = formattedValue;
                }
            });

        }


        PenyamaanSelisih()

        function PenyamaanSelisih() {

            document.getElementById('hasilDP').value = '0';

            // Mendengarkan perubahan pada input "potongan"
            document.getElementById('nominal').addEventListener('input', function() {
                var potonganValue = this.value;
                if (potonganValue === '') {
                    document.getElementById('hasilDP').value = '0'; // Set to 0 when 'potongan' is empty
                } else {
                    var formattedValue = formatRupiah(potonganValue);
                    document.getElementById('hasilDP').value = formattedValue;
                }
            });

        }

        Potongan()

        function Potongan() {
            // pembayaran 
            function hapusTitik(string) {
                return string.replace(/\./g, '');
            }

            // Fungsi untuk mengubah angka menjadi format mata uang Rupiah
            function formatRupiah(angka) {
                var reverse = angka.toString().split('').reverse().join('');
                var ribuan = reverse.match(/\d{1,3}/g);
                var formatted = ribuan.join('.').split('').reverse().join('');
                return 'Rp ' + formatted;
            }


            // Fungsi untuk menghitung selisih dan menampilkannya
            function hitungSelisih() {
                // Dapatkan nilai dari input "Total Pembayaran" dan hapus titik
                var totalPembayaranInput = document.getElementById('totalpembayaran');
                var totalPembayaranValue = totalPembayaranInput.value;
                var totalPembayaran = parseFloat(hapusTitik(totalPembayaranValue)) || 0;

                var DpInput = document.getElementById('dp');
                var DpPembayaranValue = DpInput.value;
                var DpPembayaran = parseFloat(hapusTitik(DpPembayaranValue)) || 0;

                // Dapatkan nilai dari input "Nominal" dan hapus titik
                var nominalInput = document.getElementById('potongan');
                var nominalValue = nominalInput.value;
                var nominal = parseFloat(hapusTitik(nominalValue)) || 0;

                // Dapatkan nilai dari input "Biaya" dan hapus titik
                var biayaTambahanInput = document.getElementById('biaya_tambahan');
                var biayaTambahanlValue = biayaTambahanInput.value;
                var biayaTambahan = parseFloat(hapusTitik(biayaTambahanlValue)) || 0;

                // Hitung selisih
                var selisih = totalPembayaran - DpPembayaran - nominal + biayaTambahan;

                // Tampilkan hasil selisih dalam format mata uang Rupiah dengan tanda negatif
                var hasilDP = document.getElementById('KurangiDP');

                // Tambahkan tanda negatif jika selisih negatif
                if (selisih < 0) {
                    hasilDP.value = '-' + formatRupiah(-selisih);
                } else {
                    hasilDP.value = ' ' + formatRupiah(selisih);
                }

                // Jika Anda ingin menampilkan selisih dalam format lain, sesuaikan kode di atas.
            }


            // Panggil fungsi hitungSelisih saat input "Nominal" berubah
            document.getElementById('potongan').addEventListener('input', hitungSelisih);

            // Panggil fungsi hitungSelisih saat halaman dimuat (untuk menginisialisasi nilai selisih)
            window.addEventListener('load', hitungSelisih);
        }

        Hasil()

        function Hasil() {
            function hapusTitik(string) {
                return string.replace(/\./g, '');
            }

            // Fungsi untuk mengubah angka menjadi format mata uang Rupiah
            function formatRupiah(angka) {
                var reverse = angka.toString().split('').reverse().join('');
                var ribuan = reverse.match(/\d{1,3}/g);
                var formatted = ribuan.join('.').split('').reverse().join('');
                return 'Rp ' + formatted;
            }


            // Fungsi untuk menghitung selisih dan menampilkannya
            function hitungSelisih() {
                // Dapatkan nilai dari input "Total Pembayaran" dan hapus titik
                var totalPembayaranInput = document.getElementById('totalpembayaran');
                var totalPembayaranValue = totalPembayaranInput.value;
                var totalPembayaran = parseFloat(hapusTitik(totalPembayaranValue)) || 0;

                var DpInput = document.getElementById('dp');
                var DpPembayaranValue = DpInput.value;
                var DpPembayaran = parseFloat(hapusTitik(DpPembayaranValue)) || 0;

                // Dapatkan nilai dari input "Nominal" dan hapus titik
                var potonganInput = document.getElementById('potongan');
                var potonganValue = potonganInput.value;
                var potongans = parseFloat(hapusTitik(potonganValue)) || 0;

                var nominalInput = document.getElementById('nominal');
                var nominalValue = nominalInput.value;
                var nominal = parseFloat(hapusTitik(nominalValue)) || 0;

                // Dapatkan nilai dari input "Biaya" dan hapus titik
                var biayaTambahanInput = document.getElementById('biaya_tambahan');
                var biayaTambahanlValue = biayaTambahanInput.value;
                var biayaTambahan = parseFloat(hapusTitik(biayaTambahanlValue)) || 0;

                // Hitung selisih
                var selisih = totalPembayaran - DpPembayaran - potongans - nominal + biayaTambahan;

                // Tampilkan hasil selisih dalam format mata uang Rupiah dengan tanda negatif
                var hasilDP = document.getElementById('hasilDP');

                // Tambahkan tanda negatif jika selisih negatif
                if (selisih < 0) {
                    hasilDP.value = ' ' + formatRupiah(selisih);
                } else {
                    hasilDP.value = '-' + formatRupiah(-selisih);
                }
            }
            document.getElementById('nominal').addEventListener('input', hitungSelisih);
            window.addEventListener('load', hitungSelisih);
        }


        function toggleLabels() {
            var kategori = document.getElementById('kategori');
            var bgLabel = document.getElementById('bg');
            var transLabel = document.getElementById('trans');
            var tunLabel = document.getElementById('tun');
            var Nomor = document.getElementById('nomor');

            if (kategori.value === 'Bilyet Giro') {
                bgLabel.style.display = 'block';
                transLabel.style.display = 'none';
                tunLabel.style.display = 'none';
                Nomor.style.display = 'block';
            } else if (kategori.value === 'Transfer') {
                bgLabel.style.display = 'none';
                transLabel.style.display = 'block';
                tunLabel.style.display = 'none';
                Nomor.style.display = 'block';
            } else if (kategori.value === 'Tunai') {
                bgLabel.style.display = 'none';
                transLabel.style.display = 'none';
                tunLabel.style.display = 'none';
                Nomor.style.display = 'none';
            }
        }

        // Call the function initially to set the initial visibility based on the default selection
        toggleLabels();

        // Add an event listener to trigger the function when the dropdown value changes
        document.getElementById('kategori').addEventListener('change', toggleLabels);


        function showPenjualan(selectedCategory) {
            $('#tablePenjualan').modal('show');
        }

        function getSelectedData(Penjualan_id, KodePenjualan, NamaPelanggan, Tanggal, Total, TotalPenjualan, Dp, hasilDP,
            Biayatambahan) {
            // Set the values in the form fields
            document.getElementById('penjualan_id').value = Penjualan_id;
            document.getElementById('kode_penjualan').value = KodePenjualan;
            document.getElementById('nama_pelanggan').value = NamaPelanggan;
            document.getElementById('tanggal').value = Tanggal;
            document.getElementById('total').value = Total;
            document.getElementById('totalpembayaran').value = TotalPenjualan;
            document.getElementById('dp').value = Dp;
            document.getElementById('KurangiDP').value = hasilDP;
            document.getElementById('biaya_tambahan').value = Biayatambahan;
            // Close the modal (if needed)

            $('#penjualan_id').trigger('input');

            $('#tablePenjualan').modal('hide');
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
        function formatRupiah(amount) {
            // Convert amount to a string and add commas as thousand separators
            return 'Rp ' + amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }
    </script>
    <script>
        $(document).ready(function() {
            $('#penjualan_id').on('input', function() {
                var pelangganID = $(this).val();

                if (pelangganID) {
                    $.ajax({
                        url: "{{ url('admin/pelunasan/get_itemtambahan') }}" + '/' +
                            pelangganID,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('#detail_penjualan tbody').empty();
                            if (data.length > 0) {
                                $.each(data, function(index, details) {
                                    var formattedHarga = formatRupiah(details.harga);
                                    var formattedTotal = formatRupiah(details.total);
                                    var row = '<tr>' +
                                        '<td class="text-center">' + (index + 1) +
                                        '</td>' +
                                        '<td hidden>' + details.id + '</td>' +
                                        '<td>' + details.kode_types + '</td>' +
                                        '<td>' + details.nama_karoseri + '</td>' +
                                        '<td>' + details.jumlah + '</td>' +
                                        '<td>' + formattedHarga + '</td>' +
                                        '<td>' + details.diskon + '</td>' +
                                        '<td>' + formattedTotal + '</td>' +
                                        '</td>' +
                                        '</tr>';
                                    $('#detail_penjualan tbody').append(row);
                                });
                            } else {
                                $('#detail_penjualan tbody').append(
                                    '<tr><td colspan="7" class="text-center">No data available</td></tr>'
                                );
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error("AJAX Error:", status, error);
                            $('#detail_penjualan tbody').empty();
                            $('#detail_penjualan tbody').append(
                                '<tr><td colspan="7" class="text-center">Error loading data</td></tr>'
                            );
                        }
                    });
                } else {
                    $('#detail_penjualan tbody').empty();
                    $('#detail_penjualan tbody').append(
                        '<tr><td colspan="7" class="text-center">No data available</td></tr>'
                    );
                }
            });

            // Trigger the input event manually on page load if there's a value in the penjualan_id field
            if ($('#penjualan_id').val()) {
                $('#penjualan_id').trigger('input');
            }
        });
    </script>
@endsection
