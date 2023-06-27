<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengaturan_log_aktivitas extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        check_not_login();
        $this->load->model('pengaturan_log_aktivitas_m');
        if (
            check_hak_akses('pengaturan_log_aktivitas') == 'false'
        ) {
            add_log('<div>Gagal membuka menu <i>Pengaturan - Log Aktivitas</i> karena terhalang hak akses</div>');
            redirect(base_url() . 'error_403');
        }
    }

    function index()
    {
        add_log_open_menu('pengaturan_log_aktivitas');
        $data['content'] = 'pengaturan_log_aktivitas/main';
        $data['title'] = 'Pengaturan - Log Aktivitas - Notaris/PPAT';
        $this->template->normal_template($data);
    }


    // --------------------------------------------------------------------
    // Main Datatable
    // --------------------------------------------------------------------
    function load_table_main()
    {
        $data = $this->pengaturan_log_aktivitas_m->datatable_main__process();
        $result = [];
        $no = $_POST["start"] + 1;
        foreach ($data as $row) {
            $subResult = [];
            $subResult['no']      = $no;
            $subResult['nama']    = $row->nama;
            $subResult['waktu']   = $row->waktu;
            $subResult['browser'] = $row->browser;
            $subResult['ip']      = $row->ip;
            $subResult['log']     = $row->log;
            $result[] = $subResult;
            $no++;
        }
        $output = [
            "draw"              => intval($_POST["draw"]),
            "recordsTotal"      => $this->pengaturan_log_aktivitas_m->datatable_main__get_all_data(),
            "recordsFiltered"   => $this->pengaturan_log_aktivitas_m->datatable_main__get_filtered_data(),
            "data"              => $result
        ];
        echo json_encode($output);
    }


    // --------------------------------------------------------------------
    // Fungsi Umum
    // --------------------------------------------------------------------
    function load_table_select_user()
    {
        if ($this->input->post('search') != null) {
            $search = $this->input->post('search');
        } else {
            $search = '';
        }
        $result = $this->pengaturan_log_aktivitas_m->fungsi_umum__load_table_select_user($search);
        echo json_encode($result);
    }
}
