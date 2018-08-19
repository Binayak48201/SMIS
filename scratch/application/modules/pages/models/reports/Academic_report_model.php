<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Academic_report_model extends CI_Model {

	public function students_for_rank($batch_id,$grade_id,$exam_id)
	{
		$this->db->select('*');
		$this->db->from('student s');
		$this->db->join('terminal_result tr', 'tr.student_id = s.student_id', 'left');
		$this->db->where('tr.grade', $grade_id);
		$this->db->where('tr.terminal_id', $exam_id);
		$this->db->where('tr.status', 'PASS');
		$this->db->group_by('tr.student_id,tr.grade,tr.terminal_id');
		$this->db->order_by('tr.terminal_marks', 'desc');
		$result = $this->db->get();
		if($result->num_rows() > 0)
		{
			foreach ($result->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return NULL;
	}
	

}

/* End of file academic_report_model.php */
/* Location: ./application/modules/pages/models/reports/academic_report_model.php */