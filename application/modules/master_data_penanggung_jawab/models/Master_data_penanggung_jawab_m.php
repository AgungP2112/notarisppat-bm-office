<?php defined('BASEPATH') or exit('No direct script access allowed');

class Master_data_penanggung_jawab_m extends CI_Model
{
	// --------------------------------------------------------------------
	// Main Datatable
	// --------------------------------------------------------------------
	function datatable_main__query()
	{
		$orderColumn  = [null, null, null, "nama"];
		$searchColumn = [null, null, null, "nama"];
		$order        = ["penanggung_jawab_id" => "desc"];

		$a = 0;

		$this->db->from('master_penanggung_jawab');
		$this->db->where('deleted', null);
		foreach ($searchColumn as $item) {
			if ($item != null && $_POST['columns'][$a]['search']['value']) {
				$this->db->like($item, $_POST['columns'][$a]['search']['value']);
			}
			$a++;
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
		$this->db->from('master_penanggung_jawab');
		return $this->db->count_all_results();
	}


	// --------------------------------------------------------------------
	// Add Form
	// --------------------------------------------------------------------
	function add_form__process()
	{
		date_default_timezone_set("Asia/Singapore");
		// ----------------------------------------------------------------------
		$params['nama']           = $this->input->post('nama');
		$params['user_create_id'] = user_id();
		$params['created']        = date('Y-m-d H:i:s');
		$this->db->insert('master_penanggung_jawab', $params);
		// ----------------------------------------------------------------------
		if ($this->db->affected_rows() > 0) {
			add_log(
				'<div>Menginput data penanggung jawab baru : <br>
                    <div><i>Nama</i> : ' . $this->input->post('nama') . '</div>
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
		$this->db->from('master_penanggung_jawab');
		$this->db->where('penanggung_jawab_id', $this->input->post('penanggung_jawab_id'));
		$query = $this->db->get();
		return $query;
	}

	function edit_form__process()
	{
		date_default_timezone_set("Asia/Singapore");
		// ----------------------------------------------------------------------
		$dataLama    = $this->edit_form__get()->row();
		// ----------------------------------------------------------------------
		$params['nama']           = $this->input->post('nama');
		$params['user_update_id'] = user_id();
		$params['updated']        = date('Y-m-d H:i:s');
		$this->db->where('penanggung_jawab_id', $this->input->post('penanggung_jawab_id'));
		$this->db->update('master_penanggung_jawab', $params);
		// ----------------------------------------------------------------------
		if ($this->db->affected_rows() > 0) {
			add_log(
				'<div>Mengubah data penanggung jawab :
                    <div><b>Sebelum</b></div>
					<div><i>Nama</i> : ' . $dataLama->nama . '</div>

                    <div><b>Sesudah</b></div>
                    <div><i>Nama</i> : ' . $this->input->post('nama') . '</div>
                </div>'
			);
			return true;
		} else {
			return false;
		}
	}


	// --------------------------------------------------------------------
	// Edit Batch Form
	// --------------------------------------------------------------------
	function edit_batch_form__get($id)
	{
		$this->db->from('master_penanggung_jawab');
		$this->db->where('penanggung_jawab_id', $id);
		$query = $this->db->get();
		return $query;
	}

	function edit_batch_form__get_batch($id)
	{
		$this->db->from('master_penanggung_jawab');
		$this->db->where_in('penanggung_jawab_id', $id);
		$query = $this->db->get();
		return $query;
	}

	function edit_batch_form__process()
	{
		date_default_timezone_set("Asia/Singapore");
		$this->db->trans_begin();
		$id = $this->input->post('penanggung_jawab_id');
		$idArr = explode(',', $id);
		// --------------------------------------------------------------------------------------------------
		$count = 1;
		$textBefore = '<div>';
		foreach ($idArr as $row) {
			$dataLama = $this->edit_batch_form__get($row)->row();
			$textBefore .= '<div>
								<i>No.</i> : ' . $count . ' <br>
								<i>Nama</i> : ' . $dataLama->nama . ' <br>
							</div>';
			$count++;
		}
		$textBefore .= '</div>';
		// --------------------------------------------------------------------------------------------------
		$textAfter = '<div>';
		$textAfter .= '<i>Nama</i> : ' . $this->input->post('nama') . '<br>';
		$textAfter .= '</div>';
		$params['nama'] = $this->input->post('nama');
		$this->db->where_in('penanggung_jawab_id', $idArr);
		$this->db->update('master_penanggung_jawab', $params);
		// ----------------------------------------------------------------------------------------------------------------------------------
		$this->db->trans_complete();
		if ($this->db->trans_status() === true) {
			$this->db->trans_commit();
			add_log(
				'<div>Mengubah batch data penanggung jawab : <br>
					<b>Sebelum</b>' . $textBefore . '
					<br>
					<b>Sesudah</b>' . $textAfter . '
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
		$this->db->from('master_penanggung_jawab');
		$this->db->where('penanggung_jawab_id', $this->input->post('penanggung_jawab_id'));
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
		$this->db->where('penanggung_jawab_id', $this->input->post('penanggung_jawab_id'));
		$this->db->update('master_penanggung_jawab', $params);
		// ----------------------------------------------------------------------
		if ($this->db->affected_rows() > 0) {
			add_log(
				'<div>Menghapus data penanggung jawab :
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
		$this->db->from('master_penanggung_jawab');
		$this->db->where('penanggung_jawab_id', $id);
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
			$params['penanggung_jawab_id'] = $row;
			$params['user_delete_id']      = user_id();
			$params['deleted']             = date('Y-m-d H:i:s');
			$dataDelete[] = $params;

			$dataLama = $this->delete_batch_form__get($row)->row();
			$logText = '<div>Menghapus data penanggung jawab :
							<div><i>Nama</i> : ' . $dataLama->nama . '</div>
						</div>';
			$log[] = $logText;
		}
		$this->db->update_batch('master_penanggung_jawab', $dataDelete, 'penanggung_jawab_id');
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
		$order        = ["penanggung_jawab_id" => "desc"];

		$a = 0;

		$this->db->from('master_penanggung_jawab');
		$this->db->where('deleted !=', null);
		foreach ($searchColumn as $item) {
			if ($item != null && $_POST['columns'][$a]['search']['value']) {
				$this->db->like($item, $_POST['columns'][$a]['search']['value']);
			}
			$a++;
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
		$this->db->from('master_penanggung_jawab');
		return $this->db->count_all_results();
	}


	// --------------------------------------------------------------------
	// Restore Form
	// --------------------------------------------------------------------
	function restore_form__get()
	{
		$this->db->from('master_penanggung_jawab');
		$this->db->where('penanggung_jawab_id', $this->input->post('penanggung_jawab_id'));
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
		$this->db->where('penanggung_jawab_id', $this->input->post('penanggung_jawab_id'));
		$this->db->update('master_penanggung_jawab', $params);
		// ----------------------------------------------------------------------
		if ($this->db->affected_rows() > 0) {
			add_log(
				'<div>Memulihkan data penanggung jawab yang sebelumnya terhapus :
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
		$this->db->from('master_penanggung_jawab');
		$this->db->where('penanggung_jawab_id', $id);
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
			$params['penanggung_jawab_id'] = $row;
			$params['user_restore_id']     = user_id();
			$params['restored']            = date('Y-m-d H:i:s');
			$params['user_delete_id']      = null;
			$params['deleted']             = null;
			$dataRestore[] = $params;

			$dataLama = $this->restore_batch_form__get($row)->row();
			$logText = '<div>Memulihkan data penanggung jawab yang sebelumnya terhapus :
							<div><i>Nama</i> : ' . $dataLama->nama . '</div>
						</div>';
			$log[] = $logText;
		}
		$this->db->update_batch('master_penanggung_jawab', $dataRestore, 'penanggung_jawab_id');
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
		$this->db->from('master_penanggung_jawab');
		$this->db->where('penanggung_jawab_id', $this->input->post('penanggung_jawab_id'));
		$query = $this->db->get();
		return $query;
	}

	function destroy_form__process()
	{
		date_default_timezone_set("Asia/Singapore");
		// ----------------------------------------------------------------------
		$dataLama = $this->destroy_form__get()->row();
		// ----------------------------------------------------------------------
		$this->db->where('penanggung_jawab_id', $this->input->post('penanggung_jawab_id'));
		$this->db->delete('master_penanggung_jawab');
		// ----------------------------------------------------------------------
		if ($this->db->affected_rows() > 0) {
			add_log(
				'<div>Menghancurkan data penanggung jawab yang sebelumnya terhapus :
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
		$this->db->from('master_penanggung_jawab');
		$this->db->where('penanggung_jawab_id', $id);
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
			$logText = '<div>Menghancurkan data penanggung jawab yang sebelumnya terhapus :
                            <div><i>Nama</i> : ' . $dataLama->nama . '</div>
                        </div>';
			$log[] = $logText;
		}
		$this->db->where_in('penanggung_jawab_id', $this->input->post('id'));
		$this->db->delete('master_penanggung_jawab');
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
