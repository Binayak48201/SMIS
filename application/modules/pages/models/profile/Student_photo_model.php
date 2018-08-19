<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Student_photo_model extends CI_Model {

	public function verify()
	{
		$zip = new ZipArchive;
		$res = $zip->open($_FILES['student_photo']['tmp_name']);
		if ($res) 
		{
	    $i=0;
	    while(!empty($zip->statIndex($i)['name']))
	    {
				$filename=$zip->statIndex($i)['name'];
				$file_arr=explode('.',$filename);
				$ext=end($file_arr);
				$st_roll=chop($filename,".$ext");
				$this->db->select('u.USER_NAME');
				$this->db->from('student s');
				$this->db->join('users u', 'u.PROFILE_ID = s.student_id');
				$this->db->where('u.USER_NAME',$st_roll);
				$q=$this->db->get();
				if($q->num_rows() >=1)
				{
					$data[$i]['name'] = $filename;
					if($ext=='jpg')
					{
						$data[$i]['status'] = "Verified";				
					}
					else
					{
						$data[$i]['status'] = "$filename is not in jpg Format";	
					}
					//$data[$i]['status'] = 'Verified';
				}
				else
				{
					$data[$i]['name'] = $filename;
					if($ext=='jpg')
					{
						$data[$i]['status'] = "Student with roll Number $st_roll does not exist";				
					}
					else
					{
						$data[$i]['status'] = "$filename is not in jpg Format";	
					}
				}
	      $i++;
	    }
			return $data;
		}
	}

}

/* End of file student_photo_model.php */
/* Location: ./application/modules/pages/models/student_info/student_photo_model.php */