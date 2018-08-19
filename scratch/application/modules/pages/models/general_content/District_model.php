<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class District_model extends CI_Model {

	public function get_district()
	{
		$this->db->order_by('state, district_name');
		$q=$this->db->get('district');
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
		$data['district_name']=strtoupper(trim_post('district'));
		$data['zone_name']=strtoupper(trim_post('zone'));
		$data['region_name']=strtoupper(trim_post('region'));
		$data['state']=strtoupper(trim_post('state'));
		return $this->db->insert('district',$data);
	}
	
	public function update()
	{
		$data['district_name']=strtoupper(trim_post('district'));
		$data['zone_name']=strtoupper(trim_post('zone'));
		$data['region_name']=strtoupper(trim_post('region'));
		$data['state']=strtoupper(trim_post('state'));
		$this->db->where('district_id',$this->input->post('id'));
		return $this->db->update('district',$data);
	}

	public function delete($id)
	{
		$this->db->where('district_id',$id);
		return $this->db->delete('district');
	}

}

/* End of file district_model.php */
/* Location: ./application/modules/pages/models/student_info/district_model.php */