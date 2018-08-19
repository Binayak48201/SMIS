<?php



defined('BASEPATH') OR exit('No direct script access allowed');



class Evaluation_model extends CI_Model {



	public function add_comment()

	{

		$data['student_id'] = trim_post('st_id');

		$data['comments'] = trim_post('comment');

		$data['class_days_id'] = trim_post('class_days_id');

		$data['parent_contact_required'] = trim_post('paren_contact_req');

		$data['parent_contacted'] = trim_post('paren_contacted');

		$data['user_id'] = $this->session->userdata('smis_profile_id');

		$data['comment_type'] = trim_post('comment_type');

		return $this->db->insert('st_comment', $data);

	}



	public function get_st_evaluated($opt_id,$type_id,$st_id,$exam_id,$sub_section)

	{

		if($opt_id == 1){

		

			$this->db->where('section_id', $sub_section);

			$this->db->where('exam_id', $exam_id);

			$this->db->where('student_id', $st_id);

			$this->db->where('evaluation_type_id', $type_id);

			$result = $this->db->get('student_evaluation');

			if($result->num_rows() > 0)

			{

				return $result->row();

			}

			return NULL;

		}

		else if($opt_id == 2){

			$this->db->where('section_id', $sub_section);

			$this->db->where('exam_id', $exam_id);

			$this->db->where('student_id', $st_id);

			$this->db->where('evaluation_type_id', $type_id);

			$result = $this->db->get('parent_evaluation');

			if($result->num_rows() > 0)

			{

				return $result->row();

			}

			return NULL;

		}

		else if($opt_id == 3){

			$this->db->where('subject_id', $sub_section);

			$this->db->where('exam_id', $exam_id);

			$this->db->where('student_id', $st_id);

			$this->db->where('evaluation_type_id', $type_id);

			$result = $this->db->get('subject_evaluation');

			//print_e($this->db->last_query());

			if($result->num_rows() > 0)

			{

				return $result->row();

			}

			return NULL;

		}

	}



	public function insert_subject_evaluation()

	{

		$data['student_id'] = trim_post('st_id');

		$data['subject_id'] = trim_post('subject_id');

		$data['exam_id'] = trim_post('exam_id');

		$evaluations = unserialize(trim_post('opt_eval'));

		$data['user_id'] = $this->session->userdata('smis_profile_id');

		foreach ($evaluations as $evaluation) {

			$data['evaluation_type_id'] = $evaluation;

			$data['evaluation_id'] = trim_post('type_'.$evaluation);

			$data['remarks'] = trim_post('remark_'.$evaluation);

		 	$q = $this->db->insert('subject_evaluation', $data);

		}

		return $q;

	}



	public function update_subject_evaluation()

	{

		$this->db->where('student_id', trim_post('st_id'));

		$this->db->where('subject_id', trim_post('subject_id'));

		$this->db->where('exam_id', trim_post('exam_id'));

		$evaluations = unserialize(trim_post('opt_eval'));

		$data['user_id'] = $this->session->userdata('smis_profile_id');

		foreach ($evaluations as $evaluation) {

			$this->db->where('evaluation_type_id', $evaluation);

			$data['evaluation_id'] = trim_post('type_'.$evaluation);

			$data['remarks'] = trim_post('remark_'.$evaluation);

		 	$q = $this->db->update('subject_evaluation', $data);

		}

		return $q;

	}



	public function insert_student_evaluation()

	{

		$data['student_id'] = trim_post('st_id');

		$data['section_id'] = trim_post('section_id');

		$data['exam_id'] = trim_post('exam_id');

		$evaluations = unserialize(trim_post('opt_eval'));

		$data['user_id'] = $this->session->userdata('smis_profile_id');

		foreach ($evaluations as $evaluation) {

			$data['evaluation_type_id'] = $evaluation;

			$data['evaluation_id'] = trim_post('type_'.$evaluation);

			$data['remarks'] = trim_post('remark_'.$evaluation);

		 	$q = $this->db->insert('student_evaluation', $data);

		}

		return $q;

	}



	public function update_student_evaluation()

	{

		$this->db->where('student_id', trim_post('st_id'));

		$this->db->where('section_id', trim_post('section_id'));

		$this->db->where('exam_id', trim_post('exam_id'));

		$evaluations = unserialize(trim_post('opt_eval'));

		$data['user_id'] = $this->session->userdata('smis_profile_id');

		foreach ($evaluations as $evaluation) {

			$this->db->where('evaluation_type_id', $evaluation);

			$data['evaluation_id'] = trim_post('type_'.$evaluation);

			$data['remarks'] = trim_post('remark_'.$evaluation);

		 	$q = $this->db->update('student_evaluation', $data);

		}

		return $q;

	}



	public function insert_parent_evaluation()

