<div class="sidebar sidebar-style-2">
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-primary">
                <li class="nav-item {{ request()->is('admin/beranda') || request()->is('admin/beranda/*') ? 'active' : '' }}">
                    <a href="{{ route('admin.index') }}">
                        <i class="fas fa-home"></i>
                        <p>Beranda</p>
                    </a>
                </li>
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Internship</h4>
                </li>
                <li class="nav-item {{ request()->is('admin/transaksi/') || request()->is('admin/transaksi/*') ? 'active' : '' }}">
                    <a href="{{ route('admin.transaksi.index') }}">
                        <i class="fas fa-envelope"></i>
                        <p>Permintaan Internship</p>
                    </a>
                </li>
                 <li class="nav-item {{ request()->is('admin/transaksi/') || request()->is('admin/transaksi/*') ? 'active' : '' }}">
                    <a href="{{ route('admin.transaksi.index') }}">
                        <i class="fas fa-users"></i>
                        <p>Peserta Internship</p>
                    </a>
                </li>
                 <li class="nav-item {{ request()->is('admin/transaksi/') || request()->is('admin/transaksi/*') ? 'active' : '' }}">
                    <a href="{{ route('admin.transaksi.index') }}">
                        <i class="fas fa-star"></i>
                        <p>Sertifikat & Penilaian</p>
                    </a>
                </li>
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Laporan</h4>
                </li>
                <li class="nav-item {{ request()->is('admin/laporan/') || request()->is('admin/laporan/*') ? 'active' : '' }}">
                    <a href="{{ route('admin.transaksi.index') }}">
                        <i class="fas fa-file-pdf"></i>
                        <p>Laporan Absensi</p>
                    </a>
                </li>
                <li class="nav-item {{ request()->is('admin/laporan/') || request()->is('admin/laporan/*') ? 'active' : '' }}">
                    <a href="{{ route('admin.transaksi.index') }}">
                        <i class="fas fa-file-pdf"></i>
                        <p>Laporan Aktifitas</p>
                    </a>
                </li>
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Master Data</h4>
                </li>
                @if(permission([1,2,3,5]))
                <li class="nav-item {{ request()->is('admin/master/divisi') || request()->is('admin/master/divisi/*') ? 'active' : '' }}">
                    <a href="{{ route('admin.master.divisi.index') }}">
                        <i class="fas fa-clipboard"></i>
                        <p>Divisi</p>
                    </a>
                </li>
                <li class="nav-item {{ request()->is('admin/master/jurusan') || request()->is('admin/master/jurusan/*') ? 'active' : '' }}">
                    <a href="{{ route('admin.master.jurusan.index') }}">
                        <i class="fas fa-layer-group"></i>
                        <p>Jurusan</p>
                    </a>
                </li>
                <li class="nav-item {{ request()->is('admin/master/statusSurat') || request()->is('admin/master/statusSurat/*') ? 'active' : '' }}">
                    <a href="{{ route('admin.master.statusSurat.index') }}">
                        <i class="fas fa-tag"></i>
                        <p>Status Surat</p>
                    </a>
                </li>
                <li class="nav-item {{ request()->is('admin/laporan') || request()->is('admin/laporan/*') ? 'active' : '' }}">
                    <a href="{{ route('admin.transaksi.index') }}">
                        <i class="fas fa-user"></i>
                        <p>User</p>
                    </a>
                </li>
                @endif
                
                @if(permission([1,2,3,5]))
                 
                @endif
            </ul>
        </div>
    </div>
</div>