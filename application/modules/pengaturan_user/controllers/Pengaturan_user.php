<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengaturan_user extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        check_not_login();
        $this->load->model('pengaturan_user_m');
        if (
            check_hak_akses('pengaturan_user__data') == 'false' &&
            check_hak_akses('pengaturan_user__add') == 'false' &&
            check_hak_akses('pengaturan_user__edit') == 'false' &&
            check_hak_akses('pengaturan_user__delete') == 'false' &&
            check_hak_akses('pengaturan_user__delete_batch') == 'false' &&
            check_hak_akses('pengaturan_user__switch_active') == 'false' &&
            check_hak_akses('pengaturan_user__switch_active_batch') == 'false' &&
            check_hak_akses('pengaturan_user__recycle_bin') == 'false' &&
            check_hak_akses('pengaturan_user__restore') == 'false' &&
            check_hak_akses('pengaturan_user__restore_batch') == 'false' &&
            check_hak_akses('pengaturan_user__destroy') == 'false' &&
            check_hak_akses('pengaturan_user__destroy_batch') == 'false'
        ) {
            add_log_forbidden('pengaturan_user__data');
            redirect(base_url() . 'error_403');
        }
    }

    function index()
    {
        add_log_open_menu('pengaturan_user__data');
        $data['content'] = 'pengaturan_user/main';
        $data['title'] = 'Pengaturan - User - Clover Code Palu';
        $this->template->normal_template($data);
    }


    // --------------------------------------------------------------------
    // Main Datatable
    // --------------------------------------------------------------------
    function load_table_main()
    {
        $data = $this->pengaturan_user_m->datatable_main__process();
        $result = [];
        $no = $_POST["start"] + 1;
        foreach ($data as $row) {
            $subResult = [];

            if (check_hak_akses('pengaturan_user__edit') == 'true') {
                $commandEdit = '<button class="dropdown-item" onclick="editForm(' . $row->user_id . ')"><i class="fas fa-edit"></i> Edit</button>';
            } else {
                $commandEdit = '';
            }
            if (check_hak_akses('pengaturan_user__delete') == 'true') {
                $commandHapus = '<button class="dropdown-item" onclick="deleteForm(' . $row->user_id . ')"><i class="fas fa-trash"></i> Hapus</button>';
            } else {
                $commandHapus = '';
            }
            if (check_hak_akses('pengaturan_user__switch_active') == 'true') {
                $commandGsk = '<button class="dropdown-item" onclick="gantiStatusKeaktifanForm(' . $row->user_id . ')"><i class="fas fa-toggle-on"></i> Ganti Status Keaktifan</button>';
            } else {
                $commandGsk = '';
            }
            if ($commandEdit == '' && $commandHapus == '' && $commandGsk == '') {
                $subResult['command'] = '<button type="button" class="btn btn-dark btn-sm disabled"><i class="fas fa-ban"></i></button>';
            } else {
                $subResult['command'] = '<div class="btn-group">
                                            <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-window-restore"></i> Action
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                ' . $commandEdit . '
                                                ' . $commandHapus . '
                                                ' . $commandGsk . '
                                            </div>
                                        </div>';
            }

            switch ($row->aktif) {
                case 'true':
                    $aktif = '<i class="fas fa-check"></i>';
                    break;
                case 'false':
                    $aktif = '<i class="fas fa-times"></i>';
                    break;
            }
            $subResult['checkbox']  = '<input type="checkbox" class="masterCheckbox" value="' . $row->user_id . '"/>';
            $subResult['no']        = $no;
            $subResult['username']  = $row->username;
            $subResult['nama']      = $row->nama;
            $subResult['jabatan']   = $row->nama_jabatan;
            $subResult['aktif']     = $aktif;
            $result[] = $subResult;
            $no++;
        }
        $output = [
            "draw"              => intval($_POST["draw"]),
            "recordsTotal"      => $this->pengaturan_user_m->datatable_main__get_all_data(),
            "recordsFiltered"   => $this->pengaturan_user_m->datatable_main__get_filtered_data(),
            "data"              => $result
        ];
        echo json_encode($output);
    }


    // --------------------------------------------------------------------
    // Add Form
    // --------------------------------------------------------------------
    function add_form()
    {
        add_log_open_menu('pengaturan_user__add');
        $data['content']    = 'pengaturan_user/add_form';
        $data['title']      = 'Pengaturan - User - Tambah - Clover Code Palu';
        $this->template->normal_template($data);
    }

    function process_add()
    {
        $this->form_validation->set_rules("jabatan_id", "JABATANID", "callback_check_jabatan_id", ["check_jabatan_id" => "Pilih jabatan"]);
        $this->form_validation->set_rules("nama", "NAMA", "required", ["required" => "Nama lengkap harus diisi"]);
        $this->form_validation->set_rules("username", "USERNAME", "required|is_unique[settings_user.username]", ["required" => "Username harus diisi", "is_unique" => "Username ini sudah ada"]);
        $this->form_validation->set_rules("password", "PASSWORD", "required", ["required" => "Password harus diisi"]);
        $this->form_validation->set_rules("ulangi_password", "ULANGIPASSWORD", "required|matches[password]", ["required" => "Ulangi Password harus diisi", "matches" => "Password tidak sama"]);
        if ($this->form_validation->run() == false) {
            $result['error']               = true;
            $result['jabatanIdError']      = form_error("jabatan_id");
            $result['namaError']           = form_error("nama");
            $result['usernameError']       = form_error("username");
            $result['passwordError']       = form_error("password");
            $result['ulangiPasswordError'] = form_error("ulangi_password");
        } else {
            $process = $this->pengaturan_user_m->add_form__process();
            if ($process == true) {
                $result['success'] = true;
            } else {
                $result['success'] = false;
            }
        }
        echo json_encode($result);
    }


    // --------------------------------------------------------------------
    // Edit Form
    // --------------------------------------------------------------------
    function edit_form()
    {
        add_log_open_menu('pengaturan_user__edit');
        $data['content']    = 'pengaturan_user/edit_form';
        $data['title']      = 'Pengaturan - User - Edit - Clover Code Palu';
        $this->template->normal_template($data);
    }

    function load_data_edit()
    {
        $result = $this->pengaturan_user_m->edit_form__get()->row();
        echo json_encode($result);
    }

    function process_edit()
    {
        $this->form_validation->set_rules("jabatan_id", "JABATANID", "callback_check_jabatan_id", ["check_jabatan_id" => "Pilih jabatan"]);
        $this->form_validation->set_rules("nama", "NAMA", "required", ["required" => "Nama harus diisi"]);
        $this->form_validation->set_rules("username", "USERNAME", "required|callback_check_username", ["required" => "Username harus diisi", "check_username" => "Username ini sudah ada"]);
        if ($this->input->post('password') != '') {
            $this->form_validation->set_rules("password", "PASSWORD", "required", ["required" => "Password harus diisi"]);
            $this->form_validation->set_rules("ulangi_password", "ULANGIPASSWORD", "required|matches[password]", ["required" => "Ulangi password harus diisi", "matches" => "Password tidak sama"]);
        };
        if ($this->form_validation->run() == false) {
            $result['error'] = true;
            if ($this->input->post('password') != '') {
                $result['jabatanIdError']       = form_error('jabatan_id');
                $result['namaError']            = form_error('nama');
                $result['usernameError']        = form_error('username');
                $result['passwordError']        = form_error('password');
                $result['ulangiPasswordError']  = form_error('ulangi_password');
            } else {
                $result['jabatanIdError']       = form_error('jabatan_id');
                $result['namaError']            = form_error('nama');
                $result['usernameError']        = form_error('username');
            }
        } else {
            $process = $this->pengaturan_user_m->edit_form__process();
            if ($process == true) {
                $result['success'] = true;
            } else {
                $result['success'] = false;
            }
        }
        echo json_encode($result);
    }


    // --------------------------------------------------------------------
    // Delete Form
    // --------------------------------------------------------------------
    function process_delete()
    {
        if (check_hak_akses('pengaturan_user__delete') == 'true') {
            add_log_open_menu('pengaturan_user__delete');
            $process = $this->pengaturan_user_m->delete_form__process();
            $result['success']  = $process;
        } else {
            add_log_forbidden('pengaturan_user__delete');
            $result['success']  = false;
            $result['redirect'] = true;
        }
        echo json_encode($result);
    }


    // --------------------------------------------------------------------
    // Delete Batch Form
    // --------------------------------------------------------------------
    function process_delete_batch()
    {
        if (check_hak_akses('pengaturan_user__delete_batch') == 'true') {
            add_log_open_menu('pengaturan_user__delete_batch');
            $process = $this->pengaturan_user_m->delete_batch_form__process();
            $result['success']  = $process;
        } else {
            add_log_forbidden('pengaturan_user__delete_batch');
            $result['success']  = false;
            $result['redirect'] = true;
        }
        echo json_encode($result);
    }


    // --------------------------------------------------------------------
    // Ganti Status Keaktifan Form
    // --------------------------------------------------------------------
    function process_ganti_status_keaktifan()
    {
        if (check_hak_akses('pengaturan_user__switch_active') == 'true') {
            add_log_open_menu('pengaturan_user__switch_active');
            $process = $this->pengaturan_user_m->ganti_status_keaktifan__process();
            $result['success']  = $process;
        } else {
            add_log_forbidden('pengaturan_user__switch_active');
            $result['success']  = false;
            $result['redirect'] = true;
        }
        echo json_encode($result);
    }


    // --------------------------------------------------------------------
    // Ganti Status Keaktifan Batch Form
    // --------------------------------------------------------------------
    function process_ganti_status_keaktifan_batch()
    {
        if (check_hak_akses('pengaturan_user__switch_active_batch') == 'true') {
            add_log_open_menu('pengaturan_user__switch_active_batch');
            $process = $this->pengaturan_user_m->ganti_status_keaktifan_batch__process();
            $result['success']      = $process;
        } else {
            add_log_forbidden('pengaturan_user__switch_active_batch');
            $result['success']  = false;
            $result['redirect'] = true;
        }
        echo json_encode($result);
    }


    // --------------------------------------------------------------------
    // Recycle Bin Form
    // --------------------------------------------------------------------
    function recycle_bin_form()
    {
        add_log_open_menu('pengaturan_user__recycle_bin');
        $data['content'] = 'pengaturan_user/recycle_bin_form';
        $data['title']   = 'Pengaturan - User - Lihat Tong Sampah - Clover Code Palu';
        $this->template->normal_template($data);
    }

    function load_table_recycle_bin()
    {
        $data = $this->pengaturan_user_m->datatable_recycle_bin__process();
        $result = [];
        $no = $_POST["start"] + 1;
        foreach ($data as $row) {
            $subResult = [];
            if (check_hak_akses('pengaturan_user__restore') == 'true') {
                $commandRestore = '<button class="dropdown-item" onclick="restoreForm(' . $row->user_id . ')"><i class="fas fa-trash-restore"></i> Pulihkan</button>';
            } else {
                $commandRestore = '';
            }
            if (check_hak_akses('pengaturan_user__destroy') == 'true') {
                $commandDestroy = '<button class="dropdown-item" onclick="destroyForm(' . $row->user_id . ')"><i class="fas fa-dumpster-fire"></i> Hancurkan</button>';
            } else {
                $commandDestroy = '';
            }
            if ($commandRestore == '' && $commandDestroy == '') {
                $subResult['command'] = '<button type="button" class="btn btn-dark btn-sm disabled"><i class="fas fa-ban"></i></button>';
            } else {
                $subResult['command'] = '<div class="btn-group">
                                            <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-window-restore"></i> Action
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                ' . $commandRestore . '
                                                ' . $commandDestroy . '
                                            </div>
                                        </div>';
            }
            switch ($row->aktif) {
                case 'true':
                    $aktif = '<i class="fas fa-check"></i>';
                    break;
                case 'false':
                    $aktif = '<i class="fas fa-times"></i>';
                    break;
            }
            $subResult['checkbox']  = '<input type="checkbox" class="masterCheckbox" value="' . $row->user_id . '"/>';
            $subResult['no']        = $no;
            $subResult['username']  = $row->username;
            $subResult['nama']      = $row->nama;
            $subResult['jabatan']   = $row->nama_jabatan;
            $subResult['aktif']     = $aktif;
            $result[] = $subResult;
            $no++;
        }
        $output = [
            "draw"              => intval($_POST["draw"]),
            "recordsTotal"      => $this->pengaturan_user_m->datatable_recycle_bin__get_all_data(),
            "recordsFiltered"   => $this->pengaturan_user_m->datatable_recycle_bin__get_filtered_data(),
            "data"              => $result
        ];
        echo json_encode($output);
    }


    // --------------------------------------------------------------------
    // Restore Form
    // --------------------------------------------------------------------
    function process_restore()
    {
        if (check_hak_akses('pengaturan_user__restore') == 'true') {
            add_log_open_menu('pengaturan_user__restore');
            $process = $this->pengaturan_user_m->restore_form__process();
            $result['success']      = $process;
        } else {
            add_log_forbidden('pengaturan_user__restore');
            $result['success']  = false;
            $result['redirect'] = true;
        }
        echo json_encode($result);
    }


    // --------------------------------------------------------------------
    // Restore Batch Form
    // --------------------------------------------------------------------
    function process_restore_batch()
    {
        if (check_hak_akses('pengaturan_user__restore_batch') == 'true') {
            add_log_open_menu('pengaturan_user__restore_batch');
            $process = $this->pengaturan_user_m->restore_batch_form__process();
            $result['success']      = $process;
        } else {
            add_log_forbidden('pengaturan_user__restore_batch');
            $result['success']  = false;
            $result['redirect'] = true;
        }
        echo json_encode($result);
    }


    // --------------------------------------------------------------------
    // Destroy Form
    // --------------------------------------------------------------------
    function process_destroy()
    {
        if (check_hak_akses('pengaturan_user__destroy') == 'true') {
            add_log_open_menu('pengaturan_user__destroy');
            $process = $this->pengaturan_user_m->destroy_form__process();
            $result['success']      = $process;
        } else {
            add_log_forbidden('pengaturan_user__destroy');
            $result['success']  = false;
            $result['redirect'] = true;
        }
        echo json_encode($result);
    }


    // --------------------------------------------------------------------
    // Destroy Batch Form
    // --------------------------------------------------------------------
    function process_destroy_batch()
    {
        if (check_hak_akses('pengaturan_user__destroy_batch') == 'true') {
            add_log_open_menu('pengaturan_user__destroy_batch');
            $process = $this->pengaturan_user_m->destroy_batch_form__process();
            $result['success']      = $process;
        } else {
            add_log_forbidden('pengaturan_user__destroy_batch');
            $result['success']  = false;
            $result['redirect'] = true;
        }
        echo json_encode($result);
    }


    // --------------------------------------------------------------------
    // Fungsi Umum
    // --------------------------------------------------------------------
    function load_select_jabatan()
    {
        if ($this->input->post('search') != null) {
            $search = $this->input->post('search');
        } else {
            $search = '';
        }
        $result = $this->pengaturan_user_m->fungsi_umum__load_select_jabatan($search);
        echo json_encode($result);
    }

    function check_jabatan_id()
    {
        if ($this->input->post('jabatan_id') == null) {
            return false;
        } else {
            return true;
        }
    }

    function check_username()
    {
        $check = $this->pengaturan_user_m->fungsi_umum__check_username();
        if ($check > 0) {
            return false;
        } else {
            return true;
        }
    }
}
