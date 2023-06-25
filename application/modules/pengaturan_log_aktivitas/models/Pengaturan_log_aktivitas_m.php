<?php defined('BASEPATH') or exit('No direct script access allowed');

class Pengaturan_log_aktivitas_m extends CI_Model
{
    // --------------------------------------------------------------------
    // Main Datatable
    // --------------------------------------------------------------------
    function datatable_main__query()
    {
        $orderColumn  = [null, null, 'waktu', 'browser', 'ip', 'log'];
        $searchColumn = [null, null, 'waktu', 'browser', 'ip', 'log'];
        $order        = ['log_id' => 'desc'];
        $row          = 0;

        $this->db->select('settings_log_user.*');
        $this->db->select('settings_user.nama');
        $this->db->from('settings_log_user');
        $this->db->join('settings_user', 'settings_user.user_id = settings_log_user.user_id');
        switch ($_POST['columns'][1]['search']['value']) {
            case '0': // Semua
                break;
            case '': // Semua
                break;
            default:
                $this->db->where('settings_user.user_id', $_POST['columns'][1]['search']['value']);
                break;
        }
        foreach ($searchColumn as $item) {
            if ($item != null && $_POST['columns'][$row]['search']['value']) {
                $this->db->like($item, $_POST['columns'][$row]['search']['value']);
            }
            $row++;
        }
        if (isset($_POST["order"])) {
            $this->db->order_by($orderColumn[$_POST["order"]["0"]["column"]], $_POST["order"]["0"]["dir"]);
        } else {
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function datatable_main__process()
    {
        $this->datatable_main__query();
        if ($_POST["length"] != -1) {
            $this->db->limit($_POST["length"], $_POST["start"]);
        }
        $query = $this->db->get();
        return $query->result();
    }

    function datatable_main__get_filtered_data()
    {
        $this->datatable_main__query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    function datatable_main__get_all_data()
    {
        $this->db->from('settings_log_user');
        return $this->db->count_all_results();
    }


    // --------------------------------------------------------------------
    // Fungsi Umum
    // --------------------------------------------------------------------
    function fungsi_umum__load_table_select_user($search = '')
    {
        $this->db->from('settings_user');
        $this->db->like('username', $search);
        $query = $this->db->get();
        $result = [];
        $result[] = ['id' => 0, 'text' => '-- SEMUA --'];
        foreach ($query->result() as $row) {
            $result[] = [
                'id' => $row->user_id,
                'text' => $row->nama
            ];
        }
        return $result;
    }
}
