<li class="nav-header">
    Dashboard</li>
<li class="nav-item">
    <a href="{{ url('admin') }}" class="nav-link {{ request()->is('admin') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>
            Dashboard
        </p>
    </a>
</li>
<li class="nav-header">Search</li>

<div class="form-inline">
    <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
            <button class="btn btn-sidebar">
                <i class="fas fa-search fa-fw"></i>
            </button>
        </div>
    </div>
</div>
<li class="nav-header">Menu</li>
<li
    class="nav-item {{ request()->is('admin/karyawan*') ||
    request()->is('admin/gaji_karyawan*') ||
    request()->is('admin/akun*') ||
    request()->is('admin/supplier*') ||
    request()->is('admin/user*') ||
    request()->is('admin/akses*') ||
    request()->is('admin/departemen*') ||
    request()->is('admin/pelanggan*') ||
    request()->is('admin/merek*') ||
    request()->is('admin/typekaroseri*') ||
    request()->is('admin/barang*') ||
    request()->is('admin/barangnonbesi*') ||
    request()->is('admin/tipe*') ||
    request()->is('admin/kendaraan*')
        ? 'menu-open'
        : '' }}">
    <a href="#"
        class="nav-link {{ request()->is('admin/karyawan*') ||
        request()->is('admin/gaji_karyawan*') ||
        request()->is('admin/akun*') ||
        request()->is('admin/supplier*') ||
        request()->is('admin/user*') ||
        request()->is('admin/akses*') ||
        request()->is('admin/departemen*') ||
        request()->is('admin/pelanggan*') ||
        request()->is('admin/merek*') ||
        request()->is('admin/typekaroseri*') ||
        request()->is('admin/barang*') ||
        request()->is('admin/barangnonbesi*') ||
        request()->is('admin/tipe*') ||
        request()->is('admin/kendaraan*')
            ? 'active'
            : '' }}">

        <i class="nav-icon fas fa-grip-horizontal"></i>
        <p>
            <strong style="color: rgb(255, 255, 255);">MASTER</strong>
            <i class="right fas fa-angle-left"></i>
        </p>

    </a>
    <ul class="nav nav-treeview">
        @if (auth()->check() && auth()->user()->menu['karyawan'])
            <li class="nav-item">
                <a href="{{ url('admin/karyawan') }}"
                    class="nav-link {{ request()->is('admin/karyawan*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Data Karyawan</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['user'])
            <li class="nav-item">
                <a href="{{ url('admin/user') }}" class="nav-link {{ request()->is('admin/user*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Data User</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['akses'])
            <li class="nav-item">
                <a href="{{ url('admin/akses') }}" class="nav-link {{ request()->is('admin/akses*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Hak Akses</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['departemen'])
            <li class="nav-item">
                <a href="{{ url('admin/departemen') }}"
                    class="nav-link {{ request()->is('admin/departemen*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Data Departemen</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['gaji karyawan'])
            <li class="nav-item">
                <a href="{{ url('admin/gaji_karyawan') }}"
                    class="nav-link {{ request()->is('admin/gaji_karyawan*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Data Gaji Karyawan</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['supplier'])
            <li class="nav-item">
                <a href="{{ url('admin/supplier') }}"
                    class="nav-link {{ request()->is('admin/supplier*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Data Supplier</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['pelanggan'])
            <li class="nav-item">
                <a href="{{ url('admin/pelanggan') }}"
                    class="nav-link {{ request()->is('admin/pelanggan*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Data Pelanggan</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['merek'])
            <li class="nav-item">
                <a href="{{ url('admin/merek') }}"
                    class="nav-link {{ request()->is('admin/merek*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Data Merek Kendaraan</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['merek'])
            <li class="nav-item">
                <a href="{{ url('admin/tipe') }}" class="nav-link {{ request()->is('admin/tipe*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Data Type</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['type karoseri'])
            <li class="nav-item">
                <a href="{{ url('admin/typekaroseri') }}"
                    class="nav-link {{ request()->is('admin/typekaroseri*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Data Produk</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['barang'])
            <li class="nav-item">
                <a href="{{ url('admin/barang') }}"
                    class="nav-link {{ request()->is('admin/barang*') || request()->is('admin/barangnonbesi*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Data Barang</p>
                </a>
            </li>
        @endif
        {{-- @if (auth()->check() && auth()->user()->menu['kendaraan'])
            <li class="nav-item">
                <a href="{{ url('admin/kendaraan') }}"
                    class="nav-link {{ request()->is('admin/kendaraan*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Data Kendaraan</p>
                </a>
            </li>
        @endif --}}
        @if (auth()->check() && auth()->user()->menu['barang'])
            <li class="nav-item">
                <a href="{{ url('admin/list_dokument') }}" class="nav-link {{ request()->is('admin/list_dokument*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Data Dokumen Project</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['barang'])
            <li class="nav-item">
                <a href="{{ url('admin/akun') }}" class="nav-link {{ request()->is('admin/akun*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Data Barang Akun</p>
                </a>
            </li>
        @endif
    </ul>
