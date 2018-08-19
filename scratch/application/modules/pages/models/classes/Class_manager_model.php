<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Class_manager_model extends CI_Model {

	public function update()
	{
		$section_id = trim_post('id');
		$data['class_teacher_id'] = trim_post('teacher');
		$this->db->where('section_id', $section_id);
		return $this->db->update('section', $data);
	}

	public function get_routine($section_id)
	{
		$this->db->where('section_id', $section_id);
		$q = $this->db->get('class_routine');
		if($q->num_rows() > 0){
			return $q->row();
		}
		return NULL;
	}

	public function add_routine($section_id)
	{
		$data['routine'] = trim_post('class_routine');
		$data['section_id'] = $section_id;
		return $this->db->insert('class_routine', $data);
	}

	public function update_routine($section_id)
	{
		$data['routine'] = trim_post('class_routine');
		$this->db->where('section_id', $section_id);
		return $this->db->update('class_routine', $data);
	}

	public function teacher_current_class($emp_id,$date)
	{
		$this->db->select('cd.*, sc.section_name, sc.section_id, s.subject_name, sc.grade,sc.class_teacher_id');
		$this->db->from('class_days cd');
		$this->db->join('section sc', 'sc.section_id = cd.section_id');
		$this->db->join('subject s', 's.subject_id = cd.subject_id');
		$this->db->where('cd.employee_id', $emp_id);
		$this->db->where('cd.start_date <=', $date);
		$this->db->where('cd.end_date >=', $date);
		$results = $this->db->get();
		if($results->num_rows() > 0)
		{
			foreach ($results->result() as $row){
				$data[] = $row;
			}
			return $data;
		}
		return NULL;
	}
}

/* End of file grade_manager.php */
/* Location: ./application/modules/pages/models/classes/grade_manager.php */

