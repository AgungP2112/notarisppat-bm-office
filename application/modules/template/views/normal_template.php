<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('template/header');
$this->load->view('template/sidebar');
$this->load->view('template/topbar');
$this->load->view($content);
$this->load->view('template/footer');
$this->load->view('template/js');
