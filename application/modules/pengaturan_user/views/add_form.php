<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="container-fluid" id="container-wrapper">
    <?= form_header('<i class="fas fa-tools"></i>', 'Pengaturan - User - Tambah', true) ?>

    <div class="card mb-4">
        <div class="card-header py-3 d-flex align-items-center justify-content-between bg-primary text-white">
            <h5 class="m-0 font-weight-bold">Master Form</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="form-group">
                        <label for="jabatan">Jabatan</label>
                        <select id="jabatan" class="form-control form-control-sm"></select>
                    </div>
                    <div class="form-group">
                        <label for="nama">Nama Lengkap</label>
                        <input type="text" id="nama" class="form-control form-control-sm">
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" class="form-control form-control-sm">
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" class="form-control form-control-sm">
                    </div>
                    <div class="form-group">
                        <label for="ulangiPassword">Ulangi Password</label>
                        <input type="password" id="ulangiPassword" class="form-control form-control-sm">
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="button" class="btn btn-primary btn-block" id="submit" onclick="processForm()"><i class="fa fa-paper-plane"></i> &nbsp;Simpan</button>
        </div>
    </div>
</div>
</div>