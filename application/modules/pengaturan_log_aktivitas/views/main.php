<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="container-fluid" id="container-wrapper">
    <?= form_header('<i class="fas fa-tools"></i>', 'Pengaturan - Log Aktivitas') ?>

    <div class="card mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-primary text-white">
            <h5 class="m-0 font-weight-bold">Master Data</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="tableMaster" class="table table-bordered table-striped table-hover table-sm mx-auto" style="width:1000px">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th style="text-align:center;vertical-align:middle;width:50px">No.</th>
                            <th style="text-align:center;vertical-align:middle;width:150px">Nama User</th>
                            <th style="text-align:center;vertical-align:middle;width:180px">Waktu</th>
                            <th style="text-align:center;vertical-align:middle;width:150px">Browser</th>
                            <th style="text-align:center;vertical-align:middle;width:120px">IP</th>
                            <th style="text-align:center;vertical-align:middle;width:350px">Log</th>
                        </tr>
                    </thead>
                    <tfoot class="table-search-bar">
                        <tr>
                            <th style="text-align:center;vertical-align:middle"></th>
                            <th style="text-align:center;vertical-align:middle"><?= select_search_bar('tableMasterNamaUser') ?></th>
                            <th style="text-align:center;vertical-align:middle"><?= text_search_bar('Waktu') ?></th>
                            <th style="text-align:center;vertical-align:middle"><?= text_search_bar('Browser') ?></th>
                            <th style="text-align:center;vertical-align:middle"><?= text_search_bar('IP') ?></th>
                            <th style="text-align:center;vertical-align:middle"><?= text_search_bar('Log') ?></th>
                        </tr>
                    </tfoot>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>