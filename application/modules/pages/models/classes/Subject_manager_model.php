<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Subject_manager_model extends CI_Model {

	public function get_subjects()
	{
		$this->db->order_by('subject_id', 'desc');
		//$this->db->order_by('added_batch , grade', 'desc');
		$query = $this->db->get('subject');
		if($query->num_rows() > 0){
			foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return NULL;
	}

	public function get_subject_opt($batch, $grade)
	{
		$this->db->order_by('subject_name', 'desc');
		$this->db->where('added_batch', $batch);
		$this->db->where('grade', $grade);
		$query = $this->db->get('subject');
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
		$data['added_batch'] = trim_post('batch');
		$data['grade'] = trim_post('grade');
		$data['subject_name'] = trim_post('subject_name');
		$data['full_marks'] = trim_post('full_mark');
		$data['pass_marks'] = trim_post('pass_mark');
		if(trim_post('optional') != NULL && trim_post('optional') == 'on')
			$data['subject_type'] = 'OPTIONAL' ;
		else
			$data['subject_type'] = 'COMPULSORY' ;

		return $this->db->insert('subject',$data);
	}

	public function update()
	{
		$data['added_batch'] = trim_post('batch');
		$data['grade'] = trim_post('grade');
		$data['subject_name'] = trim_post('subject_name');
		$data['full_marks'] = trim_post('full_mark');
		$data['pass_marks'] = trim_post('pass_mark');
		if(trim_post('optional') != NULL && trim_post('optional') == 'on')
			$data['subject_type'] = 'OPTIONAL' ;
		else
			$data['subject_type'] = 'COMPULSORY' ;
		$this->db->where('subject_id',trim_post('id'));
		return $this->db->update('subject',$data);
	}

	public function delete($id)
	{
		$this->db->where('subject_id',$id);
		return $this->db->delete('subject');
	}

	public function migrate()
  {
    $this->db->where('grade',trim_post('from_grade'));
    $this->db->where('added_batch',trim_post('from_batch'));
    $q = $this->db->get('subject');
    //print_e($this->db->last_query());
    if ($q->num_rows() > 0) 
    {
      foreach ($q->result() as $row) 
      {
          execute_max(300);
          $data['added_batch'] = trim_post('to_batch');
					$data['grade'] = trim_post('to_grade');
					$data['subject_name'] = $row->subject_name;
					$data['full_marks'] = $row->full_marks;
					$data['pass_marks'] = $row->pass_marks;
					$data['subject_type'] = $row->subject_type;
          $res=$this->db->insert('subject', $data);
      }
      return $data;
    }
    return FALSE;
  }
}

/* End of file subject_model.php */
/* Location: ./application/modules/pages/models/classes/subject_model.php */