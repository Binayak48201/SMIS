<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Theme_model extends CI_Model {

	function get_theme_data()
	{
		$q=$this->db->get('theme_option');
		
		if($q->num_rows() > 0){
			//foreach ($q->result() as $row) {
				//$data[] = $row;
			//}
			return $q->row();
		}
		return NULL;
	}

	public function set_theme()
	{
		$data['theme']=$this->input->post('option');
		$this->db->where('id',1);
		$this->db->update('theme_option',$data);
	}

	public function update_info($logo='')
	{ 
		if($logo!='')
		{			
			$data['logo']=$logo;
		}
		$data['title'] = trim_post('title');
		$data['email'] = trim_post('email');
		$data['fax'] = trim_post('fax');
		$data['address'] = trim_post('address');
		$data['pbo'] = trim_post('pbo');
		$data['tel'] = trim_post('tel');
		$data['final_upscale_marking'] = trim_post('final_upscale_marking');
		$data['assessment_module'] = trim_post('assessment_module');
		$data['marksheet_post'] = trim_post('marksheet_post');
		$data['marksheet_post_name'] = trim_post('marksheet_post_name');
		$data['marksheet_restrict'] = trim_post('marksheet_restrict');
		$this->db->where('id',1);
		return $this->db->update('theme_option',$data);
	}

}

/* End of file theme_model.php */
/* Location: ./application/modules/pages/models/theme_model.php */