<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manage_menu_model extends CI_Model {

	public function add_menu_list($menu)
	{
		$data['title']=ucwords($this->input->post('mtitle'));
		$data['link']=$this->input->post('mlink');
		$data['access']=serialize($this->input->post('access'));
		$data['icon']=$this->input->post('icon');
		if(!$this->db->insert('menu_links',$data))
		{
			$this->session->set_flashdata('error', TRUE);
			$this->session->set_flashdata('error_msg', 'Adding Menu List Failed');
		}
		else
		{
			$id=$this->db->insert_id();
			$ar = json_decode($menu);

			$object = new stdClass();
			$object->id = "$id";
			array_push($ar,$object);	
			$menu_arr=json_encode($ar);

			if(!$this->save_menu($menu_arr))
			{
				$this->session->set_flashdata('error', TRUE);
				$this->session->set_flashdata('alert_msg', 'Adding Menu Failed');
			}
			else
			{				
				$this->session->set_flashdata('error', FALSE);
				$this->session->set_flashdata('alert_msg', 'Menu List Succesfully Added!!');
			}

		}
	}

	public function save_menu($value)
	{
			$mdata['menu']=$value;
			$this->db->where('id',1);
			if($this->db->update('menu',$mdata))
			{
				$this->update_menu_list($value);
				return TRUE;
			}
		return FALSE;
	}

	public function edit_menu($id)
	{
		$this->db->where('id',$id);
		$q=$this->db->get('menu_links');
		
		if($q->num_rows() > 0){
			return $q->row();
		}
		return NULL;
	}

	public function update_menu($id)
	{
		$data['title']=$this->input->post('mtitle');
		$data['link']=$this->input->post('mlink');
		$data['access']=serialize($this->input->post('access'));
		$data['icon']=$this->input->post('icon');
		$this->db->where('id',$id);
		return $this->db->update('menu_links',$data);
	}

	public function get_user_type()
	{
		$q=$this->db->get('roles');
		
		if($q->num_rows() > 0){
			foreach ($q->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return NULL;
	}

	public function update_menu_list($menus)			// to updata the links form menu_links table 
	{
		if($menus!=NULL)
		{
			$ar = json_decode($menus);

			foreach($ar as $menu)
			{
				$mlist[]= $menu->id;
				if(isset($menu->children))
				{
					
					foreach($menu->children as $submenu1)
					{
						$mlist[]=$submenu1->id;
						if(isset($submenu1->children))
						{
							foreach($submenu1->children as $submenu2)
							{
								$mlist[]=$submenu2->id;
								if(isset($submenu2->children))
								{
									foreach($submenu2->children as $submenu3)
									{
										$mlist[]=$submenu3->id;
										if(isset($submenu3->children))
										{
											foreach($submenu3->children as $submenu4)
											{
												$mlist[]=$submenu4->id;
											}
										}
									}
								}
							}
						}
					}
				}
			}

			$q=$this->db->get('menu_links');	
			if($q->num_rows() > 0)
			{
				foreach ($q->result() as $row) {
					if(!in_array($row->id,$mlist))
					{
						$this->db->where('id',$row->id);
						$this->db->delete('menu_links');
					}
				}
			}
		}
	}

	public function menu_list($option)
	{
		$this->db->like('title',$option);
		if($this->session->userdata("smis_username")=='satishm')
		{
			$this->db->or_like('link',$option);
		}
		$q=$this->db->get('menu_links');
		if($q->num_rows() > 0){
			$data=array();
			foreach ($q->result() as $row) {
				$users=unserialize($row->access);
				if(in_array($this->session->userdata("smis_usertype_id"),$users) && $row->link!='#')
				{
					$data[] = $row;
				}
				else if($this->session->userdata("smis_usertype_id")==1 && $row->link!='#')
				{
					$data[] = $row;
				}
			}
			return $data;
		}
		return NULL;
	}
}

/* End of file manage_menu.php */
/* Location: ./application/modules/pages/models/manage_menu.php */