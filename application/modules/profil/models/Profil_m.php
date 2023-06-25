<?php defined('BASEPATH') or exit('No direct script access allowed');

class Profil_m extends CI_Model
{
    function load()
    {
        $this->db->select('settings_user.username');
        $this->db->select('settings_user.nama');
        $this->db->select('settings_user.jabatan_id');
        $this->db->select('settings_user.created');
        $this->db->select('settings_jabatan.nama as nama_jabatan');
        $this->db->from('settings_user');
        $this->db->join('settings_jabatan', 'settings_jabatan.jabatan_id = settings_user.jabatan_id');
        $this->db->where('settings_user.user_id', $this->session->userdata('clover_code_userid'));
        $query = $this->db->get();
        return $query;
    }

    function check_username()
    {
        $this->db->from('settings_user');
        $this->db->where('username', $this->input->post('username'));
        $this->db->where('user_id !=', $this->session->userdata('clover_code_userid'));
        $query = $this->db->get();
        return $query->num_rows();
    }

    function process_settings_user()
    {
        date_default_timezone_set("Asia/Singapore");
        // ----------------------------------------------------------------------
        $params['username'] = $this->input->post('username');
        $params['nama']     = $this->input->post('nama');
        if ($this->input->post('password') != null) {
            $params['password']       = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
        }
        $params['user_update_id']   = user_id();
        $params['updated']          = date('Y-m-d H:i:s');
        $this->db->where('user_id', $this->session->userdata('clover_code_userid'));
        $this->db->update('settings_user', $params);
        // ----------------------------------------------------------------------
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
}
