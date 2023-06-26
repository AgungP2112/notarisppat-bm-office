<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Template extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    function normal_template($data = null)
    {
        $this->load->view('template/normal_template', $data);
    }

    function login_template($data = null)
    {
        $this->load->view('template/login_template', $data);
    }

    function report_template($data = null)
    {
        $this->load->view('template/report_template', $data);
    }

    function error_403()
    {
        $data["title"] = "Error 403 Forbidden";
        $this->load->view('template/error_403_no_access', $data);
    }

    function check_hak_akses()
    {
        $this->load->model('ext_model');
        $result = $this->ext_model->check_hak_akses($this->input->post('hak_akses'));
        echo json_encode($result);
    }

    function forbidden()
    {
        $this->load->model('ext_model');
        $data = $this->ext_model->hakAkses($this->input->post('hak_akses'))->row();
        add_log('<div>Gagal membuka menu <b>' . $data->nama_menu . '</b> karena terhalang hak akses</div>');
        $result = 'Anda tidak mempunyai hak akses ke menu <b>' . $data->nama_menu . '</b>';
        echo json_encode($result);
    }

    function add_log_client()
    {
        $this->load->model('ext_model');
        $data = $this->ext_model->hakAkses($this->input->post('hak_akses'))->row();
        add_log('<div>Membuka menu <b>' . $data->nama_menu . '</b></div>');
    }

    function call_pusher()
    {
        call_pusher($this->input->post('channel'));
    }
}
