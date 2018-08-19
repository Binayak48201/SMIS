<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mis_model extends CI_Model {

	public function get_program()
	{
		$this->db->order_by('programlevel_id');
		$this->db->where('status', 1);
		$q = $this->db->get('program');
		if($q->num_rows() > 0)
		{
			foreach ($q->result() as $row) 
			{
				$data[] = $row;
			}
			return $data;
		}
		return NULL;
	}

	public function get_program_batch($program_id)
	{
		$this->db->where('program_id', $program_id);
		$this->db->where('status', 1);
		$this->db->order_by('batch_id','desc');
		$this->db->group_by('batch_id');
		$q = $this->db->get('section');
		if($q->num_rows() > 0)
		{
			foreach ($q->result() as $row) 
			{
				$data[] = $row;
			}
			return $data;
		}
		return NULL;
	}

	public function get_batch()
	{
		$this->db->where('status', 1);
		$this->db->order_by('batch_id','desc');
		$this->db->group_by('batch_id');
		$q = $this->db->get('section');
		if($q->num_rows() > 0)
		{
			foreach ($q->result() as $row) 
			{
				$data[] = $row;
			}
			return $data;
		}
		return NULL;
	}


	public function get_program_info($program_id)
	{
		$this->db->where('program_id', $program_id);
		$q = $this->db->get('program');
		if($q->num_rows() > 0)
		{
			return $q->row();
		}
		return NULL;
	}

	public function get_sections($sort_name = '')
	{
		$this->db->where('status', 1);
		if($sort_name == '')
		{
			$this->db->order_by('passed_out,section_id');
		}
		else
		{
			$this->db->order_by('section_name');
		}
		$q = $this->db->get('section');
		if($q->num_rows() > 0)
		{
			foreach ($q->result() as $row) 
			{
				$data[] = $row;
			}
			return $data;
		}
		return NULL;
	}

	public function get_active_section_st($batch_id='')
	{
		$this->db->select('s.*,p.program_name,count(sp.st_id) as total_st');
		$this->db->join('program p', 'p.program_id = s.program_id');
		$this->db->join('student_profile sp', 'sp.section_id = s.section_id');
		$this->db->where('s.status', 1);
		if(	$batch_id=='' || $batch_id == 'ALL')
		{
			$this->db->where('s.passed_out', 0);
		}
		else
		{
			$this->db->where('s.batch_id', $batch_id);
		}
		$this->db->where('sp.status !=', 'dropped');
		$this->db->where('sp.pu_scholar', 0);
		$this->db->group_by('s.section_id');
		$this->db->order_by('s.batch_id,s.program_id,s.section_name');
		
		$q = $this->db->get('section s');
		if($q->num_rows() > 0)
		{
			foreach ($q->result() as $row) 
			{
				$data[] = $row;
			}
			return $data;
		}
		return NULL;
	}

	public function get_section_info($section_id)
	{
		$this->db->where('section_id', $section_id);
		$q = $this->db->get('section');
		if($q->num_rows() > 0)
		{
			return $q->row();
		}
		return NULL;
	}

	public function get_student($section_id)
	{
		$this->db->select('CONCAT(sp.st_fname," ",st_mname," ",st_lname) as st_fullname, sp.st_roll_no, sp.st_id, sp.program_id, sp.batch_id, sp.pu_scholar');
		$this->db->from('student_profile sp');
		$this->db->where('section_id', $section_id);
		$this->db->where('status !=', 'dropped');
		$this->db->where('pu_scholar =', '0');
		$this->db->order_by('sp.st_fname');
		$q = $this->db->get();
		if($q->num_rows() > 0)
		{
			foreach ($q->result() as $row) 
			{
				$data[] = $row;
			}
			return $data;
		}
		return NULL;
	}

	public function get_student_batch($program_id, $batch_id)
	{
		$this->db->select('CONCAT(sp.st_fname," ",st_mname," ",st_lname) as st_fullname, sp.st_roll_no, sp.st_id, sp.program_id, sp.batch_id, sp.pu_scholar, sp.pu_regno, sp.st_dob, s.section_name');
		$this->db->from('student_profile sp');
		$this->db->join('section s', 's.section_id = sp.section_id');
		$this->db->where('sp.program_id', $program_id);
		$this->db->where('sp.batch_id', $batch_id);
		$this->db->where('sp.status !=', 'dropped');
		$this->db->order_by('sp.st_fname');
		$q = $this->db->get();
		if($q->num_rows() > 0)
		{
			foreach ($q->result() as $row) 
			{
				$data[] = $row;
			}
			return $data;
		}
		return NULL;
	}

	public function get_st_info($st_id='')
	{
		//$mis_db = $this->load->database('mis', TRUE);
		$this->db->select('sp.*, p.program_name, s.section_name');
		$this->db->where('sp.st_id', $st_id);
		$this->db->join('program p', 'p.program_id = sp.program_id');
		$this->db->join('section s', 's.section_id = sp.section_id');
		$q = $this->db->get('student_profile sp');
		if($q->num_rows() > 0)
		{
			return $q->row();
		}
		return NULL;
	}
}

/* End of file mis_model.php */
/* Location: ./application/modules/pages/models/mis_model.php */