</li>

<li
    class="nav-item {{ request()->is('admin/pengambilanbahan*') ||
    request()->is('admin/perhitungan_gaji*') ||
    request()->is('admin/kasbon_karyawan*') ||
    request()->is('admin/popembelian*') ||
    request()->is('admin/pembelian*') ||
    request()->is('admin/surat_penawaran*') ||
    request()->is('admin/spk*') ||
    request()->is('admin/penawaran*') ||
    request()->is('admin/pelunasan_penjualan*') ||
    request()->is('admin/penjualan*') ||
    request()->is('admin/deposit_pemesanan*') ||
    request()->is('admin/pengeluaran_kaskecil*') ||
    request()->is('admin/tablepengeluaran*') ||
    request()->is('admin/return_pembelian*') ||
    request()->is('admin/tablesurat*') ||
    request()->is('admin/tablepesanan*') ||
    request()->is('admin/tabledeposit*') ||
    request()->is('admin/tablepengambilanbahan*') ||
    request()->is('admin/tablepenjualan*') ||
    request()->is('admin/tablepelunasan*') ||
    request()->is('admin/tablepembelian*') ||
    request()->is('admin/tablepelunasanpembelian*') ||
    request()->is('admin/tablereturn*') ||
    request()->is('admin/tablepopembelian*') ||
    request()->is('admin/tablekasbon*') ||
    request()->is('admin/penerimaan_pembayaran*') ||
    request()->is('admin/perintah_kerja*') ||
    request()->is('admin/perhitungan_bahanbaku*') ||
    request()->is('admin/dokumen_project*') ||
    request()->is('admin/invoice_suratpesanan*') ||
    request()->is('admin/pelunasan_pembelian*')
        ? 'menu-open'
        : '' }}">
    <a href="#"
        class="nav-link {{ request()->is('admin/pengambilanbahan*') ||
        request()->is('admin/perhitungan_gaji*') ||
        request()->is('admin/kasbon_karyawan*') ||
        request()->is('admin/popembelian*') ||
        request()->is('admin/pembelian*') ||
        request()->is('admin/surat_penawaran*') ||
        request()->is('admin/spk*') ||
        request()->is('admin/penawaran*') ||
        request()->is('admin/pelunasan_penjualan*') ||
        request()->is('admin/penjualan*') ||
        request()->is('admin/deposit_pemesanan*') ||
        request()->is('admin/pengeluaran_kaskecil*') ||
        request()->is('admin/tablepengeluaran*') ||
        request()->is('admin/return_pembelian*') ||
        request()->is('admin/tablesurat*') ||
        request()->is('admin/tablepesanan*') ||
        request()->is('admin/tabledeposit*') ||
        request()->is('admin/tablepengambilanbahan*') ||
        request()->is('admin/tablepenjualan*') ||
        request()->is('admin/tablepelunasan*') ||
        request()->is('admin/tablepembelian*') ||
        request()->is('admin/tablepelunasanpembelian*') ||
        request()->is('admin/tablereturn*') ||
        request()->is('admin/tablepopembelian*') ||
        request()->is('admin/tablekasbon*') ||
        request()->is('admin/penerimaan_pembayaran*') ||
        request()->is('admin/perintah_kerja*') ||
        request()->is('admin/perhitungan_bahanbaku*') ||
        request()->is('admin/dokumen_project*') ||
        request()->is('admin/invoice_suratpesanan*') ||
        request()->is('admin/pelunasan_pembelian*')
            ? 'active'
            : '' }}">

        <i class="nav-icon fas fa-exchange-alt"></i>
        <p>
            <strong style="color: rgb(255, 255, 255);">TRANSAKSI</strong>
            <i class="right fas fa-angle-left"></i>
        </p>

    </a>
    <ul class="nav nav-treeview">
        @if (auth()->check() && auth()->user()->menu['perhitungan gaji'])
            <li class="nav-item">
                <a href="{{ url('admin/perhitungan_gaji') }}"
                    class="nav-link {{ request()->is('admin/perhitungan_gaji*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Perhitungan Gaji Karyawan</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['memo hutang karyawan'])
            <li class="nav-item">
                <a href="{{ url('admin/tablekasbon') }}"
                    class="nav-link {{ request()->is('admin/kasbon_karyawan*') || request()->is('admin/tablekasbon*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Memo Hutang Karyawan</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['po pembelian'])
            <li class="nav-item">
                <a href="{{ url('admin/tablepopembelian') }}"
                    class="nav-link {{ request()->is('admin/popembelian*') || request()->is('admin/tablepopembelian*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Purchase Order Pembelian</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['pembelian'])
            <li class="nav-item">
                <a href="{{ url('admin/tablepembelian') }}"
                    class="nav-link {{ request()->is('admin/pembelian*') || request()->is('admin/tablepembelian*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Faktur Pembelian</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['pelunasan pembelian'])
            <li class="nav-item">
                <a href="{{ url('admin/tablepelunasanpembelian') }}"
                    class="nav-link {{ request()->is('admin/pelunasan_pembelian*') || request()->is('admin/tablepelunasanpembelian*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Pelunasan Pembelian</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['pembelian'])
            <li class="nav-item">
                <a href="{{ url('admin/tablereturn') }}"
                    class="nav-link {{ request()->is('admin/return_pembelian*') || request()->is('admin/tablereturn*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Return Pembelian</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['surat penawaran karoseri'])
            <li class="nav-item">
                <a href="{{ url('admin/tablesurat') }}"
                    class="nav-link {{ request()->is('admin/surat_penawaran*') || request()->is('admin/tablesurat*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Surat Penawaran</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['spk'])
            <li class="nav-item">
                <a href="{{ url('admin/penerimaan_pembayaran') }}"
                    class="nav-link {{ request()->is('admin/penerimaan_pembayaran*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 13px;">Surat Penerimaan Pembayaran</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['spk'])
            <li class="nav-item">
                <a href="{{ url('admin/tablepesanan') }}"
                    class="nav-link {{ request()->is('admin/spk*') || request()->is('admin/tablepesanan*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Surat Pesanan</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['spk'])
            <li class="nav-item">
                <a href="{{ url('admin/perintah_kerja') }}"
                    class="nav-link {{ request()->is('admin/perintah_kerja*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Surat Perintah Kerja</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['deposit pemesanan'])
            <li class="nav-item">
                <a href="{{ url('admin/tabledeposit') }}"
                    class="nav-link {{ request()->is('admin/deposit_pemesanan*') || request()->is('admin/tabledeposit*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Deposit Pemesanan</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['pengambilan bahan baku'])
            <li class="nav-item">
                <a href="{{ url('admin/tablepengambilanbahan') }}"
                    class="nav-link {{ request()->is('admin/pengambilanbahan*') || request()->is('admin/tablepengambilanbahan*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Pengambilan Bahan Baku</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['pengambilan bahan baku'])
            <li class="nav-item">
                <a href="{{ url('admin/perhitungan_bahanbaku') }}"
                    class="nav-link {{ request()->is('admin/perhitungan_bahanbaku*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Perhitungan Pemakain-<br>
                        <span style="margin-left: 32px">Bahan Baku</span>
                    </p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['penjualan'])
            <li class="nav-item">
                <a href="{{ url('admin/dokumen_project') }}"
                    class="nav-link {{ request()->is('admin/dokumen_project*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Dokumen Project</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['penjualan'])
            <li class="nav-item">
                <a href="{{ url('admin/tablepenjualan') }}"
                    class="nav-link {{ request()->is('admin/penjualan*') || request()->is('admin/tablepenjualan*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Faktur Penjualan</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['pelunasan'])
            <li class="nav-item">
                <a href="{{ url('admin/tablepelunasanpenjualan') }}"
                    class="nav-link {{ request()->is('admin/pelunasan_penjualan*') || request()->is('admin/tablepelunasanpenjualan*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Pelunasan Penjualan</p>
                </a>
            </li>
        @endif
        {{-- @if (auth()->check() && auth()->user()->menu['pelunasan'])
            <li class="nav-item">
                <a href="{{ url('admin/invoice_suratpesanan') }}"
                    class="nav-link {{ request()->is('admin/invoice_suratpesanan*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Invoice Surat Pesanan</p>
                </a>
            </li>
        @endif --}}
        @if (auth()->check() && auth()->user()->menu['pengambilan kas kecil'])
            <li class="nav-item">
                <a href="{{ url('admin/tablepengeluaran') }}"
                    class="nav-link {{ request()->is('admin/tablepengeluaran*') || request()->is('admin/pengeluaran_kaskecil*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Pengambilan kas kecil</p>
                </a>
            </li>
        @endif
    </ul>
