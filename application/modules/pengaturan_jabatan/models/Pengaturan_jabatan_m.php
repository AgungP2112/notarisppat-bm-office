<?php defined('BASEPATH') or exit('No direct script access allowed');

class Pengaturan_jabatan_m extends CI_Model
{
    // --------------------------------------------------------------------
    // Main Datatable
    // --------------------------------------------------------------------
    function datatable_main__query()
    {
        $orderColumn  = [null, null, null, 'nama'];
        $searchColumn = [null, null, null, 'nama'];
        $order        = ['jabatan_id' => 'desc'];
        $row          = 0;

        $this->db->from('settings_jabatan');
        $this->db->where('deleted', null);
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
        $this->db->from('settings_jabatan');
        return $this->db->count_all_results();
    }


    // --------------------------------------------------------------------
    // Add Form
    // --------------------------------------------------------------------
    function add_form__process()
    {
        date_default_timezone_set("Asia/Singapore");
        // ----------------------------------------------------------------------
        $this->db->trans_begin();
        // ----------------------------------------------------------------------
        $paramsMaster['nama']           = $this->input->post('nama');
        $paramsMaster['user_create_id'] = user_id();
        $paramsMaster['created']        = date('Y-m-d H:i:s');
        $this->db->insert('settings_jabatan', $paramsMaster);
        $jabatanId = $this->db->insert_id();
        // ----------------------------------------------------------------------
        $data = [];
        foreach ($this->input->post('table') as $row) {
            $paramsDetail['jabatan_id'] = $jabatanId;
            $paramsDetail['root']       = $row['root'];
            $paramsDetail['menu']       = $row['menu'];
            $paramsDetail['nama_menu']  = $row['nama_menu'];
            $paramsDetail['akses']      = $row['akses'];
            $data[] = $paramsDetail;
        }
        $this->db->insert_batch('settings_jabatan__hak_akses', $data);
        // ----------------------------------------------------------------------
        $this->db->trans_complete();
        if ($this->db->trans_status() === true) {
            $this->db->trans_commit();
            add_log(
                '<div>Menginput data jabatan baru : <br>
                    <div><i>Nama</i> : ' . $this->input->post('nama') . '</div>
                </div>'
            );
            return true;
        } else {
            $this->db->trans_rollback();
            return false;
        }
    }


    // --------------------------------------------------------------------
    // Edit Form
    // --------------------------------------------------------------------
    function edit_form__get()
    {
        $this->db->select('settings_jabatan.*');
        $this->db->select('settings_jabatan__hak_akses.root');
        $this->db->select('settings_jabatan__hak_akses.menu');
        $this->db->select('settings_jabatan__hak_akses.nama_menu');
        $this->db->select('settings_jabatan__hak_akses.akses');
        $this->db->from('settings_jabatan');
        $this->db->join('settings_jabatan__hak_akses', 'settings_jabatan__hak_akses.jabatan_id = settings_jabatan.jabatan_id');
        $this->db->where('settings_jabatan.jabatan_id', $this->input->post('jabatan_id'));
        $query = $this->db->get();
        return $query;
    }

    function edit_form__get_menu($menu)
    {
        $this->db->from('settings_jabatan__hak_akses');
        $this->db->where('jabatan_id', $this->input->post('jabatan_id'));
        $this->db->where('menu', $menu);
        $query = $this->db->get();
        return $query;
    }

    function edit_form__process()
    {
        date_default_timezone_set("Asia/Singapore");
        // ----------------------------------------------------------------------
        $this->db->trans_begin();
        // ----------------------------------------------------------------------
        $dataLama = $this->edit_form__get()->row();
        // ----------------------------------------------------------------------
        $paramsMaster['nama']             = $this->input->post('nama');
        $paramsMaster['user_update_id']   = user_id();
        $paramsMaster['updated']          = date('Y-m-d H:i:s');
        $this->db->where('jabatan_id', $this->input->post('jabatan_id'));
        $this->db->update('settings_jabatan', $paramsMaster);
        // ----------------------------------------------------------------------
        $dataInsert = [];
        $dataUpdate = [];
        foreach ($this->input->post('table') as $row) {
            $dataMenu = $this->edit_form__get_menu($row['menu']);
            if ($dataMenu->num_rows() > 0) {
                $paramsUpdate['hak_akses_id'] = $dataMenu->row()->hak_akses_id;
                $paramsUpdate['jabatan_id']   = $this->input->post('jabatan_id');
                $paramsUpdate['root']         = $row['root'];
                $paramsUpdate['menu']         = $row['menu'];
                $paramsUpdate['nama_menu']    = $row['nama_menu'];
                $paramsUpdate['akses']        = $row['akses'];
                $dataUpdate[] = $paramsUpdate;
            } else {
                $paramsInsert['jabatan_id'] = $this->input->post('jabatan_id');
                $paramsInsert['root']       = $row['root'];
                $paramsInsert['menu']       = $row['menu'];
                $paramsInsert['nama_menu']  = $row['nama_menu'];
                $paramsInsert['akses']      = $row['akses'];
                $dataInsert[] = $paramsInsert;
            }
        }
        if (count($dataInsert) > 0) {
            $this->db->insert_batch('settings_jabatan__hak_akses', $dataInsert);
        }
        if (count($dataUpdate) > 0) {
            $this->db->update_batch('settings_jabatan__hak_akses', $dataUpdate, 'hak_akses_id');
        }
        // ----------------------------------------------------------------------
        $this->db->trans_complete();
        if ($this->db->trans_status() === true) {
            $this->db->trans_commit();
            add_log(
                '<div>Mengubah data jabatan :
                    <div><b>Sebelum</b></div>
                    <div><i>Nama</i> : ' . $dataLama->nama . '</div>
                    
                    <div><b>Sesudah</b></div>
                    <div><i>Nama</i> : ' . $this->input->post('nama') . '</div>
                </div>'
            );
            return true;
        } else {
            $this->db->trans_rollback();
            return false;
        }
    }


