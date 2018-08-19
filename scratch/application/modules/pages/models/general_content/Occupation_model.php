<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Occupation_model extends CI_Model {

	public function get_occupation()
	{
		$q=$this->db->get('occupation');
		
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
		$data['occupation_name']= trim_post('occupation');
		return $this->db->insert('occupation',$data);
	}
	
	public function update()
	{
		$data['occupation_name']= trim_post('occupation');
		$this->db->where('occupation_id', trim_post('id'));
		return $this->db->update('occupation',$data);
	}

	public function delete($id)
	{
		$this->db->where('occupation_id',$id);
		return $this->db->delete('occupation');
	}

}

/* End of file district_model.php */
/* Location: ./application/modules/pages/models/student_info/district_model.php */