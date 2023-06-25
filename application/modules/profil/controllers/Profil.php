<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profil extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        check_not_login();
        $this->load->model('profil_m');
    }

    function index()
    {
        add_log('Membuka menu <b>Profil</b>');
        $data['main']    = $this->profil_m->load()->row();
        $data['content'] = 'profil/main';
        $data['title']   = 'Profil - Clover Code Palu';
        $this->template->normal_template($data);
    }

    function load_main_data()
    {
        $result = $this->profil_m->load()->row();
        echo json_encode($result);
    }

    function process_settings_user()
    {
        $this->form_validation->set_rules("nama", "NAMA", "required", ["required" => "Nama Lengkap harus diisi"]);
        $this->form_validation->set_rules("username", "USERNAME", "required|callback_check_username", ["required" => "Username harus diisi", "check_username" => "Username ini sudah ada"]);
        if ($this->input->post('password') != '') {
            $this->form_validation->set_rules("password", "PASSWORD", "required", ["required" => "Password harus diisi"]);
            $this->form_validation->set_rules("ulangi_password", "ULANGIPASSWORD", "required|matches[password]", ["required" => "Ulangi password harus diisi", "matches" => "Password tidak sama"]);
        };
        if ($this->form_validation->run() == false) {
            $result['error'] = true;
            if ($this->input->post('password') != '') {
                $result['namaError']            = form_error('nama');
                $result['usernameError']        = form_error('username');
                $result['passwordError']        = form_error('password');
                $result['ulangiPasswordError']  = form_error('ulangi_password');
            } else {
                $result['namaError']            = form_error('nama');
                $result['usernameError']        = form_error('username');
            }
        } else {
            $process = $this->profil_m->process_settings_user();
            if ($process == true) {
                $result['success'] = true;
            } else {
                $result['success'] = false;
            }
        }
        echo json_encode($result);
    }

    function check_username()
    {
        $check = $this->profil_m->check_username();
        if ($check > 0) {
            return false;
        } else {
            return true;
        }
    }
}
