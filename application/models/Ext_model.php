<?php defined('BASEPATH') or exit('No direct script access allowed');

class Ext_model extends CI_Model
{
    function get_user($id = null)
    {
        $this->db->from('settings_user');
        if ($id != null) {
            $this->db->where('user_id', $id);
        }
        $query = $this->db->get();
        return $query;
    }

    function check_root_hak_akses($menu)
    {
        $this->db->from('settings_jabatan__hak_akses');
        $this->db->where('root', $menu);
        $this->db->where('jabatan_id', $this->session->userdata('notarisppat_jabatanid'));
        $query = $this->db->get();
        $result = false;
        foreach ($query->result() as $row) {
            if ($row->akses == 'true') {
                $result = true;
                break;
            }
        }
        return $result;
    }

    function check_hak_akses($menu)
    {
        $this->db->from('settings_jabatan__hak_akses');
        $this->db->where('menu', $menu);
        $this->db->where('jabatan_id', $this->session->userdata('notarisppat_jabatanid'));
        $query = $this->db->get();
        return $query->row()->akses;
    }

    function load_menu($menu)
    {
        $this->db->from('settings_jabatan__hak_akses');
        $this->db->where('menu', $menu);
        $this->db->where('jabatan_id', $this->session->userdata('notarisppat_jabatanid'));
        $query = $this->db->get();
        return $query;
    }

    function add_log($log)
    {
        date_default_timezone_set('Asia/Singapore');
        $params['user_id']  = user_id();
        $params['waktu']    = sys_date_time();
        $params['log']      = $log;
        $params['browser']  = $this->agent->browser() . ' ' . $this->agent->version();
        $params['ip']       = $this->input->ip_address();
        $this->db->insert('settings_log_user', $params);
    }

    function add_log_open_menu($menu)
    {
        date_default_timezone_set('Asia/Singapore');
        $data = $this->load_menu($menu)->row();
        $params['user_id']  = user_id();
        $params['waktu']    = sys_date_time();
        $params['log']      = '<div>Membuka menu <b>' . $data->nama_menu . '</b></div>';
        $params['browser']  = $this->agent->browser() . ' ' . $this->agent->version();
        $params['ip']       = $this->input->ip_address();
        $this->db->insert('settings_log_user', $params);
    }

    function add_log_forbidden($menu)
    {
        date_default_timezone_set('Asia/Singapore');
        $data = $this->load_menu($menu)->row();
        $params['user_id']  = user_id();
        $params['waktu']    = sys_date_time();
        $params['log']      = '<div>Gagal membuka menu <b>' . $data->nama_menu . '</b> karena terhalang hak akses</div>';
        $params['browser']  = $this->agent->browser() . ' ' . $this->agent->version();
        $params['ip']       = $this->input->ip_address();
        $this->db->insert('settings_log_user', $params);
    }
}
