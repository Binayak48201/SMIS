<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Section_manager_model extends CI_Model {

	public function get_sections()
	{
		$this->db->order_by('batch , grade', 'desc');
		$query = $this->db->get('section');
		if($query->num_rows() > 0){
			foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return NULL;
	}

	public function get_session_sections()
	{
		//$this->db->select('*, MAX(batch) as batch_active');
		//$this->db->group_by('section_id');
		//$this->db->having('batch', 'batch_active');
		//$this->db->order_by('batch , grade', 'desc');
		$query = $this->db->query("SELECT * FROM section WHERE (`batch`) IN ( SELECT MAX(`batch`) FROM section )  ORDER BY `section`.`grade`, `section`.`section_name`");
		if($query->num_rows() > 0){
			foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return NULL;
	}

	public function get_sections_with_teacher()
	{
		$this->db->select('section.*, CONCAT(employee.first_name," ",employee.middle_name," ",employee.last_name ) as emp_fullname ');
		$this->db->join('employee', 'employee.employee_id = section.class_teacher_id', 'left');
		$this->db->order_by('batch , grade', 'desc');
		$query = $this->db->get('section');
		if($query->num_rows() > 0){
			foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return NULL;
	}

	public function get_sections_opt($batch, $grade)
	{
		$this->db->order_by('section_name', 'desc');
		$this->db->where('batch', $batch);
		$this->db->where('grade', $grade);
		$query = $this->db->get('section');
		if($query->num_rows() > 0){
			foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return NULL;
	}

	public function add()
	{
		$data['batch'] = trim_post('batch');
		$data['grade'] = trim_post('grade');
		$data['section_name'] = trim_post('section_name');
		return $this->db->insert('section',$data);
	}

	public function update()
	{
		$data['batch'] = trim_post('batch');
		$data['grade'] = trim_post('grade');
		$data['section_name'] = trim_post('section_name');
		$this->db->where('section_id',trim_post('id'));
		return $this->db->update('section',$data);
	}

	public function delete($id)
	{
		$this->db->where('section_id',$id);
		return $this->db->delete('section');
	}

	public function class_teacher_section($emp_id,$date)
	{
		/*$this->db->select('cd.*, sc.section_name, sc.section_id, s.subject_name, sc.grade,sc.class_teacher_id');
		$this->db->from('class_days cd');
		$this->db->join('section sc', 'sc.section_id = cd.section_id');
		$this->db->join('subject s', 's.subject_id = cd.subject_id');*/

		$this->db->select('cd.*, sc.section_name, sc.section_id, sc.grade,sc.class_teacher_id');
		$this->db->from('section sc');
		$this->db->join('class_days cd', 'sc.section_id = cd.section_id');
		$this->db->where('sc.class_teacher_id', $emp_id);
		$this->db->where('cd.start_date <=', $date);
		$this->db->where('cd.end_date >=', $date);
		$this->db->group_by('sc.section_id');
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

/* End of file section_model.php */
/* Location: ./application/modules/pages/models/classes/section_model.php */