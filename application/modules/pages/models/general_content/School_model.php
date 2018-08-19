<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class School_model extends CI_Model {

  public function add_school() {
    $data['school_name'] = strtoupper(trim_post('school_name'));
    $data['school_address'] = strtoupper(trim_post('school_address'));
    return $this->db->insert('school', $data);
  }

  public function get_school() {
    $q = $this->db->get('school');
    if ($q->num_rows() > 0) {
      foreach ($q->result() as $row) {
        $data[] = $row;
      }
      return $data;
    }
    return NULL;
  }

  public function delete_school($id) {
    $this->db->where('school_id', $id);
    return $this->db->delete('school');
  }

  public function update_school($id) {
    $data['school_name'] = strtoupper(trim_post('school_name'));
    $data['school_address'] = strtoupper(trim_post('school_address'));
    $this->db->where('school_id', $id);
    return $this->db->update('school', $data);
  }

  public function edit_school($id) {
    $this->db->where('school_id', $id);
    $q = $this->db->get('school');
    if ($q->num_rows() == 1) {

      return $q->row();
    }
    return NULL;
  }

}
