<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_model extends CI_Model {

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

	public function add_employee($picture,$biodata)
	{
		//echo $picture;
		//echo $biodata;
		$data['first_name'] = trim_post('first_name');
		$data['middle_name'] = trim_post('middle_name');
		$data['last_name'] = trim_post('last_name');
		$data['phone_no'] = trim_post('phone_no');
		$data['email'] = trim_post('email');
		$data['address'] = trim_post('address');
		$data['birth_date'] = trim_post('birth_date');
		$data['qualification'] = trim_post('qualification');
		$data['agreement_type'] = trim_post('agreement_type');
		$data['dept'] = trim_post('dept');
		$data['basic_salary'] = trim_post('basic_salary');
		$data['joined_date'] = trim_post('joined_date');
		$data['employee_type'] = trim_post('employee_type');
		$data['additionals'] = trim_post('additionals');
		$data['status'] = trim_post('status');
		$data['designation'] = trim_post('designation');
		$data['code'] = trim_post('code');
		$data['user_id'] = trim_post('user_id');
		$data['biodata_path'] = $biodata;
		$data['picture_path'] = $picture;
		return $this->db->insert('employee', $data);

	}	

	public function update_employee($picture,$biodata,$emp_id)
	{
		$data['first_name'] = trim_post('first_name');
		$data['middle_name'] = trim_post('middle_name');
		$data['last_name'] = trim_post('last_name');
		$data['phone_no'] = trim_post('phone_no');
		$data['email'] = trim_post('email');
		$data['address'] = trim_post('address');
		$data['birth_date'] = trim_post('birth_date');
		$data['qualification'] = trim_post('qualification');
		$data['agreement_type'] = trim_post('agreement_type');
		$data['dept'] = trim_post('dept');
		$data['basic_salary'] = trim_post('basic_salary');
		$data['joined_date'] = trim_post('joined_date');
		$data['employee_type'] = trim_post('employee_type');
		$data['additionals'] = trim_post('additionals');
		$data['status'] = trim_post('status');
		$data['resign_date'] = trim_post('resign_date');
		$data['designation'] = trim_post('designation');
		$data['code'] = trim_post('code');
		$data['user_id'] = trim_post('user_id');
		$data['biodata_path'] = $biodata;
		$data['picture_path'] = $picture;
		$this->db->where('employee_id', $emp_id);
		return $this->db->update('employee', $data);
	}	

	public function delete($employee_id)
	{
		$this->db->where('employee_id', $employee_id);
		return $this->db->delete('employee');
	}

	public function get_employees()
	{
		$this->db->select('*');
		$this->db->from('employee');
		$this->db->order_by('employee_id', 'desc');
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

	public function add_leave()
	{
		$data['employee_id'] = trim_post('emp_id');
		$data['leave_type'] = trim_post('type');
		$data['leave_from'] = trim_post('from');
		$data['leave_to'] = trim_post('till');
		$data['leave_days'] = trim_post('days_no');
		$data['purpose'] = trim_post('purpose');
		$data['year_id'] = date('Y');
		return $this->db->insert('employee_leave', $data);
	}

}

/* End of file employee_model.php */
/* Location: ./application/modules/pages/models/profile/employee_model.php */