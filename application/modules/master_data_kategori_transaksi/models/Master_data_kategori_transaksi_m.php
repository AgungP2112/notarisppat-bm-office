<?php defined('BASEPATH') or exit('No direct script access allowed');

class Master_data_kategori_transaksi_m extends CI_Model
{
	// --------------------------------------------------------------------
	// Main Datatable
	// --------------------------------------------------------------------
	function datatable_main__query()
	{
		$orderColumn  = [null, null, null, "nama", "tampilkan_dalam_rekap"];
		$searchColumn = [null, null, null, "nama", "tampilkan_dalam_rekap"];
		$order        = ["kategori_transaksi_id" => "desc"];
		$row          = 0;

		$this->db->from('master_kategori_transaksi');
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
		$this->db->from('master_kategori_transaksi');
		return $this->db->count_all_results();
	}


	// --------------------------------------------------------------------
	// Add Form
	// --------------------------------------------------------------------
	function add_form__process()
	{
		date_default_timezone_set("Asia/Singapore");
		// ----------------------------------------------------------------------
		$params['nama']                  = $this->input->post('nama');
		$params['tampilkan_dalam_rekap'] = $this->input->post('tampilkan_dalam_rekap');
		$params['user_create_id']        = user_id();
		$params['created']               = date('Y-m-d H:i:s');
		$this->db->insert('master_kategori_transaksi', $params);
		// ----------------------------------------------------------------------
		if ($this->db->affected_rows() > 0) {
			add_log(
				'<div>Menginput data kategori transaksi baru : <br>
                    <div><i>Nama</i> : ' . $this->input->post('nama') . '</div>
                    <div><i>Tampilkan dalam rekap</i> : ' . $this->input->post('tampilkan_dalam_rekap') . '</div>
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
		$this->db->from('master_kategori_transaksi');
		$this->db->where('kategori_transaksi_id', $this->input->post('kategori_transaksi_id'));
		$query = $this->db->get();
		return $query;
	}

	function edit_form__process()
	{
		date_default_timezone_set("Asia/Singapore");
		// ----------------------------------------------------------------------
		$dataLama    = $this->edit_form__get()->row();
		// ----------------------------------------------------------------------
		$params['nama']                  = $this->input->post('nama');
		$params['tampilkan_dalam_rekap'] = $this->input->post('tampilkan_dalam_rekap');
		$params['user_update_id']        = user_id();
		$params['updated']               = date('Y-m-d H:i:s');
		$this->db->where('kategori_transaksi_id', $this->input->post('kategori_transaksi_id'));
		$this->db->update('master_kategori_transaksi', $params);
		// ----------------------------------------------------------------------
		if ($this->db->affected_rows() > 0) {
			add_log(
				'<div>Mengubah data kategori transaksi :
                    <div><b>Sebelum</b></div>
					<div><i>Nama</i> : ' . $dataLama->nama . '</div>
					<div><i>Tampilkan dalam rekap</i> : ' . $dataLama->tampilkan_dalam_rekap . '</div>

                    <div><b>Sesudah</b></div>
                    <div><i>Nama</i> : ' . $this->input->post('nama') . '</div>
                    <div><i>Tampilkan dalam rekap</i> : ' . $this->input->post('tampilkan_dalam_rekap') . '</div>
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
		$this->db->from('master_kategori_transaksi');
		$this->db->where('kategori_transaksi_id', $this->input->post('kategori_transaksi_id'));
		$query = $this->db->get();
		return $query;
	}

	function delete_form__process()
	{
		date_default_timezone_set("Asia/Singapore");
		// ----------------------------------------------------------------------
		$dataLama = $this->delete_form__get()->row();
		// ----------------------------------------------------------------------
		$params['user_delete_id'] = user_id();
		$params['deleted']        = date('Y-m-d H:i:s');
		$this->db->where('kategori_transaksi_id', $this->input->post('kategori_transaksi_id'));
		$this->db->update('master_kategori_transaksi', $params);
		// ----------------------------------------------------------------------
		if ($this->db->affected_rows() > 0) {
			add_log(
				'<div>Menghapus data kategori transaksi :
                    <div><i>Nama</i> : ' . $dataLama->nama . '</div>
                    <div><i>Tampilkan dalam rekap</i> : ' . $dataLama->tampilkan_dalam_rekap . '</div>
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
		$this->db->from('master_kategori_transaksi');
		$this->db->where('kategori_transaksi_id', $id);
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
			$params['kategori_transaksi_id'] = $row;
			$params['user_delete_id']        = user_id();
			$params['deleted']               = date('Y-m-d H:i:s');
			$dataDelete[] = $params;

			$dataLama = $this->delete_batch_form__get($row)->row();
			$logText = '<div>Menghapus data kategori transaksi :
							<div><i>Nama</i> : ' . $dataLama->nama . '</div>
							<div><i>Tampilkan dalam rekap</i> : ' . $dataLama->tampilkan_dalam_rekap . '</div>
						</div>';
			$log[] = $logText;
		}
		$this->db->update_batch('master_kategori_transaksi', $dataDelete, 'kategori_transaksi_id');
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
		$orderColumn  = [null, null, null, "nama"];
		$searchColumn = [null, null, null, "nama"];
		$order        = ["kategori_transaksi_id" => "desc"];
		$row          = 0;

		$this->db->from('master_kategori_transaksi');
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
		$this->db->from('master_kategori_transaksi');
		return $this->db->count_all_results();
	}


	// --------------------------------------------------------------------
	// Restore Form
	// --------------------------------------------------------------------
	function restore_form__get()
	{
		$this->db->from('master_kategori_transaksi');
		$this->db->where('kategori_transaksi_id', $this->input->post('kategori_transaksi_id'));
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
		$this->db->where('kategori_transaksi_id', $this->input->post('kategori_transaksi_id'));
		$this->db->update('master_kategori_transaksi', $params);
		// ----------------------------------------------------------------------
		if ($this->db->affected_rows() > 0) {
			add_log(
				'<div>Memulihkan data kategori transaksi yang sebelumnya terhapus :
                    <div><i>Nama</i> : ' . $dataLama->nama . '</div>
					<div><i>Tampilkan dalam rekap</i> : ' . $dataLama->tampilkan_dalam_rekap . '</div>
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
		$this->db->from('master_kategori_transaksi');
		$this->db->where('kategori_transaksi_id', $id);
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
			$params['kategori_transaksi_id'] = $row;
			$params['user_restore_id']     = user_id();
			$params['restored']            = date('Y-m-d H:i:s');
			$params['user_delete_id']      = null;
			$params['deleted']             = null;
			$dataRestore[] = $params;

			$dataLama = $this->restore_batch_form__get($row)->row();
			$logText = '<div>Memulihkan data kategori transaksi yang sebelumnya terhapus :
							<div><i>Nama</i> : ' . $dataLama->nama . '</div>
							<div><i>Tampilkan dalam rekap</i> : ' . $dataLama->tampilkan_dalam_rekap . '</div>
						</div>';
			$log[] = $logText;
		}
		$this->db->update_batch('master_kategori_transaksi', $dataRestore, 'kategori_transaksi_id');
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
		$this->db->from('master_kategori_transaksi');
		$this->db->where('kategori_transaksi_id', $this->input->post('kategori_transaksi_id'));
		$query = $this->db->get();
		return $query;
	}

	function destroy_form__process()
	{
		date_default_timezone_set("Asia/Singapore");
		// ----------------------------------------------------------------------
		$dataLama = $this->destroy_form__get()->row();
		// ----------------------------------------------------------------------
		$this->db->where('kategori_transaksi_id', $this->input->post('kategori_transaksi_id'));
		$this->db->delete('master_kategori_transaksi');
		// ----------------------------------------------------------------------
		if ($this->db->affected_rows() > 0) {
			add_log(
				'<div>Menghancurkan data kategori transaksi yang sebelumnya terhapus :
                    <div><i>Nama</i> : ' . $dataLama->nama . '</div>
					<div><i>Tampilkan dalam rekap</i> : ' . $dataLama->tampilkan_dalam_rekap . '</div>
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
		$this->db->from('master_kategori_transaksi');
		$this->db->where('kategori_transaksi_id', $id);
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
			$logText = '<div>Menghancurkan data kategori transaksi yang sebelumnya terhapus :
                            <div><i>Nama</i> : ' . $dataLama->nama . '</div>
							<div><i>Tampilkan dalam rekap</i> : ' . $dataLama->tampilkan_dalam_rekap . '</div>
                        </div>';
			$log[] = $logText;
		}
		$this->db->where_in('kategori_transaksi_id', $this->input->post('id'));
		$this->db->delete('master_kategori_transaksi');
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
