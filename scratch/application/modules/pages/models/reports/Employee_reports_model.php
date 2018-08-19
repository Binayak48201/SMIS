<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_reports_model extends CI_Model {

	public function get_class_teachers($year)
	{
		$this->db->select('*');
		$this->db->from('employee e');
		$this->db->join('section s', 's.class_teacher_id = e.employee_id');
		$this->db->where('s.batch', $year);
		$this->db->order_by('e.first_name', 'asc');
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

/* End of file employee_reports_model.php */
/* Location: ./application/modules/pages/models/reports/employee_reports_model.php */