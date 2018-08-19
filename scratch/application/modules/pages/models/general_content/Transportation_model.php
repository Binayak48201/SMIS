<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Transportation_model extends CI_Model {

	public function transportation_list()
	{
		$results = $this->db->get('transport');
		if ($results->num_rows() > 0) 
		{
      foreach ($results->result() as $row) 
      {
        $data[] = $row;
      }
      return $data;
    }
    return NULL;
	}
	
	public function add()
	{
		$data['bus_name'] = trim_post('bus_name');
		$data['bus_route'] = trim_post('bus_route');
		return $this->db->insert('transport', $data);
	}

	public function update()
	{
		$bus_id = trim_post('bus_id');
		$data['bus_name'] = trim_post('bus_name');
		$data['bus_route'] = trim_post('bus_route');
		$this->db->where('bus_id', $bus_id);
		return $this->db->update('transport', $data);
	}

	public function delete($id)
	{
		$this->db->where('bus_id', $id);
		return $this->db->delete('transport');
	}

}

/* End of file Transportation_model.php */
/* Location: ./application/modules/pages/models/general_content/Transportation_model.php */