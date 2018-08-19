<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class House_manager_model extends CI_Model {

	public function get_house()
	{
		$this->db->order_by('house_name','desc');
		$q=$this->db->get('house');
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
		$data['house_name']=trim_post('house_name');
		$data['house_color']=trim_post('house_color');
		return $this->db->insert('house',$data);
	}
	
	public function update()
	{
		$data['house_name']=trim_post('house_name');
		$data['house_color']=trim_post('house_color');
		$this->db->where('house_id',trim_post('id'));
		return $this->db->update('house',$data);
	}

	public function delete($id)
	{
		$this->db->where('house_id',$id);
		return $this->db->delete('house');
	}

}

/* End of file house_manager_model.php */
/* Location: ./application/modules/pages/models/classes/house_manager_model.php */