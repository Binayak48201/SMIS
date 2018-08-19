<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manage_role_model extends CI_Model {

public function get_role()
	{
		$q=$this->db->get('roles');
		
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
		$data['ROLE_NAME'] = $this->input->post('usertype');
		return $this->db->insert('roles',$data);
	}
	
	public function update()
	{
		$data['ROLE_NAME'] = $this->input->post('usertype');
		$this->db->where('ROLE_ID',$this->input->post('id'));
		return $this->db->update('roles',$data);
	}
}

/* End of file manage_role_model.php */
/* Location: ./application/modules/pages/models/manage_role_model.php */