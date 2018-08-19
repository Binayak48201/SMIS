<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Department_manager_model extends CI_Model {

	public function get_department()
	{
		$this->db->order_by('department_name');
		$q=$this->db->get('department');
		if($q->num_rows() > 0){
			foreach ($q->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return NULL;
	}

	public function add()
	{
		$data['department_name']=trim_post('department');
		return $this->db->insert('department',$data);
	}
	
	public function update($id)
	{
		$data['department_name']=trim_post('department');
		$this->db->where('dept_id', $id);
		return $this->db->update('department',$data);
	}

	public function delete($id)
	{
		$this->db->where('dept_id',$id);
		return $this->db->delete('department');
	}

}

/* End of file district_model.php */
/* Location: ./application/modules/pages/models/student_info/district_model.php */