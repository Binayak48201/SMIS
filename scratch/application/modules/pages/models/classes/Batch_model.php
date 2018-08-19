<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Batch_model extends CI_Model {

	public function get_batch()
	{
		$this->db->order_by('batch_name','desc');
		$q=$this->db->get('batch');
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
		$data['batch_name']=strtoupper(trim_post('batch'));
		return $this->db->insert('batch',$data);
	}
	
	public function update()
	{
		$data['batch_name']=strtoupper(trim_post('batch'));
		$this->db->where('batch_id',trim_post('id'));
		return $this->db->update('batch',$data);
	}

	public function delete($id)
	{
		$this->db->where('batch_id',$id);
		return $this->db->delete('batch');
	}

}

/* End of file batch_model.php */
/* Location: ./application/modules/pages/models/classes/batch_model.php */