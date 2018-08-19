<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Class_reports_model extends CI_Model {

	public function list_classes($batch,$section_id = '')
	{
		$this->db->select('cd.*, s.batch,s.section_name,s.grade,CONCAT(e.first_name," ",e.middle_name," ",e.last_name) as teacher, e.employee_id, sb.subject_name');
		$this->db->join('section s', 's.section_id = cd.section_id');
		$this->db->join('employee e', 'e.employee_id = cd.employee_id');
		$this->db->join('subject sb', 'sb.subject_id = cd.subject_id');
		$this->db->join('grade g', 'g.grade_name = s.grade');
		$this->db->order_by('g.grade_order,s.section_name,sb.subject_name', 'asc');
		$this->db->where('s.batch', $batch);
		if($section_id != '')
		{
			$this->db->where('s.section_id', $section_id);
		}
			

		$q = $this->db->get('class_days cd');
		if ($q->num_rows() > 0) {
      foreach ($q->result() as $row) {
        $data[] = $row;
      }
      return $data;
    }
    return NULL;
	}

	public function grade_progress_status($grade,$exam_id)
  {
  	$this->db->select('COUNT(student_id) as num,tr.status');
  	$this->db->from('terminal_result tr');
  	$this->db->join('exam e', 'e.exam_id = tr.terminal_id');
  	$this->db->where('tr.grade', $grade);
  	$this->db->where('e.numeric_value', $exam_id);
  	$this->db->group_by('tr.status');
  	$q = $this->db->get();
		if ($q->num_rows() > 0) {
      foreach ($q->result() as $row) {
        $data[] = $row;
      }
      return $data;
    }
    return NULL;
  }
}

/* End of file class_reports_model.php */
/* Location: ./application/modules/pages/models/profile/class_reports_model.php */