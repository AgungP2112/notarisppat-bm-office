<?php defined('BASEPATH') or exit('No direct script access allowed');

class Login extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('login_m');
    }

    function index()
    {
        check_already_login();
        $data["content"]  = 'login/main';
        $data["title"]    = 'Login - Notaris/PPAT';
        $this->template->login_template($data);
    }

    function process_login()
    {
        $this->form_validation->set_rules('username', 'USERNAME', 'required', ['required' => 'Username harus diisi']);
        $this->form_validation->set_rules('password', 'PASSWORD', 'required', ['required' => 'Password harus diisi']);
        if ($this->form_validation->run() == FALSE) {
            $result["error"]         = true;
            $result["usernameError"] = form_error("username");
            $result["passwordError"] = form_error("password");
        } else {
            $data = $this->login_m->login();
            if ($data->num_rows() > 0) {
                if (password_verify($this->input->post('password'), $data->row()->password)) {
                    if ($data->row()->aktif == 'true') {
                        $params["notarisppat_userid"]     = $data->row()->user_id;
                        $params["notarisppat_namauser"]   = $data->row()->nama;
                        $params["notarisppat_jabatanid"]  = $data->row()->jabatan_id;
                        $this->session->set_userdata($params);
                        add_log(
                            '<div>Login</div>'
                        );
                        $result["success"]          = true;
                    } else {
                        $result['error']         = true;
                        $result["usernameError"] = '';
                        $result["passwordError"] = '';
                        $result['customError']   = 'Username ini sedang dinonaktifkan. Silahkan hubungi administrator untuk penanganan lebih lanjut';
                    }
                } else {
                    $result['error']         = true;
                    $result["usernameError"] = '';
                    $result["passwordError"] = '';
                    $result['customError']   = 'Username atau password salah';
                }
            } else {
                $result['error']         = true;
                $result["usernameError"] = '';
                $result["passwordError"] = '';
                $result['customError']   = 'User ini tidak ditemukan';
            }
        }
        echo json_encode($result);
    }

    function logout()
    {
        $params = [];
        $params[] = 'notarisppat_userid';
        $params[] = 'notarisppat_namauser';
        $params[] = 'notarisppat_jabatanid';
        add_log(
            '<div>Logout</div>'
        );
        $this->session->unset_userdata($params);
        redirect(base_url() . 'login');
    }
}
