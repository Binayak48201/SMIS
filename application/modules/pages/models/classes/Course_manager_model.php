<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Course_manager_model extends CI_Model {

	public function get_courses()
	{
		//$this->db->order_by('added_batch , grade', 'desc');
		$this->db->select('cd.*, sb.* ,sc.section_name, CONCAT(e.first_name," ",e.middle_name," ",e.last_name) as emp_fullname');
		$this->db->from('class_days cd');
		$this->db->join('subject sb', 'sb.subject_id = cd.subject_id');
		$this->db->join('section sc', 'sc.section_id = cd.section_id');
		$this->db->join('employee e', 'e.employee_id = cd.employee_id');
		$this->db->order_by('cd.class_days_id', 'desc');
		$query = $this->db->get();
		if($query->num_rows() > 0){
			foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return NULL;
	}

	public function get_courses_by_id($class_days_id)
	{
		//$this->db->order_by('added_batch , grade', 'desc');
		$this->db->select('cd.*, sb.* ,sc.section_name, sc.grade, CONCAT(e.first_name," ",e.middle_name," ",e.last_name) as emp_fullname');
		$this->db->from('class_days cd');
		$this->db->join('subject sb', 'sb.subject_id = cd.subject_id');
		$this->db->join('section sc', 'sc.section_id = cd.section_id');
		$this->db->join('employee e', 'e.employee_id = cd.employee_id');
		$this->db->where('class_days_id', $class_days_id);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->row();
		}
		return NULL;
	}

	public function add()
	{
		$data['class_time'] = trim_post('class_time');
		$data['employee_id'] = trim_post('employee_id');
		$data['subject_id'] = trim_post('subject_id');
		$data['section_id'] = trim_post('section_id');
		$data['start_date'] = trim_post('start_date');
		$data['end_date'] = trim_post('end_date');
		$data['updater'] = trim_post('updater');
		return $this->db->insert('class_days',$data);
	}

	public function update()
	{
		$data['class_time'] = trim_post('class_time');
		$data['employee_id'] = trim_post('employee_id');
		$data['subject_id'] = trim_post('subject_id');
		$data['section_id'] = trim_post('section_id');
		$data['start_date'] = trim_post('start_date');
		$data['end_date'] = trim_post('end_date');
		$data['updater'] = trim_post('updater');
		$this->db->where('class_days_id',trim_post('id'));
		return $this->db->update('class_days',$data);
	}

	public function delete($id)
	{
		$this->db->where('class_days_id',$id);
		return $this->db->delete('class_days');
	}

	public function get_st_classes($info)
	{
		//print_e($info);
		$this->db->select('cd.*, sb.* ,sc.section_name, sc.grade, CONCAT(e.first_name," ",e.middle_name," ",e.last_name) as emp_fullname');
		$this->db->from('class_days cd');
		$this->db->join('subject sb', 'sb.subject_id = cd.subject_id');
		$this->db->join('section sc', 'sc.section_id = cd.section_id');
		$this->db->join('employee e', 'e.employee_id = cd.employee_id');
		$this->db->where('cd.section_id', $info->section_id);
		$this->db->group_by('sb.subject_id');
		$query = $this->db->get();
		if($query->num_rows() > 0){
			foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return NULL;
	}
}

/* End of file subject_model.php */
/* Location: ./application/modules/pages/models/classes/subject_model.php */