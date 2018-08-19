<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile_info_model extends CI_Model {

	public function get_std_profile($profile_id)
	{
		$this->db->where('st_roll_no',$profile_id);
		$q=$this->db->get('student_profile');
		if($q->num_rows() > 0)
		{
      return $q->row();
    }
	}

	public function get_active_course($semester_id){
		
	}

}

/* End of file profile_info_model.php */
/* Location: ./application/modules/pages/models/profile_info_model.php */