<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Find_model extends CI_Model {

	public function find_student($option,$key)
	{
		$this->db->select('sp.*,s.section_name');
		$this->db->join('section s', 's.section_id = sp.section_id');
		$this->db->like($option, $key);
		$this->db->group_by('sp.st_id');
		$this->db->order_by('sp.st_id', 'desc');
		$this->db->where('sp.status', 'studying');
		$this->db->where('pu_scholar !=', '1');
		$q=$this->db->get('student_profile sp');
		if($q->num_rows() > 0)
		{
			foreach ($q->result() as $row) 
			{
				$data[] = $row;
			}
			return $data;
		}
		return NULL;
	}

}

/* End of file find_model.php */
/* Location: ./application/modules/pages/models/find_model.php */