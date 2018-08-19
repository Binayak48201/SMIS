<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bug extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
    modules::run('dashboard/user_log/log');
    if(!check_access('su_admin'))     
		{
			redirect(site_url('login'),'refresh');
			exit;
		}

		$this->load->model('bug_model');
	}

	public function report_bug()
	{
    $data['main_content']='report_bug';
		$data['theme_option']=$this->theme_model->get_theme_data();
		$data['addons'] = array(
        site_url('assets')."/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js",                //required to load custom functions
    );
    $data['styles'] = array(
        site_url('assets')."/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css",               //requires for file input in a form 
    );
    $data['addons_load'] = array(
    );
    $data['ajax_script']=array(
			"0" => "$('.bug_img').click(function(){
		     var src=$(this).attr('data-src');
		     $('#pop-img').attr('src',src);
  			});"
			);	
    if($this->input->post('submit')!=NULL && $this->input->post('submit')=='SUBMIT')
    {
    	$bug_img='';
    	if(isset($_FILES['bug_img']) && is_uploaded_file($_FILES['bug_img']['tmp_name']))
	    {
	    	
	      $stat=$this->general->upload('bug_img','gif|jpg|png','','bug'); // form->name, ext, file name, folder
	      if($stat['status']==TRUE)
	      {
	        $bug_img=$stat['result'];
	      }
	      else
	      {
	        $this->session->set_flashdata('error', TRUE);
	        $this->session->set_flashdata('error_msg', $stat['result']);
	        redirect(site_url("pages/bug/report_bug"), 'refresh');
	      }
	    }
    	$res=$this->bug_model->insert_bug($bug_img);
      if($res)
      {
      	$this->session->set_flashdata('error', FALSE);
        $this->session->set_flashdata('error_msg', 'Succesfully Reported Bug');
      }
      else
      {
				$this->session->set_flashdata('error', TRUE);
        $this->session->set_flashdata('error_msg', 'ERROR Occured while Reporthing Bug');
      }
      redirect(site_url("pages/bug/report_bug"), 'refresh');
    }
    $data['results']=$this->bug_model->list_bug($this->session->userdata("smis_profile_id"));
		$this->load->view('template',$data);
	}

	public function list_bug()
	{
		$data['theme_option']=$this->theme_model->get_theme_data();
		$data['addons'] = array(
        site_url('assets')."/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js",                //required to load custom functions
    );
    $data['styles'] = array(
        site_url('assets')."/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css",               //requires for file input in a form 
    );
    $data['addons_load'] = array(
    );
   	$data['ajax_script']=array(
			"0" => "$('.bug_img').click(function(){
		     var src=$(this).attr('data-src');
		     $('#pop-img').attr('src',src);
  			});",
  		"1" => "$('#stat_up').click(function(){
        var id=$(this).attr('data-id');
         $.ajax({
             url: '" . site_url('pages/bug/bug_stat_toggle/') . "',
             type: 'POST',
             data: {option: id}
          })
           .done(function(result) {
              alert('updated');
          })
          .fail(function() {
             console.log('error');
          })
        
        });",
        "2" => "$( '.remark' ).dblclick(function() {
            $(this).removeAttr('readonly');
            
          });
  			",
        "3" => "$( '.remark' ).focusout(function() {
          if(!$(this).attr('readonly'))
          {
            var dis=$(this);
            var id=$(this).attr('data-id');
            var val=$(this).val();
            $.ajax({
               url: '" . site_url('pages/bug/add_bug_remark/') . "',
               type: 'POST',
               data: {option: val,id:id}
            })
             .done(function(result) {
                alert('remarked');
                dis.attr('readonly','readonly');
            })
            .fail(function() {
               console.log('error');
            })
          }
          });
        "
			);	
     $data['results']=$this->bug_model->list_bug();
		$data['main_content']='list_bug';
    $this->load->view('template',$data);
	}

	public function bug_stat_toggle()
	{
		return $this->bug_model->bug_stat_toggle();
	}

  public function add_bug_remark()
  {
    return $this->bug_model->add_bug_remark();
  }
}

/* End of file bug.php */
/* Location: ./application/modules/pages/controllers/bug.php */