<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<body class="bg-gradient-login" style="background-image: linear-gradient(to left top, #007bff, #5399ff, #84b7fe, #b4d3fa, #e6edf5);">
    <div class="container-login">
        <div class="row justify-content-center">
            <div class="col-xl-4 col-lg-5 col-md-6 col-sm-8">
                <div class="card shadow-sm my-5">
                    <div class="card-header bg-primary text-white text-center">
                        <h2 class="m-0 font-weight-bold "> <i class="fas fa-book-bookmark"></i> Notaris/PPAT</h2>
                    </div>
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="login-form">
                                    <h3 class="text-center">Login</h3>
                                    <div class="input-group mb-3">
                                        <input type="text" id="username" class="form-control" placeholder="Username ..." autofocus>
                                        <div class="input-group-append"><span class="input-group-text"><i class="fas fa-user"></i></span></div>
                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="password" id="password" class="form-control" placeholder="Password ...">
                                        <div class="input-group-append"><span class="input-group-text"><i class="fas fa-lock"></i></span></div>
                                    </div>
                                    <button type="button" id="submit" class="btn btn-primary btn-block" onclick="processForm()"><i class="fa fa-sign-in-alt"></i> LOGIN
                                    </button>


                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <strong>Notaris/PPAT 1.0.0</strong> <br>
                        Copyright 2022 - <?= date('Y') ?> | Notaris/PPAT | Developed by Agung Prasetyo
                    </div>
                </div>
            </div>
        </div>
    </div>




    <!-- <body class="hold-transition login-page" style="background: #0f2027;background: -webkit-linear-gradient(to right, #0f2027, #203a43, #2c5364);background: linear-gradient(#16222a, #3a6073);">
        <div class="login-box" style="width:500px">
            <div class="card shadow-lg">
                <div class="card-header text-center bg-gradient-dark d-flex">
                    <img src="<?= base_url('assets') ?>/logo.jpg" alt="Notaris/PPAT Logo" class="brand-image img-circle elevation-3" style="opacity: .8" width="20%">
                    <h2 style="margin-top:30px;margin-left:80px">Notaris/PPAT</h2>
                </div>
                <div class="card-body">
                    <p class="login-box-msg"><strong>LOGIN</strong></p>
                    <div class="input-group mb-3">
                        <input type="text" id="username" class="form-control" placeholder="Username ..." autofocus>
                        <div class="input-group-append">
                            <div class="input-group-text bg-gradient-dark text-white">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" id="password" class="form-control" placeholder="Password ...">
                        <div class="input-group-append">
                            <div class="input-group-text bg-gradient-dark text-white">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <button type="button" id="submit" class="btn bg-gradient-primary btn-block">
                        <i class="fa fa-sign-in-alt"></i> LOGIN
                    </button>
                </div>
                <div class="card-footer text-center">
                    <strong>Notaris/PPAT 1.0.0</strong> <br>
                    Copyright 2022 - <?= date('Y') ?> | Notaris/PPAT | Developed by Agung Prasetyo
                </div>
            </div>
        </div> -->