<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
    modules::run('dashboard/user_log/log');
    if(!check_access())     
		{
			redirect(site_url('login'),'refresh');
			exit;
		}

		$this->load->model('find_model');
	}

	public function find_student()
	{
    if($this->input->post('search')!=NULL && $this->input->post('search')=='SEARCH')
    {
    	$data['ajax_script'] = array(
    		'0'=>"$('.more-action').click(function(){
    			const id = $(this).attr('data-id');
    			$('#'+id).toggleClass('hide');
    		});" 
  		);
  		$key = preg_replace('/[^A-Za-z0-9\-]/', '', $this->input->post('key'));
      $data['results'] = $this->find_model->find_student($this->input->post('find_by'),$key);
      $data['searched'] = TRUE;
    }
    $data['theme_option'] = $this->theme_model->get_theme_data();
    $data['main_content'] = 'find_student';
    $this->load->view('template',$data);
		
	}

}

/* End of file search.php */
/* Location: ./application/modules/pages/controllers/search.php */