</li>

<li
    class="nav-item {{ request()->is('admin/inquery_pengambilanbahan*') ||
    request()->is('admin/inquery_perhitungangaji*') ||
    request()->is('admin/penerimaan_kaskecil*') ||
    request()->is('admin/inquery_kasbonkaryawan*') ||
    request()->is('admin/inquery_popembelian*') ||
    request()->is('admin/inquery_pembelian*') ||
    request()->is('admin/inquery_pembelianreturn*') ||
    request()->is('admin/inquery_fakturpelunasanpembelian*') ||
    request()->is('admin/inquery_pelunasan*') ||
    request()->is('admin/inquery_deposit*') ||
    request()->is('admin/inquery_spk*') ||
    request()->is('admin/inquery_penawaran*') ||
    request()->is('admin/inquery_penerimaankaskecil*') ||
    request()->is('admin/inquery_pengeluarankaskecil*') ||
    request()->is('admin/inquery_penerimaanpembayaran*') ||
    request()->is('admin/inquery_perintahkerja*') ||
    request()->is('admin/inquery_perhitunganbahanbaku*') ||
    request()->is('admin/inquery_dokumenproject*') ||
    request()->is('admin/inquery_invoicesuratpesanan*') ||
    request()->is('admin/inquery_penjualan*')
        ? 'menu-open'
        : '' }}">
    <a href="#"
        class="nav-link {{ request()->is('admin/inquery_pengambilanbahan*') ||
        request()->is('admin/inquery_perhitungangaji*') ||
        request()->is('admin/penerimaan_kaskecil*') ||
        request()->is('admin/inquery_kasbonkaryawan*') ||
        request()->is('admin/inquery_popembelian*') ||
        request()->is('admin/inquery_pembelian*') ||
        request()->is('admin/inquery_pembelianreturn*') ||
        request()->is('admin/inquery_fakturpelunasanpembelian*') ||
        request()->is('admin/inquery_pelunasan*') ||
        request()->is('admin/inquery_deposit*') ||
        request()->is('admin/inquery_spk*') ||
        request()->is('admin/inquery_penawaran*') ||
        request()->is('admin/inquery_penerimaankaskecil*') ||
        request()->is('admin/inquery_pengeluarankaskecil*') ||
        request()->is('admin/inquery_penerimaanpembayaran*') ||
        request()->is('admin/inquery_perintahkerja*') ||
        request()->is('admin/inquery_perhitunganbahanbaku*') ||
        request()->is('admin/inquery_dokumenproject*') ||
        request()->is('admin/inquery_invoicesuratpesanan*') ||
        request()->is('admin/inquery_penjualan*')
            ? 'active'
            : '' }}">

        <i class="nav-icon fas fa-exchange-alt"></i>
        <p>
            <strong style="color: rgb(255, 255, 255);">FINANCE</strong>
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        @if (auth()->check() && auth()->user()->menu['saldo kas kecil'])
            <li class="nav-item">
                <a href="{{ url('admin/penerimaan_kaskecil') }}"
                    class="nav-link {{ request()->is('admin/penerimaan_kaskecil*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Saldo Kas Kecil</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['inquery saldo kas kecil'])
            <li class="nav-item">
                <a href="{{ url('admin/inquery_penerimaankaskecil') }}"
                    class="nav-link {{ request()->is('admin/inquery_penerimaankaskecil*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Inquery Saldo Kas Kecil
                    </p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['inquery perhitungan gaji'])
            <li class="nav-item">
                <a href="{{ url('admin/inquery_perhitungangaji') }}"
                    class="nav-link {{ request()->is('admin/inquery_perhitungangaji*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Inquery Perhitungan Gaji
                    </p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['inquery memo hutang karyawan'])
            <li class="nav-item">
                <a href="{{ url('admin/inquery_kasbonkaryawan') }}"
                    class="nav-link {{ request()->is('admin/inquery_kasbonkaryawan*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Inquery Memo Hutang-<br>
                        <span style="margin-left: 32px">Karyawan</span>
                    </p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['inquery po pembelian'])
            <li class="nav-item">
                <a href="{{ url('admin/inquery_popembelian') }}"
                    class="nav-link {{ request()->is('admin/inquery_popembelian*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Inquery Purchase Order -<br>
                        <span style="margin-left: 32px">Pembelian</span>
                    </p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['inquery pembelian'])
            <li class="nav-item">
                <a href="{{ url('admin/inquery_pembelian') }}"
                    class="nav-link {{ request()->is('admin/inquery_pembelian*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Inquery Pembelian</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['inquery pelunasan pembelian'])
            <li class="nav-item">
                <a href="{{ url('admin/inquery_fakturpelunasanpembelian') }}"
                    class="nav-link {{ request()->is('admin/inquery_fakturpelunasanpembelian*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Inquery Pelunasan -<br>
                        <span style="margin-left: 32px">Pembelian</span>
                    </p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['inquery pembelian'])
            <li class="nav-item">
                <a href="{{ url('admin/inquery_pembelianreturn') }}"
                    class="nav-link {{ request()->is('admin/inquery_pembelianreturn*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Inquery Return Pembelian</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['inquery surat penawaran'])
            <li class="nav-item">
                <a href="{{ url('admin/inquery_penawaran') }}"
                    class="nav-link {{ request()->is('admin/inquery_penawaran*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Inquery Surat Penawaran</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['inquery surat penawaran'])
            <li class="nav-item">
                <a href="{{ url('admin/inquery_penerimaanpembayaran') }}"
                    class="nav-link {{ request()->is('admin/inquery_penerimaanpembayaran*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Inquery Surat -<br>
                        <span style="margin-left: 32px">Penerimaan Pembayaran</span>
                    </p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['inquery spk'])
            <li class="nav-item">
                <a href="{{ url('admin/inquery_spk') }}"
                    class="nav-link {{ request()->is('admin/inquery_spk*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Inquery Surat Pesanan</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['inquery spk'])
            <li class="nav-item">
                <a href="{{ url('admin/inquery_perintahkerja') }}"
                    class="nav-link {{ request()->is('admin/inquery_perintahkerja*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Inquery Surat Perintah Kerja</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['inquery pengambilan bahan baku'])
            <li class="nav-item">
                <a href="{{ url('admin/inquery_pengambilanbahan') }}"
                    class="nav-link {{ request()->is('admin/inquery_pengambilanbahan*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Inquery Pengambilan -<br>
                        <span style="margin-left: 32px">Bahan Baku</span>
                    </p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['inquery pengambilan bahan baku'])
            <li class="nav-item">
                <a href="{{ url('admin/inquery_perhitunganbahanbaku') }}"
                    class="nav-link {{ request()->is('admin/inquery_perhitunganbahanbaku*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Inquery Perhitungan-<br>
                        <span style="margin-left: 32px">Pengambilan Bahan Baku</span>
                    </p>
                </a>
            </li>
        @endif
        {{-- @if (auth()->check() && auth()->user()->menu['inquery penjualan'])
            <li class="nav-item">
                <a href="{{ url('admin/inquery_dokumenproject') }}"
                    class="nav-link {{ request()->is('admin/inquery_dokumenproject*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Inquery Dokumen Project</p>
                </a>
            </li>
        @endif --}}
        @if (auth()->check() && auth()->user()->menu['inquery deposit'])
            <li class="nav-item">
                <a href="{{ url('admin/inquery_deposit') }}"
                    class="nav-link {{ request()->is('admin/inquery_deposit*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Inquery Deposit</p>
                </a>
            </li>
        @endif
        {{-- @if (auth()->check() && auth()->user()->menu['inquery penjualan'])
            <li class="nav-item">
                <a href="{{ url('admin/inquery_invoicesuratpesanan') }}"
                    class="nav-link {{ request()->is('admin/inquery_invoicesuratpesanan*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Inquery Invoice-<br>
                        <span style="margin-left: 32px">Surat Pesanan</span>
                    </p>
                </a>
            </li>
        @endif --}}
        @if (auth()->check() && auth()->user()->menu['inquery penjualan'])
            <li class="nav-item">
                <a href="{{ url('admin/inquery_penjualan') }}"
                    class="nav-link {{ request()->is('admin/inquery_penjualan*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Inquery Penjualan</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['inquery pelunasan'])
            <li class="nav-item">
                <a href="{{ url('admin/inquery_pelunasan') }}"
                    class="nav-link {{ request()->is('admin/inquery_pelunasan*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Inquery Pelunasan -<br>
                        <span style="margin-left: 32px">Penjualan</span>
                    </p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['inquery pengambilan kas kecil'])
            <li class="nav-item">
                <a href="{{ url('admin/inquery_pengeluarankaskecil') }}"
                    class="nav-link {{ request()->is('admin/inquery_pengeluarankaskecil*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 13px;">Inquery Pengambilan Kas Kecil
                    </p>
                </a>
            </li>
        @endif
    </ul>
