<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Master_data_penanggung_jawab extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        check_not_login();
        $this->load->model('master_data_penanggung_jawab_m');
        if (
            check_hak_akses('master_data_penanggung_jawab__data') == 'false' &&
            check_hak_akses('master_data_penanggung_jawab__add') == 'false' &&
            check_hak_akses('master_data_penanggung_jawab__edit') == 'false' &&
            check_hak_akses('master_data_penanggung_jawab__edit_batch') == 'false' &&
            check_hak_akses('master_data_penanggung_jawab__delete') == 'false' &&
            check_hak_akses('master_data_penanggung_jawab__delete_batch') == 'false' &&
            check_hak_akses('master_data_penanggung_jawab__recycle_bin') == 'false' &&
            check_hak_akses('master_data_penanggung_jawab__restore') == 'false' &&
            check_hak_akses('master_data_penanggung_jawab__restore_batch') == 'false' &&
            check_hak_akses('master_data_penanggung_jawab__destroy') == 'false' &&
            check_hak_akses('master_data_penanggung_jawab__destroy_batch') == 'false'
        ) {
            add_log_forbidden('master_data_penanggung_jawab__data');
            redirect(base_url() . 'error_403');
        }
    }

    function index()
    {
        add_log_open_menu('master_data_penanggung_jawab__data');
        $data['content'] = 'master_data_penanggung_jawab/main';
        $data['title']   = 'Master Data - Penanggung Jawab - Notaris/PPAT';
        $this->template->normal_template($data);
    }


    // --------------------------------------------------------------------
    // Main Datatable
    // --------------------------------------------------------------------
    function load_table_main()
    {
        $data = $this->master_data_penanggung_jawab_m->datatable_main__process();
        $result = [];
        $no = $_POST["start"] + 1;
        foreach ($data as $row) {
            $subResult = [];

            if (check_hak_akses('master_data_penanggung_jawab__edit') == 'true') {
                $commandEdit = '<button class="dropdown-item" onclick="editForm(' . $row->penanggung_jawab_id . ')"><i class="fas fa-edit"></i> Edit</button>';
            } else {
                $commandEdit = '';
            }
            if (check_hak_akses('master_data_penanggung_jawab__delete') == 'true') {
                $commandHapus = '<button class="dropdown-item" onclick="deleteForm(' . $row->penanggung_jawab_id . ')"><i class="fas fa-trash"></i> Hapus</button>';
            } else {
                $commandHapus = '';
            }

            if ($commandEdit == '' && $commandHapus == '') {
                $subResult['command'] = '<button type="button" class="btn btn-dark btn-sm disabled"><i class="fas fa-ban"></i></button>';
            } else {
                $subResult['command'] = '<div class="btn-group">
                                            <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-window-restore"></i> Action
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                ' . $commandEdit . '
                                                ' . $commandHapus . '
                                            </div>
                                        </div>';
            }

            $subResult['checkbox']       = '<input type="checkbox" class="masterCheckbox" value="' . $row->penanggung_jawab_id . '"/>';
            $subResult['no']             = $no;
            $subResult['nama']           = $row->nama;
            $result[] = $subResult;
            $no++;
        }
        $output = [
            "draw"              => intval($_POST["draw"]),
            "recordsTotal"      => $this->master_data_penanggung_jawab_m->datatable_main__get_all_data(),
            "recordsFiltered"   => $this->master_data_penanggung_jawab_m->datatable_main__get_filtered_data(),
            "data"              => $result
        ];
        echo json_encode($output);
    }


    // --------------------------------------------------------------------
    // Add Form
    // --------------------------------------------------------------------
    function add_form()
    {
        add_log_open_menu('master_data_penanggung_jawab__add');
        $data['content'] = 'master_data_penanggung_jawab/add_form';
        $data['title']   = 'Master Data - Penanggung Jawab - Tambah - Notaris/PPAT';
        $this->template->normal_template($data);
    }

    function process_add()
    {
        $this->form_validation->set_rules("nama", "NAMA", "required", ["required" => "Nama penanggung jawab harus diisi"]);
        if ($this->form_validation->run() == false) {
            $result['error']     = true;
            $result['namaError'] = form_error("nama");
        } else {
            $process = $this->master_data_penanggung_jawab_m->add_form__process();
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
        add_log_open_menu('master_data_penanggung_jawab__edit');
        $data['content'] = 'master_data_penanggung_jawab/edit_form';
        $data['title']   = 'Master Data - Penanggung Jawab - Edit - Notaris/PPAT';
        $this->template->normal_template($data);
    }

    function load_data_edit()
    {
        $result = $this->master_data_penanggung_jawab_m->edit_form__get()->row();
        echo json_encode($result);
    }

    function process_edit()
    {
        $this->form_validation->set_rules("nama", "NAMA", "required", ["required" => "Nama penanggung jawab harus diisi"]);
        if ($this->form_validation->run() == false) {
            $result['error']     = true;
            $result['namaError'] = form_error("nama");
        } else {
            $process = $this->master_data_penanggung_jawab_m->edit_form__process();
            if ($process == true) {
                $result['success'] = true;
            } else {
                $result['success'] = false;
            }
        }
        echo json_encode($result);
    }


    // --------------------------------------------------------------------
    // Edit Batch Form
    // --------------------------------------------------------------------
    function edit_batch_form()
    {
        add_log_open_menu('master_data_penanggung_jawab__edit_batch');
        $data['content'] = 'master_data_penanggung_jawab/edit_batch_form';
        $data['title']   = 'Master Data - Penanggung Jawab - Edit Batch - Notaris/PPAT';
        $this->template->normal_template($data);
    }

    function load_data_edit_batch()
    {
        $id = explode(',', $this->input->post('penanggung_jawab_id'));
        $result = $this->master_data_penanggung_jawab_m->edit_batch_form__get_batch($id)->result();
        echo json_encode($result);
    }

    function process_edit_batch()
    {
        $this->form_validation->set_rules("nama", "NAMA", "required", ["required" => "Nama penanggung jawab harus diisi"]);
        if ($this->form_validation->run() == false) {
            $result['error']     = true;
            $result['namaError'] = form_error("nama");
        } else {
            $process = $this->master_data_penanggung_jawab_m->edit_batch_form__process();
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
        if (check_hak_akses('master_data_penanggung_jawab__delete') == 'true') {
            add_log_open_menu('master_data_penanggung_jawab__delete');
            $process = $this->master_data_penanggung_jawab_m->delete_form__process();
            $result['success']      = $process;
        } else {
            add_log_forbidden('master_data_penanggung_jawab__delete');
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
        if (check_hak_akses('master_data_penanggung_jawab__delete_batch') == 'true') {
            add_log_open_menu('master_data_penanggung_jawab__delete_batch');
            $process = $this->master_data_penanggung_jawab_m->delete_batch_form__process();
            $result['success']      = $process;
        } else {
            add_log_forbidden('master_data_penanggung_jawab__delete_batch');
            $result['success']  = false;
            $result['redirect'] = true;
        }
        echo json_encode($result);
    }


    // --------------------------------------------------------------------
    // Recycle Bin Datatable
    // --------------------------------------------------------------------
    function recycle_bin_form()
    {
        add_log_open_menu('master_data_penanggung_jawab__recycle_bin');
        $data['content'] = 'master_data_penanggung_jawab/recycle_bin_form';
        $data['title']   = 'Master Data - Penanggung Jawab - Lihat Tong Sampah - Notaris/PPAT';
        $this->template->normal_template($data);
    }

    function load_table_recycle_bin()
    {
        $data = $this->master_data_penanggung_jawab_m->datatable_recycle_bin__process();
        $result = [];
        $no = $_POST["start"] + 1;
        foreach ($data as $row) {
            $subResult = [];
            if (check_hak_akses('master_data_penanggung_jawab__restore') == 'true') {
                $commandRestore = '<button class="dropdown-item" onclick="restoreForm(' . $row->penanggung_jawab_id . ')"><i class="fas fa-trash-restore"></i> Pulihkan</button>';
            } else {
                $commandRestore = '';
            }
            if (check_hak_akses('master_data_penanggung_jawab__destroy') == 'true') {
                $commandDestroy = '<button class="dropdown-item" onclick="destroyForm(' . $row->penanggung_jawab_id . ')"><i class="fas fa-dumpster-fire"></i> Hancurkan</button>';
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

            $subResult['checkbox'] = '<input type="checkbox" class="masterCheckbox" value="' . $row->penanggung_jawab_id . '"/>';
            $subResult['no']       = $no;
            $subResult['nama']     = $row->nama;
            $result[] = $subResult;
            $no++;
        }
        $output = [
            "draw"              => intval($_POST["draw"]),
            "recordsTotal"      => $this->master_data_penanggung_jawab_m->datatable_recycle_bin__get_all_data(),
            "recordsFiltered"   => $this->master_data_penanggung_jawab_m->datatable_recycle_bin__get_filtered_data(),
            "data"              => $result
        ];
        echo json_encode($output);
    }


    // --------------------------------------------------------------------
    // Restore Form
    // --------------------------------------------------------------------
    function process_restore()
    {
        if (check_hak_akses('master_data_penanggung_jawab__restore') == 'true') {
            add_log_open_menu('master_data_penanggung_jawab__restore');
            $process = $this->master_data_penanggung_jawab_m->restore_form__process();
            $result['success']      = $process;
        } else {
            add_log_forbidden('master_data_penanggung_jawab__restore');
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
        if (check_hak_akses('master_data_penanggung_jawab__restore_batch') == 'true') {
            add_log_open_menu('master_data_penanggung_jawab__restore_batch');
            $process = $this->master_data_penanggung_jawab_m->restore_batch_form__process();
            $result['success']      = $process;
        } else {
            add_log_forbidden('master_data_penanggung_jawab__restore_batch');
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
        if (check_hak_akses('master_data_penanggung_jawab__destroy') == 'true') {
            add_log_open_menu('master_data_penanggung_jawab__destroy');
            $process = $this->master_data_penanggung_jawab_m->destroy_form__process();
            $result['success']      = $process;
        } else {
            add_log_forbidden('master_data_penanggung_jawab__destroy');
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
        if (check_hak_akses('master_data_penanggung_jawab__destroy_batch') == 'true') {
            add_log_open_menu('master_data_penanggung_jawab__destroy_batch');
            $process = $this->master_data_penanggung_jawab_m->destroy_batch_form__process();
            $result['success']      = $process;
        } else {
            add_log_forbidden('master_data_penanggung_jawab__destroy_batch');
            $result['success']  = false;
            $result['redirect'] = true;
        }
        echo json_encode($result);
    }
}
