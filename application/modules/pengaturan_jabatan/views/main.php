<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="container-fluid" id="container-wrapper">
    <?= form_header('<i class="fas fa-tools"></i>', 'Pengaturan - Jabatan') ?>

    <div class="card mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-primary text-white">
            <h5 class="m-0 font-weight-bold">Master Data</h5>
            <?php if (
                check_hak_akses('pengaturan_jabatan__add') == 'true' ||
                check_hak_akses('pengaturan_jabatan__delete_batch') == 'true' ||
                check_hak_akses('pengaturan_jabatan__recycle_bin') == 'true'
            ) { ?>
                <div class="dropdown no-arrow">
                    <a class="dropdown-toggle btn btn-info btn-sm" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-bars"></i> Menu <i class="fas fa-caret-down"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(17px, 19px, 0px);">
                        <div class="dropdown-header">MENU</div>
                        <?php if (check_hak_akses('pengaturan_jabatan__add') == 'true') { ?>
                            <?= form_menu_item('addForm()', '<i class="fas fa-circle-plus"></i>', 'Tambah'); ?>
                        <?php } ?>
                        <?php if (check_hak_akses('pengaturan_jabatan__delete_batch') == 'true') { ?>
                            <?= form_menu_item('processDeleteBatch()', '<i class="fas fa-trash-can"></i>', 'Hapus Batch'); ?>
                        <?php } ?>
                        <?php if (check_hak_akses('pengaturan_jabatan__recycle_bin') == 'true') { ?>
                            <div class="dropdown-divider"></div>
                            <?= form_menu_item('binForm()', '<i class="fas fa-dumpster"></i>', 'Lihat Tong Sampah'); ?>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="tableMaster" class="table table-bordered table-striped table-hover table-sm mx-auto" style="width:550px">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th style="text-align:center;vertical-align:middle;width:50px"></th>
                            <th style="text-align:center;vertical-align:middle;width:50px"><?= checkbox_all_search_bar() ?></th>
                            <th style="text-align:center;vertical-align:middle;width:50px">No.</th>
                            <th style="text-align:center;vertical-align:middle;width:400px">Nama</th>
                        </tr>
                    </thead>
                    <tfoot class="table-search-bar">
                        <tr>
                            <th style="text-align:center;vertical-align:middle"></th>
                            <th style="text-align:center;vertical-align:middle"></th>
                            <th style="text-align:center;vertical-align:middle"></th>
                            <th style="text-align:center;vertical-align:middle"><?= text_search_bar('Nama') ?></th>
                        </tr>
                    </tfoot>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>