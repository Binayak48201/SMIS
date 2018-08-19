<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

if(!function_exists('check_access'))
{
  function check_access($role='')
  {
    $ci=& get_instance();
    $ci->load->database(); 

    if($ci->general->is_logged_in() && $ci->menu_model->is_allowed($role))
    {
      return TRUE; 
    }
    redirect(site_url('login'),'refresh');
    exit;
  }   
}

if(!function_exists('st_restrict'))
{
    function st_restrict($st_id='')
    {
      if($st_id!='')
      {
        $ci=& get_instance();

        if($ci->session->userdata("smis_role")=='student' && $ci->session->userdata("smis_profile_id")!=$st_id)
        {
            redirect(site_url('pages/home'),'refresh');
            exit;
        }
        return TRUE;
      }
    }   
}

if(!function_exists('faculty_class_restrict'))
{
  function teacher_class_restrict($class_days='')
  {
    if($class_days!='')
    {
      $ci=& get_instance();
      $ci->load->database(); 

      $ci->db->select("*");
      $ci->db->from("class_days");
      $ci->db->where("class_days_id",$class_days);
      $q = $ci->db->get();
      if($q->num_rows() > 0)
      {
        $data=$q->row();
        if($ci->session->userdata("smis_role")=='su_admin' || $ci->session->userdata("smis_role")=='teacher' && $ci->session->userdata("smis_profile_id")==$data->employee_id)
        {
          return TRUE;
        }
      }
      redirect(site_url('pages/home'),'refresh');
      exit;
    }
  }   
}


if(!function_exists('print_e'))
{
    function print_e($val='',$exit='')
    {
      echo"<pre>";
      print_r($val);
      echo"</pre>";
      if($exit=='')
      {
        exit();
      }
      
    }   
}

if(!function_exists('download'))
{
  function download($name,$file)
  {
    $file_path=base64_decode($file);
    $data = file_get_contents("./uploads/$file_path"); // Read the file's contents
    $file_info = pathinfo("./uploads/$file_path");      
    force_download($name.'.'.$file_info['extension'], $data); 
  } 
}

if(!function_exists('execute_max'))
{
    function execute_max($limit=10)
    {
      set_time_limit($limit);
    }   
}

if(!function_exists('suffix'))
{
  function suffix($number) 
  {
    $ends = array('th','st','nd','rd','th','th','th','th','th','th');
    if ((($number % 100) >= 11) && (($number%100) <= 13))
        return $number. 'th';
    else
        return $number. $ends[$number % 10];
  }
}

if(!function_exists('set_flash'))
{
  function set_flash($status,$msg) 
  {
    $ci=& get_instance();
    if($status == 'error')
    {
      $ci->session->set_flashdata('error', TRUE);
      $ci->session->set_flashdata('alert_msg', $msg);
      return;
    }
    $ci->session->set_flashdata('error', FALSE);
    $ci->session->set_flashdata('alert_msg', $msg);
    return;
  }
}


if(!function_exists('display_alert'))
{
  function display_alert() 
  {
    $ci=& get_instance();
    if($ci->session->flashdata('error')===TRUE)
    { 
      echo'<div class="alert alert-danger">
            <button class="close" data-close="alert"></button>
            '.$ci->session->flashdata('alert_msg').'
          </div>';
    } 
    else if($ci->session->flashdata('error')===FALSE )
    {
      echo'<div class="alert alert-success">
            <button class="close" data-close="alert"></button>
            '.$ci->session->flashdata('alert_msg').'
          </div>';
    }          
  }
}


if(!function_exists('trim_post'))
{
  function trim_post($name) 
  {
    $ci=& get_instance();
    if(is_array($ci->input->post($name)))
      return $ci->input->post($name);
    return trim($ci->input->post($name));  
  }
}

if(!function_exists('trim_get'))
{
  function trim_get($name) 
  {
    $ci=& get_instance();
    if(is_array($ci->input->get($name)))
      return $ci->input->get($name);
    return trim($ci->input->get($name));  
  }
}

if(!function_exists('get_percent'))
{
  function get_percent($obtain,$total) 
  {
    return round(($obtain/$total)*100);  
  }
}

if(!function_exists('isset_post'))
{
  function isset_post($name) 
  {
    $ci=& get_instance();
    if($ci->input->post($name) != NULL)
      return TRUE;
    return False;  
  }
}

if(!function_exists('delete_file'))
{
  function delete_file($path) 
  {
    $full_path = IMG_UPLOAD_PATH.'/'.$path;
    if($path != '' && file_exists($full_path))
    {
      return unlink($full_path);
    }
    return FALSE;
  }
}

if(!function_exists('file_name_info'))
{
  function file_name_info($value='')
  {
    $all_info = explode('/',$value);
    $info['file_name'] = end($all_info);
    $info['name'] = current(explode('.',$info['file_name']));
    return $info;
  }
}

if(!function_exists('AD_to_BS'))
{
    function AD_to_BS($date='')
    {
      $ci=& get_instance();
      if($date!='')
      {
        $store_time = strtotime($date);
        $new_date = $ci->nepali_calendar->AD_to_BS(date('Y',$store_time),date('m',$store_time),date('d',$store_time));
        return(implode('-', array_filter($new_date)));
      }
      else
      {
        $new_date = $ci->nepali_calendar->AD_to_BS(date('Y'),date('m'),date('d'));
        return(implode('-', array_filter($new_date)));
      }
      
    }   
}

if(!function_exists('teacher_restrict'))
{
    function teacher_restrict($class_days_id='')
    {
      $ci=& get_instance();
      $ci->load->database(); 
      $role_access=array('teacher');
      if($class_days_id!='' && in_array($ci->session->userdata("smis_role"),$role_access))
      {

        $ci->db->select("*");
        $ci->db->from("class_days");
        $ci->db->where("class_days_id",$class_days_id);
        $q=$ci->db->get();
        if($q->num_rows() > 0)
        {
          $data=$q->row();
        }
        if($ci->session->userdata("smis_profile_id")!=$data->employee_id)
        {
          redirect(site_url('pages/home'),'refresh');
          exit;
        }
        return TRUE;
      }
      return FALSE;
    }   
}

if(!function_exists('display_pic_path'))
{
    function display_pic_path($path)
    {
      if(file_exists(IMG_UPLOAD_PATH."/".$path) && $path!='')
      {
      
      return site_url('uploads/'.$path."?dump=".rand());
     
      }
      else
      {
        return site_url('assets/admin/layout2/img/avatar.png');
      
      } 
      
    }   
}

if(!function_exists('current_batch'))
{
    function current_batch()
    {
      $date = explode('-', AD_to_BS());
      return current($date);      
    }   
}

if(!function_exists('check_st_restrict'))
{
  function check_st_restrict($st_id,$batch,$exam,$grade,$opt='')
  {
   
    $ci=& get_instance();
    if($ci->session->userdata("smis_role") == 'student' || $opt == 'check')
    {
      $ci->load->database(); 
      $ci->db->select("*");
      $ci->db->from("marksheet_restrict");
      $ci->db->where("student_id",$st_id);
      $ci->db->where('batch_id', $batch);
      $ci->db->where('exam_id', $exam);
      $ci->db->where('grade', $grade);
      $q=$ci->db->get();
      if($q->num_rows() > 0)
        return TRUE;
      
      return FALSE;
    }
    return FALSE;
  }
}



