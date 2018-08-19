<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Assessment_setting_model extends CI_Model {

	public function add_assessment()
	{
		//print_e($_POST);
		$data['section_id'] = trim_post('section_id');
		$data['assessment_name'] = trim_post('assessment_name');
		$data['numeric_value'] = trim_post('numeric_value');
		//$data['conducted_from'] = trim_post('');
		//$data['conducted_till'] = trim_post('');
		$data['subject_id'] = trim_post('subject_id');
		$data['assessment_mark'] = trim_post('assessment_mark');
		return $this->db->insert('assessment', $data);
	}

	public function get_assessments()
	{
		$this->db->select('e.* , s.section_name, sb.subject_name,s.grade');
		$this->db->from('assessment e');
		$this->db->join('section s', 's.section_id = e.section_id');
		$this->db->join('subject sb', 'sb.subject_id = e.subject_id');
		$this->db->order_by('assessment_id', 'desc');
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

	public function get_assessment_by_id($id)
	{
		$this->db->select('e.*,s.*,sb.*');
		$this->db->from('assessment e');
		$this->db->join('section s', 's.section_id = e.section_id');
		$this->db->join('subject sb', 'sb.subject_id = e.subject_id');
		$this->db->where('e.assessment_id', $id);
		$results = $this->db->get();
		if($results->num_rows() > 0)
		{
			return $results->row();
		}
		return NULL;
	}

	public function update($value='')
	{
		$data['assessment_name'] = trim_post('assessment_name');
		$data['assessment_mark'] = trim_post('assessment_mark');
		$this->db->where('assessment_id', trim_post('id'));
		return $this->db->update('assessment', $data);
	}

	public function delete($id)
	{
		$this->db->where('assessment_id', $id);
		return $this->db->delete('assessment');
	}
}

/* End of file assessment_setting_model.php */
/* Location: ./application/modules/pages/models/exam/assessment_setting_model.php */