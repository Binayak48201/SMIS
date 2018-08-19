<?php
	class Notification_model extends CI_Model
	{
		
    public function add_notification()
		{
		$data['usertype_id']=serialize($this->input->post('usertype'));
		$data['notification_title']=$this->input->post('notification_title');
		$data['msg']=$this->input->post('msg');
		$data['added_by']=$this->session->userdata("smis_username");
		$data['by_user_type']=$this->session->userdata("smis_usertype_id");
		$ins=$this->db->insert('notification', $data);
		return $ins;
		}
		public function show_notification($usertype_id)
		{
			$this->db->select('notification_title,msg,usertype_id,notification_id');
			$this->db->order_by('notification_id','desc');
			$q=$this->db->get('notification');
			$data=array();
			if($q->num_rows() > 0) 
			{
				foreach ($q->result() as $row) 
				{
					$ids=unserialize($row->usertype_id);
						if(in_array($usertype_id, $ids))
						{
							$data[] = $row;

						}
						
					}
					return $data;
			}
			return NULL;
		}
		public function show_all()
		{
			$this->db->select('notification_title,msg,usertype_id,notification_id');
			$this->db->order_by('notification_id','desc');
			$query=$this->db->get('notification');
			if($query->num_rows() > 0) {
			foreach ($query->result() as $row) {				
					$data[] = $row;			
			}
			return $data;
			}
			return NULL;
		}
		public function edit($notification_id) 
		{
			$this->db->where('notification_id',$notification_id);
			$q=$this->db->get('notification');		
			if($q->num_rows()>0)
			{
				return $q->row();
			}
			return NULL;
		}
		public function update($id) {
			$data['usertype_id']=serialize($this->input->post('usertype'));
			$data['notification_title']=$this->input->post('notification_title');
			$data['msg']=$this->input->post('msg');
			$data['by_user_type']=$this->session->userdata("usertype_id");
			$this->db->where('notification_id', $id);
			return $this->db->update('notification n', $data);
		}
		public function delete($id)
		{
			$this->db->where('notification_id', $id);
			return $this->db->delete('notification');
		}
}