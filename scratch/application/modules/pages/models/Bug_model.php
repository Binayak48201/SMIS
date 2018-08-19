<?php
 defined('BASEPATH') OR exit('No direct script access allowed');
 
 class Bug_model extends CI_Model {
 
	 public function insert_bug($file='')
	 {
	 		$data['bug_title']=$this->input->post('bug_title');
	 		$data['bug_description 	']=$this->input->post('bug_description');
	 		$data['bug_img']=$file;
	 		$data['report_id']=$this->session->userdata('smis_profile_id');
	 		$data['report_role']=$this->session->userdata('smis_role');
	 		$data['status']='Pending';
	 		return $this->db->insert('bug',$data);
	 }	

	 public function list_bug($user_id='')
	 {

	 		$this->db->select('b.*, concat(e.first_name," ",e.middle_name," ",e.last_name) as emp_fullname, concat(sp.st_fname," ",sp.st_mname," ",sp.st_lname) as st_fullname');
	 		$this->db->join('employee e', 'e.employee_id = b.report_id', 'left');
	 		$this->db->join('student_profile sp', 'sp.st_id = b.report_id', 'left');
	 		if($user_id!='')
	 		{
	 			$this->db->where('b.report_id', $user_id);
	 		}
	 		$this->db->order_by('id', 'desc');
	 		$q=$this->db->get('bug b');
			//print_e($this->db->last_query());
			if($q->num_rows() > 0){
				foreach ($q->result() as $row) {
					$data[] = $row;
				}
				return $data;
			}
			return NULL;
	 }
 		
 		public function bug_stat_toggle()
 		{
 			$data['status']='Fixed';
 			$this->db->where('id', $this->input->post('option'));
 			return $this->db->update('bug',$data);
 		}
 	
 		public function add_bug_remark()
 		{
 			$data['remarks']=$this->input->post('option');
 			$this->db->where('id', $this->input->post('id'));
 			return $this->db->update('bug', $data);
 		}

 		public function get_new_bug()
 		{
 			$this->db->where('status !=', 'Fixed');
 			$q=$this->db->get('bug');
 			if($q->num_rows()>0)
			{
				return $q->num_rows();
			}
			return FALSE;
 		}
 }
 
 /* End of file bug_model.php */
 /* Location: ./application/modules/pages/models/bug_model.php */ 