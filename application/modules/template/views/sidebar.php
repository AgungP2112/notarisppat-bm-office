<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<body id="page-top">
    <div id="wrapper">
        <ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url() ?>">
                <div class="sidebar-brand-icon">
                    <i class="fas fa-book-bookmark fa-2x"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Notaris/PPAT</div>
            </a>
            <?php if (
                check_root_hak_akses('master_data_penanggung_jawab') == true
            ) { ?>
                <li class="nav-item <?= $this->uri->segment(1) == 'master_data' ? 'active' : '' ?>">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMasterData" aria-expanded="true" aria-controls="collapseMasterData">
                        <i class="fas fa-desktop"></i>
                        <span>Master Data</span>
                    </a>
                    <div id="collapseMasterData" class="collapse <?= $this->uri->segment(1) == 'master_data' ? 'show' : '' ?>" aria-labelledby="headingMasterData" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">Master Data</h6>
                            <?php if (check_root_hak_akses('master_data_penanggung_jawab') == true) { ?>
                                <a class="collapse-item <?= $this->uri->segment(1) == 'master_data' && $this->uri->segment(2) == 'penanggung_jawab' ? 'active' : '' ?>" href="<?= base_url('master_data/penanggung_jawab') ?>">Penanggung Jawab</a>
                            <?php } ?>
                        </div>
                    </div>
                </li>
            <?php } ?>
            <?php if (
                check_root_hak_akses('pengaturan_user') == true ||
                check_root_hak_akses('pengaturan_jabatan') == true ||
                check_root_hak_akses('pengaturan_log_aktivitas') == true
            ) { ?>
                <li class="nav-item <?= $this->uri->segment(1) == 'pengaturan' ? 'active' : '' ?>">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePengaturan" aria-expanded="true" aria-controls="collapsePengaturan">
                        <i class="fas fa-tools"></i>
                        <span>Pengaturan</span>
                    </a>
                    <div id="collapsePengaturan" class="collapse <?= $this->uri->segment(1) == 'pengaturan' ? 'show' : '' ?>" aria-labelledby="headingPengaturan" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">Pengaturan</h6>
                            <?php if (check_root_hak_akses('pengaturan_user') == true) { ?>
                                <a class="collapse-item <?= $this->uri->segment(1) == 'pengaturan' && $this->uri->segment(2) == 'user' ? 'active' : '' ?>" href="<?= base_url('pengaturan/user') ?>">User</a>
                            <?php } ?>
                            <?php if (check_root_hak_akses('pengaturan_jabatan') == true) { ?>
                                <a class="collapse-item <?= $this->uri->segment(1) == 'pengaturan' && $this->uri->segment(2) == 'jabatan' ? 'active' : '' ?>" href="<?= base_url('pengaturan/jabatan') ?>">Jabatan</a>
                            <?php } ?>
                            <?php if (check_root_hak_akses('pengaturan_log_aktivitas') == true) { ?>
                                <a class="collapse-item <?= $this->uri->segment(1) == 'pengaturan' && $this->uri->segment(2) == 'log_aktivitas' ? 'active' : '' ?>" href="<?= base_url('pengaturan/log_aktivitas') ?>">Log Aktivitas</a>
                            <?php } ?>
                        </div>
                    </div>
                </li>
            <?php } ?>

        </ul>
        <!-- Sidebar -->



        <!-- <aside class="main-sidebar sidebar-dark-light elevation-4">
    <a href="javascript:void(0)" class="brand-link bg-dark text-white text-center">
        <img src="<?= base_url('assets') ?>/logo.jpg" alt="Notaris/PPAT Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text">Notaris/PPAT</span>
    </a>
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?= base_url('assets') ?>/user-circle-solid.svg" class="brand-image img-circle elevation-3">
            </div>
            <div class="info">
                <a href="javascript:void(0)" class="d-block">
                    <?= $this->session->userdata('notarisppat_namauser') ?>
                </a>
            </div>
        </div>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-flat nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
                <?php if (
                    check_root_hak_akses('master_data_customer') == true
                ) { ?>
                    <li class="nav-item has-treeview <?= $this->uri->segment(1) == 'master_data' ? 'menu-open' : '' ?>">
                        <a href="#" class="nav-link <?= $this->uri->segment(1) == 'master_data' ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-desktop"></i>
                            <p>
                                Master Data
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <?php if (check_root_hak_akses('master_data_customer') == true) { ?>
                                <li class="nav-item">
                                    <a href="<?= base_url('master_data/customer') ?>" class="nav-link <?= $this->uri->segment(1) == 'master_data' && $this->uri->segment(2) == 'customer' ? 'active' : '' ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Customer</p>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </li>
                <?php } ?>
                <?php if (
                    check_root_hak_akses('servis_data') == true ||
                    check_root_hak_akses('servis_nota_masuk') == true ||
                    check_root_hak_akses('servis_nota_proses') == true ||
                    check_root_hak_akses('servis_nota_keluar') == true ||
                    check_root_hak_akses('servis_nota_dibatalkan') == true ||
                    check_root_hak_akses('servis_sparepart_servis') == true ||
                    check_root_hak_akses('servis_honor') == true ||
                    check_root_hak_akses('servis_master_mode') == true
                ) { ?>
                    <li class="nav-item has-treeview <?= $this->uri->segment(1) == 'servis' ? 'menu-open' : '' ?>">
                        <a href="#" class="nav-link <?= $this->uri->segment(1) == 'servis' ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-tools"></i>
                            <p>
                                Servis
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <?php if (check_root_hak_akses('servis_data') == true) { ?>
                                <li class="nav-item">
                                    <a href="<?= base_url('servis/data') ?>" class="nav-link <?= $this->uri->segment(1) == 'servis' && $this->uri->segment(2) == 'data' ? 'active' : '' ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Data</p>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if (check_root_hak_akses('servis_nota_masuk') == true) { ?>
                                <li class="nav-item">
                                    <a href="<?= base_url('servis/nota_masuk') ?>" class="nav-link <?= $this->uri->segment(1) == 'servis' && $this->uri->segment(2) == 'nota_masuk' ? 'active' : '' ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Nota Masuk</p>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if (check_root_hak_akses('servis_nota_proses') == true) { ?>
                                <li class="nav-item">
                                    <a href="<?= base_url('servis/nota_proses') ?>" class="nav-link <?= $this->uri->segment(1) == 'servis' && $this->uri->segment(2) == 'nota_proses' ? 'active' : '' ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Nota Proses</p>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if (check_root_hak_akses('servis_nota_keluar') == true) { ?>
                                <li class="nav-item">
                                    <a href="<?= base_url('servis/nota_keluar') ?>" class="nav-link <?= $this->uri->segment(1) == 'servis' && $this->uri->segment(2) == 'nota_keluar' ? 'active' : '' ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Nota Keluar</p>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if (check_root_hak_akses('servis_nota_dibatalkan') == true) { ?>
                                <li class="nav-item">
                                    <a href="<?= base_url('servis/nota_dibatalkan') ?>" class="nav-link <?= $this->uri->segment(1) == 'servis' && $this->uri->segment(2) == 'nota_dibatalkan' ? 'active' : '' ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Nota Dibatalkan</p>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if (check_root_hak_akses('servis_sparepart_servis') == true) { ?>
                                <li class="nav-item">
                                    <a href="<?= base_url('servis/sparepart_servis') ?>" class="nav-link <?= $this->uri->segment(1) == 'servis' && $this->uri->segment(2) == 'sparepart_servis' ? 'active' : '' ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Sparepart Servis</p>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if (check_root_hak_akses('servis_honor') == true) { ?>
                                <li class="nav-item">
                                    <a href="<?= base_url('servis/honor') ?>" class="nav-link <?= $this->uri->segment(1) == 'servis' && $this->uri->segment(2) == 'honor' ? 'active' : '' ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Honor</p>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if (check_root_hak_akses('servis_master_mode') == true) { ?>
                                <li class="nav-item">
                                    <a href="<?= base_url('servis/master_mode') ?>" class="nav-link <?= $this->uri->segment(1) == 'servis' && $this->uri->segment(2) == 'master_mode' ? 'active' : '' ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Master Mode</p>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </li>
                <?php } ?>
                <?php if (
                    check_root_hak_akses('garansi_data') == true ||
                    check_root_hak_akses('garansi_nota_masuk') == true ||
                    check_root_hak_akses('garansi_nota_proses') == true ||
                    check_root_hak_akses('garansi_nota_keluar') == true ||
                    check_root_hak_akses('garansi_sparepart_garansi') == true ||
                    check_root_hak_akses('garansi_honor') == true
                ) { ?>
                    <li class="nav-item has-treeview <?= $this->uri->segment(1) == 'garansi' ? 'menu-open' : '' ?>">
                        <a href="#" class="nav-link <?= $this->uri->segment(1) == 'garansi' ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-arrows-turn-to-dots"></i>
                            <p>
                                Garansi
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <?php if (check_root_hak_akses('garansi_data') == true) { ?>
                                <li class="nav-item">
                                    <a href="<?= base_url('garansi/data') ?>" class="nav-link <?= $this->uri->segment(1) == 'garansi' && $this->uri->segment(2) == 'data' ? 'active' : '' ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Data</p>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if (check_root_hak_akses('garansi_nota_masuk') == true) { ?>
                                <li class="nav-item">
                                    <a href="<?= base_url('garansi/nota_masuk') ?>" class="nav-link <?= $this->uri->segment(1) == 'garansi' && $this->uri->segment(2) == 'nota_masuk' ? 'active' : '' ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Nota Masuk</p>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if (check_root_hak_akses('garansi_nota_proses') == true) { ?>
                                <li class="nav-item">
                                    <a href="<?= base_url('garansi/nota_proses') ?>" class="nav-link <?= $this->uri->segment(1) == 'garansi' && $this->uri->segment(2) == 'nota_proses' ? 'active' : '' ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Nota Proses</p>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if (check_root_hak_akses('garansi_nota_keluar') == true) { ?>
                                <li class="nav-item">
                                    <a href="<?= base_url('garansi/nota_keluar') ?>" class="nav-link <?= $this->uri->segment(1) == 'garansi' && $this->uri->segment(2) == 'nota_keluar' ? 'active' : '' ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Nota Keluar</p>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if (check_root_hak_akses('garansi_sparepart_garansi') == true) { ?>
                                <li class="nav-item">
                                    <a href="<?= base_url('garansi/sparepart_garansi') ?>" class="nav-link <?= $this->uri->segment(1) == 'garansi' && $this->uri->segment(2) == 'sparepart_garansi' ? 'active' : '' ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Sparepart Garansi</p>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if (check_root_hak_akses('garansi_honor') == true) { ?>
                                <li class="nav-item">
                                    <a href="<?= base_url('garansi/honor') ?>" class="nav-link <?= $this->uri->segment(1) == 'garansi' && $this->uri->segment(2) == 'honor' ? 'active' : '' ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Honor</p>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </li>
                <?php } ?>
                <?php if (
                    check_root_hak_akses('teknisi_pengambilan_sparepart') == true ||
                    check_root_hak_akses('teknisi_pengambilan_uang') == true ||
                    check_root_hak_akses('teknisi_dana_deposit') == true
                ) { ?>
                    <li class="nav-item has-treeview <?= $this->uri->segment(1) == 'teknisi' ? 'menu-open' : '' ?>">
                        <a href="#" class="nav-link <?= $this->uri->segment(1) == 'teknisi' ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-user-gear"></i>
                            <p>
                                Teknisi
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <?php if (check_root_hak_akses('teknisi_pengambilan_sparepart') == true) { ?>
                                <li class="nav-item">
                                    <a href="<?= base_url('teknisi/pengambilan_sparepart') ?>" class="nav-link <?= $this->uri->segment(1) == 'teknisi' && $this->uri->segment(2) == 'pengambilan_sparepart' ? 'active' : '' ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Pengambilan Sparepart</p>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if (check_root_hak_akses('teknisi_pengambilan_uang') == true) { ?>
                                <li class="nav-item">
                                    <a href="<?= base_url('teknisi/pengambilan_uang') ?>" class="nav-link <?= $this->uri->segment(1) == 'teknisi' && $this->uri->segment(2) == 'pengambilan_uang' ? 'active' : '' ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Pengambilan Uang</p>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if (check_root_hak_akses('teknisi_dana_deposit') == true) { ?>
                                <li class="nav-item">
                                    <a href="<?= base_url('teknisi/dana_deposit') ?>" class="nav-link <?= $this->uri->segment(1) == 'teknisi' && $this->uri->segment(2) == 'dana_deposit' ? 'active' : '' ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Dana Deposit</p>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </li>
                <?php } ?>
                <?php if (
                    check_root_hak_akses('laporan_servis') == true &&
                    check_root_hak_akses('laporan_teknisi') == true
                ) { ?>
                    <li class="nav-item has-treeview <?= $this->uri->segment(1) == 'laporan' ? 'menu-open' : '' ?>">
                        <a href="#" class="nav-link <?= $this->uri->segment(1) == 'laporan' ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-file"></i>
                            <p>
                                Laporan
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <!-- <?php if (check_root_hak_akses('laporan_servis') == true) { ?>
                                <li class="nav-item">
                                    <a href="<?= base_url('laporan/servis') ?>" class="nav-link <?= $this->uri->segment(1) == 'laporan' && $this->uri->segment(2) == 'servis' ? 'active' : '' ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Servis</p>
                                    </a>
                                </li>
                            <?php } ?> -->
        <?php if (check_root_hak_akses('laporan_teknisi') == true) { ?>
            <li class="nav-item">
                <a href="<?= base_url('laporan/teknisi') ?>" class="nav-link <?= $this->uri->segment(1) == 'laporan' && $this->uri->segment(2) == 'teknisi' ? 'active' : '' ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Teknisi</p>
                </a>
            </li>
        <?php } ?>
        </ul>
        </li>
    <?php } ?>
    <?php if (
        check_root_hak_akses('pengaturan_user') == true ||
        check_root_hak_akses('pengaturan_jabatan') == true ||
        check_root_hak_akses('pengaturan_log_aktivitas') == true
    ) { ?>
        <li class="nav-item has-treeview <?= $this->uri->segment(1) == 'pengaturan' ? 'menu-open' : '' ?>">
            <a href="#" class="nav-link <?= $this->uri->segment(1) == 'pengaturan' ? 'active' : '' ?>">
                <i class="nav-icon fas fa-cogs"></i>
                <p>
                    Pengaturan
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <?php if (check_root_hak_akses('pengaturan_user') == true) { ?>
                    <li class="nav-item">
                        <a href="<?= base_url('pengaturan/user') ?>" class="nav-link <?= $this->uri->segment(1) == 'pengaturan' && $this->uri->segment(2) == 'user' ? 'active' : '' ?>">
                            <i class="far fa-circle nav-icon"></i>
                            <p>User</p>
                        </a>
                    </li>
                <?php } ?>
                <?php if (check_root_hak_akses('pengaturan_jabatan') == true) { ?>
                    <li class="nav-item">
                        <a href="<?= base_url('pengaturan/jabatan') ?>" class="nav-link <?= $this->uri->segment(1) == 'pengaturan' && $this->uri->segment(2) == 'jabatan' ? 'active' : '' ?>">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Jabatan</p>
                        </a>
                    </li>
                <?php } ?>
                <?php if (check_root_hak_akses('pengaturan_log_aktivitas') == true) { ?>
                    <li class="nav-item">
                        <a href="<?= base_url('pengaturan/log_aktivitas') ?>" class="nav-link <?= $this->uri->segment(1) == 'pengaturan' && $this->uri->segment(2) == 'log_aktivitas' ? 'active' : '' ?>">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Log Aktivitas</p>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </li>
    <?php } ?>
    </ul>
    </nav>
    </div>
    </aside> -->