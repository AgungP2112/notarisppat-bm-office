<?php defined('BASEPATH') or exit('No direct script access allowed');

class Login_m extends CI_Model
{
    function login()
    {
        $this->db->from('settings_user');
        $this->db->where('username', $this->input->post('username'));
        $query = $this->db->get();
        return $query;
    }
}
