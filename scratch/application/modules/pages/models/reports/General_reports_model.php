<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class General_reports_model extends CI_Model {

	public function prev_school_st_list($school_id)
	{
		$this->db->select('s.* , u.USER_NAME,sc.*');
		$this->db->where('s.last_school_id', $school_id);		
		$this->db->where('s.passed_out !=',1);		
		$this->db->join('section sc', 'sc.section_id = s.class_id');
		$this->db->join('users u', 'u.PROFILE_ID = s.student_id','left');
		$this->db->order_by('st_fname', 'asc');
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

	public function district_st_list($district)
	{
		$this->db->select('s.* , u.USER_NAME');
		$this->db->where('s.district_id', $district);		
		$this->db->where('s.passed_out !=',1);		
		//$this->db->join('section sc', 'sc.section_id = s.class_id');
		$this->db->join('users u', 'u.PROFILE_ID = s.student_id','left');
		$this->db->order_by('st_fname', 'asc');
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

	public function student_by_bus($bus_id,$stop_id)
	{
		$this->db->select('s.* , u.USER_NAME,sc.*,t.*,bs.*');
		if($stop_id != 'all')
		{
			$this->db->where('s.stop_id', $stop_id);		
		}
		$this->db->where('s.bus_id', $bus_id);
		$this->db->where('s.passed_out !=',1);		
		//$this->db->join('section sc', 'sc.section_id = s.class_id');
		$this->db->join('users u', 'u.PROFILE_ID = s.student_id','left');
		$this->db->join('bus_stop bs ', 'bs.stop_id = s.stop_id');
		$this->db->join('transport t', 't.bus_id = bs.bus_id');
		$this->db->join('section sc', 'sc.section_id = s.class_id');
		$this->db->order_by('st_fname', 'asc');
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

	public function district_st_dist()
	{
		$this->db->select('s.* ,sc.*, u.USER_NAME,d.district_name, count(s.student_id) as total');
		$this->db->where('s.passed_out !=',1);		
		$this->db->join('section sc', 'sc.section_id = s.class_id','left');
		$this->db->join('users u', 'u.PROFILE_ID = s.student_id','left');
		$this->db->join('district d', 'd.district_id = s.district_id','left');
		$this->db->group_by('s.class_id,s.district_id');
		$this->db->order_by('sc.grade,s.class_id', 'asc');
		$results = $this->db->get('student s');
		//print_e($this->db->last_query());
		if($results->num_rows() > 0)
		{
			foreach ($results->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return NULL;
	}

	public function student_overall($year = '')
	{
		$this->db->select('sc.*, 
			count(case when s.passed_out != "1"  then s.passed_out end) studying,
			count(case when s.passed_out = "1"  then s.passed_out end) passed,
		                  count(s.student_id) as total');
		//$this->db->where('s.passed_out !=',1);		
		$this->db->join('section sc', 'sc.section_id = s.class_id','left');
		$this->db->join('users u', 'u.PROFILE_ID = s.student_id','left');
		$this->db->join('district d', 'd.district_id = s.district_id','left');
		if($year != '')
		{
			$this->db->where('year(s.joined_date)', $year);
		}
		$this->db->group_by('sc.grade');
		$this->db->order_by('sc.grade,s.class_id', 'asc');
		$results = $this->db->get('student s');
		//print_e($this->db->last_query());
		if($results->num_rows() > 0)
		{
			foreach ($results->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return NULL;
	}

	public function current_student_overall($year,$opt = 'grade')
	{
		$this->db->select('sc.*, 
			count(case when s.passed_out != "1"  then s.passed_out end) studying,
			count(case when s.passed_out != "1" and s.gender = "Male" then s.gender end) male,
			count(case when s.passed_out != "1" and s.gender = "Female" then s.gender end) female,
			count(case when s.passed_out = "1"  then s.passed_out end) passed,
		                  count(s.student_id) as total');
		//$this->db->where('s.passed_out !=',1);		
		$this->db->join('section sc', 'sc.section_id = s.class_id','left');
		$this->db->join('users u', 'u.PROFILE_ID = s.student_id','left');
		$this->db->join('district d', 'd.district_id = s.district_id','left');
		$this->db->join('grade g', 'g.grade_name = sc.grade','left');
		$this->db->where('joined_batch', $year);
		if($opt == 'grade'){			
			$this->db->group_by('sc.grade');
			$this->db->order_by('g.grade_order', 'asc');
		}
		else if($opt == 'section'){			
			$this->db->group_by('sc.section_id');
			$this->db->order_by('g.grade_order,s.class_id', 'asc');
		}
		
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

	public function occupation_guardian_list($occupation_id)
	{
		$this->db->select('s.*,sc.* ,o.occupation_name');
		$this->db->where('s.guardian_occupation_id', $occupation_id);		
		$this->db->where('s.passed_out !=',1);		
		$this->db->join('section sc', 'sc.section_id = s.class_id');
		$this->db->join('occupation o', 'o.occupation_id = s.guardian_occupation_id');
		$this->db->order_by('st_fname', 'asc');
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

	public function search_guardian_list($name)
	{
		$this->db->select('s.*,sc.* ,o.occupation_name');
		$this->db->like('s.guardian_name', $name,'after');		
		$this->db->where('s.passed_out !=',1);		
		$this->db->join('section sc', 'sc.section_id = s.class_id');
		$this->db->join('occupation o', 'o.occupation_id = s.guardian_occupation_id');
		$this->db->order_by('st_fname', 'asc');
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

	public function guardian_list_class($section_id,$batch_id='',$grade_id='')
	{
		$this->db->select('s.* , u.USER_NAME,sc.*,o.occupation_name');
		if($section_id != 'all')
		{			
			$this->db->where('class_id', $section_id);
		}
		else{
			$this->db->where('joined_batch', $batch_id);
			$this->db->where('joined_grade_id', $grade_id);
		}
		$this->db->join('occupation o', 'o.occupation_id = s.guardian_occupation_id','left');
		$this->db->join('section sc', 'sc.section_id = s.class_id');
		$this->db->join('users u', 'u.PROFILE_ID = s.student_id','left');
		$this->db->order_by('st_fname', 'asc');
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

	public function birthday_students($value='')
	{
		$this->db->select('s.* , u.USER_NAME,sc.*');
		$this->db->join('section sc', 'sc.section_id = s.class_id');
		$this->db->join('users u', 'u.PROFILE_ID = s.student_id','left');
		$this->db->where("DATE_FORMAT(st_dob,'%m-%d') = DATE_FORMAT(NOW(),'%m-%d')");
		$this->db->order_by('st_fname', 'asc');
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

	public function get_employees()
	{
		$this->db->select('agreement_type, count(*) total');
		$this->db->from('employee');
		$this->db->where('status !=', 'Left');
		$this->db->group_by('agreement_type');
		$results = $this->db->get();
		if($results->num_rows() > 0)
		{
			foreach ($results->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return NULL;
	}
}

/* End of file general_reports_model.php */
/* Location: ./application/modules/pages/models/reports/general_reports_model.php */