<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		check_access();
	}

	public function index()
	{

    modules::run('dashboard/user_log/log');
    $data['change_pass']=$this->session->userdata('smis_reset_pass');
    

    $data['styles'] = array(
          site_url('assets')."/global/css/styles.css",
      );
      $data['script']="
                                             
                    ";
      if($this->session->userdata('smis_reset_pass'))
      {
        $data['ajax_script']=array('0'=>"$('#initial_reset').trigger('click');" );
      }   

      $data['addons']=array(
      ); 
    $user_type=$this->session->userdata("smis_role");
   
    $t_date = date('Y-m-d');
    $data['theme_option'] = $this->theme_model->get_theme_data();
    $data['main_content'] = 'admin_home';
		$this->load->view('template',$data);
	}

  public function find_menu()
  {

    $data['ajax_script']=array(
      '0'=>"
          $('#find_menu').keyup(function(){
            var txt = $(this).val();
            if(txt.length >= 3)
            {
               $.post('".site_url('theme_option/home/menu_list')."', {option: txt})
              .done(function(result) {
                   $('#menu_list').html(result);
                 //alert(result);
              })
              .fail(function() {
                 console.log('error');
              });
             // alert(txt);
            }
            else
            {
              $('#menu_list').html('');
            }
          });
        "
        );

    $data['main_content']='find_menu';
    $data['theme_option']=$this->theme_model->get_theme_data();
    
    $this->load->view('template',$data);
  }

  public function menu_list()
  {

    $this->load->model('manage_menu_model');
    $option=$this->input->post('option');
    $data['result']=$this->manage_menu_model->menu_list($option);
    $this->load->view('theme_option/menu_list',$data);
  }

  public function access_control($value='')
  {
    $this->load->model('user_account_model');
    $data['styles'] = array(
          site_url('assets')."/global/css/styles.css",
      );
      $data['script']="
                         $('#ticker').tickerme(
                         {
                          fade_speed: 1000,
                          duration: 10000,
                         });
                    ";
    
    $user_type=$this->session->userdata("smis_role");

      $data['styles'] = array(
          site_url('assets') . "/admin/pages/css/profile.css",
          site_url('assets')."/global/css/styles.css",
          site_url('assets') . "/admin/pages/css/tasks.css",
      );
      $data['results']=$this->user_account_model->get_block_list($this->session->userdata('smis_profile_id'));
      $data['main_content']='access_control';
 
   
    $data['theme_option']=$this->theme_model->get_theme_data();
    
    $this->load->view('template',$data);
  }

  public function allow_ip($id)
  {
    $this->load->model('user_account_model');
    $result = $this->user_account_model->allow_ip($id);
    if ($result) {
      $this->session->set_flashdata('error', FALSE);
      $this->session->set_flashdata('error_msg', 'Ip Unblocked Succesfully');
    } else {
      $this->session->set_flashdata('error', TRUE);
      $this->session->set_flashdata('error_msg', 'Error occured while Unblocking Ip');
    }
    redirect(site_url("theme_option/home/access_control"), 'refresh');
  }

  public function site_map()
  {
    $data['main_content']='site_map';
    $data['theme_option']=$this->theme_model->get_theme_data();
    $this->load->view('template',$data);
  }
}

/* End of file test.php */
/* Location: ./application/controllers/test.php */