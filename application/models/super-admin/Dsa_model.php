<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Dsa_model extends CI_Model {
    public function CountDsaList($keyword,$date_range,$partnerpermission){
		$this->db->where('user_type','DSA');
		if(!empty($date_range)){
			$date=explode(' - ',$date_range);
			$from_date=$date[0];
			$to_date=end($date);
			$this->db->where(['DATE('.TBL_USERS.'.created_at)>='=>date('Y-m-d',strtotime($from_date)),'DATE('.TBL_USERS.'.created_at)<='=>date('Y-m-d',strtotime($to_date))]);
		}
		if(!empty($partnerpermission)){
			$this->db->where_in('user_id',$partnerpermission);
		}
		if(!empty($keyword)){
		    $this->db->group_start();
		        $this->db->like('full_name',$keyword);
		        $this->db->or_like('company_name',$keyword);
		        $this->db->or_like('email',$keyword);
		        $this->db->or_like('mobile_number',$keyword);
		        $this->db->or_like('website',$keyword);
				$this->db->or_like('gst_number',$keyword);
				$this->db->or_like('file_id',$keyword);
		    $this->db->group_end();
		}
		return $this->db->count_all_results(TBL_USERS);
	}
     public function DsaList($limit,$offset,$keyword,$date_range,$partnerpermission){
        $this->db->select('*');
        $this->db->from(TBL_USERS);
	    $this->db->where('user_type','DSA');
		if(!empty($date_range)){
			$date=explode(' - ',$date_range);
			$from_date=$date[0];
			$to_date=end($date);
			$this->db->where(['DATE('.TBL_USERS.'.created_at)>='=>date('Y-m-d',strtotime($from_date)),'DATE('.TBL_USERS.'.created_at)<='=>date('Y-m-d',strtotime($to_date))]);
		}
		if(!empty($partnerpermission)){
			$this->db->where_in('user_id',$partnerpermission);
		}
		if(!empty($keyword)){
		    $this->db->group_start();
		        $this->db->like('full_name',$keyword);
		        $this->db->or_like('company_name',$keyword);
		        $this->db->or_like('email',$keyword);
		        $this->db->or_like('mobile_number',$keyword);
		        $this->db->or_like('website',$keyword);
				$this->db->or_like('gst_number',$keyword);
				$this->db->or_like('file_id',$keyword);
		    $this->db->group_end();
		}
		$this->db->limit($limit,$offset);	
		return $this->db->get()->result();
	}
}