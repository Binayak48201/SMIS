<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class School extends MX_Controller {

  public function __construct() {
    parent::__construct();
    modules::run('dashboard/user_log/log');
    check_access(array('su_admin','admin'));  
    
    $this->load->model('general_content/school_model');
  }

  public function index() {
    $data['theme_option'] = $this->theme_model->get_theme_data();

    $data['addons'] = array(
        site_url('assets') . "/admin/pages/scripts/ui-nestable.js",
        site_url('assets') . "/global/plugins/jquery-nestable/jquery.nestable.js",
        site_url('assets') . "/global/plugins/datatables/media/js/jquery.dataTables.min.js",
        site_url('assets') . "/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js",
        site_url('assets') . "/admin/pages/scripts/table-managed.js"
    );
    /*
      required js plugins Functions to run script for the page
     */
    $data['addons_load'] = array(
    );
    $data['script'] = "
                        $('.simple_table').DataTable();
                    ";
    $data['results'] = $this->school_model->get_school();
    $data['main_content'] = 'general_content/school';
    $this->load->view('template', $data);
  }

  public function add_school() {
    if ($this->input->post('submit') != NULL && $this->input->post('submit') == 'SUBMIT') {
      $result = $this->school_model->add_school();
      if ($result) {
        $this->session->set_flashdata('error', FALSE);
        $this->session->set_flashdata('alert_msg', 'Succesfully Added School');
      } else {
        $this->session->set_flashdata('error', TRUE);
        $this->session->set_flashdata('alert_msg', 'ERROR Occured while Adding School');
      }
    }

    redirect(site_url("pages/general_content/school"), 'refresh');
  }

  public function delete_school($id) {
    $result = $this->school_model->delete_school($id);
    if ($result) {
      $this->session->set_flashdata('error', FALSE);
      $this->session->set_flashdata('alert_msg', 'Succesfully Deleted School');
    } else {
      $this->session->set_flashdata('error', TRUE);
      $this->session->set_flashdata('alert_msg', 'Error!! School Not Deleted');
    }
    redirect(site_url("pages/general_content/school"), 'refresh');
  }

  public function edit_school($id) {
    $data['theme_option'] = $this->theme_model->get_theme_data();
    /*
      required js plugins Functions to run script for the page
     */
    $data['results'] = $this->school_model->edit_school($id);
    $data['main_content'] = 'general_content/edit_school';
    $this->load->view('template', $data);
  }

  function update_school($id) {
    $result = $this->school_model->update_school($id);
    if ($result) {
      $this->session->set_flashdata('error', FALSE);
      $this->session->set_flashdata('alert_msg', 'School Updated Succesfully');
    } else {
      $this->session->set_flashdata('error', TRUE);
      $this->session->set_flashdata('alert_msg', 'Error!! Updating School');
    }
    redirect(site_url("pages/general_content/school"), 'refresh');
  }

}
