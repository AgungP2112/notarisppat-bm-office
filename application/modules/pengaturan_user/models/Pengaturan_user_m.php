<?php defined('BASEPATH') or exit('No direct script access allowed');

class Pengaturan_user_m extends CI_Model
{
	// --------------------------------------------------------------------
	// Main Datatable
	// --------------------------------------------------------------------
	function datatable_main__query()
	{
		$orderColumn  = [null, null, null, 'settings_user.username', 'settings_user.nama', 'settings_jabatan.nama', null];
		$searchColumn = [null, null, null, 'settings_user.username', 'settings_user.nama', 'settings_jabatan.nama', null];
		$order        = ['settings_user.user_id' => 'desc'];
		$row          = 0;

		$this->db->select('settings_user.user_id');
		$this->db->select('settings_user.jabatan_id');
		$this->db->select('settings_user.username');
		$this->db->select('settings_user.nama');
		$this->db->select('settings_user.aktif');
		$this->db->select('settings_jabatan.nama as nama_jabatan');
		$this->db->from('settings_user');
		$this->db->join('settings_jabatan', 'settings_jabatan.jabatan_id = settings_user.jabatan_id');
		$this->db->where('settings_user.deleted', null);
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
		$this->db->from('settings_user');
		return $this->db->count_all_results();
	}


	// --------------------------------------------------------------------
	// Add Form
	// --------------------------------------------------------------------
	function add_form__get_jabatan()
	{
		$this->db->from('settings_jabatan');
		$this->db->where('jabatan_id', $this->input->post('jabatan_id'));
		$query = $this->db->get();
		return $query;
	}

	function add_form__process()
	{
		date_default_timezone_set("Asia/Singapore");
		// ----------------------------------------------------------------------
		$params['jabatan_id']     = $this->input->post('jabatan_id');
		$params['username']       = $this->input->post('username');
		$params['nama']           = $this->input->post('nama');
		$params['password']       = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
		$params['aktif']          = 'true';
		$params['user_create_id'] = user_id();
		$params['created']        = date('Y-m-d H:i:s');
		$this->db->insert('settings_user', $params);
		// ----------------------------------------------------------------------
		if ($this->db->affected_rows() > 0) {
			$dataJabatan = $this->add_form__get_jabatan()->row();
			add_log(
				'<div>Menginput data user baru : <br>
                    <div><i>Username</i> : ' . $this->input->post('username') . '</div>
                    <div><i>Nama Lengkap</i> : ' .  $this->input->post('nama') . '</div>
                    <div><i>Jabatan</i> : ' .  $dataJabatan->nama . '</div>
                </div>'
			);
			return true;
		} else {
			return false;
		}
	}


	// --------------------------------------------------------------------
	// Edit Form
	// --------------------------------------------------------------------
	function edit_form__get()
	{
		$this->db->select('settings_user.user_id');
		$this->db->select('settings_user.jabatan_id');
		$this->db->select('settings_user.username');
		$this->db->select('settings_user.nama');
		$this->db->select('settings_user.aktif');
		$this->db->select('settings_jabatan.nama as nama_jabatan');
		$this->db->from('settings_user');
		$this->db->join('settings_jabatan', 'settings_jabatan.jabatan_id = settings_user.jabatan_id');
		$this->db->where('settings_user.user_id', $this->input->post('user_id'));
		$query = $this->db->get();
		return $query;
	}

	function edit_form__get_jabatan()
	{
		$this->db->from('settings_jabatan');
		$this->db->where('jabatan_id', $this->input->post('jabatan_id'));
		$query = $this->db->get();
		return $query;
	}

	function edit_form__process()
	{
		date_default_timezone_set("Asia/Singapore");
		// ----------------------------------------------------------------------
		$dataLama    = $this->edit_form__get()->row();
		$jabatanBaru = $this->edit_form__get_jabatan()->row();
		// ----------------------------------------------------------------------
		$params['jabatan_id']     = $this->input->post('jabatan_id');
		$params['username']       = $this->input->post('username');
		$params['nama']           = $this->input->post('nama');
		if ($this->input->post('password') != null) {
			$params['password']       = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
		}
		$params['user_update_id']   = user_id();
		$params['updated']          = date('Y-m-d H:i:s');
		$this->db->where('user_id', $this->input->post('user_id'));
		$this->db->update('settings_user', $params);
		// ----------------------------------------------------------------------
		if ($this->db->affected_rows() > 0) {
			add_log(
				'<div>Mengubah data user :
                    <div><b>Sebelum</b></div>
                    <div><i>Username</i> : ' . $dataLama->username . '</div>
                    <div><i>Nama Lengkap</i> : ' . $dataLama->nama . ' </div>
                    <div><i>Jabatan</i> : ' . $dataLama->nama_jabatan . ' </div>

                    <div><b>Sesudah</b></div>
                    <div><i>Username</i> : ' . $this->input->post('username') . '</div>
                    <div><i>Nama Lengkap</i> : ' . $this->input->post('nama') . ' </div>
                    <div><i>Jabatan</i> : ' . $jabatanBaru->nama . ' </div>
                </div>'
			);
			return true;
		} else {
			return false;
		}
	}


