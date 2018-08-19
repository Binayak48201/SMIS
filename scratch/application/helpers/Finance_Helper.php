<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

if(!function_exists('st_prev_payment'))
{
    function st_prev_payment($st_id)
    {
      $ci=& get_instance();
      $ci->load->database(); 

      $ci->db->select("*");
      $ci->db->from("student_prev_payment");
      $ci->db->where("ST_ID",$st_id);
      $q=$ci->db->get();
      if($q->num_rows() > 0)
      {
        return $q->row();
      }
      return NULL;
    }   
}


if(!function_exists('fine_calculate'))
{
    function fine_calculate($days,$fine_rate)
    {
      $total_fine = 0;
      if($days > 0 )
      {
        if($days <=7 )
        {
          $total_fine += $days*$fine_rate['7'];
          $days = 0;
        }
        else if($days > 7)
        {
          $days -=7 ;
          $total_fine += 7*$fine_rate['7'];

          if($days<=23)
          {
            $total_fine += $days*$fine_rate['30'];
          }
          else
          {
            $total_fine += 23*$fine_rate['30'];
            $days -=23 ;
            $total_fine += $days*$fine_rate['1500'];
          }
        }
      }
      return $total_fine;
    }   
}

if ( ! function_exists('get_db_config'))
{
  function get_db_config()
  {
    static $db;
    if (empty($db))
    {
      $file_path = APPPATH.'config/database.php';
      $found = FALSE;
      if (file_exists($file_path))
      {
        $found = TRUE;
        require($file_path);
      }
      // Is the config file in the environment folder?
      if (file_exists($file_path = APPPATH.'config/'.ENVIRONMENT.'/database.php'))
      {
        require($file_path);
      }
      elseif (!$found)
      {
        set_status_header(503);
        echo 'The configuration file does not exist.';
        exit();
      }
      // Does the $db array exist in the file?
      if ( ! isset($db) OR ! is_array($db))
      {
        set_status_header(503);
        echo 'Your config file does not appear to be formatted correctly.';
        exit();
      }
    }
    return $db;
  }
}


 if ( ! function_exists('check_connection'))
  {
    function check_connection($db_table)
    {
      $db_data = get_db_config('database');
      $hostname = $db_data[$db_table]['hostname'];
      $username = $db_data[$db_table]['username'];
      $password = $db_data[$db_table]['password'];
      $database = $db_data[$db_table]['database'];
      $con = @mysqli_connect($hostname,$username,$password,$database);
      // Check connection
      if (mysqli_connect_errno())
      {
        $data['stat'] = FALSE;
        $data['msg'] = mysqli_connect_error();
        return $data;
      }
      $data['stat'] = TRUE;
      return $data;
    }
  }




