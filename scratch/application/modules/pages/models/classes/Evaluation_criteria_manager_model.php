<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Evaluation_criteria_manager_model extends CI_Model {

	public function get_evaluation_type($opt_id)
	{
		if($opt_id == 1){
			$result = $this->db->get('ct_evaluation_type');
		}
		else if($opt_id == 2){
			$result = $this->db->get('ct_parent_evaluation_type');
		}
		else if($opt_id == 3){
			$result = $this->db->get('subject_evaluation_type');
		}
		if($result->num_rows() > 0)
		{
			foreach ($result->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return NULL;
	}

	public function add_type($opt_id)
	{
		if($opt_id == 1){
			$data['evaluation_type_name'] = trim_post('type_name');
			return $this->db->insert('ct_evaluation_type', $data);
		}
		else if($opt_id == 2){
			$data['evaluation_type_name'] = trim_post('type_name');
			return $this->db->insert('ct_parent_evaluation_type', $data);
		}
		else if($opt_id == 3){
			$data['evaluation_type_name'] = trim_post('type_name');
			return $this->db->insert('subject_evaluation_type', $data);
		}
		
	}

	public function delete_type($opt_id, $id)
	{
		if($opt_id == 1){
			$this->db->where('evaluation_type_id', $id);
			return $this->db->delete('ct_evaluation_type');
		}
		else if($opt_id == 2){
			$this->db->where('evaluation_type_id', $id);
			return $this->db->delete('ct_parent_evaluation_type');
		}
		else if($opt_id == 3){
			$this->db->where('evaluation_type_id', $id);
			return $this->db->delete('subject_evaluation_type');
		}
	}
	
	public function add_option($opt_id)
	{
		if($opt_id == 1){
			$data['evaluation_option_name'] = trim_post('option_name');
			$data['evaluation_type_id'] = trim_post('type_id');
			return $this->db->insert('ct_evaluation_option', $data);
		}
		else if($opt_id == 2){
			$data['evaluation_option_name'] = trim_post('option_name');
			$data['evaluation_type_id'] = trim_post('type_id');
			return $this->db->insert('ct_parent_evaluation_option', $data);
		}
		else if($opt_id == 3){
			$data['evaluation_option_name'] = trim_post('option_name');
			$data['evaluation_type_id'] = trim_post('type_id');
			return $this->db->insert('subject_evaluation_option', $data);
		}
	}

	public function update_option($opt_id,$id)
	{
		if($opt_id == 1){
			$data['evaluation_option_name'] = trim_post('option_name');
			$this->db->where('evaluation_option_id', $id);
			return $this->db->update('ct_evaluation_option', $data);
		}
		else if($opt_id == 2){
			$data['evaluation_option_name'] = trim_post('option_name');
			$this->db->where('evaluation_option_id', $id);
			return $this->db->update('ct_parent_evaluation_option', $data);
		}
		else if($opt_id == 3){
			$data['evaluation_option_name'] = trim_post('option_name');
			$this->db->where('evaluation_option_id', $id);
			return $this->db->update('subject_evaluation_option', $data);
		}
		
	}

	public function delete_option($opt_id,$id)
	{
		if($opt_id == 1){
			$this->db->where('evaluation_option_id', $id);
			return $this->db->delete('ct_evaluation_option');
		}
		else if($opt_id == 2){
			$this->db->where('evaluation_option_id', $id);
			return $this->db->delete('ct_parent_evaluation_option');
		}
		else if($opt_id == 3){
			$this->db->where('evaluation_option_id', $id);
			return $this->db->delete('subject_evaluation_option');
		}

	}

	public function get_evaluation_option($opt_id,$type_id)
	{
		if($opt_id == 1){
			$this->db->order_by('evaluation_option_name', 'Asc');
			$this->db->where('evaluation_type_id', $type_id);
			$result = $this->db->get('ct_evaluation_option');
			if($result->num_rows() > 0)
			{
				foreach ($result->result() as $row) {
					$data[] = $row;
				}
				return $data;
			}
			return NULL;
		}
		else if($opt_id == 2){
			$this->db->order_by('evaluation_option_name', 'Asc');
			$this->db->where('evaluation_type_id', $type_id);
			$result = $this->db->get('ct_parent_evaluation_option');
			if($result->num_rows() > 0)
			{
				foreach ($result->result() as $row) {
					$data[] = $row;
				}
				return $data;
			}
			return NULL;
		}
		else if($opt_id == 3){
			$this->db->order_by('evaluation_option_name', 'Asc');
			$this->db->where('evaluation_type_id', $type_id);
			$result = $this->db->get('subject_evaluation_option');
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

	
}

/* End of file appraisal_manager_model.php */
/* Location: ./application/modules/pages/models/classes/appraisal_manager_model.php */