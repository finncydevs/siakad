<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('admin.dashboard') }}" class="app-brand-link">
            <span class="app-brand-logo demo">
                {{-- SVG Logo Anda --}}
                <svg width="25" viewBox="0 0 25 42" version="1.1" xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink">
                    <defs>
                        <path
                            d="M13.7918663,0.358365126 L3.39788168,7.44174259 C0.566865006,9.69408886 -0.379795268,12.4788597 0.557900856,15.7960551 C0.68998853,16.2305145 1.09562888,17.7872135 3.12357076,19.2293357 C3.8146334,19.7207684 5.32369333,20.3834223 7.65075054,21.2172976 L7.59773219,21.2525164 L2.63468769,24.5493413 C0.445452254,26.3002124 0.0884951797,28.5083815 1.56381646,31.1738486 C2.83770406,32.8170431 5.20850219,33.2640127 7.09180128,32.5391577 C8.347334,32.0559211 11.4559176,30.0011079 16.4175519,26.3747182 C18.0338572,24.4997857 18.6973423,22.4544883 18.4080071,20.2388261 C17.963753,17.5346866 16.1776345,15.5799961 13.0496516,14.3747546 L10.9194936,13.4715819 L18.6192054,7.984237 L13.7918663,0.358365126 Z"
                            id="path-1"></path>
                        <path
                            d="M5.47320593,6.00457225 C4.05321814,8.216144 4.36334763,10.0722806 6.40359441,11.5729822 C8.61520715,12.571656 10.0999176,13.2171421 10.8577257,13.5094407 L15.5088241,14.433041 L18.6192054,7.984237 C15.5364148,3.11535317 13.9273018,0.573395879 13.7918663,0.358365126 C13.5790555,0.511491653 10.8061687,2.3935607 5.47320593,6.00457225 Z"
                            id="path-3"></path>
                        <path
                            d="M7.50063644,21.2294429 L12.3234468,23.3159332 C14.1688022,24.7579751 14.397098,26.4880487 13.008334,28.506154 C11.6195701,30.5242593 10.3099883,31.790241 9.07958868,32.3040991 C5.78142938,33.4346997 4.13234973,34 4.13234973,34 C4.13234973,34 2.75489982,33.0538207 2.37032616e-14,31.1614621 C-0.55822714,27.8186216 -0.55822714,26.0572515 -4.05231404e-15,25.8773518 C0.83734071,25.6075023 2.77988457,22.8248993 3.3049379,22.52991 C3.65497346,22.3332504 5.05353963,21.8997614 7.50063644,21.2294429 Z"
                            id="path-4"></path>
                        <path
                            d="M20.6,7.13333333 L25.6,13.8 C26.2627417,14.6836556 26.0836556,15.9372583 25.2,16.6 C24.8538077,16.8596443 24.4327404,17 24,17 L14,17 C12.8954305,17 12,16.1045695 12,15 C12,14.5672596 12.1403557,14.1461923 12.4,13.8 L17.4,7.13333333 C18.0627417,6.24967773 19.3163444,6.07059163 20.2,6.73333333 C20.3516113,6.84704183 20.4862915,6.981722 20.6,7.13333333 Z"
                            id="path-5"></path>
                    </defs>
                    <g id="g-app-brand" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <g id="Brand-Logo" transform="translate(-27.000000, -15.000000)">
                            <g id="Icon" transform="translate(27.000000, 15.000000)">
                                <g id="Mask" transform="translate(0.000000, 8.000000)">
                                    <mask id="mask-2" fill="white">
                                        <use xlink:href="#path-1"></use>
                                    </mask>
                                    <use fill="#696cff" xlink:href="#path-1"></use>
                                    <g id="Path-3" mask="url(#mask-2)">
                                        <use fill="#696cff" xlink:href="#path-3"></use>
                                        <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-3"></use>
                                    </g>
                                    <g id="Path-4" mask="url(#mask-2)">
                                        <use fill="#696cff" xlink:href="#path-4"></use>
                                        <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-4"></use>
                                    </g>
                                </g>
                                <g id="Triangle"
                                    transform="translate(19.000000, 11.000000) rotate(-300.000000) translate(-19.000000, -11.000000) ">
                                    <use fill="#696cff" xlink:href="#path-5"></use>
                                    <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-5"></use>
                                </g>
                            </g>
                        </g>
                    </g>
                </svg>
            </span>
            <span class="app-brand-text demo menu-text fw-bolder ms-2">Sekull</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">

        <li class="menu-item {{ request()->is('admin/dashboard') ? 'active' : '' }}">
            <a href="{{ route('admin.dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Dashboard">Dashboard</div>
            </a>
        </li>

        <li class="menu-item {{ request()->is('admin/pengaturan/profil_sekolah*') ? 'active' : '' }}">
            <a href="{{ route('admin.pengaturan.profil_sekolah.edit') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-school"></i>
                <div data-i18n="Profil Sekolah">Profil Sekolah</div>
            </a>
        </li>

        <li class="menu-item {{ request()->is('admin/kepegawaian*') ? 'open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bxs-user-badge"></i>
                <div data-i18n="Kepegawaian">Kepegawaian</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->is('admin/kepegawaian/pegawai*') ? 'active' : '' }}">
                    <a href="{{ route('admin.kepegawaian.pegawai.index') }}" class="menu-link">
                        <div data-i18n="Data Pegawai">Data Pegawai</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('admin/kepegawaian/tugas-pegawai*') ? 'active' : '' }}">
                    <a href="{{ route('admin.kepegawaian.tugas-pegawai.index') }}" class="menu-link">
                        <div data-i18n="Tugas Pegawai">Tugas Pegawai</div>
                    </a>
                </li>
            </ul>
        </li>

        <li class="menu-item {{ request()->is('admin/akademik*') ? 'open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bxs-book-content"></i>
                <div data-i18n="Akademik">Akademik</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->is('admin/akademik/tapel*') ? 'active' : '' }}">
                    <a href="{{ route('admin.akademik.tapel.index') }}" class="menu-link">
                        <div data-i18n="Tahun Pelajaran">Tahun Pelajaran</div>
                    </a>
                </li>
                {{-- <li class="menu-item {{ request()->is('admin/akademik/semester*') ? 'active' : '' }}">
                    <a href="{{ route('admin.akademik.semester.index') }}" class="menu-link">
                        <div data-i18n="Semester">Semester</div>
                    </a>
                </li> --}}
                <li class="menu-item {{ request()->is('admin/akademik/jurusan*') ? 'active' : '' }}">
                    <a href="{{ route('admin.akademik.jurusan.index') }}" class="menu-link">
                        <div data-i18n="Jurusan">Konsentrasi Keahlian</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('admin/akademik/mapel*') ? 'active' : '' }}">
                    <a href="{{ route('admin.akademik.semester.index') }}" class="menu-link">
                        <div data-i18n="Semester">Mapel</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('admin/akademik/ekstarakulikuler*') ? 'active' : '' }}">
                    <a href="{{ route('admin.akademik.semester.index') }}" class="menu-link">
                        <div data-i18n="Semester">Ekstrakulikuler</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('admin/akademik/jadwal*') ? 'active' : '' }}">
                    <a href="{{ route('admin.akademik.jadwal.index') }}" class="menu-link">
                        <div data-i18n="Jadwal Pelajaran">Jadwal Pelajaran</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Absensi -->
        <li class="menu-item {{ request()->is('admin/absensi*') || request()->is('guru/absensi*') ? 'open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-calendar-check"></i>
                <div data-i18n="Absensi">Absensi</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('admin.absensi.siswa.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.absensi.siswa.index') }}" class="menu-link">
                        <div data-i18n="Absensi Harian">Absensi Harian</div>
                    </a>
                </li>
                
                {{-- INI MENU BARU UNTUK QR SCANNER --}}
                <li class="menu-item {{ request()->routeIs('admin.absensi.siswa.show_scanner') ? 'active' : '' }}">
                    <a href="{{ route('admin.absensi.siswa.show_scanner') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-qr-scan"></i>
                        <div data-i18n="Scan Absensi QR">Scan Absensi QR</div>
                    </a>
                </li>
                {{-- AKHIR MENU BARU --}}
                <li class="menu-item {{ request()->is('admin/absensi/izin-siswa*') ? 'active' : '' }}">
                <a href="{{ route('admin.absensi.izin-siswa.index') }}" class="menu-link">
                    <div data-i18n="Manajemen Izin Siswa">Manajemen Izin Siswa</div>
                </a>
            </li>

                <li class="menu-item {{ request()->routeIs('guru.absensi.index') ? 'active' : '' }}">
                    <a href="{{ route('guru.absensi.index') }}" class="menu-link">
                        <div data-i18n="Absensi Mengajar">Absensi Mengajar (Guru)</div>
                    </a>
                </li>
            </ul>
        </li>

        <li class="menu-item {{ request()->is('admin/kesiswaan*') ? 'open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-user-check"></i>
                <div data-i18n="Kesiswaan">Kesiswaan</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->is('admin/kesiswaan/ppdb*') ? 'open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <div data-i18n="PPDB">PPDB</div>
                    </a>
                    <ul class="menu-sub">
                        <li
                            class="menu-item {{ request()->routeIs('admin.kesiswaan.ppdb.tahun-ppdb.index') ? 'active' : '' }}">
                            <a href="{{ route('admin.kesiswaan.ppdb.tahun-ppdb.index') }}" class="menu-link">
                                <div data-i18n="Tahun PPDB">Tahun PPDB</div>
                            </a>
                        </li>
                        <li
                            class="menu-item {{ request()->routeIs('admin.kesiswaan.ppdb.jalur-ppdb.index') ? 'active' : '' }}">
                            <a href="{{ route('admin.kesiswaan.ppdb.jalur-ppdb.index') }}" class="menu-link">
                                <div data-i18n="Jalur Pendaftaran">Jalur Pendaftaran</div>
                            </a>
                        </li>
                        <li
                            class="menu-item {{ request()->routeIs('admin.kesiswaan.ppdb.quota-ppdb.index') ? 'active' : '' }}">
                            <a href="{{ route('admin.kesiswaan.ppdb.quota-ppdb.index') }}" class="menu-link">
                                <div data-i18n="Quota">Quota Pendaftaran</div>
                            </a>
                        </li>
                        <li
                            class="menu-item {{ request()->routeIs('admin.kesiswaan.ppdb.syarat-ppdb.index') ? 'active' : '' }}">
                            <a href="{{ route('admin.kesiswaan.ppdb.syarat-ppdb.index') }}" class="menu-link">
                                <div data-i18n="Syarat">Syarat Pendaftaran</div>
                            </a>
                        </li>
                        <li
                            class="menu-item {{ request()->routeIs('admin.kesiswaan.ppdb.formulir-ppdb.index') ? 'active' : '' }}">
                            <a href="{{ route('admin.kesiswaan.ppdb.formulir-ppdb.index') }}" class="menu-link">
                                <div data-i18n="Formulir">Formulir Pendaftaran</div>
                            </a>
                        </li>
                        <li
                            class="menu-item {{ request()->routeIs('admin.kesiswaan.ppdb.daftar-calon-peserta-didik.index') ? 'active' : '' }}">
                            <a href="{{ route('admin.kesiswaan.ppdb.daftar-calon-peserta-didik.index') }}"
                                class="menu-link">
                                <div data-i18n="Calon Peserta Didik">Calon Peserta Didik</div>
                            </a>
                        </li>
                        <li
                            class="menu-item {{ request()->routeIs('admin.kesiswaan.ppdb.penempatan-kelas.index') ? 'active' : '' }}">
                            <a href="{{ route('admin.kesiswaan.ppdb.penempatan-kelas.index') }}" class="menu-link">
                                <div data-i18n="Penempatan Kelas">Penempatan Kelas</div>
                            </a>
                        </li>
                        <li
                            class="menu-item {{ request()->routeIs('admin.kesiswaan.ppdb.laporan-pendaftaran.index') ? 'active' : '' }}">
                            <a href="{{ route('admin.kesiswaan.ppdb.laporan-pendaftaran.index') }}"
                                class="menu-link">
                                <div data-i18n="Laporan Pendaftaran">Laporan Pendaftaran</div>
                            </a>
                        </li>
                        <li
                            class="menu-item {{ request()->routeIs('admin.kesiswaan.ppdb.laporan-quota.index') ? 'active' : '' }}">
                            <a href="{{ route('admin.kesiswaan.ppdb.laporan-quota.index') }}" class="menu-link">
                                <div data-i18n="Laporan Quota">Laporan Quota</div>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="menu-item {{ request()->is('admin/kesiswaan/siswa*') ? 'active' : '' }}">
                    <a href="{{ route('admin.kesiswaan.siswa.index') }}" class="menu-link">
                        <div data-i18n="Data Siswa">Data Siswa</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('admin.kesiswaan.siswa.cetak_massal_index') ? 'active' : '' }}">
                    <a href="{{ route('admin.kesiswaan.siswa.cetak_massal_index') }}" class="menu-link">
                        <div data-i18n="Cetak Kartu Massal">Cetak Kartu Massal</div>
                    </a>
                </li>
            </ul>
        </li>

