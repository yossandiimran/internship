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
                {{-- Sidebar untuk hak akses group_user level 1 (ADMIN) --}}
                @if(permission([1]))
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Internship</h4>
                </li>
                <li class="nav-item {{ request()->is('admin/permintaan') || request()->is('admin/permintaan/*') ? 'active' : '' }}">
                    <a href="{{ route('admin.permintaan.index') }}">
                        <i class="fas fa-envelope"></i>
                        <p>Permintaan Internship</p>
                    </a>
                </li>
                 <li class="nav-item {{ request()->is('admin/peserta') || request()->is('admin/peserta/*') ? 'active' : '' }}">
                    <a href="{{ route('admin.peserta.index') }}">
                        <i class="fas fa-users"></i>
                        <p>Peserta Internship</p>
                    </a>
                </li>
                 <li class="nav-item {{ request()->is('admin/sertifikat') || request()->is('admin/sertifikat/*') ? 'active' : '' }}">
                    <a href="{{ route('admin.sertifikat.index') }}">
                        <i class="fas fa-star"></i>
                        <p>Sertifikat & Penilaian</p>
                    </a>
                </li>
                @endif
                @if(permission([1]))
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Laporan</h4>
                </li>
                <li class="nav-item {{ request()->is('admin/jobdesc') || request()->is('admin/jobdesc/*') ? 'active' : '' }}">
                    <a href="{{ route('admin.jobdesc.index') }}">
                        <i class="fas fa-calendar"></i>
                        <p>Jobdesc & Aktifitas</p>
                    </a>
                </li>
                <li class="nav-item {{ request()->is('admin/absensi') || request()->is('admin/absensi/*') ? 'active' : '' }}">
                    <a href="{{ route('admin.absensi.index') }}">
                        <i class="fas fa-file-pdf"></i>
                        <p>Laporan Kehadiran</p>
                    </a>
                </li>
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Master Data</h4>
                </li>
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
                @endif
                {{-- Sidebar untuk hak akses group_user level 2 (internship) --}}
                @if(permission([2]))
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Internship</h4>
                </li>
                  <li class="nav-item {{ request()->is('admin/InternshipMember/profile') || request()->is('admin/InternshipMember/profile/*') ? 'active' : '' }}">
                    <a href="{{ route('admin.internshipMember.profile.index') }}">
                        <i class="fas fa-user"></i>
                        <p>Profile</p>
                    </a>
                </li>
                <li class="nav-item {{ request()->is('admin/InternshipMember/pengajuan') || request()->is('admin/InternshipMember/pengajuan/*') ? 'active' : '' }}">
                    <a href="{{ route('admin.internshipMember.pengajuan.index') }}">
                        <i class="fas fa-envelope"></i>
                        <p>Pengajuan Internship</p>
                    </a>
                </li>
                 <li class="nav-item {{ request()->is('admin/InternshipMember/penilaian') || request()->is('admin/InternshipMember/penilaian/*') ? 'active' : '' }}">
                    <a href="{{ route('admin.internshipMember.penilaian.index') }}">
                        <i class="fas fa-star"></i>
                        <p>Sertifikat & Penilaian</p>
                    </a>
                </li>
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Activity</h4>
                </li>
                <li class="nav-item {{ request()->is('admin/InternshipMember/jobdesc') || request()->is('admin/InternshipMember/jobdesc/*') ? 'active' : '' }}">
                    <a href="{{ route('admin.internshipMember.jobdesc.index') }}">
                        <i class="fas fa-list"></i>
                        <p>Jobdesc</p>
                    </a>
                </li>
                 <li class="nav-item {{ request()->is('admin/InternshipMember/absensi') || request()->is('admin/InternshipMember/absensi/*') ? 'active' : '' }}">
                    <a href="{{ route('admin.internshipMember.absensi.index') }}">
                        <i class="fas fa-clock"></i>
                        <p>Absensi</p>
                    </a>
                </li>
                @endif
            </ul>
        </div>
    </div>
</div>