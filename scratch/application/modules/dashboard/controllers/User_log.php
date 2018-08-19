<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class User_log extends Mx_Controller {

	public function log()
	{
		//echo $this->db->last_query();
	//exit();	//echo $this->session->userdata('user_id');
		$this->load->model('dashboard/user_log_model');
		$fname='log_'.date('Y-m-d').'.txt';
		$uri=$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		$address=$this->input->ip_address();
		$log= date('Y-m-d h:i:sa');
		$user= $this->session->userdata("smis_username");
		$data = "$log $address $user $uri " . PHP_EOL;
		$fp = fopen('./user_log/'.$fname, 'a');
		//fwrite($fp, $data);
		$logs['uri']=$uri;
		$logs['ip_address']=$address;
		$logs['log_date']=$log;
		$logs['username']=$user;

		//$data = 'Some file data';
		if ( ! fwrite($fp, $data))
		{
		  echo '<script>console.log("log failed"); </script>';
		}
		else
		{
			if($logs['username']!=NULL)
			{
					$this->user_log_model->log_user($logs);
			}
		       // echo 'File written!';
		}
	}

}

/* End of file user_log.php */
/* Location: ./application/modules/dashboard/controllers/user_log.php */