    // --------------------------------------------------------------------
    // Delete Form
    // --------------------------------------------------------------------
    function delete_form__get()
    {
        $this->db->from('settings_jabatan');
        $this->db->where('jabatan_id', $this->input->post('jabatan_id'));
        $query = $this->db->get();
        return $query;
    }

    function delete_form__process()
    {
        date_default_timezone_set("Asia/Singapore");
        // ----------------------------------------------------------------------
        $dataLama = $this->delete_form__get()->row();
        // ----------------------------------------------------------------------
        $params['user_delete_id']   = user_id();
        $params['deleted']          = date('Y-m-d H:i:s');
        $this->db->where('jabatan_id', $this->input->post('jabatan_id'));
        $this->db->update('settings_jabatan', $params);
        // ----------------------------------------------------------------------
        if ($this->db->affected_rows() > 0) {
            add_log(
                '<div>Menghapus data jabatan :
                    <div><i>Nama</i> : ' . $dataLama->nama . '</div>
                </div>'
            );
            return true;
        } else {
            return false;
        }
    }


    // --------------------------------------------------------------------
    // Delete Batch Form
    // --------------------------------------------------------------------
    function delete_batch_form__get($id)
    {
        $this->db->from('settings_jabatan');
        $this->db->where('jabatan_id', $id);
        $query = $this->db->get();
        return $query;
    }

    function delete_batch_form__process()
    {
        date_default_timezone_set('Asia/Singapore');
        $this->db->trans_begin();
        // ----------------------------------------------------------------------
        $dataDelete = [];
        $log = [];
        // ----------------------------------------------------------------------
        foreach ($this->input->post('id') as $row) {
            $params['jabatan_id']    = $row;
            $params['user_delete_id'] = user_id();
            $params['deleted']        = date('Y-m-d H:i:s');
            $dataDelete[] = $params;

            $dataLama = $this->delete_batch_form__get($row)->row();
            $logText = '<div>Menghapus data jabatan :
                            <div><i>Nama</i> : ' . $dataLama->nama . ' </div>
                        </div>';
            $log[] = $logText;
        }
        $this->db->update_batch('settings_jabatan', $dataDelete, 'jabatan_id');
        // ----------------------------------------------------------------------
        $this->db->trans_complete();
        if ($this->db->trans_status() === true) {
            $this->db->trans_commit();
            foreach ($log as $rowLog) {
                add_log($rowLog);
            }
            return true;
        } else {
            $this->db->trans_rollback();
            return false;
        }
    }