	{

		$data['student_id'] = trim_post('st_id');

		$data['section_id'] = trim_post('section_id');

		$data['exam_id'] = trim_post('exam_id');

		$evaluations = unserialize(trim_post('opt_eval'));

		$data['user_id'] = $this->session->userdata('smis_profile_id');

		foreach ($evaluations as $evaluation) {

			$data['evaluation_type_id'] = $evaluation;

			$data['evaluation_id'] = trim_post('type_'.$evaluation);

			$data['remarks'] = trim_post('remark_'.$evaluation);

		 	$q = $this->db->insert('parent_evaluation', $data);

		}

		//print_e($data);

		//exit('test');

		return $q;

	}



	public function update_parent_evaluation()

	{

		$this->db->where('student_id', trim_post('st_id'));

		$this->db->where('section_id', trim_post('section_id'));

		$this->db->where('exam_id', trim_post('exam_id'));

		$evaluations = unserialize(trim_post('opt_eval'));

		$data['user_id'] = $this->session->userdata('smis_profile_id');

		foreach ($evaluations as $evaluation) {

			$this->db->where('evaluation_type_id', $evaluation);

			$data['evaluation_id'] = trim_post('type_'.$evaluation);

			$data['remarks'] = trim_post('remark_'.$evaluation);

		 	$q = $this->db->update('parent_evaluation', $data);

		}

		return $q;

	}



	public function insert_terminal_comment()

	{

		$data['student_id'] = trim_post('st_id');

		$data['section_id'] = trim_post('section_id');

		$data['terminal_id'] = trim_post('exam_id');

		$data['user_id'] = $this->session->userdata('smis_profile_id');

		$data['comment'] = trim_post('comment');

		$q = $this->db->insert('terminal_comment', $data);

		return $q;

	}



	public function update_terminal_comment()

	{

		$this->db->where('student_id', trim_post('st_id'));

		$this->db->where('section_id', trim_post('section_id'));

		$this->db->where('terminal_id', trim_post('exam_id'));

		$data['user_id'] = $this->session->userdata('smis_profile_id');

		$data['comment'] = trim_post('comment');

		$q = $this->db->update('terminal_comment', $data);

		return $q;

	}



	public function st_terminal_comment($st_id,$terminal_id,$section_id)

	{

		$this->db->select('comment');

		$this->db->from('terminal_comment');

		$this->db->where('student_id', $st_id);

		$this->db->where('section_id', $section_id);

		$this->db->where('terminal_id', $terminal_id);

		$result = $this->db->get();

			if($result->num_rows() > 0)

			{

				return $result->row()->comment;

			}

			return NULL;

	}



	public function get_st_evaluation_head($info)

	{

		$this->db->where('s.section_id', $info->section_id);			

		$this->db->join('section s', 's.section_id = se.section_id');

		$this->db->join('exam e', 'e.exam_id = se.exam_id');

		$this->db->group_by('e.numeric_value');

		$results = $this->db->get('student_evaluation se');

		if($results->num_rows() > 0)

		{

			foreach ($results->result() as $row)

			{

				$data[] = $row;

			}

			return $data;

		}

		return NULL;

	}

	

	public function get_pt_evaluation_head($info)

	{

		$this->db->where('s.section_id', $info->section_id);		

		$this->db->join('section s', 's.section_id = se.section_id');

		$this->db->join('exam e', 'e.exam_id = se.exam_id');

		$this->db->group_by('e.numeric_value');

		$results = $this->db->get('parent_evaluation se');

		if($results->num_rows() > 0)

		{

			foreach ($results->result() as $row)

			{

				$data[] = $row;

			}

			return $data;

		}

		return NULL;

	}

	

	public function get_sst_evaluation_head($info)

	{

		//print_e($info->section_id);

		//$this->db->where('s.batch', $info->batch);

		$this->db->where('s.section_id', $info->section_id);		

		$this->db->join('exam e', 'e.exam_id = se.exam_id');

		$this->db->join('section s', 's.section_id = e.section_id');

		$this->db->join('subject sb', 'sb.subject_id = e.subject_id');

		$this->db->group_by('e.exam_id,e.subject_id');

		$results = $this->db->get('subject_evaluation se');

		if($results->num_rows() > 0)

		{

			foreach ($results->result() as $row)

			{

				$data[] = $row;

			}

			return $data;

		}

		return NULL;

	}



	public function st_evaluation($st_id,$exam_id)

	{

		$this->db->where('se.st_id', $st_id);

		$this->db->where('se.exam_id', $exam_id);		

		$this->db->join('section s', 's.section_id = se.section_id');

		$this->db->join('exam e', 'e.exam_id = se.exam_id');

		$results = $this->db->get('student_evaluation se');

		if($results->num_rows() > 0)

		{

			foreach ($results->result() as $row)

			{

				$data[] = $row;

			}

			return $data;

		}

		return NULL;

	}

}



/* End of file Evaluation_model.php */

/* Location: ./application/modules/pages/models/profile/Evaluation_model.php */