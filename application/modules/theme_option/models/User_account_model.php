<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_account_model extends CI_Model {

	public function get_users()
	{
		$q=$this->db->get('users');
		if($q->num_rows() > 0){
			foreach ($q->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return NULL;
	}

	public function user_info($uid='')
	{
		$this->db->where('USER_ID', $uid);
		$q=$this->db->get('users');
		if($q->num_rows() > 0)
		{
			return $q->row();
		}
		return NULL;
	}

	public function update($uid)
	{
		$data['USER_NAME']=$this->input->post('user_name');
		if($this->input->post('change_password')==1)
		{
			$data['USER_PASSWORD']=MD5(sha1($this->input->post('new_pass')));
		}
		$data['ACC_STATUS']=$this->input->post('acc_status');
		$data['ROLE_ID']=$this->input->post('user_type');
		$data['PROFILE_ID']=$this->input->post('profile_id');
		$this->db->where('USER_ID', $uid);
		return $this->db->update('users', $data);
	}

	public function insert_user()
	{
		$data['FNAME']=$this->input->post('fname');
		$data['LNAME']=$this->input->post('lname');
		$data['USER_NAME']=$this->input->post('username');
		$data['USER_PASSWORD']=MD5(sha1($this->input->post('password')));
		$data['ACC_STATUS']=$this->input->post('status');
		$data['PROFILE_ID']=$this->input->post('profile_id');
		$data['ROLE_ID']=$this->input->post('usertype');
		return $this->db->insert('users', $data);
	}

	public function delete($uid)
	{
		$this->db->where('USER_ID', $uid);
		return $this->db->delete('users');
	}

	public function get_block_list($value='')
	{
		if($this->session->userdata('smis_role') !='su_admin')
		{
			$this->db->where('user_id', $this->session->userdata('smis_username'));
		}
		$q=$this->db->get('blocked_ip');

		if($q->num_rows() > 0){
			foreach ($q->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
	}

	public function allow_ip($id)
	{
		$this->db->where('id', $id);
		if($this->session->userdata('smis_role') !='su_admin')
		{
			$this->db->where('user_id', $this->session->userdata('smis_username'));
		}
		return $this->db->delete('blocked_ip');
	}

	public function add_student($mis_integrate = '',$con_stat = '')
	{
		//print_e($_POST);
		$data['st_roll_no'] = $this->input->post('roll_no');
		$data['st_fname'] = $this->input->post('fname');
		$data['st_mname'] = $this->input->post('mname');
		$data['st_lname'] = $this->input->post('lname');
		$data['st_sex'] = $this->input->post('sex');
		$data['programlevel_id'] = $this->input->post('programlevel_id');
		$data['program_id'] = $this->input->post('program_id');
		$data['batch_id'] = $this->input->post('batch_id');
		$data['section_id'] = $this->input->post('section_id');
		$mis_db = $this->load->database('mis', TRUE);
		$q = $mis_db->insert('student_profile',$data);

		if($q)
		{
			$insert_id = $mis_db->insert_id();
		 	//replication record to  finance server
	    if($mis_integrate == TRUE && $con_stat == TRUE)
	    {   
        $data['st_id'] = $insert_id;
        $q = $this->db->insert('student_profile',$data);
	    }
		}
    return $q;
	}

	public function check_account($profile_id)
	{
		$this->db->where('PROFILE_ID', $profile_id);
		$query = $this->db->get('users');
		if($query->num_rows() > 0)
			return $query->row();
		return NULL;
	}
}

/* End of file user_account_model.php */
/* Location: ./application/modules/pages/models/user_account_model.php */