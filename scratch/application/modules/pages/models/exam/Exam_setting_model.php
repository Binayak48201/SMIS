<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Exam_setting_model extends CI_Model {

	public function add_exam()
	{
		$data['section_id'] = trim_post('section_id');
		$data['terminal_name'] = trim_post('exam_name');
		$data['numeric_value'] = trim_post('numeric_value');
		//$data['conducted_from'] = trim_post('');
		//$data['conducted_till'] = trim_post('');
		$data['subject_id'] = trim_post('subject_id');
		$data['full_mark'] = trim_post('full_mark');
		$data['pass_mark'] = trim_post('pass_mark');
		$data['average_at'] = trim_post('average_at');
		$data['convert_to'] = trim_post('convert_to');
		$data['status'] = 1;
		return $this->db->insert('exam', $data);
	}

	public function get_exams()
	{
		$this->db->select('e.* , s.batch, s.section_name, sb.subject_name, s.grade ');
		$this->db->from('exam e');
		$this->db->join('section s', 's.section_id = e.section_id');
		$this->db->join('subject sb', 'sb.subject_id = e.subject_id');
		$this->db->order_by('exam_id', 'desc');
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

	public function get_active_term($grade)
	{
		current_batch();
		$this->db->select('MAX(numeric_value) as numeric_value,terminal_name');
		$this->db->from('exam e');
		$this->db->join('section s', 's.section_id = e.section_id');
		$this->db->where('s.batch', 2073);
		$this->db->where('s.grade', $grade);
		$this->db->where('status', 1);
		$this->db->order_by('exam_id', 'desc');
		$results = $this->db->get();
		if($results->num_rows() > 0)
		{
			return $results->row();;
		}
		return NULL;
	}

	public function get_term_name()
	{
		$this->db->select('e.*');
		$this->db->from('exam e');
		$this->db->group_by('numeric_value');
		$this->db->order_by('numeric_value', 'asc');
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

	public function get_exam_info($grade,$batch,$numeric_value)
	{
		$this->db->select('e.* , s.batch, s.section_name, s.grade');
		$this->db->from('exam e');
		$this->db->join('section s', 's.section_id = e.section_id');
		$this->db->group_by('e.numeric_value');
		$this->db->where('s.batch', $batch);
		$this->db->where('s.grade', $grade);
		$this->db->where('e.numeric_value', $numeric_value);
		$results = $this->db->get();
		if($results->num_rows() > 0)
		{
			return $results->row();
		}
		return NULL;
	}

	public function get_exam_by_id($id)
	{
		$this->db->select('e.*,s.*,sb.*');
		$this->db->from('exam e');
		$this->db->join('section s', 's.section_id = e.section_id');
		$this->db->join('subject sb', 'sb.subject_id = e.subject_id');
		$this->db->where('e.exam_id', $id);
		$results = $this->db->get();
		if($results->num_rows() > 0)
		{
			return $results->row();
		}
		return NULL;
	}

	public function update($value='')
	{
		$data['full_mark'] = trim_post('full_mark');
		$data['pass_mark'] = trim_post('pass_mark');
		$data['average_at'] = trim_post('average_at');
		$data['convert_to'] = trim_post('convert_to');
		$data['status'] = trim_post('status');
		$this->db->where('exam_id', trim_post('id'));
		return $this->db->update('exam', $data);
	}

	public function delete($id)
	{
		$this->db->where('exam_id', $id);
		return $this->db->delete('exam');
	}

	public function get_exam_grades()
	{
		$this->db->order_by('mark_to', 'desc');
		$results = $this->db->get('exam_grades');
		if($results->num_rows() > 0)
		{
			foreach ($results->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return NULL;
	}

	public function add_exam_grade()
	{
		$data['mark_from'] = trim_post('mark_from');
		$data['mark_to'] = trim_post('mark_to'); 
		$data['grade'] = trim_post('grade_name'); 
		$data['description'] = trim_post('description'); 
		return $this->db->insert('exam_grades', $data);
	}

	public function update_exam_grade($id)
	{
		$data['mark_from'] = trim_post('mark_from');
		$data['mark_to'] = trim_post('mark_to'); 
		$data['grade'] = trim_post('grade_name'); 
		$data['description'] = trim_post('description');
		$this->db->where('id', $id);
		return $this->db->update('exam_grades', $data);
	}

	public function delete_exam_grade($id)
	{
		$this->db->where('id', $id);
		return $this->db->delete('exam_grades');
	}

	public function get_class_subjects($grade,$batch)
	{
		$this->db->select('*');
		$this->db->from('class_days cd');
		$this->db->join('section s', 's.section_id = cd.section_id');
		$this->db->join('subject sb', 'sb.subject_id = cd.subject_id');
		$this->db->where('s.batch', $batch);
		$this->db->where('s.grade', $grade);
		$this->db->group_by('cd.subject_id');
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

	public function get_section_subjects($section_id)
	{
		$this->db->select('cd.*,s.*,sb.*,CONCAT(e.first_name," ",e.last_name) as teacher');
		$this->db->from('class_days cd');
		$this->db->join('section s', 's.section_id = cd.section_id');
		$this->db->join('subject sb', 'sb.subject_id = cd.subject_id');
		$this->db->join('employee e', 'e.employee_id = cd.employee_id');
		$this->db->where('cd.section_id', $section_id);
		$this->db->group_by('cd.subject_id');
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

	public function get_assessments($grade,$batch)
	{
		$this->db->select('a.*');
		$this->db->from('assessment a');
		$this->db->join('section s', 's.section_id = a.section_id');
		$this->db->where('s.batch', $batch);
		$this->db->where('s.grade', $grade);
		$this->db->group_by('a.numeric_value');
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

	public function st_restrict()
	{
		$st_ids = unserialize( trim_post('st_ids') );
		$abs_stds = trim_post('abs_std');
		$this->db->where_in('student_id', $st_ids);
		$this->db->where('exam_id', trim_post('exam'));
		$this->db->where('grade', trim_post('grade'));
		$this->db->where('batch_id', trim_post('batch_id'));
		$this->db->delete('marksheet_restrict');

		foreach ($abs_stds as $abs_std) {
			$data['student_id'] = $abs_std;
			$data['exam_id'] = trim_post('exam');
			$data['grade'] = trim_post('grade');
			$data['batch_id'] = trim_post('batch_id');
			$data['status'] = 1;
			$q = $this->db->insert('marksheet_restrict', $data);
		}
		return $q;
	}
}

/* End of file exam_setting_model.php */
/* Location: ./application/modules/pages/models/exam/exam_setting_model.php */