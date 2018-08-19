<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Grade_manager_model extends CI_Model {

	public function get_grades()
	{
		$this->db->order_by('grade_order');
		$result = $this->db->get('grade');
		if($result->num_rows() > 0)
		{
			foreach ($result->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return NULL;
	}

	public function latest_grade_order()
	{
		$this->db->select('MAX(grade_order) as grade_order');
		$result = $this->db->get('grade');
		return $result->row()->grade_order;
	}

	public function add()
	{
		$data['grade_order'] = $this->latest_grade_order()+1;
		$data['grade_name'] = trim_post('grade_name');
		return $this->db->insert('grade', $data);
	}

	public function update()
	{
		$grade_id = trim_post('id');
		$data['grade_name'] = trim_post('grade_name');
		$this->db->where('grade_id', $grade_id);
		return $this->db->update('grade', $data);
	}

	public function delete($id)
	{
		$this->db->where('grade_id', $id);
		return $this->db->delete('grade');
	}

}

/* End of file grade_manager.php */
/* Location: ./application/modules/pages/models/classes/grade_manager.php */