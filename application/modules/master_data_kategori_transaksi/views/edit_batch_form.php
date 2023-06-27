<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="container-fluid" id="container-wrapper">
    <?= form_header('<i class="fas fa-desktop"></i>', 'Master Data - Rekening - Edit Batch', true) ?>

    <div class="card mb-4">
        <div class="card-header py-3 d-flex align-items-center justify-content-between bg-primary text-white">
            <h5 class="m-0 font-weight-bold">Master Data</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="tableBatchEdit" class="table table-bordered table-hover table-sm mx-auto" style="width:500px">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th style="text-align:center;vertical-align:middle;width:200px">Nama</th>
                            <th style="text-align:center;vertical-align:middle;width:300px">Nomor Rekening</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header py-3 d-flex align-items-center justify-content-between bg-primary text-white">
            <h5 class="m-0 font-weight-bold">Master Form</h5>
        </div>
        <div class="card-body">
            <div class="alert alert-danger">
                <h5><i class="icon fas fa-exclamation-triangle"></i> Peringatan!</h5>
                Centang bagian yang ingin dirubah, lalu isi perubahannya. Hanya bagian yang tercentang yang akan dilakukan perubahan.
            </div>

            <div class="form-group">
                <label for="nama">Nama</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><input type="checkbox" name="checkboxform" id="checkboxnama"></span>
                    </div>
                    <input type="text" id="nama" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label for="nomorrekening">Nomor Rekening</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><input type="checkbox" name="checkboxform" id="checkboxnomorrekening"></span>
                    </div>
                    <input type="text" id="nomorrekening" class="form-control">
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="button" class="btn btn-primary btn-block" id="submit" onclick="processForm()"><i class="fa fa-paper-plane"></i> &nbsp;Simpan</button>
        </div>
    </div>
</div>
</div>