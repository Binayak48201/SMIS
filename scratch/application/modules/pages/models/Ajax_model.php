<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax_model extends CI_Model {

	public function get_bus_stops($bus_id)
	{
		$this->db->where('bus_id', $bus_id);
		$result = $this->db->get('bus_stop');
		if($result->num_rows() > 0)
		{
			foreach ($result->result() as $row) 
			{
				$data[] = $row;
			}
			return $data;
		}
		return NULL;
	}

	public function bus_stops_time_table($bus_id)
	{
		$this->db->join('transport t', 't.bus_id = bs.bus_id');
		$this->db->where('bs.bus_id', $bus_id);
		$result = $this->db->get('bus_stop bs');
		if($result->num_rows() > 0)
		{
			foreach ($result->result() as $row) 
			{
				$data[] = $row;
			}
			return $data;
		}
		return NULL;
	}

	public function get_bus_stop($bus_id)
	{
		$this->db->where('bus_id', $bus_id);
		$result = $this->db->get('bus_stop');
		if($result->num_rows() > 0)
		{
			foreach ($result->result() as $row) 
			{
				$data[] = $row;
			}
			return $data;
		}
		return NULL;
	}

	public function delete_bus_stops($stop_id)
	{
		$this->db->where('stop_id', $stop_id);
		return $this->db->delete('bus_stop');
	}

	public function add_bus_stops()
	{
		$stop_name = trim_post('stop_name');
		$bus_id = trim_post('bus_id');
		$this->db->where('stop_name', $stop_name);
		$this->db->where('bus_id', $bus_id);
		$result = $this->db->get('bus_stop');
		if($result->num_rows() > 0)
		{
			return $this->update_bus_stops();
		}
		$data['bus_id'] = $bus_id;
		$data['stop_name'] = $stop_name;
		$data['pick_time'] = trim_post('pickup_time');
		$data['drop_time'] = trim_post('drop_time');
		return $this->db->insert('bus_stop', $data);
	}

	public function update_bus_stops()
	{
		$data['bus_id'] = trim_post('bus_id');
		$data['stop_name'] = trim_post('stop_name');
		$data['pick_time'] = trim_post('pickup_time');
		$data['drop_time'] = trim_post('drop_time');
		$this->db->where('stop_name', $data['stop_name']);
		$this->db->where('bus_id', $data['bus_id']);
		return $this->db->update('bus_stop', $data);
	}

	public function grade_table_recoder()
	{
		$data['grade_order'] = $this->input->post('nextPosition');
		$this->db->where('grade_id', $this->input->post('currentId'));
		$this->db->update('grade', $data);

		$data['grade_order'] = $this->input->post('currentPosition');
		$this->db->where('grade_id', $this->input->post('nextId'));
		return $this->db->update('grade', $data);
	}

	public function get_section()
	{
		$batch = trim_post('batch');
		$grade = trim_post('grade');
		$this->db->where('batch', $batch);
		$this->db->where('grade', $grade);
		$result = $this->db->get('section');
		if($result->num_rows() > 0)
		{
			foreach ($result->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return NULL;
	}

	public function get_subject()
	{
		$batch = trim_post('batch');
		$grade = trim_post('grade');
		$this->db->where('added_batch', $batch);
		$this->db->where('grade', $grade);
		$result = $this->db->get('subject');
		if($result->num_rows() > 0)
		{
			foreach ($result->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return NULL;
	}

	public function get_subject_mark()
	{
		$batch = trim_post('batch');
		$grade = trim_post('grade');
		$subject = trim_post('subject');
		$this->db->where('added_batch', $batch);
		$this->db->where('grade', $grade);
		$this->db->where('subject_id', $subject);
		$result = $this->db->get('subject');
		if($result->num_rows() > 0)
			return $result->row();

		return NULL;
	}

	public function get_class_days($section_id)
	{
		$this->db->select('cd.*, sb.* ,sc.section_name');
		$this->db->from('class_days cd');
		$this->db->join('subject sb', 'sb.subject_id = cd.subject_id');
		$this->db->join('section sc', 'sc.section_id = cd.section_id');
		//$this->db->join('employee e', 'e.employee_id = cd.employee_id');
		$this->db->where('cd.section_id', $section_id);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return NULL;
	}

	public function get_teacher_class($section_id)
	{
		$this->db->select('cd.*, sb.* ,sc.section_name');
		$this->db->from('class_days cd');
		$this->db->join('subject sb', 'sb.subject_id = cd.subject_id');
		$this->db->join('section sc', 'sc.section_id = cd.section_id');
		//$this->db->join('employee e', 'e.employee_id = cd.employee_id');
		$this->db->where('cd.section_id', $section_id);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return NULL;
	}

	public function check_lession_plan($class_days_id)
	{
		$this->db->where('class_days_id', $class_days_id);
		$query = $this->db->get('lession_plan');
		if($query->num_rows() > 0){
			return TRUE;
		}
		return FALSE;
	}

	public function get_class_exams($info)
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

	public function get_lessons($class_days_id)
	{
		$this->db->where('class_days_id', $class_days_id);
		$this->db->group_by('ch_id');
		$query = $this->db->get('lession_plan');
		if($query->num_rows() > 0){
			foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return NULL;
	}

	public function get_topics($class_days_id,$ch_id)
	{
		$this->db->where('class_days_id', $class_days_id);
		$this->db->where('ch_id', $ch_id);
		$query = $this->db->get('lession_plan');
		if($query->num_rows() > 0){
			foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return NULL;
	}

	public function update_lession($id,$opt)
	{
		$data['t_stat']=$opt;
		$data['last_updated']=`CURRENT_TIMESTAMP`;
		$this->db->where('id',$id);
    return $this->db->update('lession_plan', $data);
	}

	public function check_subjects($batch, $grade)
	{
		$this->db->where('added_batch', $batch);
		$this->db->where('grade', $grade);
		$query = $this->db->get('subject');
		if($query->num_rows() > 0){
			return TRUE;
		}
		return FALSE;
	}

	public function get_employee_profile($emp_id)
	{
		$this->db->select('e.*,d.department_name');
		$this->db->join('department d', 'd.dept_id = e.dept', 'left');
		$this->db->where('e.employee_id', $emp_id);
		$query = $this->db->get('employee e');
		if($query->num_rows() > 0){
			return $query->row();
		}
		return NULL;
	}

	public function get_class_routine($section_id)
	{
		$this->db->where('section_id', $section_id);
		$query = $this->db->get('class_routine');
		if($query->num_rows() > 0){
			return $query->row();
		}
		return NULL;
	}

	 public function get_exams($section_id,$batch_id='')
  {
  	$this->db->select('e.*');
  	$this->db->from('exam e');
  	$this->db->join('section s', 's.section_id = e.section_id');
  	if($section_id != 'all')
  		$this->db->where('e.section_id', $section_id);
  	else
  		$this->db->where('s.batch', $batch_id);
  	$this->db->group_by('e.numeric_value');
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

  public function get_st_info($st_id)
  {
  	$this->db->where('student_id', $st_id);
		$query = $this->db->get('student');
		if($query->num_rows() > 0){
			return $query->row();
		}
		return NULL;
  }

  public function get_st_with_attendance($st_id,$grade,$batch,$exam)
  {
  	$this->db->select('ca.*');
  	$this->db->from('class_attendance ca');
  	$this->db->join('exam e', 'e.exam_id = ca.terminal_id', 'left');
  	$this->db->join('section s', 's.section_id = e.section_id', 'left');
  	$this->db->where('ca.student_id', $st_id);
  	$this->db->where('s.grade', $grade);
  	$this->db->where('s.batch', $batch);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->row();
		}
		return NULL;
  }

  public function get_st_terminal_comment($st_id,$grade,$batch,$exam)
  {
  	$this->db->select('tc.*');
  	$this->db->from('terminal_comment tc');
  	$this->db->join('exam e', 'e.exam_id = tc.terminal_id', 'left');
  	$this->db->join('section s', 's.section_id = e.section_id', 'left');
  	$this->db->where('tc.student_id', $st_id);
  	$this->db->where('s.grade', $grade);
  	$this->db->where('s.batch', $batch);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->row();
		}
		return NULL;
  }

  public function get_st_appraisal($st_id,$grade,$batch,$exam,$head_id)
  {
  	$this->db->select('a.*,af.*');
  	$this->db->from('appraisal a');
  	$this->db->join('appraisal_fields af', 'af.field_id = a.field_id');
  	$this->db->join('section s', 's.section_id = a.section_id');
  	$this->db->where('a.student_id', $st_id);
  	$this->db->where('s.grade', $grade);
  	$this->db->where('s.batch', $batch);
  	$this->db->where('af.head_id', $head_id);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return NULL;
  }

  public function get_grade($percent)
  {
  	$this->db->where('mark_from <=', $percent);
  	$this->db->where('mark_to >=', $percent);
  	$query = $this->db->get('exam_grades');
		if($query->num_rows() > 0){
			return $query->row()->grade;
		}
		return NULL;
  }

  public function get_final_exam($batch,$grade)
  {
  	$this->db->select('MAX(e.numeric_value) exam_id , e.terminal_name');
  	$this->db->from('exam e');
  	$this->db->join('section s', 's.section_id = e.section_id');
  	$this->db->where('s.batch', $batch);
  	$this->db->where('s.grade', $grade);
  	$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->row();
		}
		return NULL;
  }

  public function get_all_exams($grade, $batch)
  {
  	$this->db->select('e.*');
  	$this->db->from('exam e');
  	$this->db->join('section s', 's.section_id = e.section_id');
  	$this->db->where('s.batch', $batch);
  	$this->db->where('s.grade', $grade);
  	$this->db->group_by('numeric_value');
  	$query = $this->db->get();
		if($query->num_rows() > 0){
				foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return NULL;
  }

  public function check_assesment_number($section, $subject, $numeric_value)
  {
  	$this->db->where('section_id', $section);
  	$this->db->where('subject_id', $subject);
  	$this->db->where('numeric_value', $numeric_value);
  	$query = $this->db->get('assessment');
  	if($query->num_rows() > 0)
  	{
  		return TRUE;
  	}
  	return FALSE;
  }

  public function check_exam_number($section, $subject, $numeric_value)
  {
  	$this->db->where('section_id', $section);
  	$this->db->where('subject_id', $subject);
  	$this->db->where('numeric_value', $numeric_value);
  	$query = $this->db->get('exam');
  	if($query->num_rows() > 0)
  	{
  		return TRUE;
  	}
  	return FALSE;
  }

  public function students_attandance_by_grade($st_id,$section_id,$exam_id)
	{
		$this->db->select('ca.*');
		$this->db->from('class_attendance ca');
		$this->db->join('class_days cd', 'cd.class_days_id = ca.class_days_id');
		$this->db->join('exam e', 'e.exam_id = ca.terminal_id');
		$this->db->where('e.numeric_value', $exam_id);
		$this->db->where('cd.section_id', $section_id);
		$this->db->where('ca.student_id', $st_id);
		$result = $this->db->get();
		if($result->num_rows() > 0)
		{
			return $result->row();
		}
		return NULL;
	}

	public function st_clubs($st_id)
	{
		$this->db->where('student_id', $st_id);
		$query = $this->db->get('student_club');
		if($query->num_rows() > 0){
				foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return NULL;
	}
	public function st_medical_condition($st_id)
	{
		$this->db->where('student_id', $st_id);
		$query = $this->db->get('student_condition');
		if($query->num_rows() > 0){
				foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return NULL;
	}
	public function st_medications($st_id)
	{
		$this->db->where('student_id', $st_id);
		$this->db->order_by('st_medication_id', 'desc');
		$query = $this->db->get('student_medication');
		if($query->num_rows() > 0){
				foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return NULL;
	}
	public function st_consultants($st_id)
	{
		$this->db->where('student_id', $st_id);
		$this->db->order_by('doctor_id', 'desc');
		$query = $this->db->get('doctor');
		if($query->num_rows() > 0){
				foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return NULL;
	}
	public function st_responsibilities($st_id)
	{
		$this->db->where('student_id', $st_id);
		$this->db->order_by('st_designation_id', 'desc');
		$query = $this->db->get('student_designation');
		if($query->num_rows() > 0){
				foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return NULL;
	}
	public function st_games($st_id)
	{
		$this->db->where('student_id', $st_id);
		$this->db->order_by('st_game_id', 'desc');
		$query = $this->db->get('student_game');
		if($query->num_rows() > 0){
				foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return NULL;
	}
	public function st_hobbies($st_id)
	{
		$this->db->where('student_id', $st_id);
		$this->db->order_by('st_hobby_id', 'desc');
		$query = $this->db->get('student_hobby');
		if($query->num_rows() > 0){
				foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return NULL;
	}
	public function st_siblings($st_id)
	{
		$this->db->where('student_id', $st_id);
		$this->db->order_by('sibling_id', 'desc');
		$query = $this->db->get('sibling');
		if($query->num_rows() > 0){
				foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return NULL;
	}
	public function st_achievements($st_id)
	{
		$this->db->where('student_id', $st_id);
		$this->db->order_by('st_achievement_id', 'desc');
		$query = $this->db->get('student_achievement');
		if($query->num_rows() > 0){
				foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return NULL;
	}

	public function add_st_club()
	{
		$data['club_type'] = trim_post('club_type');
		$data['club'] = trim_post('clubs');
		$data['designation'] = trim_post('designation');
		$data['student_id'] = trim_post('st_id');
		return $this->db->insert('student_club', $data);
	}

	public function delete_st_club()
	{
		$this->db->where('st_club_id', trim_post('st_club_id'));
		return $this->db->delete('student_club');
	}

	public function add_st_medication()
	{
		$data['medication'] = trim_post('medication');
		$data['remarks'] = trim_post('remarks');
		$data['student_id'] = trim_post('st_id');
		return $this->db->insert('student_medication', $data);
	}

	public function delete_st_medication()
	{
		$this->db->where('st_medication_id', trim_post('st_medication_id'));
		return $this->db->delete('student_medication');
	}

	public function add_st_doctor()
	{
		$data['doctor_name'] = trim_post('doctor_name');
		$data['hospital'] = trim_post('hospital');
		$data['phone'] = trim_post('phone');
		$data['student_id'] = trim_post('st_id');
		return $this->db->insert('doctor', $data);
	}

	public function delete_st_doctor()
	{
		$this->db->where('doctor_id', trim_post('doctor_id'));
		return $this->db->delete('doctor');
	}

	public function add_st_responsibility()
	{
		$data['designation'] = trim_post('designation');
		$data['remarks'] = trim_post('remarks');
		$data['student_id'] = trim_post('st_id');
		return $this->db->insert('student_designation', $data);
	}

	public function delete_st_responsibility()
	{
		$this->db->where('st_designation_id', trim_post('st_responsibilities_id'));
		return $this->db->delete('student_designation');
	}

	public function add_st_game()
	{
		$data['game'] = trim_post('game');
		$data['remarks'] = trim_post('remarks');
		$data['student_id'] = trim_post('st_id');
		return $this->db->insert('student_game', $data);
	}

	public function delete_st_game()
	{
		$this->db->where('st_game_id', trim_post('st_game_id'));
		return $this->db->delete('student_game');
	}
	public function add_st_hobby()
	{
		$data['hobby'] = trim_post('hobby');
		$data['remarks'] = trim_post('remarks');
		$data['student_id'] = trim_post('st_id');
		return $this->db->insert('student_hobby', $data);
	}

	public function delete_st_hobby()
	{
		$this->db->where('st_hobby_id', trim_post('st_hobby_id'));
		return $this->db->delete('student_hobby');
	}

	public function add_st_achievement()
	{
		$data['achievement'] = trim_post('achievement');
		$data['remarks'] = trim_post('remarks');
		$data['student_id'] = trim_post('st_id');
		return $this->db->insert('student_achievement', $data);
	}

	public function delete_st_achievement()
	{
		$this->db->where('st_achievement_id', trim_post('st_achievement_id'));
		return $this->db->delete('student_achievement');
	}

	public function add_st_sibling()
	{
		$data['sibling_name'] = trim_post('sibling_name');
		$data['sibling_dob'] = trim_post('sibling_dob');
		$data['sibling_qualification'] = trim_post('sibling_qualification');
		$data['sibling_institution'] = trim_post('sibling_institution');
		$data['relation'] = trim_post('relation');
		$data['student_id'] = trim_post('st_id');
		return $this->db->insert('sibling', $data);
	}

	public function delete_st_sibling()
	{
		$this->db->where('sibling_id', trim_post('sibling_id'));
		return $this->db->delete('sibling');
	}


	public function add_st_medical_condition()
	{
		$data['condition_name'] = trim_post('condition_name');
		$data['start_date'] = trim_post('start_date');
		$data['end_date'] = trim_post('end_date');
		$data['current_status'] = trim_post('current_status');
		$data['remarks'] = trim_post('remarks');
		$data['student_id'] = trim_post('st_id');
		return $this->db->insert('student_condition', $data);
	}

	public function update_st_medical_condition()
	{
		$data['condition_name'] = trim_post('condition_name');
		$data['start_date'] = trim_post('start_date');
		$data['end_date'] = trim_post('end_date');
		$data['current_status'] = trim_post('current_status');
		$data['remarks'] = trim_post('remarks');
		$this->db->where('st_condition_id', trim_post('id'));
		return $this->db->update('student_condition', $data);
	}

	public function delete_st_medical_condition()
	{
		$this->db->where('st_condition_id', trim_post('st_condition_id'));
		return $this->db->delete('student_condition');
	}

	public function get_class_teacher($section_id)
	{
		$this->db->select('CONCAT(e.first_name," ",e.middle_name," ",e.last_name) as teacher');
		$this->db->join('employee e', 'e.employee_id = s.class_teacher_id');
		$query = $this->db->get('section s');
		if($query->num_rows() > 0){
			return $query->row()->teacher;
		}
		return '';
	}

	public function get_st_feedback($st_id,$class_days_id)
	{
		$this->db->where('student_id', $st_id);
		$this->db->where('class_days_id', $class_days_id);
		$query = $this->db->get('st_comment');
		if($query->num_rows() > 0){
				foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return NULL;

	}

	public function get_feedback_date($from_date, $to_date, $employee_id)
	{
		$this->db->select('stc.*, CONCAT(s.st_fname," ",st_mname," ",st_lname) st_fullname');
		$this->db->where("date(comment_date) BETWEEN '$from_date' AND '$to_date'");
		$this->db->where('stc.user_id', $employee_id);
		//$this->db->where('class_days_id', $class_days_id);
		$this->db->join('student s', 's.student_id = stc.student_id');
		$query = $this->db->get('st_comment stc');
		if($query->num_rows() > 0){
				foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return NULL;

	}

	public function get_st_feedback_sub($st_id,$subject_id)
	{
		$this->db->join('class_days cd', 'cd.class_days_id = sc.class_days_id');
		$this->db->where('sc.student_id', $st_id);
		$this->db->where('cd.subject_id', $subject_id);
		$query = $this->db->get('st_comment sc');
		if($query->num_rows() > 0){
				foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return NULL;

	}

	public function delete_st_feedback($comment_id)
	{
		$this->db->where('comment_id', $comment_id);
		return $this->db->delete('st_comment');
	}
}

/* End of file ajax_model.php */
/* Location: ./application/modules/pages/models/ajax_model.php */