<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User_model extends CI_Model {
    public function CountUserList($keyword){
		$this->db->select(TBL_USERS.'.user_id,'.TBL_PROFILE_ASSIGN.'.assign_id');
		$this->db->from(TBL_PROFILE_ASSIGN);
		$this->db->join(TBL_USERS,TBL_USERS.'.user_id='.TBL_PROFILE_ASSIGN.'.user_id','INNER');
		if(!empty($keyword)){
		    $this->db->group_start();
                $this->db->like(TBL_USERS.'.full_name',$keyword);
                $this->db->or_like(TBL_USERS.'.email',$keyword);
                $this->db->or_like(TBL_USERS.'.mobile_number',$keyword);
                $this->db->or_like(TBL_USERS.'.file_id',$keyword);
		    $this->db->group_end();
		}
		return $this->db->count_all_results();
	}
     public function UserList($limit,$offset,$keyword){
        $this->db->select(TBL_USERS.'.*,'.TBL_PROFILE_ASSIGN.'.assign_id');
		$this->db->from(TBL_PROFILE_ASSIGN);
		$this->db->join(TBL_USERS,TBL_USERS.'.user_id='.TBL_PROFILE_ASSIGN.'.user_id','INNER');
		if(!empty($keyword)){
		    $this->db->group_start();
				$this->db->like(TBL_USERS.'.full_name',$keyword);
				$this->db->or_like(TBL_USERS.'.email',$keyword);
				$this->db->or_like(TBL_USERS.'.mobile_number',$keyword);
				$this->db->or_like(TBL_USERS.'.file_id',$keyword);
		    $this->db->group_end();
		}
		$this->db->limit($limit,$offset);	
		return $this->db->get()->result();
	}
	public function GetFileId(){
		$this->db->select('*');
		$this->db->from(TBL_USERS);
		$this->db->group_start();
		$this->db->where(['user_type'=>'USERS']);
		$this->db->or_where(['user_type'=>'SUPER-ADMIN']);
		$this->db->group_end();
		$this->db->where('file_id!=',null);
		$this->db->order_by('user_id','DESC');
		return $this->db->get()->row();
	}
}