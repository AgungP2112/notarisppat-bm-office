<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="container-fluid" id="container-wrapper">
    <?= form_header('<i class="fas fa-user"></i>', 'Profil') ?>

    <div class="card mb-4">
        <div class="card-header p-0 border-bottom">
            <ul class="nav nav-tabs" id="profil-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="pengaturan-tabid" data-toggle="pill" href="#pengaturan-tab" role="tab" aria-controls="pengaturan-tab" aria-selected="true">Pengaturan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="statistik-tabid" data-toggle="pill" href="#statistik-tab" role="tab" aria-controls="statistik-tab" aria-selected="true">Statistik</a>
                </li>
            </ul>
            <div class="tab-custom-content mt-3">
                <div class="text-center">
                    <i class="fas fa-user-circle fa-4x text-primary"></i>
                </div>
                <h3 class="profile-username text-center"><?= $this->session->userdata('notarisppat__namauser') ?></h3>
                <p class="text-muted text-center"><?= $main->nama_jabatan ?></p>
            </div>
        </div>
        <div class="card-body">
            <div class="tab-content" id="profil-tabcontent">
                <div class="tab-pane fade active show" id="pengaturan-tab" role="tabpanel" aria-labelledby="pengaturan-tabid">
                    <div class="form-group">
                        <label for="nama">Nama Lengkap</label>
                        <input type="text" name="nama" id="nama" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" name="username" id="username" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="form-control">
                        <small class="text-danger">Kosongkan jika tidak ada perubahan</small>
                    </div>
                    <div class="form-group">
                        <label for="ulangiPassword">Ulangi Password</label>
                        <input type="password" name="ulangiPassword" id="ulangiPassword" class="form-control">
                    </div>
                    <button type="button" class="btn btn-primary btn-block" id="submit" onclick="processPengaturanForm()"><i class="fa fa-paper-plane"></i> &nbsp;Simpan</button>
                </div>
                <div class="tab-pane fade" id="statistik-tab" role="tabpanel" aria-labelledby="statistik-tabid">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Quaerat blanditiis quas adipisci rerum dolorem laborum, nulla maxime fuga accusamus rem at animi, facilis molestiae. Repellat vero nobis iusto saepe ea?
                </div>
            </div>
        </div>
    </div>
</div>
</div>