	// --------------------------------------------------------------------
	// Delete Form
	// --------------------------------------------------------------------
	function delete_form__get()
	{
		$this->db->select('settings_user.user_id');
		$this->db->select('settings_user.jabatan_id');
		$this->db->select('settings_user.username');
		$this->db->select('settings_user.nama');
		$this->db->select('settings_user.aktif');
		$this->db->select('settings_jabatan.nama as nama_jabatan');
		$this->db->from('settings_user');
		$this->db->join('settings_jabatan', 'settings_jabatan.jabatan_id = settings_user.jabatan_id');
		$this->db->where('settings_user.user_id', $this->input->post('user_id'));
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
		$this->db->where('user_id', $this->input->post('user_id'));
		$this->db->update('settings_user', $params);
		// ----------------------------------------------------------------------
		if ($this->db->affected_rows() > 0) {
			add_log(
				'<div>Menghapus data user :
                    <div><i>Username</i> : ' . $dataLama->username . '</div>
                    <div><i>Nama Lengkap</i> : ' . $dataLama->nama . '</div>
                    <div><i>Jabatan</i> : ' . $dataLama->nama_jabatan . '</div>
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
		$this->db->select('settings_user.user_id');
		$this->db->select('settings_user.jabatan_id');
		$this->db->select('settings_user.username');
		$this->db->select('settings_user.nama');
		$this->db->select('settings_user.aktif');
		$this->db->select('settings_jabatan.nama as nama_jabatan');
		$this->db->from('settings_user');
		$this->db->join('settings_jabatan', 'settings_jabatan.jabatan_id = settings_user.jabatan_id');
		$this->db->where('settings_user.user_id', $id);
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
			$params['user_id']        = $row;
			$params['user_delete_id'] = user_id();
			$params['deleted']        = date('Y-m-d H:i:s');
			$dataDelete[] = $params;

			$dataLama = $this->delete_batch_form__get($row)->row();
			$logText = '<div>Menghapus data user :
                            <div><i>Username</i> : ' . $dataLama->username . '</div>
							<div><i>Nama Lengkap</i> : ' . $dataLama->nama . '</div>
							<div><i>Jabatan</i> : ' . $dataLama->nama_jabatan . '</div>
                        </div>';
			$log[] = $logText;
		}
		$this->db->update_batch('settings_user', $dataDelete, 'user_id');
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
	// Ganti Status Keaktifan Form
	// --------------------------------------------------------------------
	function ganti_status_keaktifan__get()
	{
		$this->db->select('settings_user.user_id');
		$this->db->select('settings_user.jabatan_id');
		$this->db->select('settings_user.username');
		$this->db->select('settings_user.nama');
		$this->db->select('settings_user.aktif');
		$this->db->select('settings_jabatan.nama as nama_jabatan');
		$this->db->from('settings_user');
		$this->db->join('settings_jabatan', 'settings_jabatan.jabatan_id = settings_user.jabatan_id');
		$this->db->where('settings_user.user_id', $this->input->post('user_id'));
		$query = $this->db->get();
		return $query;
	}

	function ganti_status_keaktifan__process()
	{
		date_default_timezone_set("Asia/Singapore");
		// ----------------------------------------------------------------------
		$dataLama = $this->ganti_status_keaktifan__get()->row();
		// ----------------------------------------------------------------------
		switch ($dataLama->aktif) {
			case 'true':
				$this->db->where('user_id', $this->input->post('user_id'));
				$this->db->update('settings_user', ['aktif' => 'false']);
				$log = '<div>Mengubah status user menjadi NONAKTIF :
							<div><i>Username</i> : ' . $dataLama->username . '</div>
							<div><i>Nama Lengkap</i> : ' . $dataLama->nama . '</div>
							<div><i>Jabatan</i> : ' . $dataLama->nama_jabatan . '</div>
						</div>';
				break;
			case 'false':
				$this->db->where('user_id', $this->input->post('user_id'));
				$this->db->update('settings_user', ['aktif' => 'true']);
				$log = '<div>Mengubah status user menjadi AKTIF :
							<div><i>Username</i> : ' . $dataLama->username . '</div>
							<div><i>Nama Lengkap</i> : ' . $dataLama->nama . '</div>
							<div><i>Jabatan</i> : ' . $dataLama->nama_jabatan . '</div>
						</div>';
				break;
		}
		// ----------------------------------------------------------------------
		if ($this->db->affected_rows() > 0) {
			add_log($log);
			return true;
		} else {
			return false;
		}
	}


	// --------------------------------------------------------------------
	// Ganti Status Keaktifan Batch Form
	// --------------------------------------------------------------------
	function ganti_status_keaktifan_batch__get($id)
	{
		$this->db->select('settings_user.user_id');
		$this->db->select('settings_user.jabatan_id');
		$this->db->select('settings_user.username');
		$this->db->select('settings_user.nama');
		$this->db->select('settings_user.aktif');
		$this->db->select('settings_jabatan.nama as nama_jabatan');
		$this->db->from('settings_user');
		$this->db->join('settings_jabatan', 'settings_jabatan.jabatan_id = settings_user.jabatan_id');
		$this->db->where('settings_user.user_id', $id);
		$query = $this->db->get();
		return $query;
	}

	function ganti_status_keaktifan_batch__process()
	{
		date_default_timezone_set('Asia/Singapore');
		$this->db->trans_begin();
		// ----------------------------------------------------------------------
		$log = [];
		$data = [];
		// ----------------------------------------------------------------------
		foreach ($this->input->post('id') as $row) {
			$dataLama = $this->ganti_status_keaktifan_batch__get($row)->row();
			switch ($dataLama->aktif) {
				case 'true':
					$params['user_id'] = $row;
					$params['aktif']   = 'false';
					$data[] = $params;
					$log[] = '<div>Mengubah status user menjadi NONAKTIF :
								<div><i>Username</i> : ' . $dataLama->username . '</div>
								<div><i>Nama Lengkap</i> : ' . $dataLama->nama . '</div>
								<div><i>Jabatan</i> : ' . $dataLama->nama_jabatan . '</div>
							</div>';
					break;
				case 'false':
					$params['user_id'] = $row;
					$params['aktif']   = 'true';
					$data[] = $params;
					$log[] = '<div>Mengubah status user menjadi AKTIF :
								<div><i>Username</i> : ' . $dataLama->username . '</div>
								<div><i>Nama Lengkap</i> : ' . $dataLama->nama . '</div>
								<div><i>Jabatan</i> : ' . $dataLama->nama_jabatan . '</div>
							</div>';
					break;
			}
		}
		$this->db->update_batch('settings_user', $data, 'user_id');
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
		$orderColumn  = [null, null, null, 'settings_user.username', 'settings_user.nama', 'settings_jabatan.nama', null];
		$searchColumn = [null, null, null, 'settings_user.username', 'settings_user.nama', 'settings_jabatan.nama', null];
		$order        = ['settings_user.user_id' => 'desc'];
		$row          = 0;

		$this->db->select('settings_user.user_id');
		$this->db->select('settings_user.jabatan_id');
		$this->db->select('settings_user.username');
		$this->db->select('settings_user.nama');
		$this->db->select('settings_user.aktif');
		$this->db->select('settings_jabatan.nama as nama_jabatan');
		$this->db->from('settings_user');
		$this->db->join('settings_jabatan', 'settings_jabatan.jabatan_id = settings_user.jabatan_id');
		$this->db->where('settings_user.deleted !=', null);
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
		$this->db->from('settings_user');
		return $this->db->count_all_results();
	}


	// --------------------------------------------------------------------
	// Restore Form
	// --------------------------------------------------------------------
	function restore_form__get()
	{
		$this->db->select('settings_user.user_id');
		$this->db->select('settings_user.jabatan_id');
		$this->db->select('settings_user.username');
		$this->db->select('settings_user.nama');
		$this->db->select('settings_user.aktif');
		$this->db->select('settings_jabatan.nama as nama_jabatan');
		$this->db->from('settings_user');
		$this->db->join('settings_jabatan', 'settings_jabatan.jabatan_id = settings_user.jabatan_id');
		$this->db->where('settings_user.user_id', $this->input->post('user_id'));
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
		$this->db->where('user_id', $this->input->post('user_id'));
		$this->db->update('settings_user', $params);
		// ----------------------------------------------------------------------
		if ($this->db->affected_rows() > 0) {
			add_log(
				'<div>Memulihkan data user yang sebelumnya terhapus :
                    <div><i>Username</i> : ' . $dataLama->username . '</div>
					<div><i>Nama Lengkap</i> : ' . $dataLama->nama . '</div>
					<div><i>Jabatan</i> : ' . $dataLama->nama_jabatan . '</div>
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
		$this->db->select('settings_user.user_id');
		$this->db->select('settings_user.jabatan_id');
		$this->db->select('settings_user.username');
		$this->db->select('settings_user.nama');
		$this->db->select('settings_user.aktif');
		$this->db->select('settings_jabatan.nama as nama_jabatan');
		$this->db->from('settings_user');
		$this->db->join('settings_jabatan', 'settings_jabatan.jabatan_id = settings_user.jabatan_id');
		$this->db->where('settings_user.user_id', $id);
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
			$params['user_id']         = $row;
			$params['user_restore_id'] = user_id();
			$params['restored']        = date('Y-m-d H:i:s');
			$params['user_delete_id']  = null;
			$params['deleted']         = null;
			$dataRestore[] = $params;

			$dataLama = $this->restore_batch_form__get($row)->row();
			$logText = '<div>Memulihkan data user yang sebelumnya terhapus :
                            <div><i>Username</i> : ' . $dataLama->username . '</div>
							<div><i>Nama Lengkap</i> : ' . $dataLama->nama . '</div>
							<div><i>Jabatan</i> : ' . $dataLama->nama_jabatan . '</div>
                        </div>';
			$log[] = $logText;
		}
		$this->db->update_batch('settings_user', $dataRestore, 'user_id');
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
		$this->db->select('settings_user.user_id');
		$this->db->select('settings_user.jabatan_id');
		$this->db->select('settings_user.username');
		$this->db->select('settings_user.nama');
		$this->db->select('settings_user.aktif');
		$this->db->select('settings_jabatan.nama as nama_jabatan');
		$this->db->from('settings_user');
		$this->db->join('settings_jabatan', 'settings_jabatan.jabatan_id = settings_user.jabatan_id');
		$this->db->where('settings_user.user_id', $this->input->post('user_id'));
		$query = $this->db->get();
		return $query;
	}

	function destroy_form__process()
	{
		date_default_timezone_set("Asia/Singapore");
		// ----------------------------------------------------------------------
		$dataLama = $this->destroy_form__get()->row();
		// ----------------------------------------------------------------------
		$this->db->where('user_id', $this->input->post('user_id'));
		$this->db->delete('settings_user');
		// ----------------------------------------------------------------------
		if ($this->db->affected_rows() > 0) {
			add_log(
				'<div>Menghancurkan data user yang sebelumnya terhapus :
                    <div><i>Username</i> : ' . $dataLama->username . '</div>
					<div><i>Nama Lengkap</i> : ' . $dataLama->nama . '</div>
					<div><i>Jabatan</i> : ' . $dataLama->nama_jabatan . '</div>
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
		$this->db->select('settings_user.user_id');
		$this->db->select('settings_user.jabatan_id');
		$this->db->select('settings_user.username');
		$this->db->select('settings_user.nama');
		$this->db->select('settings_user.aktif');
		$this->db->select('settings_jabatan.nama as nama_jabatan');
		$this->db->from('settings_user');
		$this->db->join('settings_jabatan', 'settings_jabatan.jabatan_id = settings_user.jabatan_id');
		$this->db->where('settings_user.user_id', $id);
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
			$logText = '<div>Menghancurkan data user yang sebelumnya terhapus :
                            <div><i>Username</i> : ' . $dataLama->username . '</div>
							<div><i>Nama Lengkap</i> : ' . $dataLama->nama . '</div>
							<div><i>Jabatan</i> : ' . $dataLama->nama_jabatan . '</div>
                        </div>';
			$log[] = $logText;
		}
		$this->db->where_in('user_id', $this->input->post('id'));
		$this->db->delete('settings_user');
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
	// Fungsi Umum
	// --------------------------------------------------------------------
	function fungsi_umum__load_select_jabatan($search = '')
	{
		$this->db->from('settings_jabatan');
		$this->db->like('nama', $search);
		$query = $this->db->get();
		$result = [];
		foreach ($query->result() as $row) {
			$sub['id']   = $row->jabatan_id;
			$sub['text'] = $row->nama;
			$result[] = $sub;
		}
		return $result;
	}

	function fungsi_umum__check_username()
	{
		$this->db->from('settings_user');
		$this->db->where('username', $this->input->post('username'));
		$this->db->where('user_id !=', $this->input->post('user_id'));
		$query = $this->db->get();
		return $query->num_rows();
	}
}