</li>

<li
    class="nav-item {{ request()->is('admin/laporan_pengambilanbahan*') ||
    request()->is('admin/laporan_perhitungangaji*') ||
    request()->is('admin/laporan_kasbonkaryawan*') ||
    request()->is('admin/laporan_pembelian*') ||
    request()->is('admin/laporan_popembelian*') ||
    request()->is('admin/laporan_spk*') ||
    request()->is('admin/laporan_deposit*') ||
    request()->is('admin/laporan_pelunasan*') ||
    request()->is('admin/laporan_returnpembelian*') ||
    request()->is('admin/laporan_fakturpelunasanpembelian*') ||
    request()->is('admin/laporan_suratpenawaran*') ||
    request()->is('admin/laporan_penerimaanpembayaran*') ||
    request()->is('admin/laporan_perintahkerja*') ||
    request()->is('admin/laporan_perhitunganbahan*') ||
    request()->is('admin/laporan_dokumenproject*') ||
    request()->is('admin/laporan_penjualan*')
        ? 'menu-open'
        : '' }}">
    <a href="#"
        class="nav-link {{ request()->is('admin/laporan_pengambilanbahan*') ||
        request()->is('admin/laporan_perhitungangaji*') ||
        request()->is('admin/laporan_kasbonkaryawan*') ||
        request()->is('admin/laporan_pembelian*') ||
        request()->is('admin/laporan_popembelian*') ||
        request()->is('admin/laporan_spk*') ||
        request()->is('admin/laporan_deposit*') ||
        request()->is('admin/laporan_pelunasan*') ||
        request()->is('admin/laporan_returnpembelian*') ||
        request()->is('admin/laporan_fakturpelunasanpembelian*') ||
        request()->is('admin/laporan_suratpenawaran*') ||
        request()->is('admin/laporan_penerimaanpembayaran*') ||
        request()->is('admin/laporan_perintahkerja*') ||
        request()->is('admin/laporan_perhitunganbahan*') ||
        request()->is('admin/laporan_dokumenproject*') ||
        request()->is('admin/laporan_penjualan*')
            ? 'active'
            : '' }}">

        <i class="nav-icon fas fa-clipboard-list"></i>
        <p>
            <strong style="color: rgb(255, 255, 255);">LAPORAN</strong>
            <i class="right fas fa-angle-left"></i>
        </p>

    </a>
    <ul class="nav nav-treeview">
        @if (auth()->check() && auth()->user()->menu['laporan po pembelian'])
            <li class="nav-item">
                <a href="{{ url('admin/laporan_popembelian') }}"
                    class="nav-link {{ request()->is('admin/laporan_popembelian*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Laporan Purchase Order -<br>
                        <span style="margin-left: 32px">Pembelian</span>
                    </p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['laporan pembelian'])
            <li class="nav-item">
                <a href="{{ url('admin/laporan_pembelian') }}"
                    class="nav-link {{ request()->is('admin/laporan_pembelian*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Laporan Pembelian</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['laporan pembelian'])
            <li class="nav-item">
                <a href="{{ url('admin/laporan_returnpembelian') }}"
                    class="nav-link {{ request()->is('admin/laporan_returnpembelian*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Laporan Return Pembelian</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['laporan spk'])
            <li class="nav-item">
                <a href="{{ url('admin/laporan_suratpenawaran') }}"
                    class="nav-link {{ request()->is('admin/laporan_suratpenawaran*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Laporan Surat Penawaran</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['laporan spk'])
            <li class="nav-item">
                <a href="{{ url('admin/laporan_penerimaanpembayaran') }}"
                    class="nav-link {{ request()->is('admin/laporan_penerimaanpembayaran*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Laporan Surat -<br>
                        <span style="margin-left: 32px">Penerimaan Pembayaran</span>
                    </p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['laporan spk'])
            <li class="nav-item">
                <a href="{{ url('admin/laporan_spk') }}"
                    class="nav-link {{ request()->is('admin/laporan_spk*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Laporan Surat Pesanan</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['laporan spk'])
            <li class="nav-item">
                <a href="{{ url('admin/laporan_perintahkerja') }}"
                    class="nav-link {{ request()->is('admin/laporan_perintahkerja*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Laporan Surat Perintah Kerja</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['laporan pengambilan bahan baku'])
            <li class="nav-item">
                <a href="{{ url('admin/laporan_pengambilanbahan') }}"
                    class="nav-link {{ request()->is('admin/laporan_pengambilanbahan*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Laporan Pengambilan -<br>
                        <span style="margin-left: 32px">Bahan Baku</span>
                    </p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['laporan pengambilan bahan baku'])
            <li class="nav-item">
                <a href="{{ url('admin/laporan_perhitunganbahan') }}"
                    class="nav-link {{ request()->is('admin/laporan_perhitunganbahan*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Laporan Perhitungan -<br>
                        <span style="margin-left: 32px">Pengambilan Bahan Baku</span>
                    </p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['laporan pengambilan bahan baku'])
            <li class="nav-item">
                <a href="{{ url('admin/laporan_dokumenproject') }}"
                    class="nav-link {{ request()->is('admin/laporan_dokumenproject*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Laporan Dokumen Project
                    </p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['laporan deposit'])
            <li class="nav-item">
                <a href="{{ url('admin/laporan_deposit') }}"
                    class="nav-link {{ request()->is('admin/laporan_deposit*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Laporan Deposit</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['laporan penjualan'])
            <li class="nav-item">
                <a href="{{ url('admin/laporan_penjualan') }}"
                    class="nav-link {{ request()->is('admin/laporan_penjualan*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Laporan Penjualan</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['laporan pelunasan'])
            <li class="nav-item">
                <a href="{{ url('admin/laporan_pelunasan') }}"
                    class="nav-link {{ request()->is('admin/laporan_pelunasan*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Laporan Pelunasan -<br>
                        <span style="margin-left: 32px">Penjualan</span>
                    </p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['laporan pelunasan'])
            <li class="nav-item">
                <a href="{{ url('admin/laporan_fakturpelunasanpembelian') }}"
                    class="nav-link {{ request()->is('admin/laporan_fakturpelunasanpembelian*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Laporan Pelunasan -<br>
                        <span style="margin-left: 32px">Faktur Pembelian</span>
                    </p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['laporan pelunasan'])
            <li class="nav-item">
                <a href="{{ url('admin/pilih_laporankaskecil') }}"
                    class="nav-link {{ request()->is('admin/pilih_laporankaskecil*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Laporan Kas Kecil</p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['laporan pelunasan'])
            <li class="nav-item">
                <a href="{{ url('admin/laporan_kasbonkaryawan') }}"
                    class="nav-link {{ request()->is('admin/laporan_kasbonkaryawan*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Laporan Memo Hutang-<br>
                        <span style="margin-left: 32px">Karyawan</span>
                    </p>
                </a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->menu['laporan pelunasan'])
            <li class="nav-item">
                <a href="{{ url('admin/laporan_perhitungangaji') }}"
                    class="nav-link {{ request()->is('admin/laporan_perhitungangaji*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                    <p style="font-size: 14px;">Laporan Gaji Karyawan</p>
                </a>
            </li>
        @endif
    </ul>
</li>
<li class="nav-header">Profile</li>
<li class="nav-item">
    <a href="{{ url('admin/profile') }}" class="nav-link {{ request()->is('admin/profile') ? 'active' : '' }}">
        <i class="nav-icon fas fa-user-edit"></i>
        <p>Update Profile</p>
    </a>
<li class="nav-item">
    <a href="#" data-toggle="modal" data-target="#modalLogout" class="nav-link">
        <i class="nav-icon fas fa-sign-out-alt"></i>
        <p>Logout</p>
    </a>
</li>
