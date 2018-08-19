<?php



defined('BASEPATH') OR exit('No direct script access allowed');



class Attendance_model extends CI_Model {



	public function isset_students_attendance($class_days_id,$exam_id)

	{

		$this->db->select('s.student_id');

		$this->db->from('student s');

		$this->db->join('class_days cd', 'cd.section_id = s.class_id');

		$this->db->join('class_attendance ca', 'ca.student_id = s.student_id');

		$this->db->where('cd.class_days_id', $class_days_id);

		$this->db->where('ca.terminal_id', $exam_id);

		$this->db->order_by('s.current_roll');

		$result = $this->db->get();

		if($result->num_rows() > 0)

		{

			return TRUE;

		}

		return FALSE;

	}



	public function students_with_attandance($class_days_id,$exam_id)

	{

		$state = $this->isset_students_attendance($class_days_id,$exam_id);

		$select = "s.student_id,s.st_fname,s.st_mname,s.st_lname,s.current_roll, cd.*";

		

		$this->db->from('student s');

		$this->db->join('class_days cd', 'cd.section_id = s.class_id');

		$this->db->where('cd.class_days_id', $class_days_id);

		if($state)

		{

			$select .= ",ca.*";

			$this->db->join('class_attendance ca', 'ca.student_id = s.student_id');

			$this->db->where('ca.terminal_id', $exam_id);

		}

		$this->db->select($select);
		$this->db->where('s.dropped_out !=1');

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



	public function add_attendance($class_days_id) {

    foreach (unserialize(trim_post('st_ids')) as $student_id) {

      $data['student_id'] = $student_id;

      $data['terminal_id'] = trim_post('terminal_id');

      $data['total_class'] = trim_post($student_id."_total_class");

      $data['present_class'] = trim_post($student_id."_present_days");

      $data['absent_class'] = intval($data['total_class'])-intval($data['present_class']);

      $data['class_days_id'] = $class_days_id;

     $sql = $this->db->insert('class_attendance', $data);

    }

    return $sql;

  }



  public function update_attendance($class_days_id) {

    foreach (unserialize(trim_post('st_ids')) as $student_id) {

      $this->db->where('student_id', $student_id);

      $this->db->where('class_days_id', $class_days_id);

      $this->db->where('terminal_id', trim_post('terminal_id'));

      $data['total_class'] = trim_post($student_id."_total_class");

      $data['present_class'] = trim_post($student_id."_present_days");

      $data['absent_class'] = intval($data['total_class'])-intval($data['present_class']);

      $sql = $this->db->update('class_attendance', $data);

    }

    return $sql;

  }



}



/* End of file attendance_model.php */

/* Location: ./application/modules/pages/models/classes/attendance_model.php */