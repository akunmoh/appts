<aside id="sidebar-left" class="sidebar-left">
    <div class="sidebar-header">
        <div class="sidebar-title">
            MENU
        </div>
    </div>

    <div class="nano">
        <div class="nano-content">
            <nav id="menu" class="nav-main" role="navigation">
                <ul class="nav nav-main">
                    <li class="<?php if ($main_menu == 'beranda') echo 'nav-active'; ?>">
                        <a href="<?=base_url('beranda'); ?>"><i class="fas fa-home"></i><span>Beranda</span></a>
                    </li>

                    <?php
                    if (get_permission('data_barang', 'is_view') || 
                        get_permission('barang_masuk', 'is_view') ||
                        get_permission('barang_keluar', 'is_view')) {
                    ?>
                    <li class="nav-parent <?php if ($main_menu == 'gudang') echo 'nav-expanded nav-active'; ?>">
                        <a><i class="fas fa-dolly"></i><span>Manage Gudang</span></a>
                        <ul class="nav nav-children">
                            <?php if(get_permission('data_barang', 'is_view')){ ?>
                            <li
                                class="<?php if ($sub_page == 'gudang/barang' || $sub_page == 'gudang/barang_edit') echo 'nav-active'; ?>">
                                <a href="<?=base_url('gudang/barang'); ?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i>Data Barang</span>
                                </a>
                            </li>
                            <?php } ?>
                            <?php if(get_permission('barang_masuk', 'is_view')){ ?>
                            <li
                                class="<?php if ($sub_page == 'gudang/barangmasuk' || $sub_page =='gudang/barangmasuk_edit') echo 'nav-active'; ?>">
                                <a href="<?=base_url('gudang/barangmasuk'); ?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i>Barang Masuk</span>
                                </a>
                            </li>
                            <?php } ?>
                            <?php if(get_permission('barang_keluar', 'is_view')){ ?>
                            <li
                                class="<?php if ($sub_page == 'gudang/keluar' || $sub_page =='gudang/keluar_detail') echo 'nav-active'; ?>">
                                <a href="<?=base_url('gudang/keluar'); ?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i>Barang Keluar</span>
                                </a>
                            </li>
                            <?php } ?>
                        </ul>
                    </li>
                    <?php } ?>

                    <?php
                    if (get_permission('sinar_jaya', 'is_view') ||
                        get_permission('non_sinar_jaya', 'is_view')) {
                    ?>
                    <li class="nav-parent <?php if ($main_menu == 'po') echo 'nav-expanded nav-active'; ?>">
                        <a><i class="fas fa-bus"></i><span>Manage P.O Bus</span></a>
                        <ul class="nav nav-children">
                            <?php if(get_permission('sinar_jaya', 'is_view')){ ?>
                            <li
                                class="<?php if ($sub_page == 'po/sinarjaya' || $sub_page == 'po/sinarjaya_edit') echo 'nav-active'; ?>">
                                <a href="<?=base_url('po'); ?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i>P.O Sinar Jaya</span>
                                </a>
                            </li>
                            <?php } ?>

                            <?php if(get_permission('non_sinar_jaya', 'is_view')){ ?>
                            <li
                                class="<?php if ($sub_page == 'po/view') echo 'nav-active'; ?>">
                                <a href="<?=base_url('poc/view/2'); ?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i>P.O Stand C</span>
                                </a>
                            </li>
                            <?php } ?>
                            
                        </ul>
                    </li>
                    <?php } ?>

                    <?php
                    if (get_permission('kas_masuk', 'is_view') || 
                        get_permission('kas_keluar', 'is_view')) {
                    ?>
                    <li class="nav-parent <?php if ($main_menu == 'keuangan') echo 'nav-expanded nav-active'; ?>">
                        <a><i class="fas fa-money-bill-wave"></i><span>Manage Keuangan</span></a>
                        <ul class="nav nav-children">
                            <?php if(get_permission('kas_masuk', 'is_view')){ ?>
                            <li class="<?php if ($sub_page == 'kas/pemasukkan') echo 'nav-active'; ?>">
                                <a href="<?=base_url('kas/pemasukkan'); ?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i>Kas Masuk</span>
                                </a>
                            </li>
                            <?php } ?>
                            <?php if(get_permission('kas_keluar', 'is_view')){ ?>
                            <li class="<?php if ($sub_page == 'kas/pengeluaran') echo 'nav-active'; ?>">
                                <a href="<?=base_url('kas/pengeluaran'); ?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i>Kas Keluar</span>
                                </a>
                            </li>
                            <?php } ?>
                        </ul>
                    </li>
                    <?php } ?>

                    <?php
                    if (get_permission('pegawai', 'is_view') || 
                        get_permission('penggajian', 'is_view') ||
                        get_permission('kasbon', 'is_view') ||
                        get_permission('absensi', 'is_view')) {
                    ?>
                    <li class="nav-parent <?php if ($main_menu == 'pegawai') echo 'nav-expanded nav-active'; ?>">
                        <a><i class="fas fa-users"></i><span>Manage Pegawai</span></a>
                        <ul class="nav nav-children">
                            <?php if(get_permission('pegawai', 'is_view')){ ?>
                            <li
                                class="<?php if ($sub_page == 'pegawai/index' || $sub_page == 'pegawai/detail') echo 'nav-active'; ?>">
                                <a href="<?=base_url('pegawai'); ?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i>Data Pegawai</span>
                                </a>
                            </li>
                            <?php } ?>
                            <?php if(get_permission('penggajian', 'is_view')){ ?>
                            <li class="<?php if ($sub_page == 'penggajian/index' || $sub_page == 'penggajian/hitung') echo 'nav-active'; ?>">
                                <a href="<?=base_url('penggajian'); ?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i>Penggajian</span>
                                </a>
                            </li>
                            <?php } ?>
                            <?php if(get_permission('kasbon', 'is_view')){ ?>
                            <li class="<?php if ($sub_page == 'pegawai/kasbon') echo 'nav-active'; ?>">
                                <a href="<?=base_url('pegawai/kasbon'); ?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i>Kasbon</span>
                                </a>
                            </li>
                            <?php } ?>
                            <?php if(get_permission('absensi', 'is_view')){ ?>
                            <li class="<?php if ($sub_page == 'absensi/index') echo 'nav-active'; ?>">
                                <a href="<?=base_url('absensi'); ?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i>Absensi</span>
                                </a>
                            </li>
                            <?php } ?>
                        </ul>
                    </li>
                    <?php } ?>

                    <?php
                    if (get_permission('laporan_kas_masuk', 'is_view') || 
                        get_permission('laporan_kas_keluar', 'is_view') ||
                        get_permission('laporan_kas', 'is_view') ||
                        get_permission('laporan_stock', 'is_view') ||
                        get_permission('laporan_barang_masuk', 'is_view') ||
                        get_permission('laporan_barang_keluar', 'is_view') ||
                        get_permission('laporan_po', 'is_view') ||
                        get_permission('laporan_absensi', 'is_view')) {
                    ?>
                    <li class="nav-parent <?php if ($main_menu == 'laporan_keuangan' || $main_menu == 'laporan_gudang' || $main_menu == 'laporan_absensi' || $main_menu == 'laporan_po') echo 'nav-expanded nav-active';?>">
                        <a><i class="fas fa-chart-pie"></i><span>Laporan</span></a>
                        <ul class="nav nav-children">
                            <?php if(get_permission('laporan_kas_masuk', 'is_view') || get_permission('laporan_kas_keluar', 'is_view') || get_permission('laporan_kas', 'is_view')){ ?>
                            <li
                                class="nav-parent <?php if ($main_menu == 'laporan_keuangan') echo 'nav-expanded nav-active'; ?>">
                                <a><i class="fas fa-chart-bar"></i><span>Laporan Keuangan</span></a>
                                <ul class="nav nav-children">
                                    <?php if(get_permission('laporan_kas_masuk', 'is_view')){ ?>
                                    <li class="<?php if ($sub_page == 'laporan/pemasukkan') echo 'nav-active';?>">
                                        <a href="<?=base_url('laporan/pemasukkan')?>">
                                            <span><i class="fas fa-caret-right" aria-hidden="true"></i>Laporan Kas Masuk</span>
                                        </a>
                                    </li>
                                    <?php } ?>
                                    <?php if(get_permission('laporan_kas_keluar', 'is_view')){ ?>
                                    <li class="<?php if ($sub_page == 'laporan/pengeluaran') echo 'nav-active';?>">
                                        <a href="<?=base_url('laporan/pengeluaran')?>">
                                            <span><i class="fas fa-caret-right" aria-hidden="true"></i>Laporan Kas Keluar</span>
                                        </a>
                                    </li>
                                    <?php } ?>
                                    <?php if(get_permission('laporan_kas', 'is_view')){ ?>
                                    <li class="<?php if ($sub_page == 'laporan/kas') echo 'nav-active';?>">
                                        <a href="<?=base_url('laporan/kas')?>">
                                            <span><i class="fas fa-caret-right" aria-hidden="true"></i>Laporan Kas</span>
                                        </a>
                                    </li>
                                    <?php } ?>
                                </ul>
                            </li>
                            <?php } ?>
                            
                            <?php if(get_permission('laporan_stock', 'is_view') || get_permission('laporan_barang_masuk', 'is_view') || get_permission('laporan_barang_keluar', 'is_view')){ ?>
                            <li
                                class="nav-parent <?php if ($main_menu == 'laporan_gudang') echo 'nav-expanded nav-active'; ?>">
                                <a><i class="fas fa-tasks"></i><span>Laporan Gudang</span></a>
                                <ul class="nav nav-children">
                                    <?php if(get_permission('laporan_stock', 'is_view')){ ?>
                                    <li class="<?php if ($sub_page == 'laporan/laporan_stock') echo 'nav-active';?>">
                                        <a href="<?=base_url('laporan/laporan_stock')?>">
                                            <span><i class="fas fa-caret-right" aria-hidden="true"></i>Laporan Stock</span>
                                        </a>
                                    </li>
                                    <?php } ?>
                                    <?php if(get_permission('laporan_barang_masuk', 'is_view')){ ?>
                                    <li class="<?php if ($sub_page == 'laporan/barang_masuk') echo 'nav-active';?>">
                                        <a href="<?=base_url('laporan/barang_masuk')?>">
                                            <span><i class="fas fa-caret-right" aria-hidden="true"></i>Laporan Barang Masuk</span>
                                        </a>
                                    </li>
                                    <?php } ?>
                                    <?php if(get_permission('laporan_barang_keluar', 'is_view')){ ?>
                                    <li class="<?php if ($sub_page == 'laporan/barang_keluar') echo 'nav-active';?>">
                                        <a href="<?=base_url('laporan/barang_keluar')?>">
                                            <span><i class="fas fa-caret-right" aria-hidden="true"></i>Laporan Barang Keluar</span>
                                        </a>
                                    </li>
                                    <?php } ?>
                                </ul>
                            </li>
                            <?php } ?>
                            
                            <?php if(get_permission('laporan_absensi', 'is_view')){ ?>
                            <li class="<?php if($sub_page == 'absensi/laporan') echo 'nav-active';?>">
                                <a href="<?=base_url('absensi/laporan')?>">
                                    <span><i class="fas fa-calendar-check" aria-hidden="true"></i> Laporan Absensi</span>
                                </a>
                            </li>
                            <?php } ?>

                            <?php if(get_permission('laporan_po', 'is_view')){ ?>
                            <li class="<?php if($sub_page == 'laporan/po') echo 'nav-active';?>">
                                <a href="<?=base_url('po/laporan')?>">
                                    <span><i class="fas fa-bus-alt" aria-hidden="true"></i> Laporan P.O Bus</span>
                                </a>
                            </li>
                            <?php } ?>

                        </ul>
                    </li>
                    <?php } ?>

                    <?php
                    if (get_permission('pengaturan', 'is_view') || 
                        get_permission('pengaturan_gudang', 'is_view') ||
                        get_permission('pengaturan_pegawai', 'is_view') ||
                        get_permission('pengaturan_keuangan', 'is_view') ||
                        get_permission('pengaturan_staff', 'is_view') ||
                        get_permission('database_backup', 'is_view')) {
                    ?>
                    <li class="nav-parent <?php if ($main_menu == 'pengaturan') echo 'nav-expanded nav-active';?>">
                        <a><i class="fa fa-cogs"></i><span>Pengaturan</span></a>
                        <ul class="nav nav-children">
                            <?php if(get_permission('pengaturan', 'is_view')){ ?>
                            <li class="<?php if($sub_page == 'pengaturan/index') echo 'nav-active';?>">
                                <a href="<?=base_url('pengaturan')?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i>Pengaturan Umum</span>
                                </a>
                            </li>
                            <?php } if(get_permission('pengaturan_gudang', 'is_view')){ ?>
                            <li class="<?php if ($sub_page == 'gudang/pengaturan') echo 'nav-active';?>">
                                <a href="<?=base_url('gudang/pengaturan')?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i>Pengaturan Gudang</span>
                                </a>
                            </li>
                            
                            <?php } if(get_permission('pengaturan_po', 'is_view')){ ?>
                            <li class="<?php if ($sub_page == 'po/pengaturan') echo 'nav-active';?>">
                                <a href="<?=base_url('po/pengaturan')?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i>Pengaturan P.O Bus</span>
                                </a>
                            </li>
                            <?php } if(get_permission('pengaturan_pegawai', 'is_view')){ ?>
                            <li class="<?php if ($sub_page == 'pegawai/pengaturan') echo 'nav-active';?>">
                                <a href="<?=base_url('pegawai/pengaturan')?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i>Pengaturan Pegawai</span>
                                </a>
                            </li>
                            <?php } if(get_permission('pengaturan_keuangan', 'is_view')){ ?>
                            <li class="<?php if ($sub_page == 'kas/pengaturan') echo 'nav-active';?>">
                                <a href="<?=base_url('kas/pengaturan')?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i>Pengaturan
                                        Keuangan</span>
                                </a>
                            </li>
                            <?php } if(get_permission('pengaturan_staff', 'is_view')){ ?>
                            <li
                                class="<?php if ($sub_page == 'user/index' || $sub_page == 'user/profile') echo 'nav-active';?>">
                                <a href="<?=base_url('user')?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i>Kelola Pengguna</span>
                                </a>
                            </li>
                            <?php } if (is_superadmin_loggedin()) { ?>
                            <li
                                class="<?php if ($sub_page == 'role/index' || $sub_page == 'role/permission') echo 'nav-active';?>">
                                <a href="<?=base_url('role')?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i>Hak Akses</span>
                                </a>
                            </li>
                            <?php } if(get_permission('database_backup', 'is_view')){ ?>
                            <li class="<?php if ($sub_page == 'database_backup/index') echo 'nav-active';?>">
                                <a href="<?=base_url('backup')?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i>Backup Database</span>
                                </a>
                            </li>
                            <?php } ?>
                        </ul>
                    </li>
                    <?php } ?>
                </ul>
            </nav>
        </div>

		<script>
			if (typeof localStorage !== 'undefined') {
				if (localStorage.getItem('sidebar-left-position') !== null) {
					var initialPosition = localStorage.getItem('sidebar-left-position');
					sidebarLeft = document.querySelector('#sidebar-left .nano-content');
					sidebarLeft.scrollTop = initialPosition;
				}
			}
		</script>
    </div>
</aside>
<!-- end sidebar -->