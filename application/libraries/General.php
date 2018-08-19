<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class General
{

/**
* CodeIgnitor global
*
* @var string
**/

protected $ci;

/**
* account status ('non_activated',etc....)
*
* @var string
**/
protected $status;

/**
* error message (uses lang file)
*
* @var string
**/

protected $errors=array();

	public function __construct()
	{
	$this->ci =& get_instance();
  //modules::run('dashboard/user_log/log');    
        
	/*$site_info = $this->get_site_setting();
	define('NAME',$site_info['name']);
        define('ADDRESS',$site_info['address']);
        define('IMAGE_PATH',$site_info['image']);		
	define('FEATURES', $site_info['features']);
        define('TEMPLATE', $site_info['template_heading']);
        define('PRICING', $site_info['pricing_heading']);
        define('FEATURES_HEADING', $site_info['features_heading']);
	$user_ip=$this->get_real_ipaddr();
	*/
	
	
	
	}
	
	
	//getting real ip of users
	function get_real_ipaddr()
	{
			if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
			$ip=$_SERVER['HTTP_CLIENT_IP'];
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
	    	$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
		else
			$ip=$_SERVER['REMOTE_ADDR'];

		return $ip;
	
	}
	/**
	author: satis
	desc: global login credentail for admin only
	**/

	function is_logged_in()
	{
		if($this->ci->session->userdata("smis_role") != NULL)
		{
			return $this->ci->session->userdata("smis_logged_in");		
		}
		return FALSE;
	}

	function is_admin($admin)
	{
		if(is_array($admin))
		{			
			if(in_array($this->ci->session->userdata("smis_role"),$admin))
			{
				return TRUE;
			}
		}
		else
		{
			if($this->ci->session->userdata("smis_role") == $admin)
			{
				return TRUE;	
			}
		}
		return FALSE; // if no condition matches
	}
       
	function logout()
	{
		$this->ci->session->destroy();
		/*$this->ci->session->unset_userdata("is_logged_in");
		$this->ci->session->unset_userdata("username");*/
		return true;
	}

  function user_logout()
  {
    $this->ci->session->unset_userdata("user_logged_in");
		$this->ci->session->unset_userdata("user_name");
		$this->ci->session->unset_userdata("user_id");
		return true;
  }
        
  function user_logged_in()
	{
		return $this->ci->session->userdata("user_logged_in");
	}
        
	function date_formate($date ,$format="dS F Y")
	{
		$str_date=strtotime($date);
		$dt_frmt=date($format,$str_date);
		return $dt_frmt;
	}
		
	function clean_url($str, $replace=array(), $delimiter='-') 
	{
		if( !empty($replace) ) {$str = str_replace((array)$replace, ' ', $str);}

		$clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
		$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
		$clean = strtolower(trim($clean, '-'));
		$clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

		return $clean;
	}

	/*
		used to display strings as desired length
	*/
	public function display($content,$length=0,$opt=0)
	{
		if(isset($content))
		{
			if( $length==0 && $opt==0)
			{
				return html_entity_decode(stripslashes($content));
			}
			elseif ($length!=0) 
			{
				$newsstringCut = substr(html_entity_decode(stripslashes($content)),0,$length);
				$newsstring = substr($newsstringCut, 0, strrpos($newsstringCut,' ')).'...';
				return (strip_tags($newsstring));
			}
			else
			{
				return html_entity_decode(stripslashes(strip_tags($content)));
			}
		}
		else
		{
			return NULL;
		}
	}

	/*
		used to upload any file to definied location 
	*/
	public function upload($userfile,$file_ext=0,$name='',$folder='')
	{
		//checking for user define upload path 
		if($folder==''){
			$config['upload_path'] = IMG_UPLOAD_PATH;
		}
		else{			
			$config['upload_path'] = IMG_UPLOAD_PATH.'/'.$folder;
		}

		// checking the file type to be uploaded
		if($file_ext==0){
			$config['max_size'] = 0;
			$config['allowed_types'] = '*';
		}
		else if($file_ext!=''){
			$config['max_size'] = 2000*5;
			$config['allowed_types'] = $file_ext;
		}
	
		// chcekin the user defined file name
		if($name=='')
		{
			$config['encrypt_name'] = TRUE;
		}
		else
		{
			$config['encrypt_name'] = FALSE;
			$config['file_name'] = $name;
		}
		$this->ci->load->library('upload', $config);
		//$this->ci->load->library('image_lib');
		$this->ci->upload->initialize($config);

		if (!$this->ci->upload->do_upload($userfile))
		{
			$response['status']=FALSE;
			$response['result'] = $this->ci->upload->display_errors();
		}
		else
		{
			$img_data = $this->ci->upload->data();

			$response['status']=TRUE;
			if($folder=='')
			{
				$response['result']=$img_data['file_name'];
			}
			else{			
				$response['result']=$folder.'/'.$img_data['file_name'];
			}
		}
		return $response;
		//$this->output->set_content_type('application/json')->set_output(json_encode($response));
	}

	/*
	function to upload zip file and extract to user defined path and delete the uploaded zip file
	*/
	public function extract_zip($userfile,$to='')
	{
		if($to==''||$to=='student')
		{
			$config['upload_path'] = IMG_UPLOAD_PATH.'/student_photo/';
		}
		else
		{
			$config['upload_path'] = IMG_UPLOAD_PATH.'/employee_photo/';
		}
		$config['allowed_types'] = 'zip';																		// defining the file types to be uploaded
		$config['max_size'] = '';
		$this->ci->load->library('upload', $config);
		if (!$this->ci->upload->do_upload($userfile))
		{
			$response['error'] = TRUE;
			$response['message'] = $this->ci->upload->display_errors();
		}
		else
		{
			$data = array('upload_data' => $this->ci->upload->data());
			$zip = new ZipArchive;
			$file = $data['upload_data']['full_path'];
			chmod($file,0777);																								//file permession setup
			if ($zip->open($file) === TRUE) 
			{
	     	$zip->extractTo($config['upload_path']);
	     	$zip->close();
	     	$response['error'] = FALSE;
	     	$response['message']='FILE Extracted Successfully';
	     	unlink($file); 																								//delete uploaded zip file after extraction
			} 
			else 
			{
		    $response['error'] = TRUE;
				$response['message'] ='FILE Extraction Error, Try Again.';
			}
		}
		return $response;
	}
	/*
		RETURNS ESCAPED TEXT
	*/
	public function escape($text)
	{
		return html_entity_decode(stripslashes(strip_tags($text)));
		//return $text;
	}


}
?>
