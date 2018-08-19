<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_log_model extends CI_Model {

	public function log_user($data=''){
    $otherdb = $this->load->database('user_log', TRUE);
    $otherdb->insert('user_log',$data);//$q = $otherdb->get('batch');
	}
	
	

}

/* End of file user_log.php */
/* Location: ./application/modules/dashboard/models/user_log.php */