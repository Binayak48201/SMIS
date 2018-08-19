<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_control_model extends CI_Model {

	public function get_all_employees()
	{
		//exit();
		
	}

	public function get_teachers()
	{
		$this->db->select('employee_id, CONCAT(first_name," ",middle_name," ",last_name) as emp_fullname');
		$this->db->where('employee_type', 'Faculty');
		//$this->db->where('status', 'Currently Working');
		$this->db->order_by('first_name', 'ASC');
		$results = $this->db->get('employee');
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

/* End of file employee_control_model.php */
/* Location: ./application/modules/pages/models/control/employee_control_model.php */