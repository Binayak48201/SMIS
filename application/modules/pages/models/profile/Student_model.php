<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Student_model extends CI_Model {

	public function get_departments()
	{
		$results = $this->db->get('department');
		if($results->num_rows() > 0)
		{
			foreach ($results->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return NULL;
	}

	public function add_student()
	{
	
		$data['registration_number'] = trim_post('registration_number');
		$data['st_fname'] = trim_post('st_fname');
		$data['st_mname'] = trim_post('st_mname');
		$data['st_lname'] = trim_post('st_lname');
		$data['st_dob'] = trim_post('st_dob');
		$data['st_dob_np'] = trim_post('st_dob_np');
		$data['birth_place'] = trim_post('birth_place');
		$data['gender'] = trim_post('gender');
		$data['home_phone'] = trim_post('home_phone');
		$data['home_address'] = trim_post('home_address');
		$data['district_id'] = trim_post('district_id');
		$data['joined_grade_id'] = trim_post('joined_grade_id');
		$data['joined_date'] = trim_post('joined_date');
		$data['joined_batch'] = trim_post('joined_batch');
		$data['last_school_id'] = trim_post('last_school_id');
		$data['father_name'] = trim_post('father_name');
		$data['father_cell'] = trim_post('father_cell');
		$data['father_employer'] = trim_post('father_employer');
		$data['father_occupation_id'] = trim_post('father_occupation_id');
		$data['father_business_add'] = trim_post('father_business_add');
		$data['father_email'] = trim_post('father_email');
		$data['father_education'] = trim_post('father_education');
		$data['mother_name'] = trim_post('mother_name');
		$data['mother_cell'] = trim_post('mother_cell');
		$data['mother_employer'] = trim_post('mother_employer');
		$data['mother_occupation_id'] = trim_post('mother_occupation_id');
		$data['mother_business_add'] = trim_post('mother_business_add');
		$data['mother_email'] = trim_post('mother_email');
		$data['mother_education'] = trim_post('mother_education');
		$data['guardian_name'] = trim_post('guardian_name');
		$data['guardian_occupation_id'] = trim_post('guardian_occupation_id');
		$data['guardian_phone'] = trim_post('guardian_phone');
		$data['guardian_email'] = trim_post('guardian_email');
		$data['blood_group'] = trim_post('blood_group');
		$data['email'] = trim_post('email');
		$data['house_id'] = trim_post('house_id');
		$data['emergency_contact'] = trim_post('emergency_contact');
		$data['ec_address'] = trim_post('ec_address');
		
		$data['ec_relation'] = trim_post('ec_relation');
		$data['ec_phone'] = trim_post('ec_phone');
		$data['class_id'] = trim_post('class_id');
		$data['current_roll'] = trim_post('current_roll');
		$data['boarding_type'] = trim_post('boarding_type');
		$data['bus_id'] = trim_post('bus_id');
		$data['stop_id'] = trim_post('stop_id');
		$data['birth_mark'] = trim_post('birth_mark');
		$data['weight'] = trim_post('weight');
		$data['height'] = trim_post('height');
		$data['special_needs'] = trim_post('special_needs');
		$data['family_number'] = trim_post('family_number');
		$this->db->insert('student', $data);
		$profile_id = $this->db->insert_id();
  	//$np_date_arr = explode('-', AD_to_BS(date('Y-m-d'))); 
  	//$escape_year = substr($np_date_arr[0], -3);
  	$escape_year = substr($data['joined_batch'], -3);
  	$merged_st_id = $profile_id.'_'.$escape_year;
		
		$data_up['picture_path'] = 'student_photo/'.$merged_st_id.'.jpg';
    $this->db->where('student_id', $profile_id);
  	$this->db->update('student', $data_up);

		$ac_data['FNAME'] = trim_post('st_fname');
		$ac_data['LNAME'] = trim_post('st_lname');
		$ac_data['USER_NAME'] = $merged_st_id;
		$ac_data['USER_NAME'] = $merged_st_id;
		$ac_data['USER_PASSWORD'] = MD5(sha1($merged_st_id));
		$ac_data['ACC_STATUS'] = 'ON';
		$ac_data['PROFILE_ID'] = $profile_id;
		$role_id = $this->get_student_role();
		$ac_data['ROLE_ID'] = $role_id;
		$q = $this->create_student_account($ac_data); //creating student login account 

		$acp_data['FNAME'] = trim_post('mother_name');
		//$acp_data['LNAME'] = trim_post('st_lname');
		$puname = $merged_st_id."_p";
		$acp_data['USER_NAME'] = $puname;
		$acp_data['USER_PASSWORD'] = MD5(sha1($puname));
		$acp_data['ACC_STATUS'] = 'ON';
		$acp_data['PROFILE_ID'] = $profile_id;
		$role_id = $this->get_parent_role();
		$acp_data['ROLE_ID'] = $role_id;
		$q = $this->create_parent_account($acp_data); //creating Parent login account 

  	$upload_error = FALSE;

    	if(isset($_FILES['picture_path']) && is_uploaded_file($_FILES['picture_path']['tmp_name']))
	    {
	      $stat=$this->general->upload('picture_path','gif|jpg|png',$merged_st_id,'student_photo'); // form->name, ext, file name, folder
	      if($stat['status']==TRUE)
	      {
	        $picture=$stat['result'];
	        $data_up['picture_path'] = $picture;
	        $this->db->where('student_id', $profile_id);
	      	$q = $this->db->update('student', $data_up);
	      }
	      
	    }
	    return $q;
	}	

	public function update_student($st_id,$picture)
	{

		$data['registration_number'] = trim_post('registration_number');
		$data['st_fname'] = trim_post('st_fname');
		$data['st_mname'] = trim_post('st_mname');
		$data['st_lname'] = trim_post('st_lname');
		$data['st_dob'] = trim_post('st_dob');
		$data['st_dob_np'] = trim_post('st_dob_np');
		$data['picture_path'] = $picture;
		$data['birth_place'] = trim_post('birth_place');
		$data['gender'] = trim_post('gender');
		$data['home_phone'] = trim_post('home_phone');
		$data['home_address'] = trim_post('home_address');
		$data['district_id'] = trim_post('district_id');
		$data['joined_grade_id'] = trim_post('joined_grade_id');
		$data['joined_date'] = trim_post('joined_date');
		$data['joined_batch'] = trim_post('joined_batch');
		$data['last_school_id'] = trim_post('last_school_id');
		
		$data['father_name'] = trim_post('father_name');
		$data['father_cell'] = trim_post('father_cell');
		$data['father_employer'] = trim_post('father_employer');
		$data['father_occupation_id'] = trim_post('father_occupation_id');
		$data['father_business_add'] = trim_post('father_business_add');
		$data['father_email'] = trim_post('father_email');
		$data['father_education'] = trim_post('father_education');
		$data['mother_name'] = trim_post('mother_name');
		$data['mother_cell'] = trim_post('mother_cell');
		$data['mother_employer'] = trim_post('mother_employer');
		$data['mother_occupation_id'] = trim_post('mother_occupation_id');
		$data['mother_business_add'] = trim_post('mother_business_add');
		$data['mother_email'] = trim_post('mother_email');
		$data['mother_education'] = trim_post('mother_education');
		$data['guardian_name'] = trim_post('guardian_name');
		$data['guardian_occupation_id'] = trim_post('guardian_occupation_id');
		$data['guardian_phone'] = trim_post('guardian_phone');
		$data['guardian_email'] = trim_post('guardian_email');
		$data['blood_group'] = trim_post('blood_group');
		$data['email'] = trim_post('email');
		$data['house_id'] = trim_post('house_id');
		$data['emergency_contact'] = trim_post('emergency_contact');
		$data['ec_address'] = trim_post('ec_address');
		$data['ec_relation'] = trim_post('ec_relation');
		$data['ec_phone'] = trim_post('ec_phone');
		$data['class_id'] = trim_post('class_id');
		$data['current_roll'] = trim_post('current_roll');
		$data['boarding_type'] = trim_post('boarding_type');
		$data['bus_id'] = trim_post('bus_id');
		$data['stop_id'] = trim_post('stop_id');
		$data['birth_mark'] = trim_post('birth_mark');
		$data['weight'] = trim_post('weight');
		$data['height'] = trim_post('height');
		$data['special_needs'] = trim_post('special_needs');
		$data['family_number'] = trim_post('family_number');
		$data['dropped_out'] = trim_post('dropped_out');
		$this->db->where('student_id', $st_id);
		return $this->db->update('student', $data);
	}	

	public function delete($employee_id)
	{
		$this->db->where('employee_id', $employee_id);
		return $this->db->delete('employee');
	}

	public function get_student_role()
	{
		$this->db->where('ROLE_NAME', 'student');
		$q = $this->db->get('roles');
		return $q->row()->ROLE_ID;
	}

	public function get_parent_role()
	{
		$this->db->where('ROLE_NAME', 'parent');
		$q = $this->db->get('roles');
		return $q->row()->ROLE_ID;
	}
	
	public function create_student_account($ac_data)
	{
		return $this->db->insert('users', $ac_data);
	}

	public function create_parent_account($ac_data)
	{
		return $this->db->insert('users', $ac_data);
	}

	public function get_students($section_id,$batch_id='',$grade_id='')
	{
		$role_id = $this->get_student_role();
		$this->db->select('s.* , u.USER_NAME,sc.*,h.house_name,bs.stop_name,t.*');
		if($section_id != 'all')
		{			
			$this->db->where('class_id', $section_id);
		}
		else{
			$this->db->where('joined_batch', $batch_id);
			$this->db->where('joined_grade_id', $grade_id);
		}

		$this->db->join('bus_stop bs ', 'bs.stop_id = s.stop_id', 'left');
		$this->db->join('transport t', 't.bus_id = bs.bus_id', 'left');
		$this->db->join('house h', 'h.house_id = s.house_id', 'left');
		$this->db->join('section sc', 'sc.section_id = s.class_id');
		$this->db->join('users u', 'u.PROFILE_ID = s.student_id','left');
		$this->db->order_by('st_fname', 'asc');
		$this->db->where('s.dropped_out !=', 1);
		$this->db->where('u.ROLE_ID ', $role_id);
		$results = $this->db->get('student s');
		if($results->num_rows() > 0)
		{
			foreach ($results->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return NULL;
	}

	public function get_all_students($section_id,$batch_id='',$grade_id='')
	{
		$role_id = $this->get_student_role();
		$this->db->select('s.* , u.USER_NAME,sc.*,h.house_name,bs.stop_name,t.*');
		if($section_id != 'all')
		{			
			$this->db->where('class_id', $section_id);
		}
		else{
			$this->db->where('joined_batch', $batch_id);
			$this->db->where('joined_grade_id', $grade_id);
		}

		$this->db->join('bus_stop bs ', 'bs.stop_id = s.stop_id', 'left');
		$this->db->join('transport t', 't.bus_id = bs.bus_id', 'left');
		$this->db->join('house h', 'h.house_id = s.house_id', 'left');
		$this->db->join('section sc', 'sc.section_id = s.class_id');
		$this->db->join('users u', 'u.PROFILE_ID = s.student_id','left');
		$this->db->order_by('st_fname', 'asc');
		$this->db->where('u.ROLE_ID ', $role_id);
		$results = $this->db->get('student s');
		if($results->num_rows() > 0)
		{
			foreach ($results->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return NULL;
	}

	public function dropped_student_list()
	{
		$role_id = $this->get_student_role();
		$this->db->select('s.* , u.USER_NAME,sc.*');
		$this->db->where('s.dropped_out ', 1);
		$this->db->join('section sc', 'sc.section_id = s.class_id');
		$this->db->join('users u', 'u.PROFILE_ID = s.student_id','left');
		$this->db->where('u.ROLE_ID ', $role_id);
		$this->db->order_by('joined_batch', 'desc');
		$results = $this->db->get('student s');
		if($results->num_rows() > 0)
		{
			foreach ($results->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return NULL;
	}

	public function get_st_id($st_id)
	{
		$role_id = $this->get_student_role();
		$this->db->select('s.* , u.USER_NAME');
		$this->db->where('s.student_id', $st_id);
		$this->db->join('users u', 'u.PROFILE_ID = s.student_id','left');
		$this->db->where('u.ROLE_ID ', $role_id);
		$q = $this->db->get('student s');
		if($q->num_rows() > 0)
			return $q->row();
		return NULL;
	}

	public function update_student_account($ac_data)
	{
		//return $this->db->insert('users', $ac_data);
	}

	public function update_st_roll()
	{
		$st_ids = unserialize(trim_post('st_ids'));
		foreach ($st_ids as $st_id) {
			$data['current_roll'] = trim_post($st_id);
			$this->db->where('student_id', $st_id);
			$res = $this->db->update('student', $data);
		}
		return $res;
	}

	public function update_bulk_st()
	{
		$st_ids = unserialize(trim_post('st_ids'));
		foreach ($st_ids as $st_id) {
			$data['weight'] = trim_post('weight_'.$st_id);
			$data['height'] = trim_post('height_'.$st_id);
			$data['special_needs'] = trim_post('special_needs_'.$st_id);
			$this->db->where('student_id', $st_id);
			$res = $this->db->update('student', $data);
		}
		return $res;
	}

	public function class_reassign()
	{
		$st_ids = trim_post('student_ids');
		foreach ($st_ids as $st_id) {
			$data['joined_batch'] = trim_post('re_batch');
			$data['joined_grade_id'] = trim_post('re_grade');
			$data['class_id'] = trim_post('re_section');
			$this->db->where('student_id', $st_id);
			$q = $this->db->update('student', $data);
		}
		return $q;
		//print_e(trim_post('student_ids'));
	}

	public function get_st_details($st_id)
	{
		$role_id = $this->get_student_role();
		$this->db->select('s.*,sh.*,d.*,h.*,t.*,sc.*,fo.occupation_name as father_occupation, mo.occupation_name as mother_occupation, gu.occupation_name as guardian_occupation,CONCAT(e.first_name," ",e.middle_name," ",e.last_name) as class_teacher,u.USER_NAME ');
		$this->db->from('student s');
		$this->db->join('school sh', 'sh.school_id = s.last_school_id', 'left');
		$this->db->join('district d', 'd.district_id = s.district_id', 'left');
		$this->db->join('house h', 'h.house_id = s.house_id', 'left');
		$this->db->join('bus_stop bs ', 'bs.stop_id = s.stop_id', 'left');
		$this->db->join('transport t', 't.bus_id = bs.bus_id', 'left');
		$this->db->join('occupation fo', 'fo.occupation_id = s.father_occupation_id', 'left');
		$this->db->join('occupation mo', 'mo.occupation_id = s.mother_occupation_id', 'left');
		$this->db->join('occupation gu', 'gu.occupation_id = s.guardian_occupation_id', 'left');
		$this->db->join('section sc', 'sc.section_id = s.class_id', 'left');
		$this->db->join('employee e', 'e.employee_id = sc.class_teacher_id', 'left');
		$this->db->join('users u', 'u.PROFILE_ID = s.student_id','left');
		$this->db->where('s.student_id', $st_id);
		$this->db->where('u.ROLE_ID ', $role_id);
		$q = $this->db->get();
		if($q->num_rows() > 0)
			return $q->row();
		return NULL;
	}

	public function find_student($option,$key)
	{
		$role_id = $this->get_student_role();
		$this->db->select('sp.*,s.*,u.USER_NAME');
		$this->db->join('section s', 's.section_id = sp.class_id');
		$this->db->join('users u', 'u.PROFILE_ID = sp.student_id');
		$this->db->like($option, $key);
		$this->db->where('u.ROLE_ID ', $role_id);
		$this->db->order_by('sp.student_id', 'desc');
		$q=$this->db->get('student sp');
		if($q->num_rows() > 0)
		{
			foreach ($q->result() as $row) 
			{
				$data[] = $row;
			}
			return $data;
		}
		return NULL;
	}

}

/* End of file employee_model.php */
/* Location: ./application/modules/pages/models/profile/employee_model.php */