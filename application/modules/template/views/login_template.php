<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('template/header');
$this->load->view($content);
$this->load->view('template/js');
