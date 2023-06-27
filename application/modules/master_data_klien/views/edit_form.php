<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="container-fluid" id="container-wrapper">
    <?= form_header('<i class="fas fa-desktop"></i>', 'Master Data - Klien - Edit', true) ?>

    <div class="card mb-4">
        <div class="card-header py-3 d-flex align-items-center justify-content-between bg-primary text-white">
            <h5 class="m-0 font-weight-bold">Master Form</h5>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" id="nama" class="form-control form-control-sm" autofocus>
            </div>
        </div>
        <div class="card-footer">
            <button type="button" class="btn btn-primary btn-block" id="submit" onclick="processForm()"><i class="fa fa-paper-plane"></i> &nbsp;Simpan</button>
        </div>
    </div>
</div>
</div>