<<<<<<< HEAD
         <li class="menu-item {{ request()->is('admin/rombel*') ? 'open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-group"></i>
                <div data-i18n="Rombel">Rombongan Belajar</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->is('admin/rombel/reguler*') ? 'active' : '' }}">
                    <a href="{{ route('admin.rombel.reguler.index') }}" class="menu-link">
                        <div data-i18n="Reguler">Reguler</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('admin/rombel/praktik*') ? 'active' : '' }}">
                    <a href="{{ route('admin.rombel.praktik.index') }}" class="menu-link">
                        <div data-i18n="Praktik">Praktik</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('admin/rombel/ekstrakurikuler*') ? 'active' : '' }}">
                    <a href="{{ route('admin.rombel.ekstrakurikuler.index') }}" class="menu-link">
                        <div data-i18n="Ekstrakurikuler">Ekstrakurikuler</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('admin/rombel/mapel-pilihan*') ? 'active' : '' }}">
                    <a href="{{ route('admin.rombel.mapel-pilihan.index') }}" class="menu-link">
                        <div data-i18n="Mapel Pilihan">Mapel Pilihan</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('admin/rombel/wali*') ? 'active' : '' }}">
                    <a href="{{ route('admin.rombel.wali.index') }}" class="menu-link">
                        <div data-i18n="Wali">Wali</div>
                    </a>
                </li>
            </ul>
        </li>

         <li class="menu-item {{ request()->routeIs('admin.keuangan.*') ? 'open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-cash"></i>
                <div data-i18n="Keuangan">Keuangan</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('admin.keuangan.penerimaan.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.keuangan.penerimaan.index') }}" class="menu-link">
                        <div data-i18n="Penerimaan">Penerimaan</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('admin.keuangan.pengeluaran.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.keuangan.pengeluaran.index') }}" class="menu-link">
                        <div data-i18n="Pengeluaran">Pengeluaran</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('admin.keuangan.kas.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.keuangan.kas.index') }}" class="menu-link">
                        <div data-i18n="Buku Kas">Buku Kas</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('admin.keuangan.iuran.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.keuangan.iuran.index') }}" class="menu-link">
                        <div data-i18n="Pengaturan Iuran">Pengaturan Iuran</div>
                    </a>
                </li>
                 <li class="menu-item {{ request()->routeIs('admin.keuangan.voucher.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.keuangan.voucher.index') }}" class="menu-link">
                        <div data-i18n="Manajemen Voucher">Manajemen Beasiswa</div>
                    </a>
                </li>
            </ul>
        </li>


