<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Marks_entry_model extends CI_Model {

	/*public function get_class_info($class_days_id)
	{
		$this->db->where('class_days_id', $class_days_id);
		$result = $this->db->get('class_days');
		if($result->num_rows() > 0)
		{
			return $result->row();
		}
		return NULL;
	}*/

	public function get_exams($info)
	{
		$this->db->where('section_id', $info->section_id);
		$this->db->where('subject_id', $info->subject_id);
		$result = $this->db->get('exam');
		if($result->num_rows() > 0)
		{
			foreach ($result->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return NULL;
	}
	
	public function get_section_exams($section_id)
	{
		$this->db->where('section_id', $section_id);
		$this->db->group_by('numeric_value');
		$result = $this->db->get('exam');
		if($result->num_rows() > 0)
		{
			foreach ($result->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return NULL;
	}

	public function get_assessments($info)
	{
		$this->db->where('section_id', $info->section_id);
		$this->db->where('subject_id', $info->subject_id);
		$result = $this->db->get('assessment');
		if($result->num_rows() > 0)
		{
			foreach ($result->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return NULL;
	}

	public function get_students($info)
	{
		$this->db->where('class_id', $info->section_id);
		$this->db->order_by('current_roll');
		$result = $this->db->get('student');
		if($result->num_rows() > 0)
		{
			foreach ($result->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return NULL;
	}

	public function students_with_mark($section_id,$subject_id,$exam_id)
	{
		$state = $this->isset_students_mark($section_id,$subject_id,$exam_id);
		$this->db->select('*');
		$this->db->from('student s');
		$this->db->where('s.class_id', $section_id);
		if($state)
		{
			$this->db->join('st_marks stm', 'stm.student_id = s.student_id', 'left');
			$this->db->where('stm.subject_id', $subject_id);
			$this->db->where('stm.exam_id', $exam_id);
		}
		$this->db->order_by('s.current_roll');
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

	public function isset_students_mark($section_id,$subject_id,$exam_id)
	{

		$this->db->select('s.student_id');
		$this->db->from('student s');
		$this->db->join('st_marks stm', 'stm.student_id = s.student_id');
		$this->db->where('s.class_id', $section_id);
		$this->db->where('stm.subject_id', $subject_id);
		$this->db->where('stm.exam_id', $exam_id);
		$this->db->order_by('s.current_roll');
		$result = $this->db->get();
		if($result->num_rows() > 0)
		{
			return TRUE;
		}
		return FALSE;

	}

	public function students_final_mark($st_id,$subject_id,$exam_id)
	{
		if($exam_id != AGGREGATE_ID)
		{
			$this->db->select('*');
			$this->db->from('st_marks stm');
			$this->db->join('exam e', 'e.exam_id = stm.exam_id');
			$this->db->where('stm.student_id', $st_id);
			$this->db->where('stm.subject_id', $subject_id);
			$this->db->where('e.numeric_value', $exam_id);
			$result = $this->db->get();
			if($result->num_rows() > 0)
			{
				return $result->row();
			}
			return NULL;
		}
		else
		{
			$this->db->select('*');
			$this->db->from('final_result fr');
			$this->db->join('subject s', 's.subject_id = fr.subject_id');
			$this->db->where('fr.student_id', $st_id);
			$this->db->where('fr.subject_id', $subject_id);
			$result = $this->db->get();
			if($result->num_rows() > 0)
			{
				return $result->row();
			}
			return NULL;
		}
		
	}

	public function students_terminal_mark($st_id,$grade,$exam_id)
	{
		$this->db->select('*');
		$this->db->from('terminal_result tr');
		$this->db->where('tr.student_id', $st_id);
		$this->db->where('tr.grade', $grade);
		$this->db->where('tr.terminal_id', $exam_id);
		$result = $this->db->get();
		if($result->num_rows() > 0)
		{
			return $result->row();
		}
		return NULL;
	}

	public function isset_student_terminal_mark($st_id,$grade,$exam_id)
	{

		$this->db->select('student_id');
		$this->db->from('terminal_result tr');
		$this->db->where('tr.student_id', $st_id);
		$this->db->where('tr.grade', $grade);
		$this->db->where('tr.terminal_id', $exam_id);
		$result = $this->db->get();
		if($result->num_rows() > 0)
		{
			return TRUE;
		}
		return FALSE;
	}

	public function student_final_mark($section_id,$subject_id)
	{
		$state = $this->isset_student_final_mark($section_id,$subject_id);
		$this->db->select('*');
		$this->db->from('student s');
		$this->db->where('s.class_id', $section_id);
		if($state)
		{
			$this->db->join('final_result fr', 'fr.student_id = s.student_id', 'left');
			$this->db->where('fr.subject_id', $subject_id);
		}
		$this->db->order_by('s.current_roll');
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

	public function isset_student_final_mark($section_id,$subject_id)
	{
		$this->db->select('s.student_id');
		$this->db->from('student s');
		$this->db->join('final_result fr', 'fr.student_id = s.student_id');
		$this->db->where('s.class_id', $section_id);
		$this->db->where('fr.subject_id', $subject_id);
		$result = $this->db->get();
		if($result->num_rows() > 0)
		{
			return TRUE;
		}
		return FALSE;
	}

	public function add_internalmarks($class_days_id) {
		if(trim_post('st_ids') != '')
		{
		}
	    foreach (unserialize(trim_post('st_ids')) as $student_id) {
	      $data['student_id'] = $student_id;
	      $data['subject_id'] = trim_post('subject_id');
	      $data['exam_id'] = trim_post('exam_id');
	      $data['obtain_mark'] = trim_post('exam_'.$student_id);

	      if(trim_post('assessment_module') == 1 && trim_post('assessments') != '')
	      {
	        foreach(unserialize(trim_post('assessments')) as $row){
	          $assessments[$row] = trim_post($row."_" . $student_id);
	        }
	      	$data['assessment_marks']=serialize($assessments);
	      }
	      $data['total_marks'] = trim_post('final_' . $student_id);
	      $data['class_days_id'] = $class_days_id;
	     $sql = $this->db->insert('st_marks', $data);
	    }
	    return $sql;
  }

  public function update_internalmarks($class_days_id) {
    foreach (unserialize(trim_post('st_ids')) as $student_id) {
      $this->db->where('student_id', $student_id);
      $this->db->where('subject_id', trim_post('subject_id'));
      $this->db->where('exam_id', trim_post('exam_id'));
      if(trim_post('assessment_module') == 1 && trim_post('assessments') != '')
      {
        foreach(unserialize(trim_post('assessments')) as $row){
          $assessments[$row] = trim_post($row."_" . $student_id);
        }
      	$data['assessment_marks']=serialize($assessments);
      }
      $data['obtain_mark'] = trim_post('exam_'.$student_id);
      //print_e($data['obtain_mark']);
      $data['total_marks'] = trim_post('final_' . $student_id);
      $sql = $this->db->update('st_marks', $data);
    }
    return $sql;
  }

  public function add_final_internalmarks($class_days_id) {
    foreach (unserialize(trim_post('st_ids')) as $student_id) {
      $data['student_id'] = $student_id;
      $data['subject_id'] = trim_post('subject_id');
      //$data['exam_id'] = trim_post('exam_id');
      $data['final_mark'] = trim_post('avg_final_'.$student_id);
      
      foreach(unserialize(trim_post('exams')) as $row){
        $exams[$row] = trim_post("avg_".$row."_" . $student_id);
      }
      $data['scale_up_mark']=serialize($exams);
      $data['class_days_id'] = $class_days_id;
     $sql = $this->db->insert('final_result', $data);
    }
    return $sql;
  }

  public function update_final_internalmarks($class_days_id) {
    foreach (unserialize(trim_post('st_ids')) as $student_id) {
      $this->db->where('student_id', $student_id);
      $this->db->where('subject_id', trim_post('subject_id'));
      //$this->db->where('class_days_id', $class_days_id);
      foreach(unserialize(trim_post('exams')) as $row){
        $exams[$row] = trim_post("avg_".$row."_" . $student_id);
      }
    	$data['scale_up_mark']=serialize($exams);
      $data['final_mark'] = trim_post('avg_final_'.$student_id);
      $sql = $this->db->update('final_result', $data);
    }
    return $sql;
  }

  public function add_terminal_total()
  {
  	$st_ids = unserialize(trim_post('st_ids'));
  	$grade = trim_post('grade');
  	$exam =	trim_post('exam');
  	foreach ($st_ids as $st_id)
  	{
	  	if($this->isset_student_terminal_mark($st_id,$grade,$exam) ==  TRUE)
	  	{
	  		$this->db->where('grade', $grade); 
	  		$this->db->where('student_id', $st_id);
	  		$this->db->where('terminal_id', $exam);
	  		$data['full_marks'] = trim_post('total_mark_'.$st_id);
	  		$data['terminal_marks'] = trim_post('obtain_mark_'.$st_id);
	  		$data['status'] = trim_post('status_'.$st_id);
	  		$q = $this->db->update('terminal_result', $data);
	  	}
	  	else
	  	{
	  		$data['grade'] = $grade; 
	  		$data['student_id'] = $st_id;
	  		$data['terminal_id'] = $exam;
	  		$data['full_marks'] = trim_post('total_mark_'.$st_id);
	  		$data['terminal_marks'] = trim_post('obtain_mark_'.$st_id);
	  		$data['status'] = trim_post('status_'.$st_id);
	  		$q = $this->db->insert('terminal_result', $data);
	  	}
  	}
  	return $q;
  }
}

/* End of file marks_entry_model.php */
/* Location: ./application/modules/pages/models/exam/marks_entry_model.php */