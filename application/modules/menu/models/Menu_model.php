<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_model extends CI_Model {

	public function get_menu()
		{
			$q=$this->db->get('menu');
		
			if($q->num_rows() > 0){
				
				return $q->row();
			}
			return NULL;
		}

		public function get_menu_list()
		{
			$q=$this->db->get('menu_links');
		
			if($q->num_rows() > 0){
				foreach ($q->result() as $row) {
					$data[$row->id]['id'] = $row->id;
					$data[$row->id]['title'] = $row->title;
					$data[$row->id]['link'] = $row->link;
					$data[$row->id]['access'] = $row->access;
					$data[$row->id]['icon'] = $row->icon;
				}
				return $data;
			}
			return NULL;
		}

		function is_allowed($opt='')
		{
			//exit(uri_string());
			$this->db->where('link',uri_string());
			$q=$this->db->get('menu_links');

			if($q->num_rows() > 0) // checks access for link that are in table menu ie statid pre-defined menu
			{	
				$data=$q->row();
				if(!empty(unserialize($data->access)) && !in_array($this->session->userdata('smis_usertype_id'), unserialize($data->access)))
				{
					return FALSE;
				}
			}
			else // checks access for link that are not in table menu ie dynamic menu
			{		
				if($opt!=NULL)
				{
					if(!$this->general->is_admin($opt))
					{
						return FALSE;
					}
				}
			}
			return TRUE;
		}

}

/* End of file menu_model.php */
/* Location: ./application/modules/menu/models/menu_model.php */