=======
        <!-- Laporan -->
<li class="menu-item {{ request()->is('admin/laporan*') ? 'open' : '' }}">
    <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bxs-report"></i>
        <div data-i18n="Laporan">Laporan</div>
    </a>
    <ul class="menu-sub">
        <li class="menu-item {{ request()->is('admin/laporan/absensi') ? 'active' : '' }}">
            <a href="{{ route('admin.laporan.absensi.index') }}" class="menu-link">
                <div data-i18n="Laporan Absensi">Laporan Absensi</div>
            </a>
        </li>

        <!-- --- TAMBAHKAN ITEM MENU BARU DI SINI --- -->
        <li class="menu-item {{ request()->routeIs('admin.laporan.absensi.tanpa_pulang') ? 'active' : '' }}">
            <a href="{{ route('admin.laporan.absensi.tanpa_pulang') }}" class="menu-link">
                <div data-i18n="Tanpa Absen Pulang">Tanpa Absen Pulang</div>
            </a>
        </li>
        <!-- --- AKHIR DARI ITEM MENU BARU --- -->

    </ul>
</li>
        
>>>>>>> origin/modul/absensi
        <!-- PENGATURAN SISTEM (DI BAWAH SENDIRI) -->
        <li class="menu-header small text-uppercase"><span class="menu-header-text">Pengaturan Sistem</span></li>
        <!-- Pengaturan Absensi (Submenu Baru) -->
        <li class="menu-item {{ request()->is('admin/pengaturan/absensi*') || request()->is('admin/pengaturan/hari-libur*') ? 'open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-time"></i>
                <div data-i18n="Pengaturan Absensi">Pengaturan Absensi</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->is('admin/pengaturan/absensi*') ? 'active' : '' }}">
                    <a href="{{ route('admin.pengaturan.absensi.edit') }}" class="menu-link">
                        <div data-i18n="Jam & Aturan">Jam & Aturan</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('admin/pengaturan/hari-libur*') ? 'active' : '' }}">
                    <a href="{{ route('admin.pengaturan.hari-libur.index') }}" class="menu-link">
                        <div data-i18n="Manajemen Hari Libur">Manajemen Hari Libur</div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-item {{ request()->is('admin/pengaturan/webservice*') ? 'open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-git-branch"></i>
                <div data-i18n="Integrasi & API">Integrasi & API</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->is('admin/pengaturan/webservice*') ? 'active' : '' }}">
                    <a href="{{ route('admin.pengaturan.webservice.index') }}" class="menu-link">
                        <div data-i18n="Pengaturan WebService">Pengaturan WebService</div>
                    </a>
                </li>
            </ul>
        </li>
        {{-- END PENGATURAN SISTEM --}}

    </ul>

</aside>