    // --------------------------------------------------------------------
    // Recycle Bin Datatable
    // --------------------------------------------------------------------
    function datatable_recycle_bin__query()
    {
        $orderColumn  = [null, null, null, 'nama'];
        $searchColumn = [null, null, null, 'nama'];
        $order        = ['jabatan_id' => 'desc'];
        $row          = 0;

        $this->db->from('settings_jabatan');
        $this->db->where('deleted !=', null);
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

    function datatable_recycle_bin__process()
    {
        $this->datatable_recycle_bin__query();
        if ($_POST["length"] != -1) {
            $this->db->limit($_POST["length"], $_POST["start"]);
        }
        $query = $this->db->get();
        return $query->result();
    }

    function datatable_recycle_bin__get_filtered_data()
    {
        $this->datatable_recycle_bin__query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    function datatable_recycle_bin__get_all_data()
    {
        $this->db->from('settings_jabatan');
        return $this->db->count_all_results();
    }


    // --------------------------------------------------------------------
    // Restore Form
    // --------------------------------------------------------------------
    function restore_form__get()
    {
        $this->db->from('settings_jabatan');
        $this->db->where('jabatan_id', $this->input->post('jabatan_id'));
        $query = $this->db->get();
        return $query;
    }

    function restore_form__process()
    {
        date_default_timezone_set("Asia/Singapore");
        // ----------------------------------------------------------------------
        $dataLama = $this->restore_form__get()->row();
        // ----------------------------------------------------------------------
        $params['user_restore_id'] = user_id();
        $params['restored']        = date('Y-m-d H:i:s');
        $params['user_delete_id']  = null;
        $params['deleted']         = null;
        $this->db->where('jabatan_id', $this->input->post('jabatan_id'));
        $this->db->update('settings_jabatan', $params);
        // ----------------------------------------------------------------------
        if ($this->db->affected_rows() > 0) {
            add_log(
                '<div>Memulihkan data jabatan yang sebelumnya terhapus :
                    <div><i>Nama</i> : ' . $dataLama->nama . '</div>
                </div>'
            );
            return true;
        } else {
            return false;
        }
    }


    // --------------------------------------------------------------------
    // Restore Batch Form
    // --------------------------------------------------------------------
    function restore_batch_form__get($id)
    {
        $this->db->from('settings_jabatan');
        $this->db->where('jabatan_id', $id);
        $query = $this->db->get();
        return $query;
    }

    function restore_batch_form__process()
    {
        date_default_timezone_set('Asia/Singapore');
        $this->db->trans_begin();
        // ----------------------------------------------------------------------
        $dataRestore = [];
        $log = [];
        // ----------------------------------------------------------------------
        foreach ($this->input->post('id') as $row) {
            $params['jabatan_id']     = $row;
            $params['user_restore_id'] = user_id();
            $params['restored']        = date('Y-m-d H:i:s');
            $params['user_delete_id']  = null;
            $params['deleted']         = null;
            $dataRestore[] = $params;

            $dataLama = $this->restore_batch_form__get($row)->row();
            $logText = '<div>Memulihkan data jabatan yang sebelumnya terhapus :
                            <div><i>Nama</i> : ' . $dataLama->nama . ' </div>
                        </div>';
            $log[] = $logText;
        }
        $this->db->update_batch('settings_jabatan', $dataRestore, 'jabatan_id');
        // ----------------------------------------------------------------------
        $this->db->trans_complete();
        if ($this->db->trans_status() === true) {
            $this->db->trans_commit();
            foreach ($log as $rowLog) {
                add_log($rowLog);
            }
            return true;
        } else {
            $this->db->trans_rollback();
            return false;
        }
    }


    // --------------------------------------------------------------------
    // Destroy Form
    // --------------------------------------------------------------------
    function destroy_form__get()
    {
        $this->db->from('settings_jabatan');
        $this->db->where('jabatan_id', $this->input->post('jabatan_id'));
        $query = $this->db->get();
        return $query;
    }

    function destroy_form__process()
    {
        date_default_timezone_set("Asia/Singapore");
        // ----------------------------------------------------------------------
        $dataLama = $this->destroy_form__get()->row();
        // ----------------------------------------------------------------------
        $this->db->where('jabatan_id', $this->input->post('jabatan_id'));
        $this->db->delete('settings_jabatan');

        $this->db->where('jabatan_id', $this->input->post('jabatan_id'));
        $this->db->delete('settings_jabatan__hak_akses');
        // ----------------------------------------------------------------------
        if ($this->db->affected_rows() > 0) {
            add_log(
                '<div>Menghancurkan data jabatan yang sebelumnya terhapus :
                    <div><i>Nama</i> : ' . $dataLama->nama . '</div>                    
                </div>'
            );
            return true;
        } else {
            return false;
        }
    }


    // --------------------------------------------------------------------
    // Destroy Batch Form
    // --------------------------------------------------------------------
    function destroy_batch_form__get($id)
    {
        $this->db->from('settings_jabatan');
        $this->db->where('jabatan_id', $id);
        $query = $this->db->get();
        return $query;
    }

    function destroy_batch_form__process()
    {
        date_default_timezone_set('Asia/Singapore');
        $this->db->trans_begin();
        // ----------------------------------------------------------------------
        $log = [];
        // ----------------------------------------------------------------------
        foreach ($this->input->post('id') as $row) {
            $dataLama = $this->destroy_batch_form__get($row)->row();
            $logText = '<div>Menghancurkan data jabatan yang sebelumnya terhapus :
                            <div><i>Nama</i> : ' . $dataLama->nama . ' </div>
                        </div>';
            $log[] = $logText;
        }
        $this->db->where_in('jabatan_id', $this->input->post('id'));
        $this->db->delete('settings_jabatan');

        $this->db->where_in('jabatan_id', $this->input->post('id'));
        $this->db->delete('settings_jabatan__hak_akses');
        // ----------------------------------------------------------------------
        $this->db->trans_complete();
        if ($this->db->trans_status() === true) {
            $this->db->trans_commit();
            foreach ($log as $rowLog) {
                add_log($rowLog);
            }
            return true;
        } else {
            $this->db->trans_rollback();
            return false;
        }
    }
}
