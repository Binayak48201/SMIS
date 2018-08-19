<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Club_manager_model extends CI_Model {

	public function get_club_type()
	{

		$result = $this->db->get('club_type');
		if($result->num_rows() > 0)
		{
			foreach ($result->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return NULL;
	}

	public function add_type()
	{
		$data['club_type'] = trim_post('club_type');
		return $this->db->insert('club_type', $data);
	}

	public function delete_type($id)
	{
		$this->db->where('id', $id);
		return $this->db->delete('club_type');
	}
	
	public function add_club()
	{
		$data['club_name'] = trim_post('club');
		$data['club_type'] = trim_post('club_type');
		return $this->db->insert('clubs', $data);
	}

	public function update_club($id)
	{
		$data['club_name'] = trim_post('club');
		$this->db->where('club_id', $id);
		return $this->db->update('clubs', $data);
	}

	public function delete_club($id)
	{
		$this->db->where('club_id', $id);
		return $this->db->delete('clubs');
	}

	public function get_club_by_type($club_type)
	{
		$this->db->order_by('club_name', 'Asc');
		$this->db->where('club_type', $club_type);
		$result = $this->db->get('clubs');
		if($result->num_rows() > 0)
		{
			foreach ($result->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return NULL;
	}
}

/* End of file appraisal_manager_model.php */
/* Location: ./application/modules/pages/models/classes/appraisal_manager_model.php */