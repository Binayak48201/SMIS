<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class lession_plan_model extends CI_Model {

	public function insert()
	{
			$count=count(array_filter(trim_post('ch_id')));
      $ch_id=trim_post('ch_id');
      $main_topic=trim_post('main_topic');
      $sub_topic=trim_post('sub_topic');
      $exam=trim_post('exam');
      for($i=0;$i<$count;$i++)
      {
        execute_max(300);
      	$data['ch_id'] = $ch_id[$i];
      	$data['main_topic'] = $main_topic[$i];
      	$data['sub_topic'] = $sub_topic[$i];
      	$data['target_exam'] = $exam[$i];
      	$data['section_id'] = trim_post('section_id');
      	$data['class_days_id'] = trim_post('subject_id');
      	$res=$this->db->insert('lession_plan', $data);
       // echo'topic='.$topic[$i]."\n";
       // echo'stopic='.$sTopic[$i]."\n";
      }
      return $res;
	}

	public function edit($class_days)
  {
    $this->db->select('lp.*');
    $this->db->from('lession_plan lp');
    $this->db->join('class_days cd', 'cd.class_days_id = lp.class_days_id');
    $this->db->where('lp.class_days_id',$class_days);
    $this->db->order_by('lp.ch_id','asc');
    $q = $this->db->get();
    if ($q->num_rows() > 0) {
      foreach ($q->result() as $row) {
        $data[] = $row;
      }

      return $data;
    }
    return NULL;
  }

  public function get_lesson_plan($class_days)
	{
    $this->db->select('lp.*, e.terminal_name');
    $this->db->from('lession_plan lp');
    $this->db->join('class_days cd', 'cd.class_days_id = lp.class_days_id');
    $this->db->join('exam e', 'e.exam_id = lp.target_exam');
    $this->db->where('lp.class_days_id',$class_days);
		$this->db->order_by('lp.ch_id','asc');
		$q = $this->db->get();
    if ($q->num_rows() > 0) {
      foreach ($q->result() as $row) {
        $data[] = $row;
      }

      return $data;
    }
    return NULL;
	}

  public function check_session_start($class_days_id)
  {
    $this->db->select('class_days');
    $this->db->where('class_days_id', $class_days_id);
    $q =$this->db->get('class_days');
    if ($q->num_rows() > 0) 
    {
      $data=$q->row();
      if($data->class_days > 0)
      {
        return TRUE;
      }
      else
      {
        return FALSE;
      }
    }
    return FALSE;
  }

	public function update($class_day)
	{
		$this->db->where('class_days_id',$class_day);
		if($this->db->delete('lession_plan')){
			$count=count(array_filter(trim_post('ch_id')));
      $ch_id=trim_post('ch_id');
      $main_topic=trim_post('main_topic');
      $sub_topic=trim_post('sub_topic');
      $exam=trim_post('exam');
      for($i=0;$i<$count;$i++)
      {
        execute_max(300);
      	$data['ch_id'] = $ch_id[$i];
        $data['main_topic'] = $main_topic[$i];
        $data['sub_topic'] = $sub_topic[$i];
        $data['target_exam'] = $exam[$i];
        $data['section_id'] = trim_post('section_id');
        $data['class_days_id'] = $class_day;
      	$res=$this->db->insert('lession_plan', $data);
       // echo'topic='.$topic[$i]."\n";
       // echo'stopic='.$sTopic[$i]."\n";
      }
      return $res;
		}
		return FALSE;
			
	}

  public function migrate()
  {
    $this->db->where('class_days_id',$this->input->post('from_subject_id'));
    $q = $this->db->get('lession_plan');
    if ($q->num_rows() > 0) 
    {
      foreach ($q->result() as $row) 
      {
          execute_max(300);
          $data['ch_id']=$row->ch_id;
          $data['main_topic']=$row->main_topic;
          $data['sub_topic']=$row->sub_topic;
          //$data['activity_txt']=$row->activity_txt;
          $data['section_id']=$this->input->post('to_section_id');
          $data['class_days_id']=$this->input->post('to_subject_id');
          $res=$this->db->insert('lession_plan', $data);
      }
      return $data;
    }
    return FALSE;
  }

  public function insert_activity($activity_file='')
  {

    //$chk=$this->get_topic($this->input->post('topic_id'));
    
    $data['activity_file']=$activity_file;
    $data['class_days_id']=trim_post('subject_id');
    $data['topic_id']=trim_post('topic_id');
    $data['teaching_material']=trim_post('teaching_material');
    $data['activity_title']=trim_post('activity_title');
    $data['activity_key']=trim_post('activity_key');
    $data['activity_objective']=trim_post('activity_objective');
    $data['activity_date']=trim_post('activity_date');    
    $data['assignments']=trim_post('assignments');
    $data['home_assignments']=trim_post('home_assignments');
    $data['standard']=trim_post('standard');    
   
    return $this->db->insert('lesson_activity', $data);
  }

  public function delete_activity($activity_id)
  {
    $this->db->where('activity_id', $activity_id);
    return $this->db->delete('lesson_activity');
  }

  public function get_topic($id)
  {
    $this->db->where('id',$id);
    $q=$this->db->get('lession_plan');
    return $q->row();
  }

  public function get_stat($class_day)
  {
    $this->db->select('
      sum(`period`) AS planned,
      Sum(Case When t_stat = 1 Then period Else 0 End)covered
      ');
    $this->db->from('lession_plan');
    $this->db->where('class_days_id',$class_day);
    $q = $this->db->get();
    if ($q->num_rows() > 0) {
      return $q->row();
    }
    return NULL;
  }

  public function update_setting()
  {
    $data['lession_plan']=$this->input->post('lession_plan');
    $this->db->where('id',1);
    return $this->db->update('theme_option', $data);
  }

  public function list_all()
  {
    $this->db->select('c.course_name,s.section_name,cd.class_days_id,cd.program_id');
    $this->db->from('lession_plan lp');
    $this->db->join('class_days cd', 'cd.class_days_id = lp.class_days_id');
    $this->db->join('course c', 'c.course_id = cd.course_id');
    $this->db->join('section s', 's.section_id = cd.section_id');
    $this->db->join('program p', 's.program_id = cd.program_id');
    $this->db->group_by('lp.class_days_id');
    $this->db->order_by('lp.section_id','desc');
    $q = $this->db->get();
    if ($q->num_rows() > 0) {
      foreach ($q->result() as $row) {
        $data[] = $row;
      }

      return $data;
    }
    return NULL;
  }

  public function get_standards()
  {
    $this->db->order_by('standard_name', 'asc');
    $q = $this->db->get('activity_standards');
    if ($q->num_rows() > 0) {
      foreach ($q->result() as $row) {
        $data[] = $row;
      }

      return $data;
    }
    return NULL;
  }

  public function insert_standard()
  {
    $data['standard_name'] = trim_post('standard');
    $data['status'] = 1;
    return $this->db->insert('activity_standards', $data);
  }

  public function update_standard()
  {
    $data['standard_name'] = trim_post('standard');
    $this->db->where('id',trim_post('id'));
    return $this->db->update('activity_standards', $data);
  }

  public function delete_standard($id)
  {
    $this->db->where('id', $id);
    return $this->db->delete('activity_standards');
  }

  public function get_activities($class_days_id)
  {
    $this->db->where('class_days_id', $class_days_id);
    $q = $this->db->get('lesson_activity');
    if ($q->num_rows() > 0) {
      foreach ($q->result() as $row) {
        $data[] = $row;
      }

      return $data;
    }
    return NULL;
  }

  public function get_activity_detail($id)
  {
    $this->db->where('topic_id', $id);
    $q = $this->db->get('lesson_activity');
    if ($q->num_rows() > 0) {
      foreach ($q->result() as $row) {
        $data[] = $row;
      }
      return $data;
    }
    return NULL;
  }
  /*public function get_info_by_topic($id)
  {
    $this->db->where('lp.id', $id);
    $this->db->join('class_days cd', 'cd.class_days_id = lp.class_days_id');
    $this->db->join('Table', 'table.column = table.column', 'left');
    $this->db->get('lession_plan lp');
  }*/
}


/* End of file lession_plan_model.php */
/* Location: ./application/modules/pages/models/classes/lession_plan_model.php */