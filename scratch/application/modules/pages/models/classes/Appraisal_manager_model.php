<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Appraisal_manager_model extends CI_Model {

	public function get_appraisals()
	{
		$result = $this->db->get('appraisal_heads');
		if($result->num_rows() > 0)
		{
			foreach ($result->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return NULL;
	}

	public function add_head()
	{
		$data['head_name'] = trim_post('head_name');
		return $this->db->insert('appraisal_heads', $data);
	}

	public function delete_head($id)
	{
		$this->db->where('head_id', $id);
		return $this->db->delete('appraisal_heads');
	}
	
	public function add_title()
	{
		$data['field_name'] = trim_post('title');
		$data['head_id'] = trim_post('head_id');
		return $this->db->insert('appraisal_fields', $data);
	}

	public function delete_title($id)
	{
		$this->db->where('field_id', $id);
		return $this->db->delete('appraisal_fields');
	}

	public function get_head_titles($head_id)
	{
		$this->db->order_by('field_name', 'Asc');
		$this->db->where('head_id', $head_id);
		$result = $this->db->get('appraisal_fields');
		if($result->num_rows() > 0)
		{
			foreach ($result->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return NULL;
	}

	public function get_grades()
	{
		$this->db->order_by('order', 'Asc');
		$result = $this->db->get('appraisal_grade');
		if($result->num_rows() > 0)
		{
			foreach ($result->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return NULL;
	}

	public function get_st_evaluated($field_id,$st_id,$exam_id,$section_id)
	{
		$this->db->where('student_id', $st_id);
		$this->db->where('section_id', $section_id);
		$this->db->where('exam_id', $exam_id);
		$this->db->where('field_id', $field_id);
		$result = $this->db->get('appraisal');
		if($result->num_rows() > 0)
		{
			return $result->row();
		}
		return NULL;
	}

	public function insert_appraisal_evaluation()
	{
		$data['student_id'] = trim_post('st_id');
		$data['section_id'] = trim_post('section_id');
		$data['exam_id'] = trim_post('exam_id');
		$evaluations = unserialize(trim_post('opt_eval'));
		$data['user_id'] = $this->session->userdata('smis_profile_id');
		foreach ($evaluations as $evaluation) {
			$data['field_id'] = $evaluation;
			$data['grade'] = trim_post('grade_'.$evaluation);
		 	$q = $this->db->insert('appraisal', $data);
		}
		return $q;
	}

	public function update_appraisal_evaluation()
	{
		$this->db->where('student_id', trim_post('st_id'));
		$this->db->where('section_id', trim_post('section_id'));
		$this->db->where('exam_id', trim_post('exam_id'));
		$evaluations = unserialize(trim_post('opt_eval'));
		$data['user_id'] = $this->session->userdata('smis_profile_id');
		foreach ($evaluations as $evaluation) {
			$this->db->where('appraisal_id', trim_post('type_'.$evaluation));
			$data['grade'] = trim_post('grade_'.$evaluation);
		 	$q = $this->db->update('appraisal', $data);
		}
		return $q;
	}
}

/* End of file appraisal_manager_model.php */
/* Location: ./application/modules/pages/models/classes/appraisal_manager_model.php */